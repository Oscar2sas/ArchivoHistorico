<?php 

function buscar($buscar){
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $lista_resultados = array();

    $sql = "SELECT * FROM archivos a1, rutas r1, tipo_archivo ta1 ,palabras_claves p1,areas a2 WHERE a1.Id_ruta = r1.Id_rutas AND a1.Id_tipo_archivo = ta1.Id_tipo_Archivo AND a1.Id_palabra_clave = p1.Id_palabra_clave AND a1.Area = a2.ID_Areas AND p1.palabra_clave = '$buscar'";

    $statement = $conexion->prepare($sql);
    $statement->execute();

    while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
        $lista_resultados[] = $resultado;
    }
    
    $tabla = armar_Tabla($lista_resultados);

    return $tabla;
}

function armar_Tabla($lista){
    $listadeCosas = array();
    $relacion = 0;
    foreach($lista as $result){

        if ($result['tipo'] == 'Expediente') {
            $tabla = '<table>
            <tr>
            <td class="titulo"><a href="http:'.$result['rutas'].$result['Nombre_Archivo'].'">'.$result['Titulo'].'</a>
            </td>
            <td rowspan="2" class="img"> <img src="../../img/imagen_pdf.jpg" alt="indice" width="10%">
            </td>
            </tr>
            <tr>
            <td>
            </td>
            </tr>
            </table>';

            array_push($listadeCosas,$tabla);

        }elseif ($result['tipo'] == 'Imagenes') {
            $Detalles = detalle_fotografia($result['id_archivo']);
            $tabla = '
            <div class="contenedor-libro">

                    <p class="contenedor-titulo"><a href="'.$result['rutas'].$result['Nombre_Archivo'].'" class="titulo_libro">'.$result['Titulo'].'</a></p>

                    <div class="contenedor-img-libro">
                        <a href="http:'.$result['rutas'].$result['Nombre_Archivo'].'"><img src="'.$result['rutas'].$result['Nombre_Archivo'].'" alt="tapa" class="img-libro"></a>
                    </div>

                    <div class="contenedor-autor-materia">
                        <p>Fuente: '.$Detalles['fuente'].'</p>
                        <p style="border-left:solid 1px rgb(199, 199, 199); margin:10px; ">Materia: '.$Detalles['fecha'].'</p>
                    </div>

                    <p class="sinopsis">'.$Detalles['Descripcion'].'</p>
                </div>';
            array_push($listadeCosas,$tabla);

        }elseif ($result['tipo'] == 'Libro') {
            if($relacion != $result['Relacion']){
                $libro = armar_libros($result['Relacion']);
                $detalle_libro = detalle_libro($libro[1]['id_archivo']);
                $tabla = '
                <a href="'.$libro[0]['rutas'].$libro[0]['Nombre_Archivo'].'" class="contenedor-libro">
                <p class="contenedor-titulo">'.$libro[0]['Titulo'].'</p>
                <div class="contenido">
                    <div class="cont" >
                        <p>Autor: '.$detalle_libro['Autor'].'</p>
                        <p>Materia: '.$detalle_libro['Materia'].'</p>
                        <p >Tipo: Libro</p>
                    </div>
                    <img src="'.$libro[1]['rutas'].$libro[1]['Nombre_Archivo'].'" alt="tapa" class="img-libro">
                </div>
                <p class="contenedor-descripcion">'.$detalle_libro['sinopsis'].'</p>
            </a>';
                $relacion = $result['Relacion'];
                array_push($listadeCosas,$tabla);
            }

        }
    }
    return $listadeCosas;

}

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