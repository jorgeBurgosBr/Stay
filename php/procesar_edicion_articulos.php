<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

// Conectar a la base de datos
if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $id_psicologo = $_SESSION['id_usuario'];
        $respuesta = [
            'success' => false,
            'error' => null,
        ];
        if ($_GET['select'] == 'articulos') {
            $respuesta['articulos'] = [];
            // Obtener los articulos
            $sql = "SELECT id_articulo, titulo_articulo FROM articulo WHERE id_psicologo = ?";
            if ($stmt = $conn->prepare($sql)) {
                // Vincular parámetros
                $stmt->bind_param("i", $id_psicologo);

                // Ejecutar
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $respuesta['success'] = true;
                        while ($row = $result->fetch_assoc()) {
                            $articulo = [
                                'id_articulo' => $row['id_articulo'],
                                'titulo_articulo' => $row['titulo_articulo']
                            ];
                            $respuesta['articulos'][] = $articulo;
                        }
                    } else {
                        $respuesta["error"] = "El psicólogo no tiene citas";
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
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['accion'])) {
            if ($_POST['accion'] == 'eliminar') {
                $respuesta = [
                    'success' => false,
                    'error' => null,
                ];
                $id_articulo = $_POST['id_articulo'];

                $sql = "DELETE FROM articulo WHERE id_articulo = ?";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("i", $id_articulo);

                    if ($stmt->execute()) {
                        $respuesta['success'] = true;
                    } else {
                        $respuesta['error'] = 'Error al eliminar el artículo.';
                    }
                    $stmt->close();
                } else {
                    $respuesta['error'] = 'Error al preparar la consulta de eliminar.';
                }
            }
        } else {
            $respuesta['error'] = 'Acción no especificada.';
        }
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    $bd->cerrar();
}
