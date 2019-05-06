<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<title>Inicio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 
</head>
<body>

<div id="container">

    <div class="container"> <BR>
        <h1>Resultados de búsqueda para '<?=$nombre_busqueda?>'</h1>
        <a type="button" class="btn btn-primary" href="<?= base_url();?>">Regresar</a>
        
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Departamento</th>
              <th scope="col">Localidad</th>
              <th scope="col">Municipio</th>
              <th scope="col">Años activo</th>
              <th scope="col">Tipo persona</th>
              <th scope="col">Tipo cargo</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($nombres as $row):?>
            <tr>
              <td><?=$row->nombre?></td>
              <td><?=$row->departamento?></td>
              <td><?=$row->localidad?></td>
              <td><?=$row->municipio?></td>
              <td><?=$row->años_activo?></td>
              <td><?=$row->tipo_persona?></td>
              <td><?=$row->tipo_cargo?></td>
            </tr> 
            <?php endforeach?>
          </tbody>
        </table>

          
    </div>
</div>

<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->
</body>
</html>