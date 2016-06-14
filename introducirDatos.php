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
	          		$consulta = "INSERT INTO general (Nombre,Sinopsis,Nota,Genero,Imagen,Annio,Aprobado) VALUES ('$nombre', '$sinopsis','0','$genero','0',$annio,'false')";
	              	$conex->refresh($consulta);
	              	 $codigo = $conex->consult("SELECT MAX(codigo) from general");
	              	 $codigo = $codigo[0][0];
	              	 $conex->refresh("UPDATE general SET Imagen = 'img$codigo' where Codigo = '$codigo'");

				   if ($_FILES['imagenProducto']["name"] != "" ){
	                    $size = ($_FILES['imagenProducto']['size']);
	                    if($size <= 7000000 && $size > 0){ //por si supera el tamaño permitido
	                      $nombreImagen = $_FILES["imagenProducto"]["name"];
	                      $nombreEXtension = explode('.', $nombreImagen);
	                      $extension = end($nombreEXtension);
	 
	                      	if ($extension == 'jpg' || $extension == 'png'){
	                      
		                        $archivo_temporal = $_FILES['imagenProducto']['tmp_name']; 
		            
		                   		
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
		                        }else{
									$fallido = true;
			                        echo "<div>Formato no válido.</div>";
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


					switch($tipo){
					      case "Serie":
					        $annioFin = $_POST["annioFin"];
					        $temporadas = $_POST["temporadas"];
					        $capitulos = $_POST["capitulos"];
					     	$nombreActor1 = $_POST["nombreActor1"];
					     	$apellidoActor1 = $_POST["apellidoActor1"];
					        $nombreActor2 = $_POST["nombreActor2"];
					        $apellidoActor2 = $_POST["apellidoActor2"];
					        $canal = $_POST["canal"];

					        $consulta2 = "INSERT INTO series (Codigo,AnnioFin,Temporadas,Capitulos,Canal) VALUES ('$codigo','$annioFin','$temporadas','$capitulos','$canal')";
					        $conex->refresh($consulta2);

					        if($conex->comprobarPersona($nombreActor1,$apellidoActor1) == 0){
					        	$consulta3 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreActor1','$apellidoActor1')";
					        	$conex->refresh($consulta3);
					        	$codigoPersona1 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona1 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreActor1' and Apellido = '$apellidoActor1'");
					        }
	              	 			$codigoPersona1 = $codigoPersona1[0][0];
					        	$consulta4 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona1','$codigo','Actor')";
					        	$conex->refresh($consulta4);

					        if($conex->comprobarPersona($nombreActor2,$apellidoActor2) == 0){
					        	$consulta5 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreActor2','$apellidoActor2')";
					        	$conex->refresh($consulta5);
					        	$codigoPersona2 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona2 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreActor2' and Apellido = '$apellidoActor2'");
					        }
	              	 			$codigoPersona2 = $codigoPersona2[0][0];
					        	$consulta6 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona2','$codigo','Actor')";
					        	$conex->refresh($consulta6);
					        
					      break;

					      case "Manga":
					      	$annioFin = $_POST["annioFin"];
					      	$nombreAutor = $_POST["nombreAutor"];
					      	$apellidoAutor = $_POST["apellidoAutor"];
					      	$revista = $_POST["revista"];
					      	$tomo = $_POST["tomo"];

					        $consulta2 = "INSERT INTO manga (Codigo,AnnioFin,Revista,Tomos) VALUES ('$codigo','$annioFin','$revista','$tomo')";
					        $conex->refresh($consulta2);

					        if($conex->comprobarPersona($nombreAutor,$apellidoAutor) == 0){
					        	$consulta3 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreAutor','$apellidoAutor')";
					        	$conex->refresh($consulta3);
					        	$codigoPersona1 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona1 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreAutor' and Apellido = '$apellidoAutor'");
					        }
	              	 			$codigoPersona1 = $codigoPersona1[0][0];
					        	$consulta4 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona1','$codigo','Autor')";
					        	$conex->refresh($consulta4);

					      break;
					      case "Videojuego":
					      	$nombreAutor = $_POST["nombreAutor"];
					      	$apellidoAutor = $_POST["apellidoAutor"];
					    	$desarrolladora = $_POST["desarrolladora"];
					    	$jugadores = $_POST["jugadores"];
					    	$online = $_POST["selectOnline"];
					    	$plataformas = $_POST["plataformas"];

					  		$consulta2 = "INSERT INTO videojuegos (Codigo,Desarrolladora,NumJugadores,Online) VALUES ('$codigo','$desarrolladora','$jugadores','$online')";
					        $conex->refresh($consulta2);

					        if($conex->comprobarPersona($nombreAutor,$apellidoAutor) == 0){
					        	$consulta3 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreAutor','$apellidoAutor')";
					        	$conex->refresh($consulta3);
					        	$codigoPersona1 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona1 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreAutor' and Apellido = '$apellidoAutor'");	
					        }
	              	 			$codigoPersona1 = $codigoPersona1[0][0];
					        	$consulta4 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona1','$codigo','Autor')";
					        	$conex->refresh($consulta4);

					        foreach ($plataformas as $plataforma) {
					        	$consultaP = "INSERT INTO plataformas (Codigo,Plataforma) VALUES ('$codigo','$plataforma')";
					        	$conex->refresh($consultaP);
					        }

					      break;
					      case "Pelicula":
					     	$nombreActor1 = $_POST["nombreActor1"];
					     	$apellidoActor1 = $_POST["apellidoActor1"];
					        $nombreActor2 = $_POST["nombreActor2"];
					        $apellidoActor2 = $_POST["apellidoActor2"];
					        $nombreDirector = $_POST["nombreDirector"];
					        $apellidoDirector = $_POST["apellidoDirector"];
					        $duracion = $_POST["duracion"];
					        $productora = $_POST["productora"];

					  		$consulta2 = "INSERT INTO peliculas (Codigo,Duracion,Productora) VALUES ('$codigo','$duracion','$productora')";
					        $conex->refresh($consulta2);

					        if($conex->comprobarPersona($nombreActor1,$apellidoActor1) == 0){
					        	$consulta3 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreActor1','$apellidoActor1')";
					        	$conex->refresh($consulta3);
					        	$codigoPersona1 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona1 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreActor1' and Apellido = '$apellidoActor1'");
					        }
	              	 			$codigoPersona1 = $codigoPersona1[0][0];
					        	$consulta4 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona1','$codigo','Actor')";
					        	$conex->refresh($consulta4);

					        if($conex->comprobarPersona($nombreActor2,$apellidoActor2) == 0){
					        	$consulta5 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreActor2','$apellidoActor2')";
					        	$conex->refresh($consulta5);
					        	$codigoPersona2 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona2 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreActor2' and Apellido = '$apellidoActor2'");
					        }
	              	 			$codigoPersona2 = $codigoPersona2[0][0];
					        	$consulta6 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona2','$codigo','Actor')";
					        	$conex->refresh($consulta6);

					        if($conex->comprobarPersona($nombreDirector,$apellidoDirector) == 0){
					        	$consulta7 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreDirector','$apellidoDirector')";
					        	$conex->refresh($consulta7);
					        	$codigoPersona1 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona1 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreDirector' and Apellido = '$apellidoDirector'");
					        }
	              	 			$codigoPersona1 = $codigoPersona1[0][0];
					        	$consulta8 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona1','$codigo','Director')";
					        	$conex->refresh($consulta8);

					      break;
					      case "Anime":
					      	$annioFin = $_POST["annioFin"];
					      	$temporadas = $_POST["temporadas"];
					      	$capitulos = $_POST["capitulos"];
					      	$estudio = $_POST["estudio"];
					     	$nombreActor1 = $_POST["nombreActor1"];
					     	$apellidoActor1 = $_POST["apellidoActor1"];
					        $nombreActor2 = $_POST["nombreActor2"];
					        $apellidoActor2 = $_POST["apellidoActor2"];

					        $consulta2 = "INSERT INTO anime (Codigo,AnnioFin,Temporadas,Capitulos,Estudio) VALUES ('$codigo','$annioFin','$temporadas','$capitulos','$estudio')";
					        $conex->refresh($consulta2);

					        if($conex->comprobarPersona($nombreActor1,$apellidoActor1) == 0){
					        	$consulta3 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreActor1','$apellidoActor1')";
					        	$conex->refresh($consulta3);
					        	$codigoPersona1 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona1 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreActor1' and Apellido = '$apellidoActor1'");
					        }
	              	 			$codigoPersona1 = $codigoPersona1[0][0];
					        	$consulta4 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona1','$codigo','Actor')";
					        	$conex->refresh($consulta4);

					        if($conex->comprobarPersona($nombreActor2,$apellidoActor2) == 0){
					        	$consulta5 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreActor2','$apellidoActor2')";
					        	$conex->refresh($consulta5);
					        	$codigoPersona2 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona2 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreActor2' and Apellido = '$apellidoActor2'");
					        }
	              	 			$codigoPersona2 = $codigoPersona2[0][0];
					        	$consulta6 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona2','$codigo','Actor')";
					        	$conex->refresh($consulta6);

					      break;
					      case "Comic":
					      	$nombreAutor = $_POST["nombreAutor"];
					      	$apellidoAutor = $_POST["apellidoAutor"];
					        $numeros = $_POST["numeros"];
					        $editorial = $_POST["editorial"];
					        $editorialOriginal = $_POST["editorialOriginal"];

					        $consulta2 = "INSERT INTO comics (Codigo,Numeros,Editorial,EditorialOriginal) VALUES ('$codigo','$numeros','$editorial','$editorialOriginal')";
					        $conex->refresh($consulta2);

					        if($conex->comprobarPersona($nombreAutor,$apellidoAutor) == 0){
					        	$consulta3 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreAutor','$apellidoAutor')";
					        	$conex->refresh($consulta3);
					        	$codigoPersona1 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona1 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreAutor' and Apellido = '$apellidoAutor'");
					        }
	              	 			$codigoPersona1 = $codigoPersona1[0][0];
					        	$consulta4 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona1','$codigo','Autor')";
					        	$conex->refresh($consulta4);

					      break;
					      case "Libro":
					      	$nombreAutor = $_POST["nombreAutor"];
					      	$apellidoAutor = $_POST["apellidoAutor"];
					  		$editorial = $_POST["editorial"];
					  		$paginas = $_POST["paginas"];
					  		$isbn = $_POST["isbn"];

					  		$consulta2 = "INSERT INTO libros (Codigo,Paginas,ISBN,Editorial) VALUES ('$codigo','$paginas','$isbn','$editorial')";
					        $conex->refresh($consulta2);

					        if($conex->comprobarPersona($nombreAutor,$apellidoAutor) == 0){
					        	$consulta3 = "INSERT INTO personas (Nombre,Apellido) VALUES ('$nombreAutor','$apellidoAutor')";
					        	$conex->refresh($consulta3);
					        	$codigoPersona1 = $conex->consult("SELECT MAX(CodigoPersona) from personas");
					        }else{
					        	$codigoPersona1 = $conex->consult("SELECT CodigoPersona from personas where Nombre = '$nombreAutor' and Apellido = '$apellidoAutor'");
					        }
	              	 			$codigoPersona1 = $codigoPersona1[0][0];
					        	$consulta4 = "INSERT INTO rol (CodigoPersona,Codigo,Rol) VALUES ('$codigoPersona1','$codigo','Autor')";
					        	$conex->refresh($consulta4);

					      break;
		            }

		            echo "<div>La introducción de datos ha sido correcta. Espera a que un administrador la apruebe para visualizarla</div>";
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
				            <input type="file" name="imagenProducto" id="imagen" required/>
				        </div>

				        <div id = 'annio'>
				            <label>Año:</label>
				            <input type = 'number' name='annio' id='id_annio' max = '2099' required/>
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

				        <div id = 'annioFin' class = "anime manga serie">
				            <label>Año de finalización (0 si no ha acabado):</label>
				            <input type = 'number' name='annioFin' id='id_annioFin' max = '2099' value= '0' class = "anime manga serie" />
				        </div>

				         <div id = 'temporadas' class = "anime serie">
				            <label>Temporadas:</label>
				            <input type = 'number' name='temporadas' id='id_temporadas' min = '1' max = '100' value= '1' class = "anime serie"/>
				        </div>

				        <div id = 'capitulos' class = "anime serie">
				            <label>Capítulos:</label>
				            <input type = 'number' name='capitulos' id='id_capitulos' min = '1' max = '1500' value= '1' class = "anime serie" />
				        </div>

				        <div id = 'estudio' class = "anime">
				            <label>Estudio:</label>
				            <input type = 'text' name='estudio' id='id_estudio' class = "anime"/>
				        </div>

				        <div id = 'actor1' class = "anime serie pelicula">
				            <label>Nombre del primer actor:</label>
				            <input type = 'text' name='nombreActor1' id='id_actor1' class = "anime serie pelicula" />
				            <label>Apellido del primer actor:</label>
				            <input type = 'text' name='apellidoActor1' id='id_actor1' class = "anime serie pelicula"/>
				        </div>

				        <div id = 'actor2' class = "anime serie pelicula">
				            <label>Nombre del segundo actor:</label>
				            <input type = 'text' name='nombreActor2' id='id_actor2' class = "anime serie pelicula"/>
				            <label>Apellido del segundo actor:</label>
				            <input type = 'text' name='apellidoActor2' id='id_actor2' class = "anime serie pelicula"/>
				        </div>

				        <div id = 'director' class = "pelicula">
				            <label>Nombre del director:</label>
				            <input type = 'text' name='nombreDirector' id='id_director' class = "pelicula"/>
				            <label>Apellido del director:</label>
				            <input type = 'text' name='apellidoDirector' id='id_director' class = "pelicula" />
				        </div>

				        <div id = 'autor' class = "manga libro videojuego comic">
				            <label>Nombre del autor:</label>
				            <input type = 'text' name='nombreAutor' id='id_autor' class = "manga libro videojuego comic"/>
				            <label>Apellido del autor:</label>
				            <input type = 'text' name='apellidoAutor' id='id_autor' class = "manga libro videojuego comic"/>
				        </div>

				        <div id = 'numeros' class = "comic">
				            <label>Números:</label>
				            <input type = 'number' name='numeros' id='id_numeros' min = '1' max = '1500' value= '1' class = "comic"/>
				        </div>

				        <div id = 'editorial' class = "comic libro">
				            <label>Editorial:</label>
				            <input type = 'text' name='editorial' id='id_editorial' class = "comic libro"/>
				        </div>

				        <div id = 'editorialOriginal' class = "comic">
				            <label>Editorial original:</label>
				            <input type = 'text' name='editorialOriginal' id='id_editorialOriginal' class = "comic"/>
				        </div>

				        <div id = 'paginas' class = "libro">
				            <label>Páginas:</label>
				            <input type = 'number' name='paginas' id='id_paginas' min = '1' max = '10000' value= '1' class = "libro"/>
				        </div>

				        <div id = 'isbn' class = "libro">
				            <label>ISBN:</label>
				            <input type = 'number' name='isbn' id='id_isbn' min = '111111111111' max = '999999999999' class = "libro"/>
				        </div>

				        <div id = 'plataformas' class = "videojuego">
				            <label>Elige tus plataformas:</label>
				          	<input type="checkbox" name="plataformas[]" value="NES" >NES
				            <input type="checkbox" name="plataformas[]" value="SNES" >SNES
						    <input type="checkbox" name="plataformas[]" value="Nintendo64" >Nintendo64
						    <input type="checkbox" name="plataformas[]" value="GameCube" >GameCube
						    <input type="checkbox" name="plataformas[]" value="Wii" >Wii
						    <input type="checkbox" name="plataformas[]" value="WiiU" >WiiU
						    <input type="checkbox" name="plataformas[]" value="GameBoy" >GameBoy
						    <input type="checkbox" name="plataformas[]" value="GameBoy Color" >GameBoy Color
						    <input type="checkbox" name="plataformas[]" value="GameBoy Advanced" >GameBoy Advanced
						    <input type="checkbox" name="plataformas[]" value="DS" >DS
						    <input type="checkbox" name="plataformas[]" value="3DS" >3DS
						    <input type="checkbox" name="plataformas[]" value="Xbox" >XBOX
						    <input type="checkbox" name="plataformas[]" value="Xbox 360" >XBOX 360
						    <input type="checkbox" name="plataformas[]" value="Xbox One" >XBOX One
						    <input type="checkbox" name="plataformas[]" value="PSX" >PSX
						    <input type="checkbox" name="plataformas[]" value="PS2" >PS2
						    <input type="checkbox" name="plataformas[]" value="PS3" >PS3
						    <input type="checkbox" name="plataformas[]" value="PS4" >PS4
						    <input type="checkbox" name="plataformas[]" value="PSP" >PSP
						    <input type="checkbox" name="plataformas[]" value="MasterSystem" >MasterSystem
						    <input type="checkbox" name="plataformas[]" value="Megadrive" >Megadrive
						    <input type="checkbox" name="plataformas[]" value="Saturn" >Saturn
						    <input type="checkbox" name="plataformas[]" value="Dreamcast" >Dreamcast
						    <input type="checkbox" name="plataformas[]" value="Gamegear" >Gamegear
						    <input type="checkbox" name="plataformas[]" value="Steam" >Steam
				        </div>

				        <div id = 'revista' class = "manga">
				            <label>Revista:</label>
				            <input type = 'text' name='revista' id='id_revista' class = "manga"/>
				        </div>

				        <div id = 'tomo' class = "manga">
				            <label>Tomos:</label>
				            <input type = 'number' name='tomo' id='id_tomo' min = '1' max = '1000' value = '1' class = "manga"/>
				        </div>

				        <div id = 'duracion' class = "pelicula">
				            <label>Duración:</label>
				            <input type = 'number' name='duracion' id='id_duracion' min = '1' max = '500' class = "pelicula"/>
				        </div>

				        <div id = 'productora' class = "pelicula">
				            <label>Productora:</label>
				            <input type = 'text' name='productora' id='id_productora' class = "pelicula"/>
				        </div>

				        <div id = 'canal' class = "serie">
				            <label>Canal:</label>
				            <input type = 'text' name='canal' id='id_canal' class = "serie"/>
				        </div>

				        <div id = 'desarrolladora' class = "videojuego">
				            <label>Desarrolladora:</label>
				            <input type = 'text' name='desarrolladora' id='id_desarrolladora' class = "videojuego"/>
				        </div>

				        <div id = 'jugadores' class = "videojuego">
				            <label>Número de jugadores:</label>
				            <input type = 'number' name='jugadores' id='id_jugadores' min = '1' max = '64' class = "videojuego"/>
				        </div>

						<div id = 'online' class = "videojuego">
				            <label>Funciones online:</label>
				            <select name="selectOnline" class = "videojuego">
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
