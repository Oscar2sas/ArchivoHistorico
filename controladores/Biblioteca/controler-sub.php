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
		
		include($absolute_include."modelo/Palabras-claves/modelo-Pc.php");
		include($absolute_include."administracion/sesion.php");
		include ($absolute_include."modelo/log/modelo_log.php");
		include($absolute_include."conexion/conexion.php");
		include($absolute_include."modelo/busqueda/busqueda-modelo.php");
		include($absolute_include."modelo/Biblioteca/subir-archivo/modelo-subir.php");
		
			
			$accion = '';
			
			if(isset($_REQUEST['accion'])){
				$accion = $_REQUEST['accion'];
			}
			if($accion == ''){

				$titulo_area = "Biblioteca";
				$ruta_home = "controladores/Biblioteca/controler-sub.php";
				$ruta_subir = "controladores/Biblioteca/controler-sub.php?accion=subir";
				$encendido = 'home';
				$icon='ri-book-mark-line';

				$libros = buscar_libro(0);

				include($absolute_include."vista/Biblioteca/index/index.php");

			}elseif ($accion == 'subir') {

				$titulo_area = "Biblioteca";
				$ruta_home = "controladores/Biblioteca/controler-sub.php";
				$ruta_subir = "controladores/Biblioteca/controler-sub.php?accion=subir";
				$encendido = 'subir';
				$icon='ri-book-mark-line';
				include($absolute_include."vista/Biblioteca/subir/index.php");
				
			}elseif ($accion == 'guardar') {
				guardar($_POST);
				$titulo_area = "Biblioteca";
				$ruta_home = "controladores/Biblioteca/controler-sub.php";
				$ruta_subir = "controladores/Biblioteca/controler-sub.php?accion=subir";
				$encendido = 'subir';
				$icon='ri-book-mark-line';
				include($absolute_include."vista/Biblioteca/index/index.php");

			}elseif ($accion == 'edit') {
				$id = $_GET['id'];
				$titulo_area = "Modificar";
				$datos_libro = buscar_un_libro($id);
				include($absolute_include."vista/Biblioteca/modificar/modificar.php");
			}elseif ($accion == 'modificar') {
				Modificar($_POST);
				
			}
			elseif ($accion == 'delete') {
				$id = $_GET['id'];
				$titulo_area = "Eliminar";
				$libro = buscar_un_libro_d($id);
				include($absolute_include."vista/Biblioteca/eliminar/eliminar.php");
			}
			elseif ($accion == 'eliminar') {
				$id = $_GET['id'];
				Eliminar($id);
				
			}

		
	?>