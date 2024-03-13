document.addEventListener('DOMContentLoaded', () => {
    dibujarTarjeta();
    manejarFormularioComentario();
});


function dibujarTarjeta() {
    // Obtener el ID de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    // Crear el objeto JSON con el ID
    const datos = {
        id: id
    };

    // Configurar la solicitud fetch para enviar los datos al servidor
    fetch('http://localhost/stay/php/procesar_entrada_foro.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const contenedor = document.querySelector('.contenedor-foro');
        // Aquí puedes llamar a la función que maneja la creación de la tarjeta
        if (data.success) {
            const fila = data.data[0];
            const tarjetaDiv = crearTarjeta(fila);
            contenedor.appendChild(tarjetaDiv);

            // Manejar los comentarios
            if (fila.comentarios && fila.comentarios.length > 0) {
                fila.comentarios.forEach(comentario => {
                    const tarjetaComentario = crearTarjetaComentario(comentario);
                    contenedor.appendChild(tarjetaComentario);
                });
            }
        }
    })
    .catch(error => {
        console.error('Error al obtener los datos del paciente:', error);
    });
}


function crearTarjeta(fila) {
    const tarjetaDiv = document.createElement('div');
    tarjetaDiv.classList.add('tarjeta');

    const personaDiv = document.createElement('div');
    personaDiv.classList.add('persona');

    const imgPersona = document.createElement('img');
    imgPersona.src = fila.img;
    imgPersona.alt = 'foto perfil';

    const pPersona = document.createElement('p');
    pPersona.textContent = fila.nombre + ' ' + fila.apellidos;

    personaDiv.appendChild(imgPersona);
    personaDiv.appendChild(pPersona);

    const tituloDiv = document.createElement('div');
    tituloDiv.classList.add('titulo');

    const pTitulo = document.createElement('p');
    pTitulo.textContent = fila.titulo;

    tituloDiv.appendChild(pTitulo);

    const contenidoDiv = document.createElement('div');
    contenidoDiv.classList.add('contenido');

    if (fila.foto_contenido) {
        const imgContenido = document.createElement('img');
        imgContenido.src = fila.foto_contenido;
        imgContenido.alt = 'foto contenido';
        contenidoDiv.appendChild(imgContenido);
    } else if (fila.texto_contenido) {
        const pContenido = document.createElement('p');
        pContenido.textContent = fila.texto_contenido;
        contenidoDiv.appendChild(pContenido);
    }

    tarjetaDiv.appendChild(personaDiv);
    tarjetaDiv.appendChild(tituloDiv);
    tarjetaDiv.appendChild(contenidoDiv);

    return tarjetaDiv;
}
function crearTarjetaComentario(comentario) {
    const tarjetaComentarioDiv = document.createElement('div');
    tarjetaComentarioDiv.classList.add('tarjeta-comentario');

    const personaDiv = document.createElement('div');
    personaDiv.classList.add('persona');

    const imgPersona = document.createElement('img');
    imgPersona.src = comentario.img;
    imgPersona.alt = 'foto perfil';

    const pPersona = document.createElement('p');
    pPersona.textContent = comentario.nombre + ' ' + comentario.apellidos;

    personaDiv.appendChild(imgPersona);
    personaDiv.appendChild(pPersona);

    const contenidoDiv = document.createElement('div');
    contenidoDiv.classList.add('contenido');

    const pComentario = document.createElement('p');
    pComentario.textContent = comentario.comentario;

    const pFecha = document.createElement('p');
    pFecha.textContent = comentario.fecha;

    contenidoDiv.appendChild(pComentario);
    contenidoDiv.appendChild(pFecha);

    tarjetaComentarioDiv.appendChild(personaDiv);
    tarjetaComentarioDiv.appendChild(contenidoDiv);

    return tarjetaComentarioDiv;
}
function manejarFormularioComentario() {
    const formularioComentario = document.getElementById('formulario-comentario');
    formularioComentario.addEventListener('submit', (event) => {
        event.preventDefault();
        const textoComentario = document.getElementById('texto-comentario').value.trim();
        
        // Obtener el ID de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        // Crear el objeto JSON con el ID y el comentario
        const datos = {
            id: id,
            comentario: textoComentario
        };

        // Configurar la solicitud fetch para enviar los datos al servidor
        fetch('http://localhost/stay/php/agregar_comentario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            // Aquí puedes manejar la respuesta del servidor, por ejemplo, mostrar un mensaje de éxito
            console.log('Comentario agregado con éxito:', data);
            // Crear y agregar la nueva tarjeta de comentario
            const nuevaTarjetaComentario = crearTarjetaComentario({
                img: data.img,
                nombre: data.nombre,
                apellidos: data.apellidos,
                comentario: textoComentario,
                fecha: data.fecha
            });
            const contenedor = document.querySelector('.contenedor-foro');
            contenedor.appendChild(nuevaTarjetaComentario);
            // Limpiar el campo de texto después de enviar el comentario
            document.getElementById('texto-comentario').value = '';
        })
        .catch(error => {
            console.error('Error al agregar el comentario:', error);
        });
    });
}