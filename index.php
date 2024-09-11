<?php

require_once './data_base/db_urquiza.php';

if ($conexion) {
    $sql = "SELECT * FROM carreras";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $carreras = $stmt->fetchAll();
} else {
    $carreras = [];
    $error_message = 'No se pudo establecer conexión con la base de datos.';
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción a Carreras</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: white;
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        header {
            height: 60px;
            background-color: #1b1b32;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: white;
            z-index: 1000;
            position: fixed;
            top: 0;
            width: 100%;
        }

        header .my-logo {
            display: flex;
            align-items: center;
        }

        header img {
            height: 40px;
            margin-right: 10px;
        }

        header p {
            font-size: 1em;
            color: white;
            text-decoration: none;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 0 15px;
        }

        nav a:hover {
            color: orange;
        }

        #search-box {
            padding: 10px 0;
            text-align: right;
        }

        #search-box input {
            padding: 5px;
            border-radius: 5px;
            border: none;
        }

        main {
            margin-top: 60px;
            display: flex;
            flex: 1;
        }

        .urquiza-background {
            background-image: linear-gradient(
                0deg,
                rgba(0, 0, 0, 0.5),
                rgba(0, 0, 0, 0.5)
            ), url("https://media.lacapital.com.ar/p/3ef5662c2dbfb07f35a8c28c46627aad/adjuntos/203/imagenes/005/944/0005944959/642x0/smart/los-alumnos-la-escuela-secundaria-n49-gral-jj-urquiza-protestaron-y-abandonador-el-establecimiento-foto-s-toriggino.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            padding: 50px 20px;
            color: white;
        }

        .urquiza-background h1 {
            font-size: 2.5em;
            text-align: center;
        }

        aside {
            padding: 20px;
            background-color: #f4f4f4;
            width: 20%;
        }

        .left-aside {
            border-right: 2px solid #ddd;
        }

        .right-aside {
            border-left: 2px solid #ddd;
        }

        .carrera {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .carrera img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .carrera a {
            font-size: 1.25em;
            text-decoration: none;
            color: #1b1b32;
        }

        .carrera a:hover {
            color: coral;
        }

        .noticias {
            list-style: none;
            padding-left: 0;
        }

        .noticias li {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .noticias li h3 {
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .noticias li p {
            font-size: 0.9em;
            color: #555;
        }

        section h1 {
            text-align: center;
        }

        section p {
            border: 2px solid #1b1b32;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin: 20px 0;
        }

        .inscripcion-link {
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid #1b1b32;
            background-color: #f9f9f9;
            color: #1b1b32;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }

        .inscripcion-link:hover {
            background-color: #1b1b32;
            color: white;
        }

        @media (max-width: 768px) {
            main {
                flex-direction: column;
            }

            aside {
                width: 100%;
                border: none;
            }

            .left-aside,
            .right-aside {
                border: none;
                padding: 10px;
            }
        }

        footer {
            background-color: #1b1b32;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 10px 20px 0px 20px;
        }

        footer h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <header>
        <div class="my-logo">
            <img src="https://encrypted-tbn2.gstatic.com/faviconV2?url=https://terciariourquiza.edu.ar&client=VFE&size=64&type=FAVICON&fallback_opts=TYPE,SIZE,URL&nfrp=2" alt="urquiza logo">
            <p>Escuela Superior Nº 49<br>Capitán General Justo José de Urquiza<br>Nivel Terciario</p>
        </div>
        <nav>
            <a href="./index.php" class="nav-link">Inicio</a>
            <a href="#calendario" class="nav-link">Calendario académico</a>
            <a href="#alumnado" class="nav-link">Iniciar sesión</a>
            <a href="#contacto" class="nav-link">Contacto</a>
        </nav>
    </header>

    <div id="search-box">
        <input type="text" placeholder="Buscar...">
    </div>

    <section class="urquiza-background">
        <h1>Alumnado</h1>
    </section>


    <main>
        <aside class="left-aside">
            <h2>Seleccione una Carrera</h2>
            <?php if (isset($error_message)) { ?>
                <p><?php echo $error_message; ?></p>
            <?php } ?>
            <?php if (!empty($carreras)) { ?>
                <?php foreach ($carreras as $carrera) { ?>
                    <div class="carrera">
                        <?php if ($carrera['id'] == 1) { ?>
                            <img src="https://terciariourquiza.edu.ar/wp-content/uploads/2023/08/j_af_solo_chico-2.jpg" alt="Logo de Analista Funcional">
                        <?php } elseif ($carrera['id'] == 2) { ?>
                            <img src="https://terciariourquiza.edu.ar/wp-content/uploads/2023/08/j_ds_solo_chico.jpg" alt="Logo de Desarrollo de Software">
                        <?php } elseif ($carrera['id'] == 3) { ?>
                            <img src="https://terciariourquiza.edu.ar/wp-content/uploads/2023/08/j_iti_solo_chico.jpg" alt="Logo de Infraestructura en TI">
                        <?php } ?>
                        <a href="materias.php?carrera_id=<?php echo $carrera['id']; ?>"><?php echo $carrera['nombre']; ?></a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No hay carreras disponibles en este momento.</p>
            <?php } ?>
        </aside>

        <section>
            <h1>Bienvenidos al Modulo de Alumnado</h1>
            <p>Para inscribirte a las materias que deseas cursar en el año academico vigente, selecciona la carrera a la que estas inscripto a la izquierda para ver las materias disponibles y comenzar con el proceso de inscripción.</p>
            <a href="preinscripcion.php" class="inscripcion-link">INSCRIPCIÓN A CARRERAS DE NIVEL TERCIARIO</a>
        </section>

        <aside class="right-aside">
            <h2>Calendario 20XX</h2>
            <ul class="noticias">
                <li>
                    <h3>Inscripción a materias</h3>
                    <p>Desde xx/xx/xxxx hasta xx/xx/xxxx</p>
                </li>
                <li>
                    <h3>Presentación de documentación requerida para inscripción a carreras</h3>
                    <p>Desde xx/xx/xxxx hasta xx/xx/xxxx</p>
                </li>
                <li>
                    <h3>Presentación de documentación para homologaciones</h3>
                    <p>Desde xx/xx/xxxx hasta xx/xx/xxxx</p>
                </li>
            </ul>
        </aside>
    </main>


    <footer id="contacto">
        <h2>CONTACTO</h2>
        <hr>Bv. Oroño 690 - Rosario<br>info@terciariourquiza.edu.ar<br>(0341) 4721430<br>(0341) 4721431<br>Horarios de bedelia: Lunes a Viernes de 20 a 22 hs
    </footer>
</body>

</html>