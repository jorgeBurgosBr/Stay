document.addEventListener('DOMContentLoaded', function() {
   const navButton = document.getElementById('mipsico_nav');
   navButton.addEventListener('click', function () {
       verificarPsicologoAsociado();
   });
});

function verificarPsicologoAsociado() {
   fetch('./php/procesar_usuario.php', {
       method: 'GET'
   })
   .then(response => {
       if (!response.ok) {
           throw new Error('Network response was not ok');
       }
       return response.json();
   })
       .then(data => {
       console.log(data)
       if (data.success) {
           if (data.tienePsicologoAsociado == true) {
               window.location.href = 'psicologo_usuario.php';
           } else {
               // El paciente no tiene un psicólogo asociado, redirigir a la página correspondiente
               window.location.href = 'elegir_psicologo.html';
           }
       } else {
           // Manejar el caso de error según tus necesidades
           console.log('Error al verificar el psicólogo asociado.');
       }
   })
   .catch(error => {
       // Manejar errores según tus necesidades
       console.error('Fetch error: ', error);
   });
}
