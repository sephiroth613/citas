@extends('layouts.app')

@section('content')
<form method="POST" action="{{ url('/reset-password') }}">
    @csrf

    <label for="email">Correo Electrónico:</label>
    <input type="email" name="email" required>

    <label for="documento">Documento:</label>
    <input type="text" name="documento" required>

    <button type="submit">Enviar correo electrónico</button>
</form>
@endsection