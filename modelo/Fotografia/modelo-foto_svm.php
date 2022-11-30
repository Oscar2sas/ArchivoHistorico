<?php

	function guardar($POST){
		$Titulo = $POST['titulo_Fotografia'];
		$resumen = $POST['descr'];
		$Fuente = $POST['Fuente'];
		$Fecha = $POST['Fecha'];
		$Area = 2;

		$id_ruta = 0;
		$tipo_A = 1;

		if (isset($POST['palabraNueva'])) {
			
			$Npalabra = $POST['palabraNueva'];
			$palabra_c = insertar_palabraC($Npalabra);
		}else{
			$palabra_c = $POST['PLC'];
		}

			$nArchivo = $_FILES['image']['name'];

			$tipo_A = 2;

			$id_ruta = 2;

			$carpeta_guardado = $_SERVER['DOCUMENT_ROOT']."/StorageArchivoHistorico/Fotografia/";

			move_uploaded_file($_FILES['image']['tmp_name'],$carpeta_guardado.$nArchivo);
			 
			$datos_fotos=[
				"ruta" => $id_ruta,
				"tipo_archivo" => $tipo_A,
				"palabraClave" => $palabra_c,
				"fuente" => $Fuente,
				"fecha" => $Fecha,
				"nArchivo" => $nArchivo,
				"titulo" => $Titulo,
				"resumen" => $resumen,
				"area" => $Area,
			];

			insertar_datos_Fotografia($datos_fotos);

		}
	

    function insertar_datos_Fotografia($datosFotos){
		
		$id_ruta_arg = $datosFotos['ruta'];
		$tipo_A_arg = $datosFotos['tipo_archivo'];
		$titulo = $datosFotos['titulo'];
		$palabra_c = $datosFotos['palabraClave'];
		$res = $datosFotos['resumen'];
		$Fecha = $datosFotos['fecha'];
		$Fuente = $datosFotos['fuente'];
		$nArchivo = $datosFotos['nArchivo'];
		$Area = $datosFotos['area'];
		$relacion = 0;
		
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

			$sql = "INSERT INTO archivos (Id_ruta,Id_tipo_archivo,Id_palabra_clave,Nombre_Archivo,Titulo,Relacion,Area) VALUE(?,?,?,?,?,?,?);";
			$statement = $conexion->prepare($sql);
			try{
				$statement->bindParam(1,$id_ruta_arg,PDO::PARAM_STR);
				$statement->bindParam(2,$tipo_A_arg,PDO::PARAM_STR);
				$statement->bindParam(3,$palabra_c,PDO::PARAM_STR);
				$statement->bindParam(4,$nArchivo,PDO::PARAM_STR);
				$statement->bindParam(5,$titulo,PDO::PARAM_STR);
				$statement->bindParam(6,$relacion,PDO::PARAM_INT);
				$statement->bindParam(7,$Area,PDO::PARAM_STR);
				$statement->execute();
			}catch(PDOException $ex){
				echo $ex->getMessage();
        	}
    
        
        $ultimoId = $conexion->lastInsertId();
        $sql = "INSERT INTO `fotografia`(`Id_archivo`, `Descripcion`, `fuente`, `fecha`) VALUES (?,?,?,?)";

        $statement = $conexion->prepare($sql);
		try{
			$statement->bindParam(1,$ultimoId,PDO::PARAM_INT);
			$statement->bindParam(2,$res,PDO::PARAM_STR);
			$statement->bindParam(3,$Fuente,PDO::PARAM_STR);
			$statement->bindParam(4,$Fecha,PDO::PARAM_STR);
			$statement->execute();
		}catch(PDOException $ex){
			echo $ex->getMessage();
		}
    
        $statement = $db->cerrar_conexion($conexion);
		header ("location:controler-svm.php");
    }

	function buscar_una_image($id_archivo){
		$db = new ConexionDB;
		$conexion = $db->retornar_conexion();
	
		$lista_resultados = array();
	
		$sql = "SELECT a.id_archivo,a.Nombre_Archivo,a.Titulo,a.Id_tipo_archivo,
            r.rutas, 
            plc.palabra_clave, 
            tpa.tipo,
            f.Descripcion,f.fuente,f.fecha
            FROM archivos a 
            LEFT JOIN rutas r ON a.Id_ruta = r.Id_rutas 
            LEFT JOIN palabras_claves plc ON a.Id_palabra_clave = plc.Id_palabra_clave 
            LEFT JOIN tipo_archivo tpa ON a.Id_tipo_archivo = tpa.Id_tipo_Archivo
            LEFT JOIN fotografia f ON a.id_archivo = f.Id_archivo
            WHERE a.id_archivo = $id_archivo;";
	
		$statement = $conexion->prepare($sql);
		$statement->execute();
	
		while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
			return $resultado;
		}
	
	}

		function buscar_una_image_d($id_archivo){
		$db = new ConexionDB;
		$conexion = $db->retornar_conexion();
	
		$lista_resultados = array();
	
		$sql = "SELECT a.id_archivo,a.Nombre_Archivo,a.Titulo,a.Id_tipo_archivo,
            r.rutas, 
            plc.palabra_clave, 
            tpa.tipo,
            f.Descripcion,f.fuente,f.fecha
            FROM archivos a 
            LEFT JOIN rutas r ON a.Id_ruta = r.Id_rutas 
            LEFT JOIN palabras_claves plc ON a.Id_palabra_clave = plc.Id_palabra_clave 
            LEFT JOIN tipo_archivo tpa ON a.Id_tipo_archivo = tpa.Id_tipo_Archivo
            LEFT JOIN fotografia f ON a.id_archivo = f.Id_archivo
            WHERE a.id_archivo = $id_archivo;";
	
		$statement = $conexion->prepare($sql);
		$statement->execute();
	
		while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
			$lista_resultados[] = $resultado;
			
		}

		$tabla = armar_Tabla($lista_resultados);

		return $tabla;
	
	}

		function Eliminar($id){
		$db = new ConexionDB;
        $conexion = $db->retornar_conexion();

		$sql = "DELETE FROM `archivos` WHERE `id_archivo` = $id";

        $statement = $conexion->prepare($sql);
        $statement->execute();

		$sql = "DELETE FROM `fotografia` WHERE `Id_archivo` = $id";

        $statement = $conexion->prepare($sql);
        $statement->execute();
    
        $statement = $db->cerrar_conexion($conexion);

		header('Location: controler-svm.php');
	}

	function modificar_img($POST){
		$Titulo = $POST['titulo_Fotografia'];
		$resumen = $POST['descr'];
		$Fuente = $POST['Fuente'];
		$Fecha = $POST['Fecha'];
		$id = $POST['id_a'];
		$Area = 2;

		$id_ruta = 0;
		$tipo_A = 1;

		if (isset($POST['palabraNueva'])) {
			
			$Npalabra = $POST['palabraNueva'];
			$palabra_c = insertar_palabraC($Npalabra);
		}else{
			$palabra_c = $POST['PLC'];
		}

			$nArchivo = $_FILES['image']['name'];

			$tipo_A = 2;

			$id_ruta = 2;

			$carpeta_guardado = $_SERVER['DOCUMENT_ROOT']."/StorageArchivoHistorico/Fotografia/";

			move_uploaded_file($_FILES['image']['tmp_name'],$carpeta_guardado.$nArchivo);
			 
			$datos_fotos=[
				"ruta" => $id_ruta,
				"tipo_archivo" => $tipo_A,
				"palabraClave" => $palabra_c,
				"fuente" => $Fuente,
				"fecha" => $Fecha,
				"nArchivo" => $nArchivo,
				"titulo" => $Titulo,
				"resumen" => $resumen,
				"area" => $Area,
				"id" => $id,
			];

			modificar_datos_Fotografia($datos_fotos);

		}
	

    function modificar_datos_Fotografia($datosFotos){
		$id_ruta_arg = $datosFotos['ruta'];
		$tipo_A_arg = $datosFotos['tipo_archivo'];
		$titulo = $datosFotos['titulo'];
		$palabra_c = $datosFotos['palabraClave'];
		$res = $datosFotos['resumen'];
		$Fecha = $datosFotos['fecha'];
		$Fuente = $datosFotos['fuente'];
		$nArchivo = $datosFotos['nArchivo'];
		$Area = $datosFotos['area'];
		$id = $datosFotos['id'];
		$relacion = 0;
		
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

		if (empty($nArchivo)) {
			$sql = "UPDATE `archivos` SET `Id_ruta`=?,`Id_tipo_archivo`=?,`Id_palabra_clave`=?,`Titulo`=?,`Relacion`=?,`Area`=? WHERE id_archivo = $id ;";
			$statement = $conexion->prepare($sql);
			try{
				$statement->bindParam(1,$id_ruta_arg,PDO::PARAM_STR);
				$statement->bindParam(2,$tipo_A_arg,PDO::PARAM_STR);
				$statement->bindParam(3,$palabra_c,PDO::PARAM_STR);
				$statement->bindParam(4,$titulo,PDO::PARAM_STR);
				$statement->bindParam(5,$relacion,PDO::PARAM_INT);
				$statement->bindParam(6,$Area,PDO::PARAM_STR);
				$statement->execute();
			}catch(PDOException $ex){
				echo $ex->getMessage();
        	}
		}else{
		
			$sql = "UPDATE `archivos` SET `Id_ruta`=?,`Id_tipo_archivo`=?,`Id_palabra_clave`=?,`Nombre_Archivo`=?,`Titulo`=?,`Relacion`=?,`Area`=? WHERE id_archivo = $id ;";
			$statement = $conexion->prepare($sql);
			try{
				$statement->bindParam(1,$id_ruta_arg,PDO::PARAM_STR);
				$statement->bindParam(2,$tipo_A_arg,PDO::PARAM_STR);
				$statement->bindParam(3,$palabra_c,PDO::PARAM_STR);
				$statement->bindParam(4,$nArchivo,PDO::PARAM_STR);
				$statement->bindParam(5,$titulo,PDO::PARAM_STR);
				$statement->bindParam(6,$relacion,PDO::PARAM_INT);
				$statement->bindParam(7,$Area,PDO::PARAM_STR);
				$statement->execute();
			}catch(PDOException $ex){
				echo $ex->getMessage();
        	}
		}
        
        $sql = "UPDATE `fotografia` SET `Id_archivo`=?,`Descripcion`=?,`fuente`=?,`fecha`=? WHERE Id_archivo = $id ; ";

        $statement = $conexion->prepare($sql);
		try{
			$statement->bindParam(1,$id,PDO::PARAM_INT);
			$statement->bindParam(2,$res,PDO::PARAM_STR);
			$statement->bindParam(3,$Fuente,PDO::PARAM_STR);
			$statement->bindParam(4,$Fecha,PDO::PARAM_STR);
			$statement->execute();
		}catch(PDOException $ex){
			echo $ex->getMessage();
		}
    
        $statement = $db->cerrar_conexion($conexion);
		header ("location:controler-svm.php");
    }

?>