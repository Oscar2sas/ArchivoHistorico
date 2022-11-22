<?php include($absolute_include."vista/plantilla/header.php"); ?>
<div class='contenedor-login'>
	
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

	<main>
		<div class="contenedor_todo">
			<div class="caja_trasera">
				<div class="caja_trasera_login">
					<h3>¿Ya Tienes cuenta? Inicia Sesion</h3>
					<p>Inicia Sesion</p>
					<button id="btn_inicio-sesion"> Iniciar Sesion</button>
				</div>

				<div class="caja_trasera_registrar">
					<h3>¿No Tienes cuenta? Crea una</h3>
					<p>Crea Una Cuenta</p>
					<button id="btn_registrar"> Crear Cuenta</button>
				</div>

			</div>
			<div class="contenedor_login-registrar">
				<form action="<?php echo $carpeta_trabajo;?>/administracion/autenticar.php" method="post" class="formulario_login">

					<h2>Iniciar Sesion</h2>

					<input type="text" placeholder="Correo ELectronico" name="usuario" require>
					<input type="password" placeholder="Contraseña" name="password" require>
					<button type="submit"> Ingresar</button>
				</form>
				
				<form action="<?php echo $carpeta_trabajo;?>/administracion/registrar.php" method="post" class="formulario_registrar">
					<input type="hidden" name="accion" value="registrar">
					<h2>Crear Cuenta</h2>
					<input type=" text" placeholder="Nombre Completo" name="cnombre_usuario">
					<input type=" text" placeholder="Correo Electronico" name="cemail_usuario">
					<input type=" text" placeholder="Contraseña" name="cpassword_usuario">
					<button type="submit" >Crear Cuenta</button>
				</form>
			</div>

		</div>
	</main>
</div>
<?php include($absolute_include."vista/plantilla/footers.php"); ?>