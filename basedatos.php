<?php
class Conexion{
	private $user;
	private $password;
	private $db;
	private $conection;
	private $tipos;
	function __construct($user,$password,$db)
	{
		$this->user=$user;
		$this->password=$password;
		$this->db=$db;
		$this->tipos = [
			'videojuegos',
			'anime',
			'manga',
			'comics',
			'libros',
			'peliculas',
			'series'
		];
	}
	public function connect()
	{
		$this->conection=mysqli_connect('localhost', $this->user, $this->password) or die("error");
		mysqli_select_db($this->conection, $this->db) or die("No se pudo seleccionar la base de datos".mysqli_error($this->conection));
		$this->conection->set_charset("utf8");
	}
	public function consult($sql)
	{
		$returned=[];
		$search=mysqli_query($this->conection, $sql) or die("ha habido un error en la consulta ".mysqli_error($this->conection));
		$i=0;
		while ($line=mysqli_fetch_array($search, MYSQLI_ASSOC))
		{
			array_push($returned,[]);
			foreach ($line as $value)
			{
				array_push($returned[$i],$value);
			}
			$i++;
		}
		mysqli_free_result($search);
		return $returned;
	}
	public function refresh($sql)
	{
		$columNumber=mysqli_query($this->conection, $sql) or die('Consulta fallida: ' . mysqli_error($this->conection));
		if($columNumber>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function insertar($nombre,$pass,$mail,$imagen){
		$comprobacion = "select * from usuarios where Nombre = $nombre";
		$resultadoComprobacion = mysqli_query($this->conection,$comprobacion);

		if ($resultadoComprobacion != null){
			echo "<div>Problema al registrar usuario por tener un usuario registrado con el mismo nombre, intentelo de nuevo.</div>";
		}else{
			 $consulta = "Insert into usuarios (Nombre,Pass,Imagen,Mail,Tipo) values ('$nombre','$pass','$imagen','$mail','usu');";
	    	 $resultado=mysqli_query($this->conection,$consulta) or die("Error al insertar el usuario. Inténtelo de nuevo.");

	        if ($resultado != null){
	            echo "<div>Usuario registrado correctamente.</div>";
	        }
		}
	}

	public function insertarComentario($Codigo,$usuario,$comentario){
		$fecha = strftime( "%Y-%m-%d-%H-%M", time());
		$consulta = "INSERT INTO comentarios (Codigo,CodUsuario,Comentario,Fecha) VALUES ('".$Codigo."','".$usuario."','".$comentario."','".$fecha."')";
       	$resultado= mysqli_query($this->conection,$consulta) or die (mysqli_error($this->conection));
	}

	public function consultaDinamica($seccion, $categoria, $preferencia){
		$consulta = "SELECT  DISTINCT g.codigo,g.nombre,g.nota,g.imagen,g.nota, g.aprobado FROM general g, ".$seccion." t, visto v WHERE g.codigo = t.codigo AND g.aprobado=1";

		if($categoria!=""){
			$consulta = $consulta." AND g.genero LIKE '".$categoria."'";
		}

		if($preferencia!=""){

			if($preferencia=="valorado"){
				$consulta = $consulta." ORDER BY g.nota Desc";
			}

			if($preferencia=="lista"){
					$consulta = $consulta." AND g.codigo = v.codigo AND v.codigousuario = ".$_SESSION['codigo'];
			}

			if($preferencia=="recientes"){
				$consulta = $consulta." ORDER BY g.codigo Desc";
			}
		}
		
		return $consulta;
	}
	
	public function notificaciones(){
		$now = new DateTime();
		$now = $now->format('Y-m-d'); 
		
		$consulta = "SELECT DISTINCT g.codigo,g.nombre,g.imagen,g.nota,e.fecha,g.sinopsis FROM general g, visto v, usuarios u, estrenos e, episodios p WHERE v.codigousuario = u.codusuario AND g.codigo = v.codigo AND e.codigo = g.codigo AND e.fecha >= '".$now."' AND e.codcapitulo = p.codigocapitulo AND u.codusuario=".$_SESSION['codigo'];
		$lista = $this->consult($consulta);
		return count($lista);
	}

	public function sacarTipo($codigo)
	{
		$tipoObjeto = '';
		foreach($this->tipos as $tipo)
		{
			$list = $this->consult('SELECT * FROM `'.$tipo.'` WHERE codigo = '.$codigo);
			if(count($list)>0)
			{
				$tipoObjeto = $tipo;
			}
		}
		return $tipoObjeto;
	}


	public function close()
	{
		mysqli_close($this->conection);
	}
}
?>
