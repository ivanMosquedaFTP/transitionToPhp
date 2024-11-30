<?php require('views/header/headerAdministrador.php')?>
  <h1>Ventas</h1>
  <?php if (isset($mensaje)): $app -> alerta($tipo, $mensaje); endif;?>
  <a href="venta.php?accion=crear" class="btn btn-success">Nueva</a>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Usuario</th>
      <th scope="col">Producto</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Monto</th>
      <th scope="col">Fecha de la venta</th>
      <th scope="col">Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($ventas as $venta): ?>
    <tr>
      <td><?php echo $venta ['id']; ?></td>
      <td><?php echo $venta ['nombre_completo']; ?></td>
      <td><?php echo $venta ['nombre_producto']; ?></td>
      <td><?php echo $venta ['cantidad']; ?></td>
      <td><?php echo $venta ['monto']; ?></td>
      <td><?php echo $venta ['fecha_venta']; ?></td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
          <a href="venta.php?accion=actualizar&id=<?php echo $venta ['id']; ?>" class="btn btn-warning">Actualizar</a>
          <a href="venta.php?accion=eliminar&id=<?php echo $venta ['id']; ?>" class="btn btn-danger">Eliminar</a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require('views/footer.php')?>