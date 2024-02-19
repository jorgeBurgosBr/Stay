// Espera a que el DOM se cargue completamente
document.addEventListener('DOMContentLoaded', function() {
    obtenerPerfilPaciente();
    actualizarInformacion();
});

// Función para obtener el perfil del paciente
function obtenerPerfilPaciente() {
   // Realiza una solicitud fetch al archivo PHP que procesa la información del usuario
   fetch('./php/procesar_usuario.php', {
       method: 'POST',
       headers: {
           'Content-Type': 'application/json',
       },
       body: JSON.stringify({ id_paciente: 1 }),
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

       // Obtiene referencias a los elementos HTML con los IDs 'user-name' y 'user-mail'
       const nombreSpan = document.getElementById('user-name');
       const correoSpan = document.getElementById('user-mail');
       const rolSpan = document.getElementById('user-role');

       // Verifica si la respuesta del servidor fue exitosa y si los elementos HTML existen
       if (data.success && nombreSpan && correoSpan) {
           console.log('Actualizando spans:', nombreSpan, correoSpan);
           // Actualiza el contenido de los elementos con los datos del paciente
           nombreSpan.textContent = data.nombre;
           correoSpan.textContent = data.correo;
           rolSpan.textContent = "Paciente";
       } else {
           // Muestra un mensaje de error si no se encontraron elementos o la respuesta fue incorrecta
           console.error('No se encontraron los elementos con los IDs proporcionados o la respuesta fue incorrecta.');
       }
   })
   .catch(error => console.error('Fetch error: ', error));
}


function actualizarInformacion() {
   // Obtener el formulario y crear un objeto FormData
   const formulario = document.getElementById('user-form-info');
   const formData = new FormData(formulario);

   // Realizar la solicitud fetch
   fetch('./php/procesar_info_usuario.php', {
       method: 'POST',
       body: formData,
   })
   .then(response => {
       if (!response.ok) {
           throw new Error('Network response was not ok');
       }
       return response.json();
   })
   .then(data => {
       // Procesar la respuesta JSON
       console.log(data);

       // Actualizar los campos del formulario con la información del servidor
       document.getElementById('hobbies').value = data.hobbies;
       document.getElementById('job').value = data.job;
       document.getElementById('studies').value = data.studies;
      document.getElementById('expectations').value = data.expectations;
      document.getElementById('gender').value = data.gender;

       // Si la actualización fue exitosa, muestra un alert
       if (data.success) {
           alert('Actualización exitosa');
       } else {
           alert('Error en la actualización');
       }
   })
   .catch(error => {
       // Capturar errores y pausar la ejecución
       console.error('Fetch error: ', error);
       alert('Error en la solicitud');
   });

   return false;
}


