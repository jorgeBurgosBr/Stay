<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="css/style_user.css" />
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
               <li><a id="mi_perfil_nav" class="current_page">Mi perfil</a></li>
               <hr id="separacion">
               <li><a id="sesiones_nav">Sesiones</a></li>
               <hr id="separacion">
               <li><a id="psicologo_paciente_nav">
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
   <!-- HERO -->
   <div class="center-container">

      <div class="profile-container">
         <div class="profile-photo-container">
            <div class="profile-info">
               <div class="profile-img">

               </div>
               <div class="">
                  <label for="upload-btn" class="upload-btn-label">
                     <input type="file" id="upload-btn" style="display: none;">
                     Actualizar foto
                  </label>
               </div>
               <div class="info-user">
                  <span id="user-name"></span>
                  <span id="user-role"></span>
                  <span id="user-mail"></span>
               </div>
            </div>
         </div>

         <div class="form-container">
            <form method="post" id="user-form-info">
               <h1>INFORMACIÓN</h1>
               <hr>
               <div class="first-column-form">
                  <div class="column-container">
                     <label id="lbl-birthdate" for="birthdate">Fecha de nacimiento:</label>
                     <input type="date" name="birthdate" id="birthdate" pattern="\d{2}/\d{2}/\d{4}">
                  </div>

                  <div class="column-container">
                     <label id="lbl-gender" for="gender">Sexo:</label>
                     <select id="gender" name="gender">
                        <option value=""></option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                     </select>
                  </div>

                  <div class="column-container">
                     <label id="lbl-partner" for="partner">Pareja:</label>
                     <div class="partner-container">
                        <input type="radio" id="partner-yes" name="partner" value="yes">
                        <label for="partner-yes">Sí</label>
                        <input type="radio" id="partner-no" name="partner" value="no">
                        <label for="partner-no">No</label>
                     </div>
                  </div>

                  <div class="column-container">
                     <label id="lbl-children" for="children">Hijos:</label>
                     <input type="number" id="children" name="children" min="0">
                  </div>
               </div>

               <div class="second-column-form">
                  <div class="column-container-2">
                     <label for="hobbies">Hobbies:</label>
                     <textarea id="hobbies" name="hobbies" placeholder="Introduce tus hobbies"></textarea>
                  </div>

                  <div class="column-container-2">
                     <label for="job">Trabajo:</label>
                     <textarea id="job" name="job" placeholder="Introduce tu trabajo"></textarea>
                  </div>

                  <div class="column-container-2">
                     <label for="studies">Estudios:</label>
                     <textarea id="studies" name="studies" placeholder="Introduce tus estudios"></textarea>
                  </div>

                  <div class="column-container-2">
                     <label for="expectations">Expectativas o preocupaciones:</label>
                     <textarea id="expectations" name="expectations" placeholder="Introduce tus expectativas o preocupaciones"></textarea>
                  </div>
               </div>

               <div class="button-container">
                  <button type="button" class="bttn-titulo" onclick="actualizarInformacion()">Actualizar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   
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
   <script src="js/script_user.js"></script>
   <script src="http://localhost/stay/js/script_flujo.js"></script>
   <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>