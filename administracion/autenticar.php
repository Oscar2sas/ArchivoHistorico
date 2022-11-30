<?php

session_start();

$carpeta_trabajo="";
$seccion_trabajo="/administracion";

if (strpos($_SERVER["PHP_SELF"], $seccion_trabajo) >1 ) {
    $carpeta_trabajo=substr($_SERVER["PHP_SELF"],1, strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) -1);
}
$absolute_include = str_repeat("../",substr_count($_SERVER["PHP_SELF"] , "/") -1).$carpeta_trabajo;

if (!empty($carpeta_trabajo)) {
    $absolute_include = $absolute_include."/"; 
    $carpeta_trabajo = "/".$carpeta_trabajo; 
    
}

include ($absolute_include."datos/global.php");
include ($absolute_include."conexion/conexion.php");
include ($absolute_include."modelo/log/modelo_log.php");
include ($absolute_include."modelo/usuarios/modelo_usuarios.php");

if (!isset($_POST['usuario']) && !isset($_POST['password'])) {
    header("location: ".$carpeta_trabajo."/administracion/login.php");
}

$usuario_id = 0;
$nombre_usuario = "Invitado";
$usuario = $_POST['usuario'];
$password = $_POST['password']; 

$resultados = login_usuario($usuario,$password);

if(!$resultados){
    $usuario_id = 0;
    header("Location: ".$carpeta_trabajo."/administracion/login.php?error=2");
}else{
	
	//var_dump($resultados);
    $usuario_id = $resultados['id_usuarios'];
    $nombre_usuario = $resultados['cnombre_usuario'];
    $usuario = $resultados['cemail_usuario'];
    $hash = $resultados['cpassword_usuario'];

    $rela_rol_id = $resultados['rela_rol_id'];

    $estado_usuario = $resultados['estado'];
	
	/*$so = password_hash(trim('queso2022'), PASSWORD_DEFAULT);
	$contr = password_verify('queso2022',$hash);
	
	echo 'la contraseña es: '.$contr;*/

    if (!password_verify($password, $hash)) {
        
        $usuario_id = 0;
        header("Location: ".$carpeta_trabajo."/administracion/login.php?error=1");
    } 
    
    if ($estado_usuario === 2) {
        $usuario_id = 0;
        header("Location: ".$carpeta_trabajo."/administracion/login.php?error=3");
    }
    if ($rela_rol_id == 20) {
        $usuario_id = 0;
        header("Location: ".$carpeta_trabajo."/administracion/login.php?error=4");
    }

    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['nombreUsuario'] = $nombre_usuario;
    $_SESSION['Usuario'] = $usuario;
    $_SESSION['Password'] = $password;

    $_SESSION['rela_rol_id'] = $rela_rol_id;

    $hora = date('H:i');
    $session_id = session_id();
    $token = hash('sha256',$hora.$session_id);

    $_SESSION['token'] = $token;

    $cdescripcion_log = 'Ingreso al sistema: '.$_SESSION['nombreUsuario'].' con ID: '.$_SESSION['usuario_id'];
    insertar_log($cdescripcion_log);

    if (($usuario_id != 0) && ($rela_rol_id == 1) || ($rela_rol_id == 2) || ($rela_rol_id == 3) || ($rela_rol_id == 4) ) {
        header("Location: ".$carpeta_trabajo."/index.php");
    }


}
