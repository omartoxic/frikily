<?php
  session_start();
	include "basedatos.php";
  $conex=new Conexion("root","","frikily");
	$conex->connect();
?>

<HTML>
  <HEAD>
		<meta charset="UTF-8">
		<title>Modificar usuario</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="estilo-plantilla.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="estilojq.js"></script>
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
					<ul class="nav navbar-nav navbar-right">
						<li>

						</li>
						<?php
							echo "<li class='usuario'>";
							echo "<img class='imagen-usu img-rounded' src='imagenesusuarios/".$_SESSION['imgusu']."?comodin=".rand(1,1000)."'>";
							echo $_SESSION['usuario'];
						?>
					</ul>
				</div>
			</div>
		</div>
		</div>
		<div class="navbar navbar-default arriba"></div>
		<div class="container">
			<div class="row">
  	<div class="registro">
  	<h1 class='titulo'>Modificar datos de usuario</h1>


      <?php
          $sql = "UPDATE usuarios SET ";
          $campos = [];
          $codigo = $_SESSION['codigo'];
          $fallido = false;
          $usuario = $_SESSION['usuario'];
          $imagenes_permitidas = Array('image/jpeg','image/png'); //tipos mime permitidos
          $ruta = "./imagenesusuarios/";//ruta carpeta donde queremos copiar las imágenes


          if(isset($_POST["pass"])){
            $passGuardada = $conex->consult("SELECT Pass FROM usuarios WHERE CodUsuario =".$codigo);
            $passSQL = $passGuardada[0];

            if ($passSQL[0] == md5($_POST["pass"])){

              if ($_POST["nueva_pass"] == $_POST["nueva_pass2"]){

                if (isset($_POST["nueva_pass"])){
                  if ($_POST["nueva_pass"] != null){
                    array_push($campos,"Pass = '".md5($_POST["nueva_pass"])."' ");
                  }
                }

                if (isset($_POST["mail"])){
                  if ($_POST["mail"] != null){
                    array_push($campos,"Mail ='".$_POST["mail"]."' ");
                  }
                }

              }else{
                echo "<div>Las nuevas contraseñas no coinciden. Inténtalo de nuevo</div>";
                $fallido = true;
               }

                if (isset($_FILES['imagen_usuario'])){
                  if ($_FILES["imagen_usuario"]["name"] != "" ){
                    $size = ($_FILES['imagen_usuario']['size']);
                    if($size <= 2000000 && $size > 0){ //por si supera el tamaño permitido
                      $nombre = $_FILES["imagen_usuario"]["name"];
                      $extension = end(explode('.', $nombre));

                      if ($extension == 'jpg' || $extension == 'png'){

                        $archivo_temporal = $_FILES['imagen_usuario']['tmp_name'];
                        $archivo_nombre = $ruta.$usuario.".jpg";

                        $tamanio = getimagesize($archivo_temporal);
                        list($ancho, $alto) = $tamanio;

                          if ($tamanio){
                            if(in_array($tamanio['mime'], $imagenes_permitidas)){
                              if ($ancho < 500 && $alto < 500){
                                if (is_uploaded_file($archivo_temporal)){
                                  if ($_FILES['imagen_usuario']['size'] < 2000000){
                                    move_uploaded_file($archivo_temporal,$archivo_nombre);
                                    $imagen = $usuario.".jpg";
                                    array_push($campos, "Imagen = '".$imagen."' ");
                                    $_SESSION['imgusu'] = $imagen;

                                  }else{
                                    $fallido = true;
                                    echo "<div>El tamaño excede el permitido.</div>";
                                  }
                                }else{
                                  $fallido = true;
                                  echo "<div>Error en la subida. Inténtalo de nuevo.</div>";
                                }
                              }else{
                                $fallido = true;
                                echo "<div>La dimensión excede el permitido (500x500 px).</div>";
                              }
                            }else{
                              $fallido = true;
                              echo "<div>Formato de imagen no válido. Solo están permitidas en formato jpg y png.</div>";
                            }
                          }
                      }else{
                        $fallido = true;
                        echo "<div>Formato no válido.</div>";
                      }
                    }else{
                      $fallido = true;
                      echo "<div>Error con la subida. Puede que el formato no sea reconodible o el tamaño muy grande. Inténtalo de nuevo o con otra imagen en formato jpg o png</div>";
                    }
                  }
                }

            if (!$fallido){
              $separado_por_comas = implode(",", $campos);

              $sql .= $separado_por_comas;

              $sql .= " WHERE CodUsuario = '" . $codigo . "'";

              $conex->refresh($sql);
              echo "<div>Usuario Modifcado</div>";
            }

            }else{
              echo "<div>La contraseña no coincide con la guardada. Inténtelo de nuevo.</div>";
            }
          }
      ?>
  		<form action="modificarDatos.php" method="POST" class='container' id="usuario" enctype="multipart/form-data">

            <div class='row'>
              <label class='col-md-2 col-md-offset-2'>Contraseña original:</label>
              <div class='col-md-5'>
                <input class='form-control' type = 'password' name='pass' id='pass'/>
              </div>
            </div>

            <div class='row'>
              <label class='col-md-2 col-md-offset-2'>Nueva Contraseña:</label>
              <div class='col-md-5'>
                <input class='form-control' type = 'password' name='nueva_pass' id='nueva_id_pass'/>
              </div>
            </div>

            <div class='row'>
              <label class='col-md-2 col-md-offset-2'>Repite tu nueva Contraseña:</label>
              <div class='col-md-5'>
                <input class='form-control' type = 'password' name='nueva_pass2' id='nueva_id_pass2'/>
              </div>
            </div>

            <div class='row'>
              <label class='col-md-2 col-md-offset-2'>Mail:</label>
              <div class='col-md-5'>
                <input class='form-control' type = 'text' name='mail' id='id_mail'/>
              </div>
            </div>

            <div class='row'>
              <label class='col-md-2 col-md-offset-2' for="imagen">Subir imagen:</label>
               <div class='col-md-5'>
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                <input type="file" name="imagen_usuario" id="imagen" />
              </div>
            </div>
            <div class='row'>
              <input class='col-md-offset-2 btn btn-primary' type = 'submit' value = 'Modificar' id = "boton"/>
              <a class='col-md-offset-5' href="index.php">Volver al inicio</a>
            </div>
      </form>
    </div>
  </BODY>
</HTML>
