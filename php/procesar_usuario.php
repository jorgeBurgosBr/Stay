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

      // Utilizando una sentencia preparada para evitar inyección SQL
      $sql = "SELECT p.nombre_paciente, p.apellidos_paciente, p.correo_paciente, pp.foto_paciente 
              FROM paciente p
              INNER JOIN perfil_paciente pp ON p.id_paciente = pp.id_paciente
              WHERE p.id_paciente = ?";

      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $id_paciente);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);

      if ($row) {
         $respuesta['success'] = true;
         $respuesta['nombre'] = $row['nombre_paciente'];
         $respuesta['apellidos'] = $row['apellidos_paciente'];
         $respuesta['correo'] = $row['correo_paciente'];
         $respuesta['photo'] = $row['foto_paciente'];
      } else {
         $respuesta['error'] = 'Error al obtener la información del paciente';
      }

      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
}
?>
