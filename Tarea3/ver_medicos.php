<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8"/> <!-- Declaring enconding as UTF 8-->
    <title> Tarea N° 2</title> <!-- Title in pestaña -->
    <link rel="stylesheet" type="text/css" media="screen" href="tarea1.css"/>    <!-- CSS: -->
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
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
    require_once(ROOT . '/BackEnd/gethint.php');
    //Ver médicos en la base de datos y mostrarlos.
    $offset = 0;
    $db = DbConfig::getConnection();
    $doctors = getDoctors($db, $offset);
    $table_especialidades = getEspecialidades($db);

    function button1() {
        global $offset;
        if ($offset >= 5) { $offset = $offset - 5; }
    }

    function button2() {
        global $offset;
        $offset = $offset + 5;
    }

    function displayDoctor($table_especialidades, $db, $doctor){
        $especialidades_medico = getEspecialidadesFromDoctorId($db, $doctor['id']);
        $especialidades_medico = mapEspecialidades($table_especialidades, $especialidades_medico);

        $nombre_medico = $doctor['nombre'];
        $comuna_id = getComunaFromId($doctor['comuna_id']);
        $twitter = $doctor['twitter'];
        $email = $doctor['email'];
        $celular = $doctor['celular'];

        echo("<tr>");
        echo("<td> <a href='detalle_medico.php?id_medico={$doctor['id']}'>" . $nombre_medico . "</a>  </td>");
        echo("<td> <a href='detalle_medico.php?id_medico={$doctor['id']}'>" . implode(', ', $especialidades_medico) . '' . "</a> </td>");
        echo("<td> <a href='detalle_medico.php?id_medico={$doctor['id']}'>" . $comuna_id . "</a>  </td>");
        echo("<td> <a href='detalle_medico.php?id_medico={$doctor['id']}'>" . $email . "<br>" . $twitter . "<br>" . $celular . "</a>  </td>");
        echo("</a> </tr>");
    }


    if(array_key_exists('button1', $_POST)) {
        button1();
        $doctors = getDoctors($db, $offset);
    }
    else if(array_key_exists('button2', $_POST)) {
        button2();
        $doctors = getDoctors($db, $offset);
    }


    ?>

    <form method="post">
        <input type="submit" name="button1" value="Atrás"/>
        <input type="submit" name="button2" value="Adelante"/>
    </form>
</div>
<div>
  <!-- Body of page -->
    <h1> Ver Médicos </h1>

    <!-- Parte relacionada con la búsqueda de médicos.    -->
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
                xmlhttp.open("GET", "./BackEnd/gethint.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
    <form action="">
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname" onkeyup="showHint(this.value)" class='auto'>
    </form>
<!--     Here are suggestions displayed-->
    <p>Suggestions: <span id="txtHint"></span></p>

    <table>
        <tr>
            <th>Nombre Médico</th>
            <th>Especialidades</th>
            <th>Comuna</th>
            <th>Datos Contacto</th>
        </tr>

        <?php //display doctors in table
        foreach ($doctors as $doc) {
            displayDoctor($table_especialidades, $db, $doc);
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
            source: "BackEnd/autocomplete_doc_names.php",
            minLength: 3
        });
    });

</script>

</body>
</html>