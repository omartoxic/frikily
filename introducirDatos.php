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
		<script type="text/javascript" src="modificardatos.js"></script>
	</head>
	
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
							if(!isset($_SESSION['usuario'])){
								echo "<li><a href='inicioSesion.php'>iniciar sesión</a></li>";
							}else{
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
		<?php
		include "basedatos.php";
		$conex=new Conexion("root","","frikily");
		$conex->connect();

		if(isset($_POST["tipo"])){
			$nombre = $_POST["nombre"];
			$sinopsis = $_POST["sinopsis"];
			$genero = $_POST["genero"];
			$annio = $_POST["annio"];
			$tipo = $_POST["tipo"];
			$codigo = 0;
			$fallido = false;


			$imagenes_permitidas = Array('image/jpeg','image/png'); //tipos mime permitidos
          	$ruta = "./imagenes/img";//ruta carpeta donde queremos copiar las imágenes

          	if (isset($_FILES['imagenProducto'])){
			   if ($_FILES['imagenProducto']["name"] != "" ){
                    $size = ($_FILES['imagenProducto']['size']);
                    if($size <= 7000000 && $size > 0){ //por si supera el tamaño permitido
                      $nombreImagen = $_FILES["imagenProducto"]["name"];
                      $extension = end(explode('.', $nombreImagen));
 
                      if ($extension == 'jpg' || $extension == 'png'){
                      
                        $archivo_temporal = $_FILES['imagenProducto']['tmp_name']; 
                        $codigo = $conex->consult("SELECT MAX(codigo) from general");
                   		$codigo = $codigo[0][0] + 1;
                        $archivo_nombre = $ruta.$codigo.".jpg"; 
                        $tamanio = getimagesize($archivo_temporal);

                          if ($tamanio){
                            if(in_array($tamanio['mime'], $imagenes_permitidas)){
                                if (is_uploaded_file($archivo_temporal)){ 
                                  if ($_FILES['imagenProducto']['size'] < 7000000){
                                    move_uploaded_file($archivo_temporal,$archivo_nombre); 
                                  }else{
                                    $fallido = true;
                                    echo "<div>El tamaño excede el permitido.</div>";
                                  }
                                }else{ 
                                  $fallido = true;
                                  echo "<div>Error en la subida. Inténtalo de nuevo.</div>"; 
                                } 
                            }else{
                              $fallido = true;
                              echo "<div>Formato de imagen no válido. Solo están permitidas en formato jpg y png.</div>";
                            }
                          }
                      }else{
                        $fallido = true;
                        echo "<div>Formato no válido.</div>";
                      }
                    }else{
                      $fallido = true;
                      echo "<div>Error con la subida. Puede que el formato no sea reconodible o el tamaño muy grande. Inténtalo de nuevo o con otra imagen en formato jpg o png</div>";
                    }
                  }
              }


              if (!$fallido){
              	$img = "img".$codigo;
              	$consulta = "INSERT INTO general (Nombre,Sinopsis,Nota,Genero,Imagen,Annio,Aprobado) VALUES ('$nombre', '$sinopsis','0','$genero','$img',$annio,'false')";
              	$conex->refresh($consulta);

				switch(tipo){
				      case "Serie":
				        $annioFin = $_POST["annioFin"];
				        $temporadas = $_POST["temporadas"];
				        $capitulos = $_POST["capitulos"];
				        $actor1 = $_POST["actor1"];
				        $actor2 = $_POST["actor2"];
				        $autor = $_POST["autor"];
				        $canal = $_POST["canal"];
				        
				        $conex->refresh($consulta2);
				      break;
				      case "Manga":
				      	$annioFin = $_POST["annioFin"];
				      	$capitulos = $_POST["capitulos"];
				      	$autor = $_POST["autor"];
				      	$revista = $_POST["revista"];
				      	$tomo = $_POST["tomo"];
				      break;
				      case "Videojuego":
				    	$autor = $_POST["autor"];
				    	$desarrolladora = $_POST["desarrolladora"];
				    	$jugadores = $_POST["jugadores"];
				    	$online = $_POST["online"];
				      break;
				      case "Pelicula":
				     	$actor1 = $_POST["actor1"];
				        $actor2 = $_POST["actor2"];
				        $director = $_POST["director"];
				        $duracion = $_POST["duracion"];
				        $productora = $_POST["productora"];
				      break;
				      case "Anime":
				      	$annioFin = $_POST["annioFin"];
				      	$temporadas = $_POST["temporadas"];
				      	$capitulos = $_POST["capitulos"];
				      	$estudio = $_POST["estudio"];
				      	$actor1 = $_POST["actor1"];
				        $actor2 = $_POST["actor2"];
				      break;
				      case "Comic":
				        $autor = $_POST["autor"];
				        $numeros = $_POST["numeros"];
				        $editorial = $_POST["editorial"];
				        $editorialOriginal = $_POST["editorialOriginal"];
				      break;
				      case "Libro":
				  		$autor = $_POST["autor"];
				  		$editorial = $_POST["editorial"];
				  		$paginas = $_POST["paginas"];
				  		$isbn = $_POST["isbn"];
				      break;
	            }
		}
	?>

					<form action="introducirDatos.php" method="POST" id="datos" enctype="multipart/form-data">

				  		<div id = 'nombre'>
				            <label>Nombre:</label>
				            <input type = 'text' name='nombre' id='id_nombre' required/>
				        </div>

				        <div id = 'sinopsis'>
				            <label>Sinopsis:</label>
				            <input type = 'text' name='sinopsis' id='id_sinopsis' required/>
				        </div>

				        <div id = 'genero'>
				            <label>Género:</label>
				            <input type = 'text' name='genero' id='id_genero' required/>
				        </div>

				        <div id = 'imagen'>
				            <label for="imagen">Subir imagen:</label>
				            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
				            <input type="file" name="imagenProducto" id="imagenP" required />
				        </div>

				        <div id = 'annio'>
				            <label>Año:</label>
				            <input type = 'number' name='annio' id='id_annio' max = '2099' required />
				        </div>

				        <div id = 'tipo'>
				            <label>Tipo:</label>
				            <select name="tipo" select = 'Seleciona' required>
				            <option disabled selected value> -- Selecciona una categoría -- </option>
							  <option value="Anime">Anime</option>
							  <option value="Comic">Comics</option>
							  <option value="Libro">Libro</option>
							  <option value="Manga">Manga</option>
							  <option value="Pelicula">Película</option>
							  <option value="Serie">Serie</option>
							  <option value="Videojuego">Videojuego</option>
							</select>
				        </div>

				        <div id = 'annioFin' class = "anime manga serie" required>
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