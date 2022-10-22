<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo $absolute_include;?>estilos/cosas.css">
</head>
<body>
<?php 
	include($absolute_include.'vista/componentes/Navbar.php');
 ?>

    <form action="<?php echo $absolute_include;?>controladores/Subir_archivo/controler-sub.php" method="post"
        enctype="multipart/form-data">
        <input hidden name='accion' value='guardar'>
        <input hidden name='area' value=1>

        <div id='sas'>
        <p><label>Titulo: </label><input type='text' name='titulo_biblioteca'></p>
        <p><label>Autor: </label><input type='text' name='autor'></p>
        <p><label>Materia: </label><input type='text' name='materia'></p>
        <p><label>Palabra clave: </label></p><p id='pala' >

        <?php  Palabras_claves(); ?>
        </p><p><label>Nueva palabra Clave: </label><input type='checkbox' name='' id='plc'>
        </p><?php 
        Tipo_Archivo();

        Coleccion();?>

        <p><label>Archivo: </label><input type='file' name='Arch' id='arch'></p><div id=omar>

        <div class="form-group">
            <label>Perfil</label><br>
            <label for="perfil">
                <img src="<?php echo $carpeta_trabajo;?>/storage/usuarios/default.png" style="width: 350px;" id="vista_previa">
            </label>
            <label id="info"></label><input hidden type="file" id="perfil" class="form-control" name="TP"
                accept="image/png, image/gif, image/jpeg">
        </div>

        <p><label>Sinopsis: </label></p></div>
        <p><textarea name='sipn' id='' cols='30' rows='10'></textarea></p>
        <p><input type='submit' name='saso'></p>
        </div>

    </form>

    <script src="<?php echo $carpeta_trabajo;?>/storage/js/jquery.min.js"></script>
    <script>
        $("#perfil").change(mostrarImagen);


        function mostrarImagen(event) {
            //console.log(event)

            if ($("#file_error").length != 0) {
                $("#file_error").remove();
            }

            var file = event.target.files[0];
            var reader = new FileReader();
            $("#info").html("Subiendo...");
            reader.onload = function (event) {
                $('#vista_previa').attr("src", event.target.result);
                $("#info").html("");
            }
            reader.readAsDataURL(file);
        }
    </script>
</body>

</html>