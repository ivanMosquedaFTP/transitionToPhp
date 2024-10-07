<?php require('views/header.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nuevo');else: echo ('Modificar');endif; ?> producto</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form method="post" action="producto.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre del producto</label>
            <input class="form-control" type="text" name="data[nombre_producto]" placeholder="Escribe aqui el nombre del producto" value="<?php if(isset($productos["nombre_producto"])):echo($productos['nombre_producto']);endif;?>" id="nombre_producto"/>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción del nuevo producto</label>
            <input class="form-control" type="text" name="data[descripcion]" placeholder="Escribe aqui la descripción del producto"  value="<?php if(isset($productos["descripcion"])):echo($productos['descripcion']);endif;?>"  id="descripcion"/>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio del nuevo producto</label>
            <input class="form-control" type="text" name="data[precio]" placeholder="Escribe aqui el precio del producto"  value="<?php if(isset($productos["precio"])):echo($productos['precio']);endif;?>"  id="precio"/>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock del nuevo producto</label>
            <input class="form-control" type="text" name="data[stock]" placeholder="Escribe aqui el stock del producto"  value="<?php if(isset($productos["stock"])):echo($productos['stock']);endif;?>"  id="stock"/>
        </div>

        <div class="mb-3">
            <label for="fecha_publicacion" class="form-label">Fecha de publicación del nuevo producto</label>
            <input class="form-control" type="text" name="data[fecha_publicacion]" placeholder="Escribe aqui la fecha de publicación del producto"  value="<?php if(isset($productos["fecha_publicacion"])):echo($productos['fecha_publicacion']);endif;?>"  id="fecha_publicacion"/>
        </div>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>