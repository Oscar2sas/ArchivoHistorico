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
		include($absolute_include."modelo/Biblioteca/subir-archivo/modelo-subir.php");
			
			$accion = '';
			
			if(isset($_REQUEST['accion'])){
				$accion = $_REQUEST['accion'];
			}

			if ($accion == 'biblioteca') {

				$alonso = formar_Formulario();
				echo json_encode($alonso);
				return;
			}elseif ($accion == 'palabra') {
				$listapalabra = Palabras_L();
				echo json_encode($listapalabra);
				return;
			}elseif ($accion == 'guardar') {
				guardar($_POST);
			}

		
		
		include($absolute_include."vista/Biblioteca/subir/index.php");
		
	?>