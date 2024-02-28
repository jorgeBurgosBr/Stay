<?php
// session_start();
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

      // $id_psicologo = $_SESSION['id_psicologo'];
      $id_psicologo = 1;

      // Utilizando una sentencia preparada para evitar inyección SQL
      $sql = "SELECT p.nombre_psicologo, p.apellidos_psicologo, p.correo_psicologo, pp.foto_psicologo 
              FROM psicologo p
              INNER JOIN perfil_psicologo pp ON p.id_psicologo = pp.id_psicologo
              WHERE p.id_psicologo = ?";

      // Crear la sentencia preparada
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $id_psicologo);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);

      if ($row) {
         $respuesta['success'] = true;
         $respuesta['nombre'] = $row['nombre_psicologo'];
         $respuesta['apellidos'] = $row['apellidos_psicologo'];
         $respuesta['correo'] = $row['correo_psicologo'];
         $respuesta['photo'] = $row['foto_psicologo'];
      } else {
         $respuesta['error'] = 'Error al obtener la información del psicólogo';
      }

      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
}
?>
