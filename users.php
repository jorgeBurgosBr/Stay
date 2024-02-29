<?php
session_start();
require_once 'php/conecta.php';
$bd = new BaseDeDatos();
$bd->conectar();
$conn = $bd->getConexion();
$bd->seleccionarContexto('stay');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Realtime Chat App</title>
  <link rel="stylesheet" href="css/style_chat.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM psicologo WHERE id_psicologo = 1");
        if (mysqli_num_rows($sql) > 0) {
          $row = mysqli_fetch_assoc($sql);
        }
        ?>
        <div class="content">
          <!-- 
    <?php /* <img src="php/images/<?php echo $row['img'] ?>" alt="" /> */ ?>
-->
          <div class="details">
            <span><?php echo $row['nombre_psicologo'] . " " . $row['apellidos_psicologo'] ?></span>
            <!-- <p><?php /* echo $row['status']*/ ?></p> -->
          </div>
        </div>
      </header>
      <div class="search">
        <span class="text">Seleciona un paciente para empezar a hablar</span>
        <input type="text" placeholder="Introduce nombre para buscar..." />
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">

      </div>
    </section>
  </div>
  <script src="js/users.js"></script>
</body>

</html>