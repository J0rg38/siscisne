<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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

$POST_Usuario   = isset($_POST['CmpUsuario'])   ? $_POST['CmpUsuario']   : null;
$POST_Contrasena= isset($_POST['CmpContrasena'])? $_POST['CmpContrasena']: null;
$POST_Almacen   = isset($_POST['CmpAlmacen'])   ? $_POST['CmpAlmacen']   : null;
$POST_Sucursal  = isset($_POST['CmpSucursal'])  ? $_POST['CmpSucursal']  : null;


require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsUsuario = new ClsUsuario();
$InsACL = new ClsACL();
$InsSucursal = new ClsSucursal();

$InsUsuario->UsuUsuario = $POST_Usuario;
$InsUsuario->UsuContrasena = md5($POST_Contrasena);
$InsUsuario->AlmId = $POST_Almacen;
$InsUsuario->SucId = $POST_Sucursal;
$InsUsuario->MtdEntrarUsuario();

if(!empty($POST_Sucursal)){
	
	$InsSucursal = new ClsSucursal();
	$InsSucursal->SucId = $POST_Sucursal;
	$InsSucursal->MtdObtenerSucursal();
	
}


//$InsTipoCambio->MonId = "MON-10001";
//$InsTipoCambio->TcaFecha = date("Y-m-d");
//
//
//$InsTipoCambio->MtdObtenerTipoCambioActual();
//
//if(!empty($InsTipoCambio->TcaId)){
//	 $_SESSION['SisTipoCambioCompra']['MON-10001'] = $InsTipoCambio->TcaMontoCompra;
//	 $_SESSION['SisTipoCambioVenta']['MON-10001'] = $InsTipoCambio->TcaMontoVenta; 		
//}
		
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
		
		$InsSesion->SesAlmacen = $POST_Almacen;
		$InsSesion->SesSucursal = $POST_Sucursal;
		
		$InsSesion->SesSucursalNombre = $InsSucursal->SucNombre;
		$InsSesion->SesSucursalDireccion = $InsSucursal->SucDireccion;
		$InsSesion->SesSucursalDepartamento = $InsSucursal->SucDepartamento;
		$InsSesion->SesSucursalProvincia = $InsSucursal->SucProvincia;
		$InsSesion->SesSucursalDistrito = $InsSucursal->SucDistrito;
		$InsSesion->SesSucursalTelefono = $InsSucursal->SucTelefono;
		$InsSesion->SesSucursalEmail = $InsSucursal->SucEmail;
		$InsSesion->SesSucursalSiglas = $InsSucursal->SucSiglas;
		$InsSesion->SesConcesionario = "ONC-10007";
		$InsSesion->SesSistema = $SistemaNombreAbreviado;
		
		$InsSesion->MtdIniciarSesion();
		//
//			unset($_SESSION['InsRolZonaPrivilegio']);
//			
//			$_SESSION['InsRolZonaPrivilegio'] = new ClsSesionObjeto();
//			
//			foreach($InsUsuario->RolZonaPrivilegio as $DatRolZonaPrivilegio){
//				$_SESSION['InsRolZonaPrivilegio']->MtdAgregarSesionObjeto(1,
//				$DatRolZonaPrivilegio->RzpId,
//				$DatRolZonaPrivilegio->RolId,
//				$DatRolZonaPrivilegio->ZprId,
//				$DatRolZonaPrivilegio->ZonNombre,
//				$DatRolZonaPrivilegio->PriNombre);	
//			}

		
		
	}
	
}else{	

	$_SESSION['SesAviso'].="#ERR_GEN_103";
}



if($error){
	//header("Location: ../login.php");			
	
	if($_POST['CmpVersionCelular']=="1"){

		header("Location: ../loginC.php");		
	}else{
		header("Location: ../login.php");		
	}
	
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
	
	if($_POST['CmpAudio'] == 1){
		$_SESSION['SisAudio'] = true;
	}else{
		$_SESSION['SisAudio'] = false;	
	}
	
//	if(!empty($POST_Sucursal)){ 
//	
//		setcookie('CooSucursal', $POST_Sucursal, time() + 30 * 24 * 60 * 60); 
//		
//	}
	
	if($_POST['CmpVersionCelular']=="1" or $InsUsuario->RolNombre=="GM"){
		header("Location: ../principalC.php");		
	}else{
		header("Location: ../principal.php?Mod=Default&Form=Ver");
	}
	
}
?>