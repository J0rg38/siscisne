<?php
session_start();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}


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




require_once($InsPoo->MtdPaqReporte().'ClsReporteCOR.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsCita.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFacturacion.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteCOR.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');

//$GET_VehiculoMarcaId = (empty($_GET['VehiculoMarcaId'])?"VMA-10017":$_GET['VehiculoMarcaId']);
$GET_Ano = (empty($_GET['Ano'])?date("Y"):$_GET['Ano']);
$GET_Mes = (empty($_GET['Mes'])?date("m"):$_GET['Mes']);
$GET_VehiculoMarca = $_GET['VehiculoMarca'];
$GET_Sucursal = (empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal']);

if(empty($GET_VehiculoMarca) or empty($GET_Ano) or empty($GET_Mes)){
	die("No se ha especificado el año, mes o marca de vehiculo.");
}


$InsProveedor = new ClsProveedor();
$InsProveedor->PrvId = "PRV-10548";
$InsProveedor->MtdObtenerProveedor();


		$InsVehiculoMarca = new ClsVehiculoMarca();
		$InsVehiculoMarca->VmaId = $GET_VehiculoMarca;
		$InsVehiculoMarca->MtdObtenerVehiculoMarca();


		$InsReporteCOR = new ClsReporteCOR();
		//MtdObtenerFacturacionTaller($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFichaIngresoModalidadIngreso=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oSucursal=NULL)
		$ResReporteCOR = $InsReporteCOR->MtdObtenerReporteCORs(NULL,NULL,NULL,'RcrId','Desc','1',$GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,NULL,NULL,NULL,NULL,$GET_Sucursal);
		$ArrReporteCORs = $ResReporteCOR['Datos'];
			
		$ReporteCORId = "";
		
		if(!empty($ArrReporteCORs)){
			foreach($ArrReporteCORs as $DatReporteCOR){
				$ReporteCORId = $DatReporteCOR->RcrId;
			}
		}
		
		
		echo "Marca Id: ".$InsVehiculoMarca->VmaNombre;
		echo "<br>";
		echo "Año: ".$GET_Ano;
		echo "<br>";
		echo "Mes: ".$GET_Mes ;
		echo "<br>";	
		
									            
		//RcrVentaTallerMarca
		$InsReporteFacturacion = new ClsReporteFacturacion();
		$RcrVentaTallerMarca = $InsReporteFacturacion->MtdObtenerFacturacionTaller("SUM","FdeImporte",$GET_Ano,$GET_Mes,$GET_VehiculoMarca,"RTI-10000",NULL,"fde.FdeId","DESC",NULL) ;
		$RcrVentaTallerMarca = (empty($RcrVentaTallerMarca)?0:$RcrVentaTallerMarca);
		
		//RcrVentaPPMarca
		$RcrVentaPPMarca = 0;
			
		//RcrVentaMesonMarca
		$InsReporteFacturacion = new ClsReporteFacturacion();
		$RcrVentaMesonMarca = $InsReporteFacturacion->MtdObtenerFacturacionMostrador("SUM","FdeImporte",$GET_Ano,$GET_Mes,$GET_VehiculoMarca,"RTI-10000","fde.FdeId","DESC",NULL) ;
		$RcrVentaMesonMarca = (empty($RcrVentaMesonMarca)?0:$RcrVentaMesonMarca);
		
		//RcrVentaRatailMarca
		$RcrVentaRatailMarca = 0;
		
		//RcrVentaRetailLubricantes
		$RcrVentaRetailLubricantes = $InsReporteFacturacion->MtdObtenerFacturacionTaller("SUM","FdeImporte",$GET_Ano,$GET_Mes,$GET_VehiculoMarca,"RTI-10001",NULL,"fde.FdeId","DESC",NULL) ;
		$RcrVentaRetailLubricantes += $InsReporteFacturacion->MtdObtenerFacturacionMostrador("SUM","FdeImporte",$GET_Ano,$GET_Mes,$GET_VehiculoMarca,"RTI-10001","fde.FdeId","DESC",NULL) ;	
		$RcrVentaRetailLubricantes = (empty($RcrVentaRetailLubricantes)?0:$RcrVentaRetailLubricantes);
		//$TotalVentasRetail += $RcrVentaRetailLubricantes;
		
		//RcrTotalVentasRetail
		$RcrTotalVentasRetail = $RcrVentaMesonMarca + $RcrVentaRetailLubricantes;
		$RcrTotalVentasRetail = (empty($RcrTotalVentasRetail)?0:$RcrTotalVentasRetail);
		
		
		
		
		//RcrMargenAporte
		$RcrMargenAporte = 35;
		
		//RcrStockMarca
		$InsReporteAlmacenMovimiento = new ClsReporteAlmacenMovimiento();
		
		//MtdObtenerAlmacenMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenMovimientoEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL,$oProducto=NULL,$oProductoABCInterno=NULL)
		$MARCAEntradaCostos = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("AVG","AmdCosto",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes),NULL,0,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000",NULL,NULL,NULL,"A,B,C,D");  
		$MARCAEntradas = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes),NULL,0,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000",NULL,NULL,NULL,"A,B,C,D");  
		//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oProductoABCInterno=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {
		$MARCASalidas = $InsReporteAlmacenMovimiento->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000","A,B,C,D",$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes));
		
		$MARCAStock  = $MARCAEntradas  - $MARCASalidas ;
		//deb($MARCAStock);
		
		$RcrStockMarca = ($MARCAStock)*($MARCAEntradaCostos);
		$RcrStockMarca = (empty($RcrStockMarca)?0:$RcrStockMarca);
		
		//RcrStockLubricantes
		$InsReporteAlmacenMovimiento = new ClsReporteAlmacenMovimiento();
		$LUBRICANTESEntradaCostos = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("AVG","AmdCosto",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$GET_Ano."-".$GET_Mes."-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes),NULL,0,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10001");  
		$LUBRICANTESEntradas = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$GET_Ano."-".$GET_Mes."-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes),NULL,0,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10001");  
		$LUBRICANTESSalidas = $InsReporteAlmacenMovimiento->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdCantidadReal",$GET_Mes,$GET_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10001");

		$RcrStockLubricantes = ($LUBRICANTESEntradas - $LUBRICANTESSalidas) * ($LUBRICANTESEntradaCostos);
		$RcrStockLubricantes = (empty($RcrStockLubricantes)?0:$RcrStockLubricantes);
		
		//RcrTotalStock
		$RcrTotalStock = $RcrStockMarca + $RcrStockLubricantes;
		
		//RcrValorRepuestosA
		$RcrValorRepuestosA = 0;
		//MtdObtenerAlmacenMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenMovimientoEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL,$oProducto=NULL,$oProductoABCInterno=NULL)
		$MARCAEntradasA = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes),NULL,0,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000",NULL,NULL,NULL,"A");  
		//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oProductoABCInterno=NULL) {
		$MARCASalidasA = $InsReporteAlmacenMovimiento->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000","A",$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes));
		$MARCAStockA  = $MARCAEntradasA  - $MARCASalidasA ;
		//deb($MARCAStockA);
		$RcrValorRepuestosA = (($MARCAStockA)*100)/(empty($MARCAStock)?1:$MARCAStock);
		//$RcrValorRepuestosA = $RcrValorRepuestosA * 100;
		$RcrValorRepuestosA = (empty($RcrValorRepuestosA)?0:$RcrValorRepuestosA);
		
			
			
		//RcrValorRepuestosB
		$RcrValorRepuestosB = 0;
		//MtdObtenerAlmacenMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenMovimientoEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL,$oProducto=NULL,$oProductoABCInterno=NULL) {
		$MARCAEntradasB = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes),NULL,0,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000",NULL,NULL,NULL,"B");  
		//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oProductoABCInterno=NULL) {
		$MARCASalidasB = $InsReporteAlmacenMovimiento->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000","B",$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes));
		$MARCAStockB  = $MARCAEntradasB  - $MARCASalidasB ;
		//deb($MARCAStockB);
		
		$RcrValorRepuestosB = (($MARCAStockB)*100)/(empty($MARCAStock)?1:$MARCAStock);
		//$RcrValorRepuestosB = $RcrValorRepuestosB * 100;
		$RcrValorRepuestosB = (empty($RcrValorRepuestosB)?0:$RcrValorRepuestosB);
		
		
				
		//RcrValorRepuestosC
		$RcrValorRepuestosC = 0;
		//MtdObtenerAlmacenMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenMovimientoEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL,$oProducto=NULL,$oProductoABCInterno=NULL) {
		$MARCAEntradasC = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes),NULL,0,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000",NULL,NULL,NULL,"C");  
		//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oProductoABCInterno=NULL) {
		$MARCASalidasC = $InsReporteAlmacenMovimiento->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000","C",$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes));
		$MARCAStockC  = $MARCAEntradasC  - $MARCASalidasC ;
		//deb($MARCAStockC);
		
		$RcrValorRepuestosC = (($MARCAStockC)*100)/(empty($MARCAStock)?1:$MARCAStock);
		//$RcrValorRepuestosC = $RcrValorRepuestosC * 100;
		$RcrValorRepuestosC = (empty($RcrValorRepuestosC)?0:$RcrValorRepuestosC);
		
		
		//RcrValorRepuestosD
		$RcrValorRepuestosD = 0;
		//MtdObtenerAlmacenMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenMovimientoEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL,$oProducto=NULL,$oProductoABCInterno=NULL) {
		$MARCAEntradasD = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes),NULL,0,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000",NULL,NULL,NULL,"D");  
		//MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oProductoABCInterno=NULL) {
		$MARCASalidasD = $InsReporteAlmacenMovimiento->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,$GET_VehiculoMarca,"RTI-10000","D",$GET_Ano."-01-01",$GET_Ano."-".$GET_Mes."-".FncCantidadDiaMes($GET_Ano,$GET_Mes));
		$MARCAStockD  = $MARCAEntradasD  - $MARCASalidasD ;
		//deb($MARCAStockD);
		
		
		$RcrValorRepuestosD = (($MARCAEntradasD)*100)/(empty($MARCAStock)?1:$MARCAStock);
		//$RcrValorRepuestosD = $RcrValorRepuestosD * 100;
		$RcrValorRepuestosD = (empty($RcrValorRepuestosD)?0:$RcrValorRepuestosD);
		
		
		//RcrRotationMarca
		$RcrRotationMarca = 0;
		
		//RcrValorPreObsoletos
		$RcrValorPreObsoletos = $RcrValorRepuestosC;
		
		//RcrValorObsoletos
		$RcrValorObsoletos = $RcrValorRepuestosD;
		
		//RcrPedidosYSTK
		$InsOrdenCompra = new ClsOrdenCompra();
		$RcrPedidosYSTK = $InsOrdenCompra->MtdObtenerOrdenComprasValor("COUNT","OcoId",$GET_Mes,$GET_Ano,NULL,NULL,NULL, 'OcoId','Desc',NULL,NULL,NULL,NULL,"STK",0,$InsProveedor->PrvId,NULL,$GET_VehiculoMarca) ;
		$RcrPedidosYSTK = (empty($RcrPedidosYSTK)?0:$RcrPedidosYSTK);

		//RcrPedidosYRUSH
		$InsOrdenCompra = new ClsOrdenCompra();
		$RcrPedidosYRUSH = $InsOrdenCompra->MtdObtenerOrdenComprasValor("COUNT","OcoId",$GET_Mes,$GET_Ano,NULL,NULL,NULL, 'OcoId','Desc',NULL,NULL,NULL,NULL,"YRUSH",0,$InsProveedor->PrvId,NULL,$GET_VehiculoMarca) ;
		$RcrPedidosYRUSH = (empty($RcrPedidosYRUSH)?0:$RcrPedidosYRUSH);
		
		//RcrPedidosZVOR
		$InsOrdenCompra = new ClsOrdenCompra();
		$RcrPedidosZVOR= $InsOrdenCompra->MtdObtenerOrdenComprasValor("COUNT","OcoId",$GET_Mes,$GET_Ano,NULL,NULL,NULL, 'OcoId','Desc',NULL,NULL,NULL,NULL,"ZVOR",0,$InsProveedor->PrvId,NULL,$GET_VehiculoMarca) ;
		$RcrPedidosZVOR = (empty($RcrPedidosZVOR)?0:$RcrPedidosZVOR);
		
		//RcrPedidosZGAR
		$InsOrdenCompra = new ClsOrdenCompra();
		$RcrPedidosZGAR= $InsOrdenCompra->MtdObtenerOrdenComprasValor("COUNT","OcoId",$GET_Mes,$GET_Ano,NULL,NULL,NULL, 'OcoId','Desc',NULL,NULL,NULL,NULL,"ZGAR",0,$InsProveedor->PrvId,NULL,$GET_VehiculoMarca) ;
		$RcrPedidosZGAR = (empty($RcrPedidosZGAR)?0:$RcrPedidosZGAR);

		//RcrTasaServicioTaller
		$RcrTasaServicioTaller = 0;
		
		//RcrMontoVentaPedidas
		$RcrMontoVentaPedidas = 0;

		//RcrPersonalAsesorRepuestos
		$RcrPersonalAsesorRepuestos = 1;
		
		//RcrPersonalAsistenteAlmacen
		$RcrPersonalAsistenteAlmacen = 1;
		
		//RcrDiasLaborados
		$CantidadDiasMensual = cal_days_in_month(CAL_GREGORIAN, $GET_Mes, $GET_Ano); // 31
		$RcrDiasLaborados = $CantidadDiasMensual - 4;
		
		//RcrHoraDisponibles
		$RcrHorasDisponibles = $RcrDiasLaborados * 8;
		
		
		echo "ReporteCORId: ".$ReporteCORId ;
		echo "<br>";	
		
		echo "RcrVentaTallerMarca: ".$RcrVentaTallerMarca;
		echo "<br>";	
		
		echo "RcrVentaPPMarca: ".$RcrVentaPPMarca;
		echo "<br>";	
		
		echo "RcrVentaMesonMarca: ".$RcrVentaMesonMarca;
		echo "<br>";	
		
		echo "RcrVentaRatailMarca: ".$RcrVentaRatailMarca;
		echo "<br>";	
		
		echo "RcrVentaRetailLubricantes: ".$RcrVentaRetailLubricantes;
		echo "<br>";	
		
		echo "RcrTotalVentasRetail: ".$RcrTotalVentasRetail;
		echo "<br>";	
		
		echo "RcrMargenAporte: ".$RcrMargenAporte;
		echo "<br>";	
		
		
		
		echo "RcrStockMarca: ".$RcrStockMarca;
		echo "<br>";	
		
		echo "RcrStockLubricantes: ".$RcrStockLubricantes;
		echo "<br>";	
		
		echo "RcrTotalStock: ".$RcrTotalStock;
		echo "<br>";	
		
		echo "RcrValorRepuestosA: ".$RcrValorRepuestosA;
		echo "<br>";	
		
		echo "RcrValorRepuestosB: ".$RcrValorRepuestosB;
		echo "<br>";	
		
		echo "RcrValorRepuestosC: ".$RcrValorRepuestosC;
		echo "<br>";	
		
		echo "RcrValorRepuestosD: ".$RcrValorRepuestosD;
		echo "<br>";	
		
		echo "RcrRotationMarca: ".$RcrRotationMarca;
		echo "<br>";	
		
		echo "RcrValorPreObsoletos: ".$RcrValorPreObsoletos;
		echo "<br>";
		
		echo "RcrValorObsoletos: ".$RcrValorObsoletos;
		echo "<br>";	
		
		
		
		echo "RcrPedidosYSTK: ".$RcrPedidosYSTK;
		echo "<br>";	
		
		echo "RcrPedidosYRUSH: ".$RcrPedidosYRUSH;
		echo "<br>";	
		
		echo "RcrPedidosZVOR: ".$RcrPedidosZVOR;
		echo "<br>";	
		
		echo "RcrPedidosZGAR: ".$RcrPedidosZGAR;
		echo "<br>";	
		
		echo "RcrTasaServicioTaller: ".$RcrTasaServicioTaller;
		echo "<br>";
		
		echo "RcrMontoVentaPedidas: ".$RcrMontoVentaPedidas;
		echo "<br>";
		
		
		
		echo "RcrPersonalAsesorRepuestos: ".$RcrPersonalAsesorRepuestos;
		echo "<br>";	
		
		echo "RcrPersonalAsistenteAlmacen: ".$RcrPersonalAsistenteAlmacen;
		echo "<br>";
		
		echo "RcrDiasLaborados: ".$RcrDiasLaborados;
		echo "<br>";
		
		echo "RcrHorasDisponibles: ".$RcrHorasDisponibles;
		echo "<br>";
		
	
		
		
		if(empty($ReporteCORId)){
			
			$InsReporteCOR = new ClsReporteCOR();
			$InsReporteCOR->RcrId = NULL;
			$InsReporteCOR->VmaId = $GET_VehiculoMarca;
			$InsReporteCOR->RcrMes = $GET_Mes;
			$InsReporteCOR->RcrAno = $GET_Ano;
			
			$InsReporteCOR->RcrVentaTallerMarca = $RcrVentaTallerMarca;
			$InsReporteCOR->RcrVentaPPMarca = $RcrVentaPPMarca;
			$InsReporteCOR->RcrVentaMesonMarca = $RcrVentaMesonMarca;
			$InsReporteCOR->RcrVentaRatailMarca = $RcrVentaRatailMarca;
			$InsReporteCOR->RcrVentaRetailLubricantes = $RcrVentaRetailLubricantes;
			$InsReporteCOR->RcrTotalVentasRetail = $RcrTotalVentasRetail;
			$InsReporteCOR->RcrMargenAporte = $RcrMargenAporte;
			
			$InsReporteCOR->RcrStockMarca = $RcrStockMarca;
			$InsReporteCOR->RcrStockLubricantes = $RcrStockLubricantes;
			$InsReporteCOR->RcrTotalStock = $RcrTotalStock;
			$InsReporteCOR->RcrValorRepuestosA = $RcrValorRepuestosA;			
			$InsReporteCOR->RcrValorRepuestosB = $RcrValorRepuestosB;
			$InsReporteCOR->RcrValorRepuestosC = $RcrValorRepuestosC;
			$InsReporteCOR->RcrValorRepuestosD = $RcrValorRepuestosD;			
			$InsReporteCOR->RcrRotationMarca = $RcrRotationMarca;
			$InsReporteCOR->RcrValorPreObsoletos = $RcrValorPreObsoletos;
			$InsReporteCOR->RcrValorObsoletos = $RcrValorObsoletos;
			
			$InsReporteCOR->RcrPedidosYSTK = $RcrPedidosYSTK;
			$InsReporteCOR->RcrPedidosYRUSH = $RcrPedidosYRUSH;
			$InsReporteCOR->RcrPedidosZVOR = $RcrPedidosZVOR;
			$InsReporteCOR->RcrPedidosZGAR = $RcrPedidosZGAR;
			$InsReporteCOR->RcrTasaServicioTaller = $RcrTasaServicioTaller;
			$InsReporteCOR->RcrMontoVentaPedidas = $RcrMontoVentaPedidas;
			
			$InsReporteCOR->RcrPersonalAsesorRepuestos = $RcrPersonalAsesorRepuestos;
			$InsReporteCOR->RcrPersonalAsistenteAlmacen = $RcrPersonalAsistenteAlmacen;
			$InsReporteCOR->RcrDiasLaborados = $RcrDiasLaborados;
			$InsReporteCOR->RcrHorasDisponibles = $RcrHorasDisponibles;
			
			$InsReporteCOR->RcrTiempoCreacion = date("Y-m-d H:i:s");
			$InsReporteCOR->RcrTiempoModificacion = date("Y-m-d H:i:s");

			if($InsReporteCOR->MtdRegistrarReporteCOR()){				
				echo "Se registro los archivos COR";	
				echo "<br>";				
			}else {
				echo "No se pudo registrar los archivos COR";	
				echo "<br>";	
			}
			
		}else{
			
			echo "Se edito los archivos COR";	
			echo "<br>";	
				
			$InsReporteCOR = new ClsReporteCOR();
			$InsReporteCOR->MtdEditarReporteCORDato("RcrVentaTallerMarca",$RcrVentaTallerMarca,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrVentaPPMarca",$RcrVentaPPMarca,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrVentaMesonMarca",$RcrVentaMesonMarca,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrVentaRatailMarca",$RcrVentaRatailMarca,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrVentaRetailLubricantes",$RcrVentaRetailLubricantes,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrTotalVentasRetail",$RcrTotalVentasRetail,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrMargenAporte",$RcrMargenAporte,$ReporteCORId);
			
			$InsReporteCOR->MtdEditarReporteCORDato("RcrStockMarca",$RcrStockMarca,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrStockLubricantes",$RcrStockLubricantes,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrTotalStock",$RcrTotalStock,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrValorRepuestosA",$RcrValorRepuestosA,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrValorRepuestosB",$RcrValorRepuestosB,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrValorRepuestosC",$RcrValorRepuestosC,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrValorRepuestosD",$RcrValorRepuestosD,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrRotationMarca",$RcrRotationMarca,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrValorPreObsoletos",$RcrValorPreObsoletos,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrValorObsoletos",$RcrValorObsoletos,$ReporteCORId);
			
			$InsReporteCOR->MtdEditarReporteCORDato("RcrPedidosYSTK",$RcrPedidosYSTK,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrPedidosYRUSH",$RcrPedidosYRUSH,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrPedidosZVOR",$RcrPedidosZVOR,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrPedidosZGAR",$RcrPedidosZGAR,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrTasaServicioTaller",$RcrTasaServicioTaller,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrMontoVentaPedidas",$RcrMontoVentaPedidas,$ReporteCORId);
			
			$InsReporteCOR->MtdEditarReporteCORDato("RcrPersonalAsesorRepuestos",$RcrPersonalAsesorRepuestos,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrPersonalAsistenteAlmacen",$RcrPersonalAsistenteAlmacen,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrDiasLaborados",$RcrDiasLaborados,$ReporteCORId);
			$InsReporteCOR->MtdEditarReporteCORDato("RcrHorasDisponibles",$RcrHorasDisponibles,$ReporteCORId);
			
		}
		

echo "<hr>";
echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");


?>