document.addEventListener('DOMContentLoaded', function () {
  const mobileMenu = document.getElementById('mobile-menu');
  const navMenu = document.querySelector('nav ul');

  mobileMenu.addEventListener('click', function () {
    navMenu.classList.toggle('show');
  });
});
// Objeto que contiene los formularios asociados a identificadores únicos
const forms = {
   "form-login": document.getElementById("form-login"),
   "form-signup": document.getElementById("form-signup"),
};

forms["form-login"].addEventListener("submit", function (event) {
   // Previene que se envíe directamente
   event.preventDefault();
   clearErroresLogin();
   // Valida el formulario
   if (validacionLogin()) {
      procesarFormLogin(forms["form-login"]);
   } else {
      return;
   }
});

forms["form-signup"].addEventListener("submit", function (event) {
   event.preventDefault();
   clearErroresSignup();
   if (validacionSignup()) {
      procesarFormRegistro(forms["form-signup"]);
   } else {
      return;
   }
});
function clearErroresLogin() {
   // Recojo span de error
   const errorCorreoLogin = document.querySelector("#error-correo-login");
   const errorContrasenaLogin = document.querySelector("#error-contrasena-login");
   errorCorreoLogin.textContent = "";
   errorCorreoLogin.style.marginTop = "initial";
   errorCorreoLogin.style.marginBottom = "initial";
   errorCorreoLogin.style.display = "initial";
   document.getElementById("email").style.border = "1px solid black";
   errorContrasenaLogin.textContent = "";
   errorContrasenaLogin.style.marginTop = "initial";
   errorContrasenaLogin.style.marginBottom = "initial";
   errorContrasenaLogin.style.display = "initial";
   document.getElementById("password_login").style.border = "1px solid black";
}
function clearErroresSignup() {
   // Recojo los span de error
   const errorNombreSignup = document.getElementById("error-nombre-signup");
   const errorApellidosSignup = document.getElementById("error-apellidos-signup");
   const errorCorreoSignup = document.getElementById("error-correo-signup");

   // Recojo el <ul></ul> de error de la contraseña
   const errorContrasenaSignup = document.getElementById("error-contrasena-signup");

   // Limpiamos erroes nombre y apellidos
   errorNombreSignup.textContent = "";
   document.getElementById("nombre-signup").style.border = "1px solid black";
   errorApellidosSignup.textContent = "";
   document.getElementById("apellidos-signup").style.border = "1px solid black";

   // Limpiamos errores correo
   errorCorreoSignup.textContent = "";
   document.getElementById("correo-signup").style.border = "1px solid black";

   // Limpiamos errores contraseña
   errorContrasenaSignup.innerHTML = "";
   document.getElementById("contrasena-signup").style.border = "1px solid black";
}
function procesarFormRegistro(formulario) {
   const formData = new FormData(formulario);
   fetch('./php/procesar_registro.php', {
      method: 'POST',
      body: formData,
   })
      .then(response => response.json())
      .then(data => {
         // Añadimos o quitamos error en función de data.success
         mostrarErrorRegistro(data.success);
         // Si se produjo el registro redirigimos al login
         if (data.success) {
            document.querySelector(".popup-login").classList.add("active");
            document.querySelector(".popup-signup").classList.remove("active");
            // mostramos pop-up de éxito
            document.querySelector(".popup-message").style.display = "block";
            document.querySelector("#popup-text").textContent = "¡Registro exitoso!";
         }
      })
      .catch(error => console.error('Fetch error: ', error));
}
function mostrarErrorRegistro(flag) {
   const errorCorreoSignup = document.querySelector("#error-correo-signup");
   if (!flag) {
      errorCorreoSignup.textContent = "⛔ El correo introducido ya existe";
      errorCorreoSignup.style.display = "block";
      errorCorreoSignup.style.color = "red";
      errorCorreoSignup.style.marginTop = "-25px";
      document.getElementById("correo-signup").style.border = "2px solid red";
   } else {
      errorCorreoSignup.textContent = "";
      document.getElementById("correo-signup").style.border = "1px solid black";
   }
}

function procesarFormLogin(formulario) {
   const formData = new FormData(formulario);
   fetch('./php/procesar_login.php', {
      method: 'POST',
      body: formData,
   })
      .then(response => {
         return response.json()
      })
      .then(data => {
         if (!data.success) {
            mostrarErrorLogin(true, data.error);
         } else {
            window.location.href = "sesiones.php";
         }
      }).catch(error => console.error('Fetch error: ', error));
}
function mostrarErrorLogin(flag, error) {
   const errorCorreoLogin = document.querySelector("#error-correo-login");
   const errorContrasenaLogin = document.querySelector("#error-contrasena-login");
   if (flag) {
      if (error == "correo") {
         errorCorreoLogin.textContent = "⛔ El correo introducido no existe.";
         errorCorreoLogin.style.marginTop = "-18px";
         errorCorreoLogin.style.marginBottom = "5px";
         errorCorreoLogin.style.display = "block";
         errorCorreoLogin.style.color = "red";
         document.getElementById("email").style.border = "2px solid red";
      } else if (error == "contrasena") {
         errorContrasenaLogin.textContent = "⛔ La contraseña es incorrecta.";
         errorContrasenaLogin.style.marginTop = "-18px";
         errorContrasenaLogin.style.marginBottom = "5px";
         errorContrasenaLogin.style.display = "block";
         errorContrasenaLogin.style.color = "red";
         document.getElementById("password-login").style.border = "2px solid red";
      }
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
function validarContrasena(contrasena) {
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
   }
   return true;
}
function validacionSignup() {
   let flag = true;
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

   if (!nombreValid) {
      errorNombreSignup.textContent = "⛔ No se pueden introducir números";
      errorNombreSignup.style.display = "block";
      errorNombreSignup.style.marginTop = "-25px";
      errorNombreSignup.style.color = "red";
      document.getElementById("nombre-signup").style.border = "2px solid red";
      flag = false;
   }
   if (!apellidosValid) {
      errorApellidosSignup.textContent = "⛔ No se pueden introducir números";
      errorApellidosSignup.style.display = "block";
      errorApellidosSignup.style.marginTop = "-25px";
      errorApellidosSignup.style.color = "red";
      document.getElementById("apellidos-signup").style.border = "2px solid red";
      flag = false;
   }

   if (!correoValid) {
      errorCorreoSignup.textContent = "⛔ Introduce un correo válido";
      errorCorreoSignup.style.display = "block";
      errorCorreoSignup.style.color = "red";
      errorCorreoSignup.style.marginTop = "-25px";
      document.getElementById("correo-signup").style.border = "2px solid red";
      flag = false;
   }

   if (!contrasenaValid) {
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
      flag = false;
   }
   return flag;

}
// formulario login
document.querySelector("#log-bttn").addEventListener("click", function () {
   document.querySelector(".popup-login").classList.add("active");
   document.querySelector(".popup-signup").classList.remove("active");
});

document.querySelector(".popup-login .close-bttn").addEventListener("click", function () {
   document.querySelector(".popup-login").classList.remove("active");
});

document.querySelector("#registrate").addEventListener("click", function (event) {
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
document.querySelector("#accedeSignup").addEventListener("click", function (event) {
   event.preventDefault();
   document.querySelector(".popup-login").classList.add("active");
   document.querySelector(".popup-signup").classList.remove("active");
});
document.querySelector("#visibleSignup").addEventListener("click", function () {

   if (this.textContent == "visibility_off") {
      this.textContent = "visibility";
      document.querySelector("#contrasena-signup").type = "password";
   } else {
      this.textContent = "visibility_off";
      document.querySelector("#contrasena-signup").type = "text";

   }
});
document.querySelector("#visibleLogin").addEventListener("click", function () {

   if (this.textContent == "visibility_off") {
      this.textContent = "visibility";
      document.querySelector("#password_login").type = "password";
   } else {
      this.textContent = "visibility_off";
      document.querySelector("#password_login").type = "text";

   }
});

// POP-UP MESSAGE
document.addEventListener('DOMContentLoaded', function () {
   var popupMessage = document.querySelector('.popup-message');
   var closeButton = document.querySelector('.popup-message .close-popup-message');

   closeButton.addEventListener('click', function () {
      popupMessage.style.display = 'none';
   });

   // Optionally, you can add a delay for the popup to appear
   // setTimeout(function() {
   //   popupMessage.style.display = 'block';
   // }, 2000); // 2000 milliseconds delay (2 seconds)
});



// swiper
let swiperCards = new Swiper('.card__content', {
   loop: true,
   spaceBetween: 32,
   grabCursor: true,

   pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true,
   },

   navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
   },

   breakpoints: {
      600: {
         slidesPerView: 2,
      },
      968: {
         slidesPerView: 3,
      },
   },
});