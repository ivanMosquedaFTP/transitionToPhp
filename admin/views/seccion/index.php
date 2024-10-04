<?php require('views/header.php')?>
  <h1>Secciones</h1>
  <?php if (isset($mensaje)): $app -> alerta($tipo, $mensaje); endif;?>
  <a href="seccion.php?accion=crear" class="btn btn-success">Nuevo</a>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Id seccion</th>
      <th scope="col">Sección</th>
      <th scope="col">Area</th>
      <th scope="col">Invernadero</th>
  </thead>
  <tbody>
    <?php foreach($secciones as $seccion): ?>
    <tr>
      <th scope="row"><?php echo $seccion ['id_seccion']; ?></th>
      <td><?php echo $seccion ['seccion']; ?></td>
      <td><?php echo $seccion ['area']; ?></td>
      <td><?php echo $seccion ['invernadero']; ?></td>
      <td>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
          <a href="seccion.php?accion=actualizar&id=<?php echo $seccion ['id_seccion']; ?>" class="btn btn-warning">Actualizar</a>
          <a href="seccion.php?accion=eliminar&id=<?php echo $seccion ['id_seccion']; ?>" class="btn btn-danger">Eliminar</a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require('views/footer.php')?>