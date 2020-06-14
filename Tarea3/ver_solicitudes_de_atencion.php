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
    $twitter = $solicitude['twitter'];
    $email = $solicitude['email'];
    $celular = $solicitude['celular'];

    echo("<tr>");
    echo("<td> <a href='detalle_solicitud.php?id_solicitante={$solicitude['id']}'>" . $nombre_solicitante . "</a>  </td>");
    echo("<td> <a href='detalle_solicitud.php?id_solicitante={$solicitude['id']}'>" . $especialidad_solicitante . "</a> </td>");
    echo("<td> <a href='detalle_solicitud.php?id_solicitante={$solicitude['id']}'>" . $comuna_solicitante . "</a>  </td>");
    echo("<td> <a href='detalle_solicitud.php?id_solicitante={$solicitude['id']}'>" . $email . "<br>" . $twitter . "<br>" . $celular . "</a>  </td>");
    echo("</a> </tr>");
}

if (array_key_exists('button1', $_POST)) {
    button1();
    $solicitudes = getSolicitudes($db, $offset);
} else if (array_key_exists('button2', $_POST)) {
    button2();
    $solicitudes = getSolicitudes($db, $offset);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title> Tarea N° 2</title> <!-- Title in pestaña -->
    <link rel="stylesheet" type="text/css" media="screen" href="tarea1.css"/>    <!-- CSS: -->
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" />

</head>
<body>

<ul class="topnav">
    <li><a class="active" href="inicio.html">Inicio</a></li>
    <li><a href="agregar_datos_de_medico.php">Agregar Datos de Médico</a></li>
    <li><a href="ver_medicos.php">Ver Médicos</a></li>
    <li><a href="publicar_solicitud_de_atencion.php">Publicar Solicitud de Atención</a></li>
    <li><a href="ver_solicitudes_de_atencion.php">Ver Solicitudes de Atención</a></li>


    <!-- Parte relacionada con la búsqueda de solicitantes.    -->
    <script>
        function showHint(str) {
            if (str.length == 0) {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            if (str.length >= 3) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "./BackEnd/gethint_solicitude.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>

</ul>


<div style="display: flex; justify-content: space-around">


    <form method="post">
        <input type="submit" name="button1" value="Atrás"/>
        <input type="submit" name="button2" value="Adelante"/>
    </form>
</div>


<div>
    <form action="">
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname" onkeyup="showHint(this.value)" class='auto'>
    </form>
    <!--     Here are suggestions displayed-->
    <p>Suggestions: <span id="txtHint"></span></p>

    <!-- Body of page -->
    <h1> Ver Solicitudes de Atención </h1>
    <p>Para aquellas personas que han solicitado atención médica.
        Si usted desea realizar una solicitud, haga click en el apartado de
        <a href="publicar_solicitud_de_atencion.php">publicar una solicitud de atención</a> .
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
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script type="text/javascript">

    $(function() {

        //autocomplete
        $(".auto").autocomplete({
            source: "BackEnd/autocomplete_sol_names.php",
            minLength: 3
        });
    });
</script>
</body>

</html>
