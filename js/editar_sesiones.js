document.addEventListener('DOMContentLoaded', function () {
    var popupMessage = document.querySelector('.popup-message');
    var closeButton = document.querySelector('.popup-message .close-popup-message');

    closeButton.addEventListener('click', function () {
        popupMessage.style.display = 'none';
    });
    const iconoAnadir = document.getElementById('icono_anadir');
    iconoAnadir.addEventListener('click', function () {
        if (validarFormAnadir()) {
            console.log('Formulario válido, procediendo con la acción de añadir...');
            // Recargamos las opciones de eliminar para que aparezca la cita;
            anadirSesion();
            cargarOpcionesEliminar();
            cargarOpcionesAnadir();
            darFeedback('Sesión añadida con éxito');
        } else {
            console.log('Validación fallida, revisa los errores.');
        }
    });

    const iconoEliminar = document.getElementById('icono_eliminar');
    iconoEliminar.addEventListener('click', function () {
        if (validarFormEliminar()) {
            console.log('Selección válida, procediendo con la acción de eliminar...');
            eliminarSesion();
            // Recargamos las opciones de anadir para que no aparezca la cita;
            cargarOpcionesAnadir();
            cargarOpcionesEliminar();
            darFeedback('Sesión eliminada con éxito');

        } else {
            console.log('Validación fallida, por favor, selecciona una sesión.');
        }
    });
    cargarOpcionesAnadir();
    cargarOpcionesEliminar();
});

function validarFormAnadir() {
    document.getElementById('errorPaciente').textContent = '';
    document.getElementById('errorFecha').textContent = '';
    document.getElementById('errorHora').textContent = '';
    document.getElementById('errorPaciente').classList.remove('error');
    document.getElementById('errorFecha').classList.remove('error');
    document.getElementById('errorHora').classList.remove('error');

    let isValid = true;

    const selectPacientes = document.getElementById('select_pacientes');
    if (selectPacientes.value === '') {
        document.getElementById('errorPaciente').textContent = 'Por favor, selecciona un paciente.';
        document.getElementById('errorPaciente').classList.add('error');
        isValid = false;
    }

    const fecha = document.getElementById('fecha').value;
    if (!fecha) {
        document.getElementById('errorFecha').textContent = 'Por favor, selecciona una fecha.';
        document.getElementById('errorFecha').classList.add('error');
        isValid = false;
    } else {
        const fechaSeleccionada = new Date(fecha);
        const manana = new Date();
        manana.setDate(manana.getDate() + 1);
        manana.setHours(0, 0, 0, 0);
        const tresMesesMasTarde = new Date(new Date().setMonth(new Date().getMonth() + 3));

        if (fechaSeleccionada >= tresMesesMasTarde || fechaSeleccionada < manana) {
            document.getElementById('errorFecha').textContent = 'La fecha debe ser entre mañana y los próximos 3 meses.';
            document.getElementById('errorFecha').classList.add('error');
            isValid = false;
        }
    }

    const hora = document.getElementById('hora').value;
    if (!hora) {
        document.getElementById('errorHora').textContent = 'Por favor, selecciona una hora.';
        document.getElementById('errorHora').classList.add('error');
        isValid = false;
    } else {
        const horaSeleccionada = hora.split(':');
        if (horaSeleccionada.length === 2) {
            const horaNum = parseInt(horaSeleccionada[0], 10);

            if (horaNum < 8 || horaNum > 20) {
                document.getElementById('errorHora').textContent = 'La hora debe estar dentro del rango de 8:00 a 20:00.';
                document.getElementById('errorHora').classList.add('error');
                isValid = false;
            }
        }
    }

    return isValid;
}

function validarFormEliminar() {
    const selectSesiones = document.getElementById('select_sesiones');
    document.getElementById('errorSesion').textContent = ''; // Limpiar el mensaje de error anterior
    document.getElementById('errorSesion').classList.remove('error');

    if (selectSesiones.value === '') {
        document.getElementById('errorSesion').textContent = 'Por favor, selecciona una sesión.';
        document.getElementById('errorSesion').classList.add('error');
        return false;
    }

    return true;
}

function cargarOpcionesAnadir() {
    const selectAnadir = document.querySelector('#select_pacientes');
    fetch(`http://localhost/stay/php/procesar_edicion_sesiones.php?select=pacientes`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                const selectAnadir = document.querySelector('#select_pacientes');
                // Limpia las opciones existentes
                selectAnadir.innerHTML = '';

                // Crea y añade una opción vacía y seleccionada al inicio
                const opcionVacia = document.createElement('option');
                opcionVacia.value = '';
                opcionVacia.textContent = 'Seleccione un paciente';
                opcionVacia.selected = true;
                opcionVacia.disabled = true; // Opcional: hacer que la opción no sea seleccionable después
                selectAnadir.appendChild(opcionVacia);

                // Añade las opciones de los pacientes
                data.pacientes.forEach(paciente => {
                    const option = document.createElement('option');
                    option.value = paciente.id_paciente; // El valor de la opción es el id del paciente
                    option.textContent = paciente.nombre; // El texto de la opción es el nombre del paciente

                    // Añade la opción al select
                    selectAnadir.appendChild(option);
                });
            } else {
                console.log(data.error)
            }
        })
        .catch(error => {
            console.error("Error:", error);
        })
}
function cargarOpcionesEliminar() {
    const selectEliminar = document.querySelector('#select_sesiones');
    fetch(`http://localhost/stay/php/procesar_edicion_sesiones.php?select=sesiones`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                // Limpia las opciones existentes
                selectEliminar.innerHTML = '';

                // Crea y añade una opción vacía y seleccionada al inicio
                const opcionVacia = document.createElement('option');
                opcionVacia.value = '';
                opcionVacia.textContent = 'Seleccione una sesión';
                opcionVacia.selected = true;
                opcionVacia.disabled = true; // Opcional: hacer que la opción no sea seleccionable después
                selectEliminar.appendChild(opcionVacia);

                // Añade las opciones de las sesiones
                data.citas.forEach(cita => {
                    const option = document.createElement('option');
                    option.value = cita.id_cita; // El valor de la opción es el id de la cita
                    option.textContent = `Cita el ${cita.fecha} a las ${cita.hora} - Paciente: ${cita.paciente}`; // El texto de la opción incluye detalles de la cita

                    // Añade la opción al select
                    selectEliminar.appendChild(option);
                });
            } else {
                console.log(data.error);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
}


function anadirSesion() {
    const formData = new FormData();
    formData.append('accion', 'anadir');
    formData.append('id_paciente', document.getElementById('select_pacientes').value);
    formData.append('fecha', document.getElementById('fecha').value);
    formData.append('hora', document.getElementById('hora').value);

    fetch('http://localhost/stay/php/procesar_edicion_sesiones.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Sesión añadida con éxito');
                // Actualiza la UI según sea necesario
            } else {
                console.error('Error al añadir sesión:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));

}
function eliminarSesion() {
    const formData = new FormData();
    formData.append('accion', 'eliminar');
    formData.append('id_cita', document.getElementById('select_sesiones').value);

    fetch('http://localhost/stay/php/procesar_edicion_sesiones.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Sesión eliminada con éxito');
            } else {
                console.error('Error al eliminar sesión:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
}

function darFeedback(string) {
    document.querySelector(".popup-message").style.display = "block";
    document.querySelector("#popup-text").textContent = string;
}