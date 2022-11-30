<?php
$carpeta_trabajo="";
$seccion_trabajo="/controladores";

if (strpos($_SERVER["PHP_SELF"], $seccion_trabajo) >1 ) {
    $carpeta_trabajo=substr($_SERVER["PHP_SELF"],1, strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) -1);
}
$absolute_include = str_repeat("../",substr_count($_SERVER["PHP_SELF"] , "/") -1).$carpeta_trabajo;

if (!empty($carpeta_trabajo)) {
    $absolute_include = $absolute_include."/"; 
    $carpeta_trabajo = "/".$carpeta_trabajo; 
    
}
include($absolute_include."administracion/sesion.php");
include($absolute_include."/conexion/conexion.php");
include($absolute_include."/modelo/Administracion/administrer_modelo.php");
include($absolute_include."/modelo/log/modelo_log.php");

$accion = "";

if(isset($_REQUEST['accion'])) {
    $accion = $_REQUEST['accion'];
}
if($accion==''){
    $titulo_area = "Administracion";
    $user=Buscar_user();
    $logs = buscar_log();
    include($absolute_include."vista/Administracion/index.php");
}



?>