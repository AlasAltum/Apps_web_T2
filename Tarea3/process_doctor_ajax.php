<?php
require_once('./BackEnd/db_config.php');
require_once('./BackEnd/diccionarios.php');

function displayFoto($ruta_foto, $nombre_medico){
    $id = 'id="change' . $ruta_foto . '" ';
    $src = 'src="./Files/fotos_medicos/' . $ruta_foto . '" ';
    $alt = 'alt = "Foto de ' . $nombre_medico . '" ';
    $style = ' height = "320" width ="200" style="width:240px; height:320px;" ';
    $onclick='onClick="Agrandar(\'change' .$ruta_foto . '\')"';
    $disp = '<img ' . $id . $src . $alt . $style . $onclick . '>';
    return $disp;
}

if (isset($_REQUEST['comuna'])) {
    $db = DbConfig::getConnection();
    $table_especialidades = getEspecialidades($db);


    $nombre_comuna = $_REQUEST['nombre_comuna'];
    $id_comuna = getComunaFromId($nombre_comuna);

    $doctors_in_comuna = getDoctorsGivenComuna($db, $id_comuna);
    $temp = array();

    foreach ($doctors_in_comuna as $doctor) {
        $doctor_id = $doctor['id'];
        $nombre_medico = $doctor['nombre'];
        $twitter = $doctor['twitter'];
        $email = $doctor['email'];
        $celular = $doctor['celular'];

        //todo: GET FOTOS MEDICOS GIVEN HIS ID
        $rutas_fotos = getRutasFotosGivenMedicoId($db, $doctor_id);
        $ids_especialidades_medico = getEspecialidadesFromDoctorId($db, $doctor_id);
        $nombres_especialidades = mapEspecialidades(getEspecialidades($db), $ids_especialidades_medico);


        $temp[] = array('nombre' => $nombre_medico,
            'twitter' => $twitter, 'email' => $email,
            'celular' => $celular, 'especialidades' => $nombres_especialidades,
            "foto" => displayFoto()
        );
    }

    echo(json_encode($temp));
}


?>