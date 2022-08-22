<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prueva</title>
    <style>
        table{
            margin: auto;
            width:450px;
            border:2px dotted #ff0000;
        }
    </style>
</head>
<body>
    <?php 
        include('conexion.php');
    ?>
    <form action="datosImagen.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <label for="imagen">Indice:</label>
                </td>
                <td>
                    <input type="file" name="indice" size="20">
                </td>
            </tr>
            <tr>
            <td>
                    <label for="imagen">Contra Tapa:</label>
                </td>
                <td>
                    <input type="file" name="contra_tapa" size="20">
                </td>
            </tr>
            <tr>
            <td>
                    <label for="imagen">Tapa:</label>
                </td>
                <td>
                    <input type="file" name="tapa" size="20">
            </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" value="Enviar Imagen">
                </td>
            </tr>
        </table>
    </form>
    <button><a href="verImagenes.php">ver las imagenes</a></button>
</body>
</html>