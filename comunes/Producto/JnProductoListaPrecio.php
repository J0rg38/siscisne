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


require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$GET_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];
$GET_Fecha = (empty($_GET['Fecha'])?date("Y-m-d"):FncCambiaFechaAMysql($_GET['Fecha']));
$GET_TipoCambioTipo = (empty($_GET['TipoCambioTipo'])?'2':$_GET['TipoCambioTipo']);


$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsTipoCambio = new ClsTipoCambio();

//MtdObtenerProductoListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PlpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)

//$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$GET_ProductoCodigoOriginal, 'PlpId','DESC',"1",1);
$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$GET_ProductoCodigoOriginal, 'PlpTiempoCreacion','DESC',"1",1);
$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
				  
$InsProductoListaPrecio->PlpId = $ArrProductoListaPrecios[0]->PlpId;
unset($ArrProductoListaPrecios);
$InsProductoListaPrecio->MtdObtenerProductoListaPrecio();

$InsTipoCambio = new ClsTipoCambio();
$InsTipoCambio->MonId = $InsProductoListaPrecio->MonId;
$InsTipoCambio->TcaFecha = $GET_Fecha;
$InsTipoCambio->MtdObtenerTipoCambioActual();

if(empty($InsTipoCambio->TcaId)){
	$InsTipoCambio->MtdObtenerTipoCambioUltimo();
}

//$InsProductoListaPrecio->PlpPrecio = round($InsProductoListaPrecio->PlpPrecio,2);
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

$InsProductoListaPrecio->PlpTipoCambio = $TipoCambio;
$InsProductoListaPrecio->PlpPrecio = round($InsProductoListaPrecio->PlpPrecioReal * $TipoCambio,2);



$InsProductoListaPrecio->PlpPrecioReal = round($InsProductoListaPrecio->PlpPrecioReal,2);
$InsProductoListaPrecio->InsMysql = NULL;
//$json = new Services_JSON();
//echo $json->encode($InsProductoListaPrecio);

$json = new JSON;
//$var = $json->serialize( $ArrProductoListaPrecios );
$var = $json->serialize( $InsProductoListaPrecio );
$json->unserialize( $var );
echo $var;
	
?>