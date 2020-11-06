<?php
require_once('./BackEnd/db_config.php');
require_once('./BackEnd/diccionarios.php');

$request = $_GET['id'];

$db = DbConfig::getConnection();



function displayFoto($ruta_foto, $nombre_medico){
    $id = 'id="change' . $ruta_foto . '" ';
    $src = 'src="./Files/fotos_medicos/' . $ruta_foto . '" ';
    $alt = 'alt = "Foto de ' . $nombre_medico . '" ';
    $style = ' height = "320" width ="200" style="width:240px; height:320px;" ';
    $onclick='onClick="Agrandar(\'change' .$ruta_foto . '\')"';
    $disp = '<img ' . $id . $src . $alt . $style . $onclick . '> <br>';
    return $disp;
}

$doctor = getDoctorWithId($db, $request)[0];
$nombre_medico = $doctor['nombre'];

//todo: GET FOTOS MEDICOS GIVEN HIS ID
$rutas_fotos = getRutasFotosGivenMedicoId($db, $request);


foreach ($rutas_fotos as $ruta_foto) {
    $disp = displayFoto($ruta_foto['nombre_archivo'], $nombre_medico);
    echo($disp);
}

?>
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