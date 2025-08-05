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


require_once($InsPoo->MtdPaqReporte().'ClsResumenVenta.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFacturacion.php');


//$GET_VehiculoMarcaId = (empty($_GET['VehiculoMarcaId'])?"VMA-10017":$_GET['VehiculoMarcaId']);
$POST_Ano = date("Y");



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
$InsReporteFacturacion = new ClsReporteFacturacion();

$InsResumenVenta = new ClsResumenVenta();
//MtdNotificarFacturaPorVencer($oDestinatario,$oCantidadDia=5,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL){
//MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL) {

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaId","ASC",NULL,"1","3");
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$MargenAporte = 35;

if(!empty($ArrVehiculoMarcas)){
	foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
		
		echo "Marca: ".$DatVehiculoMarca->VmaNombre;
		echo "<br>";
		echo "<br>";
			
			for($mes=1;$mes<=12;$mes++){
			
			/*
			
			RveId,
					RveVentaTallerMarca,
					RveVentaPPMarca,
					RveVentaMesonMarca,
					RveVentaRetailMarca,
					RveVentaRetailLubricantes,
					RveTotalVentasRetail,
					RveAno,
					RveMes
			*/
			
			echo "Mes: ".FncConvertirMes($mes);
			echo "<br>";
			echo "<br>";
		
			//Venta Taller Marca:
			$VentaTallerMarca[$mes] = 0;
			
		//	public function MtdObtenerFacturacionTaller($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFichaIngresoModalidadIngreso=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL) {
			$VentaTallerMarca[$mes] = $InsReporteFacturacion->MtdObtenerFacturacionTaller("SUM","FdeImporte",$POST_Ano,$mes,$DatVehiculoMarca->VmaId,"RTI-10000",NULL,"fde.FdeId","DESC",NULL) ;
			
			echo "Venta Taller Marca: ";
			echo number_format($VentaTallerMarca[$mes],2);
			echo "<br>";
		
			
			//Venta PyP Marca
			echo "Venta PyP Marca: ";
			echo 0;
			echo "<br>";
			
			
			//Venta Meson Marca
			$VentasMesonMarca[$mes] = 0;	
			// MtdObtenerFacturacionMostrador($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL) {
			$VentasMesonMarca[$mes] = $InsReporteFacturacion->MtdObtenerFacturacionMostrador("SUM","FdeImporte",$POST_Ano,$mes,$DatVehiculoMarca->VmaId,"RTI-10000","fde.FdeId","DESC",NULL) ;
		//	$VentasMesonMarca[$mes] = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdImporte",$mes,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,"VMA-10017","RTI-10000");
			
			echo "Venta Meson Marca: ";
			echo number_format($VentasMesonMarca[$mes],2);
			echo "<br>";
				
			//Venta Retaik Marca
			echo "Venta Retail Marca: ";
			echo 0;
			echo "<br>";
			
			
			//Venta Retail Lubricantes
			$VentaRetailLubricantes[$mes] = 0;	
			$VentaRetailLubricantes[$mes] = $InsReporteFacturacion->MtdObtenerFacturacionTaller("SUM","FdeImporte",$POST_Ano,$mes,$DatVehiculoMarca->VmaId,"RTI-10001",NULL,"fde.FdeId","DESC",NULL) ;
			$VentaRetailLubricantes[$mes] += $InsReporteFacturacion->MtdObtenerFacturacionMostrador("SUM","FdeImporte",$POST_Ano,$mes,$DatVehiculoMarca->VmaId,"RTI-10001","fde.FdeId","DESC",NULL) ;	
			
			//$VentaRetailLubricantes[$mes] = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdImporte",$mes,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,NULL,"RTI-10001");
		
			echo "Venta Retail Lubricantes: ";
			echo number_format($VentaRetailLubricantes[$mes],2);
			echo "<br>";
		
			$TotalVentasRetail[$mes] += $VentaRetailLubricantes[$mes];
		
			echo "Total Ventas Retail";
			echo number_format($TotalVentasRetail[$mes],2);
			echo "<br>";
		
			echo "Margen Aporte (%): ";
			echo $MargenAporte;
			echo "<br>";
			
	
	
			$InsResumenVenta->VmaId = $DatVehiculoMarca->VmaId;
			$InsResumenVenta->RveVentaTallerMarca = $VentaTallerMarca[$mes];
			$InsResumenVenta->RveVentaPPMarca = 0;
			$InsResumenVenta->RveVentaMesonMarca = $VentasMesonMarca[$mes];
			$InsResumenVenta->RveVentaRetailMarca = 0;
			$InsResumenVenta->RveVentaRetailLubricantes = $VentaRetailLubricantes[$mes];	
			$InsResumenVenta->RveTotalVentasRetail = $TotalVentasRetail[$mes];	
			$InsResumenVenta->RveMargenAporte = $MargenAporte;	
			$InsResumenVenta->RveTiempoCreacion = date("Y-m-d H:i:s");
			
			$InsResumenVenta->RveAno = $POST_Ano;
			$InsResumenVenta->RveMes = $mes;
			$InsResumenVenta->MtdRegistrarResumenVenta();
				
		}
		
	}
}



?>