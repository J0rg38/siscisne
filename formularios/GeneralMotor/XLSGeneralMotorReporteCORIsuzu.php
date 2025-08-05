<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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

//if($_GET['P']==2){
//	header("Content-type: application/vnd.ms-excel");
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_KPI_".date('d-m-Y').".xls\";");
//}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
    
	


$POST_Mes = empty($_GET['Mes'])?date("m"):$_GET['Mes'];
$POST_Ano = empty($_GET['Ano'])?date("Y"):$_GET['Ano'];
$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10018":$_GET['VehiculoMarca'];
$POST_Sucursal = empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal'];

if(empty($POST_VehiculoMarca)){
	die("No ha escogido una marca de vehiculo");
}

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
require_once($InsPoo->MtdPaqReporte().'ClsResumenStock.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteCOR.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


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
$InsResumenVenta = new ClsResumenVenta();
$InsResumenStock = new ClsResumenStock();

$InsPersonal->PerId = "PER-10016";
$InsPersonal->MtdObtenerPersonal();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
		
			
$InsSucursal = new ClsSucursal();		
$InsSucursal->SucId = $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();

		
$InsProveedor->PrvId = "PRV-10548";
$InsProveedor->MtdObtenerProveedor();

$CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano);

$FechaInicio = $POST_Ano."-01-01";
$FechaFin = $POST_Ano."-".$POST_Mes."-".$CantidadDias;

$SucursalNombre = $InsSucursal->SucNombre;
$SucursalDireccion = $InsSucursal->SucDireccion;
$SucursalDistrito = $InsSucursal->SucDistrito;
$SucursalProvincia = $InsSucursal->SucProvincia;

$SucursalNombreArchivo = str_replace(" ","",$SucursalNombre);

//MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentas(NULL,$FechaInicio,$FechaFin,NULL,NULL,"RprCantidad","DESC",NULL,$POST_VehiculoMarca,$POST_Sucursal);
$ArrReporteProductos = $ResReporteProducto['Datos'];

//MtdObtenerReporteProductoVentasPerdidas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
$ResReporteProductoVentasPerdida = $InsReporteProducto->MtdObtenerReporteProductoVentasPerdidas(NULL,$FechaInicio,$FechaFin,NULL,NULL,"cpr.CprFecha","DESC","",$POST_VehiculoMarca,$POST_Sucursal);
$ArrReporteProductoVentasPerdidas = $ResReporteProductoVentasPerdida['Datos'];



	
 // Create new PHPExcel object
  $objPHPExcel = new PHPExcel();
  
  $objReader = PHPExcel_IOFactory::createReader('Excel5');
			  // Set document properties
			  $objPHPExcel->getProperties()->setCreator($EmpresaNombre)
										   ->setLastModifiedBy($EmpresaNombre)
										   ->setTitle($EmpresaNombre)
										   ->setSubject($EmpresaNombre)
										   ->setDescription($EmpresaNombre)
										   ->setKeywords($EmpresaNombre)
										   ->setCategory($EmpresaNombre);
										   
			  $objPHPExcel = $objReader->load("../../plantilla/TemCORIsuzu.xls");
			  
			  


//DATOS CONCESIONARIO
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D6', $SucursalNombre);
								
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D7', $SucursalDireccion);										
								
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D8', $SucursalDistrito);											

$objPHPExcel->setActiveSheetIndex(0)
			//->setCellValue('D9', $InsPersonal->PerNombre.' '.$InsPersonal->PerApellidoPaterno.' '.$InsPersonal->PerApellidoMaterno);	
			->setCellValue('D9', "");	
								
$objPHPExcel->setActiveSheetIndex(0)
			//->setCellValue('D10', $InsPersonal->PtiNombre);									
			->setCellValue('D10',"");	
			
						
//DATOS DE LA INSTALACION
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M6', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M7', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M8', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M9', "");

																


//DATOS DEL PERSONAL
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M13', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M14', "");

	
	
	
	for($mes=1;$mes<=$POST_Mes;$mes++){
	
		
		$InsReporteCOR = new ClsReporteCOR();
		//MtdObtenerReporteCORs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL) {
		$ResReporteCOR = $InsReporteCOR->MtdObtenerReporteCORs(NULL,NULL,NULL,'RcrId','Desc','1',$POST_Ano,str_pad($mes,2,"0",STR_PAD_LEFT),$POST_VehiculoMarca);
		$ArrReporteCORs = $ResReporteCOR['Datos'];
		
		
		$RcrVentaTallerMarca[$mes] = 0;
		$RcrVentaPPMarca[$mes] = 0;
		$RcrVentaMesonMarca[$mes] = 0;
		$RcrVentaRatailMarca[$mes] = 0;
		$RcrVentaRetailLubricantes[$mes] = 0;
		$RcrTotalVentasRetail[$mes] = 0;
		$RcrMargenAporte[$mes] = 0;
		$RcrStockMarca[$mes] = 0;
		$RcrStockLubricantes[$mes] = 0;
		$RcrTotalStock[$mes] = 0;
		$RcrValorRepuestosA[$mes] = 0;
		$RcrValorRepuestosB[$mes] = 0;
		$RcrValorRepuestosC[$mes] = 0;
		$RcrValorRepuestosD[$mes] = 0;
		$RcrRotationMarca[$mes] = 0;
		$RcrValorPreObsoletos[$mes] = 0;
		$RcrValorObsoletos[$mes] = 0;
		$RcrPedidosYSTK[$mes] = 0;
		$RcrPedidosYRUSH[$mes] = 0;
		$RcrPedidosZVOR[$mes] = 0;
		$RcrPedidosZGAR[$mes] = 0;
		$RcrTasaServicioTaller[$mes] = 0;
		$RcrMontoVentaPedidas[$mes] = 0;
		$RcrPersonalAsesorRepuestos[$mes] = 0;
		$RcrPersonalAsistenteAlmacen[$mes] = 0;
		$RcrDiasLaborados[$mes] = 0;
		$RcrHorasDisponibles[$mes] = 0;
		  
		if(!empty($ArrReporteCORs)){
			foreach($ArrReporteCORs as $DatReporteCOR){
				
				$RcrVentaTallerMarca[$mes] = $DatReporteCOR->RcrVentaTallerMarca;
				$RcrVentaPPMarca[$mes] = $DatReporteCOR->RcrVentaPPMarca;
				$RcrVentaMesonMarca[$mes] = $DatReporteCOR->RcrVentaMesonMarca;
				$RcrVentaRatailMarca[$mes] = $DatReporteCOR->RcrVentaRatailMarca;
				$RcrVentaRetailLubricantes[$mes] = $DatReporteCOR->RcrVentaRetailLubricantes;
				
				$RcrTotalVentasRetail[$mes] = $DatReporteCOR->RcrTotalVentasRetail;
				$RcrMargenAporte[$mes] = $DatReporteCOR->RcrMargenAporte;
				$RcrStockMarca[$mes] =$DatReporteCOR->RcrStockMarca;
				$RcrStockLubricantes[$mes] = $DatReporteCOR->RcrStockLubricantes;
				$RcrTotalStock[$mes] = $DatReporteCOR->RcrTotalStock;
				$RcrValorRepuestosA[$mes] = $DatReporteCOR->RcrValorRepuestosA;
				$RcrValorRepuestosB[$mes] = $DatReporteCOR->RcrValorRepuestosB;
				$RcrValorRepuestosC[$mes] = $DatReporteCOR->RcrValorRepuestosC;
				$RcrValorRepuestosD[$mes] = $DatReporteCOR->RcrValorRepuestosD;
				$RcrRotationMarca[$mes] = $DatReporteCOR->RcrRotationMarca;
				$RcrValorPreObsoletos[$mes] =$DatReporteCOR->RcrValorPreObsoletos;
				$RcrValorObsoletos[$mes] =$DatReporteCOR->RcrValorObsoletos;
				
				$RcrPedidosYSTK[$mes] =$DatReporteCOR->RcrPedidosYSTK;
				$RcrPedidosYRUSH[$mes] =$DatReporteCOR->RcrPedidosYRUSH;
				$RcrPedidosZVOR[$mes] =$DatReporteCOR->RcrPedidosZVOR;
				$RcrPedidosZGAR[$mes] =$DatReporteCOR->RcrPedidosZGAR;
				$RcrTasaServicioTaller[$mes] =$DatReporteCOR->RcrTasaServicioTaller;
				$RcrMontoVentaPedidas[$mes] =$DatReporteCOR->RcrMontoVentaPedidas;
				$RcrPersonalAsesorRepuestos[$mes] =$DatReporteCOR->RcrPersonalAsesorRepuestos;
				$RcrPersonalAsistenteAlmacen[$mes] =$DatReporteCOR->RcrPersonalAsistenteAlmacen;
				$RcrDiasLaborados[$mes] =$DatReporteCOR->RcrDiasLaborados;
				$RcrHorasDisponibles[$mes] =$DatReporteCOR->RcrHorasDisponibles;
						 
			}
		}
	  
	}
       
	//RcrVentaTallerMarca

		$Fila = 7;
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'7', !empty($RcrVentaTallerMarca[$mes])?round($RcrVentaTallerMarca[$mes],2):'');
				
				
			}	
			
			$Columna++;		  
						  
		}
			
			
		//RcrVentaPPMarca
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'8', !empty($RcrVentaPPMarca[$mes])?round($RcrVentaPPMarca[$mes],2):'');
			

			}	
			
			$Columna++;		  
						  
		}
		
		
		//RcrVentaMesonMarca
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'9', !empty($RcrVentaMesonMarca[$mes])?round($RcrVentaMesonMarca[$mes],2):'');
			
				
			}	
			
			$Columna++;		  
						  
		}
		
		
		//RcrVentaRatailMarca
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
					$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'10', !empty($RcrVentaRatailMarca[$mes])?round($RcrVentaRatailMarca[$mes],2):'');
			
			}	
			
			$Columna++;		  
						  
		}
		
		
		//RcrVentaRetailLubricantes
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'11', !empty($RcrVentaRetailLubricantes[$mes])?round($RcrVentaRetailLubricantes[$mes],2):'');
			
				
			}	
			
			$Columna++;		  
						  
		}
		
		// RcrTotalVentasRetail
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'12', !empty($RcrTotalVentasRetail[$mes])?round($RcrTotalVentasRetail[$mes],2):'');
			
			}	
			
			$Columna++;		  
						  
		}	
		
		
		
		// RcrMargenAporte
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
				
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'13', !empty($RcrMargenAporte[$mes])?round($RcrMargenAporte[$mes],2):'');
			

			}	
			
			$Columna++;		  
						  
		}  
		
		
		
		
		
		
		
		
		
		//RcrStockMarca
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'17', !empty($RcrStockMarca[$mes])?round($RcrStockMarca[$mes],2):'');
			
			}	
			
			$Columna++;		  
						  
		}	
		
		//RcrStockLubricantes
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'18', !empty($RcrStockLubricantes[$mes])?round($RcrStockLubricantes[$mes],2):'');
			
			}	
			
			$Columna++;		  
						  
		}	
		
		
		//RcrTotalStock
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'19', !empty($RcrTotalStock[$mes])?round($RcrTotalStock[$mes],2):'');
			
			}	
			
			$Columna++;		  
						  
		}	
		
		//RcrValorRepuestosA
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'20', !empty($RcrValorRepuestosA[$mes])?round($RcrValorRepuestosA[$mes],2):'');
			
			}	
			
			$Columna++;		  
						  
		}	
		
		//RcrValorRepuestosB
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
					$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'21', !empty($RcrValorRepuestosB[$mes])?round($RcrValorRepuestosB[$mes],2):'');
			
			}	
			
			$Columna++;		  
						  
		}	
		
		
		//RcrValorRepuestosC
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'22', !empty($RcrValorRepuestosC[$mes])?round($RcrValorRepuestosC[$mes],2):'');
			
			}	
			
			$Columna++;		  
						  
		}	
		
		
		//RcrValorRepuestosD
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'23', !empty($RcrValorRepuestosD[$mes])?round($RcrValorRepuestosD[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
		
		//RcrRotationMarca
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
				 $objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'24', !empty($RcrRotationMarca[$mes])?round($RcrRotationMarca[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
		
		//RcrValorPreObsoletos
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
                 $objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'25', !empty($RcrValorPreObsoletos[$mes])?round($RcrValorPreObsoletos[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
		
		//RcrValorObsoletos
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			             
				 $objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'26', !empty($RcrValorObsoletos[$mes])?round($RcrValorObsoletos[$mes],2):'');
			
			}	
			
			$Columna++;	
		}	
		
		
		
		//RcrPedidosYSTK
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
				 $objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'30', !empty($RcrPedidosYSTK[$mes])?round($RcrPedidosYSTK[$mes],2):'');
			
			}	
			
			$Columna++;	
		}	
		
		
	//RcrPedidosYRUSH
	$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			 	$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'31', !empty($RcrPedidosYRUSH[$mes])?round($RcrPedidosYRUSH[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
		
		
		
		//RcrPedidosZVOR
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'32', !empty($RcrPedidosZVOR[$mes])?round($RcrPedidosZVOR[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
		
		//RcrPedidosZGAR
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'33', !empty($RcrPedidosZGAR[$mes])?round($RcrPedidosZGAR[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
		
		
		
		//RcrTasaServicioTaller
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			        
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'34', !empty($RcrTasaServicioTaller[$mes])?round($RcrTasaServicioTaller[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
		
		//RcrMontoVentaPedidas
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			        
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'35', !empty($RcrMontoVentaPedidas[$mes])?round($RcrMontoVentaPedidas[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
	
		
		//RcrPersonalAsesorRepuestos
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'39', !empty($RcrPersonalAsesorRepuestos[$mes])?round($RcrPersonalAsesorRepuestos[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
		
			
		//RcrPersonalAsistenteAlmacen
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'40', !empty($RcrPersonalAsistenteAlmacen[$mes])?round($RcrPersonalAsistenteAlmacen[$mes],2):'');
			


			}	
			
			$Columna++;	
		}	
		
		
		//RcrDiasLaborados
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'41', !empty($RcrDiasLaborados[$mes])?round($RcrDiasLaborados[$mes],2):'');
			

			}	
			
			$Columna++;	
		}	
		
		//RcrHorasDisponibles
		$Columna = 5;
		
		for($mes=1;$mes<=$POST_Mes;$mes++){
	
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'42', !empty($RcrHorasDisponibles[$mes])?round($RcrHorasDisponibles[$mes],2):'');
			


			}	
			
			$Columna++;	
		}	
		
		
		
		
		
		
		
		
		$Fila = 3;
		if(!empty($ArrReporteProductos)){
			foreach($ArrReporteProductos as $DatProducto){
		
				
				$objPHPExcel->setActiveSheetIndex(2)
										->setCellValue("A".$Fila,  $DatProducto->ProCodigoOriginal);
				
				$objPHPExcel->setActiveSheetIndex(2)
										->setCellValue("B".$Fila,  $DatProducto->ProNombre);
				$Columna =3;
										
				for($mes=1;$mes<=$POST_Mes;$mes++){
			
					if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
						$InsReporteProducto = new ClsReporteProducto();

						$TotalMensual[$mes] = $InsReporteProducto->MtdObtenerReporteProductoVentasMensual($DatProducto->ProId,$POST_Ano,$mes,$POST_VehiculoMarca);
						$objPHPExcel->setActiveSheetIndex(2)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).$Fila, !empty($TotalMensual[$mes])?$TotalMensual[$mes]:'');
						
					}	
					
					$Columna++;
					
				}	
				
					$objPHPExcel->setActiveSheetIndex(2)
										->setCellValue("P".$Fila,  $DatProducto->ProABCInterno);
				
				
				
				$Fila++;
			}
		}
		
		
		
		
		$Fila = 2;
		if(!empty($ArrReporteProductoVentasPerdidas)){
			foreach($ArrReporteProductoVentasPerdidas as $DatReporteProductoVentaPerdida){
			
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("A".$Fila, $DatReporteProductoVentaPerdida->ProCodigoOriginal);
								
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("B".$Fila, $DatReporteProductoVentaPerdida->ProNombre);
								
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("C".$Fila, $DatReporteProductoVentaPerdida->RprCantidad);
								
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("D".$Fila, $EmpresaMoneda." ".round($DatReporteProductoVentaPerdida->RprPrecio,2));
								
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("E".$Fila, FncConvertirMes($DatReporteProductoVentaPerdida->RprMes));

				$Fila++;				
			}	
		}
		
		
		
		$objPHPExcel->setActiveSheetIndex(1)
								->setCellValue("L43", date("d/m/Y"));
		
		
		$objPHPExcel->setActiveSheetIndex(1)
				//->setCellValue('L44', $InsPersonal->PerNombre.' '.$InsPersonal->PerApellidoPaterno.' '.$InsPersonal->PerApellidoMaterno);	
				->setCellValue('L44', "");	
									
									
								
								
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('COR - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/COR_".$InsVehiculoMarca->VmaNombre."_".$SucursalNombreArchivo."_".$POST_Ano."_".$POST_Mes.".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/COR_".$InsVehiculoMarca->VmaNombre."_".$SucursalNombreArchivo."_".$POST_Ano."_".$POST_Mes.".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
		
?>