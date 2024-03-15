@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-info text-white">{{ __('Inicio De Sesión') }}

                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3 row">
                            <label for="documento" class="col-md-4 col-form-label text-md-end">{{ __('Documento') }}
                            </label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-info text-white"><i class="fas fa-user " ></i></span>
                                    <input id="documento" type="number" placeholder="Documento"
                                        class="form-control @error('documento') is-invalid @enderror" name="documento"
                                        value="{{ old('documento') }}" required autocomplete="documento" autofocus>
                                </div>
                                @error('documento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}
                            </label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-info text-white"><i class="fas fa-lock"></i></span>
                                    <input id="password" type="password" placeholder="Contraseña"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">{{ __('Recuérdame') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0 row justify-content-center">
                            <div class="col-md-8">
                                <div class="text-center">
                                    <button type="submit"
                                        class="btn btn-info text-white">{{ __('Iniciar Sesión') }}</button>
                                </div>

                                @if (Route::has('password.request'))
                                <div class="text-center mt-2">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        <!-- {{ __('¿Olvidó su contraseña?') }} -->
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @error('documento')
    // Muestra una alerta de SweetAlert con el mensaje de error
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Estas credenciales no coinciden con nuestros registros',
    });
    @enderror
});
</script>
</script>