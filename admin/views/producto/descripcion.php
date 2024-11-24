<?php require('views/header.php')?>
<br>
<main>
    <div class="container mt-4">
        <form action="producto.php?accion=comprar" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="img-container">
                        <img src="<?php if(file_exists("../image/shop/".$producto['foto'])) { echo("../image/shop/".$producto['foto']); } else { echo("../image/shop/default.png"); } ?>" style="border: 1px solid #ddd;" class="card-img-top">
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-between">
                    <div>
                        <h2 class="text-primary"><?php echo($producto['nombre_producto']);?></h2>
                        <p class="text-muted">
                            <?php echo($producto['descripcion']);?>
                        </p>
                        <p class="text-success"><strong>Precio:</strong> $<?php echo($producto['precio']);?></p>
                        <p class="text-secondary"><strong>Stock:</strong> <?php if ($producto['stock'] > 0) { echo($producto['stock']); } else { echo("<h2>Sin existencias</h2>"); } ?></p>
                    </div>
                </div>
                <div>
                    <input type="submit" name="enviar" class="btn btn-success btn-lg w-100 mt-3 <?php if ($producto['stock'] == 0) { echo('disabled'); } ?>" value="Comprar">
                </div>
            </div>
        </form>
    </div>
</main>
<br> <br>
<?php require('views/footer.php')?>