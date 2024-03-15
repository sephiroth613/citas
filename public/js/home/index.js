function configurarBorradoSeleccion() {
    // Función para borrar la selección al hacer clic en el icono
    $(".input-group-text").on("click", function () {
        // Encuentra el input relacionado al icono clickeado
        var input = $(this).siblings("input");
        // Borra la selección del input
        input.val("");
    });
}

// Llamar a la función al cargar el documento
$(document).ready(function () {
    configurarBorradoSeleccion();
});

function traducirNombre(nombre) {
    const traducciones = {
        "New Year's Day": "Año Nuevo",
        Epiphany: "Día de los Reyes Magos",
        "Saint Joseph's Day": "Día de San José",
        "Maundy Thursday": "Jueves Santo",
        "Good Friday": "Viernes Santo",
        "Labour Day": "Día del Trabajo",
        "Ascension Day": "Ascensión",
        "Corpus Christi": "Corpus Christi",
        "Sacred Heart": "Sagrado Corazón",
        "Declaration of Independence": "Día de la Independencia",
        "Saint Peter and Saint Paul": "San Pedro y San Pablo",
        "All Saints' Day": "Todos los Santos",
        "Columbus Day": "Día de la Raza",
        "Battle of Boyacá": "Batalla de Boyacá",
        "Assumption of Mary": "Asunción de la Virgen",
        "Independence of Cartagena": "Independencia de Cartagena",
        "Immaculate Conception": "Inmaculada Concepción",
        "Christmas Day": "Navidad",
    };
    nombre = nombre.trim();
    return traducciones[nombre] || nombre;
}

function updateIdEspecialidad() {
    var inputNombreEspecialidad = document.querySelector(
        'input[name="nombreespecialidad"]'
    );
    var inputIdEspecialidad = document.querySelector(
        'input[name="idespecialidad"]'
    );
    var dataList = document.querySelector("#especialidades");

    var selectedOption = Array.from(dataList.options).find(
        (option) => option.value === inputNombreEspecialidad.value
    );

    if (selectedOption) {
        inputIdEspecialidad.value = selectedOption.getAttribute("data-id");
    } else {
        inputIdEspecialidad.value = ""; // Limpiar el valor si no hay coincidencia
    }
}
