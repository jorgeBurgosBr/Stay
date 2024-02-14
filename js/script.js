// Objeto que contiene los formularios asociados a identificadores únicos
const forms = {
   "form-login": document.getElementById("form-login"),
   "form-signup": document.getElementById("form-signup"),
};

forms["form-login"].addEventListener("submit", function (event) {
   // Previene que se envíe directamente
   event.preventDefault();
   // Valida el formulario
   if (validacionLogin()) {
      enviarFormularioPorAjax(forms["form-login"]);
   } else {
      return;
   }
});

forms["form-signup"].addEventListener("submit", function(event){
   event.preventDefault();
   if(validacionSignup()){
      enviarFormularioPorAjax(forms["form-signup"]);
   }else{
      return;
   }
});

function enviarFormularioPorAjax(formulario) {
   // Recolecta los datos del formulario
   const formData = new FormData(formulario);
    // Determina la URL a la que enviar los datos según el formulario
    let url = '';
    if (formulario.id === 'form-contacto') {
        url = 'php/procesar_contacto.php';
    } else if (formulario.id === 'form-login') {
        url = 'php/procesar_login.php';
    } else if (formulario.id === 'form-signup') {
        url = 'php/procesar_registro.php';
    }

    // Inicia una nueva solicitud AJAX
   const xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);

    // Define el comportamiento cuando la solicitud AJAX se complete
   xhr.onload = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            // Convertir la respuesta del servidor a JSON
            // console.log(xhr.responseText);
            var data = JSON.parse(xhr.responseText);
            console.log(data);
            if (data == "exito registro") {
               alert("Registrado con éxito");
            } else if (data == "exito login") {
               // alert("sesión iniciada");
               location.href = "sesiones.php";
            } else {
               // Mostrar errores en el formulario
               mostrarErrores(data);
            }
         } else {
            console.error("Error al procesar la solicitud: " + xhr.status);
         }
      }
   };

   // Envía la solicitud con los datos del formulario mediante AJAX
   xhr.send(formData);
}

function mostrarErrores(errores) {
   // Limpiar mensajes de error previos
   var mensajesError = document.querySelectorAll(".mensaje-error");
   mensajesError.forEach(function (elemento) {
      elemento.textContent = "";
   });
   // Mostrar mensajes de error en los campos correspondientes
   if (errores.telefono) {
      var mensajeErrorTelefono = document.getElementById(
         "mensaje-error-telefono"
      );
      mensajeErrorTelefono.textContent = errores.telefono;
   }
   if (errores.correo) {
      var mensajeErrorCorreo = document.getElementById("mensaje-error-correo");
      mensajeErrorCorreo.textContent = errores.correo;
   }
   if (errores.contraseña) {
      var mensajeErrorCorreo = document.getElementById("mensaje-error-correo");
      mensajeErrorCorreo.textContent = errores.correo;
   }
}
function validarNombre(nombre) {
   return /\d/.test(nombre.value) ? false : true;
}
function validarTelefono(telefono) {
   return /^\d{9}$/.test(telefono.value);
}
function validarCorreo(correo) {
   return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo.value);
}
function validarContrasena(contrasena){
   // Password must contain at least one uppercase letter, one lowercase letter, one digit, and be at least 8 characters long
   return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(contrasena.value);
}
function validacionContacto(event) {
   // Evito que se envíe
   event.preventDefault();

   // recojo la validación de cada campo del formulario
   let nombreValid = validarNombre(document.getElementById("nombre"));
   let telefonoValid = validarTelefono(document.getElementById("telefono"));
   let correoValid = validarCorreo(document.getElementById("correo"));

   // Recojo los span donde irán los errores
   const errorNombreContacto = document.getElementById("error-nombre-contacto");
   const errorTelContacto = document.getElementById("error-telefono-contacto");
   const errorCorreoContacto = document.getElementById("error-correo-contacto");

   // En función de si se ha validado añado errores
   if (!nombreValid) {
      errorNombreContacto.textContent = "⛔ No se pueden introducir números";
      errorNombreContacto.style.display = "block";
      errorNombreContacto.style.color = "red";
      document.getElementById("nombre").style.border = "2px solid red";
   } else {
      errorNombreContacto.textContent = "";
      document.getElementById("nombre").style.border = "1px solid black";
   }

   if (!telefonoValid) {
      errorTelContacto.textContent = "⛔ Introduce 9 números";
      errorTelContacto.style.display = "block";
      errorTelContacto.style.color = "red";
      document.getElementById("telefono").style.border = "2px solid red";
   } else {
      errorTelContacto.textContent = "";
      document.getElementById("telefono").style.border = "1px solid black";
   }

   if (!correoValid) {
      errorCorreoContacto.textContent = "⛔ Introduce un correo electrónico válido";
      errorCorreoContacto.style.display = "block";
      errorCorreoContacto.style.color = "red";
      document.getElementById("correo").style.border = "2px solid red";
   } else {
      errorCorreoContacto.textContent = "";
      document.getElementById("correo").style.border = "1px solid black";
   }

   // Only submit the form if all input fields are valid
   if (nombreValid && telefonoValid && correoValid) {
      document.getElementById("form-contacto").submit();
   }
}
function validacionLogin() {

   // Recojo campos validados
   let correoValid = validarCorreo(document.getElementById("email"));

   // Recojo span de error
   const errorCorreoLogin = document.getElementById("error-correo-login");

   if (!correoValid) {
      errorCorreoLogin.textContent = "⛔ Introduce un correo electrónico válido";
      errorCorreoLogin.style.marginTop = "-18px";
      errorCorreoLogin.style.marginBottom = "5px";
      errorCorreoLogin.style.display = "block";
      errorCorreoLogin.style.color = "red";
      document.getElementById("email").style.border = "2px solid red";
      return false;
   } else {
      errorCorreoLogin.textContent = "";
      document.getElementById("email").style.border = "1px solid black";
      return true;
   }
}
function validacionSignup() {
   // Recojo los campos validados
   let nombreValid = validarNombre(document.getElementById("nombre-signup"));
   let apellidosValid = validarNombre(document.getElementById("apellidos-signup"));
   let correoValid = validarCorreo(document.getElementById("correo-signup"));
   let contrasenaValid = validarContrasena(document.getElementById("contrasena-signup"));

   // Recojo los span de error
   const errorNombreSignup = document.getElementById("error-nombre-signup");
   const errorApellidosSignup = document.getElementById("error-apellidos-signup");
   const errorCorreoSignup = document.getElementById("error-correo-signup");

   // Recojo el <ul></ul> de error de la contraseña
   const errorContrasenaSignup = document.getElementById("error-contrasena-signup");

   if(!nombreValid){
      errorNombreSignup.textContent = "⛔ No se pueden introducir números";
      errorNombreSignup.style.display = "block";
      errorNombreSignup.style.marginTop = "-25px";
      errorNombreSignup.style.color = "red";
      document.getElementById("nombre-signup").style.border = "2px solid red";
   } else{
      errorNombreSignup.textContent = "";
      document.getElementById("nombre-signup").style.border = "1px solid black";
   }

   if(!apellidosValid){
      errorApellidosSignup.textContent = "⛔ No se pueden introducir números";
      errorApellidosSignup.style.display = "block";
      errorApellidosSignup.style.marginTop = "-25px";
      errorApellidosSignup.style.color = "red";
      document.getElementById("apellidos-signup").style.border = "2px solid red";
   } else{
      errorApellidosSignup.textContent = "";
      document.getElementById("apellidos-signup").style.border = "1px solid black";
   }

   if(!correoValid){
      errorCorreoSignup.textContent = "⛔ Introduce un correo válido";
      errorCorreoSignup.style.display = "block";
      errorCorreoSignup.style.color = "red";
      errorCorreoSignup.style.marginTop = "-25px";
      document.getElementById("correo-signup").style.border = "2px solid red";
   } else{
      errorCorreoSignup.textContent = "";
      document.getElementById("correo-signup").style.border = "1px solid black";
   }

   if(!contrasenaValid){
      // Añadimos <li></li> con los mensajes de error
      errorContrasenaSignup.innerHTML = `
         <li id="tituloError">⛔ Debe contener al menos:</li>
         <li>- una letra mayúscula</li>
         <li>- una letra minúscula</li>
         <li>- un dígito</li>
         <li>- ocho caracteres de longitud</li>
      `;

      // Cambiamos el estilo del input "contrasena-signup"
      document.getElementById("contrasena-signup").style.border = "2px solid red";
   } else{
      errorContrasenaSignup.innerHTML = "";
      document.getElementById("contrasena-signup").style.border = "1px solid black";
   }
   
}
// formulario login
document.querySelector("#log-bttn").addEventListener("click", function () {
   document.querySelector(".popup-login").classList.add("active");
   document.querySelector(".popup-signup").classList.remove("active");
});

document.querySelector(".popup-login .close-bttn").addEventListener("click", function () {
   document.querySelector(".popup-login").classList.remove("active");
});

document.querySelector("#registrate").addEventListener("click", function(event){
   event.preventDefault();
   document.querySelector(".popup-signup").classList.add("active");
   document.querySelector(".popup-login").classList.remove("active");
});

// formulario signup
document.querySelector("#signup-bttn").addEventListener("click", function () {
   document.querySelector(".popup-signup").classList.add("active");
   document.querySelector(".popup-login").classList.remove("active");
});

document.querySelector(".popup-signup .close-bttn").addEventListener("click", function () {
   document.querySelector(".popup-signup").classList.remove("active");
});
document.querySelector("#accedeSignup").addEventListener("click", function(event){
   event.preventDefault();
   document.querySelector(".popup-login").classList.add("active");
   document.querySelector(".popup-signup").classList.remove("active");
});
document.querySelector("#visibleSignup").addEventListener("click", function(){
   
   if(this.textContent == "visibility_off"){
      this.textContent = "visibility";
      document.querySelector("#contrasena-signup").type = "password";
   }else{
      this.textContent = "visibility_off";
      document.querySelector("#contrasena-signup").type = "text";

   }
});
document.querySelector("#visibleLogin").addEventListener("click", function(){
   
   if(this.textContent == "visibility_off"){
      this.textContent = "visibility";
      document.querySelector("#password_login").type = "password";
   }else{
      this.textContent = "visibility_off";
      document.querySelector("#password_login").type = "text";

   }
});


// swiper
const swiper = new Swiper('.swiper', {
   // Optional parameters
   direction: 'vertical',
   loop: true,
 
   // If we need pagination
   pagination: {
     el: '.swiper-pagination',
   },
 
   // Navigation arrows
   navigation: {
     nextEl: '.swiper-button-next',
     prevEl: '.swiper-button-prev',
   },
 
   // And if we need scrollbar
   scrollbar: {
     el: '.swiper-scrollbar',
   },
 });