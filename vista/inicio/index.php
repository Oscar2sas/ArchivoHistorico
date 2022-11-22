	
<?php
	include($absolute_include."vista/plantilla/header.php");

	if (@$_SESSION['rela_rol_id'] == 1){
		include($absolute_include.'vista/componentes/sideBar.php');
	} 
	elseif(@$_SESSION['rela_rol_id'] == ''){
		include($absolute_include.'vista/componentes/botones-inicio.php');
	}
 ?>

	<div class='contenedor-inicio'>
		<div class="imagen" >
			<img width="200" src="<?php echo $carpeta_trabajo;?>/storage/imagenes/patrimonio.png" alt="logo">
		</div>

		<h1>Bienvenido al Archivo Historico Provincial</h1>

			<form action="<?php echo $carpeta_trabajo;?>/controladores/busqueda/buscar-controler.php" method="post" class='form-inicio'>
			<input type="text" name="busqueda" class='inputB'><button class='botonB'><i class="ri-search-line"></i></button>
			</form>
	</div>

	<?php include($absolute_include."vista/plantilla/footers.php"); ?>
