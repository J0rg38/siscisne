<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsPersonal = new ClsPersonal();

$q = strtolower($_GET["q"]);
$GET_campo = (empty($_GET['Campo'])?"PerNombre":$_GET['Campo']);

if($GET_campo == "PerNombreCompleto"){
	$GET_campo = "PerNombre,PerApellidoPaterno,PerApellidoMaterno";
}

if (!$q) return;

// MtdObtenerPersonales($oCampo=NULL,$oCondicion,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL) 
$ResPersonal = $InsPersonal->MtdObtenerPersonales($GET_campo,"contiene",$q,$GET_campo,"ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
	
	$ArrPersonales = $ResPersonal['Datos'];
	$PersonalesTotal = $ResPersonal['Total'];
		
	if(empty($ArrPersonales)){
		
	}else{
		foreach($ArrPersonales as $DatPersonal){			
			echo $DatPersonal->PerNombre."|".
			$DatPersonal->PerId."|".
			$DatPersonal->PerNumeroDocumento."|".
			$DatPersonal->PerApellidoPaterno."|".
			$DatPersonal->PerApellidoMaterno."|".
			$DatPersonal->PerNombreCompleto."|".
			$DatPersonal->PerEmail."|.\n";	
		}
	}

?>