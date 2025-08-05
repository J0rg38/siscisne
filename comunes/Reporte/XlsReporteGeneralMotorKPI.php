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
        




$POST_Mes = empty($_POST['CmpMes'])?date("m"):$_POST['CmpMes'];
$POST_Ano = empty($_POST['CmpAno'])?date("Y"):$_POST['CmpAno'];

$POST_TipoCambio = ($_POST['CmpTipoCambio']);



require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');


require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsTallerPedido = new ClsTallerPedido();
$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();

$InsVentaConcretada = new ClsVentaConcretada();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();


$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();

$InsFichaIngreso = new ClsFichaIngreso();

$InsPersonal = new ClsPersonal();

$InsPersonal->PerId = "PER-10016";
$InsPersonal->MtdObtenerPersonal();




require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');




	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	
	$InsTipoCambio->MtdObtenerTipoCambioActual();
	
	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	$TipoCambio = $InsTipoCambio->TcaMontoComercial;
	
$POST_TipoCambio = empty($POST_TipoCambio)?$TipoCambio:$POST_TipoCambio;

		



        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
					// Set document properties
					$objPHPExcel->getProperties()->setCreator("C&C S.A.C.")
												 ->setLastModifiedBy("C&C S.A.C.")
												 ->setTitle("C&C S.A.C.")
												 ->setSubject("C&C S.A.C.")
												 ->setDescription("C&C S.A.C.")
												 ->setKeywords("C&C S.A.C.")
												 ->setCategory("C&C S.A.C.");
												 
					$objPHPExcel = $objReader->load("../../plantilla/TemKPI.xls");

					//ANO Y MES
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG3', FncConvertirMes($POST_Mes)." ".$POST_Ano);
								
										
					
					

					//ELABORADO POR
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AA42', $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno);
					//FECHA Y HORA
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AA43', date("d/m/Y H:i:s"));
								
								
					

       
        

        			  for($i=1;$i<=12;$i++){
		              
                      
						 $CHEVROLETTallerPedidoDetalleTotalMensual[$i] = 0;
						 $CHEVROLETVentaConcretadaDetalleTotalMensual[$i] = 0;
						 
						 $ISUZUTallerPedidoDetalleTotalMensual[$i] = 0;
						 $ISUZUVentaConcretadaDetalleTotalMensual[$i] = 0;
						 
						 
						 $CHEVROLETTotalMensual[$i] = 0;
						 $ISUZUTotalMensual[$i] = 0;
						 $LUBRICANTETotalMensual[$i] = 0;	
						 
						 $VENTASTotalMensual[$i] = 0;	
						 
						 
						 
						 
							$CHEVROLETStockMensual[$i] = 0;
							$ISUZUStockMensual[$i] = 0;
							$LUBRICANTEStockMensual[$i] = 0;
							
							$STOCKTotalMensual[$i] = 0;
							
							
							
							
							
							
							$CHEVROLETRotacion[$i] = 0;
							$ISUZURotacion[$i] = 0;
							
							
							$CHEVROLETTotalIngresoMensual[$i] = 0;
							$ISUZUTotalIngresoMensual[$i] = 0;
							
							
							
							
							
							
							
							
						$CHEVROLETTallerPedidoDetalleCostoMensual[$i] = 0;
						$CHEVROLETVentaConcretadaDetalleCostoMensual[$i] = 0;
						 
						$ISUZUTallerPedidoDetalleCostoMensual[$i] = 0;
						$ISUZUVentaConcretadaDetalleCostoMensual[$i] = 0;
						 					 
						$CHEVROLETCostoMensual[$i] = 0;
						$ISUZUCostoMensual[$i] = 0;				 
											 
						 
					}
		
		
		
		$Columna = 3;
		
		for($i=1;$i<=12;$i++){
		
			$CHEVROLETTallerPedidoDetalleTotalMensual[$i] = 0;
			$CHEVROLETTallerPedidoDetalleTotalMensual[$i] = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetallesValor("SUM","AmdImporte",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,"VMA-10017","RTI-10000");
			
			$CHEVROLETTallerPedidoDetalleTotalMensual[$i] = $CHEVROLETTallerPedidoDetalleTotalMensual[$i]/$POST_TipoCambio;
			$CHEVROLETTotalMensual[$i] += $CHEVROLETTallerPedidoDetalleTotalMensual[$i];
			
			//echo number_format($CHEVROLETTallerPedidoDetalleTotalMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'7', !empty($CHEVROLETTallerPedidoDetalleTotalMensual[$i])?$CHEVROLETTallerPedidoDetalleTotalMensual[$i]:'0');
			
			
			$CHEVROLETTallerPedidoDetalleCostoMensual[$i] = 0;
			$CHEVROLETTallerPedidoDetalleCostoMensual[$i] = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCosto",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,"VMA-10017","RTI-10000");
			
			$CHEVROLETCostoMensual[$i] += $CHEVROLETTallerPedidoDetalleCostoMensual[$i];

// --------------------------------------------------------------------------------

			$CHEVROLETVentaConcretadaDetalleTotalMensual[$i] = 0;
			$CHEVROLETVentaConcretadaDetalleTotalMensual[$i] = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdImporte",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,"VMA-10017","RTI-10000");
			
			$CHEVROLETVentaConcretadaDetalleTotalMensual[$i] = $CHEVROLETVentaConcretadaDetalleTotalMensual[$i]/$POST_TipoCambio;
			
			$CHEVROLETTotalMensual[$i] += $CHEVROLETVentaConcretadaDetalleTotalMensual[$i];
			
			//echo number_format($CHEVROLETVentaConcretadaDetalleTotalMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'8', !empty($CHEVROLETVentaConcretadaDetalleTotalMensual[$i])?$CHEVROLETVentaConcretadaDetalleTotalMensual[$i]:'0');
			
			
			$CHEVROLETVentaConcretadaDetalleCostoMensual[$i] = 0;
			$CHEVROLETVentaConcretadaDetalleCostoMensual[$i] = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdCosto",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,"VMA-10017","RTI-10000");
			
			$CHEVROLETCostoMensual[$i] += $CHEVROLETVentaConcretadaDetalleCostoMensual[$i];

// --------------------------------------------------------------------------------
			
			$VENTASTotalMensual[$i] += $CHEVROLETTotalMensual[$i];
			
			// echo number_format($CHEVROLETTotalMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'9', !empty($CHEVROLETTotalMensual[$i])?$CHEVROLETTotalMensual[$i]:'0');

// --------------------------------------------------------------------------------		
			
			$ISUZUTallerPedidoDetalleTotalMensual[$i] = 0;
			$ISUZUTallerPedidoDetalleTotalMensual[$i] = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetallesValor("SUM","AmdImporte",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,"VMA-10018","RTI-10000");
			
			$ISUZUTallerPedidoDetalleTotalMensual[$i] = $ISUZUTallerPedidoDetalleTotalMensual[$i]/$POST_TipoCambio;
			
			$ISUZUTotalMensual[$i] += $ISUZUTallerPedidoDetalleTotalMensual[$i];
			
			//echo number_format($ISUZUTallerPedidoDetalleTotalMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'10', !empty($ISUZUTallerPedidoDetalleTotalMensual[$i])?$ISUZUTallerPedidoDetalleTotalMensual[$i]:'0');
			
			
			
			$ISUZUTallerPedidoDetalleCostoMensual[$i] = 0;
			$ISUZUTallerPedidoDetalleCostoMensual[$i] = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCosto",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,"VMA-10018","RTI-10000");
			
			$ISUZUCostoMensual[$i] += $ISUZUTallerPedidoDetalleCostoMensual[$i];





			$ISUZUVentaConcretadaDetalleTotalMensual[$i] = 0;
			$ISUZUVentaConcretadaDetalleTotalMensual[$i] = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdImporte",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,"VMA-10018","RTI-10000");
			
			$ISUZUVentaConcretadaDetalleTotalMensual[$i] = $ISUZUVentaConcretadaDetalleTotalMensual[$i]/$POST_TipoCambio;
			
			$ISUZUTotalMensual[$i] += $ISUZUVentaConcretadaDetalleTotalMensual[$i];
			
			//echo number_format($ISUZUVentaConcretadaDetalleTotalMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'11', !empty($ISUZUVentaConcretadaDetalleTotalMensual[$i])?$ISUZUVentaConcretadaDetalleTotalMensual[$i]:'0');
			
			
			$ISUZUVentaConcretadaDetalleCostoMensual[$i] = 0;
			$ISUZUVentaConcretadaDetalleCostoMensual[$i] = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdCosto",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,"VMA-10018","RTI-10000");
			
			$ISUZUCostoMensual[$i] += $ISUZUVentaConcretadaDetalleCostoMensual[$i];
 
// --------------------------------------------------------------------------------

			$VENTASTotalMensual[$i] += $ISUZUTotalMensual[$i];
 
// --------------------------------------------------------------------------------

			// echo number_format($ISUZUTotalMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'12', !empty($ISUZUTotalMensual[$i])?$ISUZUTotalMensual[$i]:'0');

// --------------------------------------------------------------------------------


			$LUBRICANTEentaConcretadaDetalleTotalMensual[$i] = 0;
			$LUBRICANTEentaConcretadaDetalleTotalMensual[$i] = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdImporte",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,NULL,"RTI-10001");
			
			$LUBRICANTEentaConcretadaDetalleTotalMensual[$i] = $LUBRICANTEentaConcretadaDetalleTotalMensual[$i]/$POST_TipoCambio;
			
			$LUBRICANTETotalMensual[$i] += $LUBRICANTEentaConcretadaDetalleTotalMensual[$i];
			
			//echo number_format($LUBRICANTEentaConcretadaDetalleTotalMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'13', !empty($LUBRICANTEentaConcretadaDetalleTotalMensual[$i])?$LUBRICANTEentaConcretadaDetalleTotalMensual[$i]:'0');
			
// --------------------------------------------------------------------------------
			
			$VENTASTotalMensual[$i] += $LUBRICANTETotalMensual[$i];
			
// --------------------------------------------------------------------------------
			
 			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'14', !empty($VENTASTotalMensual[$i])?$VENTASTotalMensual[$i]:'0');
			
// --------------------------------------------------------------------------------
			
			$CHEVROLETStockMensual[$i] = 0;
			$CHEVROLETEntradas[$i] = 0;
			$CHEVROLETSalidas[$i] = 0;
			$Stock = 0;
			
			$CHEVROLETEntradas[$i] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-".$i."-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,"VMA-10017","RTI-10000");  
			
			$CHEVROLETSalidas[$i] = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,"VMA-10017","RTI-10000");
			
			$Stock = $CHEVROLETEntradas[$i] - $CHEVROLETSalidas[$i];
			
			$CHEVROLETStockMensual[$i] = $Stock + $CHEVROLETStockMensual[$i-1];
			
			//echo number_format($CHEVROLETStockMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'15', !empty($CHEVROLETStockMensual[$i])?$CHEVROLETStockMensual[$i]:'0');
			
			
			$STOCKTotalMensual[$i] += $CHEVROLETStockMensual[$i];
					   
// --------------------------------------------------------------------------------	   
		   
			$ISUZUStockMensual[$i] = 0;
			$ISUZUEntradas[$i] = 0;
			$ISUZUSalidas[$i] = 0;
			$Stock = 0;
			
			$ISUZUEntradas[$i] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-".$i."-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,"VMA-10018","RTI-10000");  
			
			$ISUZUSalidas[$i] = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetallesValor("SUM","AmdCantidadReal",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,3,"VMA-10018","RTI-10000");
			
			$Stock = $ISUZUEntradas[$i] - $ISUZUSalidas[$i];
			
			$ISUZUStockMensual[$i] = $Stock + $ISUZUStockMensual[$i-1];	   
		   
		    //echo number_format($ISUZUStockMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'16', !empty($ISUZUStockMensual[$i])?$ISUZUStockMensual[$i]:'0');
			
 			$STOCKTotalMensual[$i] += $ISUZUStockMensual[$i] ;

// --------------------------------------------------------------------------------	 
			
			$LUBRICANTEStockMensual[$i] = 0;
			$LUBRICANTESEntradas[$i] = 0;
			$LUBRICANTESSalidas[$i] = 0;
			$Stock = 0;
			
			
			$LUBRICANTESEntradas[$i] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-".$i."-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,NULL,"RTI-10001");  
			
			$LUBRICANTESSalidas[$i] = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetallesValor("SUM","AmdCantidadReal",$i,$POST_Ano,NULL,NULL,'amd.AmdId','Desc',NULL,NULL,NULL,NULL,NULL,3,NULL,"RTI-10001");
			
			$Stock = $LUBRICANTESEntradas[$i] - $LUBRICANTESSalidas[$i];
			
			$LUBRICANTEStockMensual[$i] = $Stock + $LUBRICANTEStockMensual[$i-1];
			
			//echo number_format($LUBRICANTEStockMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'17', !empty($LUBRICANTEStockMensual[$i])?$LUBRICANTEStockMensual[$i]:'0');
			
			
		   $STOCKTotalMensual[$i] += $LUBRICANTEStockMensual[$i];

// --------------------------------------------------------------------------------	 

			//echo number_format($STOCKTotalMensual[$i],2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'18', !empty($STOCKTotalMensual[$i])?$STOCKTotalMensual[$i]:'0');
			
// --------------------------------------------------------------------------------	 
			
$PIEZASA_CHEVROLET = 0;
$PIEZASA_ISUZU = 0;
$PIEZASA_LUBRICANTES = 0;
$PIEZASA = 0;

$PIEZASA_CHEVROLET = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,"VMA-10017","RTI-10000",0,30); 

$PIEZASA_ISUZU = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,"VMA-10018","RTI-10000",0,30); 

$PIEZASA_LUBRICANTES = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,NULL,"RTI-10001",0,30); 

$Stock = $PIEZASA_CHEVROLET + $PIEZASA_ISUZU + $PIEZASA_LUBRICANTES 
- $CHEVROLETSalidas[$i] - $ISUZUSalidas[$i] - $LUBRICANTESSalidas[$i];


$PIEZASA = ((($Stock) *  100) / $STOCKTotalMensual[$i]);
		
			//echo number_format($PIEZASA,2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'19', !empty($PIEZASA)?$PIEZASA:'0');
			

// --------------------------------------------------------------------------------	 
			
$PIEZASB_CHEVROLET = 0;
$PIEZASB_ISUZU = 0;
$PIEZASB_LUBRICANTES = 0;
$PIEZASB = 0;

$PIEZASB_CHEVROLET = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,"VMA-10017","RTI-10000",31,60); 

$PIEZASB_ISUZU = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,"VMA-10018","RTI-10000",31,60); 

$PIEZASB_LUBRICANTES = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,NULL,"RTI-10001",31,60); 


$Stock = $PIEZASB_CHEVROLET + $PIEZASB_ISUZU + $PIEZASB_LUBRICANTES;
- $CHEVROLETSalidas[$i] - $ISUZUSalidas[$i] - $LUBRICANTESSalidas[$i];

//$Stock = $PIEZASB_CHEVROLET + $PIEZASB_ISUZU + $PIEZASB_LUBRICANTES;
//$Stock = round($Stock,2);


//echo "::: ".$PIEZASB_CHEVROLET." - ".$PIEZASB_ISUZU." - ".$PIEZASB_LUBRICANTES;
//echo "<br>";



$PIEZASB = ((($Stock) *  100) / $STOCKTotalMensual[$i]);

//echo number_format($PIEZASB,2);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'20', !empty($PIEZASB)?$PIEZASB:'0');

// --------------------------------------------------------------------------------	 



$PIEZASC_CHEVROLET =0;
$PIEZASC_ISUZU =0;
$PIEZASC_LUBRICANTES =0;
$PIEZASC =0;

$PIEZASC_CHEVROLET = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,"VMA-10017","RTI-10000",61,0); 

$PIEZASC_ISUZU = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,"VMA-10018","RTI-10000",61,0); 

$PIEZASC_LUBRICANTES = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetallesValor("SUM","AmdCantidadReal",NULL,NULL,NULL,NULL,NULL,'amd.AmdId','Desc',1,NULL,NULL,NULL,NULL,$POST_Ano."-01-01",$POST_Ano."-".$i."-".FncCantidadDiaMes($POST_Ano,$i),NULL,0,NULL,NULL,NULL,3,NULL,"RTI-10001",61,0); 


$Stock = $PIEZASC_CHEVROLET + $PIEZASC_ISUZU + $PIEZASC_LUBRICANTES;
- $CHEVROLETSalidas[$i] - $ISUZUSalidas[$i] - $LUBRICANTESSalidas[$i];

$PIEZASC = ((($Stock) *  100) / $STOCKTotalMensual[$i]);
			
				$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'21', !empty($PIEZASC)?$PIEZASC:'0');		
			

// --------------------------------------------------------------------------------	 

			$CHEVROLETRotacion[$i] = 0;		 
			$CHEVROLETRotacion[$i] = ($CHEVROLETCostoMensual[$i]/$CHEVROLETStockMensual[$i]);

			//echo number_format($CHEVROLETRotacion[$i],2);

			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'22', !empty($CHEVROLETRotacion[$i])?$CHEVROLETRotacion[$i]:'0');
			
// --------------------------------------------------------------------------------			
			
			$ISUZURotacion[$i] = 0;		 
			$ISUZURotacion[$i] = ($ISUZUCostoMensual[$i]/$ISUZUStockMensual[$i]);

			//echo number_format($ISUZURotacion[$i],2);	
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'23', !empty($ISUZURotacion[$i])?$ISUZURotacion[$i]:'0');
				
/* ********************************** */
		
			$CHEVROLETTotalIngresoMensual[$i] = 0;
			$CHEVROLETTotalIngresoMensual[$i] = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$i,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011,LTI-10010","VMA-10017") ;
		
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'24', !empty($CHEVROLETTotalIngresoMensual[$i])?$CHEVROLETTotalIngresoMensual[$i]:'0');
			
/* ********************************** */

			$ISUZUTotalIngresoMensual[$i] = 0;
			$ISUZUTotalIngresoMensual[$i] = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$i,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011,LTI-10010","VMA-10018") ;
			//echo number_format($ISUZUTotalIngresoMensual[$i]);				
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'25', !empty($ISUZUTotalIngresoMensual[$i])?$ISUZUTotalIngresoMensual[$i]:'0');
					
			$Columna++;

		}
				
                
        
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('KPI');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("KPI_".$POST_Mes."_".$POST_Ano.".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: KPI_".$POST_Mes."_".$POST_Ano.".xls");
        // echo "KPI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
?>
