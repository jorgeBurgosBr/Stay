document.addEventListener('DOMContentLoaded', function () {
    setEventListeners();
});

function setEventListeners(){
    const mic = document.querySelector('.mic');
    const camera = document.querySelector('.camera');
    const call = document.querySelector('.call');
    const settings = document.querySelector('.setting');
    const fullscreen = document.querySelector('.fullscreen');

    mic.addEventListener('click', function(){
        mic.textContent = (mic.textContent == 'mic')? 'mic_off': 'mic';
    });
    camera.addEventListener('click', function(){
        camera.textContent = (camera.textContent == 'videocam')? 'videocam_off': 'videocam';
    });
    call.addEventListener('click', function(){
        // call.textContent = (call.textContent == 'call')? 'phone_disabled': 'call';
        if(call.textContent == 'call'){
            call.style.color = 'crimson';
            call.textContent = 'phone_disabled';
        } else{
            call.style.color = 'green';
            call.textContent = 'call';
        }
    });
    fullscreen.addEventListener('click', function(){
        fullscreen.textContent = (fullscreen.textContent == 'fullscreen')? 'fullscreen_exit': 'fullscreen';
    });
}