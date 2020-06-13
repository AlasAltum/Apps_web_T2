<?php
require_once('db_config.php');
require_once('diccionarios.php');
$db = DbConfig::getConnection();
$a = getListDoctors($db);

// get the q parameter from URLxampp
if (isset($_REQUEST["term"])){
    $q = $_REQUEST["term"];
    $doc_ids = array();
    $doc_names = array();

    // lookup all hints from array if $q is different from ""
    if ($q !== "" && strlen($q) >= 3) {
        $q = strtolower($q);
        $len = strlen($q);
        // Search for names that contain the written substring.
        foreach ($a as $name) {
            if (stristr($q, substr($name['nombre'], 0, $len))) {
                    $doc_names[] = $name['nombre'];
            }
        }
        // Show names with links that match the written substring.
        echo(json_encode($doc_names));
//        foreach ($doc_names as $key=> $value){
//            $str = $doc_names[$key;
//            echo(json_encode($str));
//        }
        $db->close();
    }
}


?>

