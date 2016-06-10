<?php
	session_start();
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Introducir nuevo artículo</title>
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
					<form action="introducirDatos.php" method="POST" id="datos" enctype="multipart/form-data">

				  		<div id = 'nombre'>
				            <label>Nombre:</label>
				            <input type = 'text' name='nombre' id='id_nombre'/>
				        </div>

				        <div id = 'sinopsis'>
				            <label>Sinopsis:</label>
				            <input type = 'text' name='sinopsis' id='id_sinopsis'/>
				        </div>

				        <div id = 'genero'>
				            <label>Género:</label>
				            <input type = 'text' name='genero' id='id_genero'/>
				        </div>

				        <div id = 'imagen'>
				            <label for="imagen">Subir imagen:</label>
				            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
				            <input type="file" name="imagen_usuario" id="imagen" />
				        </div>

				        <div id = 'annio'>
				            <label>Año:</label>
				            <input type = 'number' name='annio' id='id_annio' max = '2099' />
				        </div>

				        <div id = 'tipo'>
				            <label>Tipo:</label>
				            <select name="tipo" select = 'Seleciona'>
							  <option value="Anime">Anime</option>
							  <option value="Comic">Comics</option>
							  <option value="Libro">Libro</option>
							  <option value="Manga">Manga</option>
							  <option value="Pelicula">Película</option>
							  <option value="Serie">Serie</option>
							  <option value="Videojuego">Videojuego</option>
							</select>
				        </div>

				        <div id = 'annioFin' class = "anime manga serie">
				            <label>Año de finalización (0 si no ha acabado):</label>
				            <input type = 'number' name='annioFin' id='id_annioFin' max = '2099' value= '0' />
				        </div>

				         <div id = 'temporadas' class = "anime serie">
				            <label>Temporadas:</label>
				            <input type = 'number' name='temporadas' id='id_temporadas' min = '1' max = '100' value= '1' />
				        </div>

				        <div id = 'capitulos' class = "anime serie manga">
				            <label>Capítulos:</label>
				            <input type = 'number' name='capitulos' id='id_capitulos' min = '1' max = '1500' value= '1' />
				        </div>

				        <div id = 'estudio' class = "anime">
				            <label>Estudio:</label>
				            <input type = 'text' name='estudio' id='id_estudio'/>
				        </div>

				        <div id = 'actor1' class = "anime serie pelicula">
				            <label>Nombre del primer actor:</label>
				            <input type = 'text' name='actor1' id='id_actor1'/>
				            <label>Apellido del primer actor:</label>
				            <input type = 'text' name='actor1' id='id_actor1'/>
				        </div>

				        <div id = 'actor2' class = "anime serie pelicula">
				            <label>Nombre del segundo actor:</label>
				            <input type = 'text' name='actor2' id='id_actor2'/>
				            <label>Apellido del segundo actor:</label>
				            <input type = 'text' name='actor2' id='id_actor2'/>
				        </div>

				        <div id = 'director' class = "pelicula">
				            <label>Nombre del director:</label>
				            <input type = 'text' name='director' id='id_director'/>
				            <label>Apellido del director:</label>
				            <input type = 'text' name='director' id='id_director'/>
				        </div>

				        <div id = 'autor' class = "manga libro videojuego comic">
				            <label>Nombre del autor:</label>
				            <input type = 'text' name='autor' id='id_autor'/>
				            <label>Apellido del autor:</label>
				            <input type = 'text' name='autor' id='id_autor'/>
				        </div>

				        <div id = 'numeros' class = "comic">
				            <label>Números:</label>
				            <input type = 'number' name='numeros' id='id_numeros' min = '1' max = '1500' value= '1' />
				        </div>

				        <div id = 'editorial' class = "comic libro">
				            <label>Editorial:</label>
				            <input type = 'text' name='editorial' id='id_editorial'/>
				        </div>

				        <div id = 'editorialOriginal' class = "comic">
				            <label>Editorial original:</label>
				            <input type = 'text' name='editorialOriginal' id='id_editorialOriginal'/>
				        </div>

				        <div id = 'paginas' class = "libro">
				            <label>Páginas:</label>
				            <input type = 'number' name='paginas' id='id_paginas' min = '1' max = '10000' value= '1' />
				        </div>

				        <div id = 'isbn' class = "libro">
				            <label>ISBN:</label>
				            <input type = 'number' name='isbn' id='id_isbn' min = '111111111111' max = '999999999999' />
				        </div>

				        <div id = 'revista' class = "manga">
				            <label>Revista:</label>
				            <input type = 'text' name='revista' id='id_revista'/>
				        </div>

				        <div id = 'tomo' class = "manga">
				            <label>Tomos:</label>
				            <input type = 'number' name='tomo' id='id_tomo' min = '1' max = '1000' value = '1'/>
				        </div>

				        <div id = 'duracion' class = "pelicula">
				            <label>Duración:</label>
				            <input type = 'number' name='duracion' id='id_duracion' min = '1' max = '500' />
				        </div>

				        <div id = 'productora' class = "pelicula">
				            <label>Productora:</label>
				            <input type = 'text' name='productora' id='id_productora'/>
				        </div>

				        <div id = 'canal' class = "serie">
				            <label>Canal:</label>
				            <input type = 'text' name='canal' id='id_canal'/>
				        </div>

				        <div id = 'desarrolladora' class = "videojuego">
				            <label>Desarrolladora:</label>
				            <input type = 'text' name='desarrolladora' id='id_desarrolladora'/>
				        </div>

				        <div id = 'jugadores' class = "videojuego">
				            <label>Número de jugadores:</label>
				            <input type = 'number' name='jugadores' id='id_jugadores' min = '1' max = '64' />
				        </div>

						<div id = 'online' class = "videojuego">
				            <label>Funciones online:</label>
				            <select name="selectOnline">
							  <option value="si">Sí</option>
							  <option value="no" selected>No</option>
							</select>
				        </div>

				        <input type = 'submit' value = 'Añadir' id = "boton"/>
				        <a href="index.php">Volver al inicio</a>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
