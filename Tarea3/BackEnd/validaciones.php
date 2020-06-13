<?php


/**
 * Validación nombre con PHP.
 * @param $post
 * @param $html_field
 * @return bool
 */
function checkName($post, $html_field): bool
{
	if(isset($post[$html_field])){
		$regexp = "/^[A-Za-záéíóú\ ]+$/";
		if(preg_match($regexp, $post[$html_field]) && strlen($post[$html_field]) < 20 && strlen($post[$html_field]) > 3){
			return True;
		}
	}
	return False;
}

/**
 * @param $post
 * @param $html_field
 * @return bool
 */
function checkComuna($post, $html_field, $region_field){
    if (isset($post[$html_field])){
        $region = getRegion($post[$region_field]);
        $comuna = getComuna($post[$html_field], $region);
        if ($post[$html_field] && getComunaFromId($comuna)){
            return True;
        }
    }
    return False;
}

/**
 * @param $post
 * @return bool
 */
function checkExperiencia($post, $html_field){
    if (isset($post[$html_field])){
        if (strlen($post[$html_field]) == 0){ //case no description
            return True;
        }
        if(strlen($post[$html_field]) > 0 && strlen($post[$html_field]) < 500){ //max 500 chars
            return True;
        }
    }
    return False;
}

/**
 * @param $post
 * @return bool
 */
function checkEspecialidades($post, $html_field) {
    if (isset($post[$html_field])) {
        return True;
        }
    return False;
}


/**
 * @param $picture
 * @return bool
 */
function pictureFormatValidation($picture){
    $tamano = getimagesize($picture);
    $fp = fopen($picture, "rb");
    if ($tamano && $fp) {
        $pattern = '/(png|gif|jpeg|jpg|bmp)$/';
        if (preg_match($pattern, $tamano["mime"]) == True){
            return True;
        }
    }
    return False;
}

/**
 * @param $file that should be a document.
 * @return bool
 */
function formatValidation($file){
    $tamano = mime_content_type($file);
    if ($tamano) {
        $pattern = '/(docx|doc|pdf|png|gif|jpeg|jpg|bmp)$/';
        if (preg_match($pattern, $tamano) == True){
            return True;
        }
    }
    return False;
}


/**
 * @param $uploaddir
 * @param $original_filename
 * @return string
 */
function formatFileName($uploaddir, $original_filename){
    //we take basename in order to prevent any attacks.
    $nombre_imagen = basename($original_filename);
    //agregamos tiempo a la imagen para que siempre sea distinto.
    $id = time();
    return $uploaddir . pathinfo($nombre_imagen)['filename'] . $id . "." . pathinfo($nombre_imagen)['extension'];
}



/**
 * @param $files
 * @return bool
 */
function checkFiles($files, $html_field){
    if ($files) {
        foreach ($files[$html_field]["error"] as $key => $error) { //like a dictionary
            if ($error == UPLOAD_ERR_OK) {
                //validamos tipo
                if (!formatValidation($files[$html_field]['tmp_name'][$key])) {
                    return False;
                }
            }
        }
        return True;
    }
    return False;
}

//This checks the foto and
/**
 * @param $files
 * @return bool
 */
function checkFoto($files, $html_field){
    if ($files) {
        foreach ($files[$html_field]["error"] as $key => $error) { //like a dictionary
            if ($error == UPLOAD_ERR_OK) {
                //validamos tipo
                if (!pictureFormatValidation($files[$html_field]['tmp_name'][$key])) {
                    return False;
                }
            }
        }
        return True;
    }
    return False;
}

/**
 * @param $post
 * @return bool
 */
function checkTwitter($post, $html_field){
    if (isset($post[$html_field])) {
        $pattern = "/@[0-9a-zA-z]+/";
        if (preg_match($pattern, $post[$html_field]) == True && strlen($post[$html_field]) < 20){
            return True;
        }
    }
    return False;
}

/**
 * @param $post
 * @return bool
 */
function checkEmail($post, $html_field){
    if (isset($post[$html_field])){
        if (filter_var($post[$html_field], FILTER_VALIDATE_EMAIL)) {
            return True;
        }
    }
    return False;
}

function checkNumber($post, $html_field){
    if (isset($post[$html_field])) {
        $pattern = "/[0-9\+ ]+/";
        if (preg_match($pattern, $post[$html_field]) == True && strlen($post[$html_field]) < 20) {
            return True;
        }
        else{
            return False;
        }
    }
    return True;
}

?>