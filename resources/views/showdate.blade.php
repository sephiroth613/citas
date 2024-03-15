<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/showdate.css">

</head>

<body>
    @extends('layouts.app')
    @section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card-body bg-light shadow">
                    <div class="card">
                        <div class="table-responsive" style="overflow-x: auto; border: 1px solid #dee2e6;">
                            <table class="table table-hover" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th class="bg-info text-white"><i class="fas fa-calendar"></i> Fecha</th>
                                        <th class="bg-info text-white"><i class="fas fa-clock"></i> Hora</th>
                                        <th class="bg-info text-white"><i class="fas fa-user"></i> Especialista</th>
                                        <th class="bg-info text-white"><i class="fas fa-user"></i> Paciente</th>
                                        <th style="text-align: center;" class="bg-info text-white"><i
                                                class="fas fa-check"></i> Activa</th>
                                        <th class="bg-info text-white text-center"><i class="fas fa-cogs"></i>
                                            Cancelar_Cita</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($citas as $cita)
                                    <tr>
                                        <td>{{$cita->fecita}}</td>
                                        <td>{{ \Carbon\Carbon::parse($cita->fechacita)->format('h:i A') }}</td>
                                        <td>{{ $cita->medico->nombrereal }}</td>
                                        <td>{{ $cita->paciente->ncompleto }}</td>
                                        <td style="text-align: center;">
                                            @if(strtolower($cita->cancelada) == '0')
                                            <i class="fa-solid fa-circle-check fa-xl" style="color: #00ff2a;"></i>
                                            @else
                                            <i class="fa-solid fa-ban fa-xl " style="color: red;"></i>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <form method="POST" action="{{ url('/show/date/canceldate') }}"
                                                class="eliminarCitaForm">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $cita->idcita }}">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmarCancelacion({{ $cita->idcita }})">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmarCancelacion(idCita) {
        Swal.fire({
            title: '¿Desea cancelar la cita?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                // Encontrar el formulario específico por su clase y enviarlo
                document.querySelector('.eliminarCitaForm input[name="id"][value="' + idCita + '"]').parentNode
                    .submit();
            } else {
                // Puedes agregar lógica adicional si el usuario elige NO
            }
        });
    }
    </script>



</body>

</html>