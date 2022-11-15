<?php include($absolute_include."vista/plantilla/header.php"); 
include($absolute_include."vista/componentes/Navbar_ADM.php");
?>

<div>
    <?php
            foreach ($user as $us){
                echo $us;
        }
    ?>
</div>

<?php include($absolute_include."vista/plantilla/footers.php"); ?>