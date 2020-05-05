<?php
define( 'ROOT', getcwd()."/../" );
require_once("diccionarios.php");
require_once("validaciones.php");
require_once('db_config.php');


function limpiar($db, $str){
    return htmlspecialchars($db->real_escape_string($str));
}


function saveDoctorIntoDB($db, $region_medico, $comuna_medico, $nombre_medico, $experiencia_medico, $especialidades_medico, $foto_medico, $twitter_medico, $email_medico, $celular_medico){
    //prepare statement
    //inserting a doctor into the database for medico
    /*
    $stmt = $db->prepare("INSERT INTO medico (nombre, experiencia, comuna_id, twitter, email, celular) VALUES (?, ?, ?, ?, ?, ?)");
    $nombre_bd = limpiar($db, $nombre_medico);
    $experiencia_bd = limpiar($db, $experiencia_medico);
    $comuna_bd = limpiar($db, $comuna_medico);
    $twitter_bd = limpiar($db, $twitter_medico);
    $email_bd = limpiar($db, $email_medico);
    $celular_bd = limpiar($db, $celular_medico);
    $stmt->bind_param("ssdsss", $nombre_bd, $experiencia_bd, $comuna_bd, $twitter_bd, $email_bd, $celular_bd);
    // we need doctor id:
    if ($stmt->execute()) { //if it was successfully executed, get insert id
        $last_id = $db->insert_id;
    }
    else {
        echo ("\nError inserting medico.\n");
        return; //error
    }


    //inserting into database for foto_medico
    $stmt_foto = $db->prepare("INSERT INTO foto_medico (ruta_archivo, nombre_archivo, medico_id) VALUES (?, ?, ?)");
    $nombre_bd = limpiar($db, $nombre_medico);
    //TODO: Check whether this might turn into an error.
    $ruta_archivo = __DIR__ . "/../Files/fotos_medico/";
    $stmt_foto->bind_param("ssd", $ruta_archivo , $nombre_archivo, $last_id);

    //inserting into especialidad_medico
    //insertar una especialidad de un medico
    $stmt_especialidad = $db->prepare("INSERT INTO especialidad_medico (medico_id, especialidad_id) VALUES (?, ?)");
    */

    return true;
}


$errores = array();

if(!checkComuna($_POST)){
    $errores[] = "Comuna inválida.";
}

if(!checkName($_POST)){
    $errores[] = "Nombre inválido.";
}

if(!checkExperiencia($_POST)){
    $errores[] = "Experiencia inválida.";
}

if(!checkEspecialidades($_POST)){
    $errores[] = "Especialidades inválidas.";
}

if(!checkTwitter($_POST)){
    $errores[] = "Twitter inválido.";
}

if(!checkEmail($_POST)){
    $errores[] = "Email inválido.";
}

if(!checkFoto($_FILES)){
    $errores[] = "Archivo de foto subido no válido.";
}
if(count($errores)>0){//Si el arreglo $errores tiene elementos, debemos mostrar el error.
    header("Location: agregar_datos_de_medico.php?errores=".implode($errores, "<br>"));//Redirigimos al formulario inicio con los errores encontrados
    return; //No dejamos que continue la ejecución
}

//Si llegamos aqui, las validaciones pasaron
//TODO: Create getRegion and getComuna in dictionary
//$region_medico = getRegion($_POST['region-medico']);
//$comuna_medico = getComuna($_POST['comuna-medico']);
$region_medico = $_POST['region-medico'];
$comuna_medico = $_POST['comuna-medico'];
$nombre_medico = $_POST['nombre-medico'];
$experiencia_medico = $_POST['experiencia-medico'];
$especialidades_medico = $_POST['especialidades-medico'];
$twitter_medico = $_POST['twitter-medico'];
$email_medico = $_POST['email-medico'];
$celular_medico = $_POST['celular-medico'];

$fotos_medicos = pictureTransfer($_FILES); //the name of the pictures.


//Guardamos en base de datos
$db = DbConfig::getConnection();
$res = saveDoctorIntoDB($db, $region_medico, $comuna_medico, $nombre_medico, $experiencia_medico, $especialidades_medico, $fotos_medicos, $twitter_medico, $email_medico, $celular_medico);
$db->close();
?>

<!DOCTYPE html>
<html>

<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title> Tarea N° 2</title> <!-- Title in pestaña -->
        <link rel="stylesheet" type="text/css" media="screen"  href="tarea1.css" />    <!-- CSS: -->
        <script src="jquery-3.5.0.js"></script>  <!-- Importing JQUERY  -->
    </head>

</head>

<body>
<h1>Confirmación: Médico guardado</h1>
<p>
    Señor <?php echo $nombre_medico; ?>,<br />

    Hemos agregado su información como médico <?php print_r($especialidades_medico); ?>. En la siguiente comuna <?php echo ($comuna_medico); ?>
</p>

<p>Fue anotado  con el twitter <?php echo $twitter_medico; ?>.</p>
<p>¡Gracias por su servicio!</p>
</body>
</html>