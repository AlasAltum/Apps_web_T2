<?php


function getTipoMasa($id){
    if($id == 1) return "delgada";
    if($id == 2) return "normal";
}


function getIngredientes($arr){
    return array_map(function($val){return getIngrediente($val);}, $arr);
}

/*
 * Recibe un arreglo de números que representa los ids de las especialidades
 * Retorna un arreglo con las especilidades correspondientes a cada ingrediente
 */
function getEspecialidades($arr_especialidades){

}


/*
Recibe la base de datos y retorna las comunas
*/
function getComunas($db){
    $sql = "SELECT id, nombre FROM comunas";
    $result = $db->query($sql);
    $res = array();
    while ($row = $result->fetch_assoc()) {
        $res[] = $row;
    }
	return $res;
}

//
function getComuna($id){
    $db = dbconfig::getConnection();
    $comunas = getComunas($db);
    $db->close();
    return $comunas[$id];
}


?>