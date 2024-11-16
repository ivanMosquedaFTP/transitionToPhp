<?php require('views/header.php')?>
  <h1>recompensas</h1>
  <?php if (isset($mensaje)): $app -> alerta($tipo, $mensaje); endif;?>
  <a href="recompensa.php?accion=crear" class="btn btn-success">Nueva</a>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Usuario</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Fecha otorgada</th>
      <th scope="col">Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($recompensas as $recompensa): ?>
      <tr>
      <td><?php echo $recompensa ['id']; ?></td>
      <td><?php echo $recompensa ['nombre_completo']; ?></td>
      <td><?php echo $recompensa ['descripcion']; ?></td>
      <td><?php echo $recompensa ['fecha_otorgada']; ?></td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
          <a href="recompensa.php?accion=actualizar&id=<?php echo $recompensa ['id']; ?>" class="btn btn-warning">Actualizar</a>
          <a href="recompensa.php?accion=eliminar&id=<?php echo $recompensa ['id']; ?>" class="btn btn-danger">Eliminar</a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require('views/footer.php')?>
