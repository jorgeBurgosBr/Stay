<?php
session_start();
require_once 'conecta.php';

$bd = new BaseDeDatos();

// Conectar a la base de datos
if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');

   // Respuesta predeterminada
   $respuesta = [];
   // Verificar si se recibieron los datos del formulario mediante POST
   $data = json_decode(file_get_contents("php://input"), true);
   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($data["id"])) {
      // ID de publicación obtenido de la URL (cambia esto según cómo obtengas el ID de la publicación)
      $id_publicacion_url = $data['id'];

      // Consulta preparada para obtener datos del FORO
      $stmt_foro = $conn->prepare("SELECT 
                                    F.titulo AS titulo_foro,
                                    F.foto_contenido AS foto_foro,
                                    F.texto_contenido AS contenido_foro,
                                    U_publicante.id_usuario AS id_publicante,
                                    U_publicante.tipo_usuario AS tipo_usuario_publicante,
                                    CASE
                                       WHEN U_publicante.tipo_usuario = 'paciente' THEN PP_publicante.foto_paciente
                                       WHEN U_publicante.tipo_usuario = 'psicologo' THEN PPS_publicante.foto_psicologo
                                    END AS foto_usuario_publicante,
                                    CASE
                                       WHEN U_publicante.tipo_usuario = 'paciente' THEN P_publicante.nombre_paciente
                                       WHEN U_publicante.tipo_usuario = 'psicologo' THEN PS_publicante.nombre_psicologo
                                    END AS nombre_usuario_publicante,
                                    CASE
                                       WHEN U_publicante.tipo_usuario = 'paciente' THEN P_publicante.apellidos_paciente
                                       WHEN U_publicante.tipo_usuario = 'psicologo' THEN PS_publicante.apellidos_psicologo
                                    END AS apellidos_usuario_publicante
                                 FROM 
                                    FORO F
                                 JOIN 
                                    USUARIO U_publicante ON F.id_publicante = U_publicante.id_usuario
                                 LEFT JOIN 
                                    PACIENTE P_publicante ON U_publicante.tipo_usuario = 'paciente' AND U_publicante.id_original = P_publicante.id_paciente
                                 LEFT JOIN 
                                    PSICOLOGO PS_publicante ON U_publicante.tipo_usuario = 'psicologo' AND U_publicante.id_original = PS_publicante.id_psicologo
                                 LEFT JOIN 
                                    PERFIL_PACIENTE PP_publicante ON P_publicante.id_paciente = PP_publicante.id_paciente
                                 LEFT JOIN 
                                    PERFIL_PSICOLOGO PPS_publicante ON PS_publicante.id_psicologo = PPS_publicante.id_psicologo
                                 WHERE 
                                    F.id_publicacion = ?");

      // Consulta preparada para obtener datos de los COMENTARIOS_FORO
      $stmt_comentarios = $conn->prepare("SELECT 
                                          CF.comentario,
                                          CF.fecha,
                                          U_comentario.id_usuario AS id_usuario_comentario,
                                          U_comentario.tipo_usuario AS tipo_usuario_comentario,
                                          CASE
                                             WHEN U_comentario.tipo_usuario = 'paciente' THEN PP_comentario.foto_paciente
                                             WHEN U_comentario.tipo_usuario = 'psicologo' THEN PPS_comentario.foto_psicologo
                                          END AS foto_usuario_comentario,
                                          CASE
                                             WHEN U_comentario.tipo_usuario = 'paciente' THEN P_comentario.nombre_paciente
                                             WHEN U_comentario.tipo_usuario = 'psicologo' THEN PS_comentario.nombre_psicologo
                                          END AS nombre_usuario_comentario,
                                          CASE
                                             WHEN U_comentario.tipo_usuario = 'paciente' THEN P_comentario.apellidos_paciente
                                             WHEN U_comentario.tipo_usuario = 'psicologo' THEN PS_comentario.apellidos_psicologo
                                          END AS apellidos_usuario_comentario
                                       FROM 
                                          COMENTARIOS_FORO CF
                                       JOIN 
                                          USUARIO U_comentario ON CF.id_usuario = U_comentario.id_usuario
                                       LEFT JOIN 
                                          PACIENTE P_comentario ON U_comentario.tipo_usuario = 'paciente' AND U_comentario.id_original = P_comentario.id_paciente
                                       LEFT JOIN 
                                          PSICOLOGO PS_comentario ON U_comentario.tipo_usuario = 'psicologo' AND U_comentario.id_original = PS_comentario.id_psicologo
                                       LEFT JOIN 
                                          PERFIL_PACIENTE PP_comentario ON P_comentario.id_paciente = PP_comentario.id_paciente
                                       LEFT JOIN 
                                          PERFIL_PSICOLOGO PPS_comentario ON PS_comentario.id_psicologo = PPS_comentario.id_psicologo
                                       WHERE 
                                          CF.id_publicacion = ?");

      // Vincular el parámetro de la consulta del FORO
      $stmt_foro->bind_param("i", $id_publicacion_url);

      // Vincular el parámetro de la consulta de los COMENTARIOS_FORO
      $stmt_comentarios->bind_param("i", $id_publicacion_url);

      // Ejecutar la consulta del FORO
      if ($stmt_foro->execute()) {
         $result_foro = $stmt_foro->get_result();

         if ($result_foro->num_rows > 0) {
            $respuesta['success'] = true;
            $respuesta['data'] = [];

            // Obtener datos del FORO
            while ($row_foro = $result_foro->fetch_assoc()) {
               $fila_foro = [
                  'nombre' => $row_foro['nombre_usuario_publicante'],
                  'apellidos' => $row_foro['apellidos_usuario_publicante'],
                  'img' => $row_foro['foto_usuario_publicante'],
                  'titulo' => $row_foro['titulo_foro'],
                  'foto_contenido' => $row_foro['foto_foro'],
                  'texto_contenido' => $row_foro['contenido_foro'],
                  'comentarios' => []
               ];

               // Agregar fila del FORO al array de resultados
               $respuesta['data'][] = $fila_foro;
            }

            // Ejecutar la consulta de los COMENTARIOS_FORO fuera del bucle while principal
            if ($stmt_comentarios->execute()) {
               $result_comentarios = $stmt_comentarios->get_result();

               // Obtener datos de los COMENTARIOS_FORO
               while ($row_comentario = $result_comentarios->fetch_assoc()) {
                  foreach ($respuesta['data'] as &$fila_foro) {
                     $fila_comentario = [
                        'nombre' => $row_comentario['nombre_usuario_comentario'],
                        'apellidos' => $row_comentario['apellidos_usuario_comentario'],
                        'img' => $row_comentario['foto_usuario_comentario'],
                        'comentario' => $row_comentario['comentario'],
                        'fecha' => $row_comentario['fecha']
                     ];

                     // Agregar comentario al array de comentarios
                     $fila_foro['comentarios'][] = $fila_comentario;
                  }
                  unset($fila_foro);
               }
            }
         } else {
            $respuesta['success'] = false;
            $respuesta['message'] = "No se encontraron resultados para la publicación con ID $id_publicacion_url.";
         }
      } else {
         $respuesta['success'] = false;
         $respuesta['message'] = "Error al ejecutar la consulta del FORO: " . $stmt_foro->error;
      }


      // Enviar la respuesta como JSON
      header('Content-Type: application/json');
      echo json_encode($respuesta);

      // Cerrar las declaraciones preparadas y la conexión
      $stmt_foro->close();
      $stmt_comentarios->close();
      $conn->close();
   } else {
      // Manejo de la situación cuando 'id' no está presente en la URL
      echo "El parámetro 'id' no está presente en la URL.";
   }
}
