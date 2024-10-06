<?php require('views/header.php')?>
  <h1>Productos</h1>
  <?php if (isset($mensaje)): $app -> alerta($tipo, $mensaje); endif;?>
  <a href="producto.php?accion=crear" class="btn btn-success">Nuevo</a>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Nombre del producto</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Precio</th>
      <th scope="col">Stock</th>
      <th scope="col">Fecha de publicación</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($productos as $producto): ?>
    <tr>
      <td><?php echo $producto ['id']; ?></td>
      <td><?php echo $producto ['nombre_producto']; ?></td>
      <td><?php echo $producto ['descripcion']; ?></td>
      <td><?php echo $producto ['precio']; ?></td>
      <td><?php echo $producto ['stock']; ?></td>
      <td><?php echo $producto ['fecha_publicacion']; ?></td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
          <a href="producto.php?accion=actualizar&id=<?php echo $producto ['id']; ?>" class="btn btn-warning">Actualizar</a>
          <a href="producto.php?accion=eliminar&id=<?php echo $producto ['id']; ?>" class="btn btn-danger">Eliminar</a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require('views/footer.php')?>