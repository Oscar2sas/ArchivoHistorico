 <?php
 function insertar_palabraC($palabra){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();
        $sql = "INSERT INTO `palabras_claves`(`palabra_clave`) VALUES ('$palabra');";
		
        $statement = $conexion->prepare($sql);
        $statement->execute();

        
        $ultimoId = $conexion->lastInsertId();

        $statement = $db->cerrar_conexion($conexion);

        return $ultimoId;
    }



    function Palabras_claves(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = 'SELECT * FROM palabras_claves';

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $formulario = '<select name="PLC" id="palabra" class="inputSelect">';
        $formulario.='<option value="0">Elige la palabra clave</option>';

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $formulario.='<option value="'.$fila['Id_palabra_clave'].'">'.$fila['palabra_clave'].'</option>';
        }
        $formulario.= '</select>';

        $statement = $db->cerrar_conexion($conexion);

        echo $formulario;
    }
?>