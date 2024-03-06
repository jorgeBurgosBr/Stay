document.addEventListener('DOMContentLoaded', () => {
    dibujarTarjeta();

    const campoBusqueda = document.querySelector('.search_bar input[type="text"]');
    campoBusqueda.addEventListener('input', () => {
        const terminoBusqueda = campoBusqueda.value.trim();
        if (terminoBusqueda.length > 0) {
            buscarHilos(terminoBusqueda);
        } else {
            limpiarResultados();
        }
    });
});

function dibujarTarjeta() {
    fetch('./php/procesar_foro.php')
        .then(response => response.json())
        .then(data => {
            mostrarResultados(data);
        })
        .catch(error => {
            console.error('Error al obtener los datos del paciente:', error);
        });
}

function mostrarResultados(data) {
    const contenedor = document.querySelector('.contenedor-foro');

    if (data.success) {
        contenedor.innerHTML = '';
        for (let key in data) {
            if (key !== "success") {
                const fila = data[key];
                const tarjetaDiv = crearTarjeta(fila);
                contenedor.appendChild(tarjetaDiv);
            }
        }
    } else {
        contenedor.textContent = 'No se encontraron hilos con ese nombre.';
    }
}

function buscarHilos(terminoBusqueda) {
    fetch('./php/busqueda_foro.php?termino=' + encodeURIComponent(terminoBusqueda))
        .then(response => response.json())
        .then(data => {
            mostrarResultados(data);
            console.log(data);
        })
        .catch(error => console.error('Error al buscar hilos:', error));
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
   // Agregar el evento de clic a la tarjeta
      tarjetaDiv.addEventListener('click', function() {
         // Redirigir a otra página al hacer clic en la tarjeta
         window.location.href = 'entrada_foro.php?id=' + fila.id_publicacion; // Cambia 'otra_pagina.php' por la ruta de tu página de destino
                        });
    return tarjetaDiv;
}

function limpiarResultados() {
    const contenedor = document.querySelector('.contenedor-foro');
    const campoBusqueda = document.querySelector('.search_bar input[type="text"]');
    if (campoBusqueda.value.trim() === '') {
        dibujarTarjeta();
    } else {
        contenedor.innerHTML = '';
    }
}
