<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsignacionMenu;
use App\Models\MenuAlimento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class MenuController extends Controller
{
    //
    public function calcularGET($usuarioId)
    {
        try {
            // Obtener el último progreso del usuario donde está el TMB
            $progreso = DB::table('progreso')
                ->join('medidas', 'progreso.id_medida', '=', 'medidas.id')
                ->where('medidas.id_usuario', $usuarioId)
                ->select('progreso.*')
                ->latest('progreso.fecha')
                ->first();

            if (!$progreso) {
                return [
                    'success' => false,
                    'message' => 'No se encontró progreso con TMB calculado'
                ];
            }

            // GET 
            $get = $progreso->tmb * 1.55;

            return [
                'success' => true,
                'get' => round($get, 2),
                'tmb' => $progreso->tmb,
                'factor_actividad' => 1.55,
                'nivel_actividad' => 'Moderado',
                'fecha_calculo' => $progreso->fecha
            ];

        } catch (\Exception $e) {
            return [
                'success' => false, 
                'message' => 'Error calculando GET: ' . $e->getMessage()
            ];
        }
    }

    public function pruebaGemini()
    {
        try {
            $geminiService = new \App\Services\GeminiService();
            
            $prompt = "Genera una frase motivacional corta sobre nutrición y ejercicio (máximo 10 palabras)";
            
            $respuesta = $geminiService->generateContent($prompt);

            return response()->json([
                'success' => true,
                'mensaje' => 'Gemini API funcionando correctamente',
                'respuesta' => $respuesta
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => '❌ Error con Gemini API: ' . $e->getMessage()
            ], 500);
        }
    }

   // Generación de Dieta Optimizado con Manejo de Límite (Error 429)
   public function generarDieta()
    {
        try {
            if (!auth()->check()) {
                if (request()->ajax()) return response()->json(['success' => false, 'error' => 'Usuario no autenticado'], 401);
                return redirect()->route('login');
            }
            $usuarioId = auth()->id();

            $usuario = DB::table('usuarios')->where('id', $usuarioId)->select('id', 'nombre', 'email')->first();
            if (!$usuario) return response()->json(['success' => false, 'mensaje' => 'Usuario no encontrado'], 404);

            $alimentosCompletos = DB::table('alimentos')->select('id', 'nombre', 'calorias')->get();
            
            $preferencias = DB::table('asignacion_preferencia')
                ->join('preferencias', 'asignacion_preferencia.id_preferencia', '=', 'preferencias.id')
                ->where('asignacion_preferencia.id_usuario', $usuarioId)->select('preferencias.descripcion')->get();

            $objetivos = DB::table('asignacion_objetivo')
                ->join('objetivos', 'asignacion_objetivo.id_objetivo', '=', 'objetivos.id')
                ->where('asignacion_objetivo.id_usuario', $usuarioId)->select('objetivos.descripcion')->get();

            $usoIA = false; // Variable para saber si ya gastamos nuestra petición a Google

            // 1. FILTRO DE ALIMENTOS (Solo gastamos la IA si hay preferencias)
            if ($preferencias->isNotEmpty()) {
                $alimentosSeleccionados = $this->filtrarAlimentosConIA($alimentosCompletos, $preferencias, 9);
                $usoIA = true; 
            } else {
                // Si no hay preferencias, PHP elige rápido y no gastamos la IA
                $alimentosSeleccionados = $alimentosCompletos->count() <= 9 
                    ? $alimentosCompletos 
                    : $alimentosCompletos->random(9);
            }
        
            $alimentosPorComida = $this->dividirAlimentosPorComidas($alimentosSeleccionados);
            $caloriasPorComida = $this->calcularCaloriasPorComida($alimentosPorComida);
            $caloriasTotales = array_sum($caloriasPorComida);

            $resultadoGET = $this->calcularGET($usuarioId);
            $getValor = $resultadoGET['success'] ? $resultadoGET['get'] : 0;
            
            $caloriasRecomendadas = $this->ajustarCaloriasPorObjetivo($getValor, $objetivos);
            $diferenciaCalorias = $caloriasRecomendadas - $caloriasTotales;

            // 2. MENSAJE MOTIVACIONAL
            if ($usoIA) {
                // Como ya usamos a Gemini para filtrar la comida, usamos el banco de frases locales para evitar el Error 429
                $frases = [
                    "¡Tu dieta está lista, {$usuario->nombre}! Hemos organizado cuidadosamente tus alimentos. ¡Mucho éxito!",
                    "¡Aquí tienes tu plan, {$usuario->nombre}! Alimentos 100% perfectos para tus preferencias.",
                    "¡A darle con todo, {$usuario->nombre}! Este menú te ayudará a alcanzar tus metas de salud de esta semana."
                ];
                $mensajeGemini = $frases[array_rand($frases)];
            } else {
                // Si PHP eligió la comida, Gemini está libre para escribir el mensaje
                $geminiService = new \App\Services\GeminiService();
                $promptMensaje = "Actúa como un nutricionista experto. Escribe un mensaje motivacional muy corto (máx 20 palabras) para tu paciente {$usuario->nombre}, animándolo a cumplir su nueva dieta. No uses listas.";
                $mensajeGemini = $geminiService->generateContent($promptMensaje);
                
                // Si por alguna razón de red falla, usamos el salvavidas
                if (str_contains($mensajeGemini, 'Error') || str_contains($mensajeGemini, '⚠️')) {
                    $mensajeGemini = "¡Tu dieta está lista, {$usuario->nombre}! Hemos organizado cuidadosamente tus alimentos. ¡Mucho éxito!";
                }
            }

            return response()->json([
                'mensaje_personalizado' => $mensajeGemini,
                'alimentos_por_comida' => [
                    'desayuno' => $alimentosPorComida['desayuno']->map(fn($a) => ['id' => $a->id, 'nombre' => $a->nombre, 'calorias' => $a->calorias]),
                    'almuerzo' => $alimentosPorComida['almuerzo']->map(fn($a) => ['id' => $a->id, 'nombre' => $a->nombre, 'calorias' => $a->calorias]),
                    'cena' => $alimentosPorComida['cena']->map(fn($a) => ['id' => $a->id, 'nombre' => $a->nombre, 'calorias' => $a->calorias])
                ],
                'calorias_por_comida' => $caloriasPorComida,
                'calorias_totales' => $caloriasTotales,
                'GET' => $getValor,
                'objetivos_usuario' => $objetivos->pluck('descripcion'),
                'calorias_recomendadas' => $caloriasRecomendadas,
                'diferencia_calorias' => $diferenciaCalorias,
                'estado_calorias' => $this->evaluarEstadoCalorias($diferenciaCalorias)
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'mensaje' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // AJUSTAR CALORÍAS SEGÚN OBJETIVOS
    private function ajustarCaloriasPorObjetivo($getBase, $objetivos)
    {
        $caloriasAjustadas = $getBase;
        
        foreach ($objetivos as $objetivo) {
            $descripcion = strtolower($objetivo->descripcion);
            
            if (strpos($descripcion, 'bajar') !== false || strpos($descripcion, 'perder') !== false || strpos($descripcion, 'reducir') !== false) {
                $caloriasAjustadas = $getBase * 0.80; 
            } elseif (strpos($descripcion, 'subir') !== false || strpos($descripcion, 'aumentar') !== false || strpos($descripcion, 'ganar') !== false) {
                $caloriasAjustadas = $getBase * 1.15; 
            } elseif (strpos($descripcion, 'mantener') !== false || strpos($descripcion, 'conservar') !== false) {
                $caloriasAjustadas = $getBase;
            } elseif (strpos($descripcion, 'definir') !== false || strpos($descripcion, 'tonificar') !== false || strpos($descripcion,'desarrollar') !== false) {
                $caloriasAjustadas = $getBase * 0.85; 
            }
        }
        
        return round($caloriasAjustadas);
    }

    // EVALUAR ESTADO DE CALORÍAS
    private function evaluarEstadoCalorias($diferencia)
    {
        if ($diferencia > 200) {
            return 'Por debajo del objetivo - considerar aumentar calorías';
        } elseif ($diferencia < -200) {
            return 'Por encima del objetivo - considerar reducir calorías';
        } else {
            return 'Dentro del rango objetivo';
        }
    }

    // DIVIDIR ALIMENTOS POR COMIDAS
    private function dividirAlimentosPorComidas($alimentosSeleccionados)
    {
        $alimentosArray = $alimentosSeleccionados->shuffle()->values();
        $count = $alimentosArray->count();
        
        $porComida = floor($count / 3);
        
        return [
            'desayuno' => $alimentosArray->slice(0, $porComida),
            'almuerzo' => $alimentosArray->slice($porComida, $porComida),
            'cena' => $alimentosArray->slice($porComida * 2)
        ];
    }

    // CALCULAR CALORÍAS POR COMIDA
    private function calcularCaloriasPorComida($alimentosPorComida)
    {
        return [
            'desayuno' => $alimentosPorComida['desayuno']->sum('calorias'),
            'almuerzo' => $alimentosPorComida['almuerzo']->sum('calorias'),
            'cena' => $alimentosPorComida['cena']->sum('calorias')
        ];
    }

    // FILTRADO INTELIGENTE CON IA (Optimizado)
    private function filtrarAlimentosConIA($alimentos, $preferencias, $cantidad = 9)
    {
        // 🚀 OPTIMIZACIÓN GIGANTE: Si el usuario NO tiene preferencias de alergias/gustos,
        // no usamos la IA para filtrar. PHP elegirá aleatoriamente en 0.001 segundos.
        if ($preferencias->isEmpty()) {
            if ($alimentos->count() <= $cantidad) return $alimentos;
            return $alimentos->random($cantidad);
        }

        // Si SÍ hay preferencias, consultamos a la IA (Solo ocurre si es estrictamente necesario)
        $geminiService = new \App\Services\GeminiService();
        
        $listaAlimentos = $alimentos->pluck('nombre')->implode(', ');
        
        $promptFiltrado = "Selecciona EXACTAMENTE {$cantidad} alimentos de esta lista compatibles con: " . 
                        $preferencias->pluck('descripcion')->implode(', ') . 
                        "\n\nLista: {$listaAlimentos}\n\nResponde SOLO con los nombres separados por coma:";

        $respuestaIA = $geminiService->generateContent($promptFiltrado);
        
        \Log::info("IA filtró alimentos: " . $respuestaIA);
        
        return $this->procesarRespuestaFiltrado($respuestaIA, $alimentos, $cantidad);
    }

    // PROCESAR RESPUESTA DE IA
    private function procesarRespuestaFiltrado($respuestaIA, $alimentos, $cantidad)
    {
        // Limpiar y dividir la respuesta
        $nombresSeleccionados = array_map('trim', explode(',', $respuestaIA));
        
        $resultado = collect();
        
        foreach ($nombresSeleccionados as $nombreAlimento) {
            if (empty(trim($nombreAlimento))) continue;
            
            $alimentoEncontrado = $alimentos->first(function($alimento) use ($nombreAlimento) {
                return stripos($alimento->nombre, $nombreAlimento) !== false || 
                    stripos($nombreAlimento, $alimento->nombre) !== false;
            });
            
            if ($alimentoEncontrado && !$resultado->contains('id', $alimentoEncontrado->id)) {
                $resultado->push($alimentoEncontrado);
            }
            
            if ($resultado->count() >= $cantidad) {
                break;
            }
        }
        
        // Si la IA falló o no seleccionó suficientes, completar con aleatorios
        if ($resultado->count() < $cantidad) {
            $faltantes = $cantidad - $resultado->count();
            $alimentosRestantes = $alimentos->whereNotIn('id', $resultado->pluck('id'));
            
            if ($alimentosRestantes->count() >= $faltantes) {
                $resultado = $resultado->merge($alimentosRestantes->random($faltantes));
            } else {
                $resultado = $resultado->merge($alimentosRestantes);
            }
        }
        
        return $resultado;
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:desayuno,almuerzo,cena,otro',
            'calorias' =>'required|integer',
            'fecha_asignacion' => 'required|date',
            'alimentos' => 'required|array',
            'alimentos.*' => 'exists:alimentos,id'
        ]);

        DB::beginTransaction();

        try {
            $asignacion = AsignacionMenu::create([
                'id_usuario' => auth()->id(),
                'tipo' => $request->tipo,
                'calorias'=>$request->calorias,
                'fecha_asignacion' => $request->fecha_asignacion
            ]);

            $alimentosData = [];
            foreach ($request->alimentos as $idAlimento) {
                $alimentosData[] = [
                    'asignacion_menu_id' => $asignacion->id,
                    'id_alimento' => $idAlimento,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            MenuAlimento::insert($alimentosData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Menú asignado correctamente',
                'data' => [
                    'asignacion' => $asignacion,
                    'alimentos_count' => count($request->alimentos)
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al asignar el menú: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getMyMenus()
    {
        $menus = AsignacionMenu::with('alimentos.alimento')
            ->where('id_usuario', auth()->id())
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    public function getByUsuario($id)
    {
        $menus = AsignacionMenu::with('alimentos.alimento')
            ->where('id_usuario', $id)
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    public function toggleValidacion($id)
    {
        $menu = AsignacionMenu::findOrFail($id);
        
        $menu->validado = !$menu->validado;
        $menu->save();
        
        return response()->json([
            'success' => true,
            'menu' => $menu
        ]);
    }
}