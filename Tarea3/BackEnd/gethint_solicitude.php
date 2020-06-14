<?php
require_once('db_config.php');
require_once('diccionarios.php');
$db = DbConfig::getConnection();
$a = getListSolicitudes($db);

// get the q parameter from URL
if (isset($_REQUEST["q"])){
    $q = $_REQUEST["q"];
    $id = array();
    $hint = array();

    // lookup all hints from array if $q is different from ""
    if ($q !== "" && strlen($q) >= 3) {
        $q = strtolower($q);
        $len = strlen($q);
        // Search for names that contain the written substring.
        foreach ($a as $name) {
            if (stristr($q, substr($name['nombre_solicitante'], 0, $len))) {
                    $hint[] = $name['nombre_solicitante'];
                    $id[] = $name['id'];
            }
        }
        // Show names with links that match the written substring.
        foreach ($hint as $key=>$value){
            $str = "<a href='./detalle_solicitud.php?id_solicitante={$id[$key]}'>" . $hint[$key] . "</a><br>";
            echo($str);
        }
        $db->close();
    }

    if ($hint === "") {
        echo("no suggestion");
    }
}


?>

