<?php
session_start();
  session_destroy();
?>
<HTML>
  <HEAD>
    <TITLE>Registrar Usuario</TITLE>
     <meta http-equiv="content-type" content="text/html;charset=utf-8" />
     <link rel="stylesheet" type="text/css" href="registrar.css"/>
</HEAD>
  <BODY>  
  	<div class="registro">
  	<h1>REGISTRO DE USUARIOS<h1>

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
                        echo "<div>El tamaño excede el permitido.</div>";
                      }
                    }else{ 
                      echo "<div>Error en la subida. Inténtalo de nuevo.</div>"; 
                    } 
                  }else{
                    echo "<div>La dimensión excede el permitido (500x500 px).</div>";
                  }
                }else{
                  echo "<div>Formato de imagen no válido. Solo están permitidas en formato jpg y png.</div>";
                }
              }
            }
			?> 
  	
  		<form action="registrar.php" method="POST" id="usuario" enctype="multipart/form-data">

  		<div>
              <label>Usuario:</label>
              <input type = 'text' name='usuario' id='id_usuario'/>
            </div>

            <div>
              <label>Contraseña:</label>
              <input type = 'password' name='pass' id='id_pass'/>
            </div>

            <div>
              <label>Mail:</label>
              <input type = 'text' name='mail' id='id_mail'/>
            </div>

            <div>
              <label for="imagen">Subir imagen:</label>
              <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
              <input type="file" name="imagen_usuario" id="imagen" />
            </div>

            <input type = 'submit' value = 'Registrar' id = "boton"/>
            <a href="index.php">Volver al inicio</a>
</form>

    </div>
  </BODY>
</HTML>