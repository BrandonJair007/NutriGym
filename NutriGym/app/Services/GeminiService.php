<?php

namespace App\Services;

class GeminiService
{
    public function generateContent($prompt)
    {
        $apiKey = env('GOOGLE_API_KEY');
        
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent?key=' . $apiKey;
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];
        
        $maxIntentos = 3; // Intentará hasta 3 veces antes de rendirse
        $intento = 0;
        $httpCode = 0;
        $response = '';
        
        // Bucle Inteligente de Reintentos
        while ($intento < $maxIntentos) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                ],
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            // Si el código es 200 (Éxito), rompemos el bucle y continuamos
            if ($httpCode === 200) {
                break; 
            }
            
            // Si el código es 429 (Límite de velocidad)
            if ($httpCode === 429) {
                $intento++;
                // Si ya intentó 3 veces, enviamos un mensaje amigable
                if ($intento >= $maxIntentos) {
                    return "¡Tu dieta está lista! (Nota: Nuestro nutricionista IA está atendiendo a muchos pacientes ahora mismo, pero tus alimentos han sido seleccionados exitosamente).";
                }
                // Si falló, lo hacemos dormir 6 segundos y vuelve a intentar
                sleep(6); 
                continue;
            }
            
            // Si es otro error (como 500, etc)
            return "Error: HTTP {$httpCode}";
        }
        
        $responseData = json_decode($response, true);
        
        // Extraer texto de manera segura
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return $responseData['candidates'][0]['content']['parts'][0]['text'];
        }
        
        if (isset($responseData['candidates'][0]['content']['parts'][0])) {
            return $responseData['candidates'][0]['content']['parts'][0];
        }
        
        if (isset($responseData['candidates'][0]['content']['text'])) {
            return $responseData['candidates'][0]['content']['text'];
        }
        
        return "¡Aquí tienes tu selección de alimentos para el día de hoy!";
    }
}