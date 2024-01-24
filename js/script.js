function validacion() {
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
      alert('Enviado correctamente!!')
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
   }

   else { 
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
      alert('Sesión iniciada correctamente!!')
      return true
   }
}

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
function validacionSignUp() {
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
      alert('Registrado correctamente!!')
      return true
   }
}

function comprobarNombreSignUp() {
   const valor = document.getElementById('nombre_completo').value;
   const contieneNumeros = /^[0-9]/.test(valor);
   const bordeInput = document.getElementById('nombre_completo');
   const mensajeErrorNombre = document.getElementById('mensaje-error-nombre-signup');

   if (contieneNumeros) {
      mensajeErrorNombre.textContent = '⛔ No se pueden introducir números!';
      mensajeErrorNombre.style.display = 'block';
      mensajeErrorNombre.style.marginTop = '-25px';
      mensajeErrorNombre.style.color = 'red';
      bordeInput.style.border = '2px solid red';

      document.getElementById('nombre_completo').value = '';
   } else {
      document.getElementById('mensaje-error-nombre-signup').textContent = '';
      bordeInput.style.border = '2px solid black';
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