<?php
require_once 'php/creaBBDD.php'; //Incluir el fichero que se encarga de crear la BBDD y las tablas si no existen

session_start();
if (isset($_SESSION['id_paciente'])) { //if usuario se ha logeado ya 
  header("location: sesiones.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" type="image/jpg" href="img/logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
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
  <!-- HERO -->
  <section>
    <div class="container-titulo">
      <div class="titulo">
        <img src="img/paz.jpg" alt="Paz Mental" class="img-ppal">
        <div class="contenido-titulo">
          <h1>STAY - VIVE CON ESPERANZA</h1>
          <p>Descubre una nueva forma de encontrar esperanza y apoyo. No estás solo en este viaje.</p>
          <button class="bttn-titulo">Únete gratis</button>
        </div>
      </div>
    </div>
  </section>
  <section>
  <div class="psico-tittle">
      <h1>Psicólogos en nuestro equipo</h1>
  </div>
  <div class="container-psicologos">
  <div class="psico-card">
    <div class="green-part">
      <div class="photo">
        <img src="img/alba-psicologa.png" alt="Alba García">
      </div>
    </div>
    <div class="card-back">
        <h1 class="card-tittle">Alba</h1>
        <p class="card-info">5 años de experiencia.<br>Especialidad en niños y adolescentes.<br>Sesiones conjuntas con familiares.</p>
        <button class="card-btn">Sesión gratis</button>
    </div>
    <div class="info">
      <h2>Alba García</h2>
      <hr>
      <p>Máster en Terapia Cognitivo-Conductual</p>
    </div>
  </div>
  <div class="psico-card">
    <div class="green-part">
      <div class="photo">
        <img src="img/sigmund-psicologo.png" alt="Sigmund Freud">
      </div>
    </div>
    <div class="card-back">
        <h1 class="card-tittle">Sigmund</h1>
        <p class="card-info">12 años de experiencia.<br>Especialidad en entorno familiar.<br>Reconocido escritor de artículos para múltiples periódicos.</p>
        <button class="card-btn">Sesión gratis</button>
    </div>
    <div class="info">
      <h2>Sigmund Freud</h2>
      <hr>
      <p>Máster en Intervención Educativa y Psicológica</p>
    </div>
  </div>
  <div class="psico-card">
    <div class="green-part">
      <div class="photo">
        <img src="img/patricia-psicologo.png" alt="Patricia Fuentes">
      </div>
    </div>
    <div class="card-back">
        <h1 class="card-tittle">Patricia</h1>
        <p class="card-info">10 años de experiencia.<br>Especialidad en acoso y cyberbullying.<br>Imparte charlas en colegios e institutos a demanda.</p>
        <button class="card-btn">Sesión gratis</button>
    </div>
    <div class="info">
      <h2>Patricia Fuentes</h2>
      <hr>
      <p>Máster Oficial en Psicología Social</p>
    </div>
  </div>
</div>
  </section>

  <!-- Tarjetas de reseñas -->
 <section class="section-swiper">
 <div class="swiper container">
  <div class="swipper-wrapper content">
    <div class="swiper-slide card">
      <div class="card-content">
        <div class="quote-icon">
          <i class="fas fa-quote-right"></i>
        </div>
          <div class="rating-text">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id suscipit, quis beatae tempora provident ratione, ad laudantium modi libero pariatur ipsam at voluptates officiis impedit nam non dolorem cumque. Quis?</p>
          </div>
          <div class="user-name-rating">
            <span class="name">Mikasa Trovsky</span>
          </div>
          <div class="stars-icons">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
      </div>
    </div>

    <div class="swiper-slide card">
      <div class="card-content">
        <div class="quote-icon">
          <i class="fas fa-quote-right"></i>
        </div>
          <div class="rating-text">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id suscipit, quis beatae tempora provident ratione, ad laudantium modi libero pariatur ipsam at voluptates officiis impedit nam non dolorem cumque. Quis?</p>
          </div>
          <div class="user-name-rating">
            <span class="name">Mikasa Trovsky</span>
          </div>
          <div class="stars-icons">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="far fa-star"></i>
          </div>
      </div>
    </div>

    <div class="swiper-slide card">
      <div class="card-content">
        <div class="quote-icon">
          <i class="fas fa-quote-right"></i>
        </div>
          <div class="rating-text">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id suscipit, quis beatae tempora provident ratione, ad laudantium modi libero pariatur ipsam at voluptates officiis impedit nam non dolorem cumque. Quis?</p>
          </div>
          <div class="user-name-rating">
            <span class="name">Mikasa Trovsky</span>
          </div>
          <div class="stars-icons">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
      </div>
    </div>
  </div>
 </div>
 <div class="swiper-button-next"></div>
 <div class="swiper-button-prev"></div>
 <div class="swiper-pagination"></div>
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
      <form action="" id="form-contacto" method="post" onsubmit="return validacionContacto(event)">
        <div class="form-group">
          <label for="nombre" class="lbl-contact">Nombre completo:</label>
          <input name="nombre" type="text" id="nombre" placeholder="Introduce tu nombre" required />
          <span id="error-nombre-contacto"></span>
        </div>
        <div class="form-group">
          <label for="telefono" class="lbl-contact">Teléfono:</label>
          <input name="telefono" type="text" id="telefono" maxlength="9" placeholder="Introduce tu teléfono" required />
          <span id="error-telefono-contacto"></span>
        </div>
        <div class="form-group">
          <label for="correo" class="lbl-contact">Correo electrónico:</label>
          <input name="correo" type="text" id="correo" placeholder="Introduce tu correo" required />

          <span id="error-correo-contacto"></span>
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
    <!-- FORMULARIO DE LOG-IN -->
    <div class="popup-login">
      <div class="close-bttn">
        <i class="fa-solid fa-xmark fa-lg" style="color: #800020"></i>
      </div>
      <form class="form-login" id="form-login" action="" method="post">
        <h2>Iniciar sesión</h2>
        <div class="form-element">
          <label for="email">Correo:</label>
          <input type="text" name="correo" id="email" placeholder="Introduce tu correo" required />
          <span id="error-correo-login"></span>
        </div>
        <div class="form-element">
          <label for="password">Contraseña:</label>
          <div class="wrapper-pwd">
            <input type="password" name="password_login" id="password_login" placeholder="Introduce tu contraseña" required />
            <span class="material-symbols-outlined" id="visibleLogin">
              visibility
            </span>
          </div>
        </div>
        <div class="form-element">
          <input type="checkbox" id="recuerdame" />
          <label for="recuerdame">Recuérdame</label>
        </div>
        <div class="form-element">
          <div class="btn-container"><button type="submit">Iniciar sesión</button></div>
        </div>
        <div class="form-element">
          <div class="footer">
            <a href="#" class="enlaceFooter">¿Olvidaste tu contraseña?</a>
            <a href="#" class="enlaceFooter" id="registrate">Regístrate</a>
          </div>
        </div>
      </form>
    </div>
    <!-- FORMULARIO DE REGISTRO -->
    <div class="popup-signup active">
      <div class="close-bttn">
        <i class="fa-solid fa-xmark fa-lg" style="color: #800020"></i>
      </div>
      <form class="form-signup" id="form-signup" action="" method="post">
        <h2>Regístrate</h2>
        <div class="form-element">
          <label for="nombre">Nombre:</label>
          <input type="text" name="nombre" id="nombre-signup" placeholder="Introduce tu nombre" required />
          <span id="error-nombre-signup"></span>
        </div>
        <div class="form-element">
          <label for="apellidos_registro">Apellidos</label>
          <input type="text" id="apellidos-signup" name="apellidos" placeholder="Introduce tus apellidos" required>
          <span id="error-apellidos-signup"></span>
        </div>
        <div class="form-element">
          <label for="email-signup">Correo:</label>
          <input type="text" name="correo" id="correo-signup" placeholder="Introduce tu correo" required />
          <span id="error-correo-signup"></span>
        </div>
        <div class="form-element">
          <label for="password">Contraseña:</label>
            <div class="wrapper-pwd">
              <input type="password" name="password" id="contrasena-signup" placeholder="Introduce tu contraseña" required />
              <span class="material-symbols-outlined" id="visibleSignup">
              visibility
              </span>
            </div>
          <ul id="error-contrasena-signup"></ul>
        </div>
        <div class="form-element">
          <div class="btn-container"><button type="submit" id="signup-submit">ENVIAR</button></div>
        </div>
        <div class="form-element">
          <a href="#" id="accedeSignup">Accede</a>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>