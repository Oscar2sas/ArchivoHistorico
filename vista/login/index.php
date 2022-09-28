<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
	<style>
.error{
	width:25%;
	margin: 0 auto;
	text-align: 'center';
	color: #c0392b;
	background-color: #bdc3c7;
}
</style>
</head>
<body>

<?php
	if(isset($_GET['error'])){
		$error = $_GET['error'];
		switch($error){
			case 1: $des_error = 'Contraseña Incorrecta'; break;
			case 2: $des_error = 'Usuario no Encontrado'; break;
			case 3: $des_error = 'Usuario inhabilitado'; break;
			case 4: $des_error = 'Esperando la aprobacion del administrador'; break;
		}
		
		echo '<br><p><h1 class="error">'.$des_error.'</h1></p>';
	}
?>
    <h1>INICIAR SESION</h1>

	<form>
		<div>
		<p> 
		<input type="email" placeholder="Ingrese su Email"  autofocus class="form-control" name="usuario" required>
		</p>
		<p>
		<input type="password" autofocus class="form-control" name="password" placeholder="Ingrese su password" required>
		</p>
		<p>
		<button type="submit"> Iniciar Sesion</button>
		</p>
		<p>
		</div>
	</form>
	<p>
	<a href="<?php echo $carpeta_trabajo;?>/administracion/registrar.php"><button type="submit"> Registrarse</button></a>
		</p>
	</p>
</body>
</html>