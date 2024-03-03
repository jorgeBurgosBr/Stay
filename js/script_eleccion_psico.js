document.addEventListener('DOMContentLoaded', function () {
   obtenerPerfilPsicologos();

   const mobileMenu = document.getElementById('mobile-menu');
   const navMenu = document.querySelector('nav ul');

   mobileMenu.addEventListener('click', function () {
       navMenu.classList.toggle('show');
   });

   // Utilizaremos delegación de eventos para manejar clics en los botones
   document.addEventListener('click', function (event) {
       if (event.target.classList.contains('button')) {
           handleClick(event.target);
       }
   });
});

function obtenerPerfilPsicologos() {
   // Realiza una solicitud fetch al archivo PHP que procesa la información de los psicólogos
   fetch('./php/procesar_lista_psico.php', {
       method: "GET",
   })
   .then(response => {
       // Verifica si la respuesta de la red fue exitosa
       if (!response.ok) {
           throw new Error('Respuesta NO ok');
       }
       // Convierte la respuesta a formato JSON
       return response.json();
   })
   .then(data => {
       // Procesa la respuesta JSON
       console.log(data);

       // Obtiene una referencia al contenedor de psicólogos
       const listaPsicologos = document.querySelector('.psico-card-container');

       // Verifica si el contenedor de psicólogos existe
       if (listaPsicologos) {
           // Verifica si hay psicólogos en la respuesta
           if (data.psicologos && data.psicologos.length > 0) {
               // Itera sobre cada psicólogo y llama a la función mostrarPsicologo
               data.psicologos.forEach(psicologo => {
                   mostrarPsicologo(psicologo);
               });
           } else {
               console.error('No se encontraron psicólogos en la respuesta.');
           }
       } else {
           console.error('No se encontró el contenedor de psicólogos en el HTML.');
       }
   })
   .catch(error => console.error('Fetch error: ', error));
}

function mostrarPsicologo(psicologo) {
   // Crea un nuevo elemento div para cada psicólogo
   const nuevoPsicologo = document.createElement('div');
   nuevoPsicologo.classList.add('card');

   // Agrega la información del psicólogo al nuevo elemento div
   nuevoPsicologo.innerHTML = `
       <div class="info">
           <div class="photo-container">
               <img src="${psicologo.photo}" alt="Foto del psicólogo">
           </div>
       </div>
       <div class="info">
           <div class="name">${psicologo.nombre} ${psicologo.apellidos}</div>
           <div class="contact">${psicologo.correo}</div>
       </div>
       <div class="info">
           <div class="estudios">${psicologo.estudios}</div>
       </div>
       <div class="info">
           <div class="extra">
               <ul>
                   <li class="experiencia">${psicologo.experiencia} años de experiencia.</li>
                   <li class="especialidad">${psicologo.especialidad}</li>
               </ul>
           </div>
       </div>
       <div class="button-container">
           <button class="button" data-psicologo-id="${psicologo.id}">Elegir</button>
       </div>
   `;

   // Agrega el nuevo psicólogo al contenedor de psicólogos
   const listaPsicologos = document.querySelector('.psico-card-container');
   listaPsicologos.appendChild(nuevoPsicologo);
}

function handleClick(button) {
   var psicologoIdString = button.dataset.psicologoId;
   var psicologoId = parseInt(psicologoIdString, 10);

   console.log('Psicólogo ID:', psicologoId);

   fetch('./php/procesar_eleccion_psico.php', {
       method: 'POST',
       headers: {
           'Content-Type': 'application/x-www-form-urlencoded',
       },
       body: 'psicologoId=' + encodeURIComponent(psicologoId),
   })
   .then(response => {
       if (!response.ok) {
           throw new Error('Respuesta NO ok');
       }
       return response.json();
   })
   .then(data => {
       console.log(data);
       window.location.href = 'psicologo_usuario.php';
   })
   .catch(error => {
       console.error('Fetch error: ', error);
       alert('Error en la solicitud Fetch. Consulta la consola para más detalles.');
   });
}