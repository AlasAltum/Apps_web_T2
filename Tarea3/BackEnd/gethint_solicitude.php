<?php
require_once('db_config.php');
require_once('diccionarios.php');
$db = DbConfig::getConnection();
$list_solicitudes = getListSolicitudes($db);

// get the q parameter from URL
if (isset($_REQUEST["q"])){
    $q = $_REQUEST["q"];
    $to_show = array();

    // lookup all hints from array if $q is different from ""
    if ($q !== "" && strlen($q) >= 3) {
        $q = strtolower($q);
        $len = strlen($q);
        // Search for names that contain the written substring.
        foreach ($list_solicitudes as $solicitude) {
            if (stristr($q, substr($solicitude['nombre_solicitante'], 0, $len))) {
                $to_show[] = $solicitude['nombre_solicitante'];
                $id[] = $solicitude['id'];


            }
        }
        // Show names with links that match the written substring.
        foreach ($to_show as $key=>$value){
            $str = "<a href='./detalle_solicitud.php?id_solicitante={$id[$key]}'>" . $to_show[$key] . "</a><br>";
            echo($str);
        }
        $db->close();
    }

    if ($to_show === "") {
        echo("no suggestion");
    }
}


?>

