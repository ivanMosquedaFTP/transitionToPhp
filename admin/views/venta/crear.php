<?php require('views/header.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nueva');else: echo ('Modificar');endif; ?> venta</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form method="post" action="venta.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="usuario_id" class="form-label">Id del usuario</label>
            <input class="form-control" type="text" name="data[usuario_id]" placeholder="Escribe aqui el id del usuario" value="<?php if(isset($ventas["usuario_id"])):echo($ventas['usuario_id']);endif;?>" id="usuario_id"/>
        </div>

        <div class="mb-3">
            <label for="producto_id" class="form-label">Id del producto de la venta</label>
            <input class="form-control" type="text" name="data[producto_id]" placeholder="Escribe aqui el id del producto del venta"  value="<?php if(isset($ventas["producto_id"])):echo($ventas['producto_id']);endif;?>"  id="producto_id"/>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad del producto de la venta</label>
            <input class="form-control" type="text" name="data[cantidad]" placeholder="Escribe aqui la cantidad del producto del venta"  value="<?php if(isset($ventas["cantidad"])):echo($ventas['cantidad']);endif;?>"  id="cantidad"/>
        </div>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>