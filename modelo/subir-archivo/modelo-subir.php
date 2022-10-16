<?php

	function guardar($POST){
    $Titulo = $POST['titulo_biblioteca'];
    $Autor = $POST['autor'];
    $Materia = $POST['materia'];
    $resumen = $POST['sipn'];

    $Area = $POST['area'];

     $id_ruta = 0;
     $tipo_A = 1;

    $tpd = $POST['TPA'];
    $coleccion = $POST['CLN'];

     if (isset($POST['julio'])) {
         $checks = $POST['julio'];
     } else{
         $checks = false;
     }

     if (isset($POST['palabraNueva'])) {
        
         $Npalabra = $POST['palabraNueva'];
         $palabra_c = insertar_palabraC($Npalabra);
         echo $palabra_c;
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

         $id_ruta = 4;

         $carpeta_guardado = $_SERVER['DOCUMENT_ROOT']."/StorageArchivoHistorico/Biblioteca/Imagenes/";

         move_uploaded_file($_FILES['TP']['tmp_name'],$carpeta_guardado.$nArchivo_tapa);
         move_uploaded_file($_FILES['Arch']['tmp_name'],$carpeta_guardado.$nArchivo);



         $jose = rand(1,10000);

         insertar_datos_L_B($id_ruta,$tipo_A,$palabra_c,$imagenes,$Titulo,$Area,$Autor,$Materia,$tpd,$coleccion,$jose,$resumen);

	}}


    function buscar_ultimo_id(){
         $db = new ConexionDB;
         $conexion = $db->retornar_conexion();
         $sql = "SELECT Id_archivo FROM archivos ORDER by id_archivo DESC LIMIT 1;";
         $statement = $conexion->prepare($sql);
         $statement->execute();
         $Select = "";

         while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
             $Select = $fila['Id_archivo'];
         }
         $statement = $db->cerrar_conexion($conexion);
         return $Select;
    }

     function buscar_ultimo_id_p(){
         $db = new ConexionDB;
         $conexion = $db->retornar_conexion();
         $sql = "SELECT Id_palabra_clave FROM palabras_claves ORDER by Id_palabra_clave DESC LIMIT 1;";
         $statement = $conexion->prepare($sql);
         $statement->execute();
         $Select = "";

         while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
             $Select = $fila['Id_palabra_clave'];
         }
         $statement = $db->cerrar_conexion($conexion);
         return $Select;
     }

     function insertar_datos_L_B($id_ruta_arg,$tipo_A_arg,$id_pa,$lista,$titulo,$arg_area,$autor,$materia,$tpa,$col,$num,$res){
         $db = new ConexionDB;
         $conexion = $db->retornar_conexion();

         foreach($lista as $key){
         $sql = "INSERT INTO archivos (Id_ruta,Id_tipo_archivo,Id_palabra_clave,Nombre_Archivo,Titulo,Relacion,Area) VALUE('$id_ruta_arg','$tipo_A_arg','$id_pa','$key','$titulo','$num','$arg_area');";
         $statement = $conexion->prepare($sql);
         $statement->execute();
         }
    
        
         $ultimoId = buscar_ultimo_id();
         $sql = "INSERT INTO biblioteca(ID_Archivo, Titulo_libro, Autor, Materia, Tipo, sinopsis, ID_coleccion) VALUES ('$ultimoId','$titulo','$autor','$materia','$tpa','$res','$col');";

         $statement = $conexion->prepare($sql);
         $statement->execute();
    
         $statement = $db->cerrar_conexion($conexion);
         header("Location: index.php");
     }

     function insertar_palabraC($palabra){
         $db = new ConexionDB;
         $conexion = $db->retornar_conexion();
         $sql = "INSERT INTO `palabras_claves`(`palabra_clave`) VALUES ('$palabra');";
         echo $sql;
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

        return $formulario;
    }

    function Palabras_L(){
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

        return $formulario;
    }

    function Tipo_Archivo(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = 'SELECT * FROM tipo_cont_b';

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $formulario = '<p><label>Tipo de documento: </label><select name="TPA" id="TPA">';

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

    function formar_Formulario(){
        $omar ="<div id='sas'>\n
        <p><label>Titulo: </label><input type='text' name='titulo_biblioteca'></p>\n
        <p><label>Autor: </label><input type='text' name='autor'></p>\n
        <p><label>Materia: </label><input type='text' name='materia'></p>\n
        <p><label>Palabra clave: </label></p><p id='pala' >";

        $omar.= Palabras_claves();
        $omar.= "</p><p><label>Nueva palabra Clave: </label><input type='checkbox' name='' id='plc'>
        </p>";
        $omar.= Tipo_Archivo();

        $omar.= Coleccion();

        $omar.= "
        <p><label>Archivo: </label><input type='file' name='Arch' id='arch'></p><div id=omar>\n
        <p><label>Tapa: </label><input type='file' id='tapa' name='TP' ></p>\n
        <p><label>Sinopsis: </label></p></div>\n
        <p><textarea name='sipn' id='' cols='30' rows='10'></textarea></p>
        <p><input type='submit' name='saso'></p>\n
        </div>";

        return $omar;
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