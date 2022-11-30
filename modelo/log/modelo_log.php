<?php

    function buscar_log(){

        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM `log`,`usuarios`,`rol` WHERE log.rela_usuario_id = usuarios.id_usuarios AND usuarios.rela_rol_id = rol.rol_id  
ORDER BY `log`.`log_id` DESC"; // busca todos los logs
        
        //$statement = $conexion->query($sql);
        $statement = $conexion->prepare($sql);
    

        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }

        if (!$statement) {
            // no se encontraron paises
        }
        else {
        
            $logs = array();  // creo un array que va a almacenar la informacion de los logs

            // reviso el retorno
    
            while($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
    
                $logs[] = $resultado;
    
            }
        }

        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
        $list = armar_tabla_log($logs);
        return $list;
      
    }

function insertar_log($arg_cdescripcion_log){
    $dfecha_log=date("Y/m/d");
    $chora_log=date("H:i:s", time());
    $usuario_id=$_SESSION['usuario_id'];

    $db = new ConexionDB;
    $conexion = $db ->retornar_conexion();

    $sql = "INSERT INTO log (dfecha_log,chora_log,cdescripcion_log,rela_usuario_id) VALUES 
    (:arg_dfecha_log, :arg_chora_log, :arg_cdescripcion_log, :arg_rela_usuario_id)";

    $instancia = $conexion ->prepare($sql); 

    $instancia ->bindParam(':arg_dfecha_log', $dfecha_log);
    $instancia ->bindParam(':arg_chora_log', $chora_log);
    $instancia ->bindParam(':arg_cdescripcion_log', $arg_cdescripcion_log);
    $instancia ->bindParam(':arg_rela_usuario_id', $usuario_id);

    if (!$instancia) {
        echo "Error al crar el registro";
    }else{
        $instancia ->execute();
    }

    $instancia = $db ->cerrar_conexion($conexion);
}

function armar_tabla_log($lista){
    $listadeCosas = array();
    foreach($lista as $result){
            $tabla='
                <div class="contenedor-user">
                    <p>
                    Fecha:'.$result['dfecha_log'].'
                    </p>
                    <p>
                    Hora: '.$result['chora_log'].'
                    </p>
                    <p>
                    Movimiento: '.$result['cdescripcion_log'].'
                    </p>
                    <p>
                    Rol: '.$result['rol'].'
                    </p>
                </div>
            ';

            array_push($listadeCosas, $tabla);
        

        }
        return $listadeCosas;
    }

?>