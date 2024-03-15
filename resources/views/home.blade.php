<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="https://cdn.calendario-colombia.com/widget_blanco.css">

</head>

<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card-body bg-light shadow">
                    <div class="card ">
                        <div class="card-header bg-info text-white "><b>Citas Medicas</b></div>
                        <form action="{{ url('/ver-agenda') }}" method="post" id="form">
                            @csrf
                            <div class="mt-4 mx-auto text-center col-md-8">
                                <div class="input-group mb-2 col-12 col-md-4 p-2" style="margin-bottom: 10px;">
                                    <input list="especialidades" class="form-control" name="nombreespecialidad"
                                        placeholder="Seleccione una especialidad" required
                                        oninput="updateIdEspecialidad()">
                                    <input type="hidden" name="idespecialidad" id="idespecialidad">
                                    <span class="input-group-text bg-info text-white"
                                        style="border-radius: 0 5px 5px 0;">
                                        <i class="fa-solid fa-stethoscope"></i>
                                    </span>
                                    <datalist id="especialidades">
                                        @foreach($especialidades as $especialidad)
                                        <option value="{{ $especialidad->nombreespecialidad }}"
                                            data-id="{{ $especialidad->idespecialidad }}">
                                        </option>
                                        @endforeach
                                    </datalist>
                                </div>

                                <button type="submit" class="btn btn-info text-white" id="verAgendaBtn">Ver
                                    Medico</button>
                            </div>
                            <br>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if(isset($resultadoFinal) && count($resultadoFinal) > 0)
                <div class="card shadow">
                    <div class="card">
                        <div class="container" style="max-width: 1300px; margin: 0 auto;">
                            <div class="card-container" style="margin-top: 20px;">
                                @foreach($resultadoFinal as $nombrereal => $cedula)
                                <div class="carde" data-bs-toggle="modal" data-bs-target="#detalleModal"
                                    data-nombrereal="{{ $nombrereal }}" data-especialidad="{{ $nombreEspecialidad }}"
                                    data-cedula="{{ $cedula }}">
                                    <div class="card-photo">
                                        <i class="fas fa-user-md fa-3x text-white shadow"></i>
                                    </div>
                                    <div class="carde-title">
                                        <span style="max-font-size: 14px;"><b>{{ strtoupper($nombrereal) }}</b></span>
                                        <br>
                                        <span>{{ $nombreEspecialidad }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-info" role="alert">
                    No hay especialistas disponibles.
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-mobile  ">
            <div class="modal-content">
                <div class="modal-header shadow " style="background-color: #0dcaf0; color: black;">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Detalles del Especialista</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close "></button>
                </div>
                <div class="modal-body">
                    <div id="detalleEspecialista">

                    </div>
                    <div class="modal-body row">
                        <div class="col-md-16">
                            <div id="calendar" class="calendar">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="/js/home/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

    <script>
    $(document).ready(function() {
        // Capturar el evento de cambio en el input
        $('#especialidadInput').on('input', function() {
            // Obtener el valor seleccionado del datalist
            var inputValue = $(this).val();

            // Buscar la opción correspondiente al valor seleccionado
            var selectedOption = $('#especialidades option[value="' + inputValue + '"]');

            // Obtener el valor de data-idespecialidad de la opción seleccionada
            var idEspecialidad = selectedOption.data('idespecialidad');

            // Mostrar el valor en el input
            this.value = idEspecialidad;
        });
    });
    </script>

    <script>
    function configurarModal() {
        document.addEventListener('DOMContentLoaded', function() {
            // Obtén los elementos con la clase 'carde'
            const cards = document.querySelectorAll('.carde');

            // Itera sobre cada elemento y agrega un evento de clic
            cards.forEach(card => {
                card.addEventListener('click', function() {
                    // Obtén los datos del elemento clicado
                    const nombrereal = card.getAttribute('data-nombrereal');
                    const especialidad = card.getAttribute('data-especialidad');
                    const cedula = card.getAttribute('data-cedula');

                    consultarBaseDatos(cedula);

                    // Actualiza el contenido del modal con los datos del especialista
                    document.getElementById('detalleEspecialista').innerHTML = `
                        <p><strong><span>${nombrereal}</span></strong></p>
                        <span>${especialidad}</span>
                        <p id="cedulaEspecialista"><span>${cedula}</span></p>
                        <div class="row">
                            <div class="col-md-3 mb-3" >
                                <label for="cups">Codigo de Servicio:</label>
                                <input type="text" class="form-control" name="cups" id="cups" placeholder="Selecciona Cups" list="cupsList" onchange="actualizarProcedimiento()">
                                <input type="hidden" id="idservicio" name="idservicio">
                                @if(isset($nombrecups))
                                    <datalist id="cupsList">
                                        @foreach($nombrecups as $data)
                                            <option value="{{ $data->cups }}" data-descripcioncups="{{ $data->descripcioncups }}" data-servicio="{{ $data->servicio }}">
                                        @endforeach
                                    </datalist>
                                @endif
                            </div>
                            <div class="col-md-3 mb-3" >
                            <span>Procedimiento</span>
                            <input type="text" class="form-control" id="procedimiento" placeholder="Procedimiento" readonly>
                        </div>
                            <div class="col-md-3 mb-3" >
                                <span>Codigo de Autorizacion</span>
                                <input type="text" class="form-control" id="autorizacion" name="autorizacion" placeholder="Autorizacion">
                            </div>
                            <div class="col-md-3 mb-3" >
                                <span>Cantidad</span>
                                <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="cantidad" value="1">
                            </div>
                            <div class="col-md-3 mb-3" hidden>
                                <span>servicio</span>
                                <input type="text" class="form-control" name="servicio" id="servicio" placeholder="servicio">
                            </div>
                                <!-- Otros campos del formulario -->
                            </div>
                    `;

                    // Agrega un evento al input 'cups' para manejar el cambio y actualizar 'idservicio'
                    const cupsInput = document.getElementById('cups');
                    cupsInput.addEventListener('input', function() {
                        const selectedOption = document.querySelector(
                            `#cupsList option[value="${this.value}"]`);
                        if (selectedOption) {
                            const servicioValue = selectedOption.getAttribute(
                                'data-servicio');
                            document.getElementById('idservicio').value = servicioValue;
                        } else {
                            document.getElementById('idservicio').value = '';
                        }
                    });
                });
            });
        });
    }

    // Llama a la función para configurar el modal
    configurarModal();
    </script>

    <script>
    var fechasPrueba = []; // Declara la variable fechasPrueba fuera de la función

    function inicializarCalendario() {

        document.addEventListener('DOMContentLoaded', function() {
            $('#detalleModal').on('shown.bs.modal', function() {
                var calendarEl = document.getElementById('calendar');

                // Obtener el año actual
                var currentYear = new Date().getFullYear();


                // Llamada a la función para obtener los días festivos del año actual
                obtenerDiasFestivosColombia(currentYear)
                    .then(function(diasFestivos) {
                        // Mapear los días festivos para integrarlos en el calendario
                        var eventosFestivos = diasFestivos.map(function(festivo) {
                            return {
                                title: 'Festivo',
                                start: festivo.date,
                                display: 'background',
                                content: festivo.name,
                                color: '#f0f0ef',
                                textColor: 'red',
                            };
                        });

                        // Llamada a la función consultarBaseDatos con una cédula de ejemplo
                        consultarBaseDatos('cedulaEjemplo').then(function() {
                            var eventos = fechasPrueba.map(function(fecha) {
                                return {
                                    title: 'Disponible',
                                    start: fecha,
                                    end: fecha,
                                    display: 'background',
                                    content: 'Disponible',
                                };
                            });

                            // Combinar los eventos disponibles con los eventos festivos
                            var todosEventos = eventos.concat(eventosFestivos);

                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'dayGridMonth',
                                locale: 'es',
                                buttonText: {
                                    today: 'Hoy',
                                    month: 'Mes',
                                    week: 'Semana',
                                    day: 'Día',
                                    list: 'Lista',
                                },
                                eventTimeFormat: {
                                    hour: 'numeric',
                                    minute: '2-digit',
                                    meridiem: 'short',
                                },
                                events: todosEventos,
                                eventClick: function(info) {
                                    // Obtener la fecha seleccionada
                                    var fechaSeleccionada = info.event.start;

                                    // Llamar a la función para obtener las horas disponibles
                                    obtenerHorasDisponibles(fechaSeleccionada);

                                },
                                eventDidMount: function(info) {
                                    if (info.event.title === 'Festivo') {
                                        tippy(info.el, {
                                            content: traducirNombre(info
                                                .event.extendedProps
                                                .content),
                                        });

                                    }

                                    // Verifica si el evento es 'Disponible' y la fecha es anterior a hoy
                                    info.event.title === 'Disponible' && info
                                        .event.start < new Date() && (info.el
                                            .style.display = 'none');
                                },
                            });
                            calendar.render();
                        });
                    })
                    .catch(function(error) {
                        console.error('Error al obtener los días festivos:', error);
                    });
            });

        });
    }

    // Llama a la función para inicializar el calendario
    inicializarCalendario();

    // con esta api obtengo los dias festivos 
    function obtenerDiasFestivosColombia(year = new Date().getFullYear()) {
        const url = `https://date.nager.at/api/v3/PublicHolidays/2024/co`;

        // Devuelve una promesa para que el llamador pueda manejarla según sea necesario
        return new Promise((resolve, reject) => {
            // Utiliza la función fetch para realizar la solicitud a la API
            fetch(url)
                .then(response => {
                    // Verifica si la respuesta es exitosa (código de estado 200)
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    // Convierte la respuesta a formato JSON
                    return response.json();
                })
                .then(data => {
                    // Resuelve la promesa con los días festivos
                    resolve(data);

                })
                .catch(error => {
                    // Rechaza la promesa con el error en caso de falla
                    reject(error);
                });
        });
    }

    function obtenerHorasDisponibles(fecha) {
        var cedulaEspecialista = document.getElementById('cedulaEspecialista').innerText;
        var autorizacion = document.getElementById('autorizacion').value;
        var cups = document.getElementById('cups').value;
        var servicio = document.getElementById('idservicio').value;
        var cantidad = document.getElementById('cantidad').value;

        console.log(cantidad);
        // Simulación de horas de ejemplo para la fecha seleccionada
        fetch('/home/consulta/horario', {
                method: 'POST', // Utilizar el método POST para enviar datos al servidor
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .content // Asegúrate de incluir el token CSRF
                },
                body: JSON.stringify({
                    cedulaEspecialista: cedulaEspecialista,
                    fecha: fecha,

                })
            })
            .then(response => response.json())
            .then(data => {

                var duracioncita = data.duracioncita;
                var fechaseleccionada = `${fecha}`;
                var fechaparaenvio = fecha.toLocaleDateString('en-CA');
                var horasfinalmañana = data.horasfinalmañana;
                var horasFinalTarde = data.horasFinalTarde;
                var cotizante = data.cotizante;
                var grupofamiliar = data.grupofamiliar;

                var opcionesSelect = "";
                for (const hora of [...horasfinalmañana, ...horasFinalTarde]) {
                    const horaFormat = hora.substring(8, 10) + ":" + hora.substring(10, 12);
                    const periodo = hora.substring(6, 8) === 'AM' ? 'AM' : 'PM';
                    opcionesSelect += `<option value="${horaFormat}">${horaFormat} ${periodo}</option>`;
                }

                var opcionesSelecta = grupofamiliar.map(paciente =>
                    `<option value="${paciente.idpaciente}" data-idpaciente="${paciente.idpaciente}">
                        ${paciente.nombre1} ${paciente.nombre2} ${paciente.apellido1} ${paciente.apellido2} - ${paciente.idpaciente}
                    </option>`
                ).join('');

                var cotizante = data.cotizante;
                if (cotizante === null || typeof cotizante !== 'object') {
                    Swal.fire({
                        title: "Error",
                        text: "Debe actualizar los datos del cotizante para continuar.",
                        icon: "error",
                        showCancelButton: true,
                        confirmButtonText: "Sí",
                        cancelButtonText: "No"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/update";
                        } else {
                            // Aquí puedes agregar la lógica si el usuario elige no actualizar los datos del cotizante
                        }
                    });
                    return;
                }
                var opcionesCotizante = `<option value="${cotizante.idpaciente}" data-idpaciente="${cotizante.idpaciente}">
                        ${cotizante.nombre1 ? cotizante.nombre1 : ''} 
                        ${cotizante.nombre2 ? cotizante.nombre2 : ''} 
                        ${cotizante.apellido1 ? cotizante.apellido1 : ''} 
                        ${cotizante.apellido2 ? cotizante.apellido2 : ''} - 
                        ${cotizante.idpaciente ? cotizante.idpaciente : ''}
                    </option>`;

                // Fusionar las opciones en un solo select
                var opcionesCombinadas = opcionesCotizante + opcionesSelecta;
                var tituloHTML =
                    `<h2>Disponibilidad para</h2> <span style="font-size: 16px">${obtenerNombreDia(fecha)}</span>`;
                var cuerpoHTML = `
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="miembro" class="form-label"><b>Seleccione Un Miembro:</b></label>
                                    <select id="miembro" class="form-control form-select miembro" name="miembro" required>
                                        <option disabled selected>Seleccione un Miembro</option>
                                        ${opcionesCombinadas}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="horaSeleccionada" class="form-label"><b>Seleccione un horario:</b></label>
                                    <select id="horaSeleccionada" class="form-control form-select" name="horaSeleccionada" required>
                                        <option disabled selected>Seleccione un horario</option>
                                        ${opcionesSelect}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>`;

                // Mostrar el cuadro de diálogo de Swal.fire
                Swal.fire({
                    title: tituloHTML,
                    html: cuerpoHTML,
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return new Promise((resolve) => {
                            // Simula una operación asíncrona (puedes reemplazarlo con tu lógica)
                            setTimeout(() => {
                                // Realiza las acciones necesarias antes de cerrar el cuadro de diálogo
                                resolve();
                            }, 1000); // Simulamos 1 segundo de operación
                        });
                    },
                    focusConfirm: false,
    allowOutsideClick: true,


                }).then((result) => {

                    if (result.isConfirmed) {

                        var fechahoy = new Date();
                        // Fecha formateada para el envio
                        var fechaseleccionada = new Date(); // Puedes reemplazar esto con tu propia fecha
                        // Obtener la fecha en formato Y-m-d
                        var fechaparenvio = fechaseleccionada.toISOString().slice(0, 10).replace(/-/g, '');
                        //fecha de la solicitud toca formatearla a la de la base de datos
                        var fechaFormateada = fechahoy.toLocaleDateString("es-CO", {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit'
                            }).split('/').reverse().join('-') + ' ' +
                            fechahoy.toLocaleTimeString("es-CO", {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: false
                            }).replace(/:/g, ':');

                        var documento = data.cedulaEspecialista;
                        var fecita = fechaparaenvio;
                        var fechaEstablecida = new Date(fechaseleccionada);

                        var selectMiembro = document.getElementById('miembro');

                        // Obtener el idpaciente seleccionado
                        var selectedIdPaciente = selectMiembro.options[selectMiembro.selectedIndex]
                            .getAttribute('data-idpaciente');

                        console.log(selectedIdPaciente);

                        // Obtén la hora seleccionada del select
                        const horaSeleccionada = document.getElementById('horaSeleccionada').value;

                        // Combina la fecha con la hora seleccionada
                        const fechaHoraSeleccionada = moment(fecita + ' ' + horaSeleccionada,
                            'YYYYMMDDHHmm');

                        fetch('/home/consulta/horario/guardarcita', {
                                method: 'POST', // Utilizar el método POST para enviar datos al servidor
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .content // Asegúrate de incluir el token CSRF
                                },
                                body: JSON.stringify({
                                    fechaFormateada: fechaFormateada,
                                    fechaHoraSeleccionada: fechaHoraSeleccionada.format(
                                        'YYYYMMDDHHmm'),
                                    documento: documento,
                                    fecita: fecita,
                                    autorizacion: autorizacion,
                                    cups: cups,
                                    servicio: servicio,
                                    cantidad: cantidad,
                                    idpaciente: selectedIdPaciente

                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data.message)

                                var fechaOriginal = data.pxcita;
                                if (fechaOriginal) {
                                    var fechaFormateada =
                                        `${fechaOriginal.substring(0, 4)}-${fechaOriginal.substring(4, 6)}-${fechaOriginal.substring(6, 8)}-${fechaOriginal.substring(8, 10)}:${fechaOriginal.substring(10, 12)}`;
                                } else {
                                    console.error('fechaOriginal no está definida o es undefined');
                                }


                                // Manejar la respuesta aquí
                                if (data.message === 'Cita guardada con éxito') {
                                    // Mostrar una alerta de éxito
                                    Swal.fire({
                                            icon: 'success',
                                            title: 'Su cita quedó Agendada',
                                            html: ` Para la fecha y hora ${fechaFormateada} le recordamos al paciente traer su autorización vigente y copia del documento.`,
                                            showConfirmButton: true,

                                        })
                                        .then(() => {
                                            // Cuando se cierre la alerta, cerrar el modal
                                            $('#detalleModal').modal('hide');
                                            window.location.href = '/show/date';

                                        });
                                } else {
                                    // Mostrar una alerta de error con el mensaje proporcionado
                                    if (data.question === undefined || data.question === null) {
                                        console.log(data.question);
                                        Swal.fire({
                                                icon: 'error',
                                                title: 'Error al guardar la cita',
                                                html: `${data.message}`, // Mensaje de error personalizado
                                            })
                                            .then(() => {
                                                // No se realiza ninguna acción especial si la pregunta no está definida
                                                console.log('La pregunta no está definida.');
                                            });
                                    } else if (data.message.toLowerCase().includes(
                                            'ya tiene una cita asignada para este dia')) {
                                        Swal.fire({
                                                icon: 'error',
                                                title: 'Error al guardar la cita',
                                                html: `${data.message}<br>${data.question}`, // Agregar la pregunta aquí, debajo del texto
                                            })
                                            .then(() => {
                                                // No se realiza ninguna acción especial si el mensaje es específico
                                                console.log(
                                                    'El usuario tiene una cita ya asignada para este día'
                                                );
                                            });
                                    } else {
                                        Swal.fire({
                                                icon: 'error',
                                                title: 'Error al guardar la cita',
                                                html: `${data.message}<br>${data.question}`, // Agregar la pregunta aquí, debajo del texto
                                                showCancelButton: true,
                                                confirmButtonText: 'Sí',
                                                cancelButtonText: 'No',
                                                cancelButtonColor: '#d33',
                                            })
                                            .then((result) => {
                                                if (result.isConfirmed) {
                                                    // Redireccionar a la ruta /update si el usuario hace clic en "Sí"
                                                    window.location.href = '/update';
                                                } else {
                                                    // Puedes agregar lógica adicional si el usuario hace clic en "No"
                                                    console.log('El usuario ha seleccionado No');
                                                }
                                            });
                                    }

                                }
                            })
                            .catch(error => {
                                // Manejar errores aquí
                                console.error('Error en la solicitud:', error);
                            });
                    }
                });

                function obtenerNombreDia(fecha) {
                    const opciones = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    return fecha.toLocaleDateString('es-ES', opciones);
                }
            })
            .catch(error => {
                // Manejar errores
                console.error(error);
            });
    }

    function consultarBaseDatos(cedula) {
        // Retorna la promesa resultante de la llamada fetch
        return fetch(`/home/consulta/${cedula}`)
            .then(response => response.json())
            .then(data => {
                // Verifica si hay datos y muestra las fechas por consola si se cumplen las condiciones
                if (data && data.length > 0) {

                    fechasPrueba = data.map(item => item.fecha); // Actualiza fechasPrueba

                    // Dispara el evento personalizado con las fechas
                    document.dispatchEvent(new CustomEvent('fechasDisponibles', {
                        detail: fechasPrueba
                    }));
                }
            })
            .catch(error => console.error('Error vale mia:', error));
    }
    </script>
    <script>
    // Función para manejar el cambio en el campo cups y actualizar el campo procedimiento y servicio
    function actualizarProcedimiento() {
        // Obtén el valor seleccionado en el campo cups
        var selectedCups = document.getElementById('cups').value;

        // Busca el elemento en el datalist que coincide con el cups seleccionado
        var selectedOption = document.querySelector('#cupsList option[value="' + selectedCups + '"]');

        // Si se encuentra la opción seleccionada, actualiza el valor del campo procedimiento y servicio
        if (selectedOption) {
            var descripcionCups = selectedOption.getAttribute('data-descripcioncups');
            var descripcionServicio = selectedOption.getAttribute('data-servicio');

            document.getElementById('procedimiento').value = descripcionCups;
            document.getElementById('servicio').value = descripcionServicio;
        } else {
            // Si no se encuentra la opción seleccionada, limpia el valor de los campos procedimiento y servicio
            document.getElementById('procedimiento').value = '';
            document.getElementById('servicio').value = '';
        }
    }
    </script>


    @endsection

</body>

</html>