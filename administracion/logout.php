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

include ($absolute_include. "datos/global.php");
include ($absolute_include. "conexion/conexion.php");
include ($absolute_include. "modelo/log/modelo_log.php");

// $cdescripcion_log = " salida del sistema : ".$_SESSION['nombreUsuario']."con ID: ".$_SESSION['usuario_id'];
// insertar_log($cdescripcion_log);

session_destroy();

header("Location: ".$carpeta_trabajo."/administracion/login.php"); 

?>