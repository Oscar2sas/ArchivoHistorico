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

			$titulo_area = "Biblioteca";
			$ruta_home = "controladores/Biblioteca/Subir_archivo/controler-sub.php";
			$ruta_subir = "controladores/Biblioteca/Subir_archivo/controler-sub.php?accion=subir";
			
			$accion = '';
			
			if(isset($_REQUEST['accion'])){
				$accion = $_REQUEST['accion'];
			}
			if($accion == ''){

				$titulo_area = "Biblioteca";
				$ruta_home = "controladores/Biblioteca/Subir_archivo/controler-sub.php";
				$ruta_subir = "controladores/Biblioteca/Subir_archivo/controler-sub.php?accion=subir";
				$encendido = 'home';
				include($absolute_include."vista/Biblioteca/index/index.php");

			}elseif ($accion == 'subir') {

				$titulo_area = "Biblioteca";
				$ruta_home = "controladores/Biblioteca/Subir_archivo/controler-sub.php";
				$ruta_subir = "controladores/Biblioteca/Subir_archivo/controler-sub.php?accion=subir";
				$encendido = 'subir';
				include($absolute_include."vista/Biblioteca/subir/index.php");
				
			}elseif ($accion == 'palabra') {
				$listapalabra = Palabras_L();
				echo json_encode($listapalabra);
				return;
			}elseif ($accion == 'guardar') {
				guardar($_POST);
			}

		
	?>