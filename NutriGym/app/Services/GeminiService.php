<?php

namespace App\Services;

class GeminiService
{
    public function generateContent($prompt)
    {
        // 1. Obtener la clave API
        $apiKey = env('GOOGLE_API_KEY');
        
        // 2. Restauramos TU modelo original (gemini-2.0-flash-lite) que sí es compatible con tu API Key
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
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15, // Corta a los 15 segundos máximo
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        // Error de servidor local
        if ($curlError) {
            return "⚠️ Error de conexión en tu servidor local: " . $curlError;
        }
        
        $responseData = json_decode($response, true);

        // Éxito (200)
        if ($httpCode === 200 && isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return $responseData['candidates'][0]['content']['parts'][0]['text'];
        }
        
        // SI FALLA: Mostrará el error real
        if (isset($responseData['error']['message'])) {
            $mensajeError = $responseData['error']['message'];
            
            if ($httpCode === 429) {
                return "⚠️ Error 429: El nutricionista IA está muy ocupado. Espera unos segundos y vuelve a generar la dieta.";
            }
            
            return "⚠️ Error de Gemini ({$httpCode}): " . $mensajeError;
        }
        
        return "⚠️ Error Desconocido HTTP {$httpCode}";
    }
}