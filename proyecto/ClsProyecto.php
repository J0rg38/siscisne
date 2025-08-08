<?php
//ini_set ('error_reporting',  ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set("display_errors", 1);
////error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

date_default_timezone_set('America/Lima');

//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
//ini_set ('error_reporting',E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
ini_set('memory_limit', '1024M');

ini_set('post_max_size', '256M');
ini_set('upload_max_filesize', '256M');

//ini_set('max_input_vars', 1500);
//ini_set('suhosin.post.max_vars', 1500);
//ini_set('suhosin.request.max_vars', 1500);


//ini_set('post_max_size', '64M');
//ini_set('upload_max_filesize', '64M');
//ini_set('session.cookie_lifetime',  108000); // 240 segundos p.ej.
set_time_limit(50000);
//setlocale(LC_ALL,"es_ES@euro","es_ES","esp","es");

//ini_set("session.gc_maxlifetime", "36000");
if (session_status() == PHP_SESSION_NONE) {
    ini_set("session.cookie_lifetime","108000");
    ini_set("session.gc_maxlifetime","108000");
}

class ClsProyecto{

	public $Ruta;
	private $RutClases;
	private $RutFormularios;
	private $RutLibrerias;
	private $RutFunciones;
	private $RutMenus;
	private $RutEstilos;
	private $RutMensajes;
	private $RutConfiguraciones;
	private $RutComunes;
	private $RutImagenes;
	private $RutSpry;
	private $RutFuentes;
	
	private $ArcPrincipal;
	
	public function __construct(){
		$this->RutClases = 'clases/';	
		$this->RutConexiones = 'conexiones/';			
		$this->RutFormularios = 'formularios/';
		$this->RutLibrerias = 'librerias/';
		$this->RutFunciones = 'funciones/';
		$this->RutMenus = 'menus/';
		$this->RutEstilos = 'estilos/';
		$this->RutMensajes = 'mensajes/';
		$this->RutConfiguraciones = 'configuraciones/';
		$this->RutComunes = 'comunes/';
		$this->RutImagenes = 'imagenes/';
		$this->RutGenerados = 'generados/';
		$this->RutSpry = 'SpryAssets/';
		$this->RutFuentes = 'Fuentes/';
		$this->ArcPrincipal = "principal.php";
	}
	
	public function MtdBorrarRuta(){
		$this->Ruta = '';
	}
	
	
	public function MtdRutClases(){
		return $this->Ruta.$this->RutClases;
	}
//	
	public function MtdRutConexiones(){
		return $this->Ruta.$this->RutConexiones;
	}
//	
	public function MtdRutFormularios(){
		return $this->Ruta.$this->RutFormularios;
	}
//	
	public function MtdRutLibrerias(){
		return $this->Ruta.$this->RutLibrerias;
	}
//	
	public function MtdRutFunciones(){
		return $this->Ruta.$this->RutFunciones;
	}
//
//	public function MtdRutMenus(){
//		return $this->Ruta.$this->RutMenus;
//	}
//	
	public function MtdRutEstilos(){
		return $this->Ruta.$this->RutEstilos;
	}	
//	
	public function MtdRutMensajes(){
		return $this->Ruta.$this->RutMensajes;
	}	
//
	public function MtdRutConfiguraciones(){
		return $this->Ruta.$this->RutConfiguraciones;
	}
//	
	public function MtdRutSpry(){
		return $this->Ruta.$this->RutSpry;
	}
		
	public function MtdRutComunes(){
		return $this->Ruta.$this->RutComunes;
	}
	
	public function MtdRutImagenes(){
		return $this->Ruta.$this->RutImagenes;
	}
	
	public function MtdRutGenerados(){
		return $this->Ruta.$this->RutGenerados;
	}
//	
//	public function MtdRutFuentes(){
//		return $this->Ruta.$this->RutFuentes;
//	}
//			
	public function MtdConfiguracionesXml(){
		return $this->Ruta.$this->RutConfiguraciones.'/xml/';
	}
	
	
	


	
	public function MtdFormulariosCss($oForm){	
		return $this->MtdRutFormularios().''.$oForm.'/css/';
	}
	
	public function MtdFormulariosMsj($oForm){	
		return $this->MtdRutFormularios().''.$oForm.'/msj/';
	}

	public function MtdFormulariosJs($oForm){	
		return $this->MtdRutFormularios().''.$oForm.'/js/';
	}
	
	public function MtdFormulariosAcc($oForm){	
		return $this->MtdRutFormularios().''.$oForm.'/acc/';
	}





	public function MtdComunes($oForm){	
		return $this->MtdRutComunes().''.$oForm;
	}

	public function MtdComunesJs($oForm){	
		return $this->MtdRutComunes().''.$oForm.'/js/';
	}

	public function MtdComunesCss($oForm){	
		return $this->MtdRutComunes().''.$oForm.'/css/';
	}
//		
//		
//	public function MtdArcPrincipal(){
////		return $this->Ruta.$this->ArcPrincipal;
//		return $this->ArcPrincipal;
//	}
		
}

$InsProyecto = new ClsProyecto();
?>