<?php
define('ROOT', getcwd());
require_once(ROOT . '/BackEnd/db_config.php');
require_once(ROOT . '/BackEnd/diccionarios.php');
require_once(ROOT . '/BackEnd/gethint.php');


if (isset($_REQUEST['query'])) {

    if ($_REQUEST['query'] == 'json') {
        $db = DbConfig::getConnection();
        $comunas_with_doctors = getComunasWithDoctors($db);
        $ubications = array();

        foreach ($comunas_with_doctors as $comuna) {
            $ubications[] = $comuna['nombre_comuna'];
        }

        $string = file_get_contents("comunas_chile.json");
        $json_a = json_decode($string, true);

        $json_comuna_ubication = array(); //comuna, lat, long
        $already_ubicated = array();

        foreach ($comunas_with_doctors as $comuna){
            //AQUÍ HAY UN ERROR: NO DEBERÍAMOS REVISAR TODO EL JSON Y CONSIDERAR AQUELLOS QUE ESTÁN
            // TODO: DEBERÍAMOS VER CADA ELEMENTO DE COMUNAS WITH DOCTORS
            //TODO: Add number of pictures of doctors
            $name_comuna = $comuna['nombre_comuna'];
            $key = array_search($name_comuna, array_column($json_a, 'name'));
            $comuna = $json_a[$key];

            if (in_array($name_comuna, $already_ubicated)){
                // Find index of comuna with this name.
                $key_comuna = array_search($name_comuna, array_column($json_comuna_ubication, 'comuna'));
                $json_comuna_ubication[$key_comuna]['num_doctors'] = $json_comuna_ubication[$key_comuna]['num_doctors'] + 1;

            } else {
                $already_ubicated[] = $name_comuna;
                $json_comuna_ubication[] = array('comuna' => $name_comuna,
                    'lat' => $comuna['lat'], 'long' => $comuna['lng'],
                    'num_doctors' => 1);
            }
        }
        $db->close();

        echo(json_encode($json_comuna_ubication));

    } else {
        $nombre_comuna = $_REQUEST['query'];
        $db = DbConfig::getConnection();

        $doctors_from_comuna = getDoctorsGivenComuna($db, $nombre_comuna);

        $table_especialidades = getEspecialidades($db);
        $ret = array();

        foreach ($doctors_from_comuna as $doc){
            $ids_especialidades_medico = getEspecialidadesFromDoctorId($db, $doc['id']);
            $nombres_especialidades = mapEspecialidades($table_especialidades, $ids_especialidades_medico);

            $nombres_especialidades = '' . implode(',  ', $nombres_especialidades) . '';

            $ret[] = array_merge($doc, array('especialidades' => $nombres_especialidades));

        }

        $db->close();

        echo(json_encode($ret));
    }

}

?>