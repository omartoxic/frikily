<?php
	session_start();
	if(!(isset($_POST['categoria']))) {$_POST['categoria']="";}
	if(!(isset($_POST['pref']))){ $_POST['pref']="";}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>plantilla</title>
		<link rel="stylesheet" href="estilo-plantilla.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="estilojq.js"></script>
	</head>
	<?php
		include "basedatos.php";
		$conex=new Conexion("root","","frikily");
		$conex->connect();
		
		$consulta = $conex->consultaDinamica($_POST['ver'],$_POST['categoria'],$_POST['pref']);
		
		$list=$conex->consult($consulta);

		if(isset($_POST['search'])){
			if ($_POST['search'] != null){
				$list=$conex->consult("SELECT g.codigo,g.nombre,g.nota,g.imagen FROM general g, ".$_POST['ver']." t WHERE g.codigo = t.codigo AND g.nombre LIKE '%".$_POST['search']."%'");	
			}
		}

	?>
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
							<li><a href="index.php">Página principal</a></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="videojuegos">Videojuegos</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="anime">Anime</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="manga">Manga</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="comics">Cómics</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="libros">Libros</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="peliculas">Películas</button></li>
							<li><button class="btn btn-link" type="submit" name="ver" value="series">Series</button></li>
						</ul>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<form action='lista.php' method='post'>
								<?php
									echo "<input type='hidden' name='ver' value='".$_POST['ver']."'>";
								?>
								<input type='text' name='search'>
								<button type='submit'><i class='glyphicon glyphicon-search'></i>Buscar</button>
							</form>
						</li>
						<?php
							if(!isset($_SESSION['usuario']))
							{
								echo "<li><a href='inicioSesion.php'>iniciar sesión</a></li>";
							}
							else
							{
								echo "<li><a href='modificarDatos.php'>";
								echo "<img class='img-responsive img-rounded' src=imagenesusuarios/".$_SESSION['imgusu'].">";
								echo $_SESSION['usuario']."</a></li>";
								echo "<form action='index.php' method='post'><input type='submit' name='action' value='Cerrar sesión'></form>";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="navbar navbar-default arriba"></div>
		<div class="container">
			<div class="row">
				<div class="list-group secciones" id="secciones">
					Categorias
					<?php		
					$categorias=$conex->consult("SELECT DISTINCT g.genero FROM general g, ".$_POST['ver']." t WHERE g.codigo = t.codigo");
					
					echo "<form action='lista.php' method='post'>";			
						foreach ($categorias as $fila){
							echo '<button type="submit" name="categoria" value="'.$fila[0].'" class="list-group-item">'.$fila[0].'</button>';					
						}			
					echo "<input type='hidden' name='ver' value='".$_POST['ver']."'>";

					
					echo "Preferencias";
					echo '<button type="submit" name="pref" value="valorado" class="list-group-item">Más valorados</button>';
					if(isset($_SESSION['codigo'])){
						echo '<button type="submit" name="pref" value="lista" class="list-group-item">Mi Lista</button>';
					}
					echo '<button type="submit" name="pref" value="recientes" class="list-group-item">Más recientes</button>';
					echo "</form>";				
					?>
				</div>
				<?php
				echo '<form action="'.$_POST['ver'].'_plantilla.php" method="post" id="items" class="row">';
				
					foreach($list as $array)
					{
						echo '<button type="submit" name="item" value="'.$array[0].'" class="btn btn-link col-xs-2">';
						echo "<p class='item'>";
						echo "<img class='img-responsive img-rounded' src='imagenes/".$array[3].".jpg'>";
						echo "<span class='bold'>".$array[1]."</span>";
						echo "</p>";
						echo "</button>";
					}
					$conex->close();
				?>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>