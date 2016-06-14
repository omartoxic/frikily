<?php
	session_start();
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/> 
		<title>Administrar elemento</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="css/font-awesome.css" rel="stylesheet">
		<link href="css/font-awesome-animation.css" rel="stylesheet">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="estilojq.js"></script>
		
	</head>
	<?php
		include "basedatos.php";
		$conex=new Conexion("root","","frikily");
		$conex->connect();	
		if(isset($_POST['accion'])){
			
			if($_POST['accion']=="Aprobar"){
				$update_general= "UPDATE general g SET nombre = '".$_POST['nombre']."', sinopsis = '".$_POST['sinopsis']."', genero = '".$_POST['genero']."', annio = '".$_POST['annio']."', aprobado = 1 WHERE g.codigo =".$_POST['item'];
				
				$list=$conex->consult($update_general);
				
				echo $_POST['tipo'];
				
				//ANIME
				if($_POST['tipo']=="anime"){
					$update_especifica="UPDATE ".$_POST['tipo']." t SET anniofin = '".$_POST['annioFin']."', temporadas = '".$_POST['temporadas']."', capitulos = '".$_POST['capitulos']."', estudio = '".$_POST['estudio']."' WHERE t.codigo =".$_POST['item'];
				}
				
				//COMICS
				if($_POST['tipo']=="comics"){
					$update_especifica="UPDATE ".$_POST['tipo']." t SET numeros = '".$_POST['numeros']."', editorial = '".$_POST['editorial']."', editorialoriginal = '".$_POST['editorialOriginal']."' WHERE v.codigo =".$_POST['item'];
				}	
				
				//LIBROS
				if($_POST['tipo']=="libros"){
					$update_especifica="UPDATE ".$_POST['tipo']." t SET paginas = '".$_POST['paginas']."', isbn = '".$_POST['isbn']."', editorial = '".$_POST['editorial']."' WHERE t.codigo =".$_POST['item'];
				}
				
				//MANGAS
				if($_POST['tipo']=="manga"){
					$update_especifica="UPDATE ".$_POST['tipo']." t SET anniofin = '".$_POST['annioFin']."', revista = '".$_POST['revista']."', tomos = '".$_POST['tomo']."' WHERE t.codigo =".$_POST['item'];
				}
				
				//PELICULAS
				if($_POST['tipo']=="peliculas"){
					$update_especifica="UPDATE ".$_POST['tipo']." t SET duracion = '".$_POST['duracion']."', productora = '".$_POST['productora']."' WHERE t.codigo =".$_POST['item'];
				}
				
				//SERIES
				if($_POST['tipo']=="series"){
					$update_especifica="UPDATE ".$_POST['tipo']." t SET anniofin = '".$_POST['annioFin']."', temporadas = '".$_POST['temporadas']."', capitulos = '".$_POST['capitulos']."', canal = '".$_POST['canal']."' WHERE t.codigo =".$_POST['item'];
				}
				
				//ANIME
				if($_POST['tipo']=="videojuegos"){
					$update_especifica="UPDATE ".$_POST['tipo']." t SET desarrolladora = '".$_POST['desarrolladora']."', numjugadores = '".$_POST['jugadores']."', online = '".$_POST['selectOnline']."' WHERE t.codigo =".$_POST['item'];
				}
				
				$list=$conex->consult($update_especifica);
			}
			if($_POST['accion']=="Eliminar"){
				$list=$conex->consult("DELETE FROM general WHERE codigo = ".$_POST['item']);
				$list2=$conex->consult("DELETE FROM ".$_POST['tipo']." WHERE codigo = ".$_POST['item']);
			}
			
			header("Location:index.php");
		}
		else{	
			$list=$conex->consult("SELECT * FROM general g,".$_POST['tipo']." t WHERE g.codigo =".$_POST['item']." AND g.codigo=t.codigo");
			$general = $list[0];
			
			$list2=$conex->consult("SELECT * FROM personas, rol WHERE rol.CodigoPersona = personas.CodigoPersona AND rol.Codigo =".$_POST['item']);
			$personas = $list2[0];
			
			print_r($general);
			print_r($personas);	
		}		
	?>
	<body>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<span class="navbar-brand">Friki.ly</span>
				</div>
				<div class="navbar-collapse collapse navbar-ex1-collapse">


					<form action="lista.php" method="post">
						<ul id="paginacion" class="nav navbar-nav">
							<li><a href="index.php">Página principal</a></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="videojuegos">Videojuegos</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="anime">Anime</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="manga">Manga</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="comics">Cómics</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="libros">Libros</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="peliculas">Películas</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="series">Series</button></li>
						</ul>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<?php
							if(!isset($_SESSION['usuario']))
							{
								echo "<li><a href='inicioSesion.php'>iniciar sesión</a></li>";
							}
							else
							{
								echo "<li>";
								echo "<img class='imagen-usu img-rounded' src='imagenesusuarios/".$_SESSION['imgusu']."?comodin=".rand(1,1000)."'>";
								echo $_SESSION['usuario']."</li>";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="navbar navbar-default arriba"></div>
		<div class="container">
			<div class="row">
				<div class="list-group secciones" id="secciones">
					<form action="administrarDatos.php" method="POST" id="datos" enctype="multipart/form-data">
	
						<div id = 'imagen_subida'>
							<img src="imagenes/<?php echo $general[5] ?>.jpg" style='width:180px;'>
						</div>
						<br>
				  		<div id = 'nombre'>
				            <label>Nombre:</label>
				            <input type = 'text' name='nombre' id='id_nombre' value='<?php echo $general[1]?>'/>
				        </div>

				        <div id = 'sinopsis'>
				            <label>Sinopsis:</label>
				            <input type = 'text' name='sinopsis' id='id_sinopsis' value='<?php echo $general[2]?>'/>
				        </div>

				        <div id = 'genero'>
				            <label>Género:</label>
				            <input type = 'text' name='genero' id='id_genero' value='<?php echo $general[4]?>'/>
				        </div>

						<!--
						<div id = 'imagen_subida'>
							<label>Imagen subida:</label>
							<br>
							<img src="imagenes/<?php echo $general[5] ?>.jpg" style='width:180px;'>
						</div>
						
				        <div id = 'imagen'>
				            <label for="imagen">Subir otra imagen:</label>
				            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
				            <input type="file" name="imagen_usuario" id="imagen" />
				        </div>
						
						-->

				        <div id = 'annio'>
				            <label>Año:</label>
				            <input type = 'number' name='annio' id='id_annio' max = '2099' value='<?php echo $general[6]?>'/>
				        </div>

						<!--
				        <div id = 'tipo'>
				            <label>Tipo:</label>
				            <select name="tipo" select = 'Seleciona'>
							  <option <?php if ($_POST['tipo'] == 'anime' ) echo 'selected' ; ?> value="Anime">Anime</option>
							  <option <?php if ($_POST['tipo'] == 'comics' ) echo 'selected' ; ?> value="Comic">Comics</option>
							  <option <?php if ($_POST['tipo'] == 'libros' ) echo 'selected' ; ?> value="Libro">Libro</option>
							  <option <?php if ($_POST['tipo'] == 'manga' ) echo 'selected' ; ?> value="Manga">Manga</option>
							  <option <?php if ($_POST['tipo'] == 'peliculas' ) echo 'selected' ; ?> value="Pelicula">Película</option>
							  <option <?php if ($_POST['tipo'] == 'series' ) echo 'selected' ; ?> value="Serie">Serie</option>
							  <option <?php if ($_POST['tipo'] == 'videojuegos' ) echo 'selected' ; ?> value="Videojuego">Videojuego</option>
							</select>
				        </div>

						-->
						
						<?php 
						if($_POST['tipo'] == 'anime' || $_POST['tipo'] == 'manga' || $_POST['tipo'] == 'series'){
							echo "<div id = 'annioFin'>";
								echo "	<label>Año de finalización (0 si no ha acabado):</label>";
								echo "	<input type = 'number' name='annioFin' id='id_annioFin' max = '2099' value= '$general[8]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'anime' || $_POST['tipo'] == 'series'){
							echo "<div id = 'temporadas'>";
								echo "<label>Temporadas:</label>";
								echo "<input type = 'number' name='temporadas' id='id_temporadas' min = '1' max = '100' value= '$general[9]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'anime'  || $_POST['tipo'] == 'series'){
							echo "<div id = 'capitulos'>";
								echo "<label>Capítulos:</label>";
								echo "<input type = 'number' name='capitulos' id='id_capitulos' min = '1' max = '1500' value= '$general[10]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'anime'){
							echo "<div id = 'estudio'>";
								echo "<label>Estudio:</label>";
								echo "<input type = 'text' name='estudio' id='id_estudio' value= '$general[11]' />";
							echo "</div>";
						}
						
						// if($_POST['tipo'] == 'anime' || $_POST['tipo'] == 'peliculas' || $_POST['tipo'] == 'series'){
							// echo "<div id = 'actor1'>";
								// echo "<label>Nombre del primer actor:</label>";
								// echo "<input type = 'text' name='actor1' id='id_actor1'/>";
								// echo "<label>Apellido del primer actor:</label>";
								// echo "<input type = 'text' name='actor1' id='id_actor1'/>";
							// echo "</div>";
						// }
						
						// if($_POST['tipo'] == 'anime' || $_POST['tipo'] == 'peliculas' || $_POST['tipo'] == 'series'){
							// echo "<div id = 'actor2'>";
								// echo "<label>Nombre del segundo actor:</label>";
								// echo "<input type = 'text' name='actor2' id='id_actor2'/>";
								// echo "<label>Apellido del segundo actor:</label>";
								// echo "<input type = 'text' name='actor2' id='id_actor2'/>";
							// echo "</div>";
						// }
						
						// if($_POST['tipo'] == 'peliculas'){
							// echo "<div id = 'director'>";
								// echo "<label>Nombre del director:</label>";
								// echo "<input type = 'text' name='director' id='id_director'/>";
								// echo "<label>Apellido del director:</label>";
								// echo "<input type = 'text' name='director' id='id_director'/>";
							// echo "</div>";
						// }
						
						// if($_POST['tipo'] == 'manga' || $_POST['tipo'] == 'libros' || $_POST['tipo'] == 'videojuegos' || $_POST['tipo'] == 'comics'){
							// echo "<div id = 'autor'";
								// echo "<label>Nombre del autor:</label>";
								// echo "<input type = 'text' name='autor' id='id_autor' value= '$personas[1]'/>";
								// echo "<label>Apellido del autor:</label>";
								// echo "<input type = 'text' name='autor' id='id_autor  value= '$personas[2]'/>";
							// echo "</div>";
						// }

						if($_POST['tipo'] == 'comics'){
							echo "<div id = 'numeros'>";
								echo "<label>Números:</label>";
								echo "<input type = 'number' name='numeros' id='id_numeros' min = '1' max = '1500'  value= '$general[8]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'comics' || $_POST['tipo'] == 'libros'){
							echo "<div id = 'editorial'>";
								echo "<label>Editorial:</label>";
								echo "<input type = 'text' name='editorial' id='id_editorial' value= '$general[9]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'comics'){
							echo "<div id = 'editorialOriginal'>";
								echo "<label>Editorial original:</label>";
								echo "<input type = 'text' name='editorialOriginal' id='id_editorialOriginal' value= '$general[10]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'libros'){
							echo "<div id = 'paginas'>";
								echo "<label>Páginas:</label>";
								echo "<input type = 'number' name='paginas' id='id_paginas' min = '1' max = '10000' value= '$general[8]'  />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'libros'){
							echo "<div id = 'isbn'>";
								echo "<label>ISBN:</label>";
								echo "<input type = 'number' name='isbn' id='id_isbn' min = '111111111111' max = '999999999999' value= '$general[9]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'manga'){
							echo "<div id = 'revista'>";
								echo "<label>Revista:</label>";
								echo "<input type = 'text' name='revista' id='id_revista' value= '$general[9]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'manga'){
							echo "<div id = 'tomo'>";
								echo "<label>Tomos:</label>";
								echo "<input type = 'number' name='tomo' id='id_tomo' min = '1' max = '1000' value= '$general[10]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'peliculas'){
							echo "<div id = 'duracion'>";
								echo "<label>Duración:</label>";
								echo "<input type = 'number' name='duracion' id='id_duracion' min = '1' max = '500' value= '$general[8]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'peliculas'){
							echo "<div id = 'productora'>";
								echo "<label>Productora:</label>";
								echo "<input type = 'text' name='productora' id='id_productora' value= '$general[9]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'series'){
							echo "<div id = 'canal'>";
								echo "<label>Canal:</label>";
								echo "<input type = 'text' name='canal' id='id_canal' value= '$general[11]' />";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'videojuegos'){
							echo "<div id = 'desarrolladora'>";
								echo "<label>Desarrolladora:</label>";
								echo "<input type = 'text' name='desarrolladora' id='id_desarrolladora' value= '$general[8]'/>";
							echo "</div>";
						}
						
						if($_POST['tipo'] == 'videojuegos'){
							echo "<div id = 'jugadores'>";
								echo "<label>Número de jugadores:</label>";
								echo "<input type = 'number' name='jugadores' id='id_jugadores' min = '1' max = '64'  value= '$general[9]'/>";
							echo "</div>";
						}

						if($_POST['tipo'] == 'videojuegos'){
							echo "<div id = 'online'>";
								echo "<label>Funciones online:</label>";
								echo "<select name='selectOnline'>";
								  echo "<option value='1'>Sí</option>";
								  echo "<option value='0' selected>No</option>";
								echo "</select>";
							echo "</div>";
						}
						
						?>
						
						<input type='hidden' name='item' value='<?php echo $_POST['item']; ?>'>
						<input type='hidden' name='tipo' value='<?php echo $_POST['tipo']; ?>'>
						
				        <input type = 'submit' name="accion" value = 'Aprobar' id = "boton"/>
						<input type = 'submit' name="accion" value = 'Eliminar' id = "boton"/>
				        <a href="index.php">Volver al inicio</a>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>