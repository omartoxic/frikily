<?php
  include "basedatos.php";
  $conex=new Conexion("root","","frikily");
  $conex->connect();
  $codigo = $_POST['codigo'];
  $usuario = $_POST['usuario'];
  $capitulos = $conex->consult("SELECT * FROM `episodios` WHERE Codigo = ".$codigo);
  $vistos = $conex->consult("SELECT * FROM `visto` WHERE CodigoUsuario = ".$usuario." AND Codigo = ".$codigo);
  if(count($capitulos) == count($vistos))
  {
    echo true;
  }
  else
  {
    echo false;
  }
?>
