<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pacientes;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;

class ContactoController extends Controller
{
    public function create()
    {
        return view('contacto');
    }

public function store(Request $request)
{

    try {
    $token='EAAyZAgb9x3jcBOwspMdYUTrUzUf6KZAAFIWtDIqZBDY88ZCZA0x90O1p1w3mir6kzf9736JKRwXpYZBZBhGkIixzgL9CSe433c5wHNMV0JUYnwcmeH65mFqX0cG6ZAT7jMLjDQgU5aZAEc7DbWx0HNbWLM02MnlA29plQyjdIZCNFhXGpGtZAxNFP4du1fbIZBwtnMmr';

    
    $phoneId =  '245840231949474';
    $version = 'v18.0';
    $phoneNumber = '573187944271';
    $payload =[
        'messaging_product' => 'WHATSAPP',
        'to' => $phoneNumber,
        'type' => 'template',
        'template' => [
            'name' => 'bienvenido',
            'language' => [
                'code' => 'en_US'
            ]
        ]
    ];
    $message = Http::withToken($token)->post('https://graph.facebook.com/'. $version . '/'. $phoneId .'/messages', $payload)->throw()->json();

    return response()->json($message);

    } catch (Exeption $e) {
        return response()->json($e);
    }   
}
}