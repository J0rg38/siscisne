<?php


/**
 * Description of ClsConexionLocal
 *
 * @author Jonathan
 */
class ClsConexion
{
	//put your code here

	public $CloBdHost;
	public $CloBdPuerto;

	public $CloBdNombre;
	public $CloBdUsuario;
	public $CloBdContrasena;

	public $CloConexion;


	public $CloConectado;

	function __construct($oDatoConexion = 'local')
	{
		@session_start();

		//echo "ttttt";

		global $ConexionBdHost;
		global $ConexionBdPuerto;
		global $ConexionBdUsuario;
		global $ConexionBdContrasena;
		global $ConexionBdNombre;

		//var_dump($oDatoConexion . "::::");

		$this->CloBdHost = $ConexionBdHost[$oDatoConexion];
		$this->CloBdPuerto = $ConexionBdPuerto[$oDatoConexion];
		$this->CloBdNombre = $ConexionBdNombre[$oDatoConexion];
		$this->CloBdUsuario = $ConexionBdUsuario[$oDatoConexion];
		$this->CloBdContrasena = $ConexionBdContrasena[$oDatoConexion];

		//var_dump($this);
	}

	/*		function __construct(){
			@session_start();

			global $ConexionBdHost;
			global $ConexionBdPuerto;
			global $ConexionBdUsuario;
			global $ConexionBdContrasena;
			global $ConexionBdNombre;

            $this->CloBdHost = $ConexionBdHost['local'];
			$this->CloBdPuerto = $ConexionBdPuerto['local'];
			$this->CloBdNombre = $ConexionBdNombre['local'];
			$this->CloBdUsuario = $ConexionBdUsuario['local'];
			$this->CloBdContrasena = $ConexionBdContrasena['local'];
				
		}*/

	function __destruct()
	{
		//	mysql_close($this->Conexion);
	}

	public function MtdConectar()
	{

		if ($_SESSION['MysqlDeb']) {
			/*  
				    echo "<b>";
		   echo "Conectando...";
		   echo "</b>";
		   echo "<br>";*/
		}

		$this->CloConectado = true;

		if (!empty($this->CloBdPuerto)) {
			//echo $this->CloBdHost.":".$this->CloBdPuerto." - ".$this->CloBdUsuario. " ".$this->CloBdContrasena;
			//$this->CloConexion = mysql_connect($this->CloBdHost.":".$this->CloBdPuerto, $this->CloBdUsuario, $this->CloBdContrasena);			
			//$this->CloConexion = new mysqli($this->CloBdHost.":".$this->CloBdPuerto, $this->CloBdUsuario, $this->CloBdContrasena, $this->CloBdNombre);
			$this->CloConexion = mysqli_connect($this->CloBdHost . ":" . $this->CloBdPuerto, $this->CloBdUsuario, $this->CloBdContrasena, $this->CloBdNombre);
			//$link = mysqli_connect("localhost", "my_user", "my_password", "world");

		} else {
			//$this->CloConexion = mysql_connect($this->CloBdHost, $this->CloBdUsuario, $this->CloBdContrasena);
			//$this->CloConexion = new mysqli($this->CloBdHost, $this->CloBdUsuario, $this->CloBdContrasena, $this->CloBdNombre);
			$this->CloConexion = mysqli_connect($this->CloBdHost, $this->CloBdUsuario, $this->CloBdContrasena, $this->CloBdNombre);
		}

		//
		if (!$this->CloConexion) {

			$this->CloConectado = false;
		} else {

			//mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $this->CloConexion);
			mysqli_query($this->CloConexion, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
			//mysql_select_db($this->CloBdNombre, $this->CloConexion);

			//if(mysql_error($this->CloConexion)){     
			if (mysqli_error($this->CloConexion)) {
				//echo "::: ".mysql_error($this->CloConexion);              
				echo "::: " . mysqli_error($this->CloConexion);
				echo "No se pudo encontrar la base de datos. <br>";
				$this->CloConectado = false;
			}
		}

		return $this->CloConectado;
	}

	public function MtdDesconectar()
	{

		if ($this->CloConectado) {
			if (!@mysqli_close($this->CloConexion)) {
				echo "No se pudo desconectar del host <br>";
			}
		}
	}

	/*public function MtdEstablecerDatosConexion(){
			
			@session_start();
			$Establecido = true;
			
		 	if(!isset($_SESSION[$SistemaAliasSesion.'SesBd'])){
				$_SESSION[$SistemaAliasSesion.'SesBd']['Host'] = $this->CloBdHost;
				$_SESSION[$SistemaAliasSesion.'SesBd']['Puerto'] = $this->CloBdPuerto;
				
				$_SESSION[$SistemaAliasSesion.'SesBd']['Nombre'] = $this->CloBdNombre;
				$_SESSION[$SistemaAliasSesion.'SesBd']['Usuario'] = $this->CloBdUsuario;
				$_SESSION[$SistemaAliasSesion.'SesBd']['Contrasena'] = $this->CloBdContrasena;
				
			}
			
			if(empty($_SESSION[$SistemaAliasSesion.'SesBd']['Host']) || empty($_SESSION[$SistemaAliasSesion.'SesBd']['Nombre'])){
				$Establecido = false;			
			}
					
			return $Establecido;						
		}*/


	/*public function MtdVaciarDatosConexion(){
			//session_start();
		 	if(isset($_SESSION[$SistemaAliasSesion.'SesBd'])){
				unset($_SESSION[$SistemaAliasSesion.'SesBd']);
			}
		}*/
}
