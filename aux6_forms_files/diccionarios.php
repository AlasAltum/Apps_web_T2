<?php
require_once('db_config.php');
require_once('consultas.php');

/*
Recibe un id y retorna el nombre de la masa.
*/
function getTipoMasa($id){
	if($id == 1) return "delgada";
	if($id == 2) return "normal";
}

/*
Recibe un arreglo de ids y retorna un arreglo con los ids convertidos en su nombre.
*/
function getIngredientes($arr){
	return array_map(function($val){return getIngrediente($val);}, $arr);
}

/*
Recibe un id y retorna el nombre de la comuna.
*/
function getComuna($id){
	$db = DbConfig::getConnection();
	$comunas = getComunas($db);
	$db->close();
	return $comunas[$id];
}

/*
De uso interno.
*/
function getIngrediente($id){
	if($id == 1) return "Pepperoni";
	if($id == 2) return "Aceitunas";
	if($id == 3) return "Carne";
}


?>
