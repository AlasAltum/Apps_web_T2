<?php
/*
Implementar:
1. Preparar SQL para insertar orden: INSERT INTO ordenes (nombre, direccion, comuna, masa, comentario) VALUES ('%s', '%d', '%s', %d, %d, '%s')". Usar sprintf y limpiar los campos con la función limpiar(texto);
2. Ejecutar SQL
3. Recuperar el id de la inserción anterior
4. Preparar SQL para insertar los ingredientes: INSERT INTO ordenes_ingredientes (id_orden, id_ingrediente) VALUES (%d, %d).
x6. retornar true si todo salió bien, false si surgió un problema.
*/
function saveOrder($db, $nombre, $telefono, $direccion, $comuna, $masa, $ingredientes, $comentarios,$costo){
	$stmt = $db->prepare("INSERT INTO ordenes (nombre, telefono, direccion, comuna, masa, comentarios,costo) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sdsddsd", $nombre_bd, $telefono_bd, $direccion_bd, $comuna_bd, $masa_bd, $comentarios_bd, $costo_bd);
	$nombre_bd=limpiar($db,$nombre);
	$telefono_bd=limpiar($db, $telefono);
	$direccion_bd=limpiar($db,$direccion);
	$comuna_bd=limpiar($db,$comuna);
	$masa_bd=limpiar($db,$masa);
	$comentarios_bd=limpiar($db,$comentarios);
	$costo_bd=limpiar($db,$costo);
	if ($stmt->execute()) {
		$last_id = $db->insert_id;
		$stmt_ing=$db->prepare("INSERT INTO ordenes_ingredientes (orden_id, ingrediente_id) VALUES (?,?)");
		$stmt_ing->bind_param("dd",$id_orden_bd,$id_ing_bd);
		$id_orden_bd=$last_id;
		foreach ($ingredientes as $key => $value) {
			$id_ing_bd=$key;
			$stmt_ing->execute();
		}
		return true;
	}
	return false;
}
function limpiar($db, $str){
	return htmlspecialchars($db->real_escape_string($str));
}

function getComunas($db){
	$sql = "SELECT id, nombre FROM comunas";
		$result = $db->query($sql);
		$res = array();
		while ($row = $result->fetch_assoc()) {
			$res[] = $row;
		}
	return $res;
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
