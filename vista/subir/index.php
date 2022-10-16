<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo $absolute_include;?>estilos/cosas.css">
</head>
<body>
    
    <form action="<?php echo $absolute_include;?>controladores/Subir_archivo/controler-sub.php" method="post" enctype="multipart/form-data">
	<input hidden name='accion' value='guardar'>
<div class="form-group">
                <label>Perfil</label><br>
                <label for="perfil">
                <img src="<?php echo $carpeta_trabajo;?>/storage/usuarios/default.png" style="width:120px; height:120px; border-radius: 100px;" id="vista_previa">
                </label>
                <label id="info"></label><input hidden type="file" id="perfil" class="form-control" name="cimg_usuario" accept="image/png, image/gif, image/jpeg">
            </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $("#perfil").change(mostrarImagen);


    function mostrarImagen(event) {
        //console.log(event)

        if( $("#file_error").length != 0 ){
            $("#file_error").remove();
        }

        var file = event.target.files[0];
        var reader = new FileReader();
        $("#info").html("Subiendo...");
        reader.onload = function(event) {
            $('#vista_previa').attr("src",event.target.result);
            $("#info").html("");
        }
        reader.readAsDataURL(file);
    }
</script>
</body>
</html>