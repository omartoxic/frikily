<?php
	session_start();
	if(isset($_POST['action'])){
		if($_POST['action'] == 'Cerrar sesión'){
			unset($_SESSION['usuario']);
		}
		else if($_POST['action'] == 'Entrar'){
			include "basedatos.php";
			$conex=new Conexion("root","","frikily");
			$conex->connect();
			if(isset($_POST['user']) && isset($_POST['pass']))
			{
				$exists = false;
				$pass = md5($_POST['pass']);
				$list = $conex->consult("SELECT * FROM `usuarios`");
				foreach($list as $usu)
				{
					if($_POST['user'] == $usu[1] && $pass == $usu[2])
					{
						$exists = true;
						$_SESSION['imgusu'] = $usu[3];
						$_SESSION['codigo'] = $usu[0];
					}
				}
				if($exists)
				{
					$_SESSION['usuario'] = $_POST['user'];
				}
			}
		}
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>plantilla</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<link rel="stylesheet" href="css/font-awesome.css">
		<link rel="stylesheet" href="css/font-awesome-animation.css">
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
							<li class="active"><a href="#"  class="btn btn-link">Página principal</a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="videojuegos">Videojuegos</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="anime">Anime</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="manga">Manga</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="comics">Cómics</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="libros">Libros</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="peliculas">Películas</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="series">Series</button></a></li>
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
								echo "<li><a href='notificaciones.php'><i class='fa fa-envelope fa-2x faa-flash animated faa-slow' style='color:#58ACFA'></i></a></li>";
								
								
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
					<h1>Hola mundo</h1>
					<blockquote>
						<p>esto es un artículo de prueba para que veamos como quedaría con la etiqueta pre y un blockquote.</p>
						<footer>Bernabé, el hombre que no sabía usar mayúsculas.</footer>
					</blockquote>
				</pre>
			</div>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
