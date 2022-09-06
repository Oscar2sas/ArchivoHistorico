<?php

session_start();

if(!isset($_SESSION['usuario'])) 
{
header("Location: ".$carpeta_trabajo."/administracion/login.php" );
}
$usuarios_permitidos = array(1,2);

if (!empty($usuarios_permitidos)) {
    $permitidos = $usuarios_permitidos;
}else{
    $permitidos = "";
}

if (!empty($permitidos)) {
    if (!in_array($_SESSION['rela_rol_id'], $permitidos) ) {

        if (isset($_SERVER['HTTP_REFERER'])) {
           $url_anterior = explode("/", $_SERVER['HTTP_REFERER'], 4);
           header("Location: ".$url_anterior[3]); 
        } else {
            header("Location: ".$carpeta_trabajo."/controladores/inicio/index.php");
            
        }
        
    }
}

?>
