<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $respuesta = [
            'success' => false,
            'error' => null
        ];

        $id_paciente = $_SESSION['id_usuario'];

        if (!empty($_FILES['file']['name'])) {
            $file_name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];

            // Obtén la ruta base del servidor web
            $base_path = $_SERVER['DOCUMENT_ROOT'];

            // Construye la ruta completa del archivo
            $upload_path = $base_path . '/Stay/img/psicologo/' . $file_name;

            if (move_uploaded_file($temp_name, $upload_path)) {
                // Aquí obtén la ruta relativa a partir de la carpeta del proyecto
                $relative_path = './img/psicologo/' . $file_name;


                $sql = "UPDATE perfil_psicologo SET foto_psicologo = ? WHERE id_psicologo = ?";
                $stmt = mysqli_prepare($conn, $sql);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ss", $relative_path, $id_paciente);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    $respuesta['success'] = true;
                } else {
                    $respuesta['error'] = 'Error en la declaración preparada';
                }
            } else {
                $respuesta['error'] = 'Error al mover el archivo';
            }
        } else {
            $respuesta['error'] = 'No se ha seleccionado ningún archivo';
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
        exit;
    }
}
