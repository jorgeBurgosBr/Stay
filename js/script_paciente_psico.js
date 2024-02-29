document.addEventListener('DOMContentLoaded', () => {
   comprobarSiTienePacientes();
});
function comprobarSiTienePacientes() {
   fetch('./php/procesar_paciente_psico.php', {
      method: "GET"
   })
        .then(response => response.json())
      .then(data => {
         if (data.success) {
            alert("todo bien papi");   
       const imagen = document.getElementsByClassName('prueba');
           imagen.textContent = data.img;

               
            }
         })

}