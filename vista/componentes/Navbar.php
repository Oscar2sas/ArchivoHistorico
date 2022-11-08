<nav class='menu'>
	<label class='logo'><i class="ri-book-mark-line"></i><?php echo $titulo_area ?></a></label>
	<ul class='menu_items' id='modal'>
		<?php 
			if($encendido == 'home'){
				echo '<li class="active"><a href="'.$absolute_include.$ruta_home.'">Inicio</a></li>';
				echo '<li><a href="'.$absolute_include.$ruta_subir.'">Subir Libro</a></li>';
			}elseif($encendido == 'subir'){
				echo '<li><a href="'.$absolute_include.$ruta_home.'">Inicio</a></li>';
				echo '<li class="active"><a href="'.$absolute_include.$ruta_subir.'">Subir Libro</a></li>';
			}
		?>
	</ul>
	<ol class='menu_itemsList'>
			<li><span  class='indexList' onclick="showList()">Areas</span></li>
			<li class='listado' id=lista><a href="http://">home</a></li>
			<li class='listado' id=lista><a href="http://">home</a></li>
			<li class='listado' id=lista><a href="http://">home</a></li>
			<li class='listado' id=lista><a href="http://">home</a></li>
			<li class='listado' id=lista><a href="http://">home</a></li>
		</ol>
	<span class='btn_menu' onclick="showmenu()">
	&#9776
	</span>
</nav>

<script>
	function showList() {
		document.getElementById("lista").classList.toggle("showList");
	}
</script>