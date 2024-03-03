<?php
// incluímos la clase BaseDeDatos mediante un require a 'conecta.php'
require_once 'conecta.php';

// Funcion comprobar si existe
function existeStay()
{
    // Creo instancia conexión bbdd
    $bd = new BaseDeDatos();
    $flag = false;
    try {
        if ($bd->conectar()) {
            $conexion = $bd->getConexion();
            // Consulta para verificar si la BBDD existe
            $sql = "SHOW DATABASES LIKE 'Stay'";
            $result = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));
            if (mysqli_num_rows($result) > 0) {
                $flag = true;
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    $bd->cerrar();
    return $flag;
}

// Función crearBD
function crearBD()
{
    // Creamos una instancia
    $bd = new BaseDeDatos();
    try {
        // Nos conectamos
        if ($bd->conectar()) {
            $conexion = $bd->getConexion();
            $createSql = [
                "CREATE DATABASE Stay;",
                "USE Stay;",
                "CREATE TABLE PACIENTE (
                    id_paciente INT AUTO_INCREMENT,
                    nombre_paciente VARCHAR(255) NOT NULL,
                    apellidos_paciente VARCHAR(255) NOT NULL,
                    correo_paciente VARCHAR(255) NOT NULL,
                    telefono_paciente VARCHAR(20) NOT NULL,
                    PRIMARY KEY (id_paciente)
                );",
                "CREATE TABLE PSICOLOGO (
                    id_psicologo INT AUTO_INCREMENT,
                    nombre_psicologo VARCHAR(255) NOT NULL,
                    apellidos_psicologo VARCHAR(255) NOT NULL,
                    correo_psicologo VARCHAR(255) NOT NULL,
                    tel_psicologo VARCHAR(20),
                    linkedin_psicologo VARCHAR(255),
                    cv_psicologo TEXT,
                    PRIMARY KEY (id_psicologo)
                );",
                "CREATE TABLE USUARIO (
                    id_usuario INT AUTO_INCREMENT,
                    correo_usuario VARCHAR(255) NOT NULL,
                    contrasena_usuario VARCHAR(255) NOT NULL,
                    tipo_usuario ENUM('paciente', 'psicologo') NOT NULL,
                    id_original INT NOT NULL,
                    PRIMARY KEY (id_usuario)
                );",
                "CREATE TABLE PERFIL_PACIENTE (
                    id_paciente INT,
                    fecha_nac_paciente DATE,
                    sexo_paciente ENUM('masculino', 'femenino', 'otro') NOT NULL,
                    pareja_sino_paciente BOOLEAN,
                    hijos_paciente INT,
                    trabajo_paciente VARCHAR(255),
                    estudios_paciente VARCHAR(255),
                    hobbies_paciente TEXT,
                    expectativasypreocupaciones_paciente TEXT,
                    foto_paciente VARCHAR(255),
                    PRIMARY KEY (id_paciente),
                    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente)
                );",
                "CREATE TABLE PERFIL_PSICOLOGO (
                    id_psicologo INT,
                    sobre_mi VARCHAR(255),
                    fecha_nac_psicologo DATE,
                    sexo_psicologo ENUM('masculino', 'femenino', 'otro') NOT NULL,
                    pareja_sino_psicologo BOOLEAN,
                    hijos_psicologo INT,
                    especialidad_psicologo VARCHAR(255),
                    experiencia_psicologo INT,
                    estudios_psicologo VARCHAR(255),
                    hobbies_psicologo TEXT,
                    foto_psicologo VARCHAR(255),
                    PRIMARY KEY (id_psicologo),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );",
                "CREATE TABLE CITA (
                    id_cita INT AUTO_INCREMENT,
                    id_paciente INT NOT NULL,
                    id_psicologo INT NOT NULL,
                    fecha_cita DATE NOT NULL,
                    hora_cita TIME NOT NULL,
                    PRIMARY KEY (id_cita),
                    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );",
                "CREATE TABLE PACIENTE_PSICOLOGO (
                    id_paciente INT,
                    id_psicologo INT,
                    fecha_inicio DATE NOT NULL,
                    PRIMARY KEY (id_paciente, id_psicologo),
                    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );",
                "CREATE TABLE VIDEOLLAMADA (
                    id_videollamada INT AUTO_INCREMENT,
                    id_paciente INT NOT NULL,
                    id_psicologo INT NOT NULL,
                    enlace_videollamada VARCHAR(255) NOT NULL,
                    PRIMARY KEY (id_videollamada),
                    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );",
                "CREATE TABLE REGISTRO_CITA (
                    id_cita INT,
                    grabacion_cita VARCHAR(255),
                    PRIMARY KEY (id_cita),
                    FOREIGN KEY (id_cita) REFERENCES CITA(id_cita)
                );",
                "CREATE TABLE ARTICULO (
                    id_articulo INT AUTO_INCREMENT,
                    id_psicologo INT NOT NULL,
                    titulo_articulo VARCHAR(255) NOT NULL,
                    descripcion_articulo TEXT,
                    imagen_articulo VARCHAR(255),
                    PRIMARY KEY (id_articulo),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );",
                "CREATE TABLE ENTRADA_ARTICULO (
                    id_articulo INT,
                    contenido_articulo TEXT NOT NULL,
                    multimedia_articulo VARCHAR(255),
                    PRIMARY KEY (id_articulo),
                    FOREIGN KEY (id_articulo) REFERENCES ARTICULO(id_articulo)
                );",
                "CREATE TABLE TALLER (
                    id_taller INT AUTO_INCREMENT,
                    id_psicologo INT NOT NULL,
                    titulo_taller VARCHAR(255) NOT NULL,
                    descripcion_taller TEXT,
                    enlace_taller VARCHAR(255),
                    fecha_taller DATE,
                    imagen_taller VARCHAR(255),
                    PRIMARY KEY (id_taller),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );",
                "CREATE TABLE MENSAJES (
                    msg_id INT AUTO_INCREMENT,
                    msg_entrada_id INT,
                    msg_salida_id INT,
                    msg TEXT,
                    PRIMARY KEY (msg_id)
                );",
                "CREATE TABLE NOTAS_PACIENTE (
                    id_paciente INT,
                    bio TEXT,
                    notas TEXT,
                    PRIMARY KEY (id_paciente),
                    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente)
                );",
                "CREATE TABLE FORO (
                    id_publicacion INT AUTO_INCREMENT,
                    titulo VARCHAR(255),
                    foto_contenido VARCHAR(255),
                    texto_contenido TEXT,
                    id_publicante INT,
                    PRIMARY KEY (id_publicacion)
                );",
                "CREATE TABLE COMENTARIOS_FORO (
                    id_comentario INT AUTO_INCREMENT,
                    id_publicacion INT,
                    comentario TEXT,
                    fecha DATETIME,
                    id_usuario INT,
                    PRIMARY KEY (id_comentario),
                    FOREIGN KEY (id_publicacion) REFERENCES FORO(id_publicacion),
                    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario)
                );"
            ];
            $insertSql = [
                "USE Stay;",

                "INSERT INTO PACIENTE (nombre_paciente, apellidos_paciente, correo_paciente, telefono_paciente)
                VALUES 
                ('John', 'Doe', 'doejohn@gmail.com', '600 100 200'),
                ('Jane', 'Doe', 'doejane@gmail.com', '600 101 201'),
                ('Jim', 'Beam', 'beamjim@gmail.com', '600 102 202'),
                ('Jack', 'Daniels', 'danielsjack@gmail.com', '600 103 203'),
                ('Josie', 'Wales', 'walesjosie@gmail.com', '600 104 204');",
                "INSERT INTO PSICOLOGO (nombre_psicologo, apellidos_psicologo, correo_psicologo, tel_psicologo, linkedin_psicologo, cv_psicologo)
                VALUES 
                ('Alba', 'García', 'alba.garcia@stay.com', '610 200 300', 'linkedin.com/in/albagarcia', 'cv/albagarcia.pdf'),
                ('Sigmund', 'Freud', 'sigmund.f@stay.com', '610 201 301', 'linkedin.com/in/sigmundf', 'cv/sigmundf.pdf'),
                ('Patricia', 'Fuentes', 'fuentes.p@stay.com', '610 202 302', 'linkedin.com/in/caroljones', 'cv/caroljones.pdf'),
                ('Javier', 'Pérez', 'j.perez@stay.com', '610 203 303', 'linkedin.com/in/javip', 'cv/javip.pdf'),
                ('Dr. Emily', 'White', 'whiteemily@gmail.com', '610 204 304', 'linkedin.com/in/emilywhite', 'cv/emilywhite.pdf');",
                "INSERT INTO USUARIO (correo_usuario, contrasena_usuario, tipo_usuario, id_original)
                VALUES 
                ('doejohn@gmail.com', '\$2b\$12\$ilCBEO1rUjnUi1I6ek.KgODCGXlL2Op/I7U2jGkK7Yi8hT0cWh3/S', 'paciente', 1),
                ('doejane@gmail.com', '\$2b\$12\$VWLLmrG4tWpojOSBGP5Kme.EOWlTAvhLcCjjUXbN6DhyXCRIy3OTu', 'paciente', 2),
                ('beamjim@gmail.com', '\$2b\$12\$8D5uPzWTXsybbibN26hKfus2VqHL6ExinyTpvy0llyvRPRBBDN73C', 'paciente', 3),
                ('danielsjack@gmail.com', '\$2b\$12\$O22laW4xt1mXF1htmmEtl.gx/KJ/Hmkt50bzRiKCBI8e31UyairPS', 'paciente', 4),
                ('walesjosie@gmail.com', '\$2b\$12\$o6TnryuZ.mlz31AWyzikdeTff2VkGLj0/8oaEvb9OpONDLStJneLW', 'paciente', 5);",
                "INSERT INTO USUARIO (correo_usuario, contrasena_usuario, tipo_usuario, id_original)
                VALUES 
                ('alba.garcia@stay.com', '\$2b\$12\$cBHbn6dwFJ73ETneznybLO7F4B0VBphgAqWNH8CpgR1mdAWvpS2fi', 'psicologo', 1),
                ('sigmund.f@stay.com', '\$2b\$12\$5TS8yMJjlWRhtQZEP0pCb.UYm6FQ9DsL6xjaCeW2NAhl35Izw/3IG', 'psicologo', 2),
                ('fuentes.p@stay.com', '\$2b\$12\$/kO3ksjb/gBoX/HhqekoY.3m2L3ckfsxfUYGCHFm1BoRvQdVh3Acu', 'psicologo', 3),
                ('j.perez@stay.com', '\$2b\$12\$BcQnAld2YCVe2eMHflprKOZrz4gh9HPVrNtCrHrlekTMyoPHr.P06', 'psicologo', 4),
                ('whiteemily@gmail.com', '\$2b\$12\$A2UdSaCWGFYIrHo7J.HQfOt0UteETwKzONeYVLcze1ZI3WN5aVRPW', 'psicologo', 5);",
                "INSERT INTO PERFIL_PACIENTE (id_paciente, fecha_nac_paciente, sexo_paciente, pareja_sino_paciente, hijos_paciente, trabajo_paciente, estudios_paciente, hobbies_paciente, expectativasypreocupaciones_paciente, foto_paciente)
                VALUES 
                (1, '1980-04-23', 'masculino', TRUE, 1, 'Ingeniero', 'Grado en Ingeniería', 'Leer, Escalar', 'Espero mejorar mi gestión del estrés', './img/paciente/john_paciente.png'),
                (2, '1985-05-16', 'femenino', FALSE, 0, 'Doctora', 'Doctorado en Medicina', 'Yoga, Pintar', 'Quiero aprender a equilibrar trabajo y vida personal', './img/paciente/jane_paciente.png'),
                (3, '1990-07-08', 'masculino', TRUE, 3, 'Abogado', 'Licenciatura en Derecho', 'Correr, Viajar', 'Necesito ayuda para lidiar con la ansiedad', './img/paciente/jim_paciente.png'),
                (4, '1995-08-19', 'masculino', FALSE, 2, 'Artista', 'Diplomado en Bellas Artes', 'Música, Poesía', 'Busco formas de potenciar mi creatividad', './img/paciente/jack_paciente.png'),
                (5, '2000-12-12', 'femenino', TRUE, 0, 'Emprendedora', 'MBA', 'Cocinar, Blogging', 'Deseo mejorar mis habilidades de comunicación', './img/paciente/josie_paciente.png');",
                "INSERT INTO PERFIL_PSICOLOGO (id_psicologo, fecha_nac_psicologo, sexo_psicologo, pareja_sino_psicologo, hijos_psicologo, especialidad_psicologo, experiencia_psicologo, estudios_psicologo, hobbies_psicologo, foto_psicologo, sobre_mi)
                VALUES 
                (1, '1996-03-15', 'femenino', TRUE, 1, 'Niños y adolescentes', 5, 'Máster en Terapia Cognitivo-Conductual con niños y adolescentes', 'Jardinería, Meditación', './img/psicologo/alba-psicologa.png', 'Mi objetivo es crear un entorno seguro y acogedor para los niños, utilizando métodos terapéuticos que promuevan el desarrollo emocional y cognitivo.'),
                (2, '1970-06-22', 'masculino', FALSE, 1, 'Entorno familiar', 12, 'Máster en Intervención Educativa y Psicológica', 'Ajedrez, Fotografía', './img/psicologo/sigmund-psicologo.png', 'Con más de 12 años de experiencia, estoy dedicado a proporcionar un enfoque holístico para el tratamiento de problemas psicológicos.'),
                (3, '1980-11-30', 'femenino', TRUE, 3, 'Acoso y ciberbullying.', 12, 'Máster Oficial en Psicología Social', 'Escritura, Ciclismo', './img/psicologo/patricia-psicologo.png', 'Soy una psicóloga comprometida con ayudar a mis pacientes a encontrar soluciones a sus desafíos emocionales y mejorar su bienestar mental.'),
                (4, '1985-02-28', 'masculino', TRUE, 2, 'Adicciones', 9, 'Máster en Psicofarmacología y Drogas de Abuso', 'Cocina, Buceo', './img/psicologo/javier-psicologo.png', 'Especializado en el tratamiento de adicciones, cuento con un Máster en Psicofarmacología y Drogas de Abuso. Mi enfoque terapéutico se centra en ayudar a los individuos a superar los desafíos relacionados con las adicciones, proporcionando apoyo y orientación.'),
                (5, '1990-09-14', 'femenino', FALSE, 1, 'Mindfulness y Estrés', 5, 'Master en Mindfulness', 'Pilates, Lectura', './img/psicologo/foto_emily.jpg', 'Como profesional de la salud mental, me apasiona enseñar técnicas de mindfulness para reducir el estrés y mejorar la calidad de vida.');",
                "INSERT INTO CITA (id_paciente, id_psicologo, fecha_cita, hora_cita)
                VALUES 
                (1, 1, '2024-02-28', '10:00:00'),
                (1, 1, '2024-03-25', '17:00:00'),
                (1, 1, '2024-03-23', '12:00:00'),
                (1, 1, '2024-03-06', '10:00:00'),
                (1, 1, '2024-04-01', '09:00:00'),
                (2, 1, '2024-01-12', '11:30:00'),
                (2, 1, '2024-02-29', '13:00:00'),
                (2, 1, '2024-03-15', '14:00:00'),
                (3, 2, '2023-01-15', '10:00:00'),
                (4, 2, '2023-01-18', '14:30:00'),
                (5, 3, '2023-01-20', '16:00:00');",
                "INSERT INTO PACIENTE_PSICOLOGO (id_paciente, id_psicologo, fecha_inicio)
                VALUES 
                (1, 1, '2023-01-01'),
                (2, 1, '2023-01-03'),
                (3, 2, '2023-01-06'),
                (4, 2, '2023-01-10'),
                (5, 3, '2023-01-13');",
                "INSERT INTO VIDEOLLAMADA (id_paciente, id_psicologo, enlace_videollamada)
                VALUES 
                (1, 1, 'https://meet.jit.si/SmithJohnDoe'),
                (2, 1, 'https://meet.jit.si/SmithJaneDoe'),
                (3, 2, 'https://meet.jit.si/TaylorJimBeam'),
                (4, 2, 'https://meet.jit.si/TaylorJackDaniels'),
                (5, 3, 'https://meet.jit.si/JonesJosieWales');",
                "INSERT INTO REGISTRO_CITA (id_cita, grabacion_cita)
                VALUES 
                (1, 'grabaciones/smith_john_doe_1.mp4'),
                (2, 'grabaciones/smith_jane_doe_2.mp4'),
                (3, 'grabaciones/taylor_jim_beam_1.mp4'),
                (4, 'grabaciones/taylor_jack_daniels_1.mp4'),
                (5, 'grabaciones/jones_josie_wales_1.mp4');",
                "INSERT INTO ARTICULO (id_psicologo, titulo_articulo, descripcion_articulo, imagen_articulo)
                VALUES 
                (1, 'La importancia del mindfulness', 'Explora cómo el mindfulness mejora tu bienestar y productividad. Aprende técnicas prácticas para una vida más serena y consciente. ¡Inicia tu viaje hacia el equilibrio!', './img/articulos/articulo_1.png'),
                (2, 'Gestión del estrés en el trabajo', 'Descubre cómo gestionar el estrés laboral y mejora tu bienestar. Estrategias eficaces para un equilibrio entre trabajo y descanso.', './img/articulos/articulo_2.png'),
                (3, 'Relaciones saludables', 'Aprende a fortalecer tus relaciones con comunicación, respeto y empatía. Mejora tus conexiones para vínculos más profundos.', './img/articulos/articulo_3.png'),
                (4, 'El poder del pensamiento positivo', 'Descubre cómo el pensamiento positivo puede moldear tu realidad, abriendo puertas a nuevas oportunidades. Cultiva una mente optimista y resiliente para un crecimiento personal y éxito duraderos.', './img/articulos/articulo_4.png'),
                (5, 'Desarrollo personal a través de la psicología', 'Explora la psicología del desarrollo personal con herramientas para superar obstáculos y maximizar tu potencial.', './img/articulos/articulo_5.png');",
                "INSERT INTO ENTRADA_ARTICULO (id_articulo, contenido_articulo, multimedia_articulo)
                VALUES 
                (1, 'articulos_html/articulo1.php', 'multimedia/articulo1/'),
                (2, 'articulos_html/articulo2.php', 'multimedia/articulo2/'),
                (3, 'articulos_html/articulo3.php', 'multimedia/articulo3/'),
                (4, 'articulos_html/articulo4.php', 'multimedia/articulo4/'),
                (5, 'articulos_html/articulo5.php', 'multimedia/articulo5/');",
                "INSERT INTO TALLER (id_psicologo, titulo_taller, descripcion_taller, enlace_taller, fecha_taller, imagen_taller)
                VALUES 
                (1, '¡Animate a nuestro gym mental!', 'El cerebro es un músculo más para ejercitar aunque no se vea a simple vista, ya que cuanta más importancia le demos y más constantes seamos, más...', 'https://workshop.com/taller1', '2023/09/18', './img/talleres/taller1.png'),
                (2, 'Espacio familiar en Salud mental', '¿Quién cuida de los que cuidan? El taller de Familias permite a las personas cuidadoras de un miembro con trastorno mental compartir su experiencia...', 'https://workshop.com/taller2', '2023/07/24', './img/talleres/taller2.png'),
                (3, 'Un viaje interior', 'El taller de “Conoce tu psique” es un taller en el que se exponen diferentes patologías mentales, sus síntomas, posibles causas de origen y mantenimiento, y su tratamiento. El objetivo...', 'https://workshop.com/taller3', '2023/07/07', './img/talleres/taller3.png'),
                (4, 'Aprender a comunicarnos', 'Las habilidades sociales conforman un conjunto de estrategias de conducta que permiten adecuar nuestro comportamiento a distintas situaciones de la vida diaria..', 'https://workshop.com/taller4', '2024/02/01', './img/talleres/taller4.png'),
                (5, 'Ejercicios para salud física y mental', 'Algunos de los ejercicios más recomendados en relación a la Salud Mental son: La natación desestresa y te focaliza: Nadar ayuda a tratar la depresión...', 'https://workshop.com/taller5', '2024/02/06', './img/talleres/taller5.png'),
                (5, 'Mentes sanas para cuerpos sanos', '¿Alguna vez te has parado a escuchar a tu cuerpo? Si no lo has hecho aún, ¡Este es tu momento! Cuando algo no va bien, nuestro cuerpo puede enviarnos ciertas...', 'https://workshop.com/taller6', '2024/01/26', './img/talleres/taller6.png');",

                "INSERT INTO NOTAS_PACIENTE (id_paciente, bio, notas) VALUES 
                (1, 'John es un joven chef que ha superado grandes obstáculos para abrir su propio restaurante. Huérfano desde joven, encontró en la cocina un...', 'Notas adicionales sobre el tratamiento y observaciones.'),
                (2, 'Ha sufrido la perdida de sus padres y su hermano. Aunque se ha convertido en una exitosa influencer, la sombra del duelo persiste.', 'Observaciones del terapeuta sobre el progreso.'),
                (3, 'Exmilitar, Jim se ha reinventado como escritor de novelas de suspenso. A pesar de su éxito literario, su experiencia en...', 'Detalles sobre sesiones específicas y recomendaciones.'),
                (4, 'Jack es un reconocido biólogo marino, dedicado a la conservación de los océanos. Su motivación proviene de la pérdida de su...', 'Comentarios sobre la evolución del paciente y ajustes en el tratamiento.'),
                (5, 'Biografía breve del paciente Josie Wales. Objetivos personales y retos enfrentados.', 'Estrategias adoptadas durante las sesiones y feedback.');",
                "INSERT INTO FORO (titulo, foto_contenido, texto_contenido, id_publicante) VALUES
                ('Prevención Primaria de la Conducta Suicida | Hablemos de Suicidio', './img/foro/contenido_corazon.png', NULL , 7),
                ('[Serio] Me podrían decir lineas telefónicas para prevenir suicidios', NULL, 'No es para mi. Un amigo acaba de tener un intento de suicidio, y hasta ahora me doy cuenta que es demasiada la importancia de saber si existe algún numero al que marcar para este tipo de situaciones.', 3),
                ('¿Cómo Prevenir el Suicidio en la Sociedad?', './img/foro/contenido_uruguay.png', NULL, 8);",

                "INSERT INTO COMENTARIOS_FORO (id_publicacion, comentario, fecha, id_usuario) VALUES
                (1, 'esto es un comentario', '2024-02-03 12:46:13', 2),
                (2, 'esto es otro comentario', '2024-02-07 19:34:11', 1),
                (3, 'este hilo me parece muy interesante', '2024-02-10 10:34:11', 3);"
            ];
            // Ejecutar las consultas de inserción de datos
            ejecutarSentencias($conexion, $createSql);
            ejecutarSentencias($conexion, $insertSql);
            $bd->cerrar();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function ejecutarSentencias($conexion, $sentencias)
{
    foreach ($sentencias as $sql) {
        if (mysqli_multi_query($conexion, $sql)) {
            do {
                // Almacenar primer resultado set (si existe)
                if ($result = mysqli_store_result($conexion)) {
                    mysqli_free_result($result);
                }
                // Verificar si hay más resultados
            } while (mysqli_next_result($conexion));
        } else {
            echo "Error ejecutando SQL: " . mysqli_error($conexion);
            break; // Salir del bucle en caso de error
        }
    }
}
// Crea tablas e inserta datos solo si no existe Ambulatorio
if (!existeStay()) {
    crearBD();
}
