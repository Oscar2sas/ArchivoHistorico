<nav class='menu'>
	<label class='logo'><i class="<?php echo $icon?>"></i><?php echo $titulo_area ?></a></label>
	<ul class='menu_items' id='modal'>
		<?php 
		if (!empty($ruta_subir)&&!empty($ruta_home)) {
						if($encendido == 'home'){
				echo '<li class="active"><a href="'.$absolute_include.$ruta_home.'">Inicio</a></li>';
				echo '<li><a href="'.$absolute_include.$ruta_subir.'">Subir Archivo</a></li>';
			}elseif($encendido == 'subir'){
				echo '<li><a href="'.$absolute_include.$ruta_home.'">Inicio</a></li>';
				echo '<li class="active"><a href="'.$absolute_include.$ruta_subir.'">Subir Archivo</a></li>';
			}
		}
		?>
	</ul>
	<div class='contenedor-list'>
		<span class='indexList' onclick='showList()'>Areas</span>
		<ul class='menu_itemsList' id='lista'>
			<li><a href="<?php echo $absolute_include?>controladores/inicio/index.php">Inicio</a></li>
			<li><a href="<?php echo $absolute_include?>controladores/Biblioteca/controler-sub.php">Biblioteca</a></li>
			<li><a href="<?php echo $absolute_include?>controladores/Fotografia/controler-svm.php">Fotografia</a></li>
		</ul>
	</div>
	<span class='btn_menu' onclick="showmenu()">
	&#9776
	</span>
</nav>

<script>
	function showList() {
		document.getElementById("lista").classList.toggle("showList");
	}
</script>