<?php
$comunas_with_doctors = getComunasWithDoctors($db);
$ubications = array();

foreach($comunas_with_doctors as $comuna){
    $ubications[] = $comuna['nombre_comuna'];
}

$string = file_get_contents("comunas_chile.json");
$json_a = json_decode($string, true);

$json_comuna_ubication = array(); //comuna, lat, long
//TODO: Add number of doctors


foreach($json_a as $comuna){
    if (in_array($comuna['name'], $ubications)){
        $json_comuna_ubication[] = array('comuna' => $comuna['name'],
            'lat' => $comuna['lat'], 'long' => $comuna['lng'],
            'num_doctors' => 0,
        );
    }
}

?>