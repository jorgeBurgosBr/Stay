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

        // Obtener el ID del psicologo de la sesión
        $id_psicologo = $_SESSION['id_paciente'];
        // $id_psicologo = 1;

        // Realizar la consulta para obtener los datos del psicologo utilizando una sentencia preparada
        $sql = "SELECT * FROM perfil_psicologo WHERE id_psicologo = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id_psicologo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Actualizar la respuesta con los datos del psicologo
            $respuesta['success'] = true;
            $respuesta['gender'] = $row['sexo_psicologo'];
            $respuesta['birthdate'] = $row['fecha_nac_psicologo'];
            $respuesta['hobbies'] = $row['hobbies_psicologo'];
            $respuesta['children'] = $row['hijos_psicologo'];
            $respuesta['especialidad'] = $row['especialidad_psicologo'];
            $respuesta['partner'] = $row['pareja_sino_psicologo'];
            $respuesta['studies'] = $row['estudios_psicologo'];
            $respuesta['sobremi'] = $row['sobre_mi'];

            // Verificar si la función de actualización está presente en el formulario
            $funcion = isset($_POST['funcion']) ? $_POST['funcion'] : '';

            if ($funcion === 'updateForm') {
                // Verificar si al menos un campo necesario para la actualización está presente
                if (
                    isset($_POST['gender']) ||
                    isset($_POST['birthdate']) ||
                    isset($_POST['hobbies']) ||
                    isset($_POST['children']) ||
                    isset($_POST['especialidad']) ||
                    isset($_POST['partner']) ||
                    isset($_POST['studies']) ||
                    isset($_POST['sobremi'])
                ) {
                    // Escapar y obtener los nuevos datos para la actualización
                    $newGender = mysqli_real_escape_string($conn, $_POST['gender']);
                    $newBirthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
                    $newHobbies = mysqli_real_escape_string($conn, $_POST['hobbies']);
                    $newChildren = mysqli_real_escape_string($conn, $_POST['children']);
                    $newEspecialidad = mysqli_real_escape_string($conn, $_POST['especialidad']);
                    $newPartner = mysqli_real_escape_string($conn, $_POST['partner']);
                    $newStudies = mysqli_real_escape_string($conn, $_POST['studies']);
                    $newSobreMi = mysqli_real_escape_string($conn, $_POST['sobremi']);

                    // Actualización de la tabla utilizando una sentencia preparada
                    $sqlUpdate = "UPDATE perfil_psicologo SET
                        sexo_psicologo = ?,
                        fecha_nac_psicologo = ?,
                        hobbies_psicologo = ?,
                        hijos_psicologo = ?,
                        especialidad_psicologo = ?,
                        pareja_sino_psicologo = ?,
                        estudios_psicologo = ?,
                        sobre_mi = ?
                        WHERE id_psicologo = ?";

                    $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
                    mysqli_stmt_bind_param($stmtUpdate, "sssssssss", $newGender, $newBirthdate, $newHobbies, $newChildren, $newEspecialidad, $newPartner, $newStudies, $newSobreMi, $id_psicologo);
                    $resultUpdate = mysqli_stmt_execute($stmtUpdate);

                    if ($resultUpdate) {
                        $respuesta['success'] = true;
                        $respuesta['message'] = 'Datos actualizados con éxito';
                    } else {
                        $respuesta['error'] = 'Error en la actualización SQL: ' . mysqli_error($conn);
                    }
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
?>
