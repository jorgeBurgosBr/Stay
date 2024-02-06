<?php
require_once 'php/creaBBDD.php'; //Incluir el fichero que se encarga de crear la BBDD y las tablas si no existen

session_start();
if (isset($_SESSION['id_paciente'])) { //if usuario se ha logeado ya 
  header("location: sesiones.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" type="image/jpg" href="img/logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Stay</title>
</head>

<body>
  <header>
    <div class="container-nav">
      <div class="logo"></div>
      <nav>
        <ul>
          <img src="img/logo.png" alt="Logo" />
          <li><a href="#">Nosotros</a></li>
          <li><a href="#">Psicólogos</a></li>
          <li><a href="#">Testimonios</a></li>
          <li><a href="#">Contáctanos</a></li>
          <li><button id="log-bttn">Iniciar sesión</button></li>
          <li><button id="signup-bttn">Regístrate</button></li>
        </ul>
      </nav>
    </div>
  </header>
  <section>
    <div class="container-titulo">
      <div class="titulo">
        <img src="img/paz.jpg" alt="Paz Mental">
        <div class="contenido-titulo">
          <h1>STAY - VIVE CON ESPERANZA</h1>
          <p>Descubre una nueva forma de encontrar esperanza y apoyo. No estás solo en este viaje.</p>
          <button class="bttn-titulo">Únete gratis</button>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container-psicologos">
    </div>
  </section>
  <div class="contact-container">
    <div class="contact-info">
      <h2>Contáctanos si necesitas más ayuda.</h2>
      <p>
        Para nosotros, tu bienestar es lo más importante. Si necesitas más
        ayuda o alguien con quien hablar, por favor, completa el formulario.
        Estamos aquí para escucharte y apoyarte.
      </p>
      <p>
        Recibirás la respuesta de nuestro equipo en un máximo de 24 horas.
      </p>
    </div>
    <!--  FORMULARIO DE CONTACTO -->
    <div class="contact-form">
      <form action="php/procesar_contacto.php" id="form-contacto" method="post" onsubmit="return validacionContacto()">
        <div class="form-group">
          <label for="nombre" class="lbl-contact">Nombre completo:</label>
          <input name="nombre" type="text" id="nombre" placeholder="Introduce tu nombre" required />
          <span id="mensaje-error-nombre"></span>
        </div>
        <div class="form-group">
          <label for="telefono" class="lbl-contact">Teléfono:</label>
          <input name="telefono" type="text" id="telefono" maxlength="9" placeholder="Introduce tu teléfono" required />
          <span id="mensaje-error-telefono"></span>
        </div>
        <div class="form-group">
          <label for="correo" class="lbl-contact">Correo electrónico:</label>
          <input name="correo" type="text" id="correo" placeholder="Introduce tu correo" required />
          <span id="mensaje-error-correo"></span>
        </div>
        <div class="form-group">
          <label for="comentario" class="lbl-contact">Déjanos tu comentario:</label>
          <textarea name="comentario" id="comentario" cols="30" rows="6"></textarea>
        </div>
        <div class="buttons">
          <button type="submit">ENVIAR</button>
        </div>
      </form>
    </div>
    <!-- FORMULARIO DE LOGIN -->
    <div class="popup-login">
      <div class="close-bttn">
        <i class="fa-solid fa-xmark fa-lg" style="color: #800020"></i>
      </div>
      <form class="form-login" id="form-login" action="" method="post">
        <h2>Iniciar sesión</h2>
        <div class="form-element">
          <label for="email">Correo:</label>
          <input type="text" name="correo" id="email" placeholder="Introduce tu correo" />
          <span id="mensaje-error-correo-login"></span>
        </div>
        <div class="form-element">
          <label for="password">Contraseña:</label>
          <input type="password" name="password_login" id="password_login" placeholder="Introduce tu contraseña" required />
        </div>
        <div class="form-element">
          <input type="checkbox" id="recuerdame" />
          <label for="recuerdame">Recuérdame</label>
        </div>
        <div class="form-element">
          <button type="submit">Iniciar sesión</button>
        </div>
        <div class="form-element">
          <a href="#">He olvidado mi contraseña</a>
        </div>
      </form>
    </div>
    <!-- FORMULARIO DE SIGNUP -->
    <div class="popup-signup">
      <div class="close-bttn">
        <i class="fa-solid fa-xmark fa-lg" style="color: #800020"></i>
      </div>
      <form class="form-signup" id="form-signup" action="" method="post">
        <h2>Regístrate</h2>
        <div class="form-element">
          <label for="nombre">Nombre:</label>
          <input type="text" name="nombre" id="nombre-signup" placeholder="Introduce tu nombre" />
          <span id="mensaje-error-nombre-signup"></span>
        </div>
        <div class="form-element">
          <label for="apellidos_registro">Apellidos</label>
          <input type="text" id="apellidos-signup" placeholder="Introduce tus apellidos">
          <span id="mensaje-error-apellidos-signup"></span>
        </div>
        <div class="form-element">
          <label for="email-signup">Correo:</label>
          <input type="text" name="correo" id="email-signup" placeholder="Introduce tu correo" />
          <span id="mensaje-error-correo-signup"></span>
        </div>
        <div class="form-element">
          <label for="password">Contraseña:</label>
          <input type="password" name="password" id="password_signup" required placeholder="Introduce tu contraseña" />
        </div>
        <div class="form-element">
          <button type="submit" id="signup-submit">ENVIAR</button>
        </div>
      </form>
    </div>
  </div>
  <script src="js/script.js"></script>
</body>

</html>