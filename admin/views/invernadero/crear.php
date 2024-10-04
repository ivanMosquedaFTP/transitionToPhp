<?php require('views/header.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nuevo');else: echo ('Modificar');endif; ?> Invernadero</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form method="post" action="invernadero.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="invernadero" class="form-label">Nombre del Invernadero</label>
            <input class="form-control" type="text" name="data[invernadero]" placeholder="Escribe aqui el nombre" value="<?php if(isset($invernaderos["invernadero"])):echo($invernaderos['invernadero']);endif;?>" id="invernadero"/>
        </div>

        <div class="mb-3">
            <label for="latitud" class="form-label">Latitud del Invernadero</label>
            <input class="form-control" type="text" name="data[latitud]" placeholder="Escribe aqui la latitud"  value="<?php if(isset($invernaderos["latitud"])):echo($invernaderos['latitud']);endif;?>"  id="latitud"/>
        </div>

        <div class="mb-3">
            <label for="longitud" class="form-label">Longitud del Invernadero</label>
            <input class="form-control" type="text" name="data[longitud]" placeholder="Escribe aqui la longitud" value="<?php if(isset($invernaderos["longitud"])):echo($invernaderos['longitud']);endif;?>" id="longitud"/>
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Area del Invernadero (m<sup>2</sup>)</label>
            <input class="form-control" id="area" type="number" name="data[area]" placeholder="Escribe aqui el area" value="<?php if(isset($invernaderos["area"])):echo($invernaderos['area']);endif;?>"/>
        </div>

        <div class="mb-3">
            <label class="form-label" for="fecha">Fecha</label>
            <input class="form-control" id="fecha" type="date" name="data[fecha_creacion]" placeholder="Escribe aqui la fecha" value="<?php if(isset($invernaderos["fecha_creacion"])):echo($invernaderos['fecha_creacion']);endif;?>"/>
        </div>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>