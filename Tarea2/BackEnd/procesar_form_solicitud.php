<?php
define( 'ROOT', getcwd()."/../" );
require_once("diccionarios.php");
require_once("validaciones.php");
require_once('db_config.php');
require_once('file_processing.php');


function limpiar($db, $str){
    return htmlspecialchars($db->real_escape_string($str));
}

function saveSolicitudIntoDB($db, $nombre_solicitante, $descripcion_solicitante, $comuna_solicitante, $twitter_solicitante, $email_solicitante, $celular_solicitante, $especialidad_solicitante, $rutas_archivos_solicitante, $nombres_archivos_solicitante){
    //prepare statement
    //inserting a solicitude into the database for solicitud
    //bind it.
    $stmt = prepareSolicitudeStatement($db, $nombre_solicitante, $especialidad_solicitante, $descripcion_solicitante, $twitter_solicitante, $email_solicitante, $celular_solicitante, $comuna_solicitante);
    // we need solicitude id:
    if (!$stmt) {
        throw new Exception($db->error);
    }
    if ($stmt->execute()) { //if it was successfully executed, get insert id
        $solicitante_id = $db->insert_id; //this is the solicitude id

        //now we need to add the pics
        foreach ($rutas_archivos_solicitante as $key => $ruta_archivo) {
            $file_stmt = $db->prepare("INSERT INTO archivo_solicitud (ruta_archivo, nombre_archivo, mimetype, solicitud_atencion_id) VALUES (?, ?, ?, ?)");

            //get mime:
            $mimetype = mime_content_type($ruta_archivo);

            //TODO: rutas archivos con sus nombres, y sus tipos.
            $file_stmt->bind_param("sssi", $ruta_archivo, $nombres_archivos_solicitante[$key], $mimetype, $solicitante_id);
            if (!$file_stmt->execute()){
                return False;
            }
        }
        return True;
    }
    return false;
}


$errores = array();

if(!checkComuna($_POST, 'comuna-solicitante')){
    $errores[] = "Comuna inválida.";
}

if(!checkName($_POST, 'nombre-solicitante')){
    $errores[] = "Nombre inválido.";
}

if(!checkExperiencia($_POST, 'sintomas-solicitante')){
    $errores[] = "Experiencia inválida.";
}

if(!checkEspecialidades($_POST, 'especialidad-solicitud')){
    $errores[] = "Especialidades inválidas.";
}

if(!checkTwitter($_POST, 'twitter-solicitante')){
    $errores[] = "Twitter inválido.";
}

if(!checkEmail($_POST, 'email-solicitante')){
    $errores[] = "Email inválido.";
}

if (!checkNumber($_POST, 'celular-solicitante')){
    $errores[] = "Número equivocado.";
}

if (!checkFiles($_FILES, 'archivos-solicitante')){
    $errores[] = "Formato de archivos inválido.";
}


if(count($errores)>0){//Si el arre glo $errores tiene elementos, debemos mostrar el error.
    header("Location: publicar_solicitud_de_atencion.php?errores=".implode($errores, "<br>"));//Redirigimos al formulario inicio con los errores encontrados
    return; //No dejamos que continue la ejecución
}

//Si llegamos aqui, las validaciones pasaron
$region_solicitud = getRegion($_POST['region-solicitante']);
$nombre_comuna = $_POST['comuna-solicitante'];
$comuna_solicitud = getComuna($_POST['comuna-solicitante'], $region_solicitud);
$nombre_solicitante = $_POST['nombre-solicitante'];
$sintomas_solicitante = $_POST['sintomas-solicitante'];
$especialidad_solicitante = $_POST['especialidad-solicitud'];
$twitter_solicitante = $_POST['twitter-solicitante'];
$email_solicitante = $_POST['email-solicitante'];
$celular_solicitante = $_POST['celular-solicitante'];

$archivos_solicitante = fileTransfer($_FILES, 'archivos-solicitante', 'solicitude_files');
$rutas_archivos_solicitante = $archivos_solicitante[0];
$nombres_archivos_solicitante = $archivos_solicitante[1];
//Guardamos en base de datos
$db = DbConfig::getConnection();
$nombre_especialidad = mapEspecialidad(getEspecialidades($db), $especialidad_solicitante);
$res = saveSolicitudIntoDB($db, $nombre_solicitante, $sintomas_solicitante, $comuna_solicitud, $twitter_solicitante, $email_solicitante, $celular_solicitante, $especialidad_solicitante, $rutas_archivos_solicitante, $nombres_archivos_solicitante);
$db->close();
?>

<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title> Tarea N° 2</title> <!-- Title in pestaña -->
        <link rel="stylesheet" type="text/css" media="screen" href="../tarea1.css"/>    <!-- CSS: -->
        <script src="../jquery-3.5.0.js"></script>  <!-- Importing JQUERY  -->
    </head>

    <body>
    <ul class="topnav">
        <li><a class="active" href="inicio.html">Inicio</a></li>
        <li><a href="../agregar_datos_de_medico.php">Agregar Datos de Médico</a></li>
        <li><a href="../ver_medicos.php">Ver Médicos</a></li>
        <li><a href="../publicar_solicitud_de_atencion.php">Publicar Solicitud de Atención</a></li>
        <li><a href="../ver_solicitudes_de_atencion.php">Ver Solicitudes de Atención</a></li>
    </ul>


    <h1>Confirmación: Solicitud guardada</h1>
    <p>
        <?php echo $nombre_solicitante; ?>,<br/>

        Hemos agregado su información como solicitante de un médico con especialiad
        en: <?php echo($nombre_especialidad); ?>.
        <br>
        Con inscripción en la comuna de <?php echo(getComunaFromId($comuna_solicitud)); ?>.
        <br>
        Bajo el twitter <?php echo $twitter_solicitante; ?>.
        <br>
        ¡Gracias por preferirnos!
    </body>
</html>