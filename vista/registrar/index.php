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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>REGISTRAR USUARIO</h1>
<form>
<input type="hidden" name="accion" value="registrar">
    <div>
    <p><input type="email" placeholder="Ingrese su nombre de Usuario"></p>
    <p><input type="email" placeholder="Ingrese su email"></p>
    <p>
    <input type="text" placeholder="Ingrese su contraseña">
    </p>
    </div>
</form>
<p>
	<a href="<?php echo $carpeta_trabajo;?>/administracion/registrar.php"><button type="submit"> Registrarse</button></a>
</p>
</body>
</html>