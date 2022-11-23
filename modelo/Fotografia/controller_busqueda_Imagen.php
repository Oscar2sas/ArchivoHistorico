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

		
        

        function armar_Tabla($lista){
            $relacion = array();
            foreach ($lista as $key) {
            
                    $img= '
                    <a href="'.$key['rutas'].$key['Nombre_Archivo'].'" class="contenedor-libro">
                        <p class="contenedor-titulo">'.$key['Titulo'].'</p>
                        <img src="'.$key['rutas'].$key['Nombre_Archivo'].'" alt="tapa" class="img">
                        <div class="contenido_img">
                            <div class="cont-img" >
                                <p>Fuente: '.$key['fuente'].'</p>
                                <p>Fecha: '.$key['fecha'].'</p>
                                <p class="fi" >Tipo: '.$key['tipo'].'</p>
                            </div>
                                
                            </div>
                            <p class="contenedor-descripcion">'.$key['Descripcion'].'</p>
                        </a>';
                        echo $img;
               
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
        
            $sql = "SELECT a.Nombre_Archivo,a.Titulo,a.Id_tipo_archivo,
            r.rutas, 
            plc.palabra_clave, 
            tpa.tipo,
            f.Descripcion,f.fuente,f.fecha
            FROM archivos a 
            LEFT JOIN rutas r ON a.Id_ruta = r.Id_rutas 
            LEFT JOIN palabras_claves plc ON a.Id_palabra_clave = plc.Id_palabra_clave 
            LEFT JOIN tipo_archivo tpa ON a.Id_tipo_archivo = tpa.Id_tipo_Archivo
            LEFT JOIN fotografia f ON a.id_archivo = f.Id_archivo
            WHERE a.Id_tipo_archivo = 2;";
            
            
            if(isset($_POST['consulta'])){
                $consulta = $_POST['consulta'];
                $sql = "SELECT a.Nombre_Archivo,a.Titulo,a.Id_tipo_archivo,
                r.rutas, 
                plc.palabra_clave, 
                tpa.tipo,
                f.Descripcion,f.fuente,f.fecha
                FROM archivos a 
                LEFT JOIN rutas r ON a.Id_ruta = r.Id_rutas 
                LEFT JOIN palabras_claves plc ON a.Id_palabra_clave = plc.Id_palabra_clave 
                LEFT JOIN tipo_archivo tpa ON a.Id_tipo_archivo = tpa.Id_tipo_Archivo
                LEFT JOIN fotografia f ON a.id_archivo = f.Id_archivo
                WHERE a.Id_tipo_archivo = 2
                AND a.Titulo LIKE '%$consulta%'
                OR f.Descripcion LIKE '%$consulta%'
                OR f.fuente LIKE '%$consulta%'
                OR f.fecha LIKE '%$consulta%';";
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

                
                $tabla = armar_Tabla($lista_resultados);
    
            }
            

            
        
            return $tabla;	
            
?>
