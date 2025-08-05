<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCategoria.php');


$POST_Accion = $_POST['Accion'];
$POST_UsuUsuario = $_POST['UsuUsuario'];
$POST_UsuContrasena = $_POST['UsuContrasena'];

switch($POST_Accion){

	case "UsuarioAcceder":
		MtdUsuarioAcceder();
	break;

}	
	
function MtdUsuarioAcceder(){
	
	global $POST_Accion;
	
	global $POST_UsuUsuario;
	global $POST_UsuContrasena;

	global $InsUsuario;

	global $Resultado;

	$Resultado = '';
	$JsResultado = array();
	
	$InsUsuario = new ClsUsuario();
	$InsUsuario->UsuUsuario = $POST_UsuUsuario;
	$InsUsuario->UsuContrasena = md5($POST_UsuContrasena);
	$InsUsuario->MtdEntrarUsuario();
	
	//deb($InsUsuario->UsuUsuario);
	$JsResultado['Respuesta'] = '';	

	$JsResultado['UsuId'] = '';	
	$JsResultado['UsuUsuario'] = '';
	$JsResultado['UsuContrasena'] = '';	
	$JsResultado['PerNombre'] = '';	
	$JsResultado['PerApellidoPaterno'] = '';	
	$JsResultado['PerApellidoMaterno'] = '';	
	$JsResultado['UsuEstado'] = '';	
	
	if(!empty($InsUsuario->UsuId)){
		
		if($InsUsuario->UsuEstado == "2"){

			$JsResultado['Respuesta'] = 'U002';	
			
			$JsResultado['UsuId'] = $InsUsuario->UsuId;	
			$JsResultado['UsuUsuario'] = $InsUsuario->UsuUsuario;	

		}else{
				
			$JsResultado['UsuId'] = $InsUsuario->UsuId;
			$JsResultado['UsuUsuario'] = $InsUsuario->UsuUsuario;	
			$JsResultado['UsuContrasena'] = $InsUsuario->UsuContrasena;	
			$JsResultado['PerNombre'] = $InsUsuario->PerNombre;	
			$JsResultado['PerApellidoPaterno'] = $InsUsuario->PerApellidoPaterno;	
			$JsResultado['PerApellidoMaterno'] = $InsUsuario->PerApellidoMaterno;	
			$JsResultado['UsuEstado'] = $InsUsuario->UsuEstado;	
			
			$InsSesion = new ClsSesion();
		
			$InsSesion->SesId = $InsUsuario->UsuId;
			$InsSesion->SesNombre = $InsUsuario->PerNombre." ".$InsUsuario->PerApellidoPaterno." ".$InsUsuario->PerApellidoMaterno;
			$InsSesion->SesUsuario = $InsUsuario->UsuUsuario;
			$InsSesion->SesRol = $InsUsuario->RolId;
			$InsSesion->SesFoto = $InsUsuario->UsuFoto;
			$InsSesion->SesEstado = $InsUsuario->UsuEstado;
			
			$InsSesion->SesPersonal = $InsUsuario->PerId;
			$InsSesion->SesTiempoInicio = date("Y-m-d H:i:s");
			$InsSesion->SesUltimaSesion = $InsUsuario->UsuUltimaSesion;
			$InsSesion->MtdIniciarSesion();
			
			$InsUsuario->UsuUltimaSesion = date("Y-m-d H:i:s");
			$InsUsuario->MtdActualizarUltimaSesionUsuario();
		
			$InsUsuario->UsuUltimaActividad = date("Y-m-d H:i:s");		
			$InsUsuario->MtdActualizarUltimaActividadUsuario();

			$JsResultado['Respuesta'] = 'U001';	
		}

	} else{	
		$JsResultado['Respuesta'] = 'U003';	
	}
	
	$Resultado = json_encode($JsResultado);
}

echo ($Resultado);
?>