<?php require('views/header.php')?>
  <center>
    <h1>Productos</h1>
  </center>
  <?php if (isset($mensaje)): $app -> alerta($tipo, $mensaje); endif;?>
  <a href="producto.php?accion=crear" class="btn btn-success">Nuevo</a>
  <div class="row">
    <?php if (!empty($productos)): ?>
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
        <?php else: ?>
        <tr>
            <td colspan="7">No hay productos disponibles.</td>
        </tr>
    <?php endif; ?>
  </div>

<?php require('views/footer.php')?>