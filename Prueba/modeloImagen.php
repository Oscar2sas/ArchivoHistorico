<?php  include('conexion.php');

    if(isset($_REQUEST['accion'])){

        $accion = $_REQUEST['accion'];

        if ($accion = 'biblioteca') {

            $alonso = formar_Formulario();
            echo json_encode($alonso);
            return;
        }

    }

    function Palabras_claves(){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = 'SELECT * FROM palabras_claves';

        $statement = $conexion->prepare($sql);
        $statement->execute();

        $formulario = '<p><label>Palabra clave: </label> <select name="PLC" id="">';
        $formulario.='<option value="0">Elige la palabra clave</option>';

        while ($fila= $statement->fetch(PDO::FETCH_ASSOC)) {
            $formulario.='<option value="'.$fila['Id_palabra_clave'].'">'.$fila['palabra_clave'].'</option>';
        }
        $formulario.= '</select>';

        $formulario.="</p>";

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

        return $formulario;
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

        return $formulario;
    }

    function formar_Formulario(){
        $omar ="<div id='sas'>\n
        <p><label>Titulo: </label><input type='text' name='titulo_biblioteca'></p>\n
        <p><label>Autor: </label><input type='text' name='autor'></p>\n
        <p><label>Materia: </label><input type='text' name='materia'></p>\n
        ";

        $omar.= Palabras_claves();

        $omar.= Tipo_Archivo();

        $omar.= Coleccion();

        $omar.= "<p><label>Archivo fisico: </label><input type='checkbox' name='julio' id='olas'></p>\n
        <p><label>Archivo: </label><input type='file' name='Arch' id='arch' disabled></p><div id=omar>\n
        <p><label>Tapa: </label><input type='file' id='tapa' name='TP' ></p>\n
        <p><label>Indice: </label><input type='file' id='indice' name='IN' ></p>\n
        <p><label>Contra Tapa: </label><input type='file' id='ct' name='CTP' ></p></div>\n
        <p><input type='submit'></p>\n
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