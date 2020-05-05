<?php
require_once("diccionarios.php");
require_once("validaciones.php");
require_once('db_config.php');
require_once('consultas.php');

/*
* Se asegura de que no tenga simbolos raros que puedan causar ataques
* @param (string) $filename - Uploaded file name.
* @author Yousef Ismaeil Cliprz
*/
function check_file_uploaded_name ($filename)
{
    (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$filename)) ? true : false);
}

function picture_validation($form_name){
    // Haciendo un directorio
    $array = scandir(".", 1);

    //if it is already created, make dir.
    if (!in_array("media", $array)) {
        $result = mkdir ("./media", "0777");
    }
    else{
        $result = "./media";
    }

    // si se ha submiteado
    if(isset($_POST["submit"])) {
        //setting directorio
        $nombre_imagen = basename($_FILES[$form_name]["name"]);
        $exito = True;
        $media_files = scandir("./media", 1);

        // si ya hay un archivo con el mismo nombre en media lo renombramos.
        if (in_array($nombre_imagen, $media_files)){
            $id = time();
            //nombre imagen da algo como afd.png1232131
            $nuevo_nombre_imagen = "./media/". pathinfo($nombre_imagen)['filename'] . $id . "." . pathinfo($nombre_imagen)['extension'];
        }
        else {
            $nuevo_nombre_imagen = "./media/". pathinfo($nombre_imagen)['filename'] . "." . pathinfo($nombre_imagen)['extension'];
        }
        //validamos que el tipo sea una iamgen
        $tamano = getimagesize($_FILES[$form_name]["tmp_name"]);
        $fp = fopen($_FILES[$form_name]["tmp_name"], "rb");
        if ($tamano && $fp) {
            $pattern = '/(png|gif|jpeg|jpg|bmp)$/';
            if (preg_match($pattern, $tamano["mime"]) == true){
                $exito = True;
            }
        }
        else {
            $exito = False;
        }
        //validamos nombre
        if (check_file_uploaded_name($nombre_imagen)) {
            $exito = False;
        }
        if ($exito){
            //si ya pasamos las validaciones, y es una imagen:
            if (move_uploaded_file($_FILES['imagenASubir']['tmp_name'], $nuevo_nombre_imagen)){
                return True;
            } else {
                return False;
            }
        }
    }
    return False;
}

$errores = array();

if (!picture_validation("imagenASubir")){
    $errores[] = "El archivo subido no es una imagen válida.";
}

if(!checkName($_POST)){
	$errores[] = "No entregó su nombre.";
}
if(!checkMasa($_POST)){
	$errores[] = "Seleccione masa.";
}
if(!checkIngredientes($_POST)){
	$errores[] = "Seleccione ingredientes.";
}
if(count($errores)>0){//Si el arreglo $errores tiene elementos, debemos mostrar el error.
	header("Location: index.php?errores=".implode($errores, "<br>"));//Redirigimos al formulario inicio con los errores encontrados
	return; //No dejamos que continue la ejecución
}

//Si llegamos aqui, las validaciones pasaron
$nombre = $_POST['nombre'];
$tipo_masa = getTipoMasa($_POST['masa']);
$ingredientes = getIngredientes($_POST['ingredientes']);
$direccion = $_POST['direccion'];
$comuna = getComuna($_POST['comunas']);
$costo = count($_POST['ingredientes'])*200;


//Guardamos en base de datos
$db = DbConfig::getConnection();
$res = saveOrder($db, $_POST['nombre'],$_POST['telefono'], $_POST['direccion'],$_POST['comunas'], $_POST['masa'], $_POST['ingredientes'], $_POST['comentario'], $costo );
$db->close();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="taller4.css" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<h1>Confirmación pedido</h1>
	<p>
		Señor <?php echo $nombre; ?>,<br/>

		Hemos recibido su orden de una Pizza de masa <?php echo $tipo_masa; ?>. Con los siguientes ingredientes:
	</p>
	<ul>
		<?php foreach($ingredientes as $ingrediente) { ?>
		<li><?php echo $ingrediente; ?></li>
		<?php } ?>
	</ul>

	<p>Será enviado lo más pronto posible a la dirección <?php echo $direccion; ?> en la comuna de <?php echo $comuna['nombre']; ?>.</p>
	<p>¡Gracias por su preferencia!</p>
</body>
</html>