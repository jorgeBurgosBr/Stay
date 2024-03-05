<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="css/style_psico_user.css" />
   <link rel="icon" type="image/jpg" href="img/logo.png" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="http://localhost/stay/css/style_nav_footer.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
   <title>Stay</title>
</head>

<body>
   <!-- HEADER -->
   <header>
      <div class="container-nav">
         <div class="logo"></div>
         <div class="menu-toggle" id="mobile-menu">
            <img src="img/logo.png" alt="Logo" id="logo-nav" />
            <i class="ri-menu-line"></i>
         </div>
         <nav>
            <ul>
               <img src="img/logo.png" alt="Logo" id="logo-menu" />
               <li><a id="mi_perfil_nav">Mi perfil</a></li>
               <hr id="separacion">
               <li><a id="sesiones_nav">Sesiones</a></li>
               <hr id="separacion">
               <li><a id="psicologo_paciente_nav" class="current_page">
                     <?php
                     echo ($_SESSION['tipo_usuario'] == 'paciente') ? "Mi psicólogo" : "Mis pacientes";
                     ?>
                  </a></li>
               <hr id="separacion">
               <li><a id="articulos_nav">Artículos</a></li>
               <hr id="separacion">
               <li><a id="foro_nav">Foro</a></li>
               <hr id="separacion">
               <li><a id="talleres_nav">Talleres</a></li>
            </ul>
         </nav>
      </div>
   </header>
   <section>
      <div class="container-mi-psico">
         <div class="info-psico">
            <div class="psico-img"></div>
            <div class="datos-personales">
               <span class="nombre-psico"></span>
               <span class="correo-psico"></span>
            </div>
            <div class="datos-personales2">
               <span class="fecha-nacimiento"></span>
               <span class="telefono-psico"></span>
            </div>
         </div>
         <div class="sobre-mi">
            <h3>Sobre mi</h3>
            <span class="descripcion"></span>
         </div>
         <div class="experiencia-especialidad">
            <h3>Experiencia y especialidad</h3>
            <span class="experiencia">años de experiencia.</span>
            <span class="especialidad"></span>
         </div>

         <div class="estudios">
            <h3>Estudios superiores</h3>
            <span class="estudios-psico"></span>
         </div>
         <div class="hobbies">
            <h3>Hobbies</h3>
            <span class="hobbies-psico"></span>
         </div>
         <div class="bttns">
            <span class="material-symbols-outlined" id="icono_chat">
               chat
            </span>
            <button type="button" id="bttn-cambiar-psico">Cambiar de psicólogo</button>
         </div>
      </div>
   </section>
   <footer>
  <div class="footer-container">
    <div class="footer-column">
      <h3>Stay</h3>
      <p>Vive con esperanza</p>
      <p><i class="ri-facebook-fill"></i><i class="ri-twitter-fill"></i><i class="ri-instagram-fill"></i><i class="ri-linkedin-box-fill"></i></p>
    </div>
    <div class="footer-column">
      <h3>Quiénes somos</h3>
      <ul>
        <li><a href="#">Quiénes somos</a></li>
        <li><a href="#">Privacidad</a></li>
        <li><a href="#">Aviso legal</a></li>
        <li><a href="#">Testimonios</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h3>Otros</h3>
      <ul>
        <li><a href="#">Acerca de</a></li>
        <li><a href="#">Contacto</a></li>
        <li><a href="#">Trabaja con nosotros</a></li>
        <li><a href="#">Talleres</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h3>Soporte</h3>
      <ul>
        <li><a href="#">Chat soporte</a></li>
        <li><a href="#">Centro de ayuda</a></li>
        <li><a href="#">Reporta error</a></li>
        <li><a href="#">Cookies</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h3>Contáctanos</h3>
      <ul>
        <li><i class="ri-mail-line"></i> contacto@stay.com</li>
        <li><i class="ri-phone-line"></i> 662 223 154</li>
        <li><i class="ri-map-pin-line"></i> Calle Gran Vía, 77</li>
      </ul>
    </div>
</footer>
   <script src="js/script_user_psico.js"></script>
   <script src="http://localhost/stay/js/script_flujo.js"></script>
   <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>