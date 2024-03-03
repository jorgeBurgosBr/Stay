<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
    <link rel="stylesheet" href="./css/style_nav_footer.css">
    <link rel="stylesheet" href="./css/articulos.css">
    <title>Artículos</title>
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
                    <li><a href="perfil_usuario.php">Mi perfil</a></li>
                    <hr id="separacion">
                    <li><a href="#">Sesiones</a></li>
                    <hr id="separacion">
                    <li><a href="#" id="mipsico_nav">Mi psicólogo</a></li>
                    <hr id="separacion">
                    <li><a href="articulos.php" id="current_page">Artículos</a></li>
                    <hr id="separacion">
                    <li><a href="#">Foro</a></li>
                    <hr id="separacion">
                    <li><a href="#">Talleres</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- ARTÍCULOS -->
    <div class="container_body_articles">
        <div class="container_search_bar">
            <div class="container_search_icon">
                <div class="material-symbols-outlined" id="search_icon">search</div>
            </div>
            <div class="search_bar">
                <input type="text" name="" id="input_search">
            </div>
        </div>
        <div class="container_articles">
        </div>
    </div>
    <script src="./js/articulos.js"></script>

</body>

</html>