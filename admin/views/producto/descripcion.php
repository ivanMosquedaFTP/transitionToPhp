<?php require('views/header.php')?>
<br>
<main>
    <div class="container mt-4">
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <!-- <input type="hidden" name="business" value="coolhatscelaya@gmail.com"> -->
            <input type="hidden" name="business" value="sb-thsd034331470@business.example.com">

            <input type="hidden" name="notify_url" value="https://2561-177-227-62-217.ngrok-free.app/transitionToPhp/admin/views/producto/notificacion.php">

            <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>">
            <input type="hidden" name="item_number" value="<?php echo htmlspecialchars($producto['id']); ?>">
            <input type="hidden" name="amount" value="<?php echo number_format($producto['precio'], 2); ?>">
            <input type="hidden" name="currency_code" value="MXN">
            <input type="hidden" name="return" value="http://localhost/transitionToPhp/admin/views/producto/confirmacion.php">
            <input type="hidden" name="cancel_return" value="http://localhost/transitionToPhp/admin/views/producto/cancelar.php">

            <div class="row">
                <div class="col-md-6">
                    <div class="img-container">
                        <img src="<?php echo file_exists("../image/shop/" . $producto['foto']) ? "../image/shop/" . $producto['foto'] : "../image/shop/default.png"; ?>" style="border: 1px solid #ddd;" class="card-img-top">
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-between">
                    <div>
                        <h2 class="text-primary"><?php echo htmlspecialchars($producto['nombre_producto']); ?></h2>
                        <p class="text-muted"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p class="text-success"><strong>Precio:</strong> $<?php echo number_format($producto['precio'], 2); ?></p>
                        <p class="text-secondary"><strong>Stock:</strong> <?php if ($producto['stock'] > 0) { echo htmlspecialchars($producto['stock']); } else { echo '<h2>Sin existencias</h2>'; } ?></p>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success btn-lg w-100 mt-3 <?php if ($producto['stock'] == 0) { echo 'disabled'; } ?>">Comprar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<br> <br>
<?php require('views/footer.php')?>