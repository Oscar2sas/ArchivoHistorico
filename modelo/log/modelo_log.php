<?php

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

?>