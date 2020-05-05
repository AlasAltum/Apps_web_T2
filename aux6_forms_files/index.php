<?php
require_once('db_config.php');
require_once('consultas.php');
$db = DbConfig::getConnection();
$comunas = getComunas($db);
$db->close();
?>
<!DOCTYPE html>

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="./aux3.css">
        <script src="./aux3.js"></script>
        <title>Auxiliar 3</title>
    </head>
    
<body>

<h1>¡Arma tu Pizza!</h1>

<div class="avisos">
  <?php
    if(isset($_GET['errores'])){
      echo $_GET['errores']; 
    }
  ?>
</div>

<div id="container">
  <form id="myform" method="post" action="procesar_orden.php" onsubmit="return dataValidator();" enctype="multipart/form-data">
    <label for="nombre" class="text-field">Nombre</label>
    <input type="text" id="nombre" name="nombre" size="20" placeholder="Nombre">

    <label for="telefono" class="text-field">Teléfono</label>
    <input type="text" id="telefono" name="telefono" placeholder="Ingrese su teléfono acá">

    <label for="direccion" class="text-field">Dirección</label>
    <input type="text" id="direccion" name="direccion" placeholder="Dirección">

    

    <label for="comuna" class="text-field">Comuna</label>
    <select id="comunas" name="comunas">
      <?php foreach($comunas as $comuna){ ?>
				<option value="<?php echo $comuna['id']; ?>"><?php echo $comuna['nombre']; ?></option>
			<?php } ?>
    </select>

    <label for="masa" class="text-field">Tipo de Masa</label>
    <br>
    <br>
    <label for="masa1" class="text-field">Masa Delgada</label>
    <input type="radio" name="masa" value="1">
    <label for="masa1" class="text-field">Masa Normal</label>
    <input type="radio" name="masa" value="2">   

    <label for="ingrediente" class="text-field">Ingredientes</label>
    <br>
    <br>
    <label for="tipo" class="text-field">Pepperoni</label>
    <input type="checkbox" name="ingredientes[]" value="1" />
    <label for="tipo" class="text-field">Aceituna</label>
		<input type="checkbox" name="ingredientes[]" value="2" />
    <label for="tipo" class="text-field">Carne</label>
		<input type="checkbox" name="ingredientes[]" value="3" /><br>
    <br>
    <label for="comentario" class="text-field">Comentarios</label>
    <textarea id="comentario" name="comentario" placeholder="Ingrese comentarios acá"></textarea>
    <!-- Cambié el nombre del form -->
    <input type="file" name="imagenASubir" id="imagenASubir">
    <input type="submit" value="Crear mi pizza" name="submit">
    <button type="button" id="myButton" onclick="cleanForm();">Limpiar</button>
  </form>
</div>

</body>
</html>