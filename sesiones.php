<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./css/style_nav_footer.css">
   <link rel="stylesheet" href="./css/sesiones_paciente.css">
   <title>Sesiones</title>
</head>

<body>
   <!-- HEADER -->
   <header>
      <div class="container-nav">
         <div class="logo"></div>
         <nav>
            <ul>
               <img src="img/logo.png" alt="Logo" />
               <li><a href="perfil_usuario.php">Mi perfil</a></li>
               <li><a href="#" id="current_page">Sesiones</a></li>
               <li><a href="#">Mi psicólogo</a></li>
               <li><a href="#">Artículos</a></li>
               <li><a href="#">Foro</a></li>
               <li><a href="#">Talleres</a></li>
            </ul>
         </nav>
      </div>
   </header>
   <div class="container_sesiones">
      <!-- LISTA SESIONES -->
      <div class="container_list_sesiones">
         <ul id="list_sesiones">
            <li>Ejemplo de sesion</li>
            <li>Ejemplo de sesion</li>
            <li>Ejemplo de sesion</li>
            <li>Ejemplo de sesion</li>
         </ul>
         <span class="material-symbols-outlined" id="icono_chat">
            chat
         </span>
      </div>
      <!-- CALENDARIO -->
      <div class="container_cal">
         <span class="material-symbols-outlined" id="mesAnterior">
            chevron_left
         </span>
         <div id="calendario">

         </div>
         <span class="material-symbols-outlined" id="mesSiguiente">
            chevron_right
         </span>
      </div>
   </div>

   <!-- FOOTER -->
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
   <script src="./js/sesiones_paciente.js"></script>
</body>

</html>