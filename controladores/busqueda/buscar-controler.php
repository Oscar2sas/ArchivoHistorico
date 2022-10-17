<?php 
	$carpeta_trabajo="";
	$seccion_trabajo="/controladores";

	if (strpos($_SERVER["PHP_SELF"], $seccion_trabajo) >1 ) {
		$carpeta_trabajo=substr($_SERVER["PHP_SELF"],1, strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) -1);
	}
	$absolute_include = str_repeat("../",substr_count($_SERVER["PHP_SELF"] , "/") -1).$carpeta_trabajo;

	if (!empty($carpeta_trabajo)) {
		$absolute_include = $absolute_include."/"; 
		$carpeta_trabajo = "/".$carpeta_trabajo; 
		
	}
	
	$accion = '';
	
	$aBuscar = $_POST['busqueda'];
	
	include($absolute_include."/conexion/conexion.php");
	include($absolute_include."modelo/busqueda/busqueda-modelo.php");
	
	if($accion == ''){
        $resultado_de_busqueda = buscar($aBuscar);
		include($absolute_include."vista/busqueda/busqueda-vista.php");
	}
	
	
	
	$resultado_de_busqueda = buscar($aBuscar);
	
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
                $tabla = '<table>
                <tr>
                <td class="titulo"><a href="http:'.$result['rutas'].$result['Nombre_Archivo'].'">'.$result['Titulo'].'</a>
                </td>
                <td rowspan="2" class="img"> <img src="'.$result['rutas'].$result['Nombre_Archivo'].'" alt="indice" width="20%">
                </td>
                </tr>
                <tr>
                <td>'.$Detalles['Descripcion'].'
                </td>
                </tr>
                </table>';
                array_push($listadeCosas,$tabla);

            }elseif ($result['tipo'] == 'Libro') {
                if($relacion != $result['Relacion']){
                    $libro = armar_libros($result['Relacion']);
                    $detalle_libro = detalle_libro($libro[1]['id_archivo']);
                    $tabla = '<table>
                    <tr>
                    <td class="titulo" colspan="2"><a href="http:'.$libro[0]['rutas'].$libro[0]['Nombre_Archivo'].'">'.$libro[0]['Titulo'].'</a>
                    </td>
                    <td rowspan="3" class="img"> <a href="http:'.$libro[1]['rutas'].$libro[1]['Nombre_Archivo'].'"><img src="'.$libro[1]['rutas'].$libro[1]['Nombre_Archivo'].'" alt="indice" width="10%"></a>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="2">'.$detalle_libro['sinopsis'].'
                    </td>
                    </tr>
                    <tr>
                    <td>Autor: '.$detalle_libro['Autor'].'
                    </td>
                    <td>Materia: '.$detalle_libro['Materia'].'
                    </td>
                    </tr>
                    </table>';
                    $relacion = $result['Relacion'];
                    array_push($listadeCosas,$tabla);
                }

            }
        }
        return $listadeCosas;

    }
?>