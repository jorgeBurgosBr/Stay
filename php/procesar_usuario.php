<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');
   // echo "se ha conectado perfectamente";

   if ($_SERVER["REQUEST_METHOD"] == "GET") {
      $respuesta = [
          'success' => false,
          'error' => null
      ];
  
      $id_paciente = $_SESSION['id_paciente'];
  
      // Sentencia preparada para obtener nombre, apellidos y correo
      $sql_info_paciente = "SELECT p.nombre_paciente, p.apellidos_paciente, p.correo_paciente 
                            FROM paciente p
                            WHERE p.id_paciente = ?";
  
      $stmt_info_paciente = mysqli_prepare($conn, $sql_info_paciente);
      mysqli_stmt_bind_param($stmt_info_paciente, "s", $id_paciente);
      mysqli_stmt_execute($stmt_info_paciente);
      $result_info_paciente = mysqli_stmt_get_result($stmt_info_paciente);
      $row_info_paciente = mysqli_fetch_assoc($result_info_paciente);
  
      if ($row_info_paciente) {
          $respuesta['success'] = true;
          $respuesta['nombre'] = $row_info_paciente['nombre_paciente'];
          $respuesta['apellidos'] = $row_info_paciente['apellidos_paciente'];
          $respuesta['correo'] = $row_info_paciente['correo_paciente'];
  
          // Sentencia preparada para obtener la foto del paciente
          $sql_foto_paciente = "SELECT pp.foto_paciente 
                                FROM perfil_paciente pp
                                WHERE pp.id_paciente = ?";
  
          $stmt_foto_paciente = mysqli_prepare($conn, $sql_foto_paciente);
          mysqli_stmt_bind_param($stmt_foto_paciente, "s", $id_paciente);
          mysqli_stmt_execute($stmt_foto_paciente);
          $result_foto_paciente = mysqli_stmt_get_result($stmt_foto_paciente);
          $row_foto_paciente = mysqli_fetch_assoc($result_foto_paciente);
  
          // Verificar si se encontró la foto
          if ($row_foto_paciente) {
              $respuesta['photo'] = $row_foto_paciente['foto_paciente'];
          }
      } else {
          $respuesta['error'] = 'Error al obtener la información del paciente';
      }
  
      header('Content-Type: application/json');
      echo json_encode($respuesta);
  }
  
}
?>
