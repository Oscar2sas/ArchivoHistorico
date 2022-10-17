<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $aBuscar; ?></title>
    <link rel="stylesheet" href="<?php echo $absolute_include ?>estilos/cosas.css">
</head>
<body>
    <form action="" method="post">
        <div class="buscador">
        <input type="text" name="busqueda" id="" value="<?php echo $aBuscar; ?>">
        <input type="submit" value="Buscar">
        </div>

        <?php foreach ($resultado_de_busqueda as $key) {
            echo $key;
        } ?>
    </form>
</body>
</html>