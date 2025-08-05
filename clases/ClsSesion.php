<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSesion
 *
 * @author Ing. Jonathan Blanco Alave
 */
class ClsSesion {
    //put your code here
	public $SesId;
    public $SesUsuario;
    public $SesNombre;
    public $SesRol;
	public $SesFoto;
	public $SesEstado;
	
	public $SesTiempoInicio;
    public $SesTiempoFin;
	public $SesUltimaSesion;

	public $SesAviso;
	
	public $Ruta;
		
    public function __construct(){
		//$this->SesUltimaSesion = 'No se ha registrado ninguna sesion anteriormente';
        if(!isset($_SESSION)){
           session_start();	   
        }
    }
    
	
	public function MtdRevivirSesion(){

		$Revivir = false;
		//session_start();
		
		if (isset($_COOKIE['Sesion'])) {
			foreach ($_COOKIE['Sesion'] as $name => $value) {
				$name = htmlspecialchars($name);
				$value = htmlspecialchars($value);
				$_SESSION[$name] = $value;
			}
		}

		//deb($_COOKIE['Sesion']);
		if($_SESSION['SesionIniciado']){
			$Revivir = true;
		}
//
//		$_SESSION['SesionIniciado'] = true;
//		$_SESSION['SesionId'] = $this->SesId;	
//        $_SESSION['SesionUsuario'] = $this->SesUsuario;
//        $_SESSION['SesionNombre'] = $this->SesNombre;
//		$_SESSION['SesionPersonal'] = $this->SesPersonal;
//        $_SESSION['SesionRol'] = $this->SesRol;
//		$_SESSION['SesionFoto'] = $this->SesFoto;
//		$_SESSION['SesionEstado'] = $this->SesEstado;
//		
//        $_SESSION['SesionTiempoInicio'] = $this->SesTiempoInicio;
//        $_SESSION['SesionTiempoFin'] = $this->SesTiempoFin;   
//		$_SESSION['SesionUltimaSesion'] = $this->SesUltimaSesion; 
//		 
//		$_SESSION['SesionAviso'] = $this->SesAviso;  
//		
//		
	
		return $Revivir;
		
	}
	
    public function MtdIniciarSesion(){


		// crear las cookies
//		setcookie("cookie[tres]", "cookietres");
//		setcookie("cookie[dos]", "cookiedos");
//		setcookie("cookie[uno]", "cookieuno");
//		
//		// imprimirlas luego que la página es recargada
//		if (isset($_COOKIE['cookie'])) {
//			foreach ($_COOKIE['cookie'] as $name => $value) {
//				$name = htmlspecialchars($name);
//				$value = htmlspecialchars($value);
//				echo "$name : $value <br />\n";
//			}
//		}
//		setcookie( "Sesion[SesionIniciado]", false, time() -3600 );
//		setcookie( "Sesion[SesionId]", "", time() -3600 );
//		setcookie( "Sesion[SesionUsuario]", "", time() -3600 );
//		setcookie( "Sesion[SesionNombre]", "", time() -3600 );
//		setcookie( "Sesion[SesionPersonal]", "", time() -3600 );
//		setcookie( "Sesion[SesionRol]", "", time() -3600 );
//		setcookie( "Sesion[SesionFoto]", "", time() -3600 );
//		setcookie( "Sesion[SesionEstado]", "", time() -3600 );
//		setcookie( "Sesion[SesionTiempoInicio]", "", time() -3600 );
//		setcookie( "Sesion[SesionTiempoFin]", "", time() -3600);
//		setcookie( "Sesion[SesionUltimaSesion]", "", time() -3600 );
//		setcookie( "Sesion[SesionAviso]", "", time() -3600 );
		
		setcookie( "Sesion[SesionIniciado]", true, time() + 3600 ,"/");
		setcookie( "Sesion[SesionId]", $this->SesId, time() + 3600 ,"/");
		setcookie( "Sesion[SesionUsuario]", $this->SesUsuario, time() + 3600 ,"/");
		setcookie( "Sesion[SesionNombre]", $this->SesNombre, time() + 3600 ,"/");
		setcookie( "Sesion[SesionPersonal]", $this->SesPersonal, time() + 3600 ,"/");
		setcookie( "Sesion[SesionAlmacen]", $this->SesAlmacen, time() + 3600 ,"/");
		setcookie( "Sesion[SesionSucursal]", $this->SesSucursal, time() + 3600 ,"/");
		
		setcookie( "Sesion[SesionRol]", $this->SesRol, time() + 3600 ,"/");
		setcookie( "Sesion[SesionFoto]", $this->SesFoto, time() + 3600 ,"/");
		setcookie( "Sesion[SesionEstado]", $this->SesEstado, time() + 3600 ,"/");
		setcookie( "Sesion[SesionTiempoInicio]", $this->SesTiempoInicio, time() + 3600 ,"/");
		setcookie( "Sesion[SesionTiempoFin]", $this->SesTiempoFin, time() + 3600 ,"/");
		setcookie( "Sesion[SesionUltimaSesion]", $this->SesUltimaSesion, time() + 3600 ,"/");
		setcookie( "Sesion[SesionAviso]", $this->SesAviso, time() + 3600 ,"/");


		$_SESSION['SesionIniciado'] = true;        
		$_SESSION['SesionId'] = $this->SesId;	
        $_SESSION['SesionUsuario'] = $this->SesUsuario;
        $_SESSION['SesionNombre'] = $this->SesNombre;
		$_SESSION['SesionPersonal'] = $this->SesPersonal;
		$_SESSION['SesionAlmacen'] = $this->SesAlmacen;
		$_SESSION['SesionSucursal'] = $this->SesSucursal;
		
		
		$_SESSION['SesionSucursalNombre'] = $this->SesSucursalNombre;
		$_SESSION['SesionSucursalDireccion'] = $this->SesSucursalDireccion;
		$_SESSION['SesionSucursalDepartamento'] = $this->SesSucursalDepartamento;
		$_SESSION['SesionSucursalProvincia'] = $this->SesSucursalProvincia;
		$_SESSION['SesionSucursalDistrito'] = $this->SesSucursalDistrito;
		$_SESSION['SesionSucursalTelefono'] = $this->SesSucursalTelefono;
		$_SESSION['SesionSucursalEmail'] = $this->SesSucursalEmail;
		$_SESSION['SesionSucursalSiglas'] = $this->SesSucursalSiglas;
		$_SESSION['SesionSistema'] = $this->SesSistema;
		
        $_SESSION['SesionRol'] = $this->SesRol;
		$_SESSION['SesionFoto'] = $this->SesFoto;
		$_SESSION['SesionEstado'] = $this->SesEstado;
		
        $_SESSION['SesionTiempoInicio'] = $this->SesTiempoInicio;
        $_SESSION['SesionTiempoFin'] = $this->SesTiempoFin;   
		$_SESSION['SesionUltimaSesion'] = $this->SesUltimaSesion; 
		 
		$_SESSION['SesionAviso'] = $this->SesAviso;  		
		
		$_SESSION['SesionConcesionario'] = $this->SesConcesionario;  		
		     						
		
    }

    public function MtdCerrarSesion(){
		
		setcookie( "Sesion[SesionIniciado]", false, time() -3600 );
		setcookie( "Sesion[SesionId]", "", time() -3600 );
		setcookie( "Sesion[SesionUsuario]", "", time() -3600 );
		setcookie( "Sesion[SesionNombre]", "", time() -3600 );
		setcookie( "Sesion[SesionPersonal]", "", time() -3600 );
		setcookie( "Sesion[SesionAlmacen]", "", time() -3600 );
		//setcookie( "Sesion[SesionSucursal]", "", time() -3600 );
		
		setcookie( "Sesion[SesionRol]", "", time() -3600 );
		setcookie( "Sesion[SesionFoto]", "", time() -3600 );
		setcookie( "Sesion[SesionEstado]", "", time() -3600 );
		setcookie( "Sesion[SesionTiempoInicio]", "", time() -3600 );
		setcookie( "Sesion[SesionTiempoFin]", "", time() -3600);
		setcookie( "Sesion[SesionUltimaSesion]", "", time() -3600 );
		setcookie( "Sesion[SesionAviso]", "", time() -3600 );
		
	
        $_SESSION['SesionIniciado'] = false;	
			
		unset($_SESSION['SesionId']);
        unset($_SESSION['SesionUsuario']);
        unset($_SESSION['SesionNombre']);
		unset($_SESSION['SesionPersonal']);
		unset($_SESSION['SesionAlmacen']);
		unset($_SESSION['SesionSucursal']);
		
		
        unset($_SESSION['SesionRol']);
		unset($_SESSION['SesionFoto']);	
        unset($_SESSION['SesionEstado']);		
		
		
        unset($_SESSION['SesionTiempoInicio']);
        unset($_SESSION['SesionTiempoFin']);
		unset($_SESSION['SesionUltimaSesion']);
		unset($_SESSION['SesionAviso']);

		unset($_SESSION['SesionSucursalNombre']);
		unset($_SESSION['SesionSucursalDireccion']);
		unset($_SESSION['SesionSucursalDepartamento']);
		unset($_SESSION['SesionSucursalProvincia']);
		unset($_SESSION['SesionSucursalDistrito']);
		unset($_SESSION['SesionSucursalTelefono']);
		unset($_SESSION['SesionSucursalEmail']);
		unset($_SESSION['SesionSucursalSiglas']);
			
			unset($_SESSION['SisSucNombre']);
			unset($_SESSION['SisSucId']);
			unset($_SESSION['SisSucImagen']);
			unset($_SESSION['SisAreId']);
			unset($_SESSION['SisAreNombre']);
			
			
			unset($_SESSION['SisFtaId']);
			unset($_SESSION['BtaId']);
			unset($_SESSION['SisGrtId']);
			unset($_SESSION['SisVtaId']);
			unset($_SESSION['SisNetId']);
			unset($_SESSION['SisCvtId']);
			unset($_SESSION['SisNctId']);
						
			
		//session_destroy();
    }
	
	public function MtdSesionVerificar(){
						
		if(isset($_SESSION['SesionIniciado'])){
			if($_SESSION['SesionIniciado']){
				$Verificar = true;	
			}else{
				$Verificar = false;				
			}
		}else{
				$Verificar = false;						
		}	
		
		return $Verificar;
		
	}
	
    public function MtdDestruirSesion(){
        session_destroy();
    }

/*	public function MtdEscribirSesion(){

		if(@file_exists($this->Ruta.'sesiones/'.$this->SesUsuario.'.txt')){
			$ddf = @fopen($this->Ruta.'sesiones/'.$this->SesUsuario.'.txt','r+');			
		}else{
			$ddf = @fopen($this->Ruta.'sesiones/'.$this->SesUsuario.'.txt','a');	
		}

	
			@fputs($ddf,date("H-i-s-n-j-Y"));
			@fclose($ddf);
	}*/
}
?>
