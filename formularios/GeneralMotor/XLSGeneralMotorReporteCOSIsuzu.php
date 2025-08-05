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
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

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
		


$InsSucursal = new ClsSucursal();		
$InsSucursal->SucId = $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();

		
$SucursalNombre = $InsSucursal->SucNombre;
$SucursalDireccion = $InsSucursal->SucDireccion;
$SucursalDistrito = $InsSucursal->SucDistrito;
$SucursalProvincia = $InsSucursal->SucProvincia;

$SucursalNombreArchivo = str_replace(" ","",$SucursalNombre);



$CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano);

$FechaInicio = $POST_Ano."-01-01";
$FechaFin = $POST_Ano."-".$POST_Mes."-".$CantidadDias;





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
										   
			  $objPHPExcel = $objReader->load("../../plantilla/TemCOSIsuzu.xls");
			  
			 // 
//
////DATOS CONCESIONARIO
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('D6', $EmpresaNombre);
//								
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('D7', $EmpresaDireccion);										
//								
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('D8', $EmpresaDistrito);											
//
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('D9', $InsPersonal->PerNombre.' '.$InsPersonal->PerApellidoPaterno.' '.$InsPersonal->PerApellidoMaterno);	
//								
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('D10', $InsPersonal->PtiNombre);									
//						
////DATOS DE LA INSTALACION
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('M6', "3S");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('M7', "");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('M8', "800 M2");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('M9', "6");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('M10', "5");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('M11', "2");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('M12', "1");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('M13', "4");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('M14', "3");
//																
//
//
////DATOS DEL PERSONAL
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('S7', "1");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('S8', "2");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('S9', "1");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('S10', "");
//
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('S12', "1");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('S13', "4");
//$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('S14', "1");
					


//DATOS CONCESIONARIO
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D6', $SucursalNombre);
								
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D7', $SucursalDireccion);										
								
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D8', $SucursalDistrito);											

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D9', "");	
//			->setCellValue('D9', $InsPersonal->PerNombre.' '.$InsPersonal->PerApellidoPaterno.' '.$InsPersonal->PerApellidoMaterno);	
								
$objPHPExcel->setActiveSheetIndex(0)
//			->setCellValue('D10', $InsPersonal->PtiNombre);									
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
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M10', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M11', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M12', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M13', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M14', "");
																


//DATOS DEL PERSONAL
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S7', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S8', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S9', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S10', "");

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S12', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S13', "");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('S14', "");
					



	for($mes=1;$mes<=$POST_Mes;$mes++){
					
  		$InsReporteCOS = new ClsReporteCOS();
        //MtdObtenerReporteCOSs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL) {
		$ResReporteCOS = $InsReporteCOS->MtdObtenerReporteCOSs(NULL,NULL,NULL,'RcoId','Desc','1',$POST_Ano,str_pad($mes,2,"0",STR_PAD_LEFT),$POST_VehiculoMarca,$POST_Sucursal);
                        $ArrReporteCOSs = $ResReporteCOS['Datos'];
		
		  $RcoIngresoPrimeraRevision[$mes] = 0;
		  
		  	$RcoIngresoServicio1000[$mes] = 0;
						$RcoIngresoServicio1500[$mes] = 0;
						
						
						$RcoIngresoServicio5000[$mes] = 0;
						$RcoIngresoServicio10000[$mes] = 0;				
						$RcoIngresoServicio15000[$mes] = 0;				
						$RcoIngresoServicio20000[$mes] = 0;				
						$RcoIngresoServicio25000[$mes] = 0;					
						$RcoIngresoServicio30000[$mes] = 0;				
						$RcoIngresoServicio35000[$mes] = 0;				
						$RcoIngresoServicio40000[$mes] = 0;		
						$RcoIngresoServicio45000[$mes] = 0;		
						$RcoIngresoServicio50000[$mes] = 0;
						$RcoIngresoServicio50000Mas[$mes] = 0;
						
						$RcoIngresoServicioReparaciones[$mes] = 0;		
						$RcoIngresoServicioPlanchadoPintado[$mes] = 0;						
						$RcoIngresoServicioTrabajoInterno[$mes] = 0;						
						$RcoIngreseServicioGarantias[$mes] = 0;						
						$RcoIngresoServicioInstalacionAccesorios[$mes] = 0;						
						$RcoIngresoServicioReingresos[$mes] = 0;						
						$RcoIngresoServicioInstalacionGLP[$mes] = 0;						
						$RcoIngresoServicioSuperCambio99[$mes] = 0;
						
						
						
		$RcoIngresoSparkLite[$mes] = 0;		
		$RcoIngresoSparkGT[$mes] = 0;		
		$RcoIngresoN300MoveMax[$mes] = 0;		
		$RcoIngresoN300Work[$mes] = 0;		
		$RcoIngresoCorsaChevyTaxi[$mes] = 0;		
		$RcoIngresoSail[$mes] = 0;		
		$RcoIngresoOnix[$mes] = 0;		
		$RcoIngresoPrisma[$mes] = 0;		
		$RcoIngresoNuevoSail[$mes] = 0;		
		$RcoIngresoAveo[$mes] = 0;		
		$RcoIngresoOptra[$mes] = 0;		
		$RcoIngresoSonic[$mes] = 0;		
		$RcoIngresoCruze[$mes] = 0;		
		$RcoIngresoSpin[$mes] = 0;		
		$RcoIngresoTracker[$mes] = 0;		
		$RcoIngresoVivant[$mes] = 0;		
		$RcoIngresoOrlando[$mes] = 0;		
		$RcoIngresoCaptiva[$mes] = 0;		
		$RcoIngresoS10[$mes] = 0;		
		$RcoIngresoTrailblazer[$mes] = 0;		
		$RcoIngresoTraverse[$mes] = 0;		
		$RcoIngresoTahoeSuburban[$mes] = 0;		
		
				
		
		$RcoIngresoNLR3TON[$mes] = 0;	
		$RcoIngresoREWARD400DT[$mes] = 0;		
		$RcoIngresoREWARD400NMR[$mes] = 0;		
		$RcoIngresoNPR4TON[$mes] = 0;		
		$RcoIngresoREWARD500[$mes] = 0;		
		$RcoIngresoFTR10TON[$mes] = 0;						
		$RcoIngresoFORWARD800[$mes] = 0;			
		$RcoIngresoFORWARD1300[$mes] = 0;				
		$RcoIngresoFORWARD2000[$mes] = 0;		
		
		$RcoIngresoOtrasUnidades[$mes] = 0;				
		$RcoTotalIngresosUnidadesMantenimiento[$mes] = 0;				
		$RcoTotalIngresosUnidades[$mes] = 0;				
		
						$RcoNumeroCitas[$mes] = 0;
						$RcoCitasEfectivas[$mes] = 0;
						
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
						
						 $RcoVentaMecanica[$mes] = 0;
                        $RcoVentaGarantiaFA[$mes] = 0;
			
		if(!empty($ArrReporteCOSs)){
			foreach($ArrReporteCOSs as $DatReporteCOS){
				
								//$RcoIngresoPrimeraRevision[$mes] = $DatReporteCOS->RcoIngresoPrimeraRevision;
								
								$RcoIngresoServicio1000[$mes]= $DatReporteCOS->RcoIngresoServicio1000;
								$RcoIngresoServicio1500[$mes]= $DatReporteCOS->RcoIngresoServicio1500;
								
								$RcoIngresoPrimeraRevision[$mes] = $RcoIngresoServicio1000[$mes] + $RcoIngresoServicio1500[$mes];	
								
								$RcoIngresoServicio5000[$mes]= $DatReporteCOS->RcoIngresoServicio5000;
								$RcoIngresoServicio10000[$mes] = $DatReporteCOS->RcoIngresoServicio10000;		
								$RcoIngresoServicio15000[$mes] = $DatReporteCOS->RcoIngresoServicio15000;			
								$RcoIngresoServicio20000[$mes] = $DatReporteCOS->RcoIngresoServicio20000;		
								$RcoIngresoServicio25000[$mes] = $DatReporteCOS->RcoIngresoServicio25000;				
								$RcoIngresoServicio30000[$mes] = $DatReporteCOS->RcoIngresoServicio30000;		
								$RcoIngresoServicio35000[$mes] = $DatReporteCOS->RcoIngresoServicio35000;			
								$RcoIngresoServicio40000[$mes] = $DatReporteCOS->RcoIngresoServicio40000;	
								$RcoIngresoServicio45000[$mes]= $DatReporteCOS->RcoIngresoServicio45000;	
								$RcoIngresoServicio50000[$mes] = $DatReporteCOS->RcoIngresoServicio50000;
								$RcoIngresoServicio50000Mas[$mes] = $DatReporteCOS->RcoIngresoServicio50000Mas;
								
								$RcoIngresoServicioReparaciones[$mes] = $DatReporteCOS->RcoIngresoServicioReparaciones;	
								$RcoIngresoServicioPlanchadoPintado[$mes]  = $DatReporteCOS->RcoIngresoServicioPlanchadoPintado;					
								$RcoIngresoServicioTrabajoInterno[$mes]  = $DatReporteCOS->RcoIngresoServicioTrabajoInterno;					
								$RcoIngreseServicioGarantias[$mes]  = $DatReporteCOS->RcoIngreseServicioGarantias;				
								$RcoIngresoServicioInstalacionAccesorios[$mes]  = $DatReporteCOS->RcoIngresoServicioInstalacionAccesorios;				
								$RcoIngresoServicioReingresos[$mes]  = $DatReporteCOS->RcoIngresoServicioReingresos;						
								$RcoIngresoServicioInstalacionGLP[$mes]  = $DatReporteCOS->RcoIngresoServicioInstalacionGLP;					
								$RcoIngresoServicioSuperCambio99[$mes]  = $DatReporteCOS->RcoIngresoServicioSuperCambio99;
								
								
												
								$RcoIngresoSparkLite[$mes]  = $DatReporteCOS->RcoIngresoSparkLite;
								$RcoIngresoSparkGT[$mes]  = $DatReporteCOS->RcoIngresoSparkGT;	
								$RcoIngresoN300MoveMax[$mes]  = $DatReporteCOS->RcoIngresoN300MoveMax;	
								$RcoIngresoN300Work[$mes]  = $DatReporteCOS->RcoIngresoN300Work;	
								$RcoIngresoCorsaChevyTaxi[$mes]  = $DatReporteCOS->RcoIngresoCorsaChevyTaxi;	
								$RcoIngresoSail[$mes]  = $DatReporteCOS->RcoIngresoSail;
								$RcoIngresoOnix[$mes]  = $DatReporteCOS->RcoIngresoOnix;
								$RcoIngresoPrisma[$mes]  = $DatReporteCOS->RcoIngresoPrisma;		
								$RcoIngresoNuevoSail[$mes]  = $DatReporteCOS->RcoIngresoNuevoSail;		
								$RcoIngresoAveo[$mes]  = $DatReporteCOS->RcoIngresoAveo;	
								$RcoIngresoOptra[$mes]  = $DatReporteCOS->RcoIngresoOptra;
								$RcoIngresoSonic[$mes]  = $DatReporteCOS->RcoIngresoSonic;	
								$RcoIngresoCruze[$mes]  = $DatReporteCOS->RcoIngresoCruze;
								$RcoIngresoSpin[$mes]  = $DatReporteCOS->RcoIngresoSpin;	
								$RcoIngresoTracker[$mes]  = $DatReporteCOS->RcoIngresoTracker;	
								$RcoIngresoVivant[$mes]  = $DatReporteCOS->RcoIngresoVivant;	
								$RcoIngresoOrlando[$mes]  = $DatReporteCOS->RcoIngresoOrlando;	
								$RcoIngresoCaptiva[$mes]  = $DatReporteCOS->RcoIngresoCaptiva;		
								$RcoIngresoS10[$mes]  = $DatReporteCOS->RcoIngresoS10;	
								$RcoIngresoTrailblazer[$mes]  = $DatReporteCOS->RcoIngresoTrailblazer;	
								$RcoIngresoTraverse[$mes]  = $DatReporteCOS->RcoIngresoTraverse;
								$RcoIngresoTahoeSuburban[$mes]  = $DatReporteCOS->RcoIngresoTahoeSuburban;
								
										
								
								$RcoIngresoNLR3TON[$mes] = $DatReporteCOS->RcoIngresoNLR3TON;	
								$RcoIngresoREWARD400DT[$mes] = $DatReporteCOS->RcoIngresoREWARD400DT;	
								$RcoIngresoREWARD400NMR[$mes] = $DatReporteCOS->RcoIngresoREWARD400NMR;	
								$RcoIngresoNPR4TON[$mes] = $DatReporteCOS->RcoIngresoNPR4TON;
								$RcoIngresoREWARD500[$mes] = $DatReporteCOS->RcoIngresoREWARD500;	
								$RcoIngresoFTR10TON[$mes] = $DatReporteCOS->RcoIngresoFTR10TON;					
								$RcoIngresoFORWARD800[$mes] = $DatReporteCOS->RcoIngresoFORWARD800;			
								$RcoIngresoFORWARD1300[$mes] = $DatReporteCOS->RcoIngresoFORWARD1300;			
								$RcoIngresoFORWARD2000[$mes] = $DatReporteCOS->RcoIngresoFORWARD2000;	
								
								$RcoIngresoOtrasUnidades[$mes] = $DatReporteCOS->RcoIngresoOtrasUnidades;
								$RcoTotalIngresosUnidadesMantenimiento[$mes] = $DatReporteCOS->RcoTotalIngresosUnidadesMantenimiento;
								$RcoTotalIngresosUnidades[$mes] = $DatReporteCOS->RcoTotalIngresosUnidades;
				
								$RcoNumeroCitas[$mes] = $DatReporteCOS->RcoNumeroCitas;
								$RcoCitasEfectivas[$mes] = $DatReporteCOS->RcoCitasEfectivas;
								
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
								
								$RcoVentaMecanica[$mes] =$DatReporteCOS->RcoVentaMecanica;
                                $RcoVentaGarantiaFA[$mes] =$DatReporteCOS->RcoVentaGarantiaFA;
		
			}
		}
						
	}
	 
	 
	 
	 
	 
	 //
//	
//	$c = 1;
//	$Fila = 7;
//	foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
//		 if($DatKilometro['km']<=50000){
//			$Columna = 5;
//				for($mes=1;$mes<=$POST_Mes;$mes++){
//					
//					if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
//						
////MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
//						$FichaIngresoMantenimientoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
//						
//						$TotalIngresoTipoMensual[$mes] += $FichaIngresoMantenimientoMensualTotal;
//							 
//						$objPHPExcel->setActiveSheetIndex(1)
//								->setCellValue(FncConvertirNumeroALetraExcel($Columna).$Fila, !empty($FichaIngresoMantenimientoMensualTotal)?$FichaIngresoMantenimientoMensualTotal:'');
//							
//					}
//						$Columna++;
//				}
//				
//			$Fila++;
//		 }
//	}
//
//
//	$FichaIngresoMantenimiento50TotalMensual = array();
//						  
//	foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
//	
//		if($DatKilometro['km']>50000){
//	  
//			 for($mes=1;$mes<=$POST_Mes;$mes++){
//		   
//		   		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
//				
//					//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
//					$FichaIngresoMantenimiento50TotalMensual[$mes] += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
//
//				}
//				
//			}
//		 
//		}
//		
//	}




	//Servicio 1500
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'7', !empty($RcoIngresoServicio1500[$mes])?$RcoIngresoServicio1500[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }


	//Servicio 5000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'8', !empty($RcoIngresoServicio5000[$mes])?$RcoIngresoServicio5000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	 
	  //Servicio 10000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'9', !empty($RcoIngresoServicio10000[$mes])?$RcoIngresoServicio10000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	 
	   //Servicio 15000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'10', !empty($RcoIngresoServicio15000[$mes])?$RcoIngresoServicio15000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	//Servicio 20000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'11', !empty($RcoIngresoServicio20000[$mes])?$RcoIngresoServicio20000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	 
	 //Servicio 25000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'12', !empty($RcoIngresoServicio25000[$mes])?$RcoIngresoServicio25000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	//Servicio 30000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'13', !empty($RcoIngresoServicio30000[$mes])?$RcoIngresoServicio30000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	 //Servicio 35000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'14', !empty($RcoIngresoServicio35000[$mes])?$RcoIngresoServicio35000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	 
	 //Servicio 40000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'15', !empty($RcoIngresoServicio40000[$mes])?$RcoIngresoServicio40000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	//Servicio 45000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'16', !empty($RcoIngresoServicio45000[$mes])?$RcoIngresoServicio45000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	 //Servicio 50000
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'17', !empty($RcoIngresoServicio50000[$mes])?$RcoIngresoServicio50000[$mes]:'');
					
					
		}
		
		$Columna++;
					
	 }
	 
	//50K>
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$TotalIngresoTipoMensual[$mes] += $FichaIngresoMantenimiento50TotalMensual[$mes];
		 		 
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'18', !empty($RcoIngresoServicio50000Mas[$mes])?$RcoIngresoServicio50000Mas[$mes]:'');
		}
		
		$Columna++;
					
	 }
	 
	 //Reparacion
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			 //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
			//$FichaIngresoReparacionMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10003,MIN-10019,MIN-10020,MIN-10021",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,true,$POST_Sucursal,NULL) ;
//			
//			$FichaIngresoReparacionSumaTotal += $FichaIngresoReparacionMensualTotal;
//			
//			$TotalIngresoTipoMensual[$mes] += $FichaIngresoReparacionMensualTotal;
//		
//								
//			$objPHPExcel->setActiveSheetIndex(1)
//					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'19', !empty($FichaIngresoReparacionMensualTotal)?$FichaIngresoReparacionMensualTotal:'');
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'19', !empty($RcoIngresoServicioReparaciones[$mes])?$RcoIngresoServicioReparaciones[$mes]:'');
				
		
		
		 }
		 
		$Columna++;
					
	 }	
	 
	 
	  //Trabajo Interno
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
			//$FichaIngresoTrabajoInternoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
//			
//			$FichaIngresoTrabajoInternoSumaTotal += $FichaIngresoTrabajoInternoMensualTotal;
//			
//			$TotalIngresoTipoMensual[$mes] += $FichaIngresoTrabajoInternoMensualTotal;
//														
//			$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'20', !empty($FichaIngresoTrabajoInternoMensualTotal)?$FichaIngresoTrabajoInternoMensualTotal:'');

			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'20', !empty($RcoIngresoServicioTrabajoInterno[$mes])?$RcoIngresoServicioTrabajoInterno[$mes]:'');
				
				
		 }
		 
		$Columna++;
					
	 }	
	 
	 
	//Garantias
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			 //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
			//$FichaIngresoGarantiaMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10000",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
//			
//			$FichaIngresoGarantiaSumaTotal += $FichaIngresoGarantiaMensualTotal ;
//			
//			$TotalIngresoTipoMensual[$mes] += $FichaIngresoGarantiaMensualTotal;
//													  
//			$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'21', !empty($FichaIngresoGarantiaMensualTotal)?$FichaIngresoGarantiaMensualTotal:'');
//		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'21', !empty($RcoIngreseServicioGarantias[$mes])?$RcoIngreseServicioGarantias[$mes]:'');
			
			

 }
		 
		$Columna++;
					
	 }	
	 
	////Siniestros
//	$Columna = 5;
//	for($mes=1;$mes<=$POST_Mes;$mes++){
//		 
//		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
//			 //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
//			  $FichaIngresoSiniestroMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
//								
//			$FichaIngresoSiniestroSumaTotal += $FichaIngresoSiniestroMensualTotal ;
//			$TotalIngresoTipoMensual[$mes] += $FichaIngresoSiniestroMensualTotal;
//													  
//			$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'22', !empty($FichaIngresoSiniestroMensualTotal)?$FichaIngresoSiniestroMensualTotal:'');
//		 }
//		 
//		$Columna++;
//					
//	 }	
	 
	 
	//Reingresos
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
		//	 //MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
//			$FichaIngresoReingresoMensualTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,NULL,false,$POST_Sucursal,NULL) ;
//			
//			$FichaIngresoReingresoSumaTotal += $FichaIngresoReingresoMensualTotal ;
//			
//			$TotalIngresoTipoMensual[$mes] += $FichaIngresoReingresoMensualTotal;
//																		  
//			$objPHPExcel->setActiveSheetIndex(1)
//					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'23', !empty($FichaIngresoReingresoMensualTotal)?$FichaIngresoReingresoMensualTotal:'');
		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'22', !empty($RcoIngresoServicioReingresos[$mes])?$RcoIngresoServicioReingresos[$mes]:'');
			
		
		 }
		 
		$Columna++;
					
	 }		 
	 
	//Total ingresos por tipo
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 											  
			//$objPHPExcel->setActiveSheetIndex(1)
//					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'24', !empty($TotalIngresoTipoMensual[$mes])?$TotalIngresoTipoMensual[$mes]:'');

				$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'23', !empty($RcoTotalIngresosUnidadesMantenimiento[$mes])?$RcoTotalIngresosUnidadesMantenimiento[$mes]:'');
		
		 }
		 
		 
		$Columna++;
					
	 }		 
	 
	 
	 
	 
	 
	 
	 
	  
	 $Columna = 5;
	  for($mes=1;$mes<=$POST_Mes;$mes++){
				
			//$TotalIngresoTipoMensualModelo[$mes] = 0;
			
			if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				//NLR 3 TON
				
				//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
				//$FichaIngresoMantenimientoMensualTotalNLR3TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10091",false,$POST_Sucursal,NULL) ;
//				$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalNLR3TON ;
//									
//				$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'27', !empty($FichaIngresoMantenimientoMensualTotalNLR3TON)?$FichaIngresoMantenimientoMensualTotalNLR3TON:'');					
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'26', !empty($RcoIngresoNLR3TON[$mes])?$RcoIngresoNLR3TON[$mes]:'');					
					
					
				//REWARD 400DT
				//$FichaIngresoMantenimientoMensualTotalREWARD400DT = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10076",false,$POST_Sucursal,NULL) ;
//				$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalREWARD400DT ;
//									
//				$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'28', !empty($FichaIngresoMantenimientoMensualTotalREWARD400DT)?$FichaIngresoMantenimientoMensualTotalREWARD400DT:'');					
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'27', !empty($RcoIngresoREWARD400DT[$mes])?$RcoIngresoREWARD400DT[$mes]:'');					
				
				//REWARD 400DT NMR
				
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'28', !empty($RcoIngresoREWARD400NMR[$mes])?$RcoIngresoREWARD400NMR[$mes]:'');					
			
				
				
				//NPR 4 TON
				//$FichaIngresoMantenimientoMensualTotalNPR4TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10084",false,$POST_Sucursal,NULL) ;
//				$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalNPR4TON ;
//									
//				$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'29', !empty($FichaIngresoMantenimientoMensualTotalNPR4TON)?$FichaIngresoMantenimientoMensualTotalNPR4TON:'');					
//					
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'29', !empty($RcoIngresoNPR4TON[$mes])?$RcoIngresoNPR4TON[$mes]:'');					
			


	
				//REWARD 500
			//	$FichaIngresoMantenimientoMensualTotalNREWARD500 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10071",false,$POST_Sucursal,NULL) ;
//				$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalNREWARD500 ;
//									
//				$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'30', !empty($FichaIngresoMantenimientoMensualTotalNREWARD500)?$FichaIngresoMantenimientoMensualTotalNREWARD500:'');					
//					
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'30', !empty($RcoIngresoREWARD500[$mes])?$RcoIngresoREWARD500[$mes]:'');					
			


				//FORWARD 800
			//	$FichaIngresoMantenimientoMensualTotalFORWARD800 = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10072",false,$POST_Sucursal,NULL) ;
//				$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalFORWARD800 ;
//									
//				$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'31', !empty($FichaIngresoMantenimientoMensualTotalFORWARD800)?$FichaIngresoMantenimientoMensualTotalFORWARD800:'');					

				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'31', !empty($RcoIngresoFORWARD800[$mes])?$RcoIngresoFORWARD800[$mes]:'');					
			
			
				//FTR 10 TON
			//	$FichaIngresoMantenimientoMensualTotalFTR10TON = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10090",false,$POST_Sucursal,NULL) ;
//				$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalFTR10TON ;
//									
//				$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'32', !empty($FichaIngresoMantenimientoMensualTotalFTR10TON)?$FichaIngresoMantenimientoMensualTotalFTR10TON:'');					
//			
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'32', !empty($RcoIngresoFTR10TON[$mes])?$RcoIngresoFTR10TON[$mes]:'');					
			
			
				 			
				//FORWARD 1300
				//$FichaIngresoMantenimientoMensualTotalFORWARD1300= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10074",false,$POST_Sucursal,NULL) ;
//				$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalFORWARD1300 ;
//									
//				$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'33', !empty($FichaIngresoMantenimientoMensualTotalFORWARD1300)?$FichaIngresoMantenimientoMensualTotalFORWARD1300:'');					

				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'33', !empty($RcoIngresoFORWARD1300[$mes])?$RcoIngresoFORWARD1300[$mes]:'');					
			
			
				
				//FORWARD 2000
				//$FichaIngresoMantenimientoMensualTotalFORWARD2000= $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10000,MIN-10016",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,1,NULL,"VMO-10075",false,$POST_Sucursal,NULL) ;
//				$TotalIngresoTipoMensualModelo[$mes] +=  $FichaIngresoMantenimientoMensualTotalFORWARD2000 ;
//									
//				$objPHPExcel->setActiveSheetIndex(1)
//						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'34', !empty($FichaIngresoMantenimientoMensualTotalFORWARD2000)?$FichaIngresoMantenimientoMensualTotalFORWARD2000:'');					
//							
				$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'34', !empty($RcoIngresoFORWARD2000[$mes])?$RcoIngresoFORWARD2000[$mes]:'');					
			
 
				
					$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'35', !empty($RcoIngresoOtrasUnidades[$mes])?$RcoIngresoOtrasUnidades[$mes]:'');					
			
			
			
			}
			
																	
		$Columna++;
										
	  }
			
	
	 //TOTAL INGRESO X MODELO
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
		//	$objPHPExcel->setActiveSheetIndex(1)
//				->setCellValue(FncConvertirNumeroALetraExcel($Columna).'35', !empty($TotalIngresoTipoMensualModelo[$mes])?$TotalIngresoTipoMensualModelo[$mes]:'');
//		
		$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'36', !empty($RcoTotalIngresosUnidades[$mes])?$RcoTotalIngresosUnidades[$mes]:'');					
			
		
		 }
		 
		$Columna++;
					
	 }	
	 
	
	 
	 //CITAS
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
                   
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'39', !empty($RcoNumeroCitas[$mes])?round($RcoNumeroCitas[$mes],2):'');
						
						
		 }
		$Columna++;
					
	 }		 
	 
	 
	 //PARTICULARES
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'40', !empty($RcoClientesParticulares[$mes])?round($RcoClientesParticulares[$mes],2):'');
						
		}
		 
		$Columna++;
	 }		
	 		
	 //FLOTAS
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'41',!empty($RcoClientesFlotas[$mes])?round($RcoClientesFlotas[$mes],2):'');
					
		 }
		 
		$Columna++;
					
	 }				
			
	//PROMEDIO PERMANENCIA
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){

			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'42', !empty($RcoPromedioPermanencia[$mes])?round($RcoPromedioPermanencia[$mes],2):'');
					
		 }
		 
		$Columna++;
					
	 }		 	
			
	//PARALIZADOS
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'43', !empty($RcoParalizados[$mes])?round($RcoParalizados[$mes],2):'');
					
					
		 }
		$Columna++;
					
	 }		 	
			
	
	//TECNICOS
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'47', !empty($RcoPersonalMecanicos[$mes])?round($RcoPersonalMecanicos[$mes],2):'');
					
		 }
		 
		 
		$Columna++;
					
	 }	
	 
	 //ASESORES
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'48', !empty($RcoPersonalAsesores[$mes])?round($RcoPersonalAsesores[$mes],2):'');
					
					
					
				}
				
					
		$Columna++;
					
	 }		 	
			
	//OTROS
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'49', !empty($RcoPersonalOtros[$mes])?round($RcoPersonalOtros[$mes],2):'');
					
		}
		 	
		$Columna++;
					
	 }	
	 
	 //DIAS LABORADOS	
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
	
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'50', !empty($RcoDiasLaborados[$mes])?round($RcoDiasLaborados[$mes],2):'');
					 
		
			 
		 }
		 	
		$Columna++;
					
	 }			
					
  
  
	//HORAS TECNICO
	$Columna = 5;	
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'51',  !empty($RcoHoraDisponibles[$mes])?round($RcoHoraDisponibles[$mes],2):'');
						
			 
		 }
		 	
		$Columna++;
					
	 }	
	 
	 
	//HORAS LABORADAS TEC
	$Columna = 5;
	
	for($mes=1;$mes<=$POST_Mes;$mes++){
		 
		 if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			 
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'52', !empty($RcoHoraLaboradas[$mes])?round($RcoHoraLaboradas[$mes],2):'');
						
						
			 
		 }
		 	
		$Columna++;
					
	 }	
	 
	 
	 
	 
	  //TARIFA MO
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){

		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'56', !empty($RcoTarifaMO[$mes])?round($RcoTarifaMO[$mes],2):'');
			
			
		}
		
					
		$Columna++;
					
	 }	
	 
	 
	  //HORAS MO
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'57',!empty($RcoHoraMOVendidas[$mes])?round($RcoHoraMOVendidas[$mes],2):'');
				
		}
					
		$Columna++;
					
	 }	
	 
	  //VENTA MO
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){

		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
 		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'58', !empty($RcoVentaManoObra[$mes])?round($RcoVentaManoObra[$mes],2):'');
					
		}
		
		$Columna++;
					
	 }	
	 
	  //VENTA REPUESTOS
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){

		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
			
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'59', !empty($RcoVentaRepuestos[$mes])?$RcoVentaRepuestos[$mes]:'');
		
		}
		
		$Columna++;
					
	 }	
	 
	 	 
	  //TICKET PROMEDIO
	 $Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
				
				
			$TicketPromedio[$mes] = 0;
								if(!empty($RcoTotalIngresosUnidadesMantenimiento[$mes])){
								 
								$TicketPromedio[$mes] = ($RcoVentaManoObra[$mes] + $RcoVentaRepuestos[$mes])/$RcoTotalIngresosUnidadesMantenimiento[$mes];								
									
								}
								
								
							
			$objPHPExcel->setActiveSheetIndex(1)
						->setCellValue(FncConvertirNumeroALetraExcel($Columna).'60', !empty($TicketPromedio[$mes])?$TicketPromedio[$mes]:'');
		
		}
		
		$Columna++;
					
	}	
	 
	//VENTAS GARANTIA
	$Columna = 5;
	for($mes=1;$mes<=$POST_Mes;$mes++){
		
		if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
		
			$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue(FncConvertirNumeroALetraExcel($Columna).'61', !empty($RcoVentaGarantiaFA[$mes])?$RcoVentaGarantiaFA[$mes]:'');
						
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
        $objWriter->save("../../generados/reportes/COS_".$InsVehiculoMarca->VmaNombre."_".$SucursalNombreArchivo."_".$POST_Ano."_".$POST_Mes.".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/COS_".$InsVehiculoMarca->VmaNombre."_".$SucursalNombreArchivo."_".$POST_Ano."_".$POST_Mes.".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
	
																						
?>