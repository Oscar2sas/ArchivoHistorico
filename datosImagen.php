<?php 

include('conexion.php');

$nombreImageIndice = $_FILES['indice']['name'];
$tipoImageIndice = $_FILES['indice']['type'];
$sizeImageIndice = $_FILES['indice']['size'];

$nombreImageTapa = $_FILES['tapa']['name'];
$tipoImageTapa = $_FILES['tapa']['type'];
$sizeImageTapa = $_FILES['tapa']['size'];

$nombreImageCT = $_FILES['contra_tapa']['name'];
$tipoImageCT = $_FILES['contra_tapa']['type'];
$sizeImageCT = $_FILES['contra_tapa']['size'];

$carpeta_guardado = $_SERVER['DOCUMENT_ROOT'] . '/archivoProvincial/';

move_uploaded_file($_FILES['indice']['tmp_name'],$carpeta_guardado.$nombreImageIndice);
move_uploaded_file($_FILES['tapa']['tmp_name'],$carpeta_guardado.$nombreImageTapa);
move_uploaded_file($_FILES['contra_tapa']['tmp_name'],$carpeta_guardado.$nombreImageCT);

$sql = "INSERT INTO libros (indice, contra_tapa, tapa) VALUE ('".$nombreImageIndice."', '".$nombreImageCT."', '".$nombreImageTapa."') ";
$resultado = mysqli_query($conexion,$sql);

header("Location: verImagenes.php");


?>