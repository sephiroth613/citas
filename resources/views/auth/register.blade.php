@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">{{ __('Registro') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }} " id="form">
                        @csrf

                        <div class="mb-3 row">
                            <div class="col-md-10 mx-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-info text-white"><i class="fas fa-user"></i></span>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        oninput="this.value = this.value.toUpperCase()" placeholder="Nombre Completo">
                                </div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-10 mx-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-info text-white"><i
                                            class="fas fa-id-card"></i></span>
                                    <input id="documento" type="text" class="form-control" name="documento"
                                        placeholder="Documento">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">

                            <div class="col-md-10 mx-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-info text-white"><i
                                            class="fas fa-envelope"></i></span>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Correo Electrónico">
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">

                            <div class="col-md-10 mx-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-info text-white"><i class="fa-solid fa-hospital"
                                            style="font-size: 14px;"></i></span>
                                    <input list="entidades" class="form-control @error('entidad') is-invalid @enderror"
                                        name="entidad" id="entidad" list="entidad" required placeholder="EPS">
                                    <datalist id="entidades">
                                        @foreach($nombresEntidades as $id => $nombre)
                                        <option value="{{ $nombre }}" data-id="{{ $id }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                @error('entidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <!-- Agregar un campo oculto para almacenar el idtercero seleccionado -->
                                <input type="hidden" id="idtercero" name="idtercero">
                            </div>
                        </div>

                        <div class="mb-3 row">

                            <div class="col-md-10 mx-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-info text-white"><i class="fa-solid fa-hospital"
                                            style="font-size: 14px;"></i></span>
                                    <input list="regimen" class="form-control @error('regimen') is-invalid @enderror"
                                        name="regimen" id="regimen" list="regimen" value="" required readonly
                                        placeholder="Regimen">
                                </div>
                                @error('regimen')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">

                            <div class="col-md-10 mx-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-info text-white"><i class="fas fa-lock"></i></span>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" minlength="8" placeholder="Contraseña"
                                        readonly>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">

                            <div class="col-md-10 mx-auto">
                                <div class="input-group">
                                    <span class="input-group-text bg-info text-white"><i class="fas fa-lock"></i></span>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirmar Contraseña" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0 row justify-content-center">
                            <div class="col-md-10 text-center">
                                <!-- Aquí agregamos la clase text-center para centrar el contenido -->
                                <button type="submit" class="btn btn-info text-white">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>

                    </form>
                    <small style="color: grey;"><b>Nota:</b> Por el momento la contraseña será el mismo número de documento y se asignará automáticamente</small>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eps-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align: center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">La Eps seleccionada es:</h1>
                <div id="selectedResult"></div>
                <div id="selectedNit" style="font-size: 12px"></div>
                <div>Seleccione el Régimen</div>

                <!-- Contenedor para mostrar botones de régimen -->
                <div id="regimenButtonsContainer"></div>
            </div>
        </div>
    </div>
</div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    @error('documento')
    // Muestra una alerta de SweetAlert con el mensaje de error
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'El Documento ya esta registrado',
    });
    @enderror
});
</script>


<!-- Añade datos al modal -->
<script>
$(document).ready(function() {
    $('#entidad').on('change', function() {
        var selectedValue = $(this).val();
        var selectedId = $('#entidades option[value="' + selectedValue + '"]').data('id');

        if (selectedValue && selectedId) {
            $('#selectedResult').html(selectedValue);
            $('#selectedNit').html('NIT: ' + selectedId);

            $('#exampleModal').modal('show');

            fetch('/register/entidades', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        selectedValue: selectedValue,
                        selectedId: selectedId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Muestra los botones en el contenedor
                    showRegimenButtons(data.regimen);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });

    // Función para mostrar botones en el contenedor
    // ...

    // Función para mostrar botones en el contenedor
    function showRegimenButtons(regimen) {
        var buttonsContainer = $('#regimenButtonsContainer');

        // Limpiar el contenedor antes de agregar nuevos botones
        buttonsContainer.empty();

        // Crear y agregar botones según los datos recibidos
        regimen.forEach(function(item) {
            var button = $('<button class="btn btn-primary m-2">' + item.tipoentidad + '</button>');

            // Agregar el valor de identidad como atributo data al botón
            button.data('identidad', item.identidad);

            // ...

            button.click(function() {
                // Manejar clic en el botón
                var selectedTipoEntidad = item.tipoentidad;
                var selectedIdentidad = item.identidad;

                // Actualizar el valor del input con la identidad
                $('#regimen').val(selectedTipoEntidad);
                $('#selected_identidad').val(selectedIdentidad);

                // Mostrar el tipo de entidad seleccionado en otro elemento, por ejemplo, un div
                $('#tipoEntidadDisplay').text(selectedIdentidad);
                $('#idtercero').val(selectedIdentidad);

                // Puedes realizar más acciones si es necesario

                console.log('Tipo de entidad seleccionado:', selectedTipoEntidad);
                console.log('Identidad correspondiente:', selectedIdentidad);
                $('#exampleModal').modal('hide');
            });

            // ...


            buttonsContainer.append(button);
        });
    }

    // ...

});
</script>

<script>
document.getElementById('entidad').addEventListener('input', function() {
    var selectedOption = document.querySelector('#entidades option[value="' + this.value + '"]');
    if (selectedOption) {
        document.getElementById('idtercero').value = selectedOption.getAttribute('data-id');
    } else {
        // Limpiar el campo oculto si el valor ingresado no coincide con ninguna opción
        document.getElementById('idtercero').value = '';
    }
});
</script>

<script>
$(document).ready(function() {
    $("#documento").on("input", function() {
        var documentoValue = $(this).val();
        $("#password, #password-confirm").val(documentoValue);
    });
});
</script>