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

		$list=$conex->consult($consulta);

?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="css/font-awesome.css" rel="stylesheet">
		<link href="css/font-awesome-animation.css" rel="stylesheet">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<link rel="stylesheet" href="hover.css">

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
								<button class='col-md-2 btn btn-info' type='submit'><i class='glyphicon glyphicon-search'></i> Buscar</button>
							</span>
						</form>
					</div>
					<div class='row objetosbis'>
					<?php
						foreach($list as $array)
						{
							$tipo = $conex->sacarTipo($array[0]);

							echo '<div class="col-md-2  objeto">';
								echo '<form action="'.$tipo.'_plantilla.php" method="post" id="items">';
								echo "<div class='estreno'>";
								echo "Estreno: ".$array[4];
								echo "</div>";
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
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
