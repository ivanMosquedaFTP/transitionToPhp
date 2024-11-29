<?php require('views/header.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nueva');else: echo ('Modificar');endif; ?> venta</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form method="post" action="venta.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="usuario_id" class="form-label">Usuario</label>
            <select name="data[usuario_id]" id="" class="form-select">
              <?php foreach($usuarios as $usuario):?> 
                <?php
                  $selected = "";
                   if ($ventas['usuario_id'] == $usuario['id']) {
                       $selected = "selected";
                   }
                ?>
                <option value="<?php echo($usuario['id']);?>" <?php echo($selected);?>><?php echo($usuario['nombre_completo']);?></option>
                <?php endforeach;?>
           </select>
        </div>

        <div class="mb-3">
            <label for="producto_id" class="form-label">Producto</label>
            <select name="data[producto_id]" id="" class="form-select">
              <?php foreach($productos as $producto):?> 
                <?php
                  $selected = "";
                   if ($ventas['producto_id'] == $producto['id']) {
                       $selected = "selected";
                   }
                ?>
                <option value="<?php echo($producto['id']);?>" <?php echo($selected);?>><?php echo($producto['nombre_producto']);?></option>
                <?php endforeach;?>
           </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad del producto de la venta</label>
            <input class="form-control" type="text" name="data[cantidad]" placeholder="Escribe aqui la cantidad del producto del venta"  value="<?php if(isset($ventas["cantidad"])):echo($ventas['cantidad']);endif;?>"  id="cantidad"/>
        </div>

        <div class="mb-3">
            <label for="monto" class="form-label">Monto de la venta</label>
            <input class="form-control" type="text" name="data[monto]" placeholder="Escribe aqui el monto del venta"  value="<?php if(isset($producto["precio"])):echo($producto['precio']);endif;?>"  id="monto"/>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha de la venta</label>
            <input class="form-control" type="date" name="data[fecha_venta]" value="<?php if(isset($ventas["fecha_venta"])):echo($ventas['fecha_venta']);endif;?>"  id="fecha"/>
        </div>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>
