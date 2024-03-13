<?php
session_start();
require_once 'php/conecta.php';
$id_paciente = $_SESSION['id_usuario'];
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
    <link rel="stylesheet" href="http://localhost/stay/css/style_nav_footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
</head>

<body>
    <!-- HEADER -->
    <header>
        <div class="container-nav">
            <div class="logo"></div>
            <div class="menu-toggle" id="mobile-menu">
                <img src="img/logo.png" alt="Logo" id="logo-nav" />
                <i class="ri-menu-line"></i>
            </div>
            <nav>
                <ul>
                    <img src="img/logo.png" alt="Logo" id="logo-menu" />
                    <li><a id="mi_perfil_nav">Mi perfil</a></li>
                    <hr id="separacion">
                    <li><a id="sesiones_nav" class="current_page">Sesiones</a></li>
                    <hr id="separacion">
                    <li><a id="psicologo_paciente_nav">
                            <?php
                            echo ($_SESSION['tipo_usuario'] == 'paciente') ? "Mi psicólogo" : "Mis pacientes";
                            ?>
                        </a></li>
                    <hr id="separacion">
                    <li><a id="articulos_nav">Artículos</a></li>
                    <hr id="separacion">
                    <li><a id="foro_nav">Foro</a></li>
                    <hr id="separacion">
                    <li><a id="talleres_nav">Talleres</a></li>
                </ul>
            </nav>
        </div>
    </header>
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
                    <a class="back-icon" id="backButton"><i class="fas fa-arrow-left"></i></a>
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
        <script src="http://localhost/stay/js/script_flujo.js"></script>
        <script src="http://localhost/stay/js/script_hamburguer.js"></script>
    </div>
</body>

</html>