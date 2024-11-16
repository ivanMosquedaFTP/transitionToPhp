<?php require('views/header/headerAdministrador.php');?>
  <h1>Usuarios</h1>
  <?php if (isset($mensaje)): $app -> alerta($tipo, $mensaje); endif;?>
  <a href="usuario.php?accion=crear" class="btn btn-success">Nuevo</a>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Nombre del usuario</th>
      <th scope="col">Telefono</th>
      <th scope="col">email</th>
      <th scope="col">Fecha de registro</th>
      <th scope="col">Total de compras</th>
      <th scope="col">Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($usuarios as $usuario): ?>
    <tr>
      <td><?php echo $usuario ['id']; ?></td>
      <td><?php echo $usuario ['nombre_completo']; ?></td>
      <td><?php echo $usuario ['telefono']; ?></td>
      <td><?php echo $usuario ['email']; ?></td>
      <td><?php echo $usuario ['fecha_registro']; ?></td>
      <td><?php echo $usuario ['total_compras']; ?></td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
          <a href="usuario.php?accion=actualizar&id=<?php echo $usuario ['id']; ?>" class="btn btn-warning">Actualizar</a>
          <a href="usuario.php?accion=eliminar&id=<?php echo $usuario ['id']; ?>" class="btn btn-danger">Eliminar</a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require('views/footer.php')?>
