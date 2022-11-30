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
		include($absolute_include."conexion/conexion.php");
		include ($absolute_include."modelo/log/modelo_log.php");
		include($absolute_include."modelo/busqueda/busqueda-modelo.php");
		include($absolute_include."modelo/Fotografia/modelo-foto_svm.php");
		include($absolute_include."modelo/Palabras-claves/modelo-Pc.php");
			
			$accion = '';
			
			if(isset($_REQUEST['accion'])){
				$accion = $_REQUEST['accion'];
			}

			if ($accion == '') {

				$titulo_area = "Fotografia";
				$ruta_home = "controladores/Fotografia/controler-svm.php";
				$ruta_subir = "controladores/Fotografia/controler-svm.php?accion=subir";
				$encendido = 'home';
				$icon='ri-camera-fill';

				include($absolute_include."vista/Fotografia/index/index.php");
			}elseif ($accion == 'subir') {

				$titulo_area = "Fotografia";
				$ruta_home = "controladores/Fotografia/controler-svm.php";
				$ruta_subir = "controladores/Fotografia/controler-svm.php?accion=subir";
				$encendido = 'subir';
				$icon='ri-camera-fill';
				include($absolute_include."vista/Fotografia/foto-svm/index.php");
				
			}elseif ($accion == 'guardar') {
				guardar($_POST);
			}elseif ($accion == 'edit') {
				$id = $_GET['id'];
				$titulo_area = "Modificar";
				$datos_libro = buscar_una_image($id);
				include($absolute_include."vista/Fotografia/modificar/modificar.php");
			}elseif ($accion == 'Modificar') {
				modificar_img($_POST);
				
			}
			elseif ($accion == 'delete') {
				$id = $_GET['id'];
				$titulo_area = "Eliminar";
				$libro = buscar_una_image_d($id);
				include($absolute_include."vista/Fotografia/eliminar/eliminar.php");
			}
			elseif ($accion == 'eliminar') {
				$id = $_GET['id'];
				Eliminar($id);
				
			}

		
		
		
		
	?>