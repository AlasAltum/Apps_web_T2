<!-- HTML5 -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title> Tarea N° 2</title> <!-- Title in pestaña -->
    <link rel="stylesheet" type="text/css" media="screen"  href="tarea1.css" />    <!-- CSS: -->

</head>
<script>
    function Agrandar(container){
        if (document.getElementById(container).height == 320){
            document.getElementById(container).style="width:600px; height:800px;";
            document.getElementById(container).height=800;
        }
        else {
            document.getElementById(container).style="width:240px; height:320px;";
            document.getElementById(container).height=320;
        }
    }
</script>
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

function displayFoto($ruta_foto, $nombre_medico){
    $id = 'id="change' . $ruta_foto . '" ';
    $src = 'src="./Files/fotos_medicos/' . $ruta_foto . '" ';
    $alt = 'alt = "Foto de ' . $nombre_medico . '" ';
    $style = ' height = "320" width ="200" style="width:240px; height:320px;" ';
    $onclick='onClick="Agrandar(\'change' .$ruta_foto . '\')"';
    $disp = '<img ' . $id . $src . $alt . $style . $onclick . '>';
    return $disp;
}

$doctor_id = $_GET['id_medico'];
$doctor = getDoctorWithId($db, $doctor_id)[0];
$nombre_medico = $doctor['nombre'];
$nombre_comuna = getComunaFromId($doctor['comuna_id']);
$twitter = $doctor['twitter'];
$email = $doctor['email'];
$celular = $doctor['celular'];
$experiencia = $doctor['experiencia'];
$experiencia_medico = $doctor['experiencia'];
$region_id = getRegionIdFromComunaId($db, $doctor['comuna_id']);
$nombre_region = getRegionWithId($db, $region_id[0]['region_id'])[0]['nombre'];

//todo: GET FOTOS MEDICOS GIVEN HIS ID
$rutas_fotos = getRutasFotosGivenMedicoId($db, $doctor_id);


$table_especialidades = getEspecialidades($db);
$ids_especialidades_medico = getEspecialidadesFromDoctorId($db, $doctor_id);
$nombres_especialidades = mapEspecialidades(getEspecialidades($db), $ids_especialidades_medico);

?>
<div>

    <!-- Nombre médico -->
    <h1>Ficha del médico: <?php echo($nombre_medico); ?> </h1>
    <br>
    <table>
    <!-- intro row -->
        <tr>
          <th>Campo de información</th>
          <th>Información del Médico</th> 
        </tr>
    
        
    <!-- Región médico -->
    <tr>
        <th>Región del Médico</th>
        <th><?php echo($nombre_region); ?></th>
    </tr>

    <!-- Comuna row  -->
    <tr>
        <th>Comuna del Médico</th>
        <th><?php echo($nombre_comuna); ?></th>
    </tr>

    <!-- Nombre row -->
        <tr>
            <th>Nombre del médico</th>
            <th><?php echo($nombre_medico); ?></th>
        </tr>

    <!-- Experiencia row -->
    <tr>
        <th>Experiencia</th>
        <th><?php echo($experiencia_medico); ?></th>
    </tr>

    <!-- Especialidad row -->
    <tr>
        <th>Especialidades</th>
        <th><?php echo '' . implode(', ', $nombres_especialidades) . ''; ?></th>
    </tr>

    <!-- Fotos row -->
    <tr>
        <th>Fotos del Médicos</th>
        <th>
            <?php
            foreach ($rutas_fotos as $ruta_foto){
                $disp = displayFoto($ruta_foto['nombre_archivo'], $nombre_medico);
                echo ($disp);
            }
            ?>
        </th>
    </tr>

    <!-- Twitter row -->
    <tr>
        <th>Twitter del médico</th>
        <th><?php echo($twitter); ?></th>
    </tr>

    <!-- Email row -->
    <tr>
        <th>Email del médico</th>
        <th><?php echo($email); ?></th>
    </tr>

    <!-- Número row -->
    <tr>
        <th>Número de celular del médico</th>
        <th><?php echo($celular); ?></th>
    </tr>



</table>

</div>
</body>
</html>