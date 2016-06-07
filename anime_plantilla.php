<?php
	session_start();
	include "basedatos.php";
	$conex=new Conexion("root","","frikily");
	$conex->connect();
	if (isset($_POST['item'])){
		$codigo= $_POST['item'];
	}else{
		$codigo = $_SESSION['cod'];
	}
	if(isset($_POST['comentario'])){
		$conex->insertarComentario($_POST['item'],$_SESSION['codigo'],$_POST['comentario']);
		$_SESSION['cod'] = $codigo;
		header("location: anime_plantilla.php");
	}
	$list=$conex->consult("SELECT * FROM general WHERE codigo =".$codigo);
	$general = $list[0];
	$list1=$conex->consult("SELECT * FROM anime WHERE codigo =".$codigo);
	$anime = $list1[0];
	$list3=$conex->consult("SELECT * FROM personas, rol WHERE rol.CodigoPersona = personas.CodigoPersona AND rol.Codigo =".$codigo);
	$actores = $list3;
	$temporadas=$conex->consult("SELECT DISTINCT contenedor FROM episodios WHERE codigo =".$codigo." ORDER BY contenedor");
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $general[1] ?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="estilojq.js"></script>
		<script type='text/javascript' src='visto.js'></script>
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
								echo "<li><a href='modificarDatos.php'>";
								echo "<img class='imagen-usu img-rounded' src=imagenesusuarios/".$_SESSION['imgusu'].">";
								echo $_SESSION['usuario']."</a></li>";
								echo "<form action='index.php' method='post'><input type='submit' name='action' value='Cerrar sesión'></form>";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="navbar navbar-default arriba"></div>
			<div class="row">
				<div class="list-group secciones" id="secciones">
					<a href="#" class="list-group-item">Sección 1</a>
					<a href="#" class="list-group-item">Sección 2</a>
					<a href="#" class="list-group-item">Sección 3</a>
					<a href="#" class="list-group-item">Sección 4</a>
				</div>
				<pre class="col-xs-10">
					<div class="objeto row">
						<span class="imagen col-xs-3">
							<img src="imagenes/<?php echo $general[5] ?>.jpg" class='img-responsive'>
						</span>
						<span class="datos col-xs-9">
							<span class="bold col-xs-9"><?php echo $general[1] ?></span>
							<span class="col-xs-2 col-xs-offset-1"><?php echo $general[3] ?></span>
							<span class="col-xs-10">Género: <?php echo $general[4] ?></span>
							<span class="col-xs-5">Año de comienzo: <?php echo $general[6] ?></span>
							<span class="col-xs-5">Año de finalización: <?php echo $anime[1] ?></span>
							<span class="col-xs-5">Temporadas: <?php echo $anime[2] ?></span>
							<span class="col-xs-5">Capitulos: <?php echo $anime[3] ?></span>
							<span class="col-xs-5">Estudio: <?php echo $anime[4] ?></span>
							<span class="col-xs-10">Actores: <br><?php
								foreach ($actores as $actor)
								{
									echo 'Nombre y apellidos: '.$actor[1].' '. $actor[2].' Rol: '. $actor[4].'<br>';
								}
							?>
							</span>
						</span>
					</div>
					<div class="row">
						<?php
							if(isset($_SESSION['usuario']))
							{
								$vistos = count($conex->consult("SELECT * FROM visto WHERE CodigoUsuario = '".$_SESSION['codigo']."' AND Codigo = '".$general[0]."'"));
								$episodios = count($conex->consult("SELECT * FROM episodios WHERE codigo =".$codigo));
								$visto = $episodios == $vistos;
								if($visto)
								{
									echo "<button id='vistos' class='btn btn-link visto'><i class='glyphicon glyphicon-ok'></i></button>";
								}
								else
								{
									echo "<button id='vistos' class='btn btn-link'><i class='glyphicon glyphicon-ok'></i></button>";
								}
								echo "<input type='hidden' id='cod' value='".$general[0]."'>";
								echo "<input type='hidden' id='cod-usu' value='".$_SESSION['codigo']."'>";
							}
						?>
					</div>
					<div class="sinopsis row"><?php echo $general[2] ?></div>
					<div class="episodios row">
						<?php
						echo "Lista de episodios:";
						foreach ($temporadas as $temporada)
						{
							echo '<span class="col-xs-10">Temporada: '.$temporada[0].'</span>';
							$capitulos=$conex->consult("SELECT * FROM episodios WHERE codigo =".$codigo." AND contenedor=".$temporada[0]);

							foreach($capitulos as $capitulo){
								echo '<span class="col-xs-5">Capitulo: '.$capitulo[2].' : '.$capitulo[4];
								if(isset($_SESSION['usuario']))
								{
									$vistos = $conex->consult('SELECT * FROM visto');
									$visto = false;
									foreach($vistos as $dato)
									{
										if($dato[1] == $_SESSION['codigo'] && $dato[2] == $general[0] && $dato[3] == $capitulo[0])
										{
											$visto = true;
										}
									}
									if($visto)
									{
										echo "<button id='".$capitulo[0]."' class='btn btn-link visto ver'><i class='glyphicon glyphicon-ok'></i></button>";
									}
									else
									{
										echo "<button id='".$capitulo[0]."' class='btn btn-link ver'><i class='glyphicon glyphicon-ok'></i></button>";
									}
								}
								echo '</span>';
							}
						}

						echo "<br>";
						echo "<br>";
						echo "<br>";
						echo "<br>";
						echo "Comentarios:";

						if (isset($_SESSION['usuario'])){
							echo "<form method='post' action = ''>";
							echo "<textarea name='comentario' rows='10' cols='40'>Escribe aquí tus comentarios</textarea>";
							echo "<br>";
							echo "<button type='submit' name='item' value='".$codigo."'>Guardar comentario</button>";
							echo "</form>";
						}

						echo "<br>";
						echo "<br>";

						$listaComentarios=$conex->consult("SELECT * FROM comentarios WHERE codigo =".$codigo);

						foreach ($listaComentarios as $key) {
							$time = strtotime($key[4]);
							$myFormatForView = date("d-n-Y H:i ", $time);

							echo "<div class = 'comentario'>";
							echo $_SESSION['usuario'];
							echo "<img src = 'imagenesusuarios/".$_SESSION['imgusu']."' />";
							echo "<br>";
							echo $key[3];
							echo "<br>";
							echo "Escrito el ".$myFormatForView;
							echo "</div>";
							echo "<br>";
						}

						?>
					</div>
				</pre>
			</div>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
