<?php
  session_start();
  session_destroy();
?>
<HTML>
  <HEAD>
    <TITLE>Registrar Usuario</TITLE>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
</HEAD>
  <BODY>
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
  	<div class="registro">
  	<h1 class='titulo'>Registrar de usuario</h1>

      <?php
          include "basedatos.php";
          $conex=new Conexion("root","","frikily");
          $conex->connect();

			    if (isset($_POST["usuario"]) && isset($_POST["pass"]) && isset($_POST["mail"]) && isset($_FILES['imagen_usuario'])){
						$usuario = $_POST["usuario"];
			      $pass = $_POST["pass"];
			      $mail = $_POST["mail"];
            $passM = md5($pass);

			      $imagenes_permitidas = Array('image/jpeg','image/png'); //tipos mime permitidos

            $ruta = "./imagenesusuarios/";//ruta carpeta donde queremos copiar las imágenes
            $archivo_temporal = $_FILES['imagen_usuario']['tmp_name'];
            $archivo_nombre = $ruta.$usuario.".jpg";

            $tamanio = getimagesize($_FILES['imagen_usuario']['tmp_name']);
            list($ancho, $alto) = $tamanio;

            if ($tamanio){
                if(in_array($tamanio['mime'], $imagenes_permitidas)){
                  if ($ancho < 500 && $alto < 500){
                    if (is_uploaded_file($archivo_temporal)){
                      if ($_FILES['imagen_usuario']['size'] < 6291456){
                        move_uploaded_file($archivo_temporal,$archivo_nombre);
                        $imagen = $usuario.".jpg";
                        $conex->insertar($usuario,$passM,$mail,$imagen);
                      }else{
                        echo "<h3 class='titulo'>El tamaño excede el permitido.</h3>";
                      }
                    }else{
                      echo "<h3 class='titulo'>Error en la subida. Inténtalo de nuevo.</h3>";
                    }
                  }else{
                    echo "<h3 class='titulo'>La dimensión excede el permitido (500x500 px).</h3>";
                  }
                }else{
                  echo "<h3 class='titulo'>Formato de imagen no válido. Solo están permitidas en formato jpg y png.</h3>";
                }
              }
            }
			?>

  		<form action="registrar.php" method="POST" id="usuario" class='container' enctype="multipart/form-data">

  		      <div class='row'>
              <label class='col-md-2 col-md-offset-2'>Usuario:</label>
              <div class='col-md-5'>
                <input type = 'text' class='form-control' name='usuario' id='id_usuario'/>
              </div>
            </div>

            <div class='row'>
              <label class='col-md-2 col-md-offset-2'>Contraseña:</label>
              <div class='col-md-5'>
                <input class='form-control' type = 'password' name='pass' id='id_pass'/>
              </div>
            </div>

            <div class='row'>
              <label class='col-md-2 col-md-offset-2'>Mail:</label>
              <div class='col-md-5'>
                <input class='form-control' type = 'text' name='mail' id='id_mail'/>
              </div>
            </div>

            <div class='row'>
              <label for="imagen" class='col-md-2 col-md-offset-2'>Subir imagen:</label>
              <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
              <div class='col-md-5'>
                <input type="file" name="imagen_usuario" id="imagen" />
              </div>
            </div>

            <div class='row'>
              <input class='col-md-offset-2 btn btn-primary' type = 'submit' value = 'Registrar' id = "boton"/>
              <a class='col-md-offset-5' href="index.php">Volver al inicio</a>
          </div>
</form>

    </div>
  </BODY>
</HTML>
