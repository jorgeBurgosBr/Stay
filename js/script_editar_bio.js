document.addEventListener('DOMContentLoaded', () => {
    // Obtener el ID de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    // Si hay un ID en la URL, llamar a la función para dibujar la tarjeta
    if (id) {
        dibujarTarjeta(id);
    }
});

function dibujarTarjeta(id) {
    fetch('./php/procesar_editar_bio.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                for (let key in data) {
                    if (key !== "success") {
                        let fila = data[key];

                        // Crear la sección de información del paciente
                        const informacionDiv = document.createElement('div');
                        informacionDiv.classList.add('informacion');

                        // Crear la sección de datos del paciente
                        const datosPacienteDiv = document.createElement('div');
                        datosPacienteDiv.classList.add('datos_paciente');

                        // Crear la imagen del paciente
                        const imagenPaciente = document.createElement('img');
                        imagenPaciente.src = fila.img;
                        imagenPaciente.alt = 'Imagen del paciente';

                        // Crear el contenedor de nombre y edad
                        const nombreEdadDiv = document.createElement('div');
                        nombreEdadDiv.classList.add('nombre_edad');

                        // Crear el párrafo para el nombre
                        const nombreP = document.createElement('p');
                        nombreP.classList.add('nombre');
                        nombreP.textContent = fila.nombre + " " + fila.apellidos;

                        // Crear el párrafo para la edad
                        const edadP = document.createElement('p');
                        edadP.classList.add('edad');
                        edadP.textContent = fila.edad + " / " + fila.genero;

                        // Agregar la imagen, nombre y edad al contenedor de datos del paciente
                        nombreEdadDiv.appendChild(nombreP);
                        nombreEdadDiv.appendChild(edadP);
                        datosPacienteDiv.appendChild(imagenPaciente);
                        datosPacienteDiv.appendChild(nombreEdadDiv);

                        // Agregar el contenedor de datos del paciente a la sección de información
                        informacionDiv.appendChild(datosPacienteDiv);

                        // Crear la sección de biografía
                        const bioDiv = document.createElement('div');
                        bioDiv.classList.add('bio');

                        // Crear el formulario
                        const formulario = document.createElement('form');
                        formulario.classList.add('formulario-bio');

                        // Crear el textarea para la biografía
                        const textareaBio = document.createElement('textarea');
                        textareaBio.name = 'bio';
                        textareaBio.textContent = fila.bio;

                        // Crear el botón de enviar
                        const botonEnviar = document.createElement('button');
                        botonEnviar.textContent = 'Actualizar';
                        botonEnviar.type = 'submit';

                        // Agregar el textarea y el botón al formulario
                        formulario.appendChild(textareaBio);
                        formulario.appendChild(botonEnviar);

                        // Agregar el formulario a la sección de biografía
                        bioDiv.appendChild(formulario);

                        // Agregar la sección de biografía al contenedor de tarjetas
                        // informacionDiv.appendChild(bioDiv);

                        // Agregar la sección de información al contenedor de tarjetas
                        const contenedorTarjetas = document.querySelector('.contenedor');
                       contenedorTarjetas.appendChild(informacionDiv);
                       contenedorTarjetas.appendChild(bioDiv);

                        // Agregar el evento de escucha al formulario
                        formulario.addEventListener('submit', (event) => {
                            event.preventDefault(); // Evitar que el formulario se envíe normalmente

                            // Obtener el valor del textarea
                            const nuevaBio = textareaBio.value;

                            // Enviar los datos al servidor para su actualización
                            actualizarBio(id, nuevaBio);
                        });
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error al obtener los datos del paciente:', error);
        });
}

function actualizarBio(id, nuevaBio) {
    // Crear los datos a enviar
    const datos = {
        id: id,
        bio: nuevaBio
    };

    // Configurar la solicitud fetch para enviar los datos al servidor
    fetch('./php/procesar_actualizar_bio.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {
        // Manejar la respuesta del servidor
        if (data.success) {
           console.log('La biografía se ha actualizado correctamente.');
           const contenedorTarjetas = document.querySelector('.contenedor');
           contenedorTarjetas.innerHTML = ''; // Esto borrará todo el contenido dentro del contenedor

           dibujarTarjeta(id);
        } else {
            console.error('Error al actualizar la biografía:', data.error);
        }
    })
   //  .catch(error => {
   //      console.error('Error al enviar la solicitud:', error);
   //  });
}
