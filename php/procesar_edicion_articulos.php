<?php
error_reporting(E_ALL);
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
            } else if ($_POST['accion'] == 'anadir') {
                $id_psicologo = $_SESSION['id_usuario'];

                $respuesta = [
                    'success' => false,
                    'error' => null,
                ];
                $directorioDestino = "C:/xampp/htdocs/Stay/articulos_html/";

                $archivo = $directorioDestino . basename($_FILES['archivo']['name']);
                $respuesta['archivo'] = $archivo;
                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $archivo)) {

                    // Si el archivo ha sido añadido, creamos nueva fila en tabla articulos
                    $sql = "INSERT INTO articulo (id_psicologo, titulo_articulo, descripcion_articulo, imagen_articulo) VALUES (?,?,?,?)";

                    if ($stmt = $conn->prepare($sql)) {
                        $tituloArticulo = 'Artículo de prueba';
                        $descripcionArticulo = 'Descripción de prueba al añadir un artículo...';
                        $imagenArticulo = 'http://localhost/stay/img/articulos/articulo_6.png';

                        // Ahora pasas las variables en lugar de los valores directamente.
                        $stmt->bind_param("isss", $id_psicologo, $tituloArticulo, $descripcionArticulo, $imagenArticulo);


                        if ($stmt->execute()) {
                            $respuesta['success'] = true;
                        } else {
                            $respuesta['error'] = 'Error al añadir el artículo.';
                        }
                        $stmt->close();
                    } else {
                        $respuesta['error'] = 'Error al preparar la consulta de eliminar.';
                    }

                    $sql2 = "SELECT id_articulo FROM ARTICULO ORDER BY id_articulo DESC LIMIT 1";
                    if ($stmt = $conn->prepare($sql2)) {
                        if ($stmt->execute()) {
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $id = $row['id_articulo'];
                        } else {
                            $respuesta['error'] = 'Error recuperar id.';
                        }
                        $stmt->close();
                    } else {
                        $respuesta['error'] = 'Error al preparar la consulta de eliminar.';
                    }
                    // 
                    $sql3 = "INSERT INTO ENTRADA_ARTICULO(id_articulo, contenido_articulo, multimedia_articulo) VALUES (?,?,?)";


                    if ($stmt = $conn->prepare($sql3)) {
                        $contenido_articulo = 'articulos_html/' . basename($_FILES['archivo']['name']);
                        $multimedia_articulo = 'multi_prueba';
                        $stmt->bind_param("iss", $id, $contenido_articulo, $multimedia_articulo);
                        if ($stmt->execute()) {
                            $respuesta['success'] = true;
                        } else {
                            $respuesta['error'] = 'Error al insertar entrada articulo.';
                        }
                        $stmt->close();
                    } else {
                        $respuesta['error'] = 'Error al preparar la consulta de eliminar.';
                    }
                } else {
                    $respuesta['error'] = 'Error al mover el archivo';
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
