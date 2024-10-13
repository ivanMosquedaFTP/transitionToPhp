<?php require('views/header.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nueva');else: echo ('Modificar');endif; ?> recompensa</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form method="post" action="recompensa.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="usuario_id" class="form-label">Usuario</label>
            <select name="data[id]" id="" class="form-select">
              <?php foreach($usuarios as $usuario):?> 
                <?php
                  $selected = "";
                   if ($recompensas['id_usuario'] == $usuario['id']) {
                       $selected = "selected";
                   }
                ?>
                <option value="<?php echo($usuario['id']);?>" <?php echo($selected);?>><?php echo($usuario['nombre_completo']);?></option>
                <?php endforeach;?>
           </select>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción de la nueva recompensa</label>
            <input class="form-control" type="text" name="data[descripcion]" placeholder="Escribe aqui la descripción de la recompensa"  value="<?php if(isset($recompensas["descripcion"])):echo($recompensas['descripcion']);endif;?>"  id="descripcion"/>
        </div>

        <div class="mb-3">
            <label for="fecha_otorgada" class="form-label">Fecha otorgada de la recompensa</label>
            <input class="form-control" type="text" name="data[fecha_otorgada]" placeholder="Escribe aqui la fecha de otorgacion de la recompensa"  value="<?php if(isset($recompensas["fecha_otorgada"])):echo($recompensas['fecha_otorgada']);endif;?>"  id="fecha_otorgada"/>
        </div>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>
