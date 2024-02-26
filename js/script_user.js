// Espera a que el DOM se cargue completamente
document.addEventListener('DOMContentLoaded', function() {
    obtenerPerfilPaciente();
    mostrarInformacion();
});

document.addEventListener('DOMContentLoaded', function () {
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.querySelector('nav ul');
  
    mobileMenu.addEventListener('click', function () {
      navMenu.classList.toggle('show');
    });
  });

// Función para obtener el perfil del paciente
function obtenerPerfilPaciente() {
   // Realiza una solicitud fetch al archivo PHP que procesa la información del usuario
   fetch('./php/procesar_usuario.php',{
    method: "GET"
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


function mostrarInformacion() {
   // Obtener el formulario y crear un objeto FormData
    const formData = new FormData(document.getElementById('user-form-info'));
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
       document.getElementById('birthdate').value = data.birthdate;
       document.getElementById('children').value = data.children;
       
        const genderSelect = document.getElementById('gender');
        const partnerYesRadio = document.getElementById('partner-yes');
        const partnerNoRadio = document.getElementById('partner-no');
    
           // Establecer la opción seleccionada basada en el valor del servidor
           for (let i = 0; i < genderSelect.options.length; i++) {
            if (genderSelect.options[i].value === data.gender) {
                genderSelect.options[i].selected = true;
                break;
            }
       }
       if (data.partner === '1' || data.partner === 1 || data.partner === true || data.partner === 'true') {
        partnerYesRadio.checked = true;
    } else if (data.partner === '0' || data.partner === 0 || data.partner === false || data.partner === 'false') {
        partnerNoRadio.checked = true;
    }
       
       // Si la actualización fue exitosa, muestra un alert
       if (data.success) {
        //    alert('Actualización exitosa');
        //    window.location.reload();
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

function actualizarInformacion() {
    // Obtener el formulario y crear un objeto FormData
    const formulario = document.getElementById('user-form-info');
     const formData = new FormData(formulario);
     formData.append('funcion', 'updateForm');
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
        document.getElementById('birthdate').value = data.birthdate;
        document.getElementById('children').value = data.children;
        
         const genderSelect = document.getElementById('gender');
         const partnerYesRadio = document.getElementById('partner-yes');
         const partnerNoRadio = document.getElementById('partner-no');
     
            // Establecer la opción seleccionada basada en el valor del servidor
            for (let i = 0; i < genderSelect.options.length; i++) {
             if (genderSelect.options[i].value === data.gender) {
                 genderSelect.options[i].selected = true;
                 break;
             }
        }
        if (data.partner === '1' || data.partner === 1 || data.partner === true || data.partner === 'true') {
         partnerYesRadio.checked = true;
     } else if (data.partner === '0' || data.partner === 0 || data.partner === false || data.partner === 'false') {
         partnerNoRadio.checked = true;
     }
        
        // Si la actualización fue exitosa, muestra un alert
        if (data.success) {
            // alert('Actualización exitosa');
            setTimeout(() => {
                window.location.reload();
            }, 0);

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


