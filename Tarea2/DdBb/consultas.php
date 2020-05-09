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




?>
