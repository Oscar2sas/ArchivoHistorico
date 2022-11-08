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
		
		include($absolute_include."conexion/conexion.php");
		include($absolute_include."modelo/Fotografia/modelo-foto_svm.php");
		include($absolute_include."modelo/Palabras-claves/modelo-Pc.php");
			
			$accion = '';
			
			if(isset($_REQUEST['accion'])){
				$accion = $_REQUEST['accion'];
			}

			if ($accion == '') {
				include($absolute_include."vista/Fotografia/foto-svm/index.php");
			}elseif ($accion == 'guardar') {
				guardar($_POST);
			}

		
		
		
		
	?>