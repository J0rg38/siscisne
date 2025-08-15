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

require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');

require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
require_once('clases/ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');

require_once($InsPoo->MtdPaqEmpresa().'/ClsSucursal.php');
require_once($InsPoo->MtdPaqEmpresa().'/ClsArea.php');

require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');

$InsUsuario = new ClsUsuario();
$InsSucursal = new ClsSucursal();
$InsArea = new ClsArea();

$InsACL = new ClsACL();

$InsUsuario->UsuUsuario = $_POST['CmpUsuario'];
$InsUsuario->UsuContrasena = md5($_POST['CmpContrasena']);
$InsUsuario->SucId = ($_POST['CmpSucursal']);
$InsUsuario->MtdEntrarUsuario();

$InsSucursal->SucId = $_POST['CmpSucursal'];
$InsSucursal = $InsSucursal->MtdObtenerSucursal();	

$error = true;

if(!empty($InsUsuario->UsuId)){

	if($InsUsuario->UsuEstado==2){
		$_SESSION['SesAviso'].="#ERR_GEN_102";
	}else{
	
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
		
			unset($_SESSION['InsRolZonaPrivilegio']);
			
			$_SESSION['InsRolZonaPrivilegio'] = new ClsSesionObjeto();
			
			foreach($InsUsuario->RolZonaPrivilegio as $DatRolZonaPrivilegio){
		
					$_SESSION['InsRolZonaPrivilegio']->MtdAgregarSesionObjeto(1,$DatRolZonaPrivilegio->RzpId,$DatRolZonaPrivilegio->RolId,$DatRolZonaPrivilegio->ZprId,$DatRolZonaPrivilegio->ZonNombre,$DatRolZonaPrivilegio->PriNombre);	
					
			}				
	
	
			$_SESSION['SesAviso'].="#SAS_GEN_102";
			$error = false;
	
	}
	
}else{	
	$_SESSION['SesAviso'].="#ERR_GEN_103";
}


if($error){
	header("Location: ../formularios/Usuario/FrmUsuarioSesionCambiar.php");			
}else{
	//Uso: Chat
	//Descripcion:
	$_SESSION['username'] = $InsUsuario->UsuUsuario."_".$InsUsuario->PerNombre."_".$InsUsuario->PerApellidoPaterno."_".$InsUsuario->PerApellidoMaterno;
	$_SESSION['username'] = preg_replace("/ /", "_", $_SESSION['username']);
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
		
	header("Location: ../formularios/Usuario/FrmUsuarioSesionCambiar.php");			
}
?>