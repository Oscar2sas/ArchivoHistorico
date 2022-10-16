<?php  
  
  if (isset($_GET['error'])) 
  {
  
    echo "<br><br>
    <div class='col-lg-12'>
     <div class='card alert-danger'>
      <div class='card-body text-center'>
       Usuario o Contraseña Incorrecta !</div>
     </div></div>";
   
  } 

  ?> 
  <div class="imagen" >
	<img width="200" src="<?php echo $carpeta_trabajo;?>/storage/imagenes/patrimonio.png" alt="logo">
  </div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $carpeta_trabajo;?>/estilos/index.css">
    <title>RESGISTRO</title>
</head>
<body class="fondo" >
  

    
<div>
<div class="tabla">
<div class="titulo">
REGISTRAR USUARIO
   </div>
<form  method="post" accion="<?php echo $carpeta_trabajo;?>/administracion/registrar.php">
<input type="hidden" name="accion" value="registrar">
    
    <p><input  class="text" type="text" placeholder="Nombre de Usuario" name="cnombre_usuario"></p>
    <p><input class="text" type="email" placeholder="Email" name="cemail_usuario"></p>
    <p>
    <input class="text" type="password" placeholder="Contraseña" name="cpassword_usuario">
    </p>
    <p>
    <button type="submit" class="boton"> Registrarse</button>
    </p>
</form>
</div>
</div>
</body>
</html>