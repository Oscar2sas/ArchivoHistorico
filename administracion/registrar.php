<?php 

$carpeta_trabajo="";
$seccion_trabajo="/administracion";

if (strpos($_SERVER["PHP_SELF"], $seccion_trabajo) >1 ) {
    $carpeta_trabajo=substr($_SERVER["PHP_SELF"],1, strpos($_SERVER["PHP_SELF"] , $seccion_trabajo) -1);
}
$absolute_include = str_repeat("../",substr_count($_SERVER["PHP_SELF"] , "/") -1).$carpeta_trabajo;

if (!empty($carpeta_trabajo)) {
    $absolute_include = $absolute_include."/"; 
    $carpeta_trabajo = "/".$carpeta_trabajo; 
    
}

$accion = "";

if (isset($_REQUEST['accion'])) {
    $accion = $_REQUEST['accion'];
}

if ($accion == "" || $accion=="index") {
    include($absolute_include."vista/registrar/index.php");
}elseif ($accion == 'registrar') {
    usuarios_incertar($_POST,$_FILES);
}

function numero_ramdom(){
    $num = '';
    for ($i=1; $i <= 5 ; $i++) { 
        $num = $num.mt_rand(0,9);
    }
    return $num;
}

function usuarios_incertar($arg_POST,$arg_FILES){
    $absolute_include = $GLOBALS['absolute_include'];
    $carpeta_trabajo = $GLOBALS['carpeta_trabajo'];

    $cnombre_usuario = strtoupper($arg_POST['cnombre_usuario']);
    $rela_rol_id = 20;
    if($arg_FILES['cimg_usuario']['sise'] ==0){
        $img_perfil = "default.png";
    }else{
        $num = numero_ramdom();
        $img_perfil = "IMG".date('dmy').$num.".png";

        move_uploaded_file($arg_FILES['cimg_usuario']['tmp_name'],$absolute_include."/storage/usuarios/".$img_perfil);
    }

    $arraydat = [
        "cimg_usuario" => $img_perfil,
        "cnombre_usuario" => trim($arg_POST['cnombre_usuario']),
        "cemail_usuario" => trim($arg_POST['cemail_usuario']),
        "cpassword_usuario" => strtoupper(trim($arg_POST['cnombre_usuario'])),
        "rela_rol_id" => $rela_rol_id,
    ];

    $ultimo_usuario_id = insertar_usuario($arraydat);

    header("Location: ".$carpeta_trabajo."/administracion/login.php");

}

?>