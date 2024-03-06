document.addEventListener('DOMContentLoaded', () => {
    dibujarTarjeta();
});

function dibujarTarjeta() {
    fetch('./php/procesar_paciente_psico.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
               // Itera sobre las claves del objeto data
                for (let key in data) {
                    // Verifica si la clave no es "success"
                    if (key !== "success") {
                        // Accede al objeto JSON interno y haz lo que necesites con él
                        let fila = data[key];
                        console.log("Objeto:", fila);
                        // Crear la tarjeta con los datos obtenidos
                        const tarjetaDiv = document.createElement('div');
                        tarjetaDiv.classList.add('tarjeta');

                        // Crear el encabezado
                        const encabezadoDiv = document.createElement('div');
                        encabezadoDiv.classList.add('encabezado');
                        // Aquí deberías construir el SVG con los datos que recibiste

                        // Crear la sección de contenido de encabezado
                        const contenidoEncabezadoDiv = document.createElement('div');
                        contenidoEncabezadoDiv.classList.add('contenido-encabezado');

                        
                        const tituloTarjetaDiv = document.createElement('div');
                        tituloTarjetaDiv.classList.add('titulo-tarjeta');
                        
                        const nombreP = document.createElement('p');
                        nombreP.classList.add('nombre');
                        nombreP.textContent = fila.nombre + " " + fila.apellidos;
                        
                        const edadP = document.createElement('p');
                        edadP.classList.add('edad');
                        edadP.textContent = fila.edad + " / " + fila.genero; // Suponiendo que 'fila' contiene la edad del paciente
                        
                        tituloTarjetaDiv.appendChild(nombreP);
                        tituloTarjetaDiv.appendChild(edadP);
                        
                        const imagenPaciente = document.createElement('img');
                        imagenPaciente.classList.add('imagen-paciente');
                        imagenPaciente.src = fila.img; // Suponiendo que 'fila' contiene la URL de la imagen
                        imagenPaciente.alt = 'Imagen paciente';
                        
                        contenidoEncabezadoDiv.appendChild(tituloTarjetaDiv);
                        contenidoEncabezadoDiv.appendChild(imagenPaciente);

                        // Crear la sección de texto
                        const textoDiv = document.createElement('div');
                        textoDiv.classList.add('texto');

                        const textoP = document.createElement('p');
                        textoP.textContent = truncateText(fila.bio);

                        textoDiv.appendChild(textoP);

                        // Agregar todas las secciones a la tarjeta
                        tarjetaDiv.appendChild(encabezadoDiv);
                        tarjetaDiv.appendChild(contenidoEncabezadoDiv);
                        tarjetaDiv.appendChild(textoDiv);

                        // Agregar el evento de clic a la tarjeta
                        tarjetaDiv.addEventListener('click', function() {
                            // Redirigir a otra página al hacer clic en la tarjeta
                            window.location.href = 'editar_bio.php?id=' + fila.id; // Cambia 'otra_pagina.php' por la ruta de tu página de destino
                        });

                        // Agregar la tarjeta al contenedor de tarjetas
                        const contenedorTarjetas = document.querySelector('.contenedor-tarjetas');
                        contenedorTarjetas.appendChild(tarjetaDiv);
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error al obtener los datos del paciente:', error);
        });
}
const MAX_WORDS = 25; // Define el número máximo de palabras a mostrar

function truncateText(text) {
    // Verificar si la bio es null
    if (text === null) {
        return "No tiene biografía.";
    } else {
        // Dividir la cadena de texto en palabras
        const words = text.split(/\s+/);
        // Seleccionar las primeras MAX_WORDS palabras y unirlas de nuevo en una cadena
        const truncatedText = words.slice(0, MAX_WORDS).join(" ");
        // Agregar puntos suspensivos si hay más palabras
        if (words.length > MAX_WORDS) {
            return truncatedText + "...";
        }
        return truncatedText;
    }
}
