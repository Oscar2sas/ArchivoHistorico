<?php include($absolute_include."vista/plantilla/header.php"); ?>

    <form action="" method="post">
        <div class="buscador">
        <input type="text" name="busqueda" id="" value="<?php echo $aBuscar; ?>">
        <input type="submit" value="Buscar">
        </div>
    </form>

        <div class='contenedor-busqueda'>
            <?php foreach ($resultado_de_busqueda as $key) {
                echo $key;
            } ?>
        </div>

<?php include($absolute_include."vista/plantilla/footers.php"); ?>