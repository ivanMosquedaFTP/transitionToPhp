<?php require('views/header/headerAdministrador.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nuevo');else: echo ('Modificar');endif; ?> permiso</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form method="post" action="permiso.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="permiso" class="form-label">Defina el permiso a continuación</label>
            <input class="form-control" type="text" name="data[permiso]" placeholder="Escribe aqui el permiso" value="<?php if(isset($permisos["permiso"])):echo($permisos['permiso']);endif;?>" id="permiso"/>
        </div>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>