<?php 
		$carpeta_trabajo="";
		$seccion_trabajo="/modelo";

		if (strpos($_SERVER["PHP_SELF"], $seccion_trabajo) >1 ) {
			$carpeta_trabajo=substr($_SERVER["PHP_SELF"],1, strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) -1);
		}
		$absolute_include = str_repeat("../",substr_count($_SERVER["PHP_SELF"] , "/") -1).$carpeta_trabajo;

		if (!empty($carpeta_trabajo)) {
			$absolute_include = $absolute_include."/"; 
			$carpeta_trabajo = "/".$carpeta_trabajo; 
			
		}

        class ConexionDB{

            public function retornar_conexion(){
                try {
        
                    $user = "root";
                    $pass = "";
                    $host = "localhost";//Solo si es el localhost
                    $db = "archivo_historico";
                    $conexion = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);
                    
                
                } catch (Exception $e) {
        
                    $conexion=$e->getMessage(); 
        
                }				
                
                if (!is_object($conexion)){
                    // es un error no es un objeto database
                    echo $conexion;
                    echo "<br> NO SE PUEDE CONECTAR A LA BASE DE DATOS";
                    die();
                
                }
                
        
                return $conexion;
        
            }
            
            public function cerrar_conexion(&$conexion){
        
                $conexion = null;
                
                return null;
                
            }		
        
        
        }

		
        

        function armar_Tabla($lista,$absolute_include){
            if(!empty($lista)){
            $relacion = array();
            foreach ($lista as $key) {
            
                if(!in_array($key['Relacion'],$relacion)){
                    $pdf = armar_libros($key['Relacion']);
                    $libro= '<div class="contenedor-busqueda">
                    <a href="'.$key['rutas'].$pdf.'" class="contenedor-libro">
                        <p class="contenedor-titulo">'.$key['Titulo'].'</p>
                        <div class="contenido">
                            <div class="cont" >
                                <p>Autor: '.$key['Autor'].'</p>
                                <p>Materia: '.$key['Materia'].'</p>
                                <p >Tipo: Libro</p>
                            </div>
                                <img src="'.$key['rutas'].$key['Nombre_Archivo'].'" alt="tapa" class="img-libro">
                            </div>
                            <p class="contenedor-descripcion">'.$key['sinopsis'].'</p>
                        </a>
                        <div class="">
                        <a href="'.$absolute_include.'controladores/Biblioteca/controler-sub.php?accion=edit&id='.$key['id_archivo'].'" class="btn_modificar" ><i class="ri-edit-fill"></i></a>
                        <a href="'.$absolute_include.'controladores/Biblioteca/controler-sub.php?accion=delete&id='.$key['id_archivo'].'" class="btn_eliminar" ><i class="ri-delete-bin-2-fill"></i></a></div>
                        </div>';
                        $relacion[] = $key['Relacion'];
                        echo $libro;

                }
               
            }
            }else{
                echo '<center><img src="../../storage/imagenes/sinResultado.png" style="width:150px;opacity:1; trasition:all 1s"/>
                <h1>No se Encontraron resultados</h1></center>';
            }

        
        }

            function armar_libros($relacion){
                $db = new ConexionDB;
                $conexion = $db->retornar_conexion();
        
                $lista_resultados = array();
        
                $sql = "SELECT * FROM archivos a WHERE a.Relacion = '$relacion' LIMIT 1";
        
                $statement = $conexion->prepare($sql);
                $statement->execute();
        
                while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
                    return $resultado['Nombre_Archivo'];
                }
        
                
            }


            $db = new ConexionDB;
            $conexion = $db->retornar_conexion();
        
            $lista_resultados = array();
        
            $sql = "SELECT a.id_archivo,a.Nombre_Archivo,a.Titulo,a.Relacion, a.Id_tipo_archivo,
            r.rutas, 
            plc.palabra_clave, 
            tpa.tipo, 
            b.Autor,b.Materia,b.sinopsis, 
            c.Tipo_coleccion, 
            tcb.Descripcion AS 'Tipo_Contenido' 
            FROM archivos a 
            LEFT JOIN rutas r ON a.Id_ruta = r.Id_rutas 
            LEFT JOIN palabras_claves plc ON a.Id_palabra_clave = plc.Id_palabra_clave 
            LEFT JOIN tipo_archivo tpa ON a.Id_tipo_archivo = tpa.Id_tipo_Archivo 
            LEFT JOIN biblioteca b ON a.id_archivo = b.ID_Archivo 
            LEFT JOIN coleccion c ON b.ID_coleccion = c.ID_coleccion 
            LEFT JOIN tipo_cont_b tcb ON b.Tipo = tcb.ID_tipo_cont_b
            WHERE a.Id_tipo_archivo = 5;";
            
            
            if(isset($_POST['consulta'])){
                $consulta = $_POST['consulta'];
                $sql = "SELECT a.id_archivo,a.Nombre_Archivo,a.Titulo,a.Relacion,
                r.rutas,
                plc.palabra_clave,
                tpa.tipo,
                b.Autor,b.Materia,b.sinopsis,
                c.Tipo_coleccion,
                tcb.Descripcion AS 'Tipo_Contenido'
                FROM archivos a
                LEFT JOIN rutas r ON a.Id_ruta = r.Id_rutas
                LEFT JOIN palabras_claves plc ON a.Id_palabra_clave = plc.Id_palabra_clave
                LEFT JOIN tipo_archivo tpa ON a.Id_tipo_archivo = tpa.Id_tipo_Archivo
                LEFT JOIN biblioteca b ON a.id_archivo = b.ID_Archivo
                LEFT JOIN coleccion c ON b.ID_coleccion = c.ID_coleccion
                LEFT JOIN tipo_cont_b tcb ON b.Tipo = tcb.ID_tipo_cont_b
                WHERE a.Titulo LIKE '%$consulta%' 
                OR plc.palabra_clave LIKE '%$consulta%' 
                OR b.Autor LIKE '%$consulta%' 
                OR b.sinopsis LIKE '%$consulta%';";
            }

            $statement = $conexion->prepare($sql);
            $statement->execute();
        
            if (!$statement) {
                $tabla = "No se encontraron libros";
                // no se encontraron paises
            }
            else {
            
                // reviso el retorno
                while ($resultado= $statement->fetch(PDO::FETCH_ASSOC)) {
                    
                    $lista_resultados[] = $resultado;
                }

                
                $tabla = armar_Tabla($lista_resultados,$absolute_include);
    
            }
            

            
        
            return $tabla;	
            
?>
