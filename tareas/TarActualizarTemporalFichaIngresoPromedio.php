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

require_once($InsPoo->MtdPaqReporte().'ClsResumenFichaIngresoPromedio.php');


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
$InsReporteProducto = new ClsReporteProducto();

$InsResumenFichaIngresoPromedio = new ClsResumenFichaIngresoPromedio();
//MtdNotificarFacturaPorVencer($oDestinatario,$oCantidadDia=5,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL){

$POST_Ano = date("Y");
echo "";	
for($mes=1;$mes<=12;$mes++){
	
	/*
	RstId,
			RstVentaTallerChevrolet,
			RstVentaPPChevrolet,
			RstVentaMesonChevrolet,
			RstVentaRetailChevrolet,
			RstVentaRetailLubricantes,
			RstTotalVentasRetail,
			RstAno,
			RstMes
	*/
	
	echo "Mes: ".FncConvertirMes($mes);
	echo "<br>";
	echo "<br>";

	
	//Stock Chevrolet
	$CHEVROLETStockMensual[$mes] = 0;
	$CHEVROLETEntradas[$mes] = 0;
	$CHEVROLETSalidas[$mes] = 0;
	$Stock = 0;
	
	$CHEVROLETEntradas[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-".$mes."-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,"VMA-10017","RTI-10000");  
	
	$CHEVROLETSalidas[$mes] = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",$mes,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,"VMA-10017","RTI-10000");
	
	$Stock = $CHEVROLETEntradas[$mes] - $CHEVROLETSalidas[$mes];
	$CHEVROLETStockMensual[$mes] = $Stock + $CHEVROLETStockMensual[$mes-1];
	$STOCKTotalMensual[$mes] += $CHEVROLETStockMensual[$mes];
	
	echo "Stock Chevrolet: ";
	echo number_format($CHEVROLETStockMensual[$mes],2);
	echo "<br>";
	


	//Stock Lubricantes
	$LUBRICANTEStockMensual[$mes] = 0;
	$LUBRICANTESEntradas[$mes] = 0;
	$LUBRICANTESSalidas[$mes] = 0;
	$Stock = 0;
	
	$LUBRICANTESEntradas[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-".$mes."-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,NULL,"RTI-10001");  
	
	$LUBRICANTESSalidas[$mes] = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdCantidadReal",$mes,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,NULL,"RTI-10001");
	
	$Stock = $LUBRICANTESEntradas[$mes] - $LUBRICANTESSalidas[$mes];
	$LUBRICANTEStockMensual[$mes] = $Stock + $LUBRICANTEStockMensual[$mes-1];
	$STOCKTotalMensual[$mes] += $LUBRICANTEStockMensual[$mes];
	 
	echo "Stock Lubricantes";
	echo number_format($LUBRICANTEStockMensual[$mes],2);
	echo "<br>";
		  
		   
		   
		   
		   
	
	//Valor en repuestos A (%)
	$PIEZASA_CHEVROLET[$mes] = 0;
	$PIEZASA_LUBRICANTES[$mes] = 0;
	$PIEZASA[$mes] = 0;
	
	$PIEZASA_CHEVROLET[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,"VMA-10017","RTI-10000",0,30); 
	
	$PIEZASA_LUBRICANTES[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,NULL,"RTI-10001",0,30); 
	
	//$Stock = $PIEZASA_CHEVROLET[$mes] + $PIEZASA_ISUZU + $PIEZASA_LUBRICANTES - $CHEVROLETSalidas[$mes] - $ISUZUSalidas[$mes] - $LUBRICANTESSalidas[$mes];
	$Stock = $PIEZASA_CHEVROLET[$mes] + $PIEZASA_LUBRICANTES[$mes] - $CHEVROLETSalidas[$mes] - $LUBRICANTESSalidas[$mes];
	
	$PIEZASA[$mes] = ((($Stock) *  100) / $STOCKTotalMensual[$mes]);
	

	echo "Valor en repuestos A (%)";
	echo number_format($PIEZASA[$mes],2);
	echo "<br>";

	
		
	//Valor en repuestos B (%)
	$PIEZASB_CHEVROLET[$mes] = 0;
	//$PIEZASB_ISUZU = 0;
	$PIEZASB_LUBRICANTES[$mes] = 0;
	$PIEZASB[$mes] = 0;
	
	$PIEZASB_CHEVROLET[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,"VMA-10017","RTI-10000",31,60); 
	
	//$PIEZASB_ISUZU = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,"VMA-10018","RTI-10000",31,60); 
	
	$PIEZASB_LUBRICANTES[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,NULL,"RTI-10001",31,60); 
	
	
	//$Stock = $PIEZASB_CHEVROLET + $PIEZASB_ISUZU + $PIEZASB_LUBRICANTES - $CHEVROLETSalidas[$mes] - $ISUZUSalidas[$mes] - $LUBRICANTESSalidas[$mes];
	$Stock = $PIEZASB_CHEVROLET[$mes] + $PIEZASB_LUBRICANTES[$mes] - $CHEVROLETSalidas[$mes] - $LUBRICANTESSalidas[$mes];
	
	$PIEZASB[$mes] = ((($Stock) *  100) / $STOCKTotalMensual[$mes]);



	echo "Valor en repuestos B (%)";
	echo number_format($PIEZASB[$mes],2);
	echo "<br>";




	
	//Valor en repuestos C (%)
	$PIEZASC_CHEVROLET[$mes] =0;
	//$PIEZASC_ISUZU =0;
	$PIEZASC_LUBRICANTES[$mes] =0;
	$PIEZASC[$mes] =0;
	
	$PIEZASC_CHEVROLET[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,"VMA-10017","RTI-10000",61,0); 
	
	//$PIEZASC_ISUZU = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,"VMA-10018","RTI-10000",61,0); 
	
	$PIEZASC_LUBRICANTES[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,NULL,"RTI-10001",61,0); 
	
	
	//$Stock = $PIEZASC_CHEVROLET[$mes] + $PIEZASC_ISUZU + $PIEZASC_LUBRICANTES[$mes] - $CHEVROLETSalidas[$mes] - $ISUZUSalidas[$mes] - $LUBRICANTESSalidas[$mes];
	$Stock = $PIEZASC_CHEVROLET[$mes] + $PIEZASC_LUBRICANTES[$mes] - $CHEVROLETSalidas[$mes] - $LUBRICANTESSalidas[$mes];
	
	$PIEZASC[$mes] = ((($Stock) *  100) / $STOCKTotalMensual[$mes]);
	
	

	echo "Valor en repuestos C (%)";
	echo number_format($PIEZASC[$mes],2);
	echo "<br>";
			 
	//Valor en repuestos D (%)  
	echo "Valor en repuestos D (%)";
	echo 0;
	echo "<br>";



//Rotación Chevrolet
$CHEVROLETRotacion[$mes] = 0;		 
$CHEVROLETRotacion[$mes] = ($CHEVROLETCostoMensual[$mes]/$CHEVROLETStockMensual[$mes]);

	echo "Rotación Chevrolet";
	echo number_format($CHEVROLETRotacion[$mes],2);
	echo "<br>";


		   
/*
  public $RstId;
	public $RstStockChevrolet;
	public $RstStockLubricantes;
	
	public $RstTotalStock;
	public $RstValorRepuestoA;
	public $RstValorRepuestoB;
	public $RstValorRepuestoC;
	public $RstValorRepuestoD;
	
	public $RstRotacionChevrolet;
	public $RstValorPreObsoletos;
	public $RstValorObsoletos;
*/
				
	$InsResumenStock->RstStockChevrolet = $CHEVROLETStockMensual[$mes];
	$InsResumenStock->RstStockLubricantes = $LUBRICANTEStockMensual[$mes];
	$InsResumenStock->RstTotalStock = $STOCKTotalMensual[$mes];
	$InsResumenStock->RstValorRepuestoA = $PIEZASA[$mes];
	$InsResumenStock->RstValorRepuestoB = $PIEZASB[$mes];	
	$InsResumenStock->RstValorRepuestoC = $PIEZASC[$mes];	
	$InsResumenStock->RstValorRepuestoD = 0;	
	
	$InsResumenStock->RstRotacionChevrolet = $CHEVROLETRotacion[$mes];	
	$InsResumenStock->RstValorPreObsoletos = 0;	
	$InsResumenStock->RstValorObsoletos = 0;	
				
	$InsResumenStock->RstTiempoCreacion = date("Y-m-d H:i:s");
	
	$InsResumenStock->RstAno = $POST_Ano;
	$InsResumenStock->RstMes = $mes;
	$InsResumenStock->MtdRegistrarResumenStock();
		
}

?>