<?php 
include('conexion.php');

$sql = "SELECT tapa,indice,contra_tapa FROM libros";

$resultado = mysqli_query($conexion,$sql);

echo "<table>
<thead>
<th>Nombre</th>
<th>Tapa</th>
<th>Indice</th>
<th>Contra Tapa</th>
</thead>";

while($fila = mysqli_fetch_array($resultado)){

    $ruta_indice = $fila['indice'];
    $ruto_tapa = $fila['tapa'];
    $ruto_Ctapa = $fila['contra_tapa'];
    echo "
    <tr>
        <td>
            libro:
        </td>
        <td>
            <img src='../archivoProvincial/".$ruto_tapa.$ruta_indice.$ruto_Ctapa."' alt='tapa' width='20%'>;
        </td>
        <td>
            <img src='../archivoProvincial/".$ruta_indice."' alt='indice' width='20%'>;
        </td>
        <td>
            <img src='../archivoProvincial/".$ruto_Ctapa."' alt='Ctapa' width='20%'>;
        </td>
    </tr>";
    

    
}

echo "</table>";

?>