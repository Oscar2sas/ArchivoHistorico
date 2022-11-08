<?php include($absolute_include."vista/plantilla/header.php"); ?>
<?php 
	include($absolute_include.'vista/componentes/Navbar.php');
 ?>
<div>
    <form action="<?php echo $absolute_include;?>controladores/Fotografia/controler-svm.php" method="post" enctype="multipart/form-data">
        <input hidden name='accion' value='guardar'>
        <input hidden name='area' value=1>
        
        <div class='contenedor'>
            <div class='formulario'>
                <input type='text' name='titulo_Fotografia' placeholder="Titulo" class='inputText' require>
                <input type='text' name='Fuente' placeholder="Fuentes" class='inputText' require>
                <input type='date' name='Fecha'class='inputText' require>
                <p id='pala' ><?php  Palabras_claves(); ?></p> 
                <label for="" class="contenedorCheck">Nueva palabra clave:  <span class="spanCheck"><input type="checkbox" name="" id="" class="check" require></span></label>
                                
                <textarea name='descr' id='' cols='30' rows='10' placeholder='Descripciones' class='inputArea' require></textarea>
                <input type='submit' name='saso' class='inputBoton' value='Guardar'>
            </div>
            <div class='tapa_libro'>

                    <label for='perfil'>
                        <img src="<?php echo $carpeta_trabajo;?>/storage/imagenes/defaul-img.png" class='img-tapa' id="vista_previa">
                    </label>

                    <label id="info"></label><input hidden type="file" id="perfil" class="form-control" name="image" accept="image/png, image/gif, image/jpeg">
            </div>
        </div>

    </form>
    </div>
    
<?php include($absolute_include."vista/plantilla/footers.php"); ?>
<script>
        $("#perfil").change(mostrarImagen);


        function mostrarImagen(event) {
            //console.log(event)

            if ($("#file_error").length != 0) {
                $("#file_error").remove();
            }

            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function (event) {
                $('#vista_previa').attr("src", event.target.result);
                $("#info").html("");
            }
            reader.readAsDataURL(file);
            if(!document.getElementById("vista_previa").classList.contains("show")){
                document.getElementById("vista_previa").classList.toggle("show");
            }
            
        }
    </script>