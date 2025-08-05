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

require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');


$POST_ProductoId = $_POST['ProductoId'];
$POST_ProductoCodigoOriginal = $_POST['ProductoCodigoOriginal'];
$POST_FechaInicio = (empty($_POST['FechaInicio'])?date("d/m/Y"):$_POST['FechaInicio']);
$POST_FechaFin = (empty($_POST['FechaFin'])?date("d/m/Y"):$_POST['FechaFin']);

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPromocion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProductoListaPrecioCotizado.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

//deb($_POST);

$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$ResVentaDirectaDetalle = $InsVentaDirectaDetalle->MtdSeguimientoVentaDirectaDetalles("ProCodigoOriginal","esigual",$POST_ProductoCodigoOriginal,"VdiFecha","DESC",NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,NULL);
$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];

$TotalPedidos = 0;
$TotalAtendidos = 0;

if(!empty($ArrVentaDirectaDetalles)){
	foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
		
		$TotalPedidos += $DatVentaDirectaDetalle->VddCantidad;
		
		$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
		$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,NULL,NULL,NULL,$DatVentaDirectaDetalle->VddId,3);
		$ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];
		
		if(!empty($ArrVentaConcretadaDetalles)){
			foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
			
				$TotalAtendidos += $DatVentaConcretadaDetalle->VcdCantidad;
		
			}
		}

	}
}

$TotalPendientes = $TotalPedidos - $TotalAtendidos;


$Resultado['TotalPedidos'] = $TotalPedidos;
$Resultado['TotalAtendidos'] = $TotalAtendidos;
$Resultado['TotalPendientes'] = $TotalPendientes;

if($TotalPendientes>0){
	$Resultado['TienePedido'] = 'Si';	
}else{
	$Resultado['TienePedido'] = 'No';	
}


//$json = new JSON;
//$var = $json->serialize( $InsProducto );
//$json->unserialize( $var );
//$json = new Services_JSON();
//echo $json->encode($InsProducto);

echo json_encode($Resultado);
?>