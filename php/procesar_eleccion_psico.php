<?php
error_reporting(E_ALL);
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    // Verifica que la solicitud sea de tipo POST
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {

        $respuesta = [
            "success" => false,
            "error" => "'psicologoId' no presente en la solicitud POST.",
        ];

        // Obtén el ID del paciente desde la sesión
        $id_paciente = isset($_SESSION['id_paciente']) ? $_SESSION['id_paciente'] : null;

        // Obtiene el ID del psicólogo desde la solicitud POST
        $id_psicologo = isset($_POST['psicologoId']) ? $_POST['psicologoId'] : null;

        // Verifica si el paciente y el psicólogo son válidos
        if ($id_paciente && $id_psicologo) {
            // Consulta para verificar si ya existe una asociación
            $sqlSelect = "SELECT id_paciente FROM paciente_psicologo WHERE id_paciente = ?";
            $stmtSelect = mysqli_prepare($conn, $sqlSelect);

            if ($stmtSelect) {
                mysqli_stmt_bind_param($stmtSelect, "i", $id_paciente);
                mysqli_stmt_execute($stmtSelect);
                mysqli_stmt_store_result($stmtSelect);

                if (mysqli_stmt_num_rows($stmtSelect) > 0) {
                    // Ya existe una asociación, realiza la actualización
                    $sqlUpdate = "UPDATE paciente_psicologo SET id_psicologo = ?, fecha_inicio = CURDATE() WHERE id_paciente = ?";
                    $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);

                    if ($stmtUpdate) {
                        mysqli_stmt_bind_param($stmtUpdate, "ii", $id_psicologo, $id_paciente);
                        mysqli_stmt_execute($stmtUpdate);

                        $respuesta["success"] = true;
                        $respuesta["error"] = null;

                        mysqli_stmt_close($stmtUpdate);
                    } else {
                        $respuesta["error"] = "Error al preparar la sentencia de actualización: " . mysqli_error($conn);
                    }
                } else {
                    // No existe una asociación, realiza la inserción
                    $sqlInsert = "INSERT INTO paciente_psicologo (id_paciente, id_psicologo, fecha_inicio) VALUES (?, ?, CURDATE())";
                    $stmtInsert = mysqli_prepare($conn, $sqlInsert);

                    if ($stmtInsert) {
                        mysqli_stmt_bind_param($stmtInsert, "ii", $id_paciente, $id_psicologo);
                        mysqli_stmt_execute($stmtInsert);

                        $respuesta["success"] = true;
                        $respuesta["error"] = null;

                        mysqli_stmt_close($stmtInsert);
                    } else {
                        $respuesta["error"] = "Error al preparar la sentencia de inserción: " . mysqli_error($conn);
                    }
                }

                mysqli_stmt_close($stmtSelect);
            } else {
                $respuesta["error"] = "Error al preparar la consulta de verificación: " . mysqli_error($conn);
            }
        } else {
            $respuesta["error"] = "Datos de paciente o psicólogo no válidos.";
        }

        // Envía la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}
?>
