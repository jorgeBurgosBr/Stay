//formulario contacto, no te devuelve errores
//formulario signup, el único error que te puede devolver es que el correo ya exista
//formulario login, que el correo no exista en la bbdd o que si exista pero no coincida la contraseña

// Asigna un identificador único a cada formulario
const forms = {
   //  'form-contacto': document.getElementById('form-contacto'),
    'form-login': document.getElementById('form-login'),
    'form-signup': document.getElementById('form-signup')
};

// Adjunta un controlador de eventos de envío de formulario a cada formulario
for (let formId in forms) {
    forms[formId].addEventListener('submit', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente

        // Determina qué función de validación utilizar según el formulario
        switch (formId) {
            // case 'form-contacto':
            //     if (!validacionContacto()) {
            //         return;
            //     }
            //     break;
            case 'form-login':
                if (!validacionLogin()) {
                    return;
                }
                break;
            case 'form-signup':
                if (!validacionSignup()) {
                    return;
                }
                break;
            default:
                break;
        }

        // Si la validación pasa, envía el formulario mediante AJAX
        enviarFormularioPorAjax(document.getElementById(formId));
    });
}

function enviarFormularioPorAjax(formulario){
    // Recolecta los datos del formulario
    const formData = new FormData(formulario);

    // Determina la URL a la que enviar los datos según el formulario
    let url = '';
    if (formulario.id === 'form-contacto') {
        url = 'php/procesar_contacto.php';
    } else if (formulario.id === 'form-login') {
        url = 'p p';
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
            if (data == "exito registro") {
               alert("Registrado con éxito")
            } else if (data == "exito login") {
              location.href = "../sesiones.php";
            } else {
               // Mostrar errores en el formulario
               mostrarErrores(data);
            }
         } else {
            console.error('Error al procesar la solicitud: ' + xhr.status);
         }
      }
    };

    // Envía la solicitud con los datos del formulario mediante AJAX
    xhr.send(formData);
}


function mostrarErrores(errores) {
   // Limpiar mensajes de error previos
   var mensajesError = document.querySelectorAll(".mensaje-error");
   mensajesError.forEach(function(elemento) {
      elemento.textContent = "";
   });
   // Mostrar mensajes de error en los campos correspondientes
   if (errores.telefono) {
      var mensajeErrorTelefono = document.getElementById("mensaje-error-telefono");
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

function validacionContacto() {
   let error = false

   comprobarNombre()
   comprobarTelefono()
   comprobarCorreo()

   const mensajeErrorNombre = document.getElementById('mensaje-error-nombre')
   const mensajeErrorTel = document.getElementById('mensaje-error-telefono')
   const mensajeErrorCorreo = document.getElementById('mensaje-error-correo')
  
   if (mensajeErrorNombre.textContent) {
      error = true
   }
   if (mensajeErrorTel.textContent) { 
      error = true
   }
   if (mensajeErrorCorreo.textContent) { 
      error = true
   }
   // Si tiene algún error retorna false y si no lo tiene retornará true y enviará un alert
   if (error) {
      return false
   } else {
      // alert('Enviado correctamente!!')
      return true
   }
}
function validacionLogin() {
   let error = false

   comprobarCorreoLogin()

   const mensajeErrorCorreo = document.getElementById('mensaje-error-correo-login')

   if (mensajeErrorCorreo.textContent) { 
      error = true
   }

   // Si tiene algún error retorna false y si no lo tiene retornará true y enviará un alert
   if (error) {
      return false
   } else {
      // alert('Sesión iniciada correctamente!!')
      return true
   }
}
function validacionSignup() {
   let error = false

   comprobarNombreSignUp()
   comprobarCorreoSignUp()
   // comprobarUsuario()

   const mensajeErrorNombre = document.getElementById('mensaje-error-nombre-signup')
   // const mensajeErrorUser = document.getElementById('mensjae-error-user')
   // const mensajeErrorTel = document.getElementById('mensaje-error-telefono-signin')
   const mensajeErrorCorreo = document.getElementById('mensaje-error-correo-signup')
  
   if (mensajeErrorNombre.textContent) {
      error = true
   }
   
   // if (mensajeErrorTel.textContent) { 
   //    error = true
   // }

   if (mensajeErrorCorreo.textContent) { 
      error = true
   }

   // if (mensajeErrorUser.textContent) { 
   //    error = true
   // }

   // Si tiene algún error retorna false y si no lo tiene retornará true y enviará un alert
   if (error) {
      return false
   } else {
      // alert('Registrado correctamente!!')
      return true
   }
}

function comprobarNombre() { 
   const valor = document.getElementById('nombre').value
   const contieneNumeros = /^[0-9]/.test(valor)
   const bordeInput = document.getElementById('nombre')
   const mensajeErrorNombre = document.getElementById('mensaje-error-nombre')

   if (contieneNumeros) {
      mensajeErrorNombre.textContent = '⛔ No se pueden introducir números!'
      mensajeErrorNombre.style.display = 'block'
      mensajeErrorNombre.style.color = 'red'
      bordeInput.style.border = '2px solid red'
      document.getElementById('nombre').value = ''
   } else { 
      document.getElementById('mensaje-error-nombre').textContent = ''
      bordeInput.style.border = '2px solid black'
      bordeInput.style.backgroundColor = 'transparent'
   }
}

function comprobarTelefono() {
   const valor = document.getElementById('telefono').value
   const contieneNumeros = /^\d{9}$/.test(valor)
   const bordeInput = document.getElementById('telefono')
   const mensajeErrorTelefono = document.getElementById('mensaje-error-telefono')

   if (!contieneNumeros) { 
      mensajeErrorTelefono.textContent = '⛔ Introduce 9 números!'
      mensajeErrorTelefono.style.display = 'block'
      mensajeErrorTelefono.style.color = 'red'
      bordeInput.style.border = '2px solid red'
      document.getElementById('telefono').value = ''
   } else { 
      document.getElementById('mensaje-error-telefono').textContent = ''
      bordeInput.style.border = '2px solid black'
      bordeInput.style.backgroundColor = 'transparent'
   }
}

function comprobarCorreo() {
   const valor = document.getElementById('correo').value
   const bordeInput = document.getElementById('correo')
   const mensajeErrorCorreo = document.getElementById('mensaje-error-correo')
   // Expresión regular para validar el correo electrónico
   const expresionCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
   if (!expresionCorreo.test(valor)) {
      mensajeErrorCorreo.textContent = '⛔ Introduce un correo electrónico válido!'
      mensajeErrorCorreo.style.display = 'block'
      mensajeErrorCorreo.style.color = 'red'
      bordeInput.style.border = '2px solid red'
      document.getElementById('correo').value = ''
   } else {
      document.getElementById('mensaje-error-correo').textContent = ''
      bordeInput.style.border = '2px solid black'
   }
}

// Validación log-in
function comprobarCorreoLogin() {
   const valor = document.getElementById('email').value
   const bordeInput = document.getElementById('email')
   const mensajeErrorCorreo = document.getElementById('mensaje-error-correo-login')

   // Expresión regular para validar el correo electrónico
   const expresionCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

   if (!expresionCorreo.test(valor)) {
      mensajeErrorCorreo.textContent = '⛔ Introduce un correo electrónico válido!'
      mensajeErrorCorreo.style.marginTop = '-18px'
      mensajeErrorCorreo.style.marginBottom = '5px'
      mensajeErrorCorreo.style.display = 'block'
      mensajeErrorCorreo.style.color = 'red'
      bordeInput.style.border = '2px solid red'
      document.getElementById('email').value = ''
   } else {
      document.getElementById('mensaje-error-correo-login').textContent = ''
      bordeInput.style.border = '2px solid black'
   }
}

// Validación sign-in
function comprobarNombreSignUp() {
   // const valor = document.getElementById('nombre_completo').value;
   const nombre = document.getElementById('nombre-signup').value;
   const apellidos = document.getElementById('apellidos-signup').value;
   const expresionregex = /^[a-zA-ZÀ-ÿ\s']+$/u;
   const bordeInputNombre = document.getElementById('nombre-signup');
   const bordeInputApellidos = document.getElementById('apellidos-signup');
   const mensajeErrorNombre = document.getElementById('mensaje-error-nombre-signup');
   const mensajeErrorApellidos = document.getElementById('mensaje-error-apellidos-signup');
   
   // Comprobamos nombre
   if(!expresionregex.test(nombre)){
      mensajeErrorNombre.textContent = '⛔ No se pueden introducir números!';
      mensajeErrorNombre.style.display = 'block';
      mensajeErrorNombre.style.marginTop = '-25px';
      mensajeErrorNombre.style.color = 'red';
      bordeInputNombre.style.border = '2px solid red';
   }else{
      document.getElementById('mensaje-error-nombre-signup').textContent = '';
      bordeInputNombre.style.border = '2px solid black';
   }
   if(!expresionregex.test(apellidos)){
      mensajeErrorApellidos.textContent = '⛔ No se pueden introducir números!';
      mensajeErrorApellidos.style.display = 'block';
      mensajeErrorApellidos.style.marginTop = '-25px';
      mensajeErrorApellidos.style.color = 'red';
      bordeInputApellidos.style.border = '2px solid red';
   } else{
      document.getElementById('mensaje-error-apellidos-signup').textContent = '';
      bordeInputApellidos.style.border = '2px solid black';
   }
}

// function comprobarTelefonoSignUp() {

//    const valor = document.getElementById('phone').value
//    const contieneNumeros = /^\d{9}$/.test(valor)
//    const bordeInput = document.getElementById('phone')
//    const mensajeErrorTelefono = document.getElementById('mensaje-error-telefono-signup')

//    if (!contieneNumeros) { 

//       mensajeErrorTelefono.textContent = '⛔ Introduce 9 números!'
//       mensajeErrorTelefono.style.display = 'block'
//       mensajeErrorTelefono.style.marginTop = '-25px'
//       mensajeErrorTelefono.style.color = 'red'
//       bordeInput.style.border = '2px solid red'
//       document.getElementById('phone').value = ''
//    }

//    else { 
//       document.getElementById('mensaje-error-telefono-signup').textContent = ''
//       bordeInput.style.border = '2px solid black'
//       bordeInput.style.backgroundColor = 'transparent'
//    }
// }

function comprobarCorreoSignUp() {
   const valor = document.getElementById('email-signup').value;
   const bordeInput = document.getElementById('email-signup');
   const mensajeErrorCorreo = document.getElementById('mensaje-error-correo-signup');

   // Expresión regular para validar el correo electrónico
   const expresionCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

   if (!expresionCorreo.test(valor)) {
      mensajeErrorCorreo.textContent = '⛔ Introduce un correo válido!';
      mensajeErrorCorreo.style.display = 'block';
      mensajeErrorCorreo.style.color = 'red';
      mensajeErrorCorreo.style.marginTop = '-25px';
      bordeInput.style.border = '2px solid red';
      document.getElementById('email-signup').value = '';
   } else {
      document.getElementById('mensaje-error-correo-signup').textContent = '';
      bordeInput.style.border = '2px solid black';
   }
}

// formulario login
document.querySelector("#log-bttn").addEventListener("click", function () {
   document.querySelector(".popup-login").classList.add("active")
});

document.querySelector(".popup-login .close-bttn").addEventListener("click", function () {
   document.querySelector(".popup-login").classList.remove("active")
});

// formulario signup
document.querySelector("#signup-bttn").addEventListener("click", function () {
   document.querySelector(".popup-signup").classList.add("active")
});

document.querySelector(".popup-signup .close-bttn").addEventListener("click", function () {
   document.querySelector(".popup-signup").classList.remove("active")
});