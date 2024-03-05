document.addEventListener('DOMContentLoaded', function () {

    cargarOpcionesEliminar();
    const iconoEliminar = document.getElementById('icono_eliminar');
    iconoEliminar.addEventListener('click', function () {
        if (validarFormEliminar()) {
            console.log('Selección válida, procediendo con la acción de eliminar...');
            eliminarSesion();

        } else {
            console.log('Validación fallida, por favor, selecciona una sesión.');
        }
    });

    const iconoAnadir = document.getElementById('icono_anadir');
    iconoAnadir.addEventListener('click', function () {
        if (validarFormAnadir()) {
            console.log('Formulario válido, procediendo con la acción de añadir...');
            anadirArticulo();
            console.log('debería llegar aqúi');

        } else {
            console.log('Validación fallida, revisa los errores.');
        }
    });
});

function validarFormAnadir() {
    document.getElementById('errorPaciente').classList.remove('error');
    document.getElementById('errorPaciente').textContent = '';

    let flag = false;
    const input = document.getElementById('input_archivo');
    const archivo = input.files[0];
    if (archivo) {
        const nombreArchivo = archivo.name;
        const extensionArchivo = nombreArchivo.slice(((nombreArchivo.lastIndexOf(".") - 1) >>> 0) + 2).toLowerCase();
        // Verifica si la extensión es PHP
        if (extensionArchivo == "php") {
            flag = true;
        } else {
            document.getElementById('errorPaciente').textContent = 'Por favor, selecciona un archivo php.';
            document.getElementById('errorPaciente').classList.add('error');
        }
    } else {
        document.getElementById('errorPaciente').textContent = 'Por favor, selecciona un archivo.';
        document.getElementById('errorPaciente').classList.add('error');
    }
    return flag;
}


function validarFormEliminar() {
    const selectSesiones = document.getElementById('select_sesiones');
    document.getElementById('errorSesion').textContent = ''; // Limpiar el mensaje de error anterior
    document.getElementById('errorSesion').classList.remove('error');

    if (selectSesiones.value === '') {
        document.getElementById('errorSesion').textContent = 'Por favor, selecciona un articulo.';
        document.getElementById('errorSesion').classList.add('error');
        return false;
    }

    return true;
}


function cargarOpcionesEliminar() {
    console.log('hola');
    const selectEliminar = document.querySelector('#select_sesiones');
    fetch(`http://localhost/stay/php/procesar_edicion_articulos.php?select=articulos`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                // Limpia las opciones existentes
                selectEliminar.innerHTML = '';

                // Crea y añade una opción vacía y seleccionada al inicio
                const opcionVacia = document.createElement('option');
                opcionVacia.value = '';
                opcionVacia.textContent = 'Seleccione una artículo';
                opcionVacia.selected = true;
                opcionVacia.disabled = true; // Opcional: hacer que la opción no sea seleccionable después
                selectEliminar.appendChild(opcionVacia);

                // Añade las opciones de las sesiones
                data.articulos.forEach(articulo => {
                    const option = document.createElement('option');
                    option.value = articulo.id_articulo; // El valor de la opción es el id de la cita
                    option.textContent = `Id_articulo : ${articulo.id_articulo} - Título: ${articulo.titulo_articulo}`; // El texto de la opción incluye detalles de la cita

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

function eliminarSesion() {
    const formData = new FormData();
    formData.append('accion', 'eliminar');
    formData.append('id_articulo', document.getElementById('select_sesiones').value);

    fetch('http://localhost/stay/php/procesar_edicion_articulos.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Artículo eliminado con éxito');
            } else {
                console.error('Error al eliminar artículo:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    cargarOpcionesEliminar();
}

function anadirArticulo() {
    let archivo = document.getElementById('input_archivo').files[0];
    const formData = new FormData();
    formData.append('accion', 'anadir');
    formData.append('archivo', archivo);
    fetch('http://localhost/stay/php/procesar_edicion_articulos.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });

    cargarOpcionesEliminar();
}