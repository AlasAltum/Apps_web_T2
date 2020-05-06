<?php


/**
 * Validación nombre con PHP.
 */
function checkName($post){
	if(isset($post['nombre-medico'])){
		$regexp = "/^[A-Za-záéíóú\ ]+$/";
		if(preg_match($regexp, $post['nombre-medico'])){
			return true;
		}
	}
	return false;
}
function checkComuna($post){
    if (isset($post['comuna-medico'])){
        if ($post['comuna-medico']){
            return true;
        }
    }
    return false;
}

function checkExperiencia($post){
    if (isset($post['experiencia-medico'])){
        if (strlen($post['experiencia-medico']) == 0){ //case no description
            return true;
        }
        if(strlen($post['experiencia-medico']) > 0 && strlen($post['experiencia-medico']) < 200){
            return true;
        }
    }
    return False;
}

function checkEspecialidades($post) {
    if (isset($post['especialidades-medico'])) {
        return true;
        }
    //TODO: Check if an option was given.
    return false;
}

function pictureFormatValidation($picture){
    $tamano = getimagesize($picture);
    $fp = fopen($picture, "rb");
    if ($tamano && $fp) {
        $pattern = '/(png|gif|jpeg|jpg|bmp)$/';
        if (preg_match($pattern, $tamano["mime"]) == true){
            return True;
        }
    }
    return false;
}

function formatName($uploaddir, $original_filename){
    //we take basename in order to prevent any attacks.
    $nombre_imagen = basename($original_filename);
    //agregamos tiempo a la imagen para que siempre sea distinto.
    $id = time();
    return $uploaddir . pathinfo($nombre_imagen)['filename'] . $id . "." . pathinfo($nombre_imagen)['extension'];
}


function pictureTransfer($files){
    $ret_paths = array();
    $ret_filenames = array();
    if ($files) {
        // cada imagen será $files["foto-medico"]['name'][$key]
        foreach ($files["foto-medico"]["error"] as $key => $error) { //like a dictionary
            if ($error == UPLOAD_ERR_OK) {
                //validamos que el tipo sea una imagen
                $nueva_ruta_imagen = formatName("./../Files/fotos_medico/" , $files["foto-medico"]['name'][$key]);
                $transfer = move_uploaded_file($files["foto-medico"]['tmp_name'][$key], $nueva_ruta_imagen);
                if ($transfer) {
                    $ret_paths[] = $nueva_ruta_imagen; //Guardamos el path de la imagen
                    $ret_filenames[] = basename($nueva_ruta_imagen); //Guardamos el nombre de la imagen
                } else {
                    return False;
                }
            }
        }
        return array($ret_paths, $ret_filenames);
    }
    return False;
}


//This checks the foto and
function checkFoto($files){
    if ($files) {
        foreach ($files["foto-medico"]["error"] as $key => $error) { //like a dictionary
            if ($error == UPLOAD_ERR_OK) {
                //validamos tipo
                if (!pictureFormatValidation($files["foto-medico"]['tmp_name'][$key])) {
                    return False;
                }
            }
        }
        return true;
    }
    return false;
}

function checkTwitter($post){
    if (isset($post['twitter-medico'])) {
        return true;
    }
    return false;
}

function checkEmail($post){
    if (isset($post['email-medico'])){
        return true;
    }
    return false;
}



?>