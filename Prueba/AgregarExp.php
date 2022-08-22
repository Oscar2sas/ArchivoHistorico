<?php     include('conexion.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prueva</title>
    <style>
        table{
            margin: auto;
            width:450px;
            border:2px dotted #ff0000;
        }
    </style>
</head>
<body>
    <form action="modeloExp.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <label>Decada:</label>
                </td>
                <td>
                    <input type="text" name="Decada" id="">
                </td>
            </tr>
            <tr>
            <td>
                    <label>Palabra Clave:</label>
                </td>
                <td>
                    <?php buscar_palabra_clave(); ?>
                </td>
            </tr>
            <tr>
            <td>
                    <label>Archivo:</label>
            </td>
            <td>
                    <input type="file" name="Arch" size="20">
            </td>
            </tr>
            <tr>
            <td>
                    <label>Tipo Archivo:</label>
            </td>
            <td>
                    <?php buscar_tipo_arch(); ?>
            </td>
            </tr>
            <tr>
                <td><label>Ruta</label></td>
                <td><?php buscar_rutas(); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" value="Guardar Archivo">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>

<?php


    function buscar_rutas(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
        $sql = "SELECT * FROM rutas";
        $statement = $conexion->prepare($sql);
        $statement->execute();
        $Select = "<select name='ruta'>";

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $Select.= "<option value=".$fila["Id_rutas"].">".$fila['rutas']."</option>";
        }

        $Select.= "</select>";

        echo $Select;
        
    }

    function buscar_tipo_arch(){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM tipo_archivo";
        $statement = $conexion->prepare($sql);
        $statement->execute();

        $Select = "<select name='tipo_arch'>";

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $Select.= "<option value=".$fila["Id_tipo_Archivo"].">".$fila['tipo']."</option>";
        }

        $Select.= "</select>";

        echo $Select;
    }

    function buscar_palabra_clave(){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM palabras_claves";
        $statement = $conexion->prepare($sql);
        $statement->execute();

        $Select = "<select name='palabraCla'>";

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $Select.= "<option value=".$fila["Id_palabra_clave"].">".$fila['palabra_clave']."</option>";
        }

        $Select.= "</select>";

        echo $Select;
    }
?>