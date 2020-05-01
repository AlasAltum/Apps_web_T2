<?php
require_once("diccionarios.php");
require_once("validaciones.php");
require_once('db_config.php');
require_once('consultas.php');

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

if(!checkDireccion($_POST)){
    $errores[] = "Dirección Inválida.";
}
if(!checkTwitter($_POST)){
    $errores[] = "Twitter inválido.";
}
if(!checkEmail($_POST)){
    $errores[] = "Email inválido.";
}
if(count($errores)>0){//Si el arreglo $errores tiene elementos, debemos mostrar el error.
    header("Location: agregar_datos_de_medico.php?errores=".implode($errores, "<br>"));//Redirigimos al formulario inicio con los errores encontrados
    return; //No dejamos que continue la ejecución
}

//Si llegamos aqui, las validaciones pasaron
//TODO: Create getRegion and getComuna in dictionary
$region_medico = getRegion($_POST['region-medico']);
$comuna_medico = getComuna($_POST['masa']);
$nombre_medico = $_POST['nombre-medico'];
$experiencia_medico = $_POST['experiencia-medico'];
$especialidades_medico = $_POST['especialidades-medico']; //TODO: Check whether it results in array
$foto_medico = $_POST['foto-medico']; //TODO: Special care for this
$twitter_medico = $_POST['twitter-medico'];
$email_medico = $_POST['email-medico'];
$celular_medico = $_POST['celular-medico'];


//Guardamos en base de datos
$db = DbConfig::getConnection();
$res = saveDoctorIntoDB($db, $region_medico, $comuna_medico, $nombre_medico, $experiencia_medico, $especialidades_medico, $foto_medico, $twitter_medico, $email_medico, $celular_medico);
$db->close();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="taller4.css" type="text/css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
<h1>Confirmación: Médico guardado</h1>
<p>
    Señor <?php echo $nombre_medico; ?>,<br />

    Hemos agregado su información como médico <?php echo $especialidades_medico; ?>. En la siguiente comuna <?php echo getComuna($comuna_medico); ?>
</p>

<p>Fue anotado  con el twitter <?php echo $twitter_medico; ?>.</p>
<p>¡Gracias por su servicio!</p>
</body>
</html>