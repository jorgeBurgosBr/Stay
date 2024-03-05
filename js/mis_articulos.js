document.addEventListener('DOMContentLoaded', function () {
    cargarMisArticulos();
    window.addEventListener('resize', ajustarEstilosArticulos);
    document.querySelector('.container_articles').addEventListener('click', function (e) {
        // Comprueba si el elemento clicado o uno de sus padres es un article_wrapper
        let target = e.target;
        while (target != document.querySelector('.container_articles')) {
            if (target.classList.contains('article_wrapper')) {

                const datos = new FormData();
                datos.append('id_articulo', target.dataset.idArticulo);
                // Aquí puedes realizar la acción deseada con el article_wrapper
                fetch('./php/procesar_articulos.php', {
                    method: 'POST',
                    body: datos
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = `${data.url}`;
                        } else {
                            console.log(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error', error);
                    });

                break; // Sale del bucle ya que encontramos nuestro article_wrapper
            }
            target = target.parentNode; // Si no es el article_wrapper, subimos un nivel en el DOM
        }
    });
    document.getElementById('input_search').addEventListener('input', function (e) {
        const textoBusqueda = e.target.value;
        fetch(`./php/procesar_mis_articulos.php?busqueda=${encodeURIComponent(textoBusqueda)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const container_articles = document.querySelector('.container_articles');
                    container_articles.innerHTML = ''; // Limpia los artículos actuales
                    pintarArticulos(data.articulos); // Pinta los artículos filtrados
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
    document.querySelector('#icono_editar_articulos').addEventListener('click', function () {
        window.location.href = 'http://localhost/stay/editar_articulos.php';
    })
});
function cargarMisArticulos() {
    fetch('./php/procesar_mis_articulos.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container_articles = document.querySelector('.container_articles');
                container_articles.innerHTML = ''; // Limpia los artículos actuales
                pintarArticulos(data.articulos); // Pinta los artículos
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
function pintarArticulos(articulos) {
    // Primero seleccionamos el container de los articulos
    const container_articles = document.querySelector('.container_articles');

    for (let i = 0; i < articulos.length; i++) {
        let articulo = articulos[i];
        // Creamos wrapper articulo
        let article_wrapper = document.createElement('div');
        article_wrapper.className = 'article_wrapper'
        article_wrapper.dataset.idArticulo = `${articulo.id_articulo}`;
        article_wrapper.dataset.idPsicologo = `${articulo.id_psicologo}`;

        // Creamos article_image
        let article_image = document.createElement('div');

        // Cambiamos propiedades css pertinentes
        article_image.className = 'article_image';
        article_image.style.background = `url('${articulo.img_articulo}') no-repeat center / cover`;

        // Creamos article_brief
        let article_brief = document.createElement('div');

        // Cambiamos propiedades css pertinentes
        article_brief.className = 'article_brief';

        // Crear el elemento <h2> para el título del artículo
        let tituloArticulo = document.createElement('h2');
        tituloArticulo.className = 'titulo_articulo';
        tituloArticulo.textContent = articulo.titulo_articulo; // Asume que articulo.titulo_articulo es una cadena de texto

        // Crear el elemento <p> para la descripción del artículo
        let descripcionArticulo = document.createElement('p');
        descripcionArticulo.className = 'resumen_articulo';
        descripcionArticulo.textContent = articulo.descripcion_articulo; // Asume que articulo.descripcion_articulo es una cadena de texto

        // Añadir el título y la descripción al div article_brief
        article_brief.appendChild(tituloArticulo);
        article_brief.appendChild(descripcionArticulo);

        // Anidamos article_image y article_brief en article_wrapper
        article_wrapper.appendChild(article_image);
        article_wrapper.appendChild(article_brief);

        // Anidamos article_wrapper en container_articles
        container_articles.appendChild(article_wrapper);

    }
    ajustarEstilosArticulos();

}
function ajustarEstilosArticulos() {
    // Asumiendo que articulos es accesible en este contexto
    const articulos = document.querySelectorAll('.article_wrapper');
    articulos.forEach((article_wrapper, i) => {
        // Restablece los estilos predeterminados o elimina los estilos dinámicos aquí si es necesario
        const article_image = article_wrapper.querySelector('.article_image');
        const article_brief = article_wrapper.querySelector('.article_brief');

        if (window.innerWidth > 426) {
            if (i % 2 == 0) {
                article_wrapper.style.flexDirection = 'row';

            } else {
                article_wrapper.style.flexDirection = 'row-reverse';
            }
        } else {
            article_wrapper.style.flexDirection = 'column';
        }
    });
}