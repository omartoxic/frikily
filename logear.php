<?php
	session_start();
	
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>plantilla</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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
							<li><a href="index.php"  class="btn btn-link">Página principal</a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="videojuegos">Videojuegos</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="anime">Anime</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="manga">Manga</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="comics">Cómics</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="libros">Libros</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="peliculas">Películas</button></a></li>
							<li><a href="#"><button class="btn btn-link" type="submit" name="ver" value="series">Series</button></a></li>
						</ul>
					</form>
				</div>
			</div>
		</div>
		<div class="navbar navbar-default arriba"></div>
		<h1 class='titulo'>
		<?php
			
					echo "Bienvenido ".$_SESSION['usuario']."</h1><br>";
					echo "<a href='index.php'>Pantalla principal</a>";
				}
				else
				{
					echo "El usuario no existe</h1><br>";
					echo "<a href='inicioSesion.php'>Volver atrás</a>";
				}
			}
			else
			{
				echo "Debes completar todos los campos</h1><br>";
				echo "<a href='inicioSesion.php'>Volver atrás</a>";
			}
		?>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
