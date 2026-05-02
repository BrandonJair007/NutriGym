<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RegistroUsuarioController;
use App\Http\Controllers\LoginUsuarioController;
use App\Http\Controllers\PreferenciaController;
use App\Http\Controllers\MedidaController;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlimentosController;
use App\Http\Controllers\BackUpController;
use App\Http\Controllers\NutriologoController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProgresoController;
use App\Http\Controllers\EntrenadorController;
use App\Models\Usuario;
use Illuminate\Auth\Events\Logout;

// ==========================================
// RUTAS DE ACCESO Y AUTENTICACIÓN
// ==========================================

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('usuario.login');
})->name('login');

Route::post('/login', [LoginUsuarioController::class, 'validacion'])
    ->name('login.store');

Route::get('/registrar_usuario', function () {
    return view('usuario.registrar_usuario');
})->name('registrar_usuario');

Route::post('/registrar_usuario', [RegistroUsuarioController::class, 'store'])
    ->name('registrar_usuario.store');

Route::get('logout', function () {
    return view('usuario.logout');
})->name('logout.confirm');

Route::post('logout', function () {
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('success', 'Sesión cerrada correctamente');
})->name('logout');

// ==========================================
// PERFIL Y MEDIDAS
// ==========================================

Route::get('/cuenta', [MedidaController::class, 'index'])->name('cuenta');
Route::post('/medidas', [MedidaController::class, 'store'])->name('medidas.store');
Route::put('/medidas/{medida}', [MedidaController::class, 'update'])->name('medidas.update');

// ==========================================
// DASHBOARD GENERAL
// ==========================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('usuario', function () {
    return view('ui_dashboard.usuario');
})->name('usuario');

// ==========================================
// PREFERENCIAS Y OBJETIVOS
// ==========================================

Route::get('preferencia', [ObjetivoController::class, 'select'])->name('preferencia');
Route::post('/guardar-objetivo', [ObjetivoController::class, 'guardarObjetivo'])->name('guardar.objetivo');
Route::post('/guardar-preferencia', [PreferenciaController::class, 'guardarPreferencia'])->name('guardar.preferencia');

Route::get('/preferencias', [PreferenciaController::class, 'index'])->name('preferencias.index');
Route::post('/preferencias/guardar', [PreferenciaController::class, 'guardarpreferencias'])->name('preferencias.guardar');
Route::get('/preferencias/seleccionados', [PreferenciaController::class, 'preferenciasSeleccionados'])->name('preferencias.seleccionados');
Route::delete('/preferencias/{id}/eliminar', [PreferenciaController::class, 'eliminarPreferencia'])->name('preferencias.eliminar');

Route::get('/objetivos', [ObjetivoController::class, 'index'])->name('objetivos.index');
Route::post('/objetivos/guardar', [ObjetivoController::class, 'guardarObjetivos'])->name('objetivos.guardar');
Route::get('/objetivos/seleccionados', [ObjetivoController::class, 'objetivosSeleccionados'])->name('objetivos.seleccionados');
Route::delete('/objetivos/{id}/eliminar', [ObjetivoController::class, 'eliminarObjetivo'])->name('objetivos.eliminar');

// ==========================================
// MENÚS Y DIETAS
// ==========================================

Route::get('/dashboard/generar-dieta', [MenuController::class, 'generarDieta']);
Route::post('/menus', [MenuController::class, 'store']);
Route::get('/menus/mis-menus', [MenuController::class, 'getMyMenus'])->middleware('auth');
Route::get('/mis-dietas', [MenuController::class, 'getMyMenus'])->name('dietas.mis-dietas');
Route::get('/menu/calcular-get/{usuarioId}', [MenuController::class, 'calcularGET']);

// ==========================================
// MÓDULO NUTRIÓLOGO
// ==========================================

Route::get('nutriologo', [NutriologoController::class, 'index'])->name('ui_dashboard.nutriologo');
Route::get('/usuario/{id}/dietas', [MenuController::class, 'getByUsuario'])->name('usuario.dietas');
Route::post('/menu/{id}/toggle-validacion', [MenuController::class, 'toggleValidacion']);
Route::get('/usuarios/{id}/objetivos', [NutriologoController::class, 'obtenerObjetivosUsuario'])->name('usuarios.objetivos');
Route::get('/usuarios/{id}/preferencias', [NutriologoController::class, 'obtenerPreferenciasUsuario'])->name('usuarios.preferencias');

// Alimentos
Route::get('alimentos', [AlimentosController::class, 'index'])->name('nutriologo.alimentos');
Route::put('alimentos/{id}', [AlimentosController::class, 'update'])->name('nutriologo.alimentos.update');
Route::post('alimentos', [AlimentosController::class, 'store'])->name('nutriologo.alimentos.store');
Route::delete('alimentos/{id}', [AlimentosController::class, 'destroy'])->name('nutriologo.alimentos.destroy');

// ==========================================
// MÓDULO ENTRENADOR
// ==========================================

Route::get('entrenador', [EntrenadorController::class, 'index'])->name('ui_dashboard.entrenador');
Route::get('/entrenador/medidas/{usuarioId}', [EntrenadorController::class, 'obtenerMedidasUsuario'])->name('entrenador.medidas.usuario');
Route::get('/entrenador/ultima-medida/{usuarioId}', [EntrenadorController::class, 'obtenerUltimaMedida'])->name('entrenador.ultima.medida');

// ==========================================
// PROGRESO Y BACKUP
// ==========================================

Route::get('/progreso/datos/{pacienteId?}', [ProgresoController::class, 'obtenerProgresoUsuario'])
    ->name('progreso.datos')
    ->middleware('auth');

Route::post('/backup/create', [BackupController::class, 'createBackup'])->name('backup.create');

// ==========================================
// RUTAS DEL ADMINISTRADOR (MODIFICADAS)
// ==========================================

// Vista principal del admin (Carga la tabla de usuarios y roles)
Route::get('admin', [AdminController::class, 'index'])->name('admin');

// Ruta para procesar la actualización del rol de un usuario
Route::put('/admin/usuarios/{id}/rol', [AdminController::class, 'actualizarRol'])->name('admin.actualizar_rol');

// Otras vistas de administración
Route::get('control', function () {
    return view('admin.control');
})->name('control');


// Vista principal del admin
Route::get('admin', [AdminController::class, 'index'])->name('admin');

// Ruta para procesar el cambio rápido de rol
Route::put('/admin/usuarios/{id}/rol', [AdminController::class, 'actualizarRol'])->name('admin.actualizar_rol');

// NUEVAS RUTAS CRUD
Route::post('/admin/usuarios', [AdminController::class, 'store'])->name('admin.usuarios.store'); // Crear
Route::put('/admin/usuarios/{id}', [AdminController::class, 'update'])->name('admin.usuarios.update'); // Editar
Route::delete('/admin/usuarios/{id}', [AdminController::class, 'destroy'])->name('admin.usuarios.destroy'); // Eliminar

// Otras vistas de administración
Route::get('control', function () {
    return view('admin.control');
})->name('control');


// ==========================================
// INTEGRACIÓN GEMINI AI
// ==========================================

Route::get('/dashboard/prueba-gemini', [MenuController::class, 'pruebaGemini']);
Route::get('/dashboard/debug-gemini', [MenuController::class, 'debugGeminiConfig']);
Route::get('/dashboard/prueba-gemini-usuario/{usuarioId}', [MenuController::class, 'pruebaGeminiUsuario']);
Route::get('/dashboard/generar-dieta/{usuarioId}', [MenuController::class, 'generarDieta']);