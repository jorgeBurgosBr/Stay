<?php
// incluímos la clase BaseDeDatos mediante un require a 'conecta.php'
require_once 'conecta.php';

// Funcion comprobar si existe
function existeAmbulatorio()
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
// Función crearTablas
function crearTablas()
{
    // Creamos una instancia
    $bd = new BaseDeDatos();
    try {
        // Nos conectamos
        if ($bd->conectar()) {
            $conexion = $bd->getConexion();
            /**
             * Se crean las tablas teniendo en cuenta la integridad referencial, es decir, cuál debe ser el orden adecuado
             * para crear las tablas de tal forma que no se cree primero una tabla que referencie a otra.
             */

            $sql = "
                CREATE DATABASE Stay;

                USE Stay;
                
                CREATE TABLE PACIENTE (
                    id_paciente INT AUTO_INCREMENT,
                    nombre_paciente VARCHAR(255) NOT NULL,
                    apellidos_paciente VARCHAR(255) NOT NULL,
                    correo_paciente VARCHAR(255) NOT NULL,
                    telefono_paciente VARCHAR(20) NOT NULL,
                    PRIMARY KEY (id_paciente)
                );
                CREATE TABLE PSICOLOGO (
                    id_psicologo INT AUTO_INCREMENT,
                    nombre_psicologo VARCHAR(255) NOT NULL,
                    apellidos_psicologo VARCHAR(255) NOT NULL,
                    correo_psicologo VARCHAR(255) NOT NULL,
                    tel_psicologo VARCHAR(20),
                    linkedin_psicologo VARCHAR(255),
                    cv_psicologo TEXT,
                    PRIMARY KEY (id_psicologo)
                );
                CREATE TABLE USUARIO (
                    id_usuario INT AUTO_INCREMENT,
                    correo_usuario VARCHAR(255) NOT NULL,
                    contrasena_usuario VARCHAR(255) NOT NULL,
                    tipo_usuario ENUM('paciente', 'psicologo') NOT NULL,
                    id_original INT NOT NULL,
                    PRIMARY KEY (id_usuario)
                );
                
                CREATE TABLE PERFIL_PACIENTE (
                    id_paciente INT,
                    fecha_nac_paciente DATE,
                    sexo_paciente ENUM('masculino', 'femenino', 'otro') NOT NULL,
                    pareja_sino_paciente BOOLEAN,
                    hijos_sino_paciente BOOLEAN,
                    trabajo_paciente VARCHAR(255),
                    estudios_paciente VARCHAR(255),
                    hobbies_paciente TEXT,
                    expectativasypreocupaciones_paciente TEXT,
                    foto_paciente VARCHAR(255),
                    PRIMARY KEY (id_paciente),
                    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente)
                );
                CREATE TABLE PERFIL_PSICOLOGO (
                    id_psicologo INT,
                    fecha_nac_psicologo DATE,
                    sexo_psicologo ENUM('masculino', 'femenino', 'otro') NOT NULL,
                    pareja_sino_psicologo BOOLEAN,
                    hijos_sino_psicologo BOOLEAN,
                    especialidad_psicologo VARCHAR(255),
                    experiencia_psicologo INT,
                    estudios_psicologo VARCHAR(255),
                    hobbies_psicologo TEXT,
                    foto_psicologo VARCHAR(255),
                    PRIMARY KEY (id_psicologo),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );
                CREATE TABLE CITA (
                    id_cita INT AUTO_INCREMENT,
                    id_paciente INT NOT NULL,
                    id_psicologo INT NOT NULL,
                    fecha_cita DATE NOT NULL,
                    hora_cita TIME NOT NULL,
                    PRIMARY KEY (id_cita),
                    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );
                CREATE TABLE PACIENTE_PSICOLOGO (
                    id_paciente INT,
                    id_psicologo INT,
                    fecha_inicio DATE NOT NULL,
                    PRIMARY KEY (id_paciente, id_psicologo),
                    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );
                CREATE TABLE VIDEOLLAMADA (
                    id_videollamada INT AUTO_INCREMENT,
                    id_paciente INT NOT NULL,
                    id_psicologo INT NOT NULL,
                    enlace_videollamada VARCHAR(255) NOT NULL,
                    PRIMARY KEY (id_videollamada),
                    FOREIGN KEY (id_paciente) REFERENCES PACIENTE(id_paciente),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );
                CREATE TABLE REGISTRO_CITA (
                    id_cita INT,
                    grabacion_cita VARCHAR(255),
                    PRIMARY KEY (id_cita),
                    FOREIGN KEY (id_cita) REFERENCES CITA(id_cita)
                );
                CREATE TABLE ARTICULO (
                    id_articulo INT AUTO_INCREMENT,
                    id_psicologo INT NOT NULL,
                    titulo_articulo VARCHAR(255) NOT NULL,
                    descripcion_articulo TEXT,
                    imagen_articulo VARCHAR(255),
                    PRIMARY KEY (id_articulo),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );
                CREATE TABLE ENTRADA_ARTICULO (
                    id_articulo INT,
                    contenido_articulo TEXT NOT NULL,
                    multimedia_articulo VARCHAR(255),
                    PRIMARY KEY (id_articulo),
                    FOREIGN KEY (id_articulo) REFERENCES ARTICULO(id_articulo)
                );
                CREATE TABLE TALLER (
                    id_taller INT AUTO_INCREMENT,
                    id_psicologo INT NOT NULL,
                    titulo_taller VARCHAR(255) NOT NULL,
                    descripcion_taller TEXT,
                    enlace_taller VARCHAR(255),
                    PRIMARY KEY (id_taller),
                    FOREIGN KEY (id_psicologo) REFERENCES PSICOLOGO(id_psicologo)
                );
                CREATE TABLE MENSAJES (
                    msg_id INT AUTO_INCREMENT,
                    msg_entrada_id INT,
                    msg_salida_id INT,
                    msg VARCHAR(1000),
                    PRIMARY KEY (msg_id)
                );
                ";
            // Ejecutar las consultas de creación de BBDD y tablas
            if (mysqli_multi_query($conexion, $sql)) {
            } else {
                echo "Error al crear las tablas: " . mysqli_error($conexion);
            }

            $bd->cerrar();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
// Función insertarDatos
function insertarDatos()
{
    // Creamos una instancia
    $bd = new BaseDeDatos();
    try {
        // Nos conectamos
        if ($bd->conectar()) {
            $conexion = $bd->getConexion();

            $sql_insert = "
                USE Stay;

                INSERT INTO PACIENTE (nombre_paciente, apellidos_paciente, correo_paciente, telefono_paciente)
                VALUES 
                ('John', 'Doe', 'doejohn@gmail.com', '600 100 200'),
                ('Jane', 'Doe', 'doejane@gmail.com', '600 101 201'),
                ('Jim', 'Beam', 'beamjim@gmail.com', '600 102 202'),
                ('Jack', 'Daniels', 'danielsjack@gmail.com', '600 103 203'),
                ('Josie', 'Wales', 'walesjosie@gmail.com', '600 104 204');

                INSERT INTO PSICOLOGO (nombre_psicologo, apellidos_psicologo, correo_psicologo, tel_psicologo, linkedin_psicologo, cv_psicologo)
                VALUES 
                ('Dr. Anna', 'Smith', 'smithanna@gmail.com', '610 200 300', 'linkedin.com/in/annasmith', 'cv/annasmith.pdf'),
                ('Dr. Brian', 'Taylor', 'taylorbrian@gmail.com', '610 201 301', 'linkedin.com/in/briantaylor', 'cv/briantaylor.pdf'),
                ('Dr. Carol', 'Jones', 'jonescarol@gmail.com', '610 202 302', 'linkedin.com/in/caroljones', 'cv/caroljones.pdf'),
                ('Dr. David', 'Brown', 'browndavid@gmail.com', '610 203 303', 'linkedin.com/in/davidbrown', 'cv/davidbrown.pdf'),
                ('Dr. Emily', 'White', 'whiteemily@gmail.com', '610 204 304', 'linkedin.com/in/emilywhite', 'cv/emilywhite.pdf');

                -- Para pacientes
                INSERT INTO USUARIO (correo_usuario, contrasena_usuario, tipo_usuario, id_original)
                VALUES 
                ('doejohn@gmail.com', 'Jd2021$45', 'paciente', 1),
                ('doejane@gmail.com', 'Jane#879', 'paciente', 2),
                ('beamjim@gmail.com', 'Jb!3098', 'paciente', 3),
                ('danielsjack@gmail.com', 'JackD@1234', 'paciente', 4),
                ('walesjosie@gmail.com', 'Josie*5321', 'paciente', 5);

                -- Para psicólogos
                INSERT INTO USUARIO (correo_usuario, contrasena_usuario, tipo_usuario, id_original)
                VALUES 
                ('smithanna@gmail.com', 'AnnaS1975$', 'psicologo', 1),
                ('taylorbrian@gmail.com', 'BTaylor@2021', 'psicologo', 2),
                ('jonescarol@gmail.com', 'CJones!980', 'psicologo', 3),
                ('browndavid@gmail.com', 'DBrown#1985', 'psicologo', 4),
                ('whiteemily@gmail.com', 'EmilyW1990!', 'psicologo', 5);

                INSERT INTO PERFIL_PACIENTE (id_paciente, fecha_nac_paciente, sexo_paciente, pareja_sino_paciente, hijos_sino_paciente, trabajo_paciente, estudios_paciente, hobbies_paciente, expectativasypreocupaciones_paciente, foto_paciente)
                VALUES 
                (1, '1980-04-23', 'masculino', TRUE, FALSE, 'Ingeniero', 'Grado en Ingeniería', 'Leer, Escalar', 'Espero mejorar mi gestión del estrés', 'foto_john.jpg'),
                (2, '1985-05-16', 'femenino', FALSE, TRUE, 'Doctora', 'Doctorado en Medicina', 'Yoga, Pintar', 'Quiero aprender a equilibrar trabajo y vida personal', 'foto_jane.jpg'),
                (3, '1990-07-08', 'masculino', TRUE, TRUE, 'Abogado', 'Licenciatura en Derecho', 'Correr, Viajar', 'Necesito ayuda para lidiar con la ansiedad', 'foto_jim.jpg'),
                (4, '1995-08-19', 'masculino', FALSE, FALSE, 'Artista', 'Diplomado en Bellas Artes', 'Música, Poesía', 'Busco formas de potenciar mi creatividad', 'foto_jack.jpg'),
                (5, '2000-12-12', 'femenino', TRUE, FALSE, 'Emprendedora', 'MBA', 'Cocinar, Blogging', 'Deseo mejorar mis habilidades de comunicación', 'foto_josie.jpg');

                INSERT INTO PERFIL_PSICOLOGO (id_psicologo, fecha_nac_psicologo, sexo_psicologo, pareja_sino_psicologo, hijos_sino_psicologo, especialidad_psicologo, experiencia_psicologo, estudios_psicologo, hobbies_psicologo, foto_psicologo)
                VALUES 
                (1, '1975-03-15', 'femenino', TRUE, TRUE, 'Terapia Cognitiva', 15, 'Doctorado en Psicología', 'Jardinería, Meditación', 'foto_anna.jpg'),
                (2, '1970-06-22', 'masculino', FALSE, FALSE, 'Psicología Clínica', 20, 'Doctorado en Psicología Clínica', 'Ajedrez, Fotografía', 'foto_brian.jpg'),
                (3, '1980-11-30', 'femenino', TRUE, FALSE, 'Psicología Infantil', 10, 'Master en Psicología Infantil', 'Escritura, Ciclismo', 'foto_carol.jpg'),
                (4, '1985-02-28', 'masculino', TRUE, TRUE, 'Terapia de Parejas', 8, 'Master en Terapia Familiar', 'Cocina, Buceo', 'foto_david.jpg'),
                (5, '1990-09-14', 'femenino', FALSE, TRUE, 'Mindfulness y Estrés', 5, 'Master en Mindfulness', 'Pilates, Lectura', 'foto_emily.jpg');

                INSERT INTO CITA (id_paciente, id_psicologo, fecha_cita, hora_cita)
                VALUES 
                (1, 1, '2023-01-10', '09:00:00'),
                (2, 1, '2023-01-12', '11:30:00'),
                (3, 2, '2023-01-15', '10:00:00'),
                (4, 2, '2023-01-18', '14:30:00'),
                (5, 3, '2023-01-20', '16:00:00');

                INSERT INTO PACIENTE_PSICOLOGO (id_paciente, id_psicologo, fecha_inicio)
                VALUES 
                (1, 1, '2023-01-01'),
                (2, 1, '2023-01-03'),
                (3, 2, '2023-01-06'),
                (4, 2, '2023-01-10'),
                (5, 3, '2023-01-13');

                INSERT INTO VIDEOLLAMADA (id_paciente, id_psicologo, enlace_videollamada)
                VALUES 
                (1, 1, 'https://meet.jit.si/SmithJohnDoe'),
                (2, 1, 'https://meet.jit.si/SmithJaneDoe'),
                (3, 2, 'https://meet.jit.si/TaylorJimBeam'),
                (4, 2, 'https://meet.jit.si/TaylorJackDaniels'),
                (5, 3, 'https://meet.jit.si/JonesJosieWales');

                INSERT INTO REGISTRO_CITA (id_cita, grabacion_cita)
                VALUES 
                (1, 'grabaciones/smith_john_doe_1.mp4'),
                (2, 'grabaciones/smith_jane_doe_2.mp4'),
                (3, 'grabaciones/taylor_jim_beam_1.mp4'),
                (4, 'grabaciones/taylor_jack_daniels_1.mp4'),
                (5, 'grabaciones/jones_josie_wales_1.mp4');

                INSERT INTO ARTICULO (id_psicologo, titulo_articulo, descripcion_articulo, imagen_articulo)
                VALUES 
                (1, 'La importancia de la mindfulness', 'Un artículo sobre cómo la mindfulness puede mejorar tu vida', 'imagen_articulo1.jpg'),
                (2, 'Gestión del estrés en el trabajo', 'Estrategias efectivas para manejar el estrés laboral', 'imagen_articulo2.jpg'),
                (3, 'Relaciones saludables', 'Consejos para construir y mantener relaciones saludables', 'imagen_articulo3.jpg'),
                (4, 'El poder del pensamiento positivo', 'Cómo el pensamiento positivo puede influir en tu día a día', 'imagen_articulo4.jpg'),
                (5, 'Desarrollo personal a través de la psicología', 'Explorando las herramientas que la psicología ofrece para el desarrollo personal', 'imagen_articulo5.jpg');

                INSERT INTO ENTRADA_ARTICULO (id_articulo, contenido_articulo, multimedia_articulo)
                VALUES 
                (1, 'html_articulos/articulo1.html', 'multimedia/articulo1/'),
                (2, 'html_articulos/articulo2.html', 'multimedia/articulo2/'),
                (3, 'html_articulos/articulo3.html', 'multimedia/articulo3/'),
                (4, 'html_articulos/articulo4.html', 'multimedia/articulo4/'),
                (5, 'html_articulos/articulo5.html', 'multimedia/articulo5/');


                INSERT INTO TALLER (id_psicologo, titulo_taller, descripcion_taller, enlace_taller)
                VALUES 
                (1, 'Taller de Mindfulness', 'Un taller práctico sobre la aplicación de la mindfulness', 'https://workshop.com/taller1'),
                (2, 'Gestión del Estrés 101', 'Aprende técnicas para gestionar el estrés efectivamente', 'https://workshop.com/taller2'),
                (3, 'Construyendo Relaciones Saludables', 'Un taller sobre cómo construir relaciones saludables y duraderas', 'https://workshop.com/taller3'),
                (4, 'Pensamiento Positivo para el Día a Día', 'Técnicas para incorporar el pensamiento positivo en tu vida diaria', 'https://workshop.com/taller4'),
                (5, 'Herramientas de Psicología para el Desarrollo Personal', 'Explora herramientas psicológicas para tu desarrollo personal', 'https://workshop.com/taller5');
                                
                
                ";
            // Ejecutar las consultas de inserción de datos
            if (mysqli_multi_query($conexion, $sql_insert)) {
            } else {
                echo "Error al insertar los datos:" . mysqli_error($conexion);
            }

            $bd->cerrar();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
// Crea tablas e inserta datos solo si no existe Ambulatorio
if (!existeAmbulatorio()) {
    crearTablas();
    insertarDatos();
}
