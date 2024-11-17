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
      <th scope="col">Opciones</th>
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

<div class="row">
    <?php foreach ($productos as $producto): ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
              <div class="card-img-container">
                <img src="<?php 
                            if(file_exists("../image/shop/".$producto['foto'])) {
                              echo("../image/shop/".$producto['foto']);
                            } else {
                              echo("../image/shop/default.png");
                            }
                          ?>" class="card-img-top">
              </div>
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre_producto']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                <p class="card-text"><strong>Precio:</strong> $<?php echo number_format($producto['precio'], 2); ?></p>
                <p class="card-text"><strong>Stock:</strong> <?php echo htmlspecialchars($producto['stock']); ?></p>
                <p class="card-text"><small class="text-muted">Publicado: <?php echo htmlspecialchars($producto['fecha_publicacion']); ?></small></p>
                <p class="card-text"><small class="text-muted">Identificador: <?php echo htmlspecialchars($producto['id']); ?></small></p>
                <div class="d-flex justify-content-between align-items-center">
                  <a href="producto.php?accion=actualizar&id=<?php echo $producto['id']; ?>" class="btn btn-primary">Editar</a>
                  <a href="producto.php?accion=eliminar&id=<?php echo $producto['id']; ?>" class="btn btn-danger">Eliminar</a>
                </div>
              </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require('views/footer.php')?>