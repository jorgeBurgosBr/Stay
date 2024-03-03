document.addEventListener('DOMContentLoaded', () => {
    dibujarTarjeta();
    const campoBusqueda = document.querySelector('.buscador input[type="text"]');
    campoBusqueda.addEventListener('input', () => {
        const terminoBusqueda = campoBusqueda.value.trim();
        if (terminoBusqueda.length > 0) {
            fetch('./php/busqueda_foro.php?termino=' + encodeURIComponent(terminoBusqueda))
                .then(response => response.json())
                .then(data => {
                    mostrarResultados(data);
                    console.log(data);
                })
                .catch(error => console.error('Error al buscar hilos:', error));
        }
        else {
            limpiarResultados();
        }
    });
});

function dibujarTarjeta() {
    fetch('./php/procesar_foro.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let contenedor = document.querySelector('.contenedor-foro');
                contenedor.innerHTML = '';
                for (let key in data) {
                    if (key !== "success") {
                        let fila = data[key];
                        let tarjetaDiv = document.createElement('div');
                        tarjetaDiv.classList.add('tarjeta');
                        let personaDiv = document.createElement('div');
                        personaDiv.classList.add('persona');
                        let imgPersona = document.createElement('img');
                        imgPersona.src = fila.img;
                        imgPersona.alt = 'foto perfil';
                        let pPersona = document.createElement('p');
                        pPersona.textContent = fila.nombre + fila.apellidos;
                        personaDiv.appendChild(imgPersona);
                        personaDiv.appendChild(pPersona);
                        let tituloDiv = document.createElement('div');
                        tituloDiv.classList.add('titulo');
                        let pTitulo = document.createElement('p');
                        pTitulo.textContent = fila.titulo;
                        tituloDiv.appendChild(pTitulo);
                        let contenidoDiv = document.createElement('div');
                        contenidoDiv.classList.add('contenido');
                        if (fila.foto_contenido) {
                            let imgContenido = document.createElement('img');
                            imgContenido.src = fila.foto_contenido;
                            imgContenido.alt = 'foto contenido';
                            contenidoDiv.appendChild(imgContenido);
                        } else if (fila.texto_contenido) {
                            let pContenido = document.createElement('p');
                            pContenido.textContent = fila.texto_contenido;
                            contenidoDiv.appendChild(pContenido);
                        }
                        tarjetaDiv.appendChild(personaDiv);
                        tarjetaDiv.appendChild(tituloDiv);
                        tarjetaDiv.appendChild(contenidoDiv);
                        contenedor.appendChild(tarjetaDiv);
                    }
                }
            }
            else {
                contenedor.textContent = "data.error";
            }
        })
        .catch(error => {
            console.error('Error al obtener los datos del paciente:', error);
        });
}

function mostrarResultados(data) {
    const contenedor = document.querySelector('.contenedor-foro'); // Definir contenedor aquí

    if (data.success) {
        contenedor.innerHTML = '';
        for (let key in data) {
            if (key !== "success") {
                let fila = data[key];
                let tarjetaDiv = document.createElement('div');
                tarjetaDiv.classList.add('tarjeta');
                let personaDiv = document.createElement('div');
                personaDiv.classList.add('persona');
                let imgPersona = document.createElement('img');
                imgPersona.src = fila.img;
                imgPersona.alt = 'foto perfil';
                let pPersona = document.createElement('p');
                pPersona.textContent = fila.nombre + fila.apellidos;
                personaDiv.appendChild(imgPersona);
                personaDiv.appendChild(pPersona);
                let tituloDiv = document.createElement('div');
                tituloDiv.classList.add('titulo');
                let pTitulo = document.createElement('p');
                pTitulo.textContent = fila.titulo;
                tituloDiv.appendChild(pTitulo);
                let contenidoDiv = document.createElement('div');
                contenidoDiv.classList.add('contenido');
                if (fila.foto_contenido) {
                    let imgContenido = document.createElement('img');
                    imgContenido.src = fila.foto_contenido;
                    imgContenido.alt = 'foto contenido';
                    contenidoDiv.appendChild(imgContenido);
                } else if (fila.texto_contenido) {
                    let pContenido = document.createElement('p');
                    pContenido.textContent = fila.texto_contenido;
                    contenidoDiv.appendChild(pContenido);
                }
                tarjetaDiv.appendChild(personaDiv);
                tarjetaDiv.appendChild(tituloDiv);
                tarjetaDiv.appendChild(contenidoDiv);
                contenedor.appendChild(tarjetaDiv);
            }
        }
    } else {
        contenedor.textContent = 'No se encontraron hilos con ese nombre.';
    }
}


function limpiarResultados() {
    const contenedor = document.querySelector('.contenedor-foro');
    // Verificar si el campo de búsqueda está vacío
    const campoBusqueda = document.querySelector('.buscador input[type="text"]');
    if (campoBusqueda.value.trim() === '') {
        // Si el campo de búsqueda está vacío, volver a cargar todos los hilos originales
        dibujarTarjeta();
    } else {
        // Si hay un término de búsqueda, limpiar los resultados anteriores
        contenedor.innerHTML = '';
    }
}

