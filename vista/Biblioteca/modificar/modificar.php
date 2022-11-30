<?php include($absolute_include."vista/plantilla/header.php"); ?>
<?php 
	include($absolute_include.'vista/componentes/Navbar.php');
 ?>
<div>
    <form action="<?php echo $absolute_include;?>controladores/Biblioteca/controler-sub.php" method="post" enctype="multipart/form-data">
        <input hidden name='accion' value='modificar'>
        <input hidden name='area' value=1>
        <input hidden name='rela' value='<?php echo $datos_libro['Relacion'] ?>'>
        <input hidden name='id_a' value='<?php echo $datos_libro['id_archivo'] ?>'>
        
        <div class='contenedor'>
            <div class='formulario'>
                <input type='text' name='titulo_biblioteca' placeholder="Titulo" class='inputText' require value='<?php echo $datos_libro['Titulo'] ?>'>
                <input type='text' name='autor' placeholder="Autor" class='inputText' require value='<?php echo $datos_libro['Autor'] ?>'>
                <input type='text' name='materia' placeholder="Materia" class='inputText' require value='<?php echo $datos_libro['Materia'] ?>'>
                <p id='pala' ><?php  Palabras_claves(); ?></p> 
                <label for="" class="contenedorCheck">Nueva palabra clave:  <span class="spanCheck"><input type="checkbox" name="" id="plc" class="check" require></span></label>
                <label for=""></label>
                <?php 
                Tipo_Archivo();
                Coleccion();?>

                <div class="mb-3"><input class="form-control" type="file" name='Arch' id="formFile" require></div>
                
                <textarea name='sipn' id='' cols='30' rows='10' placeholder='Sinopsis' class='inputArea' require><?php echo $datos_libro['sinopsis'] ?></textarea>
                <input type='submit' name='saso' class='inputBoton' value='Guardar'>
            </div>
            <div class='tapa_libro'>

                    <label for='perfil'>
                        <img src="../../../<?php echo $datos_libro['rutas'].$datos_libro['Nombre_Archivo'];?>" class='img-tapa show' id="vista_previa">
                    </label>

                    <label id="info"></label><input hidden type="file" id="perfil" class="form-control" name="TP" accept="image/png, image/gif, image/jpeg">
            </div>
        </div>

    </form>
    </div>
<?php include($absolute_include."vista/plantilla/footers.php"); ?>

<script>
        $("#perfil").change(mostrarImagen);

        $('#plc').change( function() { 
                if(this.checked){
                    document.getElementById('palabra').remove();
                    $('#pala').append('<input name="palabraNueva" id="palabraN" class="inputText" placeholder="Ingreses Nueva Plabra Clave">');

                }else{
                    document.getElementById('palabraN').remove();
                    $('#pala').append('<?php echo Palabras_claves(); ?>');
                }
            });

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