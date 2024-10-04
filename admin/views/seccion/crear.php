<?php require('views/header.php'); ?>
<center>
    <h1><?php if($accion=="crear"):echo('Nuevo');else: echo ('Modificar');endif; ?> seccion</h1>
</center>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form method="post" action="seccion.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>">
        <div class="mb-3">
            <label for="seccion" class="form-label">Nombre de la sección</label>
            <input class="form-control" type="text" name="data[seccion]" placeholder="Escribe aqui el nombre" value="<?php if(isset($secciones["seccion"])):echo($secciones['seccion']);endif;?>" id="seccion"/>
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Area de la sección (m<sup>2</sup>)</label>
            <input class="form-control" id="area" type="number" name="data[area]" placeholder="Escribe aqui el area" value="<?php if(isset($secciones["area"])):echo($secciones['area']);endif;?>"/>
        </div>

        <div class="mb-3">
           <label for="">Invernadero</label> 
           <select name="data[id_invernadero]" id="" class="form-select">
                <?php foreach($invernaderos as $invernadero):?> 
                <?php
                    $selected = "";
                    if ($secciones['id_invernadero'] == $invernadero['id_invernadero']) {
                        $selected = "selected";
                    }
                ?>
                <option value="<?php echo($invernadero['id_invernadero']);?>" <?php echo($selected);?>><?php echo($invernadero['invernadero']);?></option>
                <?php endforeach;?>
           </select>
        </div>

        <input type="submit" value="Guardar" name="data[enviar]" class="btn btn-primary w-100">
        </form>
    </div>
    <div class="col-md-1"></div>
</div>

<?php require('views/footer.php'); ?>