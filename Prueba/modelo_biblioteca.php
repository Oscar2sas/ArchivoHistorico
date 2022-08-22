<?php  include('conexion.php');
   $Titulo = $_POST['titulo_biblioteca'];
   $Autor = $_POST['autor'];
   $Materia = $_POST['materia'];

   $Area = $_POST['area'];

    $id_ruta = 0;
    $tipo_A = 1;

   $palabra_c = $_POST['PLC'];
   $tpd = $_POST['TPA'];
   $coleccion = $_POST['CLN'];

    if (isset($_POST['julio'])) {
        $checks = $_POST['julio'];
    } else{
        $checks = false;
    }

    if($Area == 1){
        
   if($checks == true){

        $nArchivo = $_FILES['Arch']['name'];
        $tipo_Arch =  $_FILES['Arch']['type'];

        $id_ruta = 3;

        if ($tipo_Arch == 'aplication/pdf') {
            $tipo_A = 5;
        }

        $carpeta_guardado = $_SERVER['DOCUMENT_ROOT']."/archivoProvincial/Biblioteca/";

        #move_uploaded_file($_FILES['Arch']['tmp_name'],$carpeta_guardado.$nArchivo);

        insertar_datos($id_ruta,$tipo_A,$palabra_c,$nArchivo,$Titulo,$Area,$Autor,$Materia,$tpd,$coleccion);

    }else{

        $tipo_Arch =  $_FILES['TP']['type'];
        $imagenes = array();

        $nArchivo_tapa = $_FILES['TP']['name'];
        $nArchivo_in = $_FILES['IN']['name'];
        $nArchivo_CTP = $_FILES['CTP']['name'];

        array_push($imagenes,$nArchivo_tapa);
        array_push($imagenes,$nArchivo_in);
        array_push($imagenes,$nArchivo_CTP);

        if ($tipo_Arch == 'imagen/jpg') {
            $tipo_A = 2;
        }

        $id_ruta = 4;

        $carpeta_guardado = $_SERVER['DOCUMENT_ROOT']."/archivoProvincial/Biblioteca/Imagenes/";

        // move_uploaded_file($_FILES['TP']['tmp_name'],$carpeta_guardado.$nArchivo_tapa);
        // move_uploaded_file($_FILES['IN']['tmp_name'],$carpeta_guardado.$nArchivo_in);
        // move_uploaded_file($_FILES['CTP']['tmp_name'],$carpeta_guardado.$nArchivo_CTP);


        $jose = rand(1,10000);

        insertar_datos_L_B($id_ruta,$tipo_A,$palabra_c,$imagenes,$Titulo,$Area,$Autor,$Materia,$tpd,$coleccion,$jose);



    }
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

    function insertar_datos($id_ruta_arg,$tipo_A_arg,$id_pa,$nArchivo,$titulo,$arg_area,$autor,$materia,$tpa,$col){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
        $sql = "INSERT INTO archivos (Id_ruta,Id_tipo_archivo,Id_palabra_clave,Nombre_Archivo,Titulo,Area) VALUE('$id_ruta_arg','$tipo_A_arg','$id_pa','$nArchivo','$titulo','$arg_area');";
        echo $sql;
        // $statement = $conexion->prepare($sql);
        // $statement->execute();
    
        
        $ultimoId = buscar_ultimo_id();
        $sql = "INSERT INTO biblioteca(ID_Archivo, Titulo_libro, Autor, Materia, Tipo, ID_coleccion) VALUES ('$ultimoId','$titulo','$autor','$materia','$tpa','$col');";
        echo $sql;

        // $statement = $conexion->prepare($sql);
        // $statement->execute();
    
        $statement = $db->cerrar_conexion($conexion);
        // header("Location: index.php");
    }

    function insertar_datos_L_B($id_ruta_arg,$tipo_A_arg,$id_pa,$lista,$titulo,$arg_area,$autor,$materia,$tpa,$col,$num){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        foreach($lista as $key){
        $sql = "INSERT INTO archivos (Id_ruta,Id_tipo_archivo,Id_palabra_clave,Nombre_Archivo,Titulo,Relacion,Area) VALUE('$id_ruta_arg','$tipo_A_arg','$id_pa','$key','$titulo','$num','$arg_area');";
        echo $sql;
        $statement = $conexion->prepare($sql);
        $statement->execute();
        }
    
        
        $ultimoId = buscar_ultimo_id();
        $sql = "INSERT INTO biblioteca(ID_Archivo, Titulo_libro, Autor, Materia, Tipo, ID_coleccion) VALUES ('$ultimoId','$titulo','$autor','$materia','$tpa','$col');";
        echo $sql;

        $statement = $conexion->prepare($sql);
        $statement->execute();
    
        $statement = $db->cerrar_conexion($conexion);
        // header("Location: index.php");
    }


?>