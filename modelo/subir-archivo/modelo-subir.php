<?php

	function guardar($POST){
		$Titulo = $POST['titulo_biblioteca'];
		$Autor = $POST['autor'];
		$Materia = $POST['materia'];
		$resumen = $POST['sipn'];

		$Area = $POST['area'];

		$id_ruta = 0;
		$tipo_A = 1;

		$tipo_cont_b = $POST['TipoCB'];
		$coleccion = $POST['CLN'];

		if (isset($POST['julio'])) {
			$checks = $POST['julio'];
		}else{
			$checks = false;
		}

		if (isset($POST['palabraNueva'])) {
			
			$Npalabra = $POST['palabraNueva'];
			$palabra_c = insertar_palabraC($Npalabra);
		}else{
			$palabra_c = $POST['PLC'];
		}

		 if($Area == 1){

			$nArchivo = $_FILES['Arch']['name'];
			$tipo_Arch =  $_FILES['TP']['type'];
			$imagenes = array();

			$nArchivo_tapa = $_FILES['TP']['name'];

			array_push($imagenes,$nArchivo);
			array_push($imagenes,$nArchivo_tapa);

			$tipo_A = 5;

			$id_ruta = 1;

			$carpeta_guardado = $_SERVER['DOCUMENT_ROOT']."/StorageArchivoHistorico/Biblioteca/Imagenes/";

			move_uploaded_file($_FILES['TP']['tmp_name'],$carpeta_guardado.$nArchivo_tapa);
			move_uploaded_file($_FILES['Arch']['tmp_name'],$carpeta_guardado.$nArchivo);



			$relacion = rand(1,1000);
			 
			$datos_libro=[
				"ruta" => $id_ruta,
				"tipo_archivo" => $tipo_A,
				"palabraClave" => $palabra_c,
				"imagenes" => $imagenes,
				"titulo" => $Titulo,
				"area" => $Area,
				"autor" => $Autor,
				"materia" => $Materia,
				"tipoDeContenido" => $tipo_cont_b,
				"coleccion" => $coleccion,
				"relacion" => $relacion,
				"resumen" => $resumen,
			];

			insertar_datos_L_B($datos_libro);

		}
	}

    function insertar_datos_L_B($datosLibros){
		
		$id_ruta_arg = $datosLibros['ruta'];
		$tipo_A_arg = $datosLibros['tipo_archivo'];
		$id_pa = $datosLibros['palabraClave'];
		$titulo = $datosLibros['titulo'];
		$num = $datosLibros['relacion'];
		$arg_area = $datosLibros['area'];
		$lista = $datosLibros['imagenes'];
		$col = $datosLibros['coleccion'];
		$res = $datosLibros['resumen'];
		$materia = $datosLibros['materia'];
		$autor = $datosLibros['autor'];
		$tpcB = $datosLibros['tipoDeContenido'];
		
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        foreach($lista as $key){
			$sql = "INSERT INTO archivos (Id_ruta,Id_tipo_archivo,Id_palabra_clave,Nombre_Archivo,Titulo,Relacion,Area) VALUE(?,?,?,?,?,?,?);";
			$statement = $conexion->prepare($sql);
			try{
				$statement->bindParam(1,$id_ruta_arg,PDO::PARAM_STR);
				$statement->bindParam(2,$tipo_A_arg,PDO::PARAM_STR);
				$statement->bindParam(3,$id_pa,PDO::PARAM_STR);
				$statement->bindParam(4,$key,PDO::PARAM_STR);
				$statement->bindParam(5,$titulo,PDO::PARAM_STR);
				$statement->bindParam(6,$num,PDO::PARAM_INT);
				$statement->bindParam(7,$arg_area,PDO::PARAM_STR);
				$statement->execute();
			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
        }
    
        
        $ultimoId = $conexion->lastInsertId();
        $sql = "INSERT INTO biblioteca(ID_Archivo, Titulo_libro, Autor, Materia, Tipo, sinopsis, ID_coleccion) VALUES ('$ultimoId','$titulo','$autor','$materia','$tpcB','$res','$col');";

        $statement = $conexion->prepare($sql);
        $statement->execute();
    
        $statement = $db->cerrar_conexion($conexion);
    }

    function insertar_palabraC($palabra){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
        $sql = "INSERT INTO `palabras_claves`(`palabra_clave`) VALUES ('$palabra');";
		
        $statement = $conexion->prepare($sql);
        $statement->execute();

        
        $ultimoId = buscar_ultimo_id_p();

        $statement = $db->cerrar_conexion($conexion);

        return $ultimoId;
    }



    function Palabras_claves(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = 'SELECT * FROM palabras_claves';

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $formulario = '<select name="PLC" id="palabra">';
        $formulario.='<option value="0">Elige la palabra clave</option>';

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $formulario.='<option value="'.$fila['Id_palabra_clave'].'">'.$fila['palabra_clave'].'</option>';
        }
        $formulario.= '</select>';

        $statement = $db->cerrar_conexion($conexion);

        echo $formulario;
    }

    function Tipo_Archivo(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = 'SELECT * FROM tipo_cont_b';

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $formulario = '<p><label>Tipo de documento: </label><select name="TipoCB" id="TPA">';

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $formulario.='<option value="'.$fila['ID_tipo_cont_b'].'">'.$fila['Descripcion'].'</option>';
        }
        $formulario.= '</select>';

        $formulario.="</p>";

        $statement = $db->cerrar_conexion($conexion);

        echo $formulario;
    }

    function Coleccion(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = 'SELECT * FROM coleccion';

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $formulario = '<p><label>Coleccion: </label><select name="CLN" id="">';

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $formulario.='<option value="'.$fila['ID_coleccion'].'">'.$fila['Tipo_coleccion'].'</option>';
        }
        $formulario.= '</select>';

        $formulario.="</p>";

        $statement = $db->cerrar_conexion($conexion);

        echo $formulario;
    }

    function buscar_areas(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = 'SELECT * FROM areas';

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $formulario = '<p><label>Area: </label><select name="area" id="opcion1">';
        $formulario.='<option value="0">Elige el Area</option>';

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $formulario.='<option value="'.$fila['ID_Areas'].'">'.$fila['area'].'</option>';
        }
        $formulario.= '</select>';

        $formulario.="</p>";

        $statement = $db->cerrar_conexion($conexion);

        return $formulario;
    }
?>