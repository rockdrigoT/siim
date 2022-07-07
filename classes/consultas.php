<?php
	class consultasAcuerdos{
		private $con;
		private $dbhost="localhost";
		private $dbuser="root";
		private $dbpass="root";
		private $dbname="acuerdos";
		function __construct(){
			$this->connect_db();
		}
		public function connect_db(){
			$this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
			$this->con->set_charset("utf8");
			if(mysqli_connect_error()){
				die("Conexión a la base de datos falló " . mysqli_connect_error() . mysqli_connect_errno());
			}
		}

		public function listarAcuerdosUPP($upp){
			$sql = "SELECT * FROM acuerdosGabinete WHERE uppResponsable = $upp";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function listarTodosAcuerdosLibreta($libreta){
			$sql = "SELECT * FROM acuerdosGabinete WHERE libreta = $libreta AND estatus = 0 ";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		
		
		public function listarTodosAcuerdosUPP(){
			$sql = "SELECT * FROM acuerdosGabinete";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}


        public function EncuentraUpp($upp){
			$sql = "SELECT * FROM catalogo_upp WHERE upp = $upp";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}


		public function EnlistarUPP(){
			$sql = "SELECT * FROM catalogo_upp ORDER BY denominacion ASC";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function seleccionaUppColaboradoras($idAcuerdo){
			$sql = "SELECT * FROM acuerdosGabColaboradores WHERE idAcuerdo = $idAcuerdo";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function muestraComentarios($idAcuerdo){
			$sql = "SELECT * FROM acuerdosGabComentarios WHERE idAcuerdo = $idAcuerdo ORDER BY bitacora ASC";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function encuentraColaboracion($miUpp){
			$sql = "SELECT DISTINCT idAcuerdo FROM acuerdosGabColaboradores WHERE uppColaboradora = $miUpp AND estatus = 0 ";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function encuentraColaboracionProceso($miUpp){
			$sql = "SELECT DISTINCT idAcuerdo FROM acuerdosGabColaboradores WHERE uppColaboradora = $miUpp AND estatus = 1 ";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function encuentraColaboracionTerminados($miUpp){
			$sql = "SELECT DISTINCT idAcuerdo FROM acuerdosGabColaboradores WHERE uppColaboradora = $miUpp AND estatus = 2 ";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function muestraColaboracion($idAcuerdoColaboracion){
			$sql = "SELECT * FROM acuerdosGabinete WHERE idAcuerdo = $idAcuerdoColaboracion";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}


		public function seleccionaLibretas($upp){
			$sql = "SELECT * FROM libretas WHERE uppLibreta = $upp";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function abreLibreta($idLibreta){
			$sql = "SELECT * FROM libretas WHERE id = $idLibreta";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}


		public function guardaLibretaNueva($uppLibreta, $nombre, $descripcion, $autor, $fechaRegistro){
			$sql = "INSERT INTO libretas (uppLibreta, nombre, descripcion, autor, fechaRegistro) 
			VALUES ('$uppLibreta','$nombre','$descripcion','$autor','$fechaRegistro')";
			$res = mysqli_query($this->con, $sql);
			if($res){
			  return true;
			}else{
			return false;
		 }
		}

		public function guardaNuevoAcuerdo($uppResponsable, $acuerdo, $fechaRegistro, $libreta, $autor, ){
			$sql = "INSERT INTO acuerdosGabinete (uppResponsable, acuerdo, fechaRegistro, libreta, autor) 
			VALUES ('$uppResponsable','$acuerdo','$fechaRegistro','$libreta','$autor')";
			$res = mysqli_query($this->con, $sql);
			if($res){
			  return true;
			}else{
			return false;
		 }
		}

		public function agregarColaborador($idAcuerdo, $uppColaboradora){
			$sql = "INSERT INTO acuerdosGabColaboradores (idAcuerdo, uppColaboradora) 
			VALUES ('$idAcuerdo','$uppColaboradora')";
			$res = mysqli_query($this->con, $sql);
			if($res){
			  return true;
			}else{
			return false;
		 }
		}

		public function agregarComentario($idAcuerdo, $comentario, $upp, $bitacora){
			$sql = "INSERT INTO acuerdosGabComentarios (idAcuerdo, comentario, upp, bitacora) 
			VALUES ('$idAcuerdo','$comentario','$upp','$bitacora')";
			$res = mysqli_query($this->con, $sql);
			if($res){
			  return true;
			}else{
			return false;
		 }
		}


		public function actualizacComentarioAcuerdo($idAcuerdo, $comentario){
			$sql = "UPDATE acuerdosGabinete SET 
			comentario = '$comentario'
			WHERE idAcuerdo = $idAcuerdo";
			$res = mysqli_query($this->con, $sql);
			if($res){
				return true;
			  }else{
			  return false;
		   }
		}

		public function GuardaReporte200dias($accion, $upp, $meta, $unidadMedida, $inversion){
			$sql = "INSERT INTO 200dias (accion, upp, meta, unidadMedida, inversion) 
			VALUES ('$accion','$upp','$meta','$unidadMedida','$inversion')";
			$res = mysqli_query($this->con, $sql);
			if($res){
			  return true;
			}else{
			return false;
		 }
		}


		public function eliminarColaborador($idAcuerdo, $uppColaboradora){
			$sql = "DELETE FROM acuerdosGabColaboradores WHERE uppColaboradora = $uppColaboradora AND idAcuerdo = $idAcuerdo";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		
		public function listarTodosAcuerdosNuevosUPP(){
			$sql = "SELECT * FROM acuerdosGabinete WHERE estatus = 0 ORDER BY idAcuerdo ASC";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function listarTodosAcuerdosNuevosUPPFiltrado($uppMostrar){
			$sql = "SELECT * FROM acuerdosGabinete WHERE estatus = 0 AND uppResponsable = '$uppMostrar' ORDER BY idAcuerdo ASC";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function listarTodosAcuerdosProcesoUPP(){
			$sql = "SELECT * FROM acuerdosGabinete WHERE estatus = 1";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function listarTodosAcuerdosProcesoUPPFiltrado($uppMostrar){
			$sql = "SELECT * FROM acuerdosGabinete WHERE estatus = 1 AND uppResponsable = '$uppMostrar' ORDER BY idAcuerdo ASC";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function listarTodosAcuerdosProcesoUPPLibreta($libreta){
			$sql = "SELECT * FROM acuerdosGabinete WHERE estatus = 1 AND libreta = '$libreta' ORDER BY idAcuerdo ASC";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function listarTodosAcuerdosAtendidosUPP(){
			$sql = "SELECT * FROM acuerdosGabinete WHERE estatus = 2 ORDER BY fechaTermino ASC";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		
		public function listarTodosAcuerdosAtendidosUPPFiltrado($uppMostrar){
			$sql = "SELECT * FROM acuerdosGabinete WHERE estatus = 2 AND uppResponsable='$uppMostrar' ORDER BY fechaTermino ASC";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		
		public function listarTodosAcuerdosAtendidosLibreta($libreta){
			$sql = "SELECT * FROM acuerdosGabinete WHERE estatus = 2 AND libreta='$libreta' ORDER BY fechaTermino ASC";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		
		public function acuerdoProceso($idAcuerdo){
			$sql = "UPDATE acuerdosGabinete SET 
			estatus = 1
			WHERE idAcuerdo = $idAcuerdo";
			$res = mysqli_query($this->con, $sql);
			if($res){
				return true;
			  }else{
			  return false;
		   }
		}

		public function acuerdoTerminado($idAcuerdo, $fechaTermino){
			$sql = "UPDATE acuerdosGabinete SET 
			estatus = 2,
			fechaTermino = '$fechaTermino'
			WHERE idAcuerdo = $idAcuerdo";
			$res = mysqli_query($this->con, $sql);
			if($res){
				return true;
			  }else{
			  return false;
		   }
		}


		public function acuerdoArchivado($idAcuerdo){
			$sql = "UPDATE acuerdosGabinete SET 
			estatus = 3
			WHERE idAcuerdo = $idAcuerdo";
			$res = mysqli_query($this->con, $sql);
			if($res){
				return true;
			  }else{
			  return false;
		   }
		}

		public function borrarAcuerdo($idAcuerdo){
			$sql = "DELETE FROM acuerdosGabinete WHERE idAcuerdo = $idAcuerdo";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function borraLibreta($libreta){
			$sql = "DELETE FROM libretas WHERE id = $libreta";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		       
}

?>
