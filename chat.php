<?php
session_start();
require_once 'php/conecta.php';
$id_psicologo = $_SESSION['id_paciente'];
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
  <div class="body">
    <div class="wrapper">
      <section class="chat-area">
        <div class="header">
          <?php
          if (isset($_GET['id_usuario'])) {
            $id_paciente = mysqli_real_escape_string($conn, $_GET['id_usuario']);
            $sql = mysqli_query($conn, "SELECT p.*, pp.* FROM paciente p JOIN perfil_paciente pp ON p.id_paciente = pp.id_paciente WHERE p.id_paciente = $id_paciente");
            if (mysqli_num_rows($sql) > 0) {
              $row = mysqli_fetch_assoc($sql);
            }
          } else {
            // Manejar el caso en el que 'user_id' no está presente en $_GET
            echo "Error: 'user_id' no está presente en la URL.";
          }
          ?>
          <a class="back-icon" href="users.php"><i class="fas fa-arrow-left"></i></a>
          <img src="<?php echo $row['foto_paciente'] ?>" alt="" />
          <div class="details">
            <span><?php echo $row['nombre_paciente'] . " " . $row['apellidos_paciente'] ?></span>
          </div>
        </div>
        <div class="chat-box">
        </div>
        <form action="#" class="typing-area">
          <input type="text" name="outgoing_id" value="<?php echo $id_psicologo; ?>" hidden>
          <input type="text" name="incoming_id" value="<?php echo $id_paciente; ?>" hidden>
          <input type="text" name="message" class="input-field" placeholder="Type a message here..." />
          <button><i class="fa-regular fa-paper-plane"></i></button>
        </form>
      </section>
    </div>
    <script src="js/chat.js"></script>
  </div>
</body>

</html>