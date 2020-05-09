<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" /> <!-- Declaring enconding as UTF 8-->
    <title> Tarea N° 2</title> <!-- Title in pestaña -->
    <link rel="stylesheet" type="text/css" media="screen"  href="tarea1.css" />    <!-- CSS: -->

</head>
<body>

<ul class="topnav">
  <li><a class="active" href="inicio.html">Inicio</a></li>
  <li><a href="agregar_datos_de_medico.php">Agregar Datos de Médico</a></li>
  <li><a href="ver_medicos.html">Ver Médicos</a></li>
  <li><a href="publicar_solicitud_de_atencion.php">Publicar Solicitud de Atención</a></li>
  <li><a href="ver_solicitudes_de_atencion.html">Ver Solicitudes de Atención</a></li>
</ul>


<div style="display: flex; justify-content: space-around">
    <?php
    define( 'ROOT', getcwd() );
    require_once(ROOT.'/BackEnd/db_config.php');
    require_once(ROOT.'/BackEnd/diccionarios.php');

    $offset = 0;
    $db = DbConfig::getConnection();
    $doctors = getDoctors($db, $offset);


    function displayDoctor($table_especialidades, $doctor){
        $especialidades_medico = getEspecialidadesFromDoctorId($db, $doc4['id']);
        $especialidades_medico = mapEspecialidades($table_especialidades, $especialidades_medico);


        $nombre_medico = $doc4['nombre'];
        $comuna_id = getComunaFromId($doc4['comuna_id']);
        $twitter = $doc4['twitter'];
        $email = $doc4['email'];
        $celular = $doc4['celular'];

        echo("<tr>");
        echo("<td>". "<a href=\"medico_jorge_p1.html\"> {$nombre_medico} </a>" . "</td>");
        echo("<td>".implode(', ', $especialidades_medico).'' . "</td>");
        echo("<td>". $comuna_id . "</td>");
        echo("<td>". $email ."<br>" . $twitter . "<br>"  . $celular . "</td>");
        echo("</tr>");
    }


    $doc0 = $doctors[0];
    $doc1 = $doctors[1];
    $doc2 = $doctors[2];
    $doc3 = $doctors[3];
    $doc4 = $doctors[4];

    if(array_key_exists('button1', $_POST)) {
        button1();
        $doctors = getDoctors($db, $offset);
        $doc0 = $doctors[0];
        $doc1 = $doctors[1];
        $doc2 = $doctors[2];
        $doc3 = $doctors[3];
        $doc4 = $doctors[4];
    }
    else if(array_key_exists('button2', $_POST)) {
        button2();
        $doctors = getDoctors($db, $offset);
        $doc0 = $doctors[0];
        $doc1 = $doctors[1];
        $doc2 = $doctors[2];
        $doc3 = $doctors[3];
        $doc4 = $doctors[4];
    }

    function button1() {
        GLOBAL $offset;
        if ($offset >= 5){
            $offset = $offset - 5;
        }
        //echo($offset);
    }
    function button2() {
        GLOBAL $offset;
        $offset = $offset + 5;
        //echo($offset);
    }
    ?>

    <form method="post">
        <input type="submit" name="button1" value="Atrás"/>
        <input type="submit" name="button2" value="Adelante"/>
    </form>
</div>
<div>
  <!-- Body of page -->
  <h1> Ver Médicos </h1>

    <table >
      <tr>
        <th>Nombre Médico</th>
        <th>Especialidades</th> 
        <th>Comuna</th>
        <th>Datos Contacto</th>
      </tr>
      <!-- First row -->
      <tr>
        <td>
            <?php
            $table_especialidades = getEspecialidades($db);
            $especialidades_medico = getEspecialidadesFromDoctorId($db, $doc0['id']);
            $especialidades_medico = mapEspecialidades($table_especialidades, $especialidades_medico);


            $nombre_medico = $doc0['nombre'];
            $comuna_id = getComunaFromId($doc0['comuna_id']);
            $twitter = $doc0['twitter'];
            $email = $doc0['email'];
            $celular = $doc0['celular'];

            echo("<a href=\"medico_jorge_p1.html\"> {$nombre_medico} </a>");
            ?>
        </td>
        <td>
            <?php echo(''.implode(', ', $especialidades_medico).''); ?>
        </td>
        <td><?php echo($comuna_id); ?></td>
        <td> <?php echo($email); ?> <br>
            <?php echo($twitter); ?> <br>
          <?php echo($celular); ?>
        </td>
      </tr>
      <!-- Second row -->
      <tr>
          <td>
          <?php
          $especialidades_medico = getEspecialidadesFromDoctorId($db, $doc1['id']);
          $especialidades_medico = mapEspecialidades($table_especialidades, $especialidades_medico);


          $nombre_medico = $doc1['nombre'];
          $comuna_id = getComunaFromId($doc1['comuna_id']);
          $twitter = $doc1['twitter'];
          $email = $doc1['email'];
          $celular = $doc1['celular'];

          echo("<a href=\"medico_jorge_p1.html\"> {$nombre_medico} </a>");
          ?>
          </td>
          <td>
              <?php echo(''.implode(', ', $especialidades_medico).''); ?>
          </td>
          <td><?php echo($comuna_id); ?></td>
          <td> <?php echo($email); ?> <br>
              <?php echo($twitter); ?> <br>
              <?php echo($celular); ?>
          </td>
      </tr>
        <!-- Third row -->
        <tr>
            <td>
            <?php
            $especialidades_medico = getEspecialidadesFromDoctorId($db, $doc2['id']);
            $especialidades_medico = mapEspecialidades($table_especialidades, $especialidades_medico);


            $nombre_medico = $doc2['nombre'];
            $comuna_id = getComunaFromId($doc2['comuna_id']);
            $twitter = $doc2['twitter'];
            $email = $doc2['email'];
            $celular = $doc2['celular'];

            echo("<a href=\"medico_jorge_p1.html\"> {$nombre_medico} </a>");
            ?>
            </td>
            <td>
                <?php echo(''.implode(', ', $especialidades_medico).''); ?>
            </td>
            <td><?php echo($comuna_id); ?></td>
            <td> <?php echo($email); ?> <br>
                <?php echo($twitter); ?> <br>
                <?php echo($celular); ?>
            </td>
        </tr>

        <!-- Fourth row -->
        <tr>
            <td>
            <?php
            $especialidades_medico = getEspecialidadesFromDoctorId($db, $doc3['id']);
            $especialidades_medico = mapEspecialidades($table_especialidades, $especialidades_medico);


            $nombre_medico = $doc3['nombre'];
            $comuna_id = getComunaFromId($doc3['comuna_id']);
            $twitter = $doc3['twitter'];
            $email = $doc3['email'];
            $celular = $doc3['celular'];

            echo("<a href=\"medico_jorge_p1.html\"> {$nombre_medico} </a>");
            ?>
            </td>
            <td>
                <?php echo(''.implode(', ', $especialidades_medico).''); ?>
            </td>
            <td><?php echo($comuna_id); ?></td>
            <td> <?php echo($email); ?> <br>
                <?php echo($twitter); ?> <br>
                <?php echo($celular); ?>
            </td>
        </tr>

        <!-- Fifth row -->
        <tr>
            <td>
            <?php
            $especialidades_medico = getEspecialidadesFromDoctorId($db, $doc4['id']);
            $especialidades_medico = mapEspecialidades($table_especialidades, $especialidades_medico);


            $nombre_medico = $doc4['nombre'];
            $comuna_id = getComunaFromId($doc4['comuna_id']);
            $twitter = $doc4['twitter'];
            $email = $doc4['email'];
            $celular = $doc4['celular'];

            echo("<a href=\"medico_jorge_p1.html\"> {$nombre_medico} </a>");
            ?>
            </td>
            <td>
                <?php echo(''.implode(', ', $especialidades_medico).''); ?>
            </td>
            <td><?php echo($comuna_id); ?></td>
            <td> <?php echo($email); ?> <br>
                <?php echo($twitter); ?> <br>
                <?php echo($celular); ?>
            </td>
        </tr>

        <?php


        $db->close();
        ?>


    </table>
</div>

</body>

</html>