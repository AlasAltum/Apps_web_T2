<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/> <!-- Declaring enconding as UTF 8-->
    <title> Tarea N° 2</title> <!-- Title in pestaña -->
    <link rel="stylesheet" type="text/css" media="screen" href="tarea1.css"/>    <!-- CSS: -->

</head>
<body>

<ul class="topnav">
    <li><a class="active" href="inicio.html">Inicio</a></li>
    <li><a href="agregar_datos_de_medico.php">Agregar Datos de Médico</a></li>
    <li><a href="ver_medicos.php">Ver Médicos</a></li>
    <li><a href="publicar_solicitud_de_atencion.php">Publicar Solicitud de Atención</a></li>
    <li><a href="ver_solicitudes_de_atencion.php">Ver Solicitudes de Atención</a></li>
</ul>


<div style="display: flex; justify-content: space-around">
    <?php
    define('ROOT', getcwd());
    require_once(ROOT . '/BackEnd/db_config.php');
    require_once(ROOT . '/BackEnd/diccionarios.php');

    $offset = 0;
    $db = DbConfig::getConnection();
    $doctors = getDoctors($db, $offset);
    $table_especialidades = getEspecialidades($db);
    $solicitudes = getSolicitudes($db, $offset);

    function button1()
    {
        global $offset;
        if ($offset >= 5) {
            $offset = $offset - 5;
        }
    }

    function button2()
    {
        global $offset;
        $offset = $offset + 5;
    }

    function displaySolicitud($table_especialidades, $solicitude)
    {
        $especialidad_solicitante = mapEspecialidad($table_especialidades, $solicitude['especialidad_id']);

        $nombre_solicitante = $solicitude['nombre_solicitante'];
        $comuna_solicitante = getComunaFromId($solicitude['comuna_id']);
        $twitter_solicitante = $solicitude['twitter'];
        $email_solicitante = $solicitude['email'];
        $celular_solicitante = $solicitude['celular'];

        echo("<tr>");
        echo("<td>" . "<a href=\"medico_jorge_p1.html\"> {$nombre_solicitante} </a>" . "</td>");
        echo("<td>" . $especialidad_solicitante . "</td>");
        echo("<td>" . $comuna_solicitante . "</td>");
        echo("<td>" . $email_solicitante . "<br>" . $twitter_solicitante . "<br>" . $celular_solicitante . "</td>");
        echo("</tr>");
    }

    if (array_key_exists('button1', $_POST)) {
        button1();
        $solicitudes = getSolicitudes($db, $offset);
    } else if (array_key_exists('button2', $_POST)) {
        button2();
        $solicitudes = getSolicitudes($db, $offset);
    }

    ?>

    <form method="post">
        <input type="submit" name="button1" value="Atrás"/>
        <input type="submit" name="button2" value="Adelante"/>
    </form>
</div>
<div>
    <!-- Body of page -->
    <!-- Body of page -->
    <h1> Ver Solicitudes de Atención </h1>
    <p>Para aquellas personas que han solicitado atención médica.
        Si usted desea realizar una solicitud, haga click en el apartado de <a
                href="publicar_solicitud_de_atencion.php">publicar una solicitud de atención</a> .
    </p>
    <table>
        <tr>
            <th>Nombre Solicitante</th>
            <th>Especialidad solicitada</th>
            <th>Comuna</th>
            <th>Datos Contacto</th>
        </tr>
        <!-- First row -->
        <?php //display doctors in table
        foreach ($solicitudes as $sol) {
            displaySolicitud($table_especialidades, $sol);
        }
        $db->close();
        ?>

    </table>
</div>

</body>
</html>
