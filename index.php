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
	$_POST['ver'] = 'general';
	if(!isset($_POST['categoria']))
	{
		$_POST['categoria'] = "";
	}
	if(!isset($_POST['pref']))
	{
		$_POST['pref'] = "";
	}
	$consulta = $conex->consultaDinamica($_POST['ver'],$_POST['categoria'],$_POST['pref']);

	$list=$conex->consult($consulta);

	if(isset($_POST['search'])){
		if ($_POST['search'] != null){
			$list=$conex->consult("SELECT g.codigo,g.nombre,g.nota,g.imagen FROM general g, ".$_POST['ver']." t WHERE g.codigo = t.codigo AND g.nombre LIKE '%".$_POST['search']."%'");
		}
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Página principal</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="css/font-awesome.css" rel="stylesheet">
		<link href="css/font-awesome-animation.css" rel="stylesheet">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="estilojq.js"></script>
		<script type="text/javascript" src="texto-articulo.js"></script>
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
							<li><a class='barra btn btn-link' href="#">Página principal</a></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="videojuegos">Videojuegos</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="anime">Anime</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="manga">Manga</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="comics">Cómics</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="libros">Libros</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="peliculas">Películas</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="series">Series</button></li>
							<?php
								if(isset($_SESSION['usuario']))
								{
									echo "<li><a class='barra btn btn-link' href='introducirDatos.php'>Añadir</a></li>";
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
								echo "<li><a class='iniciosesion btn btn-link' href='inicioSesion.php'>iniciar sesión</a></li>";
							}
							else
							{
								echo "<li><a href='notificaciones.php'><i class='fa fa-envelope fa-2x faa-flash animated faa-slow' style='color:#58ACFA'></i></a></li>";
								echo "<li class='usuario'><a href='modificarDatos.php'>";
								echo "<img class='imagen-usu img-rounded' src='imagenesusuarios/".$_SESSION['imgusu']."?comodin=".rand(1,1000)."'>";
								echo $_SESSION['usuario'];
								echo "<form action='index.php' method='post'><input type='submit' id='cerrarSesion' class='btn btn-link' name='action' value='Cerrar sesión'></form></a></li>";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="navbar navbar-default arriba"></div>
		<div class="container">
			<div class="col-md-2">
				<div class="list-group secciones" id="secciones">
					<form action='lista.php' method='post'>
						<?php
							$categorias=$conex->consult("SELECT DISTINCT g.genero FROM general g, ".$_POST['ver']." t WHERE g.codigo = t.codigo");
							echo "<div>Categorias";
								foreach ($categorias as $fila){
									echo '<button type="submit" name="categoria" value="'.$fila[0].'" class="list-group-item">'.$fila[0].'</button>';
								}
							echo "<input type='hidden' name='ver' value='".$_POST['ver']."'>";

							echo "</div><div class='preferencias'>";
							echo "Preferencias";
							echo '<button type="submit" name="pref" value="valorado" class="list-group-item">Más valorados</button>';
							if(isset($_SESSION['codigo'])){
								echo '<button type="submit" name="pref" value="lista" class="list-group-item">Mi Lista</button>';
							}
							echo '<button type="submit" name="pref" value="recientes" class="list-group-item">Más recientes</button>';
							echo "</div>";
						?>
					</form>
				</div>
			</div>
			<div class='col-md-10'>
				<div class='articulos container'>
					<div class='row'>
						<form action='index.php' method='post'>
							<?php
								echo "<input type='hidden' name='ver' value='".$_POST['ver']."'>";
							?>
							<span class='col-md-10'>
								<span class='col-md-8 col-md-offset-2'>
									<input type='text' class='form-control' name='search'>
								</span>
								<button class='col-md-2 btn btn-success' type='submit'><i class='glyphicon glyphicon-search'></i>Buscar</button>
							</span>
						</form>
					</div>
					<div class='row objetos'>
						<?php
							foreach($list as $array)
							{
								$tipo = $conex->sacarTipo($array[0]);
								echo '<div class="col-md-2  objeto">';
								echo '<form action="'.$tipo.'_plantilla.php" method="post" id="items">';
								echo '<button type="submit" name="item" value="'.$array[0].'" class="btn btn-link col-xs-2">';
								echo "<p class='item'>";
								echo "<img class='img-responsive imagen-articulo img-rounded' src='imagenes/".$array[3].".jpg'>";
								echo "<span class='texto-articulo bold'>".$array[1]."</span>";
								echo "</p>";
								echo "</button>";
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
