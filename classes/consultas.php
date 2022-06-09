<?php
	class consulta{
		private $con;
		private $dbhost="localhost";
		private $dbuser="root";
		private $dbpass="root";
		private $dbname="infraestructura_michoacan";
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

		public function lsFortapaz($municipio){
			$sql = "SELECT * FROM fortapaz WHERE id_mun = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function lsFaeispum($municipio){
			$sql = "SELECT * FROM faeispum WHERE claveMunicipio = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function proyectosFaeispum($municipio){
			$sql = "SELECT * FROM proyectos_faeispum_2022 WHERE clave_Municipio = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function encuentraMunicipio($municipio){
			$sql = "SELECT municipio FROM catalogo_municipios WHERE clave_mun = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function lsBienestar($municipio){
			$sql = "SELECT * FROM bienestar_beneficiarios WHERE clave_mun = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function encuentraPrograma($programa){
			$sql = "SELECT programa FROM bienestar_catalogo WHERE id_programa = $programa";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function indicadoresBienestar($municipio){
			$sql = "SELECT * FROM indicadores_bienestar WHERE clave_mun = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function fortapaz_anexos($municipio){
			$sql = "SELECT * FROM fortapaz_anexos WHERE cve_mun = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function listadoMunicipios(){
			$sql = "SELECT * FROM catalogo_municipios";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function incDel($municipio){
			$sql = "SELECT * FROM incidencia_delictiva WHERE cve_mun = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function homicidio($municipio){
			$sql = "SELECT * FROM homicidio WHERE cve_mun = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		public function coneval($municipio){
			$sql = "SELECT * FROM coneval WHERE cve_mun = $municipio";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}

		
		

		public function guardaIntegranteGobierno($miupp, $upp, $tipo_integrante, $nombre, $cargo, $oficio_designacion, $vigente){
			$sql = "INSERT INTO estructuraOrgano (miupp, upp, tipo_integrante, nombre, cargo, oficio_designacion, vigente) 
			VALUES ('$miupp','$upp','$tipo_integrante','$nombre','$cargo','$oficio_designacion','$vigente')";
			$res = mysqli_query($this->con, $sql);
			if($res){
			  return true;
			}else{
			return false;
		 }
		}


		public function actualizaIntegranteGobierno($idIntegrante){
			$sql = "UPDATE estructuraOrgano SET 
			vigente = 0 WHERE id = $idIntegrante";
			$res = mysqli_query($this->con, $sql);
			if($res){
				return true;
			  }else{
			  return false;
		   }
		}

 
}

?>