<?php
  session_start();
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
          $sql = "UPDATE usuarios SET ";
          $campos = [];
          $codigo = $_SESSION['codigo'];

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

                if (isset($_FILES['imagen_usuario'])){
                  if ($_FILES["imagen_usuario"]["name"] != "") {
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
                              array_push($campos, "Imagen = '".$imagen."' ");
                              $_SESSION['imgusu'] = $imagen;
                              echo $_SESSION['imgusu'];
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
               }
             }
           
              $separado_por_comas = implode(",", $campos);

              $sql .= $separado_por_comas;

              $sql .= " WHERE CodUsuario = '".$codigo."' ";
              $conex->refresh($sql);
              echo "<div>Usuario Modifcado</div>";

            }else{
              echo "<div>La contraseña no coincide con la guardada. Inténtelo de nuevo.</div>";
            }  
          }
			?> 
  	
      Modificar datos de usuario
  		<form action="modificarDatos.php" method="POST" id="usuario" enctype="multipart/form-data">

            <div>
              <label>Contraseña original:</label>
              <input type = 'password' name='pass' id='pass'/>
            </div>

            <div>
              <label>Nueva Contraseña:</label>
              <input type = 'password' name='nueva_pass' id='nueva_id_pass'/>
            </div>

            <div>
              <label>Repite tu nueva Contraseña:</label>
              <input type = 'password' name='nueva_pass2' id='nueva_id_pass2'/>
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

            <input type = 'submit' value = 'Modifcar' id = "boton"/>
            <a href="index.php">Volver al inicio</a>
      </form>

    </div>
  </BODY>
</HTML>