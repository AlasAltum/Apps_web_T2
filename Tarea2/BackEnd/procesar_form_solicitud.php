<?php
define( 'ROOT', getcwd()."/../" );
require_once("diccionarios.php");
require_once("validaciones.php");
require_once('db_config.php');


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
$region_medico = getRegion($_POST['region-medico']);
$nombre_comuna = $_POST['comuna-medico'];
$comuna_medico = getComuna($_POST['comuna-medico'], $region_medico);
$nombre_medico = $_POST['nombre-medico'];
$experiencia_medico = $_POST['experiencia-medico'];
$especialidades_medico = $_POST['especialidades-medico'];
$twitter_medico = $_POST['twitter-medico'];
$email_medico = $_POST['email-medico'];
$celular_medico = $_POST['celular-medico'];

$fotos_medicos = pictureTransfer($_FILES); //the name of the pictures.
$rutas_fotos_medicos = $fotos_medicos[0];
$nombres_fotos_medicos = $fotos_medicos[1];
//Guardamos en base de datos
//TODO: Transform iquique into number
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
        <link rel="stylesheet" type="text/css" media="screen"  href="tarea1.css" />    <!-- CSS: -->
        <script src="jquery-3.5.0.js"></script>  <!-- Importing JQUERY  -->
    </head>

</head>

<body>
<h1>Confirmación: Médico guardado</h1>
<p>
    Señor <?php echo $nombre_medico; ?>,<br />

    Hemos agregado su información como médico con especialiades en: <?php echo ''.implode(', ', $nombres_especialidades).''; ?>.
    <br>
    Fue inscrito en la comuna de <?php echo (getComunaFromId($comuna_medico)); ?>.
    <br>
    Fue anotado  con el twitter <?php echo $twitter_medico; ?>.
    <br>
    ¡Gracias por su servicio!
</body>
</html>