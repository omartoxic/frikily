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
					<ul class="nav navbar-nav navbar-right">
						<li class="active">Iniciando sesión</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="navbar navbar-default arriba"></div>
		<div class="container">
			<h1 class="titulo">Inicio de sesión</h1>
			<form method="post" action="index.php">
				<div class="row">
					<label class="col-xs-2 col-xs-offset-2">
						Usuario:
					</label>
					<div class="col-xs-6">
						<input class="form-control" name="user" type="text" required>
					</div>
				</div>
				<div class="row">
					<label class="col-xs-2 col-xs-offset-2">
						Contraseña:
					</label>
					<div class="col-xs-6">
						<input class="form-control" name="pass" type="password" required>
					</div>
				</div>
				<div class="row">
					<label class="col-xs-offset-2">
						<input class="btn btn-success" name='action' type="submit" value="Entrar">
					</label>
					<a class="col-xs-offset-5" href="registrar.php">No estoy registrado</a>
				</div>
			</form>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
