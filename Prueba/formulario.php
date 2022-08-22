<?php 
    include('modeloimagen.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="estilos/cosas.css">
</head>
<body>
    
    <form action="modelo_biblioteca.php" method="post" enctype="multipart/form-data">
    <div id='formulario' class='atributo'>
            <?php 
                echo buscar_areas();
            ?>
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="Formulario.js"></script>
</body>
</html>

