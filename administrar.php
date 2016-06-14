<?php
	session_start();
	if(isset($_POST['action'])){
		if($_POST['action'] == 'Cerrar sesión'){
			unset($_SESSION['usuario']);
		}
	}
	include "basedatos.php";
	$conex=new Conexion("root","","frikily");
	$conex->connect();

	$list=$conex->consult("SELECT codigo,nombre,nota,imagen,aprobado FROM general WHERE aprobado=0");

	$notifi = $conex->notificaciones();
?>
<html>
	<head>

		<title>Página principal</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="css/font-awesome.css" rel="stylesheet">
		<link href="css/font-awesome-animation.css" rel="stylesheet">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<link rel="stylesheet" href="hover.css">
		<script type="text/javascript" src="estilojq.js"></script>
		<script type="text/javascript" src="texto-articulo.js"></script>
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
								echo "<li><a class='btn btn-link' href='inicioSesion.php'>iniciar sesión</a></li>";
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
		<div class="navbar navbar-default arriba"></div>
		<div class="container">
			<div class='col-md-12'>
				<div class='articulos container'>
					<div class='row'>
					<?php
						foreach($list as $array)
						{
							$tipo = $conex->sacarTipo($array[0]);
							echo '<div class="col-md-2  objeto">';
							echo '<form action="administrarDatos.php" method="post" id="items">';
								echo '<button type="submit" name="item" value="'.$array[0].'" class="boton-item btn btn-link hvr-grow">';
								echo "<p class='item'>";
								echo "<img class='img-responsive imagen-articulo img-rounded' src='imagenes/".$array[3].".jpg'></img>";
								echo "<span class='texto-articulo bold'>".$array[1]."</span>";
								echo "</p>";
								echo "</button>";
							echo "<input type='hidden' name='tipo' value='".$tipo."'>";
							echo "</form>";
							echo '</div>';
						}
						$conex->close();
					?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
