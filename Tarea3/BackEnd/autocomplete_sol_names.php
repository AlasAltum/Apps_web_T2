<?php
require_once('db_config.php');
require_once('diccionarios.php');
$db = DbConfig::getConnection();
$a = getListSolicitudes($db);

// get the q parameter from URLxampp
if (isset($_REQUEST["term"])){
    $q = $_REQUEST["term"];
    $sol_names = array();

    // lookup all hints from array if $q is different from ""
    if ($q !== "" && strlen($q) >= 3) {
        $q = strtolower($q);
        $len = strlen($q);
        // Search for names that contain the written substring.
        foreach ($a as $name) {
            if (stristr($q, substr($name['nombre_solicitante'], 0, $len))) {
                    $sol_names[] = $name['nombre_solicitante'];
            }
        }
        // Show names with links that match the written substring.
        echo(json_encode($sol_names));
        $db->close();
    }
}

?>

