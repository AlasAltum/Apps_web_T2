<!-- HTML5 -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title> Tarea N° 2</title> <!-- Title in pestaña -->
    <link rel="stylesheet" type="text/css" media="screen"  href="tarea1.css" />    <!-- CSS: -->

</head>
<body>

<ul class="topnav">
    <li><a class="active" href="inicio.html">Inicio</a></li>
    <li><a href="agregar_datos_de_medico.php">Agregar Datos de Médico</a></li>
    <li><a href="ver_medicos.php">Ver Médicos</a></li>
    <li><a href="publicar_solicitud_de_atencion.php">Publicar Solicitud de Atención</a></li>
    <li><a href="ver_solicitudes_de_atencion.php">Ver Solicitudes de Atención</a></li>
</ul>

<?php
require_once('./BackEnd/db_config.php');
require_once('./BackEnd/diccionarios.php');
$db = DbConfig::getConnection();

//<a href="./Files/solicitude_files/formats1588971345.pdf">formats1588971345.pdf</a> MimeType: pdf

function displayArchivo($nombre_archivo, $mime, $nombre_solicitante){
    $link = '<a href="./Files/solicitude_files/' . $nombre_archivo. ' " ' . ' >' . $nombre_archivo . '</a> ';
    $disp = $link . '  =>     MimeType:' . $mime;
    return $disp;
}

$solicitante_id = $_GET['id_solicitante'];
$solicitante = getSolicitanteWithId($db, $solicitante_id)[0];
$nombre_solicitante = $solicitante['nombre_solicitante'];
$nombre_comuna = getComunaFromId($solicitante['comuna_id']);
$twitter = $solicitante['twitter'];
$email = $solicitante['email'];
$celular = $solicitante['celular'];
$sintomas = $solicitante['sintomas'];
$region_id = getRegionIdFromComunaId($db, $solicitante['comuna_id']);
$nombre_region = getRegionWithId($db, $region_id[0]['region_id'])[0]['nombre'];

$rutas_fotos = getRutasFotosGivenMedicoId($db, $solicitante_id);

$archivos = getArchivosGivenSolicitudId($db, $solicitante_id);

//Cuando deba desplegar el listado de archivos asociados a una solicitud de atención.
// debe mostrar el nombre de cada archivo como un enlace acompañado del mime type correspondiente.
$table_especialidades = getEspecialidades($db);
$especialidad_id = $solicitante['especialidad_id'];
$especialidad = mapEspecialidad($table_especialidades, $especialidad_id);

?>
<div>
    <!-- Nombre solicitante -->
    <h1>Ficha de solicitante: <?php echo($nombre_solicitante); ?> </h1>
    <br>
    <table>
        <!-- intro row -->
        <tr>
            <th>Campo de información</th>
            <th>Información del solicitante</th>
        </tr>

        <!-- Nombre row -->
        <tr>
            <th>Nombre del Solicitante</th>
            <th><?php echo($nombre_solicitante); ?></th>
        </tr>

        <!-- Especialidad row -->
        <tr>
            <th>Especialidad requerida</th>
            <th><?php echo($especialidad); ?></th>
        </tr>

        <!-- Descripción row -->
        <tr>
            <th>Descripción de Síntomas</th>
            <th><?php echo($sintomas); ?></th>
        </tr>

        <!-- Archivos row -->
        <tr>
            <th>Archivos complementarios</th>
            <th>
                <?php
                foreach ($archivos as $archivo){
                    $nombre_archivo = $archivo['nombre_archivo'];
                    $mime = $archivo['mimetype'];
                    echo(displayArchivo($nombre_archivo, $mime, $nombre_solicitante));
                    echo("<br>");
                }

                ?>
            </th>
        </tr>

        <!-- Twitter row -->
        <tr>
            <th>Twitter del solicitante</th>
            <th><?php echo($twitter); ?></th>
        </tr>

        <!-- Email row -->
        <tr>
            <th>Email del solicitante</th>
            <th><?php echo($email); ?></th>
        </tr>

        <!-- Número row -->
        <tr>
            <th>Número de celular del Solicitante</th>
            <th><?php echo($celular); ?></th>
        </tr>

        <!-- Región row -->
        <tr>
            <th>Región del Solicitante</th>
            <th><?php echo($nombre_region); ?></th>
        </tr>

        <!-- Comuna row  -->
        <tr>
            <th>Comuna del Solicitante</th>
            <th><?php echo($nombre_comuna); ?></th>
        </tr>

</table>

</div>
</body>
</html>