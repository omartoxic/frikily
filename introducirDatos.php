<?php
	session_start();
	include "basedatos.php";
	$conex=new Conexion("root","","frikily");
	$conex->connect();
	if(isset($_SESSION['usuario']))
	{
		$notifi = $conex->notificaciones();
	}
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
		<script type="text/javascript" src="introducirdatos.js"></script>
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
					<span class="navbar-brand"><a class='enlace-principal' href='index.php'>Friki.ly</a></span>
				</div>
				<div class="navbar-collapse collapse navbar-ex1-collapse">


					<form action="lista.php" method="post">
						<ul id="paginacion" class="nav navbar-nav">
							<li><button class="barra btn btn-link" type="submit" name="ver" value="videojuegos">Videojuegos</button></li>
							<li><button class="barra btn btn-link" type="submit" name="ver" value="anime">Anime</button></li>
							<li><button class="barra btn btn-link" type="submit" name="ver" value="manga">Manga</button></li>
							<li><button class="barra btn btn-link" type="submit" name="ver" value="comics">Cómics</button></li>
							<li><button class="barra btn btn-link" type="submit" name="ver" value="libros">Libros</button></li>
							<li><button class="barra btn btn-link" type="submit" name="ver" value="peliculas">Películas</button></li>
							<li><button class="barra btn btn-link" type="submit" name="ver" value="series">Series</button></li>
							<?php
								if(isset($_SESSION['usuario']))
								{
									echo "<li><a href='introducirDatos.php'>Añadir</a></li>";

									$admn=$conex->consult("SELECT tipo from usuarios where codusuario=".$_SESSION['codigo']);
									if($admn[0][0]=="admn"){
										echo "<li><a href='administrar.php'>Administrar</a></li>";
									}
								}


							?>
						</ul>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<li>

						</li>
						<?php
							if(!isset($_SESSION['usuario']))
							{
								echo "<li><a class='btn btn-link' href='inicioSesion.php'>Iniciar sesión</a></li>";
							}
							else
							{
								if($notifi!=0){
									echo "<li><a href='notificaciones.php'><i class='fa fa-envelope fa-2x faa-flash animated faa-slow' style='color:#58ACFA'> ".$notifi."</i></a></li>";
								}
								echo "<li class='usuario'>";
								echo "<span class='nombre-usuario'>".$_SESSION['usuario']."&nbsp;&nbsp;</span>";
								echo "<img class='imagen-usu img-rounded' src='imagenesusuarios/".$_SESSION['imgusu']."?comodin=".rand(1,1000)."'>&nbsp;";
								echo '<li><div class="dropdown">';
								echo '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
								echo '<i class="glyphicon glyphicon-option-vertical"></i>';
								echo '</button>';
							  echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';
								echo '<li><form action="index.php" method="post"><button type="submit" id="cerrarSesion" class="btn btn-default" name="action" value="Cerrar sesión">Cerrar sesión</button></form></li>';
								echo '<li><a class="btn btn-default" href="modificarDatos.php">Modificar datos</a></li>';
								echo '</ul>';
								echo '</div></li>';
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
		                                    	echo "<h3 class='titulo'>El tamaño excede el permitido.</h3>";
		                                  	}
		                                }else{
		                                  $fallido = true;
		                                  echo "<h3 class='titulo'>Error en la subida. Inténtalo de nuevo.</h3>";
		                                }
		                            }else{
		                              $fallido = true;
		                              echo "<h3 class='titulo'>Formato de imagen no válido. Solo están permitidas en formato jpg y png.</h3>";
		                            }
		                        }else{
									$fallido = true;
			                        echo "<h3 class='titulo'>Formato no válido.</h3>";
		                        }
		                    }else{
			                    $fallido = true;
			                    echo "<h3 class='titulo'>Formato no válido.</h3>";
			                }
		                }else{
		                    $fallido = true;
		                    echo "<h3 class='titulo'>Error con la subida. Puede que el formato no sea reconodible o el tamaño muy grande. Inténtalo de nuevo o con otra imagen en formato jpg o png</h3>";
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

		            echo "<h3 class='titulo'>La introducción de datos ha sido correcta. Espera a que un administrador la apruebe para visualizarla</h3>";
				}
			}
	?>

					<form action="introducirDatos.php" class="container" method="POST" id="datos" enctype="multipart/form-data">

				  		<div class="row" id = 'nombre'>
				            <label class="col-xs-2 col-xs-offset-2">
											Nombre:
										</label>
										<div class="col-xs-6">
				            	<input class="form-control" type = 'text' name='nombre' id='id_nombre' required/>
										</div>
				        </div>

				        <div class="row" id = 'sinopsis'>
				            <label class="col-xs-2 col-xs-offset-2">
											Sinopsis:
										</label>
										<div class="col-xs-6">
				            	<textarea name='sinopsis' rows='10' class='form-control' cols='40'maxlength = '600' required>Sinopsis</textarea>
										</div>
				        </div>

				        <div class="row" id = 'genero'>
				            <label class="col-xs-2 col-xs-offset-2">
											Género:
										</label>
										<div class="col-xs-6">
				            	<input class='form-control' type = 'text' name='genero' id='id_genero' required/>
										</div>
				        </div>

				        <div class="row" id = 'imagen'>
				            <label class="col-xs-2 col-xs-offset-2">
											Subir imagen:
										</label>
				            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
										<div class="col-xs-6">
				            	<input type="file" name="imagenProducto" id="imagen" required/>
										</div>
				        </div>

				        <div class="row" id = 'annio'>
				            <label class="col-xs-2 col-xs-offset-2">
											Año:
										</label>
										<div class="col-xs-6">
				            	<input class='form-control' type = 'number' name='annio' id='id_annio' max = '2099' required/>
										</div>
				        </div>

				        <div class="row" id = 'tipo'>
				            <label class="col-xs-2 col-xs-offset-2">
											Tipo:
										</label>
										<div class="col-xs-6">
					            <select class='form-control' name="tipo" select = 'Seleciona' required>
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
				        </div>

				        <div id = 'annioFin' class = "row anime manga serie">
				            <label class="col-xs-2 col-xs-offset-2">
											Año de finalización (0 si no ha acabado):
										</label>
										<div class="col-xs-6">
				            	<input type = 'number' name='annioFin' id='id_annioFin' max = '2099' value= '0' class = "form-control anime manga serie" />
										</div>
				        </div>

				         <div id = 'temporadas' class = "row anime serie">
				            <label class="col-xs-2 col-xs-offset-2">
											Temporadas:
										</label>
										<div class="col-xs-6">
				            	<input type = 'number' name='temporadas' id='id_temporadas' min = '1' max = '100' value= '1' class = "form-control anime serie"/>
										</div>
				        </div>

				        <div id = 'capitulos' class = "row anime serie">
				            <label class="col-xs-2 col-xs-offset-2">
											Capítulos:
										</label>
										<div class="col-xs-6">
				            	<input type = 'number' name='capitulos' id='id_capitulos' min = '1' max = '1500' value= '1' class = "form-control anime serie" />
										</div>
								</div>

				        <div id = 'estudio' class = "row anime">
				            <label class="col-xs-2 col-xs-offset-2">
											Estudio:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='estudio' id='id_estudio' class = "form-control anime"/>
										</div>
				        </div>

				        <div id = 'actor1' class = "row anime serie pelicula">
										<div class="row">
					            <label class="col-xs-2 col-xs-offset-2">
												Nombre del primer actor:
											</label>
											<div class="col-xs-6">
					            	<input type = 'text' name='nombreActor1' id='id_actor1' class = "form-control anime serie pelicula" />
											</div>
										</div>
										<div class="row">
					            <label class="col-xs-2 col-xs-offset-2">
												Apellido del primer actor:
											</label>
											<div class="col-xs-6">
					            	<input type = 'text' name='apellidoActor1' id='id_actor1' class = "form-control anime serie pelicula"/>
											</div>
										</div>
				        </div>

				        <div id = 'actor2' class = "row anime serie pelicula">
									<div class="row">
				            <label class="col-xs-2 col-xs-offset-2">
											Nombre del segundo actor:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='nombreActor2' id='id_actor2' class = "form-control anime serie pelicula"/>
										</div>
									</div>
									<div class="row">
				            <label class="col-xs-2 col-xs-offset-2">
											Apellido del segundo actor:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='apellidoActor2' id='id_actor2' class = "form-control anime serie pelicula"/>
										</div>
									</div>
				        </div>

				        <div id = 'director' class = "row pelicula">
									<div class="row">
				            <label class="col-xs-2 col-xs-offset-2">
											Nombre del director:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='nombreDirector' id='id_director' class = "form-control pelicula"/>
										</div>
									</div>
									<div class="row">
				            <label class="col-xs-2 col-xs-offset-2">
											Apellido del director:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='apellidoDirector' id='id_director' class = "form-control pelicula" />
										</div>
									</div>
				        </div>

				        <div id = 'autor' class = "row manga libro videojuego comic">
									<div class="row">
				            <label class="col-xs-2 col-xs-offset-2">
											Nombre del autor:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='nombreAutor' id='id_autor' class = "form-control manga libro videojuego comic"/>
										</div>
									</div>
									<div class="row">
				            <label class="col-xs-2 col-xs-offset-2">
											Apellido del autor:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='apellidoAutor' id='id_autor' class = "form-control manga libro videojuego comic"/>
										</div>
									</div>
				        </div>

				        <div id = 'numeros' class = "row comic">
				            <label class="col-xs-2 col-xs-offset-2">
											Números:
										</label>
										<div class="col-xs-6">
				            	<input type = 'number' name='numeros' id='id_numeros' min = '1' max = '1500' value= '1' class = "form-control comic"/>
										</div>
				        </div>

				        <div id = 'editorial' class = "row comic libro">
				            <label class="col-xs-2 col-xs-offset-2">
											Editorial:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='editorial' id='id_editorial' class = "form-control comic libro"/>
										</div>
				        </div>

				        <div id = 'editorialOriginal' class = "row comic">
				            <label class="col-xs-2 col-xs-offset-2">
											Editorial original:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='editorialOriginal' id='id_editorialOriginal' class = "form-control comic"/>
										</div>
				        </div>

				        <div id = 'paginas' class = "row libro">
				            <label class="col-xs-2 col-xs-offset-2">
											Páginas:
										</label>
										<div class="col-xs-6">
				            	<input type = 'number' name='paginas' id='id_paginas' min = '1' max = '10000' value= '1' class = "form-control libro"/>
										</div>
				        </div>

				        <div id = 'isbn' class = "row libro">
				            <label class="col-xs-2 col-xs-offset-2">
											ISBN:
										</label>
										<div class="col-xs-6">
				            	<input type = 'number' name='isbn' id='id_isbn' min = '111111111111' max = '999999999999' class = "form-control libro"/>
										</div>
				        </div>

				        <div id = 'plataformas' class = "row videojuego">
				            <label class="col-xs-2 col-xs-offset-2">
											Elige tus plataformas:
										</label>
										<div class="col-xs-6">
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
				        </div>

				        <div id = 'revista' class = "row manga">
				            <label class="col-xs-2 col-xs-offset-2">
											Revista:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='revista' id='id_revista' class = "form-control manga"/>
										</div>
				        </div>

				        <div id = 'tomo' class = "row manga">
				            <label class="col-xs-2 col-xs-offset-2">
											Tomos:
										</label>
										<div class="col-xs-6">
				            	<input type = 'number' name='tomo' id='id_tomo' min = '1' max = '1000' value = '1' class = "form-control manga"/>
										</div>
				        </div>

				        <div id = 'duracion' class = "row pelicula">
				            <label class="col-xs-2 col-xs-offset-2">
											Duración:
										</label>
										<div class="col-xs-6">
				            	<input type = 'number' name='duracion' id='id_duracion' min = '1' max = '500' class = "form-control pelicula"/>
										</div>
				        </div>

				        <div id = 'productora' class = "row pelicula">
				            <label class="col-xs-2 col-xs-offset-2">
											Productora:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='productora' id='id_productora' class = "form-control pelicula"/>
										</div>
				        </div>

				        <div id = 'canal' class = "row serie">
				            <label class="col-xs-2 col-xs-offset-2">
											Canal:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='canal' id='id_canal' class = "form-control serie"/>
										</div>
				        </div>

				        <div id = 'desarrolladora' class = "row videojuego">
				            <label class="col-xs-2 col-xs-offset-2">
											Desarrolladora:
										</label>
										<div class="col-xs-6">
				            	<input type = 'text' name='desarrolladora' id='id_desarrolladora' class = "form-control videojuego"/>
										</div>
				        </div>

				        <div id = 'jugadores' class = "row videojuego">
				            <label class="col-xs-2 col-xs-offset-2">
											Número de jugadores:
										</label>
										<div class="col-xs-6">
				            	<input type = 'number' name='jugadores' id='id_jugadores' min = '1' max = '64' class = "form-control videojuego"/>
										</div>
				        </div>

						<div id = 'online' class = "row videojuego">
				            <label class="col-xs-2 col-xs-offset-2">
											Funciones online:
										</label>
										<div class="col-xs-6">
					            <select name="selectOnline" class = "form-control videojuego">
											  <option value="si">Sí</option>
											  <option value="no" selected>No</option>
											</select>
										</div>
				        </div>

								<label class="col-xs-offset-2">
									<input class="btn btn-primary" type = 'submit' value = 'Añadir' id = "boton"/>
								</label>
								<a class="col-xs-offset-5" href="index.php">Volver al inicio</a>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
