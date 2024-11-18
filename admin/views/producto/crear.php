<?php require('views/header.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nuevo');else: echo ('Modificar');endif; ?> producto</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <?php if ($accion == 'modificar'): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <?php endif; ?>
    <div class="col-md-10">
        <form method="post" enctype="multipart/form-data" action="producto.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre del producto</label>
            <input class="form-control" type="text" name="data[nombre_producto]" required="true" placeholder="Escribe aqui el nombre del producto" value="<?php if(isset($productos["nombre_producto"])):echo($productos['nombre_producto']);endif;?>" id="nombre_producto"/>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción del nuevo producto</label>
            <input class="form-control" type="text" name="data[descripcion]" required="true" placeholder="Escribe aqui la descripción del producto"  value="<?php if(isset($productos["descripcion"])):echo($productos['descripcion']);endif;?>"  id="descripcion"/>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio del nuevo producto</label>
            <input class="form-control" type="text" name="data[precio]" required="true" placeholder="Escribe aqui el precio del producto"  value="<?php if(isset($productos["precio"])):echo($productos['precio']);endif;?>"  id="precio"/>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock del nuevo producto</label>
            <input class="form-control" type="text" name="data[stock]" required="true" placeholder="Escribe aqui el stock del producto"  value="<?php if(isset($productos["stock"])):echo($productos['stock']);endif;?>"  id="stock"/>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Fotografía</label>
            <input class="form-control" type="file" name="foto" placeholder="Selecciona la fotografía" id="foto"/>
        </div>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>