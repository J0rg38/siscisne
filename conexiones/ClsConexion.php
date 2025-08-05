<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsConexionLocal
 *
 * @author Ing. Jonathan Blanco Alave
 */
class ClsConexion {
    //put your code here

	private $CloBdHost;
	private $CloBdPuerto;
	
	private $CloBdNombre;
	private $CloBdUsuario;
	private $CloBdContrasena;
	
    public $CloConexion;
	
	public $CloConectado;

		function __construct(){
			
			global $ConexionBdHost;
			global $ConexionBdPuerto;
			global $ConexionBdUsuario;
			global $ConexionBdContrasena;
			global $ConexionBdNombre;
				
			
            $this->CloBdHost = $ConexionBdHost;
			$this->CloBdPuerto = $ConexionBdPuerto;
			$this->CloBdNombre = $ConexionBdNombre;
			$this->CloBdUsuario = $ConexionBdUsuario;
			$this->CloBdContrasena = $ConexionBdContrasena;

		}
		
		function __destruct(){
			//	mysql_close($this->Conexion);
		}

		public function MtdConectar(){
           
			$this->CloConectado = true;
			
			if(!empty($this->CloBdPuerto)){
				$this->CloConexion = mysql_connect($this->CloBdHost.":".$this->CloBdPuerto, $this->CloBdUsuario, $this->CloBdContrasena);
			}else{
				$this->CloConexion = mysql_connect($this->CloBdHost, $this->CloBdUsuario, $this->CloBdContrasena);
			}
			
			
			
            if (!$this->CloConexion) {
			   $this->CloConectado = false;
			} else {
				mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $this->CloConexion);
				mysql_select_db($this->CloBdNombre, $this->CloConexion);
				if(mysql_error($this->CloConexion)){                   
					echo "No se pudo encontrar la base de datos. <br>";
					$this->CloConectado = false;
				}
			}   
			
			
			return $this->CloConectado;
		}
		
	
		
		public function MtdDesconectar(){
			if($this->CloConectado){
                if(!@mysql_close($this->CloConexion)){
					echo "No se pudo desconectar del host <br>";
				}
            }
		}
		
		//public function MtdEstablecerDatosConexion(){
//			
//			
//			$Establecido = true;
//			
//		 	if(!isset($_SESSION['SesBd'])){
//			
//				global $ConexionBdHost;
//				global $ConexionBdPuerto;
//				global $ConexionBdUsuario;
//				global $ConexionBdContrasena;
//				global $ConexionBdNombre;
//				
//				@session_start();
//				$_SESSION['SesBd']['Host'] = $ConexionBdHost;
//				
//				$_SESSION['SesBd']['Puerto'] = $ConexionBdPuerto;
//				$_SESSION['SesBd']['Nombre'] = $ConexionBdNombre;
//				$_SESSION['SesBd']['Usuario'] = $ConexionBdUsuario;
//				$_SESSION['SesBd']['Contrasena'] = $ConexionBdContrasena;
//			
////				$_SESSION['SesBd']['Host'] = $this->CloBdHost;
////				$_SESSION['SesBd']['Puerto'] = $this->CloBdPuerto;
////				
////				$_SESSION['SesBd']['Nombre'] = $this->CloBdNombre;
////				$_SESSION['SesBd']['Usuario'] = $this->CloBdUsuario;
////				$_SESSION['SesBd']['Contrasena'] = $this->CloBdContrasena;
//				
//			}
//			
//			if(empty($_SESSION['SesBd']['Host']) || empty($_SESSION['SesBd']['Nombre']) || empty($_SESSION['SesBd']['Usuario'])){
//				$Establecido = false;			
//			}
//					
//			return $Establecido;						
//		}
//		
//		
//		public function MtdVaciarDatosConexion(){
//			//session_start();
//		 	if(isset($_SESSION['SesBd'])){
//				unset($_SESSION['SesBd']);
//			}
//		}
}
?>