<?php

session_start();
$usuario = $_SESSION['username']

if(!isset($usuario)){
    header("location: Login.php");

 }else{

    echo "<h1>BIENVENIDO $usuario </h1>";


    echo "<a href='prueba/salir.php'> SALIR</a> ";


 }




?>