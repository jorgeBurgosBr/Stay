document.addEventListener('DOMContentLoaded', function () {
    setEventListeners();
});

function setEventListeners() {
    const mic = document.querySelector('.mic');
    const camera = document.querySelector('.camera');
    const call = document.querySelector('.call');
    const settings = document.querySelector('.setting');
    const fullscreen = document.querySelector('.fullscreen');
    let camera_section = document.querySelectorAll('.camera_section');

    mic.addEventListener('click', function () {
        mic.textContent = (mic.textContent == 'mic') ? 'mic_off' : 'mic';
    });
    camera.addEventListener('click', function () {
        camera.textContent = (camera.textContent == 'videocam') ? 'videocam_off' : 'videocam';
    });
    call.addEventListener('click', function () {
        if (call.textContent == 'call') {
            call.style.color = 'crimson';
            call.textContent = 'phone_disabled';
            camera_section[0].style.background = `#F5F5F5 url(http://localhost/stay/img/loading2.gif) center / 30px 30px no-repeat`;
            camera_section[1].style.background = `#F5F5F5`;
            ponerFoto(camera_section[1]);
        } else {
            call.style.color = 'green';
            call.textContent = 'call';
            camera_section[0].style.background = `url(http://localhost/stay/svg/camera_section.svg) center / cover no-repeat`;
            camera_section[1].style.background = `url(http://localhost/stay/svg/camera_section.svg) center / cover no-repeat`;
            if (document.querySelector('.foto_perfil') != null) {
                document.querySelector('.foto_perfil').remove();
            }
        }
    });
    fullscreen.addEventListener('click', function () {
        fullscreen.textContent = (fullscreen.textContent == 'fullscreen') ? 'fullscreen_exit' : 'fullscreen';
    });
}

function ponerFoto(div) {
    fetch('./php/procesar_videollamada.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let container = document.createElement('div');
                container.className = 'foto_perfil';
                let img = document.createElement('img');
                img.src = data.ruta;
                img.className = 'imagen-perfil';
                container.appendChild(img);
                div.appendChild(container);
            } else {
                console.log('No tienes fotos para este usuario');
            }
        })
        .catch(error => {
            console.error('Error al cargar la foto del usuario:', error);
        });
}