<?php


function prepareDoctorStatement($db, $nombre_medico, $experiencia_medico, $comuna_medico, $twitter_medico, $email_medico, $celular_medico){
//prepare statement
//inserting a doctor into the database for medico
    $stmt = $db->prepare("INSERT INTO medico (nombre, experiencia, comuna_id, twitter, email, celular) VALUES (?, ?, ?, ?, ?, ?)");
    $nombre_bd = limpiar($db, $nombre_medico);
    $experiencia_bd = limpiar($db, $experiencia_medico);
    $comuna_bd = limpiar($db, $comuna_medico);
    $twitter_bd = limpiar($db, $twitter_medico);
    $email_bd = limpiar($db, $email_medico);
    $celular_bd = limpiar($db, $celular_medico);
    $stmt->bind_param("ssissd", $nombre_bd, $experiencia_bd, $comuna_bd, $twitter_bd, $email_bd, $celular_bd);
    return $stmt;
}


/*
 * Retorna arreglo con los ids y descripciones.
 */
function getEspecialidades($db){
    $sql = "SELECT id, descripcion FROM especialidad";
    $result = $db->query($sql);
    $ret = array();
    while ($row = $result->fetch_assoc()) {
        $ret[] = $row;
    }
    return $ret;
}

function mapEspecialidades($table, $ids){
    $ret = array();
    foreach ($ids as $esp_id){
        $esp_id = $esp_id - 1;
        $ret[] = $table[$esp_id]['descripcion'];
    }
    return $ret;
}

/*
Recibe la base de datos y retorna las comunas
*/
function getRegiones($db){
    $sql = "SELECT id, nombre FROM region";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}

//
function getRegion($name){
    $db = dbconfig::getConnection();
    $regiones = getRegiones($db);
    $db->close();
    $pieces = explode(' ', $name);
    $last_word = array_pop($pieces);
    //nos quedamos con la última palabra de la región dada, por si hay inconsistencias con de / del y demás.
    foreach ($regiones as $key => $region){
        $posible_match = "/(" . $last_word .")/";
        if (preg_match($posible_match, $region['nombre'])){
            return $region['id'];
        }
    }
    return false;
}

/*
Recibe la base de datos y retorna las comunas
*/
function getComunas($db, $region_id){
    $sql = "SELECT id, nombre FROM comuna WHERE region_id = {$region_id}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
	return $res;
}

/*
Recibe la base de datos y retorna las comunas
*/
function getComunaFromId($comuna_id){
    $db = dbconfig::getConnection();
    $sql = "SELECT id, nombre FROM comuna WHERE id = {$comuna_id}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    $db->close();
    $resultado = $res[0]['nombre'];

    return $resultado;
}

//
function getComuna($name, $region_id){
    $db = dbconfig::getConnection();
    $comunas = getComunas($db, $region_id);
    $db->close();
    /*
     * Viendo el caso en que la comuna en javascript viene con tilde, pero en la base de datos no D:< qué paja
     */
    $unwanted_array = array(  'À'=>'A', 'Á'=>'A','È'=>'E', 'É'=>'E',
        'Ú'=>'U', 'à'=>'a', 'á'=>'a', 'Ì'=>'I', 'Í'=>'I', 'Ò'=>'O', 'Ó'=>'O', 'Ù'=>'U',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ì'=>'i', 'í'=>'i', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ù'=>'u', 'ú'=>'u');
    $name = strtr($name, $unwanted_array);
    foreach ($comunas as $key => $comuna){
        $posible_match = "/(" . $name .")/";
        if (preg_match($posible_match, $comuna['nombre'])){
            return $comuna['id'];
        }
    }
    return False;
}


?>