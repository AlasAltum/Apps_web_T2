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

function prepareSolicitudeStatement($db, $nombre_solicitante, $especialidad_solicitante, $descripcion_solicitante, $twitter_solicitante, $email_solicitante, $celular_solicitante, $comuna_solicitante){
    //prepare statement
    //inserting a doctor into the database for solicitud atención
    $stmt = $db->prepare("INSERT INTO solicitud_atencion (nombre_solicitante, especialidad_id, sintomas, twitter, email, celular, comuna_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $nombre_bd = limpiar($db, $nombre_solicitante);
    $especialidad_bd = limpiar($db, $especialidad_solicitante);
    $descripcion_bd = limpiar($db, $descripcion_solicitante);
    $twitter_bd = limpiar($db, $twitter_solicitante);
    $comuna_bd = limpiar($db, $comuna_solicitante);
    $email_bd = limpiar($db, $email_solicitante);
    $celular_bd = limpiar($db, $celular_solicitante);
    $stmt->bind_param("sisssdi", $nombre_bd, $especialidad_bd, $descripcion_bd, $twitter_bd, $email_bd, $celular_bd, $comuna_bd);
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

function mapEspecialidad($table, $id){
    $ret = $table[$id - 1]['descripcion'];
    return $ret;
}

function mapEspecialidades($table, $ids){
    $ret = array();
    if (is_array($ids[0])){ //si es un arreglo de la forma (medico_id, especialidad_id)
        foreach ($ids as $esp) {
            $esp_id = $esp['especialidad_id'];
            $ret[] = $table[$esp_id-1]['descripcion'];
        }
    } else {
        foreach ($ids as $esp_id) {
            $ret[] = $table[$esp_id-1]['descripcion'];
        }
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
function getRegionWithId($db, $regionid){
    $sql = "SELECT id, nombre FROM region WHERE id = {$regionid}";
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
    $resultado = array();
    $res = array();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $res[] = $row;
        }
        $resultado = $res[0]['nombre'];
    }
    $db->close();
    if ($resultado){
        return $resultado;
    }
    else {
        echo ("Error, Comuna inválida");
        return False;
    }
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

function getDoctors($db, $offset)
{
    //get the last 5 doctors
    $sql = "SELECT id, nombre, experiencia, comuna_id, twitter, email, celular FROM medico ORDER BY id DESC LIMIT 5 OFFSET {$offset}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}

function getListDoctors($db)
{
    $sql = "SELECT id, nombre FROM medico";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}

function getDoctorWithId($db, $id)
{
    //get the last 5 doctors
    $sql = "SELECT id, nombre, experiencia, comuna_id, twitter, email, celular FROM medico WHERE id = {$id}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}


function getSolicitudes($db, $offset)
{
    //get the last 5 doctors
    $sql = "SELECT id, nombre_solicitante, especialidad_id, sintomas, twitter, email, celular, comuna_id FROM solicitud_atencion ORDER BY id DESC LIMIT 5 OFFSET {$offset}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}

function getEspecialidadesFromDoctorId($db, $medico_id)
{
    $sql = "SELECT especialidad_id FROM `especialidad_medico` WHERE medico_id = {$medico_id}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}

function getRegionIdFromComunaId($db, $comunaid)
{
    $sql = "SELECT region_id FROM comuna WHERE id = {$comunaid}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}

function getRutasFotosGivenMedicoId($db, $medicoid)
{
    $sql = "SELECT nombre_archivo FROM foto_medico WHERE medico_id = {$medicoid}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}

function getArchivosGivenSolicitudId($db, $solicitudid)
{
    $sql = "SELECT * FROM archivo_solicitud WHERE solicitud_atencion_id = {$solicitudid}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}

function getSolicitanteWithId($db, $id)
{
    //get the last 5 doctors
    $sql = "SELECT * FROM solicitud_atencion WHERE id = {$id}";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
    return $res;
}


?>