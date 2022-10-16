<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="<?php echo $carpeta_trabajo;?>/estilos/index.css">
    <title>Login</title>
	<style>
</style>
</head>
<body class="fondo">
	<div class="imagen" >
		<img width="200" src="<?php echo $carpeta_trabajo;?>/storage/imagenes/patrimonio.png" alt="logo">
	</div>
	
	<?php
		if(isset($_GET['error'])){
			$error = $_GET['error'];
			switch($error){
				case 1: $des_error = 'Contraseña Incorrecta'; break;
				case 2: $des_error = 'Usuario no Encontrado'; break;
				case 3: $des_error = 'Usuario inhabilitado'; break;
				case 4: $des_error = 'Esperando la aprobacion del administrador'; break;
			}
			
			echo '<div class="error"> '.$des_error.' </div>';
		}
	?>
	<div class="tabla">
		<form method="POST" action="<?php echo $carpeta_trabajo;?>/administracion/autenticar.php">
		<div class="titulo">
		INICIAR SESION
		</div>
			<p> 
				<input class="text" type="email" placeholder="Ingrese su Email"  autofocus name="usuario" required>
			</p>
			<p>
				<input class="text" type="password" placeholder="Ingrese su password"  name="password"  required>
			</p>
			<p>
				<button class="boton" type="submit"> Iniciar Sesion</button>
			</p>
		
		</form>
		<p>
			<a href="<?php echo $carpeta_trabajo;?>/administracion/registrar.php"><button class="boton" type="submit"> Registrarse</button></a>
		</p>
	</div>
	
</body>
</html>