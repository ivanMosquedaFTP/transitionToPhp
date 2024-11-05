<?php require('views/header/headerAdministrador.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nuevo');else: echo ('Modificar');endif; ?> usuario</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form method="post" action="usuario.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="nombre_completo" class="form-label">Nombre del usuario</label>
            <input class="form-control" type="text" name="data[nombre_completo]" placeholder="Escribe aqui el nombre del usuario" value="<?php if(isset($usuarios["nombre_completo"])):echo($usuarios['nombre_completo']);endif;?>" id="nombre_completo"/>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono del nuevo usuario</label>
            <input class="form-control" type="text" name="data[telefono]" placeholder="Escribe aqui el teléfono del usuario"  value="<?php if(isset($usuarios["telefono"])):echo($usuarios['telefono']);endif;?>"  id="telefono"/>
        </div>

        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña del nuevo usuario</label>
            <input class="form-control" type="text" name="data[contrasena]" placeholder="Escribe aqui la contraseña del usuario"  value="<?php if(isset($usuarios["contrasena"])):echo($usuarios['contrasena']);endif;?>"  id="contrasena"/>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email del nuevo usuario</label>
            <input class="form-control" type="text" name="data[email]" placeholder="Escribe aqui el email del usuario"  value="<?php if(isset($usuarios["email"])):echo($usuarios['email']);endif;?>"  id="email"/>
        </div>

        <?php foreach($roles as $rol): ?>
          <div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" <?php $checked = ''; if(in_array($rol['id_rol'], $misRoles)): $checked = 'checked'; endif; echo($checked); ?> role="switch" id="flexSwitchCheckChecked" name="rol[<?php echo($rol['id_rol']);?>]">
              <label class="form-check-label" for="flexSwitchCheckChecked"><?php echo($rol['rol']);?></label>
            </div>
          </div>
        <?php endforeach;?>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>
