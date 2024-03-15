<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/update.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    @extends('layouts.app')
    @section('content')


    <div class="container ">
        <div class="row justify-content-center">
            <!-- Card para actualizar datos del cotizante -->
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title">Actualizar Datos del Cotizante</h5>
                    </div>

                    <div class="card-body bg-light shadow">
                        @if(isset($paciente))
                        <div class="row mt-3 text-center justify-content-center">
                            <div class="col-sm-5">
                                <div class="card shadow"
                                    style="border: 2px solid #3498db; transition: border-color 0.3s; cursor: pointer; background: linear-gradient(to right, #bbe4e9, white);"
                                    onmouseover="this.style.borderColor='#2c3e50'"
                                    onmouseout="this.style.borderColor='#3498db'">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-user-circle icon"></i>
                                            <input type="text" class="form-control text-center" id="apellido1"
                                                name="apellido1"
                                                value="{{$paciente->apellido1}} {{$paciente->apellido2}} {{$paciente->nombre1}} {{$paciente->nombre2}}"
                                                tabindex="2"
                                                style="border: none; margin-bottom: -25px; font-weight: bold; background: linear-gradient(to right, #bbe4e9, white);">
                                        </h5>
                                        <h6 class="card-title">
                                            <input type="text" class="form-control text-center"
                                                value="{{$paciente->tipoid}} {{ Auth::user()->documento }}"
                                                style="border: none; background: linear-gradient(to right, #bbe4e9, white); color: black;">
                                        </h6>
                                        <p class="card-text text-center"><b>Cotizante</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-info text-white" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Actualizar</button>

                        </div>

                        @else
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-info text-white" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Actualizar</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(isset($paciente))
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #61b5ff">
                        <h5 class="card-title">Grupo Familiar</h5>
                    </div>
                    <div class="card-body bg-light shadow">
                        @php $counter = 0; @endphp
                        @foreach ($grupofamiliar as $grupo)
                        @if ($counter % 2 == 0)
                        <div class="row mt-3 text-center justify-content-center">
                            @endif
                            <div class="col-sm-5 mb-4">
                                <div class="card shadow"
                                    style="border: 2px solid #3498db; transition: border-color 0.3s; cursor: pointer; background: linear-gradient(to right, #bbe4e9, white);"
                                    onmouseover="this.style.borderColor='#2c3e50'"
                                    onmouseout="this.style.borderColor='#3498db'">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-user-circle icon"></i>
                                            <input type="text" class="form-control text-center apellido11"
                                                id="apellido1" name="apellido1"
                                                value="{{$grupo->apellido1}} {{$grupo->apellido2}} {{$grupo->nombre1}} {{$grupo->nombre2}}"
                                                tabindex="2"
                                                style="border: none; margin-bottom: -25px; font-weight: bold; background: linear-gradient(to right, #bbe4e9, white); font-size: 14px; width: 100%;">
                                        </h5>
                                        <h6 class="card-title">
                                            <input type="text" class="form-control text-center"
                                                value="{{$grupo->tipoid}} {{$grupo->idpaciente}}"
                                                style="border: none; background: linear-gradient(to right, #bbe4e9, white); color: black; font-size: 12px; width: 100%;">
                                        </h6>
                                        <p class="card-text text-center"><b>Miembro</b></p>
                                    </div>
                                </div>
                            </div>
                            @if ($counter % 2 != 0 || $loop->last)
                        </div>
                        @endif
                        @php $counter++; @endphp
                        @endforeach
                        <div class="text-center mt-3">
                            <div class="mensajedemiembro"></div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn text-white" style="background-color: #61b5ff"
                                id="botonmiembro" data-bs-toggle="modal" data-bs-target="#exampleModal2">Añadir</button>
                        </div>
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>

    @if(session('success'))
    <script>
    // Reemplaza la alerta por una SweetAlert
    swal.fire({
        title: "¡Éxito!",
        text: "{{ session('success') }}",
        icon: "success",
        button: "Aceptar",
    });
    </script>
    @endif

    @if(session('error'))
    <script>
    // Reemplaza la alerta por una SweetAlert
    swal.fire({
        title: "¡Error!",
        text: "{{ session('error') }}",
        icon: "error",
        button: "Aceptar",
    });
    </script>
    @endif


    </div>
    <!-- Modal grupo Familiar -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header  text-white" style="background-color: #61b5ff">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registre los Miembros del Grupo Familiar</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="miembros" method="POST" action="/update/miembros">
                        @csrf
                        <div class="input-group mb-1" style="margin: 0 auto; width: fit-content;">
                            <p>Antes de Agregar un mienmbro haga una busqueda</p>
                        </div>
                        <div class="input-group mb-3" style="margin: 0 auto; width: fit-content;">
                            <input type="search" class="form-control" id="documento_1" name="documento_1"
                                placeholder="Digite Documento" style="max-width: 80%;">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>

                        <div class="row">
                            <!-- Columna 1 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tiposdoc2" class="form-label">Tipo de Documento</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input class="form-control" id="tiposdoc2" name="tiposdoc2"
                                            list="opcionesTiposdoc2" required>
                                    </div>
                                    <datalist id="opcionesTiposdoc2" name="tiposdoc2">
                                        <option value="AS">Adulto Sin Identificación</option>
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="CD">Carnet Diplomatico</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="MS">Menor Sin Identificación</option>
                                        <option value="NI">Identidad</option>
                                        <option value="NU">Numero Unico</option>
                                        <option value="NV">Certificado Nacido Vivo</option>
                                        <option value="PA">Pasaporte</option>
                                        <option value="MS">Menos Sin Identificación</option>
                                        <option value="PE">Permiso Especial Permanente</option>
                                        <option value="PP">Permiso De Protección temporal</option>
                                        <option value="RC">Registro Civil</option>
                                        <option value="SC">Salvo Conducto</option>
                                        <option value="MS">Menos Sin Identificación</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                    </datalist>
                                </div>
                                <div class="mb-3">
                                    <label for="documento" class="form-label">Documento</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="number" class="form-control" id="documento_1_1"
                                            name="documento_1_1" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="apellido1_1" class="form-label">Primer Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="apellido1_1" name="apellido1_1"
                                            oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="apellido2_1" class="form-label">Segundo Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="apellido2_1" name="apellido2_1"
                                            oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                </div>

                            </div>
                            <!-- Fin de Columna 1 -->

                            <!-- Columna 2 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nombre1_1" class="form-label ">Primer Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="nombre1_1" name="nombre1_1"
                                            oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nombre2_1" class="form-label">Segundo Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="nombre2_1" name="nombre2_1"
                                            oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono_1" class="form-label">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control" id="telefono_1" name="telefono_1"
                                            required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="direccion_1" class="form-label">Dirección</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control" id="direccion_1" name="direccion_1"
                                            oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>

                                <div class="mb-3" hidden>
                                    <label for="Regimen_1" class="form-label">Codigo Regimen</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-envelope"></i></span>
                                        <input type="text" class="form-control" id="Regimen_1" name="Regimen_1">
                                    </div>
                                </div>
                            </div>

                            <!-- Fin de Columna 2 -->

                            <!-- Columna 3 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fechanacimiento_1" class="form-label">Fecha de Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                        <input type="date" class="form-control" id="fechanacimiento_1"
                                            name="fechanacimiento_1" max="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="sexopaciente_1" class="form-label">Sexo Del Paciente</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-venus-mars"></i></span>
                                        <input type="text" class="form-control " id="sexopaciente_1"
                                            name="sexopaciente_1" list="sexOptions" required>
                                        <datalist id="sexOptions">
                                            <option value="M">Masculino
                                            <option value="F">Femenino
                                        </datalist>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email_1" class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email_1" name="email_1" required>
                                    </div>
                                </div>
                                <div class="mb-3" hidden>
                                    <label for="email_1" class="form-label">Entidad</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-envelope"></i></span>
                                        <input type="text" class="form-control" id="entidad_1" value="{{ Auth::user()->entidad }}" name="entidad_1" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin de Columna 3 -->
                        </div>
                        <div class="mensajemienbros d-flex justify-content-center">
                            <h4></h4>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-info text-white" id="botonañadir">Añadir</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 id="nombreCompleto" class="card-title">Registre los datos del Cotizante:
                                {{ Auth::user()->name }}</h5>
                            <p class="card-text" style="font-size: 12px">{{ Auth::user()->documento }}</p>

                        </div>
                    </div>
                </div>
                <div class="modal-body">

                    @if(isset($paciente))
                    <form action="{{ url('/update/existing') }}" method="post" id="formmodal">
                        @csrf

                        <div class="row ">
                            <!-- Columna 1 -->
                            <div class="col-md-4 ">
                                <div class="mb-3">
                                    <label for="tipodoc" class="form-label">Tipo de Documento</label>
                                    <div class="input-group ">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input class="form-control" id="tipodoc" name="tipodoc" list="tiposdoc"
                                            value="{{$paciente->tipoid}}" tabindex="1">
                                    </div>
                                    <datalist id="tiposdoc">
                                        <option value="AS">Adulto Sin Identificación
                                        <option value="CC">Cédula de Ciudadanía
                                        <option value="CD">Carnet Diplomatico
                                        <option value="CE">Cédula de Extranjería
                                        <option value="MS">Menor Sin Identificación
                                        <option value="NI">Identidad
                                        <option value="NU">Numero Unico
                                        <option value="NV">Certificado Nacido Vivo
                                        <option value="PA">Pasaporte
                                        <option value="MS">Menos Sin Identificación
                                        <option value="PE">Permiso Especial Permanente
                                        <option value="PP">Permiso De Protección temporal
                                        <option value="RC">Registro Civil
                                        <option value="SC">Salvo Conducto
                                        <option value="MS">Menos Sin Identificación
                                        <option value="TI">Tarjeta de Identidad
                                    </datalist>
                                </div>
                                <div class="mb-3">
                                    <label for="apellido1" class="form-label">Primer Apellido</label>
                                    <div class="input-group " id="ape">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control " id="apellido1" name="apellido1"
                                            value="{{$paciente->apellido1}}" tabindex="2">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="apellido2" class="form-label">Segundo Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="apellido2" name="apellido2"
                                            value="{{$paciente->apellido2}}" tabindex="3">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre1" class="form-label">Primer Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="nombre1" name="nombre1"
                                            value="{{$paciente->nombre1}}" tabindex="4">
                                    </div>
                                </div>

                            </div>
                            <!-- Fin de Columna 1 -->

                            <!-- Columna 2 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nombre2" class="form-label">Segundo Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="nombre2" name="nombre2"
                                            value="{{$paciente->nombre2}}" tabindex="5">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control" id="telefono" name="telefono"
                                            value="{{$paciente->telefono}}" tabindex="6">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control" id="direccion" name="direccion"
                                            value="{{$paciente->direccion}}" tabindex="7">
                                    </div>
                                </div>


                            </div>

                            <!-- Fin de Columna 2 -->

                            <!-- Columna 3 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fechanacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                        <input type="date" class="form-control" id="fechanacimiento"
                                            name="fechanacimiento" value="{{$paciente->fechanacimiento}}" tabindex="9">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="sexopaciente" class="form-label">Sexo Del Paciente</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-venus-mars"></i></span>
                                        <input type="text" class="form-control" id="sexopaciente" name="sexopaciente"
                                            list="sexOptions" value="{{$paciente->sexopaciente}}" tabindex="10">
                                        <datalist id="sexOptions">
                                            <option value="M">Masculino
                                            <option value="F">Femenino
                                        </datalist>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ Auth::user()->email }}" tabindex="11">
                                    </div>
                                </div>
                            </div>

                            <!-- Fin de Columna 3 -->
                        </div>

                        <!-- Puedes seguir añadiendo más campos según tus necesidades -->

                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-info text-white">Actualizar</button>
                        </div>

                    </form>
                    @else
                    <form id="miFormulario">
                        <div class="row">
                            <!-- Columna 1 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tipodoc" class="form-label">Tipo de Documento</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input class="form-control" id="tipodoc" name="tiposdoc" list="tiposdoc"
                                            required>

                                    </div>
                                    <datalist id="tiposdoc" name="tiposdoc">
                                        <option value="AS">Adulto Sin Identificación</option>
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="CD">Carnet Diplomatico</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="MS">Menor Sin Identificación</option>
                                        <option value="NI">Identidad</option>
                                        <option value="NU">Numero Unico</option>
                                        <option value="NV">Certificado Nacido Vivo</option>
                                        <option value="PA">Pasaporte</option>
                                        <option value="MS">Menos Sin Identificación</option>
                                        <option value="PE">Permiso Especial Permanente</option>
                                        <option value="PP">Permiso De Protección temporal</option>
                                        <option value="RC">Registro Civil</option>
                                        <option value="SC">Salvo Conducto</option>
                                        <option value="MS">Menos Sin Identificación</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                    </datalist>
                                </div>
                                <div class="mb-3">
                                    <label for="apellido1" class="form-label">Primer Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control apellido1" id="apellido1"
                                            name="apellido1" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="apellido2" class="form-label">Segundo Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="apellido2" name="apellido2"
                                            oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre1" class="form-label ">Primer Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="nombre1" name="nombre1"
                                            oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin de Columna 1 -->

                            <!-- Columna 2 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nombre2" class="form-label">Segundo Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="nombre2" name="nombre2"
                                            oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-phone"></i></span>
                                        <input type="number" class="form-control" id="telefono" name="telefono"
                                            required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control" id="direccion" name="direccion"
                                            oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>

                                <div class="mb-3" hidden>
                                    <label for="direccion" class="form-label">Entidad</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control" id="entidad" name="entidad"
                                            oninput="this.value = this.value.toUpperCase()"
                                            value="{{ Auth::user()->entidad }}" required>
                                    </div>
                                </div>

                                <div class="mb-3" hidden>
                                    <label for="Regimen" class="form-label">Codigo Regimen</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-envelope"></i></span>
                                        <input type="text" class="form-control" id="Regimen" name="regimen">
                                    </div>
                                </div>

                            </div>

                            <!-- Fin de Columna 2 -->

                            <!-- Columna 3 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fechanacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                        <input type="date" class="form-control" id="fechanacimiento"
                                            name="fechanacimiento" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="sexopaciente" class="form-label">Sexo Del Paciente</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-venus-mars"></i></span>
                                        <input type="text" class="form-control " id="sexopaciente" name="sexopaciente"
                                            list="sexOptions" required>
                                        <datalist id="sexOptions">
                                            <option value="M">Masculino
                                            <option value="F">Femenino
                                        </datalist>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i
                                                class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="correoe" name="correoe"
                                            value="{{ Auth::user()->email }}" required>
                                    </div>
                                </div>


                            </div>
                            <!-- Fin de Columna 3 -->
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-info text-white">Actualizar</button>
                        </div>
                    </form>

                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- aqui esta el modal para la eps -->
    <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal de Ejemplo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del modal -->
                    <p>Contenido del modal relacionado con la opción seleccionada.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> -->
                <div class="modal-body">
                    ...
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>
</body>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- este escript abre el modal -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('miFormulario').addEventListener('submit', function(event) {
        event.preventDefault();
        // Obtener los datos del formulario
        const formData = new FormData(event.target);

        // Realizar la solicitud fetch
        fetch('/update/datos', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Agrega el token CSRF de Laravel si lo estás utilizando
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del servidor:', data);
                Swal.fire({
                    text: "Los datos se han actualizado correctamente",
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonText: "OK",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la URL /update
                        window.location.href = '/update';
                    }
                });
            })
            .catch(error => {
                console.error('Error al enviar la solicitud fetch:', error);
            });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('documento_1').addEventListener('blur', function() {
        var documento = this.value;
        var tel = document.getElementById('telefono_1');
        console.log('tel:', tel);
        fetch('/update/validarmiembros', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    documento: documento
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.miembro) {
                    console.log('Datos de miembros:', data.miembro);

                    document.getElementById('apellido1_1').value = data.miembro.apellido1;
                    document.getElementById('apellido2_1').value = data.miembro.apellido2;
                    document.getElementById('nombre1_1').value = data.miembro.nombre1;
                    document.getElementById('nombre2_1').value = data.miembro.nombre2;
                    document.getElementById('fechanacimiento_1').value = data.miembro
                        .fechanacimiento;
                    document.getElementById('tiposdoc2').value = data.miembro.tipoid;
                    document.getElementById('email_1').value = data.miembro.correoe;
                    document.getElementById('direccion_1').value = data.miembro.direccion;
                    document.getElementById('sexopaciente_1').value = data.miembro.sexopaciente;
                    document.getElementById('telefono_1').value = data.miembro.telefono;
                    document.getElementById('documento_1_1').value = data.miembro.idpaciente;

                    if (data.miembro.grupofamiliar_id == 0) {
                        $('.mensajemienbros h4').text(
                            'El usuario no pertenece a ningún miembro familiar, Puede añadirlo.'
                        );
                        $('#botonañadir').show().prop('disabled',
                            false); // Mostrar y habilitar el botón
                    } else {
                        $('.mensajemienbros h4').text(
                            'El usuario ya pertenece a un grupo familiar.'
                        );
                        // Ocultar el botón de añadir si el usuario ya pertenece a un grupo familiar
                        $('#botonañadir').hide().prop('disabled',
                            true); // Ocultar y deshabilitar el botón
                    }

                    if (data.documentoUsuario) {
                        $('.mensajemienbros h4').text(
                            'Este usuario es Cotizante'
                        )
                        $('#botonañadir').hide().prop('disabled',
                            true); // Ocultar y deshabilitar el botón

                    }


                    // Aquí puedes asignar otros campos si los necesitas
                } else {
                    // Manejar el caso en que no se encuentre ningún miembro con el documento proporcionado
                    console.log('No se encontró ningún miembro con el documento proporcionado.');
                    document.getElementById('apellido1_1').value = '';
                    document.getElementById('apellido2_1').value = '';
                    document.getElementById('nombre1_1').value = '';
                    document.getElementById('nombre2_1').value = '';
                    document.getElementById('fechanacimiento_1').value = '';
                    document.getElementById('tiposdoc2').value = '';
                    document.getElementById('email_1').value = '';
                    document.getElementById('direccion_1').value = '';
                    document.getElementById('sexopaciente_1').value = '';
                    document.getElementById('telefono_1').value = '';
                    document.getElementById('documento_1_1').value = '';
                    $('#botonañadir').show().prop('disabled',
                        false);
                    $('.mensajemienbros h4').text(
                        'El usuario es un usuario nuevo y puede añadirse al grupo'
                    );
                }
            })
            .catch(error => {
                console.error('Hubo un problema con la solicitud fetch:', error);
            });
    });
});
</script>

<script>
$(document).ready(function() {
    $('#exampleModal2').on('hidden.bs.modal', function() {
        $('#miembros').trigger("reset");
        $('.mensajemienbros h4').text(
            ' '
        );
    });
});
</script>

<script>
// Espera a que la página esté completamente cargada
document.addEventListener('DOMContentLoaded', function() {
    // Obtener el nombre completo del usuario
    var namecomplet = "{{ Auth::user()->name }}";

    // Dividir el nombre completo en partes utilizando el espacio como separador
    var partesNombre = namecomplet.split(' ');

    // El primer elemento del array partesNombre debería ser el primer nombre
    var primerNombre = partesNombre[0];

    // El último elemento del array partesNombre debería ser el apellido
    var apellido = partesNombre[partesNombre.length - 1];

    // Obtener el elemento de entrada del primer nombre
    var inputPrimerNombre = document.getElementById('nombre1');

    // Obtener el elemento de entrada del apellido



    // Asignar el primer nombre al valor del input del primer nombre
    inputPrimerNombre.value = primerNombre;

    // Asignar el apellido al valor del input del apellido
    inputApellido1.value = apellido;
});
</script>


<script>
// Deshabilitar la capacidad de entrada de texto en el campo de entrada
document.getElementById("sexopaciente").addEventListener("input", function(event) {
    if (!event.target.value.includes('Masculino') && !event.target.value.includes('Femenino')) {
        event.target.value = '';
    }
});
</script>

</html>