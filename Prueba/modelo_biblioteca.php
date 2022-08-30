<?php  include('conexion.php');
   $Titulo = $_POST['titulo_biblioteca'];
   $Autor = $_POST['autor'];
   $Materia = $_POST['materia'];
   $resumen = $_POST['sipn'];

   $Area = $_POST['area'];

    $id_ruta = 0;
    $tipo_A = 1;

   $tpd = $_POST['TPA'];
   $coleccion = $_POST['CLN'];

    if (isset($_POST['julio'])) {
        $checks = $_POST['julio'];
    } else{
        $checks = false;
    }

    if (isset($_POST['palabraNueva'])) {
        
        $Npalabra = $_POST['palabraNueva'];
        $palabra_c = insertar_palabraC($Npalabra);
        echo $palabra_c;
    }else{
        $palabra_c = $_POST['PLC'];
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

        $carpeta_guardado = $_SERVER['DOCUMENT_ROOT']."/archivoProvincial/Biblioteca/Imagenes/";

        move_uploaded_file($_FILES['TP']['tmp_name'],$carpeta_guardado.$nArchivo_tapa);
        move_uploaded_file($_FILES['Arch']['tmp_name'],$carpeta_guardado.$nArchivo);



        $jose = rand(1,10000);

        insertar_datos_L_B($id_ruta,$tipo_A,$palabra_c,$imagenes,$Titulo,$Area,$Autor,$Materia,$tpd,$coleccion,$jose,$resumen);

    }


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


?>