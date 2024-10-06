<?php require('views/header.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nuevo');else: echo ('Modificar');endif; ?> Administrador</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form method="post" action="administrador.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del administrador</label>
            <input class="form-control" type="text" name="data[nombre]" placeholder="Escribe aqui el nombre" value="<?php if(isset($administradores["nombre"])):echo($administradores['nombre']);endif;?>" id="nombre"/>
        </div>

        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña del nuevo administrador</label>
            <input class="form-control" type="text" name="data[contrasena]" placeholder="Escribe aqui la contraseña"  value="<?php if(isset($administradores["contrasena"])):echo($administradores['contrasena']);endif;?>"  id="contrasena"/>
        </div>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>