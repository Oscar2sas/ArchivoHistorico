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

        $statement->execute();
    
        $statement = $db->cerrar_conexion($conexion);
		header ("location:controler-svm.php");
    }

    function Coleccion(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = 'SELECT * FROM coleccion';

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $formulario = '<p><select name="CLN" id="" class="inputSelect">';

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $formulario.='<option value="'.$fila['ID_coleccion'].'">'.$fila['Tipo_coleccion'].'</option>';
        }
        $formulario.= '</select>';

        $formulario.="</p>";

        $statement = $db->cerrar_conexion($conexion);

        echo $formulario;
    }

    
?>