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

    $usuario_id = $resultados['usuario_id'];
    $nombre_usuario = $resultados['cnombre_usuario'];
    $usuario = $resultados['cmail_usuario'];
    $hash = $resultados['cpassword_usuario'];

    $rela_rol_id = $resultados['rela_rol_id'];
    $cimg_usuario = $resultados['cimg_usuario'];

    $rol = $resultados['cdescripcion_rol'];

    $estado_usuario = $resultados['nestado_usuario'];

    if (!password_verify($password, $hash)) {
        
        $usuario_id = 0;
        header("Location: ".$carpeta_trabajo."/administracion/login.php?error=1");
    }
    if ($rela_rol_id == 20) {
        $usuario_id = 0;
        header("Location: ".$carpeta_trabajo."/administracion/login.php?error=4");
    }if ($estado_usuario = 2) {
        $usuario_id = 0;
        header("Location: ".$carpeta_trabajo."/administracion/login.php?error=3");
    }

    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['nombreUsuario'] = $nombre_usuario;
    $_SESSION['Usuario'] = $usuario;
    $_SESSION['Password'] = $password;

    $_SESSION['rela_rol_id'] = $rela_rol_id;
    $_SESSION['Rol'] = $rol;
    $_SESSION['ImagenPerfil'] = $cimg_usuario;

    $hora = date('H:i');
    $session_id = session_id();
    $token = hash('sha256',$hora.$session_id);

    $_SESSION['token'] = $token;

    $cdescripcion_log = 'Ingreso el sistema: '.$_SESSION['nombreUsuario'].' con ID: '.$_SESSION['usuario_id'];
    insertar_log($cdescripcion_log);

    if (($usuario_id != 0) && ($rela_rol_id == 1) || ($rela_rol_id == 2) || ($rela_rol_id == 3) || ($rela_rol_id == 4) ) {
        header("Location: ".$carpeta_trabajo."/index.php");
    }

    


}
