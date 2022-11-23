<?php 

function buscar($buscar){
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $lista_resultados = array();

    $sql = "SELECT a.Nombre_Archivo,a.Titulo,a.Relacion,a.id_archivo,
    r.rutas,
    plc.palabra_clave,
    tpa.tipo
    FROM archivos a
    LEFT JOIN rutas r ON a.Id_ruta = r.Id_rutas
    LEFT JOIN palabras_claves plc ON a.Id_palabra_clave = plc.Id_palabra_clave
    LEFT JOIN tipo_archivo tpa ON a.Id_tipo_archivo = tpa.Id_tipo_Archivo
    WHERE a.Titulo LIKE '%$buscar%' 
    OR plc.palabra_clave LIKE '%$buscar%';";

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
            $des = detalle_foto($result['id_archivo']);
            $img= '
            <a href="'.$result['rutas'].$result['Nombre_Archivo'].'" class="contenedor-libro">
                <p class="contenedor-titulo">'.$result['Titulo'].'</p>
                <img src="'.$result['rutas'].$result['Nombre_Archivo'].'" alt="tapa" class="img">
                <div class="contenido_img">
                    <div class="cont-img" >
                        <p>Fuente: '.@$des['fuente'].'</p>
                        <p>Fecha: '.@$des['fecha'].'</p>
                        <p class="fi" >Tipo: '.$result['tipo'].'</p>
                    </div>
                        
                    </div>
                    <p class="contenedor-descripcion">'.@$des['Descripcion'].'</p>
                </a>';
            array_push($listadeCosas,$img);

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

    function detalle_foto($id_libro){
        $foto = array();
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $lista_resultados = array();

        $sql = "SELECT * FROM `fotografia` WHERE Id_fotografia = '$id_libro';";

        $statement = $conexion->prepare($sql);
        $statement->execute();

        while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
            return $resultado;
        }
    }

    function detalle_libro($id_libro){
        $foto = array();
        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $lista_resultados = array();

        $sql = "SELECT * FROM `biblioteca` WHERE ID_Archivo = $id_libro;";

        $statement = $conexion->prepare($sql);
        $statement->execute();

        while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
            return $resultado;
        }
    }
?>