<?php
define( 'ROOT', getcwd()."/../" );
require_once("diccionarios.php");
require_once("validaciones.php");
require_once('db_config.php');
require_once('file_processing.php');

function limpiar($db, $str){
    return htmlspecialchars($db->real_escape_string($str));
}


function saveDoctorIntoDB($db, $nombre_medico, $experiencia_medico, $comuna_medico, $twitter_medico, $email_medico, $celular_medico, $especialidades_medico, $rutas_fotos_medicos, $nombres_fotos_medicos){
    //prepare statement
    //inserting a doctor into the database for medico
    //bind it.
    $stmt = prepareDoctorStatement($db, $nombre_medico, $experiencia_medico, $comuna_medico, $twitter_medico, $email_medico, $celular_medico);
    // we need doctor id:
    if (!$stmt) {
        throw new Exception($db->error);
    }
    if ($stmt->execute()) { //if it was successfully executed, get insert id
        $doctor_id = $db->insert_id; //this is the doctor id
        //Adding into especialidad-medico db
        foreach ($especialidades_medico as $especialidad_id) {
            $esp_stamt = $db->prepare("INSERT INTO especialidad_medico (medico_id, especialidad_id) VALUES (?, ?)");
            $especialidad_id = limpiar($db, $especialidad_id);
            $esp_stamt->bind_param("ii", $doctor_id, $especialidad_id);
            if (!$esp_stamt->execute()){
                return False;
            }
        }
        //now we need to add the pics
        foreach ($rutas_fotos_medicos as $key => $ruta_foto) {
            $pic_stmt = $db->prepare("INSERT INTO foto_medico (ruta_archivo, nombre_archivo, medico_id) VALUES (?, ?, ?)");
            $pic_stmt->bind_param("ssi", $ruta_foto, $nombres_fotos_medicos[$key], $doctor_id);
            if (!$pic_stmt->execute()){
                return False;
            }
        }
        if ($pic_stmt && $esp_stamt){
            return True;
        }
    }
    return false;
}

$errores = array();

if(!checkComuna($_POST, 'comuna-medico')){
    $errores[] = "Comuna inválida.";
}

if(!checkName($_POST, 'nombre-medico')){
    $errores[] = "Nombre inválido.";
}

if(!checkExperiencia($_POST, 'experiencia-medico')){
    $errores[] = "Experiencia inválida.";
}

if(!checkEspecialidades($_POST, 'especialidades-medico')){
    $errores[] = "Especialidades inválidas.";
}

if(!checkTwitter($_POST, 'twitter-medico')){
    $errores[] = "Twitter inválido.";
}

if(!checkEmail($_POST, 'email-medico')){
    $errores[] = "Email inválido.";
}

if(!checkFoto($_FILES, 'foto-medico')){
    $errores[] = "Archivo de foto subido no válido.";
}

if (!checkNumber($_POST, 'celular-medico')){
    $errores[] = "Número equivocado.";
}

if(count($errores)>0){//Si el arreglo $errores tiene elementos, debemos mostrar el error.
    header("Location: agregar_datos_de_medico.php?errores=".implode($errores, "<br>"));//Redirigimos al formulario inicio con los errores encontrados
    return; //No dejamos que continue la ejecución
}

$region_medico = getRegion($_POST['region-medico']);
$nombre_comuna = $_POST['comuna-medico'];
$comuna_medico = getComuna($_POST['comuna-medico'], $region_medico);
$nombre_medico = $_POST['nombre-medico'];
$experiencia_medico = $_POST['experiencia-medico'];
$especialidades_medico = $_POST['especialidades-medico'];
$twitter_medico = $_POST['twitter-medico'];
$email_medico = $_POST['email-medico'];
$celular_medico = $_POST['celular-medico'];

$fotos_medicos = fileTransfer($_FILES, 'foto-medico', 'fotos_medicos'); //the name of the pictures.
$rutas_fotos_medicos = $fotos_medicos[0];
$nombres_fotos_medicos = $fotos_medicos[1];

$db = DbConfig::getConnection();
$nombres_especialidades = mapEspecialidades(getEspecialidades($db), $especialidades_medico);
$res = saveDoctorIntoDB($db, $nombre_medico, $experiencia_medico, $comuna_medico, $twitter_medico, $email_medico, $celular_medico, $especialidades_medico, $rutas_fotos_medicos, $nombres_fotos_medicos);
$db->close();
?>

<!DOCTYPE html>
<html>

<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title> Tarea N° 2</title> <!-- Title in pestaña -->
        <link rel="stylesheet" type="text/css" media="screen"  href="../tarea1.css" />    <!-- CSS: -->
        <script src="../jquery-3.5.0.js"></script>  <!-- Importing JQUERY  -->
    </head>

</head>

<body>

<ul class="topnav">
    <li><a class="active" href="inicio.html">Inicio</a></li>
    <li><a href="../agregar_datos_de_medico.php">Agregar Datos de Médico</a></li>
    <li><a href="../ver_medicos.php">Ver Médicos</a></li>
    <li><a href="../publicar_solicitud_de_atencion.php">Publicar Solicitud de Atención</a></li>
    <li><a href="../ver_solicitudes_de_atencion.php">Ver Solicitudes de Atención</a></li>
</ul>

<h1>Confirmación: Médico guardado</h1>
<p>
    <?php echo $nombre_medico; ?>,<br/>

    Hemos agregado su información como médico con especialiades
    en: <?php echo '' . implode(', ', $nombres_especialidades) . ''; ?>.
    <br>
    Con inscripción en la comuna de <?php echo(getComunaFromId($comuna_medico)); ?>.
    <br>
    Bajo el twitter <?php echo $twitter_medico; ?>.
    <br>
    ¡Gracias por su servicio!
</body>
</html>