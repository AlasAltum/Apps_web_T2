<?php

$dir = './';
$file = $dir . basename($_FILES['file']['name']);

if (isset($_FILES['file'])) {
    // Chequear sí el archivo fue enviado para realizar validaciones
}

if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
    echo "The files has been uploaded";
} else {
    echo "Sorry, the was a error uploading your file";
}



?>