<?php





function limpiar($db, $str){
	return htmlspecialchars($db->real_escape_string($str));
}

function getComunas($db){
	$sql = "SELECT id, nombre FROM comuna";
		$result = $db->query($sql);
		$res = array();
		while ($row = $result->fetch_assoc()) {
			$res[] = $row;
		}
	return $res;
}

/*
 * Dada la base de datos y el nombre de la comuna, retorna el id
 */

function getIdComuna($db, $comuna_name){
	$db = DbConfig::getConnection();
	$comunas = getComunas($db);
	$db->close();
	//TODO: Check this
	return $comunas[$comuna_name];
}

function getOrders($db){
	$sql = "SELECT ordenes.id, ordenes.nombre, ordenes.direccion, comunas.nombre as comuna_nombre, ordenes.masa
	FROM ordenes, comunas
	WHERE ordenes.comuna = comunas.id";
	$result = $db->query($sql);
	$res = array();
	while ($row = $result->fetch_assoc()) {
		$res[] = $row;
	}
	return $res;
}
?>
