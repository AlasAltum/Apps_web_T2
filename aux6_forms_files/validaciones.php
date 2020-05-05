<?php
/**
 * Validación nombre con PHP.
 */
function checkName($post){
	if(isset($post['nombre'])){
		$regexp = "/^[A-Za-záéíóú\ ]+$/";
		if(preg_match($regexp, $post['nombre'])){
			return true;
		}
	}
	return false;
}

/**
 * Validación tipo de masa.
 */
function checkMasa($post){
	if(isset($post['masa'])){
		return true;
	}
	return false;
}

/**
 * Validación para seleccionar ingredientes.
 */
function checkIngredientes($post){
	if(isset($post['ingredientes']) && count($post['ingredientes']) > 0){
		return true;
	}
	return false;
}
?>