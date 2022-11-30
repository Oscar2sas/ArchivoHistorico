<?php



function Buscar_user (){
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $lista_resultados = array();

    $sql = "SELECT * FROM usuarios u1, rol r1,estados_usuario e WHERE u1.rela_rol_id = r1.rol_id and u1.estado = e.id_estado;";

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
            $tabla='
                <div class="contenedor-user">
                    <p>
                    Nombre de Ususario: '.$result['cnombre_usuario'].'
                    </p>
                    <p class="centro">
                    Email: '.$result['cemail_usuario'].'
                    </p>
                    <p>
                    Rol del usuario: '.$result['rol'].'
                    </p>
                </div>
            ';

            array_push($listadeCosas, $tabla);
        

        }
        return $listadeCosas;
    }

    

?>