<?php
define( 'ROOT', getcwd() );
require_once(ROOT.'/BackEnd/db_config.php');
$db = DbConfig::getConnection();
//TODO: define this functions.
//$regiones = getRegiones($db);
//$comunas = getComunas($db);
$db->close();
?>

<!-- HTML5 -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" /> <!-- Declaring enconding as UTF 8-->
    <title> Tarea N° 1</title> <!-- Title in pestaña -->
    <link rel="stylesheet" type="text/css" media="screen"  href="tarea1.css" />    <!-- CSS: -->
    <script src="jquery-3.5.0.js"></script>  <!-- Importing JQUERY  -->
</head>
<body>

<ul class="topnav">
  <li><a class="active" href="inicio.html">Inicio</a></li>
  <li><a href="agregar_datos_de_medico.php">Agregar Datos de Médico</a></li>
  <li><a href="ver_medicos.html">Ver Médicos</a></li>
  <li><a href="publicar_solicitud_de_atencion.php">Publicar Solicitud de Atención</a></li>
  <li><a href="ver_solicitudes_de_atencion.html">Ver Solicitudes de Atención</a></li>
</ul>

<div>
  <!-- Body of page -->
  <h1>Publicar solicitud de atención</h1>
  <p>Para aquellas personas que necesitan atención médica.</p>
  <form enctype="multipart/form-data" method="post" id="solicitud-form" action="./BackEnd/procesar_form_solicitud.php" onsubmit="return solicitudeValidator();">
    <br>
    <!-- Label for Nombre solicitante -->
    <label for="nombre-solicitante" class="text-field">Nombre del solicitante (*)</label>
    <br>
    <input type="text" id="nombre-solicitante" name="nombre-solicitante" size="30" maxlength="30" placeholder="Nombre del solicitante" >
    <br>
    <br> 

    <!-- Label for Especialidades -->
    <label for="especialidad-solicitud" class="text-field">Especialidad solicitada (*)</label>
    <br>
    <select id="especialidad-solicitud" name="especialidad-solicitud">
        <option value="1">Cardiología</option>
        <option value="2">Gastroenterología</option>
        <option value="3">Endocrinología</option>
        <option value="4">Epidemiología</option>
        <option value="5">Geriatría</option>
        <option value="6">Hematología</option>
        <option value="7">Infectología</option>
        <option value="8">Medicina del Deporte</option>
        <option value="9">Medicina de urgencias</option>
        <option value="10">Medicina interna</option>
        <option value="11">Nefrología</option>
        <option value="12">Neumología</option>
        <option value="13">Neurología</option>
        <option value="14">Nutriología</option>
        <option value="15">Oncología</option>
        <option value="16">Pediatría</option>
        <option value="17">Psiquiatría</option>
        <option value="18">Reumatología</option>
        <option value="19">Toxicología</option>
        <option value="20">Dermatología</option>
        <option value="21">Ginecología</option>
        <option value="22">Oftalmología</option>
        <option value="23">Otorrinolaringología</option>
        <option value="24">Urología</option>
        <option value="25">Traumatología</option>
    </select>
    <br>
  
  <!-- Label for Descripción de Síntomas -->
  <br>
  <label for="sintomas-solicitante" class="text-field">Descripción de síntomas</label>
  <br>
  <textarea rows="8" cols="40" maxlength="500" id="sintomas-solicitante" name="sintomas-solicitante" placeholder="Indique aquí sus síntomas."></textarea>
  <br>

  <!-- Archivos complementarios-->
  <!-- Para el ingreso de las fotos del médico, se debe solicitar un archivo y a continuación un botónque diga “agregar otra foto”. Al presionar dicho botón, debe aparecer un nuevo elemento “input”de tipo “file” que permita ingresar otro archivo, considerando un máximo de 5 archivo -->
  <br>
  <br>
  <label for="archivos-solicitante[]" class="text-field">Archivos complementarios</label>
  <br>
  <div class="input">
    <input type="file" id="archivos-solicitante[]" name="archivos-solicitante[]" value="" multiple="multiple" >
  </div>

    
  <!-- Label for twitter solicitante -->
  <br>
  <label for="twitter-solicitante" class="text-field">Twitter del solicitante</label>
  <br>
  <input type="text" id="twitter-solicitante" name="twitter-solicitante" size="80" minlength="3" maxlength="80" placeholder="Twitter de contacto">
  <br>

  
  <!-- Label for email solicitante -->
  <br>
  <label for="email-solicitante" class="text-field">Email del solicitante (*)</label>
  <br>
  <input type="email" id="email-solicitante" name="email-solicitante" size="80" maxlength="80" placeholder="Correo electrónico" >
  <br>


  <!-- Label for número celular contacto -->
  <br>
  <label for="celular-solicitante" class="text-field">Celular solicitante</label>
  <br>
  <input type="tel" id="celular-solicitante" name="celular-solicitante" size="15" maxlength="15" placeholder="Celular del solicitante">
  <br>

  <br>
  <!-- Label for Región -->
  <label for="region-solicitante" class="text-field">Región del solicitante(*)</label>
  <br>
  <select id="region-solicitante" name="region-solicitante" >

  </select>
  <br>

  <!-- Label for Comuna -->
  <br>
  <label for="comuna-solicitante" class="text-field">Comuna del solicitante(*)</label>
  <br>
  <select id="comuna-solicitante" name="comuna-solicitante" >
  </select>
  <br>
  <br>
  <input type="submit" value="Crear Solicitud de Atención">
  <br>
  <br>
  <button id="myButton" onclick="cleanForm();">Limpiar</button>
  </form>
  </div>
  <script src="formValidator_test_solicitud.js"></script>
</body>
</html>
