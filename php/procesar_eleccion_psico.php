<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {

        $respuesta = [
            "success" => false,
            "error" => "'psicologoId' no presente en la solicitud POST.",
        ];

        // Obtén el ID del paciente desde la sesión (asegúrate de haber iniciado la sesión antes)
        $id_paciente = $_SESSION['id_paciente'];

        $id_psicologo = isset($_POST['psicologoId']) ? $_POST['psicologoId'] : null;
        echo "Valor de psicologoId: " . $id_psicologo;
        // Verifica si el paciente y el psicólogo son válidos (puedes realizar más validaciones según tus necesidades)
        if ($id_paciente && $id_psicologo) {
            // Utiliza sentencias preparadas para la inserción en la tabla paciente_psicologo
            $sqlInsert = "INSERT INTO paciente_psicologo (id_paciente, id_psicologo, fecha_inicio) VALUES (?, ?, CURDATE())";

            $stmt = mysqli_prepare($conn, $sqlInsert);

            if ($stmt) {
                // Vincula los parámetros
                mysqli_stmt_bind_param($stmt, "ii", $id_paciente, $id_psicologo);

                // Ejecuta la sentencia
                if (mysqli_stmt_execute($stmt)) {
                    $respuesta["success"] = true;
                    $respuesta["error"] = null;
                } else {
                    $respuesta["error"] = "Error al ejecutar la sentencia preparada: " . mysqli_stmt_error($stmt);
                }

                // Cierra la sentencia preparada
                mysqli_stmt_close($stmt);
            } else {
                $respuesta["error"] = "Error al preparar la sentencia: " . mysqli_error($conn);
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
