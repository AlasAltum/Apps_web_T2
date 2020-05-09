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
    <title> Tarea N° 2</title> <!-- Title in pestaña -->
    <link rel="stylesheet" type="text/css" media="screen" href="tarea1.css"/>    <!-- CSS: -->
    <script src="jquery-3.5.0.js"></script>  <!-- Importing JQUERY  -->
</head>
<body>

<ul class="topnav">
    <li><a class="active" href="inicio.html">Inicio</a></li>
    <li><a href="agregar_datos_de_medico.php">Agregar Datos de Médico</a></li>
    <li><a href="ver_medicos.php">Ver Médicos</a></li>
    <li><a href="publicar_solicitud_de_atencion.php">Publicar Solicitud de Atención</a></li>
    <li><a href="ver_solicitudes_de_atencion.php">Ver Solicitudes de Atención</a></li>
</ul>

<div class="avisos">
    <?php
    if(isset($_GET['errores'])){
        echo $_GET['errores'];
    }
    ?>
</div>

<div>
    <!-- Body of page -->
    <h1>Agregar datos de un médico</h1>
    <form id="myform" enctype="multipart/form-data" method="post" action="./BackEnd/procesar_form_medico.php" onsubmit="return dataValidator();">
      <br>
      <!-- Label for Región -->
      <label for="region-medico" class="text-field">Región (*)</label>
      <br>
      <select id="region-medico" name="region-medico" ></select>
      <br>

      <!-- Label for Comuna -->
      <br>
      <label for="comuna-medico" class="text-field">Comuna (*)</label>
      <br>
      <select id="comuna-medico" name="comuna-medico" >
      </select>
      <br>
      
      <!-- Label for nombre médico -->
      <br>
      <label for="nombre-medico" class="text-field">Nombre (*)</label>
      <br> 
      <input type="text" id="nombre-medico" name="nombre-medico" size="20" maxlength="30" placeholder="Nombre del médico" >
      <br>

      <!-- Label for experiencia-medico -->
      <br>
      <label for="experiencia-medico" class="text-field">Experiencia</label>
      <br>
      <textarea rows="8" cols="40" id="experiencia-medico" name="experiencia-medico" placeholder="Ingrese experiencia del médico."></textarea>
      <br>
        <br>

        <!-- Label for Especialidades -->
        <label for="especialidades-medico" class="text-field">Especialidad del médico (*)</label>
        <br>
        <select name="especialidades-medico[]" id="especialidades-medico" multiple="multiple" size="5">
            <option value="1">Cardiología</option>
            <option value="2">Gastroenterología</option>
            <option value="3">Endocrinología</option>
            <option value="4">Epidemiología</option>
            <option value="5">Hematología</option>
            <option value="6">Infectología</option>
            <option value="7">Medicina del Deporte</option>
            <option value="8">Medicina de urgencias</option>
            <option value="9">Medicina interna</option>
            <option value="10">Nefrología</option>
            <option value="11">Neumología</option>
            <option value="12">Neurología</option>
            <option value="13">Nutriología</option>
            <option value="14">Oncología</option>
            <option value="15">Pediatría</option>
            <option value="16">Psiquiatría</option>
            <option value="17">Reumatología</option>
            <option value="18">Toxicología</option>
            <option value="19">Dermatología</option>
            <option value="20">Ginecología</option>
            <option value="21">Oftalmología</option>
            <option value="22">Otorrinolaringología</option>
            <option value="23">Urología</option>
            <option value="24">Traumatología</option>
            <option value="25">Geriatría</option>
        </select>
        <br>

        <!-- FOTO MÉDICO -->
        <!-- Para el ingreso de las fotos del médico, se debe solicitar un archivo y a continuación un botónque diga “agregar otra foto”. Al presionar dicho botón, debe aparecer un nuevo elemento “input”de tipo “file” que permita ingresar otro archivo, considerando un máximo de 5 archivo -->
        <br>
        <label for="foto-medico" class="text-field">Foto médico</label>
        <br>
        <div class="input">
            <input type="file" name="foto-medico[]" id="foto-medico" onchange="fotos_medicoValidation('foto-medico')"
                   multiple="multiple" value="" accept="image/*">
      </div>
      
      <!-- Label for twitter contacto -->
      <br>
      <label for="twitter-medico" class="text-field">Twitter contacto</label>
      <br>
      <input type="text" id="twitter-medico" name="twitter-medico" size="80" minlength="3" maxlength="80" placeholder="Twitter de contacto">
      <br>

      <!-- Label for email contacto -->
      <br>
      <label for="email-medico" class="text-field">Email contacto</label>
      <br>
      <input type="email" id="email-medico" name="email-medico" size="80" maxlength="80" placeholder="Correo electrónico" >
      <br>

      <!-- Label for número celular contacto -->
      <br>
      <label for="celular-medico" class="text-field">Celular contacto</label>
      <br>
      <input type="tel" id="celular-medico" name="celular-medico" maxlength="20" placeholder="Correo electrónico">
      <br> 
      <br>
    
      <input type="submit" value="Crear datos del médico">
      <br>
      <br>
      <button id="myButton" onclick="cleanForm();">Limpiar</button>
      </form>
      </div>
    <!--TODO: Change this to real, without _test-->
      <script src="formValidator_test.js"></script>
</body>
</html>
