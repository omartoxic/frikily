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
				$fallido = false;
				$ruta = "./imagenes/img";
				$imagenes_permitidas = Array('image/jpeg','image/png');

				if ($_FILES['imagenProducto']["name"] != "" ){
	                    $size = ($_FILES['imagenProducto']['size']);
	                    if($size <= 7000000 && $size > 0){ //por si supera el tamaño permitido
	                      $nombreImagen = $_FILES["imagenProducto"]["name"];
	                      $nombreEXtension = explode('.', $nombreImagen);
	                      $extension = end($nombreEXtension);
	                      	if ($extension == 'jpg' || $extension == 'png'){

		                        $archivo_temporal = $_FILES['imagenProducto']['tmp_name'];

		                        $archivo_nombre = $ruta.$_POST['item'].".jpg";
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
	            

				//ANIME
				if($_POST['tipo']=="anime"){
					$update_especifica="UPDATE ".$_POST['tipo']." t SET anniofin = '".$_POST['annioFin']."', temporadas = '".$_POST['temporadas']."', capitulos = '".$_POST['capitulos']."', estudio = '".$_POST['estudio']."' WHERE t.codigo =".$_POST['item'];
				}

				//COMICS
				if($_POST['tipo']=="comics"){
					$update_especifica="UPDATE ".$_POST['tipo']." t SET numeros = '".$_POST['numeros']."', editorial = '".$_POST['editorial']."', editorialoriginal = '".$_POST['editorialOriginal']."' WHERE t.codigo =".$_POST['item'];
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

				//ACTOR 1
				if($_POST['actor1nom']){
					$list=$conex->consult("UPDATE personas p SET nombre = '".$_POST['actor1nom']."', apellido = '".$_POST['actor1ape']."' WHERE CodigoPersona = ".$_POST['idactor1']);
				}

				//ACTOR 2
				if($_POST['actor2nom']){
					$list=$conex->consult("UPDATE personas p SET nombre = '".$_POST['actor2nom']."', apellido = '".$_POST['actor2ape']."' WHERE CodigoPersona = ".$_POST['idactor2']);
				}

				//DIRECTOR
				if($_POST['directornom']){
					$list=$conex->consult("UPDATE personas p SET nombre = '".$_POST['directornom']."', apellido = '".$_POST['directorape']."' WHERE CodigoPersona = ".$_POST['iddirector']);
				}

				//AUTOR
				if($_POST['autornom']){
					$list=$conex->consult("UPDATE personas p SET nombre = '".$_POST['autornom']."', apellido = '".$_POST['autorape']."' WHERE CodigoPersona = ".$_POST['idautor']);
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

			$list2=$conex->consult("SELECT p.nombre, p.apellido, r.codigopersona FROM personas p, rol r WHERE r.CodigoPersona = p.CodigoPersona AND r.Codigo =".$_POST['item']." AND r.rol NOT LIKE 'Director'");
			$personas = $list2;
			
			$list3=$conex->consult("SELECT p.nombre, p.apellido, r.codigopersona FROM personas p, rol r WHERE r.CodigoPersona = p.CodigoPersona AND r.Codigo =".$_POST['item']." AND r.rol LIKE 'Director'");
			if (empty($list3)) {
				$director[0] = "";
				$director[1] = "";
				$director[2] = "";
			}
			$list4=$conex->consult("SELECT p.nombre, p.apellido, r.codigopersona FROM personas p, rol r WHERE r.CodigoPersona = p.CodigoPersona AND r.Codigo =".$_POST['item']." AND r.rol LIKE 'Autor'");
			if (empty($list4)) {
				$autor[0]  = "";
				$autor[1]  = "";
				$autor[2]  = "";
			}
			
			

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
								echo "<li class='usuario'>";
								echo "<img class='imagen-usu img-rounded' src='imagenesusuarios/".$_SESSION['imgusu']."?comodin=".rand(1,1000)."'>";
								echo $_SESSION['usuario'];
								echo '<li><div class="dropdown">';
								echo '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
								echo '<i class="glyphicon glyphicon-option-vertical"></i>';
								echo '</button>';
							  echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';
								echo '<li><form action="index.php" method="post"><button type="submit" id="cerrarSesion" class="btn btn-default" name="action" value="Cerrar sesión">Cerrar sesión</button></form></li>';
								echo '<li><a class="btn btn-default" href="modificarDatos.php">ModificarDatos</a></li>';
								echo '</ul>';
								echo '</div></li>';
							}
						?>
					</ul>
				</div>
			</div>
		</div>
			<div class="navbar navbar-default arriba"></div>
			<form class="container" action="administrarDatos.php" method="POST" id="datos" enctype="multipart/form-data">

				<div class="imagen-centrada row" id = 'imagen_subida'>
					<img src="imagenes/<?php echo $general[5] ?>.jpg" style='width:180px;'>
				</div>
					<div class="row" id = 'nombre'>
			          <label class="col-xs-2 col-xs-offset-2">
									Nombre:
								</label>
								<div class="col-xs-6">
			          	<input class="form-control" type = 'text' name='nombre' id='id_nombre' value='<?php echo $general[1]?>'/>
								</div>
			      </div>


						<div class="row" id = 'sinopsis'>
			          <label class="col-xs-2 col-xs-offset-2">
									Sinopsis:
								</label>
								<div class="col-xs-6">
			          	<textarea name='sinopsis' rows='10' class='form-control' cols='40' maxlength = '600'name='sinopsis' id='id_sinopsis'><?php echo $general[2]?></textarea>
								</div>
			      </div>

			      <div class="row" id = 'genero'>
			          <label class="col-xs-2 col-xs-offset-2">
									Género:
								</label>
								<div class="col-xs-6">
			          	<input class='form-control' type = 'text' name='genero' id='id_genero' value='<?php echo $general[4]?>'/>
								</div>
			      </div>
			    	<div class="row" id = 'imagen'>
				        <label class="col-xs-2 col-xs-offset-2">
									Subir otra imagen:
								</label>
				        <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
								
				        	<input type="file" name="imagenProducto" id="imagen" />
								</div>
			      </div>
	        	<div class="row" id = 'annio'>
		            <label class="col-xs-2 col-xs-offset-2">
									Año:
								</label>
								<div class="col-xs-6">
		            	<input class='form-control' type = 'number' name='annio' id='id_annio' max = '2099' value='<?php echo $general[6]?>'/>
								</div>
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
					echo "<div class='row' id = 'annioFin'>";
						echo "	<label class='col-xs-2 col-xs-offset-2'>Año de finalización (0 si no ha acabado):</label>";
						echo '<div class="col-xs-6">';
						echo "	<input class='form-control' type = 'number' name='annioFin' id='id_annioFin' max = '2099' value= '$general[8]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'anime' || $_POST['tipo'] == 'series'){
					echo "<div  class='row'id = 'temporadas'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Temporadas:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'number' name='temporadas' id='id_temporadas' min = '1' max = '100' value= '$general[9]' />";
						echo "</div>";
					echo "</div>";
				}
				if($_POST['tipo'] == 'anime'  || $_POST['tipo'] == 'series'){
					echo "<div class='row' id = 'capitulos'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Capítulos:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'number' name='capitulos' id='id_capitulos' min = '1' max = '1500' value= '$general[10]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'anime'){
					echo "<div class='row' id = 'estudio'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Estudio:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='estudio' id='id_estudio' value= '$general[11]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'anime' || $_POST['tipo'] == 'peliculas' || $_POST['tipo'] == 'series'){
					echo "<div class='row' id = 'actor1'>";
						echo "<div class='row'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Nombre del primer actor:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='actor1nom' id='id_actor1' value= '".$personas[0][0]."' />";
						echo "</div>";
						echo "</div>";
						echo "<div class='row'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Apellido del primer actor:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='actor1ape' id='id_actor1' value= '".$personas[0][1]."' />";
						echo "<input type='hidden' name='idactor1' value='".$personas[0][2]."'>";
						echo "</div>";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'anime' || $_POST['tipo'] == 'peliculas' || $_POST['tipo'] == 'series'){
					echo "<div class='row' id = 'actor2'>";
						echo "<div class='row'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Nombre del segundo actor:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='actor2nom' id='id_actor2' value= '".$personas[1][0]."' />";
						echo "</div>";
						echo "</div>";
						echo "<div class='row'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Apellido del segundo actor:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='actor2ape' id='id_actor2' value= '".$personas[1][1]."' />";
						echo "<input type='hidden' name='idactor2' value='".$personas[1][2]."'>";
						echo "</div>";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'peliculas'){
					echo "<div class='row' id = 'director'>";
						echo "<div class='row'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Nombre del director:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='directornom' id='id_director' value= '".$director[0]."' />";
						echo "</div>";
						echo "</div>";
						echo "<div class='row'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Apellido del director:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='directorape' id='id_director' value= '".$director[1]."' />";
						echo "<input type='hidden' name='iddirector' value='".$director[2]."'>";
						echo "</div>";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'manga' || $_POST['tipo'] == 'libros' || $_POST['tipo'] == 'videojuegos' || $_POST['tipo'] == 'comics'){
					echo "<div class='row' id = 'autor'";
						echo "<div class='row'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Nombre del autor:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='autornom' id='id_autor' value= '".$autor[0]."' />";
						echo "</div>";
						echo "</div>";
						echo "<div class='row'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Apellido del autor:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='autorape' id='id_autor' value= '".$autor[1]."' />";
						echo "<input type='hidden' name='idautor' value='".$autor[2]."'>";
						echo "</div>";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'comics'){
					echo "<div class='row' id = 'numeros'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Números:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'number' name='numeros' id='id_numeros' min = '1' max = '1500'  value= '$general[8]' />";
						echo "</div>";
					echo "</div>";
				}
				if($_POST['tipo'] == 'comics' || $_POST['tipo'] == 'libros'){
					echo "<div class='row' id = 'editorial'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Editorial:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='editorial' id='id_editorial' value= '$general[9]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'comics'){
					echo "<div class='row' id = 'editorialOriginal'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Editorial original:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='editorialOriginal' id='id_editorialOriginal' value= '$general[10]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'libros'){
					echo "<div class='row' id = 'paginas'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Páginas:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'number' name='paginas' id='id_paginas' min = '1' max = '10000' value= '$general[8]'  />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'libros'){
					echo "<div class='row' id = 'isbn'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>ISBN:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'number' name='isbn' id='id_isbn' min = '111111111111' max = '999999999999' value= '$general[9]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'manga'){
					echo "<div class='row' id = 'revista'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Revista:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='revista' id='id_revista' value= '$general[9]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'manga'){
					echo "<div class='row' id = 'tomo'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Tomos:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'number' name='tomo' id='id_tomo' min = '1' max = '1000' value= '$general[10]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'peliculas'){
					echo "<div class='row' id = 'duracion'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Duración:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'number' name='duracion' id='id_duracion' min = '1' max = '500' value= '$general[8]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'peliculas'){
					echo "<div class='row' id = 'productora'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Productora:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='productora' id='id_productora' value= '$general[9]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'series'){
					echo "<div class='row' id = 'canal'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Canal:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='canal' id='id_canal' value= '$general[11]' />";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'videojuegos'){
					echo "<div class='row' id = 'desarrolladora'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Desarrolladora:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'text' name='desarrolladora' id='id_desarrolladora' value= '$general[8]'/>";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'videojuegos'){
					echo "<div class='row' id = 'jugadores'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Número de jugadores:</label>";
						echo '<div class="col-xs-6">';
						echo "<input class='form-control' type = 'number' name='jugadores' id='id_jugadores' min = '1' max = '64'  value= '$general[9]'/>";
						echo "</div>";
					echo "</div>";
				}

				if($_POST['tipo'] == 'videojuegos'){
					echo "<div class='row' id = 'online'>";
						echo "<label class='col-xs-2 col-xs-offset-2'>Funciones online:</label>";
						echo '<div class="col-xs-6">';
						echo "<select class='form-control' name='selectOnline'>";
					  echo "<option value='1'>Sí</option>";
					  echo "<option value='0' selected>No</option>";
						echo "</select>";
						echo "</div>";
					echo "</div>";
				}

				?>
				<input type='hidden' name='item' value='<?php echo $_POST['item']; ?>'>
				<input type='hidden' name='tipo' value='<?php echo $_POST['tipo']; ?>'>
				<label class="col-xs-offset-2">
	    		<input class="btn btn-primary" type = 'submit' name="accion" value = 'Aprobar' id = "boton"/>
				</label>
				<label class="col-xs-offset-3">
					<input class="btn btn-danger" type = 'submit' name="accion" value = 'Eliminar' id = "boton"/>
				</label>
		    <a class="col-xs-offset-3" href="index.php">Volver al inicio</a>
			</form>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
