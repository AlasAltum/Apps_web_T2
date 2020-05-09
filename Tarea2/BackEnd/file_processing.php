<?php

function FileReader($files, $html_field){
    $ret_paths = array();
    $ret_filenames = array();
    if ($files) {
        // cada imagen será $files["foto-medico"]['name'][$key]
        foreach ($files[$html_field]["error"] as $key => $error) { //like a dictionary
            if ($error == UPLOAD_ERR_OK) {
                //validamos que el tipo sea una imagen
                $nueva_ruta_imagen = formatName("./../Files/solicitude_files/" , $files[$html_field]['name'][$key]);
                $transfer = move_uploaded_file($files[$html_field]['tmp_name'][$key], $nueva_ruta_imagen);
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


/**
 * @param $files
 * @return array[]|bool
 */
function fileTransfer($files, $html_field, $destination_dir){
    $ret_paths = array();
    $ret_filenames = array();
    if ($files) {
        // cada imagen será $files["foto-medico"]['name'][$key]
        foreach ($files[$html_field]["error"] as $key => $error) { //like a dictionary
            if ($error == UPLOAD_ERR_OK) {
                $nueva_ruta_imagen = formatName("./../Files/{$destination_dir}/" , $files[$html_field]['name'][$key]);
                $transfer = move_uploaded_file($files[$html_field]['tmp_name'][$key], $nueva_ruta_imagen);
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


?>