<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {

        $id_usuario = $_SESSION['id_usuario'];
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $pagina_clicada = $_POST['a_clicado'];
        $respuesta = [
            "success" => false,
            "error" => null,
            "vacio" => false,
            "tipo_usuario" => $tipo_usuario,
        ];

        switch ($pagina_clicada) {
            case 'mi_perfil_nav':
                $respuesta['success'] = true;
                break;
            case 'sesiones_nav':
                $respuesta['success'] = true;
                if ($tipo_usuario == 'paciente') {
                    // Verificar si el paciente tiene citas
                    $sql = "SELECT COUNT(*) as count_citas FROM cita WHERE id_paciente = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $id_usuario);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);

                    if ($row['count_citas'] == 0) {
                        $respuesta['vacio'] = true;
                    }
                } else {
                    // Verificar si el psicólogo tiene citas
                    $sql = "SELECT COUNT(*) as count_citas FROM cita WHERE id_psicologo = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $id_usuario);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);

                    if ($row['count_citas'] == 0) {
                        $respuesta['vacio'] = true;
                    }
                }
                break;
            case 'psicologo_paciente_nav':
                $respuesta['success'] = true;
                if ($tipo_usuario == 'paciente') {
                    // Verificar si el paciente tiene un psicólogo asociado
                    $sql = "SELECT COUNT(*) as count_psicologos FROM paciente_psicologo WHERE id_paciente = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $id_usuario);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);

                    if ($row['count_psicologos'] == 0) {
                        $respuesta['vacio'] = true;
                    }
                } else {
                    // Verificar si el psicólogo tiene algún paciente asociado
                    $sql = "SELECT COUNT(*) as count_pacientes FROM paciente_psicologo WHERE id_psicologo = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $id_usuario);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);

                    if ($row['count_pacientes'] == 0) {
                        $respuesta['vacio'] = true;
                    }
                }
                break;
            case 'articulos_nav':
                $respuesta['success'] = true;

                break;
            case 'foro_nav':
                $respuesta['success'] = true;

                break;
            case 'talleres_nav':
                $respuesta['success'] = true;

                break;
            default:
                $respuesta['error'] = 'Ha habido un error con la página clicada';
                break;
        }
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    $bd->cerrar();
}
