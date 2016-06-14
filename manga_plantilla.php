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
		header("location: manga_plantilla.php");
	}

	$list=$conex->consult("SELECT * FROM general WHERE codigo =".$codigo);
	$general = $list[0];
	$list1=$conex->consult("SELECT * FROM manga WHERE codigo =".$codigo);
	$manga = $list1[0];
	$list3=$conex->consult("SELECT * FROM personas, rol WHERE rol.CodigoPersona = personas.CodigoPersona AND rol.Codigo =".$codigo);
	$actores = $list3;
	$temporadas=$conex->consult("SELECT DISTINCT contenedor FROM episodios WHERE codigo =".$codigo." ORDER BY contenedor");
	$haPuestoNota = count($conex->consult("SELECT * FROM 	notas WHERE CodigoUsuario = ".$_SESSION['codigo']." AND Codigo = ".$general[0])) > 0;
	if(isset($_SESSION['usuario']))
	{
		$notifi = $conex->notificaciones();
	}
	if(isset($_POST['nota']))
	{
		$nota = $_POST['nota'];
		if($haPuestoNota)
		{
			$conex->refresh('UPDATE `notas` SET `Nota`='.$nota.' WHERE Codigo = '.$general[0].' AND CodigoUsuario = '.$_SESSION['codigo']);
		}
		else
		{
			$conex->refresh('INSERT INTO `notas`(`Codigo`, `CodigoUsuario`, `Nota`) VALUES ('.$general[0].','.$_SESSION['codigo'].','.$nota.')');
		}
		$listaNotas = $conex->consult("SELECT * FROM 	notas WHERE Codigo = ".$general[0]);
		$notasEnTotal = count($listaNotas)+1;
		$notaFinal = 0;
		if($notasEnTotal > 1)
		{
			foreach($listaNotas as $notaPuesta)
			{
				$notaFinal = $notaFinal + $notaPuesta[3];
			}
		}
		else
		{
			$notaFinal = $nota;
		}
		$notaFinal = $notaFinal / $notasEnTotal;
		$conex->refresh('UPDATE `general` SET `Nota`='.$notaFinal.' WHERE Codigo = '.$general[0]);
		$list=$conex->consult("SELECT * FROM general WHERE codigo =".$codigo);
		$general = $list[0];
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $general[1] ?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="css/font-awesome.css" rel="stylesheet">
		<link href="css/font-awesome-animation.css" rel="stylesheet">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="estilojq.js"></script>
		<script type="text/javascript" src="visto.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
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
		<div class="container">
			<div class="navbar navbar-default arriba"></div>
				<div class="col-xs-12">
					<div class="objeto row">
						<h1 class="col-xs-12"><?php echo $general[1] ?></h1>
						<span class="imagen col-xs-3">
							<img src="imagenes/<?php echo $general[5] ?>.jpg" class='img-responsive'>
							<?php
								if(isset($_SESSION['usuario']))
								{
									$vistos = count($conex->consult("SELECT * FROM visto WHERE CodigoUsuario = '".$_SESSION['codigo']."' AND Codigo = '".$general[0]."'"));
									$episodios = count($conex->consult("SELECT * FROM episodios WHERE codigo =".$codigo));
									$visto = $episodios == $vistos;
									if($visto)
									{
										echo "<button id='vistos' class='btn btn-link visto'><i class='glyphicon glyphicon-ok'></i>Manga leido</button>";
									}
									else
									{
										echo "<button id='vistos' class='btn btn-link'><i class='glyphicon glyphicon-ok'></i>Marcar manga como leido</button>";
									}
									echo "<input type='hidden' id='tipo' value='manga'>";
									echo "<input type='hidden' id='cod' value='".$general[0]."'>";
									echo "<input type='hidden' id='cod-usu' value='".$_SESSION['codigo']."'>";
								}
							?>
						</span>
						<span class="datos col-xs-9">
							<div class="col-xs-10">
								<div class="bold">Nota: </div>
								<?php
									echo $general[3];
									if (isset($_SESSION['usuario']))
									{
										echo '<form method="post" action="">';
										echo "<input type='hidden' name='item' value=".$codigo.">";
										echo "<div class='col-md-2'>";
										echo "<input class='form-control' type='number' min='0' max='10' name='nota'>";
										echo "</div>";
										echo "<input class='btn btn-primary' type='submit' value='Puntuar'>";
										echo "</form>";
									}
								?>
							</div>
							<span class="col-xs-12"><div class="bold">Género: </div><?php echo $general[4] ?></span>
							<span class="col-xs-12"><div class="bold">Año de comienzo: </div><?php echo $general[6] ?></span>
							<span class="col-xs-12"><div class="bold">Año de finalización: </div><?php
								if($manga[1]==0){
									echo "En publicación";
								}
								else{
									echo $manga[1];
								}
							?></span>
							<span class="col-xs-12"><div class="bold">Revista: </div><?php echo $manga[2] ?></span>
							<span class="col-xs-12"><div class="bold">Tomos: </div><?php echo $manga[3] ?></span>
							<?php
							if(!(empty($actores))){
								echo "<span class='col-xs-12'><div class='bold'>Autor: </div>";
									foreach ($actores as $actor){
										echo $actor[1].' '.$actor[2].'<br>';
									}
								echo "</span>";
							}
							?>
							</span>
						</span>
					</div>
					<div class="row">

					</div>
					<div class="sinopsis row"><div class="bold">Sinopsis:</div><?php echo $general[2] ?></div>
					<div class="episodios row">
						<div class="bold">Tomos:</div>
						<?php
						foreach ($temporadas as $temporada)
						{
							echo '<span class="col-xs-10"><span class="bold-extra">Tomo: </span>'.$temporada[0].'</span>';
							$capitulos=$conex->consult("SELECT * FROM episodios WHERE codigo =".$codigo." AND contenedor=".$temporada[0]);

							foreach($capitulos as $capitulo){
								echo '<span class="col-xs-5"><span class="bold-extra">Número: </span>'.$capitulo[2].' : '.$capitulo[4];
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

						echo "</div>";
						echo "<div class='row col-md-12 comentarios-series' ><span class='bold'>Comentarios:</span>";

						if (isset($_SESSION['usuario'])){
							echo "<form method='post' action = ''>";
							echo "<textarea name='comentario' rows='10' class='form-control' cols='40'>Escribe aquí tus comentarios</textarea>";
							echo "<br>";
							echo "<button type='submit' class='btn btn-primary' name='item' value='".$codigo."'>Guardar comentario</button>";
							echo "</form>";
						}

						echo "</div>";
						echo "<br>";

						$listaComentarios=$conex->consult("SELECT * FROM comentarios WHERE codigo ='". $codigo."'");

						foreach ($listaComentarios as $key) {
							$time = strtotime($key[4]);
							$myFormatForView = date("d-n-Y H:i ", $time);
							$nombre = $conex->consult("SELECT Nombre FROM usuarios WHERE CodUsuario = '". $key[2]."'");


							echo "<div class = 'comentario col-md-12'>";
							echo $nombre[0][0];
							echo "&nbsp;&nbsp;&nbsp;<img class='imagen-usu img-rounded' src = 'imagenesusuarios/".$nombre[0][0].".jpg'/>";
							echo "<br>";
							echo $key[3];
							echo "<br>";
							echo "Escrito el ".$myFormatForView;
							echo "</div>";
							echo "<br>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
