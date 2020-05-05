<!DOCTYPE html>
<html>
<body>

<h2>Auxiliar 6</h2>

<form action="save_image.php" method="post" enctype="multipart/form-data">
  <label for="fname">Nombre:</label><br>
  <input type="text" id="fname" name="fname" value="John"><br>
  <label for="lname">Apellido:</label><br>
  <input type="text" id="lname" name="lname" value="Doe"><br>
  <label for="lname">Foto de Perfil:</label><br>
  <input type="file" id="file" name="file"> <br> <br>
  <input type="submit" value="Enviar" name="submit">
</form> 

</body>
</html>