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
			$list=$conex->consult("SELECT g.codigo,g.nombre,g.nota,g.imagen,g.aprobado FROM general g, ".$_POST['ver']." t WHERE g.codigo = t.codigo AND g.nombre LIKE '%".$_POST['search']."%' AND g.aprobado=1");
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
								echo "<li><a class='btn btn-link' href='inicioSesion.php'>Iniciar sesión</a></li>";
							}
							else
							{
								$notifi = $conex->notificaciones();
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
			<div class="col-md-2">
				<div class="list-group secciones" id="secciones">
					<form action='index.php' method='post'>
						<?php
							$categorias=$conex->consult("SELECT DISTINCT g.genero,g.aprobado FROM general g, ".$_POST['ver']." t WHERE g.codigo = t.codigo AND g.aprobado=1 ORDER BY g.genero");
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
								<button class='col-md-2 btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i> Buscar</button>
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
								echo '<button type="submit" name="item" value="'.$array[0].'" class="boton-item btn btn-link hvr-grow">';
								echo "<p class='item'>";
								echo "<img class='img-responsive imagen-articulo img-rounded' src='imagenes/".$array[3].".jpg'></img>";
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
