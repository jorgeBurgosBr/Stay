document.addEventListener('DOMContentLoaded', function () {
   const mobileMenu = document.getElementById('mobile-menu');
   const navMenu = document.querySelector('nav ul');

   mobileMenu.addEventListener('click', function () {
       navMenu.classList.toggle('show');
   });

   document.querySelectorAll('.button').forEach(function (button) {
      button.addEventListener('click', function () {
         // Obtiene el ID del psicólogo al que se hizo clic

         var psicologoIdString = this.dataset.psicologoId;
         var psicologoId = parseInt(psicologoIdString, 10); // Convierte a entero con base 10
         console.log("Tipo de dato de psicologoId:", typeof psicologoId);
         console.log("Valor de psicologoId:", psicologoId);

         console.log("Datos a enviar:", { psicologoId: psicologoId });
         // Realiza la solicitud de inserción al servidor
         fetch('./php/procesar_eleccion_psico.php', {
            method: 'POST',
            headers: {
               'Content-Type': 'application/json',
            },
            body: JSON.stringify({ psicologoId: psicologoId }),
         })
         .then(response => {
            if (!response.ok) {
               throw new Error('Respuesta NO ok');
            }
            return response.json();
         })
         .then(data => {
            console.log(data);
            // Puedes realizar acciones adicionales según la respuesta del servidor
         })
         .catch(error => console.error('Fetch error: ', error));
      });
   });
   
});
