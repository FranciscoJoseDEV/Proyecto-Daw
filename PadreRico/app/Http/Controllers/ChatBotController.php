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

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Referer' => 'http://18.205.80.205:8000/',
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

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'API error',
                    'details' => $response->json()
                ], $response->status());
            }
            //que cojone
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
