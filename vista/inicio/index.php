<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="<?php echo $carpeta_trabajo;?>/estilos/index.css">
	<link rel="stylesheet" href="<?php echo $carpeta_trabajo;?>/RemixIcon_Fonts_v2.5.0/fonts/remixicon.css">
	<link rel="stylesheet" href="<?php echo $carpeta_trabajo;?>/estilos/slideBar.css">
    <title>Document</title>
</head>
<body class='fondo'>
	
<?php
	if (@$_SESSION['rela_rol_id'] == 1){
		include($absolute_include.'vista/componentes/sideBar.php');
	} 
	elseif(@$_SESSION['rela_rol_id'] == ''){
		include($absolute_include.'vista/componentes/botones-inicio.php');
	}
 ?>
<div class="imagen" >
		<img width="200" src="<?php echo $carpeta_trabajo;?>/storage/imagenes/patrimonio.png" alt="logo">
	</div>
    <h1>Bienvenido al Archivo Historico Provincial</h1>
	<p><form action="<?php echo $carpeta_trabajo;?>/controladores/busqueda/buscar-controler.php" method="post">
        <input type="text" name="busqueda" class='inputB'><button class='botonB'><i class="ri-search-line"></i></button>
    </form></p>
		<script src='<?php echo $carpeta_trabajo;?>/storage/js/slidebar.js'></script>
</body>
</html>