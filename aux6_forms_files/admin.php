<?php
require_once('db_config.php');
require_once('consultas.php');
require_once('diccionarios.php');
$db = DbConfig::getConnection();
$ordenes = getOrders($db);
$db->close();

?>
<!DOCTYPE html>
<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<h1>Administración</h1>
	<h1>Lista pedidos</h1>
	<table class="pure-table">
		<thead>
		<tr>
			<td>Nombre</td>
			<td>Dirección</td>
			<td>Masa</td>
			<td>Acciones</td>
		</tr>
		</thead>
		<tbody>	
		<?php foreach($ordenes as $orden){ ?>
		<tr>
			<td><?php echo $orden['nombre'] ?></td>
			<td><?php echo $orden['direccion'].', '.$orden['comuna_nombre'] ?></td>
			<td><?php echo getTipoMasa($orden['masa']) ?></td>
			<td><a href="ver.php?orden_id=<?php echo $orden['id'] ?>">Ver</a></td>
		</tr>
		<?php } ?>
	</tbody>
	</table>
</body>
</html>