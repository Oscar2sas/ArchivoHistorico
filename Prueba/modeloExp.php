<?php  include('conexion.php');

$decada = $_POST['Decada'];
$pCla = $_POST['palabraCla'];
$nArchivo = $_FILES['Arch']['name'];
$tipo_Arch = $_POST['tipo_arch'];
$ruta = $_POST['ruta'];

Guardar_Archivo_en_carpeta($ruta,$tipo_Arch,$pCla,$nArchivo,$decada);

function Guardar_Archivo_en_carpeta($ruta,$tipo_Arch,$pCla,$nArchivo,$decada){

    $Ruta = buscar_ruta($ruta);
    $carpeta_guardado = $_SERVER['DOCUMENT_ROOT'].$Ruta;

    move_uploaded_file($_FILES['Arch']['tmp_name'],$carpeta_guardado.$nArchivo);
    echo $_FILES['Arch']['tmp_name'],$carpeta_guardado.$nArchivo;

    insertarDatos($ruta,$tipo_Arch,$pCla,$nArchivo,$decada);
}



function buscar_ruta($ruta){
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    $sql = "SELECT * FROM rutas WHERE Id_rutas= $ruta ";
    $statement = $conexion->prepare($sql);
    $statement->execute();
    $Select = "";

    while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
        $Select = $fila['rutas'];
    }

    return $Select;
}

function insertarDatos($ruta,$tipo_Arch,$pCla,$nArchivo,$decada){
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();
    $sql = "INSERT INTO archivos (Id_ruta,Id_tipo_archivo,Id_palabra_clave,Nombre_Archivo) VALUE('$ruta','$tipo_Arch','$pCla','$nArchivo');";
    echo $sql;
    $statement = $conexion->prepare($sql);
    $statement->execute();

    
    $ultimoId = buscar_ultimo_id();
    $sql = "INSERT INTO expedientes_judiciales (Decada,Id_archivo) VALUE($decada,$ultimoId);";
    echo $sql;
    $statement = $conexion->prepare($sql);
    $statement->execute();

    $statement = $db->cerrar_conexion($conexion);
    header("Location: index.php");
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

    return $Select;
}
?>