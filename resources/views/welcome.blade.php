<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pastor Y Maria</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/welcome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="antialiased " style="background-color: blue">
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-white bg-dots-darker bg-center bg-gray-80 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
            <a href="{{ url('/home') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Inicio</a>
            @else
            <a href="{{ route('login') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar
                Sesion</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrarse</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="mt-8 text-xl font-semibold text-gray-900 dark:text-white text-center">
                            <!-- Agrega la imagen dentro de la columna con las clases de Bootstrap -->
                            <img src="https://iili.io/Jl29jYg.png" class="imagen-pequena mb-2 mx-auto" alt="Imagen">
                            <!-- Agregamos la clase 'mb-2' para un margen en la parte inferior y 'mx-auto' para centrar horizontalmente -->
                        </div>
                        <!--  <div class="mt-6 text-xl font-semibold text-gray-900 dark:text-white text-center">
                            <img src="https://iili.io/JYBSTD7.gif" class="img-fluid mb-2" alt="Imagen">
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="card mx-auto p-3 shadow hover:shadow-lg" style="max-width: 50rem;">
                <div class="card-header bg-white">
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">
                        Citas Medicas Online
                    </h3>
                </div>
                <div class="card-body">
                    <p class="font-serif text-sm lg:text-base text-justify">
                        Bienvenido a nuestra plataforma de citas médicas en línea. Descubre cómo facilitamos el
                        acceso a servicios médicos y mejora tu experiencia de atención médica.
                    </p>
                    <p class="font-serif text-sm lg:text-base text-justify">
                        Si eres un usuario registrado, tienes la opción de crear tu propia cita médica. En caso
                        de no estar registrado, es necesario hacerlo para acceder a esta funcionalidad.
                    </p>
                </div>


                <div class="card-footer text-muted bg-white text-sm">
                    SaludShinra Productions
                    <span class="float-end text-sm">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </span>
                </div>
            </div>

        </div>
    </div>


</body>

</html>