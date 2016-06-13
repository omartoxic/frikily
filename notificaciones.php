<?php
	session_start();
	include "basedatos.php";
	$conex=new Conexion("root","","frikily");
	$conex->connect();
	
	$consulta= "SELECT DISTINCT g.codigo,g.nombre,g.nota,g.imagen,e.fecha,g.sinopsis FROM general g, visto v, usuarios u, estrenos e, episodios p";

	$now = new DateTime();
	$now = $now->format('Y-m-d'); 
		
		if(isset($_POST['seccion'])){
			$seccion=", ".$_POST['seccion']." t WHERE v.codigousuario = u.codusuario AND g.codigo = v.codigo and e.codigo = g.codigo AND e.fecha >= '".$now."' AND t.codigo = g.codigo AND u.codusuario=".$_SESSION['codigo'];
			$consulta= $consulta.$seccion;	
		}
		else{
			$consulta=$consulta." WHERE v.codigousuario = u.codusuario AND g.codigo = v.codigo AND e.codigo = g.codigo AND e.fecha >= '".$now."' AND e.codcapitulo = p.codigocapitulo AND u.codusuario=".$_SESSION['codigo'];
		}
		
		if(isset($_POST['search'])){
			if ($_POST['search'] != null){
				$consulta = "SELECT DISTINCT g.codigo,g.nombre,g.nota,g.imagen,e.fecha,g.sinopsis FROM general g, visto v, usuarios u, estrenos e WHERE  v.codigousuario = u.codusuario AND g.codigo = v.codigo AND e.codigo = g.codigo and e.fecha >= $now and g.nombre LIKE '%".$_POST['search']."%' AND u.codusuario=".$_SESSION['codigo'];
			}
		}
		echo $consulta;
		
		$list=$conex->consult($consulta);
	
?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="css/font-awesome.css" rel="stylesheet">
		<link href="css/font-awesome-animation.css" rel="stylesheet">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="estilojq.js"></script>
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
							<li><a class='barra btn btn-link' href="index.php">Página principal</a></li>
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
					<form action='notificaciones.php' method='post'>
					
					<button type="submit" name="seccion" value="videojuegos" class="list-group-item">Videojuegos</button>
					<button type="submit" name="seccion" value="anime" class="list-group-item">Anime</button>
					<button type="submit" name="seccion" value="manga" class="list-group-item">Manga</button>
					<button type="submit" name="seccion" value="comics" class="list-group-item">Cómics</button>
					<button type="submit" name="seccion" value="libros" class="list-group-item">Libros</button>
					<button type="submit" name="seccion" value="peliculas" class="list-group-item">Peliculas</button>
					<button type="submit" name="seccion" value="series" class="list-group-item">Series</button>
					
					</form>
				</div>
			</div>
			<div class='col-md-10'>
				<div class='articulos container'>
					<div class='row'>
						<form action='notificaciones.php' method='post'>
							<span class='col-md-10'>
								<span class='col-md-8 col-md-offset-2'>
									<input type='text' class='form-control' name='search'>
								</span>
								<button class='col-md-2 btn btn-success' type='submit'><i class='glyphicon glyphicon-search'></i>Buscar</button>
							</span>
						</form>
					</div>
					<div class='row objetosbis'>
					<?php
						foreach($list as $array)
						{
							echo '<div class="col-md-2  objeto">';
								
								echo "<div class='estreno'>";
								echo "Estreno: ".$array[4];
								echo "</div>";
								
								echo "<p class='item'>";
								echo "<img class='img-responsive imagen-articulo img-rounded' src='imagenes/".$array[3].".jpg'></img>";
								echo "<span class='texto-articulo bold'>".$array[1]."</span>";
								echo "</p>";
								
								
							echo '</div>';
							
							
							// echo '<div class="col-md-2  objeto">';
								// echo '<div id="items" class="row">';
									// echo "<div class='estreno'>";
									// echo "Estreno: ".$array[4];
									// echo "</div>";
										// echo "<p class='item'>";
											// echo "<img class='imagen-articulo img-responsive img-rounded' src='imagenes/".$array[2].".jpg'>";
											// echo "<span class='bold'>".$array[1]."</span>";
										// echo "</p>";
									// echo "</div>";
								// echo "</div>";
							// echo "</div>";
							// echo '<div class="col-md-10">';
							// echo '<div id="items" class="row">';
								
						}
						$conex->close();
					?>
					</div>
				</div>
			</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
