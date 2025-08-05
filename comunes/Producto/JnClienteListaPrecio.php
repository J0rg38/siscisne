<?php
//header('Content-type: text/json');
//header('Content-type: application/json');

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

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqLogistica().'ClsClienteListaPrecio.php');

$GET_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];
$GET_ClienteId = $_GET['ClienteId'];

$InsClienteListaPrecio = new ClsClienteListaPrecio();

//MtdObtenerClienteListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ClpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL)
$ResClienteListaPrecio = $InsClienteListaPrecio->MtdObtenerClienteListaPrecios("ClpCodigo","esigual",$GET_ProductoCodigoOriginal, 'ClpId','ASC',"1",NULL,$GET_ClienteId);
$ArrClienteListaPrecios = $ResClienteListaPrecio['Datos'];
				  
$InsClienteListaPrecio->ClpId = $ArrClienteListaPrecios[0]->ClpId;
unset($ArrClienteListaPrecios);
$InsClienteListaPrecio->MtdObtenerClienteListaPrecio();

$InsClienteListaPrecio->ClpPrecio = round($InsClienteListaPrecio->ClpPrecio,2);

$InsClienteListaPrecio->ClpPrecio = round($InsClienteListaPrecio->ClpPrecio,2);
$InsClienteListaPrecio->ClpPrecioReal = round($InsClienteListaPrecio->ClpPrecioReal,2);
	
$InsClienteListaPrecio->InsMysql=NULL;

//$json = new Services_JSON();
//echo $json->encode($InsClienteListaPrecio);


$json = new JSON;
//$var = $json->serialize( $ArrClienteListaPrecios );
$var = $json->serialize( $InsClienteListaPrecio );
$json->unserialize( $var );
echo $var;
	
?>