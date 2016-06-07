<?php
  include "basedatos.php";
  $conex=new Conexion("root","","frikily");
  $conex->connect();
  $codigo = $_POST['codigo'];
  $usuario = $_POST['usuario'];
  $codigoCap = 0;
  if($_POST['capitulo'] != null)
  {
    $codigoCap = $_POST['capitulo'];
  }
  echo $codigoCap;
  $todoCorrecto = false;
  $exists = false;
  $vistos = $conex->consult("SELECT * FROM `visto`");
  foreach($vistos as $visto)
  {
    if($visto[0] == $usuario && $visto[1] == $codigo && $visto[2] == $codigoCap)
    {
      $exists = true;
    }
  }
  if($exists)
  {
    $todoCorrecto = $conex->refresh("DELETE FROM visto  WHERE CodigoUsuario = '".$usuario."' AND Codigo = '".$codigo."' AND CodigoEpisodio = '".$codigoCap."'");
  }
  else
  {
    $todoCorrecto = $conex->refresh("INSERT INTO visto VALUES ('".$usuario."','".$codigo."','".$codigoCap."')");
  }
  echo $todoCorrecto;
?>
