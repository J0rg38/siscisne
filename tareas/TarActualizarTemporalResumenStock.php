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

$GET_VehiculoMarcaId = (empty($_GET['VehiculoMarcaId'])?"VMA-10017":$_GET['VehiculoMarcaId']);

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
require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqReporte().'ClsResumenStock.php');


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
$InsResumenStock = new ClsResumenStock();
$InsReporteAlmacenMovimiento = new ClsReporteAlmacenMovimiento();



$POST_Ano = date("Y");


$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaId","ASC",NULL,"1","3");
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];


if(!empty($ArrVehiculoMarcas)){
	foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
		
		echo "Marca: ".$DatVehiculoMarca->VmaNombre;
		echo "<br>";
		echo "<br>";

		for($mes=1;$mes<=12;$mes++){
			
			/*
			RstId,
			RstVentaTallerMarca,
			RstVentaPPMarca,
			RstVentaMesonMarca,
			RstVentaRetailMarca,
			RstVentaRetailLubricantes,
			RstTotalVentasRetail,
			RstAno,
			RstMes
			*/
			
			echo "Mes: ".FncConvertirMes($mes);
			echo "<br>";
			echo "<br>";
		
			//Stock Marca
			$MARCAStockMensual[$mes] = 0;
			$MARCAEntradas[$mes] = 0;
			$MARCASalidas[$mes] = 0;
			$Stock = 0;

			$MARCAEntradas[$mes] = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-".$mes."-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10000");  
			$MARCASalidas[$mes] = $InsReporteAlmacenMovimiento->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",$mes,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10000");
			
			$Stock = $MARCAEntradas[$mes] - $MARCASalidas[$mes];

			$MARCAStockMensual[$mes] = $Stock + $MARCAStockMensual[$mes-1];
			$STOCKTotalMensual[$mes] += $MARCAStockMensual[$mes];
			
			echo "Stock Marca: ";
			echo number_format($MARCAStockMensual[$mes],2);
			echo "<br>";

			//Stock Lubricantes
			$LUBRICANTEStockMensual[$mes] = 0;
			$LUBRICANTESEntradas[$mes] = 0;
			$LUBRICANTESSalidas[$mes] = 0;
			$Stock = 0;

			$LUBRICANTESEntradas[$mes] = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-".$mes."-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10001");  
			$LUBRICANTESSalidas[$mes] = $InsReporteAlmacenMovimiento->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdCantidadReal",$mes,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10001");

			$Stock = $LUBRICANTESEntradas[$mes] - $LUBRICANTESSalidas[$mes];

			$LUBRICANTEStockMensual[$mes] = $Stock + $LUBRICANTEStockMensual[$mes-1];
			$STOCKTotalMensual[$mes] += $LUBRICANTEStockMensual[$mes];
			 
			echo "Stock Lubricantes";
			echo number_format($LUBRICANTEStockMensual[$mes],2);
			echo "<br>";
				  
			//Valor en repuestos A (%)
			$PIEZASA_MARCA[$mes] = 0;
			$PIEZASA_LUBRICANTES[$mes] = 0;
			$PIEZASA[$mes] = 0;
			
			$PIEZASA_MARCA[$mes] = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10000",0,30); 
			$PIEZASA_LUBRICANTES[$mes] = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10001",0,30); 

			$Stock = $PIEZASA_MARCA[$mes] + $PIEZASA_LUBRICANTES[$mes] - $MARCASalidas[$mes] - $LUBRICANTESSalidas[$mes];
			
			$PIEZASA[$mes] = ((($Stock) *  100) / $STOCKTotalMensual[$mes]);
			
			echo "Valor en repuestos A (%)";
			echo number_format($PIEZASA[$mes],2);
			echo "<br>";
		
			//Valor en repuestos B (%)
			$PIEZASB_MARCA[$mes] = 0;
			$PIEZASB_LUBRICANTES[$mes] = 0;
			$PIEZASB[$mes] = 0;
			
			$PIEZASB_MARCA[$mes] = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10000",31,60); 
			$PIEZASB_LUBRICANTES[$mes] = $InsReporteAlmacenMovimiento->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10001",31,60); 

			$Stock = $PIEZASB_MARCA[$mes] + $PIEZASB_LUBRICANTES[$mes] - $MARCASalidas[$mes] - $LUBRICANTESSalidas[$mes];
			
			$PIEZASB[$mes] = ((($Stock) *  100) / $STOCKTotalMensual[$mes]);
		
		
			echo "Valor en repuestos B (%)";
			echo number_format($PIEZASB[$mes],2);
			echo "<br>";
		
		
			//Valor en repuestos C (%)
			$PIEZASC_MARCA[$mes] =0;
			$PIEZASC_LUBRICANTES[$mes] =0;
			$PIEZASC[$mes] =0;
			
			$PIEZASC_MARCA[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10000",61,0); 
			$PIEZASC_LUBRICANTES[$mes] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$mes."-".FncCantidadDiaMes($POST_Ano,$mes),NULL,0,NULL,NULL,NULL,3,$DatVehiculoMarca->VmaId,"RTI-10001",61,0); 

			$Stock = $PIEZASC_MARCA[$mes] + $PIEZASC_LUBRICANTES[$mes] - $MARCASalidas[$mes] - $LUBRICANTESSalidas[$mes];
			
			$PIEZASC[$mes] = ((($Stock) *  100) / $STOCKTotalMensual[$mes]);
			
			
		
			echo "Valor en repuestos C (%)";
			echo number_format($PIEZASC[$mes],2);
			echo "<br>";
					 
			//Valor en repuestos D (%)  
			echo "Valor en repuestos D (%)";
			echo 0;
			echo "<br>";
		
		
		
			//Rotación Marca
			$MARCARotacion[$mes] = 0;		 
			$MARCARotacion[$mes] = ($MARCACostoMensual[$mes]/$MARCAStockMensual[$mes]);
		
			echo "Rotación Marca";
			echo number_format($MARCARotacion[$mes],2);
			echo "<br>";
		
		
				   
		/*
		  public $RstId;
			public $RstStockMarca;
			public $RstStockLubricantes;
			
			public $RstTotalStock;
			public $RstValorRepuestoA;
			public $RstValorRepuestoB;
			public $RstValorRepuestoC;
			public $RstValorRepuestoD;
			
			public $RstRotacionMarca;
			public $RstValorPreObsoletos;
			public $RstValorObsoletos;
		*/
		
			$InsResumenStock->VmaId = $GET_VehiculoMarcaId;		
			$InsResumenStock->RstStockMarca = $MARCAStockMensual[$mes];
			$InsResumenStock->RstStockLubricantes = $LUBRICANTEStockMensual[$mes];
			$InsResumenStock->RstTotalStock = $STOCKTotalMensual[$mes];
			$InsResumenStock->RstValorRepuestoA = $PIEZASA[$mes];
			$InsResumenStock->RstValorRepuestoB = $PIEZASB[$mes];	
			$InsResumenStock->RstValorRepuestoC = $PIEZASC[$mes];	
			$InsResumenStock->RstValorRepuestoD = 0;	
			
			$InsResumenStock->RstRotacionMarca = $MARCARotacion[$mes];	
			$InsResumenStock->RstValorPreObsoletos = 0;	
			$InsResumenStock->RstValorObsoletos = 0;	
						
			$InsResumenStock->RstTiempoCreacion = date("Y-m-d H:i:s");
			
			$InsResumenStock->RstAno = $POST_Ano;
			$InsResumenStock->RstMes = $mes;
			$InsResumenStock->MtdRegistrarResumenStock();
				
		}
		
	}	
}


?>