<?php
session_start();
$output = "";
require_once 'conecta.php';
$bd = new BaseDeDatos();
$bd->conectar();
$conn = $bd->getConexion();
$bd->seleccionarContexto('stay');

if (isset($_GET['termino'])) {
   // Obtener el término de búsqueda y limpiarlo para evitar inyección de SQL
   $termino = htmlspecialchars($_GET['termino']);

   // Realizar la búsqueda en la base de datos
   $sql = "SELECT
U.tipo_usuario,
CASE
WHEN U.tipo_usuario = 'paciente' THEN PP.foto_paciente
WHEN U.tipo_usuario = 'psicologo' THEN PPS.foto_psicologo
END AS foto,
CASE
WHEN U.tipo_usuario = 'paciente' THEN P.nombre_paciente
WHEN U.tipo_usuario = 'psicologo' THEN PS.nombre_psicologo
END AS nombre,
CASE
WHEN U.tipo_usuario = 'paciente' THEN P.apellidos_paciente
WHEN U.tipo_usuario = 'psicologo' THEN PS.apellidos_psicologo
END AS apellidos,
F.titulo,
F.foto_contenido,
F.texto_contenido
FROM
FORO F
JOIN
USUARIO U ON F.id_publicante = U.id_usuario
LEFT JOIN
PACIENTE P ON U.tipo_usuario = 'paciente' AND U.id_original = P.id_paciente
LEFT JOIN
PSICOLOGO PS ON U.tipo_usuario = 'psicologo' AND U.id_original = PS.id_psicologo
LEFT JOIN
PERFIL_PACIENTE PP ON P.id_paciente = PP.id_paciente
LEFT JOIN
PERFIL_PSICOLOGO PPS ON PS.id_psicologo = PPS.id_psicologo
WHERE
F.titulo LIKE '%$termino%'";

   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      $resultados['success'] = true;

      while ($row = $result->fetch_assoc()) {
         $fila = [
            'nombre' => $row['nombre'],
            'apellidos' => $row['apellidos'],
            'img' => $row['foto'],
            'titulo' => $row['titulo'],
            'foto_contenido' => $row['foto_contenido'],
            'texto_contenido' => $row['texto_contenido']
         ];
         $resultados[] = $fila;
      }

      // Enviar la respuesta como JSON
      header('Content-Type: application/json');
      echo json_encode($resultados);
   } else {
      // Enviar un mensaje de error cuando no hay resultados
      $resultados['success'] = false;
      $resultados['error'] = "No hay hilos con ese título";
      // Enviar la respuesta como JSON
      header('Content-Type: application/json');
      echo json_encode($resultados);
   }
}
