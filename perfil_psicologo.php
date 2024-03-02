<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="css/style_psico.css" />
   <link rel="stylesheet" href="css/style_nav_footer.css" />
   <link rel="icon" type="image/jpg" href="img/logo.png" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
   <title>Stay</title>
</head>

<body>
   <header>
      <div class="container-nav">
         <div class="logo"></div>
         <div class="menu-toggle" id="mobile-menu">
      <img src="img/logo.png" alt="Logo" id="logo-nav"/>
      <i class="ri-menu-line"></i>
      </div>
         <nav>
            <ul>
               <img src="img/logo.png" alt="Logo" id="logo-menu"/>
               <li><a href="#" id="current_page">Mi perfil</a></li>
               <hr id="separacion">
               <li><a href="sesiones.php">Sesiones</a></li>
               <hr id="separacion">
               <li><a href="paciente_psico.html">Pacientes</a></li>
               <hr id="separacion">
               <li><a href="#">Artículos</a></li>
               <hr id="separacion">
               <li><a href="#">Foro</a></li>
               <hr id="separacion">
               <li><a href="#">Talleres</a></li>
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
               <span id="psico-name"></span>
               <span id="psico-role"></span>
               <span id="psico-mail"></span>
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
                     <textarea id="hobbies" name="hobbies" placeholder="introduce tus hobbies"></textarea>
                  </div>

                  <div class="column-container-2">
                     <label for="">Especialidad:</label>
                     <textarea id="especialidad" name="especialidad" placeholder="introduce tu especialidad"></textarea>
                  </div>

                  <div class="column-container-2">
                     <label for="studies">Estudios:</label>
                     <textarea id="studies" name="studies" placeholder="introduce tus estudios"></textarea>
                  </div>

                  <div class="column-container-2">
                     <label for="expectations">Sobre mi:</label>
                     <textarea id="sobremi" name="sobremi" placeholder="Cuenta algo sobre ti"></textarea>
                  </div>
               </div>

               <div class="button-container">
                  <button type="button" class="bttn-titulo" onclick="actualizarInformacion()">Actualizar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <script src="js/script_psico.js"></script>
</body>

</html>