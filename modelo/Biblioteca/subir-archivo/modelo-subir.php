<?php
		if(isset($_POST['consulta'])){
			$consulta = $_POST['consulta'];

			$db = new ConexionDB;
			$conexion = $db->retornar_conexion();
		
			$lista_resultados = array();
		
			$sql = "SELECT * FROM archivos a1, rutas r1, tipo_archivo ta1 ,palabras_claves p1,areas a2,biblioteca b1 WHERE a1.Id_ruta = r1.Id_rutas AND a1.Id_tipo_archivo = ta1.Id_tipo_Archivo AND a1.Id_palabra_clave = p1.Id_palabra_clave AND b1.ID_Archivo = a1.id_archivo AND a1.Area = a2.ID_Areas AND a1.area = 1;";
		
			$statement = $conexion->prepare($sql);
			$statement->execute();
		
			if (!$statement) {
				$tabla = "No se encontraron libros";
				// no se encontraron paises
			}
			else {
			
				// reviso el retorno
				while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
					$lista_resultados[] = $resultado;
				}
				
				$tabla = armar_Tabla($lista_resultados);
	
			}

			
		
			return $tabla;			
		}

		

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

			$carpeta_guardado = $_SERVER['DOCUMENT_ROOT']."/StorageArchivoHistorico/Biblioteca/";

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

    function Tipo_Archivo(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = 'SELECT * FROM tipo_cont_b';

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $formulario = '<p><select name="TipoCB" id="TPA" class="inputSelect">';

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

        $formulario = '<p><select name="CLN" id="" class="inputSelect">';

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

	function buscar_libro(){
		$db = new ConexionDB;
		$conexion = $db->retornar_conexion();
	
		$lista_resultados = array();
	
		$sql = "SELECT * FROM archivos a1, rutas r1, tipo_archivo ta1 ,palabras_claves p1,areas a2 WHERE a1.Id_ruta = r1.Id_rutas AND a1.Id_tipo_archivo = ta1.Id_tipo_Archivo AND a1.Id_palabra_clave = p1.Id_palabra_clave AND a1.Area = a2.ID_Areas AND a1.area = 1 ";
	
		$statement = $conexion->prepare($sql);
		$statement->execute();
	
		while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
			$lista_resultados[] = $resultado;
		}
		
		$tabla = armar_Tabla($lista_resultados);
	
		return $tabla;
	}
?>