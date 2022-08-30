<?php 
    function detalle_fotografia($id_a_buscar){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $lista_resultados = array();

        $sql = "SELECT * FROM fotografia WHERE Id_archivo = $id_a_buscar ;";

        $statement = $conexion->prepare($sql);
        $statement->execute();

        while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
            return $resultado;
        }
    }

    function armar_libros($relacion){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $lista_resultados = array();

        $sql = "SELECT * FROM archivos a1,rutas r1 WHERE a1.Id_ruta = r1.Id_rutas AND a1.Relacion = $relacion;";

        $statement = $conexion->prepare($sql);
        $statement->execute();

        while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
            $lista_resultados[] = $resultado;
        }

        return $lista_resultados;
    }

    function detalle_libro($id_libro){
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $lista_resultados = array();

        $sql = "SELECT * FROM biblioteca WHERE ID_Archivo = $id_libro;";

        $statement = $conexion->prepare($sql);
        $statement->execute();

        while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
            return $resultado;
        }
    }
?>