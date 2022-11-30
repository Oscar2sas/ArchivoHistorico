<?php include($absolute_include."vista/plantilla/header.php"); ?>
<?php 
	include($absolute_include.'vista/componentes/Navbar.php');

    $id = $_GET['id'];
 ?>
    <div class="contenedor-busqueda">
        <?php 
        foreach($libro as $li){
            echo $li;
        }
        ?>
        
    </div>
    <center><p>¿Estas Seguro que quieres <strong> Eliminar </strong> este archivo?</p></center>
    <center><a href="controler-svm.php?accion=eliminar&id=<?php echo $id?>" class='btn_modificar'>Estoy seguro</a><a href="controler-svm.php" class='btn_eliminar'>Cancelar</a></center>
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