<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Mail\MiMailable;


class ResetPasswordController extends Controller
{

    public function show()
    {
        return view('reset-password');
    }
    public function reset(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'email' => 'required|email',
        'documento' => 'required',
    ]);

    // Obtener el correo electrónico y documento del formulario
    $email = $request->input('email');
    $documento = $request->input('documento');

    // Aquí debes enviar el correo electrónico, puedes usar la clase Mail de Laravel
    Mail::to($email)->send(new MiMailable($documento));

    // Puedes agregar un mensaje de éxito o redirigir a una página de confirmación
    return redirect('/')->with('success', 'Correo electrónico enviado con éxito');
}
}