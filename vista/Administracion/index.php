<?php include($absolute_include."vista/plantilla/header.php"); 
include($absolute_include."vista/componentes/Navbar_ADM.php");
?>

<h2> Usuarios: </h2><a href="http://">Ver Mas</a>
<center><div class="">
    <?php
            foreach ($user as $us){
                echo $us;
        }
    ?>
</div></center>

<h2> Movimientos: </h2><a href="http://">Ver Mas</a>
<center><div class="" >
<?php 
    foreach ($logs as $key) {
        echo $key;
    }
?>
</div></center>

<?php include($absolute_include."vista/plantilla/footers.php"); ?>