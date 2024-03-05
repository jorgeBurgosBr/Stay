<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

// Conectar a la base de datos
if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        if ($_SESSION['tipo_usuario'] == 'paciente') {
            $id_paciente = $_SESSION['id_usuario'];
            $respuesta = [
                'success' => false,
                'error' => null,
            ];
            // Obtener la ruta de la foto del paciente
            $sql = "SELECT foto_paciente FROM perfil_paciente WHERE id_paciente = ?";
            if ($stmt = $conn->prepare($sql)) {
                // Vincular parámetros
                $stmt->bind_param("i", $id_paciente);

                // Ejecutar
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $respuesta["success"] = true;
                        $row = $result->fetch_assoc();
                        $respuesta['ruta'] = $row['foto_paciente'];
                    } else {
                        $respuesta["error"] = "No tienes foto para este paciente";
                    }
                } else {
                    $respuesta["error"] = "Error al ejecutar la consulta.";
                }
                $stmt->close();
            } else {
                $respuesta["error"] = "Error al preparar la consulta.";
            }
        } else if ($_SESSION['tipo_usuario'] == 'psicologo') {
            $id_psicologo = $_SESSION['id_usuario'];
            $respuesta = [
                'success' => false,
                'error' => null,
            ];
            // Obtener la ruta de la foto del psicólogo
            $sql = "SELECT foto_psicologo FROM perfil_psicologo WHERE id_psicologo = ?";
            if ($stmt = $conn->prepare($sql)) {
                // Vincular parámetros
                $stmt->bind_param("i", $id_psicologo);

                // Ejecutar
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $respuesta["success"] = true;
                        $row = $result->fetch_assoc();
                        $respuesta['ruta'] = $row['foto_psicologo'];
                    } else {
                        $respuesta["error"] = "No tienes foto para este psicólogo";
                    }
                } else {
                    $respuesta["error"] = "Error al ejecutar la consulta.";
                }
                $stmt->close();
            } else {
                $respuesta["error"] = "Error al preparar la consulta.";
            }
        }




        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}
