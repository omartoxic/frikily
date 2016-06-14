<?php
	session_start();
	include "basedatos.php";
	$conex=new Conexion("root","","frikily");
	$conex->connect();
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Inicio de sesión</title>
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
				</div>
			</div>
		</div>
		<div class="navbar navbar-default arriba"></div>
		<div class="container">
			<h1 class="titulo">Inicio de sesión</h1>
			<?php
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
						header("Location: index.php");
						exit();
					}
					else
					{
						echo "<h3 class='titulo'>El usuario no existe</h3>";
					}
				}
			?>
			<form method="post" action="inicioSesion.php">
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
						<input class="btn btn-primary" name='action' type="submit" value="Entrar">
					</label>
					<a class="col-xs-offset-5" href="registrar.php">No estoy registrado</a>
				</div>
			</form>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
