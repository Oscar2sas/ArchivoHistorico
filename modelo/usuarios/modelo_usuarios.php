<?php 

function login_usuario($arg_usuario,$arg_password){
	// uso la clase PDO para conectar a la base de datos
        //  tambien se puede hacer sin clases   con mysqli_connect()


        $db = new ConexionDB;
        $conexion = $db->retornar_conexion();

        $sql = "SELECT * FROM usuarios WHERE `cemail_usuario`='".$arg_usuario."'";   // aqui va el sql para recuperar el usuario

        // preparo el sql para enviar   se puede usar prepare   y bindparam 
        $statement = $conexion->prepare($sql);
        
        if(!$statement){
            echo "Error al crear el registro";
        }else{
            $statement->execute();
        }


        // o puedo usar directamente  ->query()
        
        // $statement = $conexion->query($sql)


        $resultado = $statement->fetch( PDO::FETCH_ASSOC );   // porque es un solo resultado
        
        // si tuviera mas resultados
        // $resultados = array();  // creo un array que va a almacenar la informacion del usuario


        // reviso el retorno

        //while($resultado = $statement->fetch()){

            //  $resultados[] = $resultado;

        //}

        // return $resultados;


        // cierro la conexion
        $statement = $db->cerrar_conexion($conexion);
		return $resultado;
}

function insertar_usuario($array){
    $ultimo_id=0;
       
    $db = new ConexionDB;
    $conexion = $db->retornar_conexion();

    $hash = encriptar_password($array['cpassword_usuario']);

    //$sql = "INSERT INTO paises (cnombre_pais) VALUES (:arg_cnombre_pais)";
    $sql = "INSERT INTO `usuarios`(`cnombre_usuario`, `cemail_usuario`, `cpassword_usuario`, `rela_rol_id`, `estado`) VALUES (:arg_cnombre_usuario,:arg_cemail_usuario,:arg_cpassword_usuario,:arg_rela_rol_id,1)";
        
    // preparo el sql para enviar   se puede usar prepare   y bindparam 
    $statement = $conexion->prepare($sql);
        
        
    $statement->bindParam(':arg_cnombre_usuario' , $array['cnombre_usuario']);  // reemplazo los parametros enlazados 
    $statement->bindParam(':arg_cemail_usuario' , $array['cemail_usuario']);
    $statement->bindParam(':arg_rela_rol_id' , $array['rela_rol_id']);
    $statement->bindParam(':arg_cpassword_usuario' , $hash);
        
    if(!$statement){
        echo "Error al crear el registro";
    }else{
        $statement->execute();
    }
        
    $ultimo_id = $conexion->lastinsertid();
       
    // cierro la conexion
    $statement = $db->cerrar_conexion($conexion);

    return $ultimo_id;
}

function encriptar_password($arg_password){
	$hash = password_hash(trim($arg_password), PASSWORD_DEFAULT);
    return $hash;
}

?>