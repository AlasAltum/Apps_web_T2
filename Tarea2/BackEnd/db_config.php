<?php
/* Clase que crea una coneción a la base de datos
* Modo de uso:
$db = dbconfig::getConnection();
$sql = "SELECT id, nombre FROM region"
$result = $db->query($sql);
$res = array();
while ($row = $result->fetch_assoc()) {
	$res[] = $row;
}
$db->close();
Resultados están en arreglo $res
*/
class dbconfig{
    private static $db_name = "tarea2"; //Base de datos de la app
    private static $db_user = "usuario"; //Usuario MySQL
    private static $db_pass = "cc5002"; //Password
    private static $db_host = "localhost";//Servidor donde esta alojado, puede ser 'localhost' o una IP (externa o interna).

    public static function getConnection(){
        $mysqli = new mysqli(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);

        $mysqli->set_charset("utf8"); //Indicar charset utf8 como indica W3Schools
        return $mysqli;
    }
}

?>