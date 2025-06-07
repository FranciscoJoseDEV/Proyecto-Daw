<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    public function ask(Request $request)
    {
        $apiKey = env('OPENROUTER_API_KEY');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'HTTP-Referer' => 'https://www.sitename.com',
            'X-Title' => 'SiteName',
            'Content-Type' => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'deepseek/deepseek-r1:free',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Actúa como un gestor de finanzas profesional y no respondas nada que no tenga que ver con las finanzas personales.Ademas habla como hablaria un padre a su hijo y tu nombre es Padre Rico'
                ],
                [
                    'role' => 'user',
                    'content' => $request->input('message'),
                ]
            ],
        ]);
        if ($response->failed()) {
            return response()->json([
                'error' => 'API error',
                'details' => $response->body()
            ], 500);
        }
        return $response->json();
    }
}
