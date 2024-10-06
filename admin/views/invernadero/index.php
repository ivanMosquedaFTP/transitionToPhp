<?php require('views/header.php')?>
  <h1>Administradores</h1>
  <?php if (isset($mensaje)): $app -> alerta($tipo, $mensaje); endif;?>
  <a href="administrador.php?accion=crear" class="btn btn-success">Nuevo</a>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Nombre</th>
      <th scope="col">Contraseña</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($administradores as $administrador): ?>
    <tr>
      <td><?php echo $administrador ['id']; ?></td>
      <td><?php echo $administrador ['nombre']; ?></td>
      <td><?php echo $administrador ['contrasena']; ?></td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
          <a href="administrador.php?accion=actualizar&id=<?php echo $administrador ['id']; ?>" class="btn btn-warning">Actualizar</a>
          <a href="administrador.php?accion=eliminar&id=<?php echo $administrador ['id']; ?>" class="btn btn-danger">Eliminar</a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require('views/footer.php')?>