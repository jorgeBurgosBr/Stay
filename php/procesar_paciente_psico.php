<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();
$id_psicologo = $_SESSION["id_paciente"];
// Conectar a la base de datos
if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');

   // Respuesta predeterminada
   $respuesta = [
      'success' => false,
      'error' => null,
   ];

   $sql = mysqli_query($conn, "SELECT p.*, pp.*
                              FROM 
                                 PACIENTE_PSICOLOGO ps
                              JOIN 
                                 PACIENTE p ON ps.id_paciente = p.id_paciente
                              JOIN 
                                 PERFIL_PACIENTE pp ON pp.id_paciente = p.id_paciente
                              WHERE 
                                 ps.id_psicologo = '$id_psicologo';
                              ");
   if (mysqli_num_rows($sql) > 0) {
      $row = mysqli_fetch_assoc($sql);
      $respuesta['success'] = true;
      $respuesta['nombre'] = $row['nombre_paciente'];
      $respuesta['apellidos'] = $row['apellidos_paciente'];
      $respuesta['img'] = $row['foto_paciente'];

      // Enviar la respuesta como JSON
      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
} else {
   // Error en la consulta SQL
   $respuesta['error'] = 'Error en la consulta SQL: ' . mysqli_error($conn);
}
