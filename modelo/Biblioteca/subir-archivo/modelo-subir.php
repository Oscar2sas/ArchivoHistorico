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

		$cdescripcion_log = 'Subio un libro: '.$_SESSION['nombreUsuario'].' con titulo: '.$titulo;
    	insertar_log($cdescripcion_log);
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

	function buscar_un_libro($id_archivo){
		$db = new ConexionDB;
		$conexion = $db->retornar_conexion();
	
		$lista_resultados = array();
	
		$sql = "SELECT a.id_archivo,a.Nombre_Archivo,a.Titulo,a.Relacion, a.Id_tipo_archivo,
            r.rutas, 
            plc.palabra_clave, 
            tpa.tipo, 
            b.Autor,b.Materia,b.sinopsis, 
            c.Tipo_coleccion, 
            tcb.Descripcion AS 'Tipo_Contenido' 
            FROM archivos a 
            LEFT JOIN rutas r ON a.Id_ruta = r.Id_rutas 
            LEFT JOIN palabras_claves plc ON a.Id_palabra_clave = plc.Id_palabra_clave 
            LEFT JOIN tipo_archivo tpa ON a.Id_tipo_archivo = tpa.Id_tipo_Archivo 
            LEFT JOIN biblioteca b ON a.id_archivo = b.ID_Archivo 
            LEFT JOIN coleccion c ON b.ID_coleccion = c.ID_coleccion 
            LEFT JOIN tipo_cont_b tcb ON b.Tipo = tcb.ID_tipo_cont_b
            WHERE a.id_archivo = $id_archivo;";
	
		$statement = $conexion->prepare($sql);
		$statement->execute();
	
		while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
			return $resultado;
		}
	
	}

		function buscar_un_libro_d($id_archivo){
		$db = new ConexionDB;
		$conexion = $db->retornar_conexion();
	
		$lista_resultados = array();
	
		$sql = "SELECT a.id_archivo,a.Nombre_Archivo,a.Titulo,a.Relacion, a.Id_tipo_archivo,
            r.rutas, 
            plc.palabra_clave, 
            tpa.tipo, 
            b.Autor,b.Materia,b.sinopsis, 
            c.Tipo_coleccion, 
            tcb.Descripcion AS 'Tipo_Contenido' 
            FROM archivos a 
            LEFT JOIN rutas r ON a.Id_ruta = r.Id_rutas 
            LEFT JOIN palabras_claves plc ON a.Id_palabra_clave = plc.Id_palabra_clave 
            LEFT JOIN tipo_archivo tpa ON a.Id_tipo_archivo = tpa.Id_tipo_Archivo 
            LEFT JOIN biblioteca b ON a.id_archivo = b.ID_Archivo 
            LEFT JOIN coleccion c ON b.ID_coleccion = c.ID_coleccion 
            LEFT JOIN tipo_cont_b tcb ON b.Tipo = tcb.ID_tipo_cont_b
            WHERE a.id_archivo = $id_archivo;";
	
		$statement = $conexion->prepare($sql);
		$statement->execute();
	
		while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
			$lista_resultados[] = $resultado;
			
		}

		$tabla = armar_Tabla($lista_resultados);

		return $tabla;
	
	}

	function Modificar($POST){
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


			$nArchivo = $_FILES['Arch']['name'];
			$tipo_Arch =  $_FILES['TP']['type'];
			$nArchivo_tapa = $_FILES['TP']['name'];
			$imagenes = array();

			if(!empty($nArchivo)){
				array_push($imagenes,$nArchivo);
			}
			else{
				array_push($imagenes,$nArchivo);
			}

			if(!empty($nArchivo_tapa)){
				array_push($imagenes,$nArchivo_tapa);
			}else{
				array_push($imagenes,$nArchivo_tapa);
			}

			$tipo_A = 5;

			$id_ruta = 1;

			$carpeta_guardado = $_SERVER['DOCUMENT_ROOT']."/StorageArchivoHistorico/Biblioteca/";

			move_uploaded_file($_FILES['TP']['tmp_name'],$carpeta_guardado.$nArchivo_tapa);
			move_uploaded_file($_FILES['Arch']['tmp_name'],$carpeta_guardado.$nArchivo);



			$relacion = $POST['rela'];
			$id_archivo = $POST['id_a'];
			 
			$datos_libro=[
				"id_Arc" => $id_archivo,
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

			modificar_datos_L_B($datos_libro);

	}

    function modificar_datos_L_B($datosLibros){

		

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

		$ultimoId = $datosLibros['id_Arc'];
		
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();


			$ronda = 0;
        foreach($lista as $key){
			if($key != ""){
			$ronda ++;
			if($ronda == 2){
				$sql = "UPDATE `archivos` SET `Id_ruta`=?,`Id_tipo_archivo`=?,`Id_palabra_clave`=?,`Nombre_Archivo`=?,`Titulo`=?,`Relacion`=?,`Area`=? WHERE id_archivo = $ultimoId ;";
			}else{
				$sql = "UPDATE `archivos` SET `Id_ruta`=?,`Id_tipo_archivo`=?,`Id_palabra_clave`=?,`Nombre_Archivo`=?,`Titulo`=?,`Relacion`=?,`Area`=? WHERE id_archivo = $ultimoId-1 ;";
			}
			
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
			
        }else{
			$ronda ++;
			$sql = "UPDATE `archivos` SET `Id_ruta`=?,`Id_tipo_archivo`=?,`Id_palabra_clave`=?,`Titulo`=?,`Relacion`=?,`Area`=? WHERE id_archivo = $ultimoId ;";
			$statement = $conexion->prepare($sql);
			try{
				$statement->bindParam(1,$id_ruta_arg,PDO::PARAM_STR);
				$statement->bindParam(2,$tipo_A_arg,PDO::PARAM_STR);
				$statement->bindParam(3,$id_pa,PDO::PARAM_STR);
				$statement->bindParam(4,$titulo,PDO::PARAM_STR);
				$statement->bindParam(5,$num,PDO::PARAM_INT);
				$statement->bindParam(6,$arg_area,PDO::PARAM_STR);
				$statement->execute();
			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}
		}

		$sql = "UPDATE `biblioteca` SET `Titulo_libro`='$titulo',`Autor`='$autor',`Materia`='$materia',`Tipo`='$tpcB',`sinopsis`='$res',`ID_coleccion`='$col' WHERE `ID_Archivo`='$ultimoId' ";

        $statement = $conexion->prepare($sql);
        $statement->execute();
    
        $statement = $db->cerrar_conexion($conexion);

		$cdescripcion_log = 'Modifico un libro: '.$_SESSION['nombreUsuario'].' con titulo: '.$titulo;
    	insertar_log($cdescripcion_log);

		header('Location: controler-sub.php');
    }

	function Eliminar($id){
		$db = new ConexionDB;
        $conexion = $db->retornar_conexion();

		$sql = "DELETE FROM `archivos` WHERE `id_archivo` = $id";

        $statement = $conexion->prepare($sql);
        $statement->execute();

		$sql = "DELETE FROM `archivos` WHERE `id_archivo` = $id-1";

        $statement = $conexion->prepare($sql);
        $statement->execute();

		$sql = "DELETE FROM `biblioteca` WHERE `ID_Archivo` = $id";

        $statement = $conexion->prepare($sql);
        $statement->execute();
    
        $statement = $db->cerrar_conexion($conexion);

		$cdescripcion_log = 'Elimino un libro: '.$_SESSION['nombreUsuario'];
    	insertar_log($cdescripcion_log);
		header('Location: controler-sub.php');
	}

?>