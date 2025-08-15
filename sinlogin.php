<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require_once('proyecto/ClsProyecto.php');
require_once('proyecto/ClsPoo.php');

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


$InsUsuario = new ClsUsuario();
$InsACL = new ClsACL();

$InsUsuario->UsuUsuario = "jba";
$InsUsuario->UsuContrasena = md5("soporte");
$InsUsuario->MtdEntrarUsuario();


$error = true;

if(!empty($InsUsuario->UsuId)){

	if($InsUsuario->UsuEstado==2){
		$_SESSION['SesAviso'].="#ERR_GEN_102";
	}else{
	
		$error = false;
		
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


	}
	
}else{	

	$_SESSION['SesAviso'].="#ERR_GEN_103";
}



if($error){
	header("Location: login.php");			
}else{
	//Uso: Chat
	//Descripcion:
	//$_SESSION['username'] = $InsUsuario->UsuUsuario."_".$InsUsuario->PerNombre."_".$InsUsuario->PerApellidoPaterno."_".$InsUsuario->PerApellidoMaterno;
	//$_SESSION['username'] = preg_replace("/ /", "_", $_SESSION['username']);
	//Uso: Menu Flotante
	//Descripcion:
	//$_SESSION['SisBarraActivo'] = "si";
	//Uso: Menu de Tipo de Cambio
	//Descripcion:
	$_SESSION['SisTipoCambio'] = true;
	
	$InsUsuario->UsuUltimaSesion = date("Y-m-d H:i:s");
	$InsUsuario->MtdActualizarUltimaSesionUsuario();

	$InsUsuario->UsuUltimaActividad = date("Y-m-d H:i:s");		
	$InsUsuario->MtdActualizarUltimaActividadUsuario();
		
	header("Location: principal.php");
}
?>