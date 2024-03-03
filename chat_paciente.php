<?php
session_start();
require_once 'php/conecta.php';
$id_paciente = $_SESSION['id_paciente'];
$bd = new BaseDeDatos();
$bd->conectar();
$conn = $bd->getConexion();
$bd->seleccionarContexto('stay');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Realtime Chat App</title>
    <link rel="stylesheet" href="css/style_chat.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="body">
        <div class="wrapper">
            <section class="chat-area">
                <div class="header">
                    <?php
                    if (isset($id_paciente)) {
                        $sql2 = mysqli_query($conn, "SELECT id_psicologo FROM paciente_psicologo WHERE id_paciente = $id_paciente");

                        if ($sql2) {
                            if (mysqli_num_rows($sql2) > 0) {
                                $row = mysqli_fetch_assoc($sql2);
                                $id_psicologo = $row['id_psicologo'];

                                $sql = mysqli_query($conn, "SELECT p.*, pp.* FROM psicologo p JOIN perfil_psicologo pp ON p.id_psicologo = pp.id_psicologo WHERE p.id_psicologo = $id_psicologo");

                                if ($sql) {
                                    if (mysqli_num_rows($sql) > 0) {
                                        $row = mysqli_fetch_assoc($sql);
                                        // Aquí puedes usar $row para acceder a los datos del psicólogo y su perfil
                                    } else {
                                        echo "No se encontraron resultados para el psicólogo asociado.";
                                    }
                                } else {
                                    echo "Error en la consulta SQL: " . mysqli_error($conn);
                                }
                            } else {
                                echo "No hay ningún psicólogo asociado a este paciente.";
                            }
                        } else {
                            echo "Error en la consulta SQL: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error: 'id_paciente' no está presente en la solicitud.";
                    }

                    ?>
                    <a class="back-icon" href="psicologo_usuario.php"><i class="fas fa-arrow-left"></i></a>
                    <img src="<?php echo $row['foto_psicologo'] ?>" alt="" />
                    <div class="details">
                        <span><?php echo $row['nombre_psicologo'] . " " . $row['apellidos_psicologo'] ?></span>
                    </div>
                </div>
                <div class="chat-box">
                </div>
                <form action="#" class="typing-area">
                    <input type="text" name="outgoing_id" value="<?php echo $id_paciente; ?>" hidden>
                    <input type="text" name="incoming_id" value="<?php echo $id_psicologo; ?>" hidden>
                    <input type="text" name="message" class="input-field" placeholder="Type a message here..." />
                    <button><i class="fa-regular fa-paper-plane"></i></button>
                </form>
            </section>
        </div>
        <script src="js/chat.js"></script>
    </div>
</body>

</html>