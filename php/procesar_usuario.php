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

      // Realizar la consulta para obtener el nombre y el correo del paciente
      $sql = mysqli_query($conn, "SELECT p.nombre_paciente, p.apellidos_paciente, p.correo_paciente, pp.foto_paciente 
                            FROM paciente p
                            INNER JOIN perfil_paciente pp ON p.id_paciente = pp.id_paciente
                            WHERE p.id_paciente = '$id_paciente'");
      $row = mysqli_fetch_assoc($sql);

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