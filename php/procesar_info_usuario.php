<?php
session_start();
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

        // Obtener el ID del paciente de la sesión
        $id_paciente = $_SESSION['id_paciente'];

        // Realizar la consulta para obtener los datos del paciente utilizando una sentencia preparada
        $sql = "SELECT * FROM perfil_paciente WHERE id_paciente = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id_paciente);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Actualizar la respuesta con los datos del paciente
            $respuesta['success'] = true;
            $respuesta['gender'] = $row['sexo_paciente'];
            $respuesta['birthdate'] = $row['fecha_nac_paciente'];
            $respuesta['hobbies'] = $row['hobbies_paciente'];
            $respuesta['children'] = $row['hijos_paciente'];
            $respuesta['job'] = $row['trabajo_paciente'];
            $respuesta['partner'] = $row['pareja_sino_paciente'];
            $respuesta['studies'] = $row['estudios_paciente'];
            $respuesta['expectations'] = $row['expectativasypreocupaciones_paciente'];

            // Verificar si la función de actualización está presente en el formulario
            $funcion = isset($_POST['funcion']) ? $_POST['funcion'] : '';

            if ($funcion === 'updateForm') {
                // Verificar si al menos un campo necesario para la actualización está presente
                if (
                    isset($_POST['gender']) ||
                    isset($_POST['birthdate']) ||
                    isset($_POST['hobbies']) ||
                    isset($_POST['children']) ||
                    isset($_POST['job']) ||
                    isset($_POST['partner']) ||
                    isset($_POST['studies']) ||
                    isset($_POST['expectations'])
                ) {
                    // Escapar y obtener los nuevos datos para la actualización
                    $newGender = mysqli_real_escape_string($conn, $_POST['gender']);
                    $newBirthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
                    $newHobbies = mysqli_real_escape_string($conn, $_POST['hobbies']);
                    $newChildren = mysqli_real_escape_string($conn, $_POST['children']);
                    $newJob = mysqli_real_escape_string($conn, $_POST['job']);
                    $newPartner = mysqli_real_escape_string($conn, $_POST['partner']);
                    $newStudies = mysqli_real_escape_string($conn, $_POST['studies']);
                    $newExpectations = mysqli_real_escape_string($conn, $_POST['expectations']);

                    // Actualización de la tabla utilizando una sentencia preparada
                    $sqlUpdate = "UPDATE perfil_paciente SET
sexo_paciente = ?,
fecha_nac_paciente = ?,
hobbies_paciente = ?,
hijos_paciente = ?,
trabajo_paciente = ?,
pareja_sino_paciente = ?,
estudios_paciente = ?,
expectativasypreocupaciones_paciente = ?
WHERE id_paciente = ?";

                    $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);

                    // Convertir el valor de $newPartner a un booleano
                    $newPartnerBoolean = filter_var($newPartner, FILTER_VALIDATE_BOOLEAN);

                    mysqli_stmt_bind_param($stmtUpdate, "sssssisss", $newGender, $newBirthdate, $newHobbies, $newChildren, $newJob, $newPartnerBoolean, $newStudies, $newExpectations, $id_paciente);

                    $resultUpdate = mysqli_stmt_execute($stmtUpdate);

                    if ($resultUpdate) {
                        $respuesta['success'] = true;
                        $respuesta['message'] = 'Datos actualizados con éxito';
                    } else {
                        $respuesta['error'] = 'Error en la actualización SQL: ' . mysqli_error($conn);
                    }

                    mysqli_stmt_close($stmtUpdate);
                } else {
                    $respuesta['error'] = 'Datos insuficientes para la actualización';
                }
            }
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
