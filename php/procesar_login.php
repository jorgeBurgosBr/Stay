<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');
   if ($_SERVER["REQUEST_METHOD"] == 'POST') {

      $respuesta = [
         "success" => false,
         "error" => null,
         "tipo" => null
      ];

      $correo = mysqli_real_escape_string($conn, $_POST['correo']);
      $password = mysqli_real_escape_string($conn, $_POST['password_login']);

      // Comprobamos si el correo es correcto
      $sql = mysqli_query($conn, "SELECT contrasena_usuario, id_original, tipo_usuario FROM usuario WHERE correo_usuario = '$correo'");
      if ($fila = mysqli_fetch_assoc($sql)) {
         // La función password_verify compara la contraseña ingresada con el hash almacenado
         if (password_verify($password, $fila['contrasena_usuario'])) {
            // La contraseña es correcta
            $respuesta["success"] = true;
            $respuesta["tipo"] = $fila['tipo_usuario'];

            // Alamacenamos el id en una sesión
            $_SESSION['id_usuario'] = $fila['id_original'];
            $_SESSION['tipo_usuario'] = $fila['tipo_usuario'];
         } else {
            // La contraseña es incorrecta
            $respuesta["error"] = "contrasena";
         }
      } else {
         // El correo no existe
         $respuesta["error"] = "correo";
      }
      if ($_SESSION['tipo_usuario'] == 'paciente') {
         // Verificar si el paciente tiene psicólogo
         $sql = "SELECT COUNT(*) as count_psico FROM paciente_psicologo WHERE id_paciente = ?";
         $stmt = mysqli_prepare($conn, $sql);
         mysqli_stmt_bind_param($stmt, "s", $_SESSION['id_usuario']);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         $row = mysqli_fetch_assoc($result);

         if ($row['count_psico'] == 0) {
            $respuesta['vacio'] = true;
            $respuesta['url'] = 'http://localhost/stay/sesiones_vacio.php';
         }
      } else {
         // Verificar si el psicólogo tiene citas
         $sql = "SELECT COUNT(*) as count_citas FROM cita WHERE id_psicologo = ?";
         $stmt = mysqli_prepare($conn, $sql);
         mysqli_stmt_bind_param($stmt, "s", $_SESSION['id_usuario']);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         $row = mysqli_fetch_assoc($result);

         if ($row['count_citas'] == 0) {
            $respuesta['vacio'] = true;
            $respuesta['url'] = 'http://localhost/stay/sesiones_vacio.php';
         }
      }


      // Enviamos respuesta
      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
}
