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


require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPromocion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$GET_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];
$GET_Fecha = (empty($_GET['Fecha'])?date("Y-m-d"):FncCambiaFechaAMysql($_GET['Fecha']));
$GET_TipoCambioTipo = (empty($_GET['TipoCambioTipo'])?'2':$_GET['TipoCambioTipo']);


$InsProductoListaPromocion = new ClsProductoListaPromocion();
$InsTipoCambio = new ClsTipoCambio();

//MtdObtenerProductoListaPromocions($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PloId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)

$ResProductoListaPromocion = $InsProductoListaPromocion->MtdObtenerProductoListaPromocions("PloCodigo","esigual",$GET_ProductoCodigoOriginal, 'PloId','ASC',"1",1);
$ArrProductoListaPromocions = $ResProductoListaPromocion['Datos'];
				  
$InsProductoListaPromocion->PloId = $ArrProductoListaPromocions[0]->PloId;
unset($ArrProductoListaPromocions);
$InsProductoListaPromocion->MtdObtenerProductoListaPromocion();

$InsTipoCambio = new ClsTipoCambio();
$InsTipoCambio->MonId = $InsProductoListaPromocion->MonId;
$InsTipoCambio->TcaFecha = $GET_Fecha;
$InsTipoCambio->MtdObtenerTipoCambioActual();

if(empty($InsTipoCambio->TcaId)){
	$InsTipoCambio->MtdObtenerTipoCambioUltimo();
}

//$InsProductoListaPromocion->PloPrecio = round($InsProductoListaPromocion->PloPrecio,2);
$TipoCambio = 0;

//if(empty($InsTipoCambio->TcaMontoComercial)){
//	$TipoCambio = $InsTipoCambio->TcaMontoVenta;
//}else{
//	$TipoCambio = $InsTipoCambio->TcaMontoComercial;	
//}

switch($GET_TipoCambioTipo){
	
	case "1":
		$TipoCambio = $InsTipoCambio->TcaMontoCompra;
	break;
	
	case "2":
		$TipoCambio = $InsTipoCambio->TcaMontoVenta;
	break;
	
	case "3":
		$TipoCambio = $InsTipoCambio->TcaMontoComercial;	
	break;
	
	default:
	
	break;
}

$InsProductoListaPromocion->PloTipoCambio = $TipoCambio;
$InsProductoListaPromocion->PloPrecio = round($InsProductoListaPromocion->PloPrecioReal * $TipoCambio,2);


$InsProductoListaPromocion->PloPrecioReal = round($InsProductoListaPromocion->PloPrecioReal,2);
$InsProductoListaPromocion->InsMysql = NULL;
//$json = new Services_JSON();
//echo $json->encode($InsProductoListaPromocion);

$json = new JSON;
//$var = $json->serialize( $ArrProductoListaPromocions );
$var = $json->serialize( $InsProductoListaPromocion );
$json->unserialize( $var );
echo $var;
	
?>