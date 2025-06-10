<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    public function ask(Request $request)
    {
        $apiKey = env('OPENROUTER_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API key missing'], 500);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Referer' => 'http://98.82.138.75:8000',
            'X-Title' => 'Padre Rico',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'deepseek/deepseek-r1:free',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Actúa como un gestor de finanzas profesional y no respondas nada que no tenga que ver con las finanzas personales. Además, habla como hablaría un padre a su hijo y tu nombre es Padre Rico'
                ],
                [
                    'role' => 'user',
                    'content' => $request->input('message'),
                ]
            ],
        ]);

        if ($response->failed()) {
            // Intenta decodificar el cuerpo como JSON
            $json = json_decode($response->body(), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return response()->json($json, 500);
            } else {
                // Si no es JSON, devuelve un error genérico
                return response()->json([
                    'error' => 'Error inesperado del servidor de IA. Intenta más tarde.',
                    'details' => $response->body()
                ], 500);
            }
        }
        return $response->json();
    }
}
