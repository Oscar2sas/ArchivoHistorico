<?php include($absolute_include."vista/plantilla/header.php"); ?>

    <form action="" method="post">
        <div class="buscador">
        <input type="text" name="busqueda" id="" value="<?php echo $aBuscar; ?>">
        <input type="submit" value="Buscar">
        </div>
    </form>

        <div class='contenedor-busqueda'>
        
            <?php 
            
            if (!empty($resultado_de_busqueda)) {
               foreach ($resultado_de_busqueda as $key) {
                echo $key;
                }
            }else{

                echo '<img src="../../storage/imagenes/sinResultado.png" style="width:150px;opacity:1; trasition:all 1s"/>
                <h1>No se Encontraron resultados</h1>';
            }

             ?>
        </div>

<?php include($absolute_include."vista/plantilla/footers.php"); ?>