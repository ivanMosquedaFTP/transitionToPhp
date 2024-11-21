  <?php if (isset($mensaje)): $app -> alerta($tipo, $mensaje); endif;?>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
      <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
          <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Crea tu cuenta hoy mismo!</h1>
          <p class="col-lg-10 fs-4">Al crear tu cuenta estarás automáticamente inscrito al programa de beneficios a
            clientes frecuentes, dichos beneficios van desde descuentos hasta productos gratis!</p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
          <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" action="admin/usuario.php?accion=nuevoDesdeSnippet" method="POST">
            <div class="form-floating mb-3">
              <input type="text" name="data[nombre_completo]" class="form-control" id="inName" placeholder="Nombre completo" required="true">
              <label for="inName">Nombre completo</label>
            </div>
            <div class="form-floating mb-3">
              <input type="text" name="data[telefono]" class="form-control" id="inPhone" placeholder="Numero de telefono" required="true">
              <label for="inPhone">Numero de telefono</label>
            </div>
            <div class="form-floating mb-3">
              <input type="email" name="data[email]" class="form-control" id="inEmail" placeholder="nombre@ejemplo.com" required="true">
              <label for="inEmail">Correo electrónico</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" name="data[contrasena]" class="form-control" id="inPass" placeholder="Contrasena" required="true">
              <label for="inPas">Contraseña</label>
            </div>
            <!-- <button class="w-100 btn btn-lg btn-primary" type="submit">Terminar registro</button> -->
            <input type="submit" value="Terminar registro" name="data[enviar]" class="w-100 btn btn-lg btn-primary">
            <hr class="my-4">
            <small class="text-body-secondary">Al presionar el botón declaras que estás de acuerdo con nuetros <a
                href="index/termsAndConditions.html"> términos y condiciones</a></small>
          </form>
        </div>
      </div>
    </div>