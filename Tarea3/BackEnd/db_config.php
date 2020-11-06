<?php

class dbconfig{

    //Version Local
    private static $db_name = "tarea2"; //Base de datos de la app
    private static $db_user = "usuario"; //Usuario MySQL
    private static $db_pass = "cc5002"; //Password
    private static $db_host = "localhost";//Servidor donde esta alojado, puede ser 'localhost' o una IP (externa o interna).

    // Version Anakena
//    private static $db_name = "cc500228_db"; //Base de datos de la app
//    private static $db_user = "cc500228_u"; //Usuario MySQL
//    private static $db_pass = "suadavulpu"; //Password
//    private static $db_host = "localhost";//Servidor donde esta alojado, puede ser 'localhost' o una IP (externa o interna).
//    private static $db_port = 3306; //puerto


    public static function getConnection(){
        $mysqli = new mysqli(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);

        $mysqli->set_charset("utf8"); //Indicar charset utf8 como indica W3Schools
        return $mysqli;
    }
}

?>