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
$POST_VehiculoMarca = empty($_GET['CmpVehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_Sucursal = empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal'];
//deb($POST_Mes);
if(empty($POST_VehiculoMarca)){
	die("No ha escogido una marca de vehiculo");
}



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
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFacturacion.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteCOS.php');

require_once($InsPoo->MtdPaqActividad().'ClsCita.php');

$InsTallerPedido = new ClsTallerPedido();
$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();

$InsVentaConcretada = new ClsVentaConcretada();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();

$InsFichaIngreso = new ClsFichaIngreso();

$InsPersonal = new ClsPersonal();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsCita = new ClsCita();
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


$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
		
		
$CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano);

$FechaInicio = $POST_Ano."-01-01";
$FechaFin = $POST_Ano."-".$POST_Mes."-".$CantidadDias;




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
										   
			  $objPHPExcel = $objReader->load("../../plantilla/TemCOSChevrolet.xls");
			  
			  

//DATOS CONCESIONARIO
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D6', $EmpresaNombre);
								
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D7', $EmpresaDireccion);										
								
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D8', $EmpresaDistrito);											

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D9', $InsPersonal->PerNombre.' '.$InsPersonal->PerApellidoPaterno.' '.$InsPersonal->PerApellidoMaterno);	
								
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D10', $InsPersonal->PtiNombre);									
						
//DATOS DE LA INSTALACION
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M6', "3S");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M7', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M8', "800 M2");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M9', "6");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M10', "5");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M11', "2");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M12', "1");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M13', "4");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M14', "3");
																


//DATOS DEL PERSONAL
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S7', "1");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S8', "2");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S9', "1");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S10', "");

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S12', "1");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S13', "4");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S14', "1");
					
	
	
	$c = 1;
	$Fila = 7;
	foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
		 if($DatKilometro['km']<=50000){
			$Columna = 5;
				for($mes=1;$mes<=$POST_Mes;$mes++){
					
					if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						
						$FichaIngresoMantenimientoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1) ;
						
						$TotalIngresoTipoMensual[$mes] += $FichaIngresoMantenimientoMensualTotal;
							 
						$objPHPExcel->setActiveSheetIndex(1)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).$Fila, !empty($FichaIngresoMantenimientoMensualTotal)?$FichaIngresoMantenimientoMensualTotal:'');
							
					}
						$Columna++;
				}
				
			$Fila++;
		 }
	}


	$FichaIngresoMantenimiento50TotalMensual = array();
						  
	foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
	
		if($DatKilometro['km']>50000){
	  
			 for($mes=1;$mes<=$POST_Mes;$mes++){
		   
		   		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
					$FichaIngresoMantenimiento50TotalMensual[$mes] += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1) ;

				}
				
			}
		 
		}
		
	}

	
	//50K>
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$TotalIngresoTipoMensual[$mes] += $FichaIngresoMantenimiento50TotalMensual[$mes];
		 		 
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'18', !empty($FichaIngresoMantenimiento50TotalMensual[$mes])?$FichaIngresoMantenimiento50TotalMensual[$mes]:'');
		}
		
		$Columna++;
					
	 }
	 
	 //Reparacion
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false)
			$FichaIngresoReparacionMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10003,MIN-10019,MIN-10020,MIN-10021",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,true) ;
			                     
			$FichaIngresoReparacionSumaTotal += $FichaIngresoReparacionMensualTotal;
			
			$TotalIngresoTipoMensual[$mes] += $FichaIngresoReparacionMensualTotal;
		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'19', !empty($FichaIngresoReparacionMensualTotal)?$FichaIngresoReparacionMensualTotal:'');
		 }
		 
		$Columna++;
					
	 }	
	 
	 
	  //Trabajo Interno
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){

			$FichaIngresoTrabajoInternoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1) ;
			
			$FichaIngresoTrabajoInternoSumaTotal += $FichaIngresoTrabajoInternoMensualTotal;
			
			$TotalIngresoTipoMensual[$mes] += $FichaIngresoTrabajoInternoMensualTotal;
														
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'20', !empty($FichaIngresoTrabajoInternoMensualTotal)?$FichaIngresoTrabajoInternoMensualTotal:'');

		 }
		 
		$Columna++;
					
	 }	
	 
	 
	//Garantias
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			$FichaIngresoGarantiaMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10000",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1) ;
			  
			$FichaIngresoGarantiaSumaTotal += $FichaIngresoGarantiaMensualTotal ;
			
			$TotalIngresoTipoMensual[$mes] += $FichaIngresoGarantiaMensualTotal;
													  
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'21', !empty($FichaIngresoGarantiaMensualTotal)?$FichaIngresoGarantiaMensualTotal:'');
		 }
		 
		$Columna++;
					
	 }	
	 
	 
	//Reingresos
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			$FichaIngresoReingresoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1) ;
			
			$FichaIngresoReingresoSumaTotal += $FichaIngresoReingresoMensualTotal ;
			
			$TotalIngresoTipoMensual[$mes] += $FichaIngresoReingresoMensualTotal;
																		  
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'22', !empty($FichaIngresoReingresoMensualTotal)?$FichaIngresoReingresoMensualTotal:'');
		 }
		 
		$Columna++;
					
	 }		 
	 
		//Total ingresos por tipo
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 											  
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'23', !empty($TotalIngresoTipoMensual[$mes])?$TotalIngresoTipoMensual[$mes]:'');
		 }
		 
		 
		$Columna++;
					
	 }		 
	 
	 
	 
	 
	 $Columna = 5;
	  for($mes=1;$mes<=$POST_Mes;$mes++){
			
			
						
			$TotalIngresoTipoMensualModelo[$mes] = 0;
			
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			//SPARK LITE
			$FichaIngresoMantenimientoMensualTotalSparkLite = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10006") ;			
			$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalSparkLite ;
								
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'26', !empty($FichaIngresoMantenimientoMensualTotalSparkLite)?$FichaIngresoMantenimientoMensualTotalSparkLite:'');					
								
			
			//SPARK GT
			$FichaIngresoMantenimientoMensualTotalSparkGT = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10005") ;
			$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalSparkGT ;
				
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'27', !empty($FichaIngresoMantenimientoMensualTotalSparkGT)?$FichaIngresoMantenimientoMensualTotalSparkGT:'');	
					
					
		//N300
		$FichaIngresoMantenimientoMensualTotalN300MoveMax = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10063,VMO-10064") ;
			$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalN300MoveMax ;
				
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'28', !empty($FichaIngresoMantenimientoMensualTotalN300MoveMax)?$FichaIngresoMantenimientoMensualTotalN300MoveMax:'');	
					
					
					
		//N300 WORK
		$FichaIngresoMantenimientoMensualTotalN300Work = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10065") ;
		$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalN300Work ;
								
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'29', !empty($FichaIngresoMantenimientoMensualTotalN300Work)?$FichaIngresoMantenimientoMensualTotalN300Work:'');	
					
					
		//CORSA 
		$FichaIngresoMantenimientoMensualTotalCorsaChevy = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10028,VMO-10052") ;
		$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalCorsaChevy ;
								
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'30', !empty($FichaIngresoMantenimientoMensualTotalCorsaChevy)?$FichaIngresoMantenimientoMensualTotalCorsaChevy:'');	
					
					
		//AVEO 
		$FichaIngresoMantenimientoMensualTotalAveo = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10000,VMO-10059") ;
		$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalAveo ;
								
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'31', !empty($FichaIngresoMantenimientoMensualTotalAveo)?$FichaIngresoMantenimientoMensualTotalAveo:'');	
								
										
		
		//SAIL 
		$FichaIngresoMantenimientoMensualTotalSail= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10003,VMO-10062") ;
		$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalSail ;
								
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'32', !empty($FichaIngresoMantenimientoMensualTotalSail)?$FichaIngresoMantenimientoMensualTotalSail:'');	
					
					
		//NUEVO SAIL 
		 $FichaIngresoMantenimientoMensualTotalNuevoSail= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10087") ;
		$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalNuevoSail ;
								
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'33', !empty($FichaIngresoMantenimientoMensualTotalNuevoSail)?$FichaIngresoMantenimientoMensualTotalNuevoSail:'');	
					
					
					
		//OPTRA
		$FichaIngresoMantenimientoMensualTotalOptra= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10002,VMO-10007") ;
		$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalOptra ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'34', !empty($FichaIngresoMantenimientoMensualTotalOptra)?$FichaIngresoMantenimientoMensualTotalOptra:'');	
					
					
		//SONIC
		$FichaIngresoMantenimientoMensualTotalSonic= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10004,VMO-10060") ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalSonic ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'35', !empty($FichaIngresoMantenimientoMensualTotalSonic)?$FichaIngresoMantenimientoMensualTotalSonic:'');	
					

		//CRUZE
		$FichaIngresoMantenimientoMensualTotalCruze= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10001,VMO-10061") ;
                            $TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalCruze ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'36', !empty($FichaIngresoMantenimientoMensualTotalCruze)?$FichaIngresoMantenimientoMensualTotalCruze:'');	
					
					
		//TRACKER
		 $FichaIngresoMantenimientoMensualTotalTracker= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10012") ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalTracker ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'37', !empty($FichaIngresoMantenimientoMensualTotalTracker)?$FichaIngresoMantenimientoMensualTotalTracker:'');
					
					

		//VIVANT
		 $FichaIngresoMantenimientoMensualTotalVivant= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10008") ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalVivant ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'38', !empty($FichaIngresoMantenimientoMensualTotalVivant)?$FichaIngresoMantenimientoMensualTotalVivant:'');
					
			//ORLANDO
		 $FichaIngresoMantenimientoMensualTotalOrlando= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10010") ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalOrlando ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'39', !empty($FichaIngresoMantenimientoMensualTotalOrlando)?$FichaIngresoMantenimientoMensualTotalOrlando:'');
							
			//CAPTIVA
		$FichaIngresoMantenimientoMensualTotalCaptiva= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10009") ;
								$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalCaptiva ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'40', !empty($FichaIngresoMantenimientoMensualTotalCaptiva)?$FichaIngresoMantenimientoMensualTotalCaptiva:'');		
					
						
			//S10
		$FichaIngresoMantenimientoMensualTotalS10= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10067") ;
		$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalS10 ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'41', !empty($FichaIngresoMantenimientoMensualTotalS10)?$FichaIngresoMantenimientoMensualTotalS10:'');						
					
						
		//TRAILBLAZER
		 $FichaIngresoMantenimientoMensualTotalTrailblazer= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10066") ;
		$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalTrailblazer ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'42', !empty($FichaIngresoMantenimientoMensualTotalTrailblazer)?$FichaIngresoMantenimientoMensualTotalTrailblazer:'');
					
					
		//TRAVERSE
		$FichaIngresoMantenimientoMensualTotalTraverse= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10013") ;
		 $TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalTraverse ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'43', !empty($FichaIngresoMantenimientoMensualTotalTraverse)?$FichaIngresoMantenimientoMensualTotalTraverse:'');
					
					
							
		//TAHOE SUBURBAN
		$FichaIngresoMantenimientoMensualTotalTahoeSuburban = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10011,VMO-10025") ;
		$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalTahoeSuburban ;
								
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'44', !empty($FichaIngresoMantenimientoMensualTotalTahoeSuburban)?$FichaIngresoMantenimientoMensualTotalTahoeSuburban:'');
					
					
				//OTROS
				$FichaIngresoMantenimientoMensualTotalModelo = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL) ;
								  
				$FichaIngresoMantenimientoMensualTotalOtroModelo[$mes]  = $FichaIngresoMantenimientoMensualTotalModelo - $TotalIngresoTipoMensualModelo[$mes];
									
				$TotalIngresoTipoMensualModelo[$mes] +=   $FichaIngresoMantenimientoMensualTotalOtroModelo[$mes] ;
					
				$objPHPExcel->setActiveSheetIndex(1)
							->setCellValue(FncConvertirNumeroALetraExcel($Columna).'45', !empty($FichaIngresoMantenimientoMensualTotalOtroModelo[$mes])?$FichaIngresoMantenimientoMensualTotalOtroModelo[$mes]:'');
					
			
			}
			
																	
		$Columna++;
										
	  }
			
			
			
			
	//TOTAL INGRESO X MODELO
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
		  //$FichaIngresoMantenimientoMensualTotalModelo = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL) ;
		  
		  														  
		//$objPHPExcel->setActiveSheetIndex(1)
		//			->setCellValue(FncConvertirNumeroALetraExcel($Columna).'46', !empty($FichaIngresoMantenimientoMensualTotalModelo)?$FichaIngresoMantenimientoMensualTotalModelo:'');
			$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue(FncConvertirNumeroALetraExcel($Columna).'46', !empty($TotalIngresoTipoMensualModelo[$mes])?$TotalIngresoTipoMensualModelo[$mes]:'');
		
		
		
		 }
		 
		$Columna++;
					
	 }	
	 
	 
	 
	for($mes=1;$mes<=$POST_Mes;$mes++){
					
  		$InsReporteCOS = new ClsReporteCOS();
        //MtdObtenerReporteCOSs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL) {
		$ResReporteCOS = $InsReporteCOS->MtdObtenerReporteCOSs(NULL,NULL,NULL,'RcoId','Desc','1',$POST_Ano,str_pad($mes,2,"0",STR_PAD_LEFT),$POST_VehiculoMarca);
		$ArrReporteCOSs = $ResReporteCOS['Datos'];
		
		$RcoNumeroCitas[$mes] = 0;
		$RcoClientesParticulares[$mes] = 0;
		$RcoClientesFlotas[$mes] = 0;
		$RcoPromedioPermanencia[$mes] = 0;
		$RcoParalizados[$mes] = 0;
		
		$RcoPersonalMecanicos[$mes] = 0;
		$RcoPersonalAsesores[$mes] = 0;
		$RcoPersonalOtros[$mes] = 0;
		$RcoDiasLaborados[$mes] = 0;
		$RcoHoraDisponibles[$mes] = 0;
		$RcoTarifaMO[$mes] = 0;
		
		$RcoHoraMOVendidas[$mes] = 0;
		$RcoVentaManoObra[$mes] = 0;
		$RcoVentaRepuestos[$mes] = 0;
		$RcoTicketPromedio[$mes] = 0;
		$RcoVentaGarantiaFA[$mes] = 0;
			
		if(!empty($ArrReporteCOSs)){
			foreach($ArrReporteCOSs as $DatReporteCOS){
				
				$RcoNumeroCitas[$mes] = $DatReporteCOS->RcoNumeroCitas;
								$RcoClientesParticulares[$mes] = $DatReporteCOS->RcoClientesParticulares;
								$RcoClientesFlotas[$mes] = $DatReporteCOS->RcoClientesFlotas;
								$RcoPromedioPermanencia[$mes] = $DatReporteCOS->RcoPromedioPermanencia;
								$RcoParalizados[$mes] = $DatReporteCOS->RcoParalizados;
								
                                $RcoPersonalMecanicos[$mes] = $DatReporteCOS->RcoPersonalMecanicos;
                                $RcoPersonalAsesores[$mes] = $DatReporteCOS->RcoPersonalAsesores;
                                $RcoPersonalOtros[$mes] =$DatReporteCOS->RcoPersonalOtros;
								
                                $RcoDiasLaborados[$mes] = $DatReporteCOS->RcoDiasLaborados;
                                $RcoHoraDisponibles[$mes] = $DatReporteCOS->RcoHoraDisponibles;
								$RcoHoraLaboradas[$mes] = $DatReporteCOS->RcoHoraLaboradas;
								$RcoTarifaMO[$mes] = $DatReporteCOS->RcoTarifaMO;
							   
                                $RcoHoraMOVendidas[$mes] = $DatReporteCOS->RcoHoraMOVendidas;
                                $RcoVentaManoObra[$mes] = $DatReporteCOS->RcoVentaManoObra;
                                $RcoVentaRepuestos[$mes] = $DatReporteCOS->RcoVentaRepuestos;
                                $RcoTicketPromedio[$mes] =$DatReporteCOS->RcoTicketPromedio;
                                $RcoVentaGarantiaFA[$mes] =$DatReporteCOS->RcoVentaGarantiaFA;
		
			}
		}
						
	}
	 
	 //CITAS
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
                   
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'48', !empty($RcoNumeroCitas[$mes])?round($RcoNumeroCitas[$mes],2):'');
						
						
		 }
		$Columna++;
					
	 }		 
	 
	 
	 //PARTICULARES
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'49', !empty($RcoClientesParticulares[$mes])?round($RcoClientesParticulares[$mes],2):'');
						
		}
		 
		$Columna++;
	 }		
	 		
	 //FLOTAS
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'50',!empty($RcoClientesFlotas[$mes])?round($RcoClientesFlotas[$mes],2):'');
					
		 }
		 
		$Columna++;
					
	 }				
			
	//PROMEDIO PERMANENCIA
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){

			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'51', !empty($RcoPromedioPermanencia[$mes])?round($RcoPromedioPermanencia[$mes],2):'');
					
		 }
		 
		$Columna++;
					
	 }		 	
			
	//PARALIZADOS
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'52', !empty($RcoParalizados[$mes])?round($RcoParalizados[$mes],2):'');
					
					
		 }
		$Columna++;
					
	 }		 	
			
	
	//TECNICOS
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'56', !empty($RcoPersonalMecanicos[$mes])?round($RcoPersonalMecanicos[$mes],2):'');
					
		 }
		 
		 
		$Columna++;
					
	 }	
	 
	 //ASESORES
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'57', !empty($RcoPersonalAsesores[$mes])?round($RcoPersonalAsesores[$mes],2):'');
					
					
					
				}
				
					
		$Columna++;
					
	 }		 	
			
	//OTROS
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'58', !empty($RcoPersonalOtros[$mes])?round($RcoPersonalOtros[$mes],2):'');
					
		}
		 	
		$Columna++;
					
	 }	
	 
	 //DIAS LABORADOS	
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
	
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'59', !empty($RcoDiasLaborados[$mes])?round($RcoDiasLaborados[$mes],2):'');
					 
		
			 
		 }
		 	
		$Columna++;
					
	 }			
					
  
  
	//HORAS TECNICO
	$Columna = 5;	
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'60',  !empty($RcoHoraDisponibles[$mes])?round($RcoHoraDisponibles[$mes],2):'');
						
			 
		 }
		 	
		$Columna++;
					
	 }	
	 
	 
	//HORAS LABORADAS TEC
	$Columna = 5;
	
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'61', !empty($RcoHoraLaboradas[$mes])?round($RcoHoraLaboradas[$mes],2):'');
						
						
			 
		 }
		 	
		$Columna++;
					
	 }	
	 
	 
	 
	 
	  //TARIFA MO
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){

		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'65', !empty($RcoTarifaMO[$mes])?round($RcoTarifaMO[$mes],2):'');
			
			
		}
		
					
		$Columna++;
					
	 }	
	 
	 
	  //HORAS MO
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'66',!empty($RcoHoraMOVendidas[$mes])?round($RcoHoraMOVendidas[$mes],2):'');
				
		}
					
		$Columna++;
					
	 }	
	 
	 
	 	 
	  //VENTA MO
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){

		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
 		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'67', !empty($RcoVentaManoObra[$mes])?round($RcoVentaManoObra[$mes],2):'');
					
		}
		
		$Columna++;
					
	 }	
	 
	 
	  //VENTA REPUESTOS
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){

		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'68', !empty($RcoVentaRepuestos[$mes])?$RcoVentaRepuestos[$mes]:'');
		
		}
		
		$Columna++;
					
	 }	
	 
	 	 
	  //TICKET PROMEDIO
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'69', !empty($RcoTicketPromedio[$mes])?$RcoTicketPromedio[$mes]:'');
		
		}
		
		$Columna++;
					
	}	
	 
	//VENTAS GARANTIA
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'70', !empty($RcoVentaGarantiaFA[$mes])?$RcoVentaGarantiaFA[$mes]:'');
						
		}
		$Columna++;
					
	 }
	 
	 $objPHPExcel->setActiveSheetIndex(1)
					->setCellValue('L73', date("d/m/Y"));
					
	$objPHPExcel->setActiveSheetIndex(1)
			->setCellValue('L72', $InsPersonal->PerNombre.' '.$InsPersonal->PerApellidoPaterno.' '.$InsPersonal->PerApellidoMaterno);	
									
					
        // Rename worksheet
       // $objPHPExcel->getActiveSheet()->setTitle('COS - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/COS_".$InsVehiculoMarca->VmaNombre."_".$POST_Ano."_".$POST_Mes.".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/COS_".$InsVehiculoMarca->VmaNombre."_".$POST_Ano."_".$POST_Mes.".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
	
																						
?>