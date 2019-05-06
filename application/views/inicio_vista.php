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
        <h1>Comparación de nombres</h1>
        
        <form action="<?= base_url();?>buscar" method="POST">
          <div class="form-group">
            <label for="nombre">Nombre a buscar</label>
            <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="ayuda_nombre" placeholder="Ej: Yolanda Hernandez">
            <small id="ayuda_nombre" class="form-text text-muted">Segmentos en formato nombre-apellido o apellido-nombre</small>
          </div>
          
          <div class="form-group">
            <label for="nivel_coinc">Nivel de coincidencia</label>
            <select class="form-control" id="nivel_coinc" name="nivel_coinc">
              <option value="1">Básico: nombres que tengan al menos una palabra similar</option>
              <option value="2">Avanzado: nombres que tengan mínimo dos palabras similares</option>              
            </select>
          </div>
          
          <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>
</div>

<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->
</body>
</html>