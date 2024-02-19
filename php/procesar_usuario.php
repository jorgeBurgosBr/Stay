<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');
   // echo "se ha conectado perfectamente";

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $respuesta = [
         'success' => false,
         'error' => null
      ];

      $id_paciente = 1;

      // Realizar la consulta para obtener el nombre y el correo del paciente
      $sql = mysqli_query($conn, "SELECT nombre_paciente, correo_paciente FROM paciente WHERE id_paciente = '$id_paciente'");
      $row = mysqli_fetch_assoc($sql);

      if ($row) {
         $respuesta['success'] = true;
         $respuesta['nombre'] = $row['nombre_paciente'];
         $respuesta['correo'] = $row['correo_paciente'];
      } else {
         $respuesta['error'] = 'Error al obtener la información del paciente';
      }

      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
}
?>