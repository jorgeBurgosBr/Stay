document.addEventListener('DOMContentLoaded', function () {
    obtenerPerfilPsicologo();
});

document.querySelector('#icono_chat').addEventListener('click', function(){
    window.location.href = 'chat_paciente.php'
})

document.querySelector('#bttn-cambiar-psico').addEventListener('click', function () {
    window.location.href = 'elegir_psicologo.php'
})
 
// Función para obtener el perfil del psicólogo
function obtenerPerfilPsicologo() {
   // Realiza una solicitud fetch al archivo PHP que procesa la información del psicólogo
   
    fetch('./php/procesar_psicologo_usuario.php',{
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
        const photoPsico = document.querySelector('.info-psico');
        const nombrePsico = document.querySelector('.nombre-psico');
        const fechaNacimiento = document.querySelector('.fecha-nacimiento');
        const correoPsico = document.querySelector('.correo-psico');
        const telefonoPsico = document.querySelector('.telefono-psico');
        const descripcionPsico = document.querySelector('.descripcion');
        const experienciaPsico = document.querySelector('.experiencia');
        const especialidadPsico = document.querySelector('.especialidad');
        const estudiosPsico = document.querySelector('.estudios-psico');
        const hobbiesPsico = document.querySelector('.hobbies-psico');

        // Verifica si la respuesta del servidor fue exitosa y si los elementos HTML existen
        if (data.success) {

            const nombreCompleto = data.nombre + ' ' + data.apellidos;
            // Actualiza el contenido del elemento con el nombre completo del psicólogo
            nombrePsico.textContent = nombreCompleto; 
            correoPsico.textContent = data.correo;
            telefonoPsico.textContent = data.telefono;
            descripcionPsico.textContent = data.sobre_mi;
            experienciaPsico.innerHTML = data.experiencia + ' ' + experienciaPsico.innerHTML;
            especialidadPsico.innerHTML = especialidadPsico.innerHTML + ' ' + data.especialidad + '.';
            estudiosPsico.textContent = data.estudios;
            hobbiesPsico.textContent = data.hobbies;

            // Convierte la cadena de fecha a un objeto de fecha
            const fechaObjeto = new Date(data.fecha);
            // Obtiene los componentes de la fecha (día, mes, año)
            const dia = fechaObjeto.getDate();
            const mes = fechaObjeto.getMonth() + 1;
            const anio = fechaObjeto.getFullYear();
            const fechaFormateada = `${dia}-${mes}-${anio}`;
          
            // Actualiza el contenido del elemento con la fecha formateada
            fechaNacimiento.textContent = fechaFormateada;

    // Actualiza la imagen del perfil si existe
    if (data.foto_psico) {
        // Obtén una referencia al div con la clase "psico-img"
        const profileImgContainer = photoPsico.querySelector('.psico-img');

        // Crea un elemento de imagen y establece su atributo 'src'
        const profilePhoto = document.createElement('img');
        profilePhoto.src = data.foto_psico;

        // Agrega la imagen como hijo del div "psico-img"
        profileImgContainer.appendChild(profilePhoto);
    }
        } else {
            // Muestra un mensaje de error si no se encontraron elementos o la respuesta fue incorrecta
            console.error('No se encontraron los elementos con los IDs proporcionados o la respuesta fue incorrecta.');
        }

    })
    .catch(error => console.error('Fetch error: ', error));
}