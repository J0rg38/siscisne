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



require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');

require_once($InsPoo->MtdPaqReporte().'ClsResumenProductoStock.php');


$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaAccion = new ClsFichaAccion();
$InsFichaAccionProducto = new ClsFichaAccionProducto();
$InsPersonal = new ClsPersonal();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsProveedor = new ClsProveedor();
$InsOrdenCompra = new ClsOrdenCompra();
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
$InsProducto = new ClsProducto();
$InsResumenProductoStock = new ClsReporteProducto();

//MtdNotificarFacturaPorVencer($oDestinatario,$oCantidadDia=5,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL){
$POST_Ano = date("Y");
//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,'ProId','Desc',NULL,NULL,NULL,1,"VMA-10017",NULL,NULL,NULL,true,NULL,NULL,0,NULL);	
$ArrProductos = $ResProducto['Datos'];

if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
		
		for($mes=1;$mes<=12;$mes++){
			
			echo "Mes: ".FncConvertirMes($mes);
			echo "<br>";
			echo "<br>";
			//Stock Chevrolet
			$CHEVROLETEntradas = 0;
			$CHEVROLETTallerPedidoSalidas = 0;
			$CHEVROLETVentaConcretadaSalidas = 0;
			$CHEVROLETCosto = 0;
			$CHEVROLETStock = 0;
			
			$CHEVROLETCosto  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("AVG","AmdCosto",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-".$mes."-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,NULL,NULL,NULL,NULL,$DatProducto->ProId);  
			
			//MtdObtenerAlmacenMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenMovimientoEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL,$oProducto=NULL) {
			$CHEVROLETAlmacenMovimientoEntradaEntradas  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-".$mes."-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,NULL,NULL,NULL,NULL,$DatProducto->ProId);  
			//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL) {
			$CHEVROLETTallerPedidoSalidas  = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",$mes,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,$DatProducto->ProId,3,NULL,NULL);
			//MtdObtenerVentaConcretadaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL,$oVentaConcretadaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL) {
			$CHEVROLETVentaConcretadaSalidas = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdCantidadReal",$mes,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,$DatProducto->ProId,NULL,3,NULL,NULL);
			
			$CHEVROLETEntradas = $CHEVROLETAlmacenMovimientoEntradaEntradas;
			$CHEVROLETSalidas = $CHEVROLETTallerPedidoSalidas + $CHEVROLETVentaConcretadaSalidas;
			$CHEVROLETStock = $CHEVROLETEntradas - $CHEVROLETSalidas;
			
			
			$InsResumenProductoStock = new ClsResumenProductoStock();			
			$InsResumenProductoStock->MtdObtenerResumenProductoStockMensual($POST_Ano,$mes,$DatProducto->ProId);
			$ResumenProductoStockId = $InsResumenProductoStock->RpsId;
			
			
			
			echo "ProCodigoOriginal: ".$DatProducto->ProCodigoOriginal;
			echo "<br>";
			echo "ProNombre: ".$DatProducto->ProNombre;
			echo "<br>";
			
			echo "CHEVROLETEntradas: ".$CHEVROLETEntradas;
			echo "<br>";
			
			echo "CHEVROLETSalidas: ".$CHEVROLETSalidas;
			echo "<br>";
			
			echo "CHEVROLETStock: ".$CHEVROLETStock;
			echo "<br>";
			
			echo "CHEVROLETCosto: ".$CHEVROLETCosto;
			echo "<br>";
			
			echo "ProABCInterno: ".$DatProducto->ProABCInterno;
			echo "<br>";
			
			echo "RpsId: ".$InsResumenProductoStock->RpsId;
			echo "<br>";
			echo "<br>";
			
			if(empty($InsResumenProductoStock->RpsId)){
				
				$InsResumenProductoStock = new ClsResumenProductoStock();			
				$InsResumenProductoStock->ProId = $DatProducto->ProId;
				$InsResumenProductoStock->RpsAno = $POST_Ano;
				$InsResumenProductoStock->RpsMes = $mes;		
				$InsResumenProductoStock->RpsEntradas = $CHEVROLETEntradas;
				$InsResumenProductoStock->RpsSalidas = $CHEVROLETSalidas;
				$InsResumenProductoStock->RpsStock = $CHEVROLETStock;
				$InsResumenProductoStock->RpsCosto = $CHEVROLETCosto;
				$InsResumenProductoStock->RpsABCInterno = $DatProducto->ProABCInterno;
				$InsResumenProductoStock->RpsTiempoCreacion = date("Y-m-d H:i:s");
				$InsResumenProductoStock->RpsTiempoModificacion = date("Y-m-d H:i:s");

				if($InsResumenProductoStock->MtdRegistrarResumenProductoStock()){
					echo "Se registro correctamente el ResumenProductoStock";	
					echo "<br>";
				}else{
					echo "No se ha podido registrar el ResumenProductoStock";	
					echo "<br>";
				}

			}else{
				
				$InsResumenProductoStock = new ClsResumenProductoStock();
				$InsResumenProductoStock->RpsId = $ResumenProductoStockId;
				$InsResumenProductoStock->ProId = $DatProducto->ProId;
				$InsResumenProductoStock->RpsAno = $POST_Ano;
				$InsResumenProductoStock->RpsMes = $mes;		
				$InsResumenProductoStock->RpsEntradas = $CHEVROLETEntradas;
				$InsResumenProductoStock->RpsSalidas = $CHEVROLETSalidas;
				$InsResumenProductoStock->RpsStock = $CHEVROLETStock;
				$InsResumenProductoStock->RpsCosto = $CHEVROLETCosto;
				$InsResumenProductoStock->RpsABCInterno = $DatProducto->ProABCInterno;
				$InsResumenProductoStock->RpsTiempoCreacion = date("Y-m-d H:i:s");
				$InsResumenProductoStock->RpsTiempoModificacion = date("Y-m-d H:i:s");

				if($InsResumenProductoStock->MtdEditarResumenProductoStock()){
					echo "Se edito correctamente el ResumenProductoStock";	
					echo "<br>";
				}else{
					echo "No se ha podido editar el ResumenProductoStock";	
					echo "<br>";
				}

			}
			
			echo "-------";
			echo "<br>";
			
		}


	}	
}

echo "";	

?>