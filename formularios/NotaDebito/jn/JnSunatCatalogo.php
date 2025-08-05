<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
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



require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

$POST_CodigoMotivo = $_GET['CodigoMotivo'];

require_once($InsPoo->MtdPaqContabilidad().'ClsSunatCatalogo.php');

$InsSunatCatalogo = new ClsSunatCatalogo();

if(!empty($POST_CodigoMotivo)){
	
	$ResSunatCatalogo = $InsSunatCatalogo->MtdObtenerSunatCatalogos('ScaCodigo',$POST_CodigoMotivo,'ScaCodigo','ASC',NULL,"CATALOGO9");
	$ArrSunatCatalogos = $ResSunatCatalogo['Datos'];
		
	$SunatCatalogoId = "";
	
	if(!empty($ArrSunatCatalogos)){
		foreach($ArrSunatCatalogos as $DatSunatCatalogo){
			$SunatCatalogoId = $DatSunatCatalogo->ScaId;		
		}
	}
	
}

if(!empty($SunatCatalogoId)){
	
	$InsSunatCatalogo->ScaId = $SunatCatalogoId;
	$InsSunatCatalogo->MtdObtenerSunatCatalogo();
	
}

//$json = new JSON;
//$var = $json->serialize( $InsClienteTipo );
//$json->unserialize( $var );
//
//echo $var;
$InsSunatCatalogo->InsMysql = NULL;

echo json_encode($InsSunatCatalogo);
?>