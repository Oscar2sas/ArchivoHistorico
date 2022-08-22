<?php 
    include('conexion.php');
    $aBuscar = $_POST['busqueda'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $aBuscar; ?></title>
    <link rel="stylesheet" href="estilos/cosas.css">
</head>
<body>
    <form action="" method="post">
        <div class="buscador">
        <input type="text" name="busqueda" id="" value="<?php echo $aBuscar; ?>">
        <input type="submit" value="Buscar">
        </div>
    </form>
    <?php 
        $sasa = buscar($aBuscar);
        echo $sasa;
    ?>
</body>
</html>
<?php 

    function buscar($buscar){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $palabras = buscar_palabras_C();

        $sql = "SELECT Id_palabra_clave FROM palabras_claves WHERE palabra_clave = '$buscar';";

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $Select = "";

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $Select = $fila['Id_palabra_clave'];
        }

       $arch =  buscar_Arc($Select);
       return $arch;        
    }

    function buscar_palabras_C(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM palabras_claves";

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $Select = [];

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $Select = $fila;
        }

       return $Select;        
    }

    function buscar_rutas(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM rutas";

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $Select = [];

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $Select = $fila;
        }

       return $Select;        
    }
 
    function buscar_Arc($Select){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM archivos where Id_palabra_clave = '$Select'";
        $statement = $conexion->prepare($sql);
        $statement->execute();

 
        $tabla = "<div>";

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {

            $Select = $fila['Id_ruta'];
            $id = $fila['id_archivo'];
            
            $rut = buscar_ruta_arc($Select);
            $desc = buscar_dec($id);

            if($fila['Id_ruta'] == 2){
                $tabla.= "<table><tr>";
                $tabla.= "<td class='titulo'><a href='".$rut.$fila['Nombre_Archivo']."'>".$fila['Titulo']."</a></td>";  
                $tabla.= "<td rowspan='2' class='img' ><img src='".$rut.$fila['Nombre_Archivo']."' alt='indice' class='img' ></td></tr>";
                $tabla.= "<tr>";
                $tabla.= "<td>$desc</td></tr>";
                $tabla.= "</table>";
            }
            else{
                $tabla.= "<table><tr>";
                $tabla.= "<td><a href='".$rut.$fila['Nombre_Archivo']."'>".$fila['Titulo']."</a></td>";  
                $tabla.= "</tr>";
                $tabla.= "</table>";
            }
            
        }

        $tabla .= "</div>";

        return $tabla;

    }

    function buscar_ruta_arc($Select){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT rutas FROM rutas where Id_rutas = '$Select'";
            $statement = $conexion->prepare($sql);
            $statement->execute();
            while($fila= $statement->fetch(PDO::FETCH_ASSOC)){
                $sas = $fila['rutas'];
            }
            return $sas;
    }

    function buscar_dec($Select){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT Descripcion FROM fotografia WHERE Id_archivo = '$Select';";
        $statement = $conexion->prepare($sql);
        $statement->execute();
        while($fila= $statement->fetch(PDO::FETCH_ASSOC)){
            $sas = $fila['Descripcion'];
        }
        
        return @$sas;
    }

?>