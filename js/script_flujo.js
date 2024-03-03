document.addEventListener('DOMContentLoaded', function () {
    // Primero, obtenemos el <ul> del <nav>
    const ul = document.querySelector('nav ul');

    // Luego, agregamos un eventListener al <ul>
    ul.addEventListener('click', function (event) {
        // Verificamos si el elemento clicado es un <a> dentro de un <li>
        if (event.target.tagName === 'A' && event.target.closest('li')) {
            // Si es así, obtenemos el id del <a> clickeado
            let a_clicado = event.target.id;
            redirigir(a_clicado);

        }
    });

});
function redirigir(a_clicado) {
    datos = new FormData();
    datos.append('a_clicado', a_clicado);
    fetch('./php/procesar_flujo.php', {
        method: 'POST',
        body: datos
    })
        .then(response => {
            console.log(response);
            return response.json()
        })
        .then(data => {
            console.log(data);
            if (data.success) {
                switch (a_clicado) {
                    case 'mi_perfil_nav':
                        if (data.tipo_usuario == 'paciente') {
                            window.location.href = 'http://localhost/stay/perfil_usuario.php';
                        } else {
                            window.location.href = 'http://localhost/stay/perfil_psicologo.php';
                        }
                        break;
                    case 'sesiones_nav':
                        window.location.href = 'http://localhost/stay/sesiones.php';
                        break;
                    case 'psicologo_paciente_nav':
                        if (data.tipo_usuario == 'paciente') {
                            let url = (data.vacio) ? 'http://localhost/stay/elegir_psicologo.html' : 'http://localhost/stay/psicologo_usuario.php';
                            window.location.href = `${url}`;
                        } else {
                            let url = (data.vacio) ? 'http://localhost/stay/paciente_psico.html' : 'http://localhost/stay/paciente_psico.html';
                            window.location.href = `${url}`;
                        }
                        break;
                    case 'articulos_nav':
                        window.location.href = 'http://localhost/stay/articulos.php';
                        break;
                    case 'foro_nav':
                        if (data.tipo_usuario == 'paciente') {
                            window.location.href = 'http://localhost/stay/foro_paciente.html';
                        } else {
                            window.location.href = 'http://localhost/stay/foro_psicologo.html';
                        }
                        break;
                    case 'talleres_nav':
                        if (data.tipo_usuario == 'paciente') {
                            window.location.href = 'http://localhost/stay/talleres_paciente.html';
                        } else {
                            window.location.href = 'http://localhost/stay/talleres_psico.html';
                        }
                        break;

                    default:
                        break;
                }
            } else {
                console.log(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
}
