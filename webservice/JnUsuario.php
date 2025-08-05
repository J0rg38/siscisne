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


require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$POST_Accion = $_POST['Accion'];
$POST_UsuarioUsuario = $_POST['UsuarioUsuario'];
$POST_UsuarioContrasena = $_POST['UsuarioContrasena'];

switch($POST_Accion){

	case "UsuarioAcceder":
		MtdUsuarioAcceder();
	break;

}	
	
function MtdUsuarioAcceder(){
	
	global $POST_Accion;
	
	global $POST_UsuarioUsuario;
	global $POST_UsuarioContrasena;

	global $InsUsuario;

	global $Resultado;

	$Resultado = '';
	$JsResultado = array();
	
	$InsUsuario = new ClsUsuario();
	$InsUsuario->UsuUsuario = $POST_UsuarioUsuario;
	$InsUsuario->UsuContrasena = md5($POST_UsuarioContrasena);
	$InsUsuario->MtdEntrarUsuario();
	
	$JsResultado['POST_UsuUsuario'] =  $POST_UsuarioUsuario;
	$JsResultado['POST_UsuContrasena'] = $POST_UsuarioContrasena;	
	
	
	//deb($InsUsuario->UsuUsuario);
	$JsResultado['Respuesta'] = '';	

	$JsResultado['UsuId'] = '';	
	$JsResultado['UsuUsuario'] = '';
	$JsResultado['UsuContrasena'] = '';	
	$JsResultado['UsuCelular'] = '';	
	$JsResultado['UsuEmail'] = '';	
	$JsResultado['UsuEstado'] = '';	
	
	$JsResultado['PerNombre'] = '';	
	$JsResultado['PerApellidoPaterno'] = '';	
	$JsResultado['PerApellidoMaterno'] = '';	
	
	
	if(!empty($InsUsuario->UsuId)){
		
		if($InsUsuario->UsuEstado == "2"){

			$JsResultado['Respuesta'] = 'U002';	
			
			$JsResultado['UsuId'] = $InsUsuario->UsuId;	
			$JsResultado['UsuUsuario'] = $InsUsuario->UsuUsuario;	

		}else{
				
			$JsResultado['UsuId'] = $InsUsuario->UsuId;
			$JsResultado['UsuUsuario'] = $InsUsuario->UsuUsuario;	
			$JsResultado['UsuContrasena'] = $InsUsuario->UsuContrasena;	
			$JsResultado['UsuEstado'] = $InsUsuario->UsuEstado;	
			
			$JsResultado['PerNombre'] = $InsUsuario->PerNombre;	
			$JsResultado['PerApellidoPaterno'] = $InsUsuario->PerApellidoPaterno;	
			$JsResultado['PerApellidoMaterno'] = $InsUsuario->PerApellidoMaterno;	
			
			
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