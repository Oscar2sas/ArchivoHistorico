<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="<?php echo $carpeta_trabajo;?>/estilos/index.css">
	<link rel="stylesheet" href="<?php echo $carpeta_trabajo;?>/RemixIcon_Fonts_v2.5.0/fonts/remixicon.css">
    <title>Document</title>
</head>
<body class='fondo'>
<div class="imagen" >
		<img width="200" src="<?php echo $carpeta_trabajo;?>/storage/imagenes/patrimonio.png" alt="logo">
	</div>
    <h1>Bienvenido al Archivo Historico Provincial</h1>
	<p><form action="<?php echo $carpeta_trabajo;?>/controladores/busqueda/buscar-controler.php" method="post">
        <input type="text" name="busqueda" class='inputB'><button class='botonB'><i class="ri-search-line"></i></button>
    </form></p>
		<a href='<?php echo $carpeta_trabajo;?>/controladores/Subir_archivo/controler-sub.php'>Subir archivo</a>
</body>
</html>