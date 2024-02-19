<?php
require_once 'conecta.php';
$bd = new BaseDeDatos();

// Conectar a la base de datos
if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    // Verificar el método de la solicitud
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Respuesta predeterminada
        $respuesta = [
            'success' => false,
            'error' => null,
        ];

        // Obtener el ID del paciente de la solicitud
        $idPaciente = mysqli_real_escape_string($conn, $_POST['id_paciente']);

        // Realizar la consulta para obtener los datos del paciente
        $sql = "SELECT * FROM perfil_paciente WHERE id_paciente = '$idPaciente'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                // Actualizar la respuesta con los datos del paciente
                $respuesta['success'] = true;
                $respueta['gender'] = $row['sexo_paciente'];
                $respuesta['hobbies'] = $row['hobbies_paciente'];
                $respuesta['job'] = $row['trabajo_paciente'];
                $respuesta['studies'] = $row['estudios_paciente'];
                $respuesta['expectations'] = $row['expectativasypreocupaciones_paciente'];
            } else {
                // Paciente no encontrado
                $respuesta['error'] = 'Paciente no encontrado';
            }
        } else {
            // Error en la consulta SQL
            $respuesta['error'] = 'Error en la consulta SQL: ' . mysqli_error($conn);
        }

        // Enviar la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}
?>
