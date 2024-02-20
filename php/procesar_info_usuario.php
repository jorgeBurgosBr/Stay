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
                    // Verificar si los datos necesarios para la actualización están presentes
                    if (isset($_POST['new_gender'])) {
                        // Escapar y obtener los nuevos datos para la actualización
                        $newGender = mysqli_real_escape_string($conn, $_POST['new_gender']);
                        $newBirthdate = mysqli_real_escape_string($conn, $_POST['new_birthdate']);
                        $newHobbies = mysqli_real_escape_string($conn, $_POST['new_hobbies']);
                        $newChildren = mysqli_real_escape_string($conn, $_POST['new_children']);
                        $newJob = mysqli_real_escape_string($conn, $_POST['new_job']);
                        $newPartner = mysqli_real_escape_string($conn, $_POST['new_partner']);
                        $newStudies = mysqli_real_escape_string($conn, $_POST['new_studies']);
                        $newExpectations = mysqli_real_escape_string($conn, $_POST['new_expectations']);

                        // Ejemplo de actualización de datos
                        $sqlUpdate = "UPDATE perfil_paciente SET
                                      sexo_paciente = '$newGender',
                                      fecha_nac_paciente = '$newBirthdate',
                                      hobbies_paciente = '$newHobbies',
                                      hijos_paciente = '$newChildren',
                                      trabajo_paciente = '$newJob',
                                      pareja_sino_paciente = '$newPartner',
                                      estudios_paciente = '$newStudies',
                                      expectativasypreocupaciones_paciente = '$newExpectations'
                                      WHERE id_paciente = '$idPaciente'";

                        $resultUpdate = mysqli_query($conn, $sqlUpdate);

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
}
?>
