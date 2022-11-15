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
	
	$aBuscar = $_POST['busqueda'];
	
	include($absolute_include."/conexion/conexion.php");
	include($absolute_include."modelo/busqueda/busqueda-modelo.php");
	
    $resultado_de_busqueda = buscar($aBuscar);
	include($absolute_include."vista/busqueda/busqueda-vista.php");

?>