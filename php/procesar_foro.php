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

   // Consulta preparada
   $stmt = $conn->prepare("SELECT 
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
                                    PERFIL_PSICOLOGO PPS ON PS.id_psicologo = PPS.id_psicologo");

   if ($stmt) {
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
         $stmt->bind_result($tipo_usuario, $foto, $nombre, $apellidos, $titulo, $foto_contenido, $texto_contenido);

         $respuesta['success'] = true;

         while ($stmt->fetch()) {
            //metemos los datos que  nos interesan en un array que más adelante se metera en resultado
            $fila = [
               'nombre' => $nombre,
               'apellidos' => $apellidos,
               'img' => $foto,
               'titulo' => $titulo,
               'foto_contenido' => $foto_contenido,
               'texto_contenido' => $texto_contenido
            ];
            // Añadir la fila al array de resultados
            $respuesta[] = $fila;
         }
         // Enviar la respuesta como JSON
         header('Content-Type: application/json');
         echo json_encode($respuesta);
      }

      $stmt->close();
   }
}
