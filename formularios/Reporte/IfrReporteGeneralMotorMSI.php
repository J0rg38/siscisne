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
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_MSI_".date('d-m-Y').".xls\";");
//}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        




$POST_Mes = empty($_POST['CmpMes'])?date("m"):$_POST['CmpMes'];
$POST_Ano = empty($_POST['CmpAno'])?date("Y"):$_POST['CmpAno'];
$POST_VehiculoMarca = $_POST['CmpVehiculoMarca'];

//deb($POST_Mes);
if(empty($POST_VehiculoMarca)){
die("No ha escogido una marca de vehiculo");
}

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');


$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaAccion = new ClsFichaAccion();
$InsFichaAccionProducto = new ClsFichaAccionProducto();
$InsPersonal = new ClsPersonal();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPersonal->PerId = "PER-10016";
$InsPersonal->MtdObtenerPersonal();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
		
		
		
if($_GET['P'] == 2){


        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
					// Set document properties
					$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
												 ->setLastModifiedBy("Maarten Balliauw")
												 ->setTitle("PHPExcel Test Document")
												 ->setSubject("PHPExcel Test Document")
												 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
												 ->setKeywords("office PHPExcel php")
												 ->setCategory("Test result file");
												 
												 
		switch($InsVehiculoMarca->VmaId){
				
			default:
				
				
					$objPHPExcel = $objReader->load("../../plantilla/TemMSIChevrolet.xls");

					  
					//ANO Y MES
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG3', FncConvertirMes($POST_Mes)." ".$POST_Ano);
								
					//DATOS DEL CONSECIONARIO
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E7', $EmpresaNombre);
								
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E8', $EmpresaDireccion);
								
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E9', $EmpresaDistrito);
								
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E10', $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno);
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E11', $InsPersonal->PtiNombre);
										
					
					
					
					
					
					
					//DATOS DE LA INSTALACION
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('X7', "3S");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('X8', "");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('X9', "800 M2");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('X10', "6");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('X11', "5");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('X12', "2");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('X13', "1");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('X14', "4");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('X15', "3");
								
					//DATOS DEL PERSONAL
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AI8', "1");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AI9', "2");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AI10', "1");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AI11', "");
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AI13', "1");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AI14', "4");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AI15', "1");
					
					
					
					
	
								
                    $FichaIngresoMantenimientoSumaTotal = 0;
                    $FichaIngresoMantenimiento50SumaTotal = 0;
                    $FichaIngresoReparacionSumaTotal = 0;
                    $FichaIngresoTotalInternoSumaTotal = 0;
                    $FichaIngresoTotalPlanchadoPintadoSumaTotal = 0;
                    $FichaIngresoTotalReingesoSumaTotal = 0;
					
					$CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano);
						
						foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
							
							$FichaIngresoMantenimientoDiarioTotal = 0;
							
							if($DatKilometro['km']=="1500"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
//
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
										
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'19', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="5000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'20', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}

							if($DatKilometro['km']=="10000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
					
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'21', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}

							if($DatKilometro['km']=="15000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
					
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'22', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="20000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'23', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;

								}
					
							}
							
							
							if($DatKilometro['km']=="25000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
					
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'24', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="30000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
					
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'25', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							
							if($DatKilometro['km']=="35000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'26', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							
							if($DatKilometro['km']=="40000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
					
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'27', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="45000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'28', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="50000"){
					
								$Columna = 6;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'29', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							
							
						}
						
						$FichaIngresoMantenimiento50TotalDiario = array();
						
					foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
							
								if($DatKilometro['km']>50000){
							
									for($i=1;$i<=$CantidadDias;$i++){
							
										$FichaIngresoMantenimiento50TotalDiario[$i] += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
							
									}
							
								}
							
					}
					
					
					
					//SERVICIOS>500000
					$Columna = 6;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$FichaIngresoMantenimiento50SumaTotal += $FichaIngresoMantenimiento50TotalDiario[$i];
						//$FichaIngresoMantenimiento50TotalDiario[$i];
						
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'30', !empty($FichaIngresoMantenimiento50TotalDiario[$i])?$FichaIngresoMantenimiento50TotalDiario[$i]:'');
						$Columna++;
					}
					
					//REPARACIONES
					$Columna = 6;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$FichaIngresoReparacionTotalDiario = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10003",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
						
						$FichaIngresoReparacionSumaTotal += $FichaIngresoReparacionTotalDiario;
						
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'31', !empty($FichaIngresoReparacionTotalDiario)?$FichaIngresoReparacionTotalDiario:'');
						$Columna++;
					}
					
					
					//TRABAJO INTERNO
					$Columna = 6;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$FichaIngresoTrabajoInternoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
						
						$FichaIngresoTrabajoInternoSumaTotal += $FichaIngresoTrabajoInternoDiarioTotal;
						
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'32', !empty($FichaIngresoTrabajoInternoDiarioTotal)?$FichaIngresoTrabajoInternoDiarioTotal:'');
						$Columna++;
					}
					
					
					
					
					//PLANCHADO Y PINTURA
					$Columna = 6;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$FichaIngresoPlanchadoPintadoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10002,MIN-10004",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
						
						$FichaIngresoPlanchadoPintadoSumaTotal += $FichaIngresoPlanchadoPintadoDiarioTotal;
						
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'33', !empty($FichaIngresoPlanchadoPintadoDiarioTotal)?$FichaIngresoPlanchadoPintadoDiarioTotal:'');
						$Columna++;
					}
					
					//REINGRESOS
					$Columna = 6;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'34', "");
						$Columna++;
					}
					
					
/*

MIN-10000	Garantia
MIN-10001	Mantenimiento
MIN-10002	Siniestro
MIN-10003	Reparacion
MIN-10004	Planchado y Pintado
MIN-10005	Configuracion e Instalacion
MIN-10006	Obsequio
MIN-10007	C&C Activos
MIN-10008	Campaña
MIN-10009	Accesorios e Instalacion
MIN-10010	Politica
MIN-10012	PDI/Faltante
MIN-10013	Inspeccion
MIN-10014	PDI/Planchado y Pintado
MIN-10015	PDS/Accesorios e Instalacion
MIN-10016	Reingreso
MIN-10017	Prueba Tecnica
MIN-10018	Trabajo Pendiente
*/					
					
					
					$Mantenimiento = $FichaIngresoMantenimientoSumaTotal + $FichaIngresoMantenimiento50SumaTotal;

                    $Reparacion = $FichaIngresoReparacionSumaTotal + $FichaIngresoTotalInternoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalReingesoSumaTotal;

                   // $TotalVIN = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011,LTI-10010,LTI-10017",$POST_VehiculoMarca) ;
				   
					$TotalVIN = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
					
					$TotalVIN = $Mantenimiento + $Reparacion;
					
					//CITAS DE SERVICIO
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F37', $Mantenimiento);	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F38', $Reparacion);	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F39', $TotalVIN);
								
					
					
					
					//$TipoVehiculoPasajero = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011",$POST_VehiculoMarca) ;
//                   
//                    $TipoVehiculoComercial = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10010,LTI-10017",$POST_VehiculoMarca) ;

$TipoVehiculoPasajero = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,NULL,"VTI-10006,VTI-10004,VTI-10001") ;
                    
                    $TipoVehiculoComercial = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,NULL,"VTI-10000,VTI-10002,VTI-10003,VTI-10005") ;
							
					//TIPOS DE VEHICULOS		
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('N37', $TipoVehiculoPasajero);	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('N38', $TipoVehiculoComercial);	
					
					
					

	
					$ManoObraTallerMecanica = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca);
                    
                    $ManoObraPlanchadoPintado = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,"MIN-10002,MIN-10004",$POST_VehiculoMarca);
					
					//VENTA MANO DE OBRA
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('W37', $ManoObraTallerMecanica);	
					$objPHPExcel->getActiveSheet()->getStyle('W37')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('W38', $ManoObraPlanchadoPintado);	
					$objPHPExcel->getActiveSheet()->getStyle('W38')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


					$VentaRepuestoTallerMecanica = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca,"RTI-10000");

                    $VentaRepuestoPlanchadoPintura = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10000");
					
					$VentaRepuestoAceite = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10001");
					
					$VentaRepuestoRefrigerante = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10002");
					
					
					
					//VENTA DE REPUESTOS
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG37', $VentaRepuestoTallerMecanica);	
					$objPHPExcel->getActiveSheet()->getStyle('AG37')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG38', $VentaRepuestoPlanchadoPintura);	
					$objPHPExcel->getActiveSheet()->getStyle('AG38')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG39', $VentaRepuestoAceite);	
					$objPHPExcel->getActiveSheet()->getStyle('AG39')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG40', $VentaRepuestoRefrigerante);	
					$objPHPExcel->getActiveSheet()->getStyle('AG40')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
								
					
					
					//ELABORADO POR
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AA42', $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno);
					//FECHA Y HORA
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AA43', date("d/m/Y H:i:s"));
								
								
					
			break;
			
			case "VMA-10018":
			
					$objPHPExcel = $objReader->load("../../plantilla/TemMSIIsuzu.xls");
				
				
					//ANO Y MES
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AH5', FncConvertirMes($POST_Mes)." ".$POST_Ano);
								
					//DATOS DEL CONSECIONARIO
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F9', $EmpresaNombre);
								
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F10', $EmpresaDireccion);
								
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F11', $EmpresaDistrito);
								
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F12', $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno);
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F13', $InsPersonal->PtiNombre);
										
					
					//DATOS DE LA INSTALACION
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('Y9', "3S");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('Y10', "");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('Y11', "800 M2");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('Y12', "6");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('Y13', "5");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('Y14', "2");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('Y15', "1");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('Y16', "4");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('Y17', "3");
								
					//DATOS DEL PERSONAL
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AJ10', "1");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AJ11', "2");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AJ12', "1");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AJ13', "");
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AJ15', "1");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AJ16', "4");
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AJ17', "1");
					


                   


                    $FichaIngresoMantenimientoSumaTotal = 0;
                    $FichaIngresoMantenimiento50SumaTotal = 0;
                    $FichaIngresoReparacionSumaTotal = 0;
                    $FichaIngresoTotalInternoSumaTotal = 0;
                    $FichaIngresoTotalPlanchadoPintadoSumaTotal = 0;
                    $FichaIngresoTotalReingesoSumaTotal = 0;
					
					$CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano);
					

						
						foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
							
							if($DatKilometro['km']=="1000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'21', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							
							if($DatKilometro['km']=="5000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'22', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="10000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'23', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="15000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'24', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="20000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'25', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							
							if($DatKilometro['km']=="25000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'26', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="30000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'27', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							
							if($DatKilometro['km']=="35000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'28', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							
							if($DatKilometro['km']=="40000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'29', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="45000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'30', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							if($DatKilometro['km']=="50000"){
					
								$Columna = 7;
								for($i=1;$i<=$CantidadDias;$i++){
					
									$FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
									
									$FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal;
									
									$objPHPExcel->setActiveSheetIndex(0)
											->setCellValue(FncConvertirNumeroALetraExcel($Columna).'31', !empty($FichaIngresoMantenimientoDiarioTotal)?$FichaIngresoMantenimientoDiarioTotal:'');
									$Columna++;
								}
					
							}
							
							
							
						}
						
						
						
					
					$FichaIngresoMantenimiento50TotalDiario = array();
							foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
							
								
							
								if($DatKilometro['km']>50000){
							
									for($i=1;$i<=$CantidadDias;$i++){
							
										$FichaIngresoMantenimiento50TotalDiario[$i] += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
							
									}
							
								}
							
							}
							
				
					
					
					//SERVICIOS>500000
					$Columna = 7;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$FichaIngresoMantenimiento50SumaTotal += $FichaIngresoMantenimiento50TotalDiario[$i];
						//$FichaIngresoMantenimiento50TotalDiario[$i];
						
						//$FichaIngresoMantenimiento50SumaTotal += $FichaIngresoMantenimiento50TotalDiario[$i];
						
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'32', !empty($FichaIngresoMantenimiento50TotalDiario[$i])?$FichaIngresoMantenimiento50TotalDiario[$i]:'');
						$Columna++;
					}
					
					//REPARACIONES
					$Columna = 7;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$FichaIngresoReparacionTotalDiario = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10003",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
					
						$FichaIngresoReparacionSumaTotal += $FichaIngresoReparacionTotalDiario;
						
						$objPHPExcel->setActiveSheetIndex(0)	
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'33', !empty($FichaIngresoReparacionTotalDiario)?$FichaIngresoReparacionTotalDiario:'');
						$Columna++;
					}
					
					
					//TRABAJO INTERNO
					$Columna = 7;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$FichaIngresoTrabajoInternoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
						
						$FichaIngresoTrabajoInternoSumaTotal += $FichaIngresoTrabajoInternoDiarioTotal;
						
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'34', !empty($FichaIngresoTrabajoInternoDiarioTotal)?$FichaIngresoTrabajoInternoDiarioTotal:'');
						$Columna++;
					}
					
					
					
					
					//PLANCHADO Y PINTURA
					$Columna = 7;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$FichaIngresoPlanchadoPintadoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10002,MIN-10004",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
						
						$FichaIngresoPlanchadoPintadoSumaTotal += $FichaIngresoPlanchadoPintadoDiarioTotal;
						
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'35', !empty($FichaIngresoPlanchadoPintadoDiarioTotal)?$FichaIngresoPlanchadoPintadoDiarioTotal:'');
						$Columna++;
					}
					
					//REINGRESOS
					$Columna = 7;
					for($i=1;$i<=$CantidadDias;$i++){
					
						$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel($Columna).'36', "");
						$Columna++;
					}
					
					
					
					
					
					
					
					
					
					$Mantenimiento = $FichaIngresoMantenimientoSumaTotal + $FichaIngresoMantenimiento50SumaTotal;
	
                    $Reparacion = $FichaIngresoReparacionSumaTotal + $FichaIngresoTotalInternoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalReingesoSumaTotal;
					
					
					//$TotalVIN = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011,LTI-10010,LTI-10017",$POST_VehiculoMarca) ;
                    $TotalVIN = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;

					$TotalVIN = $Mantenimiento + $Reparacion;
					
					
					//CITAS DE SERVICIO
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G39', $Mantenimiento);	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G40', $Reparacion);	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G41', $TotalVIN);		
								
								

                   // $TipoVehiculoPasajero = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011",$POST_VehiculoMarca) ;
//                   
//                    $TipoVehiculoComercial = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10010,LTI-10017",$POST_VehiculoMarca) ;
                    
                    $TipoVehiculoPasajero = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,NULL,"VTI-10006,VTI-10004,VTI-10001") ;
                    
                    $TipoVehiculoComercial = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,NULL,"VTI-10000,VTI-10002,VTI-10003,VTI-10005") ;
													
					//TIPOS DE VEHICULOS		
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('N39', $TipoVehiculoPasajero);	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('N40', $TipoVehiculoComercial);	
					
					
					
					
					$ManoObraTallerMecanica = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca);
                    
                    $ManoObraPlanchadoPintado = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,"MIN-10002,MIN-10004",$POST_VehiculoMarca);
					
						

					//MANO OBRA
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('W39', $ManoObraTallerMecanica);	
					$objPHPExcel->getActiveSheet()->getStyle('W39')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('W40', $ManoObraPlanchadoPintado);	
					$objPHPExcel->getActiveSheet()->getStyle('W40')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					
					
					
					$VentaRepuestoTallerMecanica = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca,"RTI-10000");

                    $VentaRepuestoPlanchadoPintura = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10000");				
						
					$VentaRepuestoAceite = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10001");
					
					$VentaRepuestoRefrigerante = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10002");
					
							
					//VENTA DE REPUESTOS	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG39', $VentaRepuestoTallerMecanica);	
					$objPHPExcel->getActiveSheet()->getStyle('AG39')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG40', $VentaRepuestoPlanchadoPintura);	
					$objPHPExcel->getActiveSheet()->getStyle('AG40')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG41', $VentaRepuestoAceite);	
					$objPHPExcel->getActiveSheet()->getStyle('AG41')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AG42', $VentaRepuestoRefrigerante);	
					$objPHPExcel->getActiveSheet()->getStyle('AG42')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);			
								
								
								
					//ELABORADO POR
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AC44', $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno);
					//FECHA Y HORA
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('AC45', date("d/m/Y H:i:s"));	
								
					
					
					
			break;
		
		}
       
        

        
        
        
                
        
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('MSI - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
					
					

}else{
?>


        <html>
        <head>
       
        <link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
        <script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

        </head>
        <body>

        <script type="text/javascript">
        
        $().ready(function() {
        <?php if($_GET['P']==1){?> 
            setTimeout("window.close();",2500);	
            window.print(); 
        
        <?php }?>
        });
        
        </script>

        <?php if($_GET['P']==1){?>
        <table cellpadding="0" cellspacing="0" width="100%" border="0">
        <tr>
          <td colspan="4" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
        </tr>
        <tr>
          <td width="23%" rowspan="2" align="left" valign="top"><?php
                if(!empty($InsVehiculoMarca->VmaFoto)){
                ?>
            <img src="../../subidos/vehiculo_marca/<?php echo $InsVehiculoMarca->VmaFoto;?>" width="271" height="92" />
            <?php
                }else{
                ?>
        -
        <?php	
                }
                ?></td>
          <td width="54%" rowspan="2" align="center" valign="top">INDICADORES MAYORES DE SERVICIO [MSI]&#13;<br>
        Entregable mensual para la Gerencia de Distrito de Posventa</td>
          <td width="23%" rowspan="2" align="right" valign="top">FORM<br>
        MRI1</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        <tr>
          <td align="right" valign="top">Mes y a&ntilde;o: <?php echo FncConvertirMes($POST_Mes);?> <?php echo $POST_Ano;?></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
			<?php
            switch($InsVehiculoMarca->VmaId){
                default:
            ?>
                     
                    <table class="EstTablaReporte" width="100%">
                    <tr>
                      <td width="27%" align="center" valign="top">
                        
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">1. Datos del concesionario</span></td>
                              </tr>
                            <tr>
                              <td width="95">Nombre:</td>
                              <td width="140">&nbsp;<?php echo $EmpresaNombre;?></td>
                              </tr>
                            <tr>
                              <td>Ubicación:</td>
                              <td>&nbsp;<?php echo $EmpresaDireccion;?></td>
                              </tr>
                            <tr>
                              <td>Distrito:</td>
                              <td>&nbsp;<?php echo $EmpresaDistrito;?></td>
                              </tr>
                            <tr>
                              <td>Responsable:</td>
                              <td>&nbsp;<?php echo $InsPersonal->PerNombre ?> <?php echo $InsPersonal->PerApellidoPaterno ?> <?php echo $InsPersonal->PerApellidoMaterno ?></td>
                              </tr>
                            <tr>
                              <td>Cargo:</td>
                              <td>&nbsp;<?php echo $InsPersonal->PtiNombre ?></td>
                              </tr>
                            <tr>
                              <td>Firma:</td>
                              <td>&nbsp;
                                
                                <?php
                        if(!empty($InsPersonal->PerFirma)){
                        ?>
                                <img src="../../subidos/personal_firmas/<?php echo $InsPersonal->PerFirma;?>" alt="[-]" />    
                                <?php	
                        }	
                        ?>
                                
                                
                                
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        
                        </td>
                      <td width="27%" align="center" valign="top">
                        
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">2. Datos de la instalación</span></td>
                              </tr>
                            <tr>
                              <td width="176">Tipo de    local (2S/3S):</td>
                              <td width="112">3S</td>
                              </tr>
                            <tr>
                              <td>Inicio de    operación:</td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td>Area total de    servicio (m2):</td>
                              <td>800 M2</td>
                              </tr>
                            <tr>
                              <td>Puestos de    mantenimiento:</td>
                              <td>6</td>
                              </tr>
                            <tr>
                              <td>Elevadores    disponibles:</td>
                              <td>5</td>
                              </tr>
                            <tr>
                              <td>Puestos de    reparación:</td>
                              <td>2</td>
                              </tr>
                            <tr>
                              <td>Puestos de    lavado/secado:</td>
                              <td>1</td>
                              </tr>
                            <tr>
                              <td>Estacionamientos    de clientes:</td>
                              <td>4</td>
                              </tr>
                            <tr>
                              <td>Estacionamientos    internos:</td>
                              <td>3</td>
                              </tr>
                            </tbody>
                        </table></td>
                      <td colspan="2" align="center" valign="top">
                        
                        
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">3. Datos del personal</span></td>
                              </tr>
                            <tr>
                              <td colspan="2"> <span class="EstTablaReporteSubtitulo2">Personal de operaciones</span></td>
                              </tr>
                            <tr>
                              <td width="167">Gestor del    área:</td>
                              <td width="41">1</td>
                              </tr>
                            <tr>
                              <td>Asesores de    servicio:</td>
                              <td>2</td>
                              </tr>
                            <tr>
                              <td>Asistentes    administrativos:</td>
                              <td>1</td>
                              </tr>
                            <tr>
                              <td>Otros</td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td colspan="2"> <span class="EstTablaReporteSubtitulo2">Personal técnico</span></td>
                              </tr>
                            <tr>
                              <td width="167">Jefe de    taller:</td>
                              <td>1</td>
                              </tr>
                            <tr>
                              <td>Técnicos:</td>
                              <td>4</td>
                              </tr>
                            <tr>
                              <td>Otros:</td>
                              <td>1</td>
                              </tr>
                            </tbody>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="4">
                      
                      
                    <?php
                    $CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano); // 31
                    ?>
                    
                    <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th>
                    Categoria/Dia
                    </th>
                    <?php
                    for($i=1;$i<=$CantidadDias;$i++){
                    ?>
                    <th align="center"><?php echo $i;?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                    
                    <?php
                    //$FichaIngresoMantenimientoTotalMensual = 0;
                    //$FichaIngresoMantenimiento50TotalMensual = 0;
                    //$FichaIngresoReparacionTotalMensual = 0;
                    //$FichaIngresoTotalInternoMensual = 0;
                    //$FichaIngresoTotalPlanchadoPintadoMensual = 0;
                    //$FichaIngresoTotalReingesoMensual = 0;
                    $FichaIngresoMantenimientoSumaTotal = 0;
                    $FichaIngresoMantenimiento50SumaTotal = 0;
                    $FichaIngresoReparacionSumaTotal = 0;
                    $FichaIngresoTotalInternoSumaTotal = 0;
                    $FichaIngresoTotalPlanchadoPintadoSumaTotal = 0;
                    $FichaIngresoTotalReingesoSumaTotal = 0;
                    
                    ?>
                    <tbody class="EstTablaReporteBody">
                    <?php
                    $c = 1;
                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                        <?php
                        if($DatKilometro['km']<=50000){
                        ?>
                        <tr>
                            <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                                Servicio <?php echo $DatKilometro['km'];?>
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                    
                                <?php
                                $FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
                                ?>
                                <?php $FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal ?>
                                
                                <?php
                                if(!empty($FichaIngresoMantenimientoDiarioTotal)){
                                ?>
                                
                                <?php echo $FichaIngresoMantenimientoDiarioTotal;?>
                                
                                <?php
                                }
                                ?>
                              
                  </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        <?php
                        }
                        ?>
                    <?php	
                    $c++;
                    }
                    ?>
                    
                    
                     <?php
                        $FichaIngresoMantenimiento50TotalDiario = array();
                        ?>
                    <?php
                    foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                       
                        <?php
                        if($DatKilometro['km']>50000){
                        ?>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                            
                                <?php
                                $FichaIngresoMantenimiento50TotalDiario[$i] += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
                                ?>
                                
                             <?php
                            }
                            ?> 
                              
                        <?php
                        }
                        ?>
                     <?php	
                    }
                    ?>
                       
                        <tr>
                            <td class="EstTablaReporteColumnaEspecial1">
                                Servicio >50000
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial1">
                                
                          
                                <?php $FichaIngresoMantenimiento50SumaTotal += $FichaIngresoMantenimiento50TotalDiario[$i] ?>
                                
            
                                <?php
                                if(!empty($FichaIngresoMantenimiento50TotalDiario[$i])){
                                ?>
                                    <?php echo $FichaIngresoMantenimiento50TotalDiario[$i];?>
                                <?php
                                }
                                ?>
                                
                                
                  </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                    
                    
                    
                        <tr>
                            <td class="EstTablaReporteColumnaEspecial2">
                                Reparaciones
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial2">
                                
                                <?php
                                $FichaIngresoReparacionTotalDiario = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10003",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
                                ?>
                    
                                <?php $FichaIngresoReparacionSumaTotal += $FichaIngresoReparacionTotalDiario ?>
            
                                <?php
                                if(!empty($FichaIngresoReparacionTotalDiario)){
                                ?>
                                    <?php echo $FichaIngresoReparacionTotalDiario;?>
                                <?php
                                }
                                ?>
                                
                  </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                       
                       
                       
                        <tr>
                            <td class="EstTablaReporteColumnaEspecial3">
                                Trabajo Interno
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial3">
                                
                                
                                 <?php
                    
                                $FichaIngresoTrabajoInternoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
                                ?>
                                <?php $FichaIngresoTrabajoInternoSumaTotal += $FichaIngresoTrabajoInternoDiarioTotal ?>
            
                                
                                <?php
                                if(!empty($FichaIngresoTrabajoInternoDiarioTotal)){
                                ?>
                                 <?php echo $FichaIngresoTrabajoInternoDiarioTotal;?>                    
                                <?php
                                }
                                ?> 
                                
                  </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                        
                            <tr>
                            <td class="EstTablaReporteColumnaEspecial4">
                                Planchado y Pintura
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial4">
                    
                                <?php
                                $FichaIngresoPlanchadoPintadoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10002,MIN-10004",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
                                ?>
                                
                                <?php $FichaIngresoPlanchadoPintadoSumaTotal += $FichaIngresoPlanchadoPintadoDiarioTotal ?>
                                
                                <?php
                                if(!empty($FichaIngresoPlanchadoPintadoDiarioTotal)){
                                ?>
                                <?php echo $FichaIngresoPlanchadoPintadoDiarioTotal;?>
                                <?php
                                }
                                ?>
                                
                    
                              </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                              <tr>
                            <td class="EstTablaReporteColumnaEspecial5">
                               Reingresos
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial5">&nbsp;</td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                       
                    
                    </tbody>
                    </table>
                    
                    
                    
                    
                      </td>
                    </tr>
                    <tr>
                      <td align="center" valign="top">
                      
                    <?php
					
					
                    $Mantenimiento = $FichaIngresoMantenimientoSumaTotal + $FichaIngresoMantenimiento50SumaTotal;
                    ?>  
                    
                    <?php
                    $Reparacion = $FichaIngresoReparacionSumaTotal + $FichaIngresoTotalInternoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalReingesoSumaTotal;
                    ?>
                    
                    <?php
                    //$TotalVIN = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011,LTI-10010,LTI-10017",$POST_VehiculoMarca) ;
					$TotalVIN = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
					
					$TotalVIN = $Mantenimiento + $Reparacion;
                    ?> 
                    
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                        <tbody class="EstTablaReporteBody">
                          <tr>
                            <td colspan="2"><span class="EstTablaReporteSubtitulo">5. Citas de servicio</span></td>
                          </tr>
                          <tr>
                            <td width="167">Mantenimiento:</td>
                            <td width="41">
                    
                            
                            <?php echo $Mantenimiento;?>
                            </td>
                          </tr>
                          <tr>
                            <td>Reparaci&oacute;n:</td>
                            <td>
                    
                            
                            <?php echo $Reparacion;?>       
                            
                            </td>
                          </tr>
                          <tr>
                            <td>Total VIN:</td>
                            <td><?php echo $TotalVIN;?></td>
                          </tr>
                        </tbody>
                      </table></td>
                      <td align="center" valign="top">
                      
                    <?php
               /*     $TipoVehiculoPasajero = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011",$POST_VehiculoMarca) ;
                    ?>
                    
                    
                    <?php
                    $TipoVehiculoComercial = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10010,LTI-10017",$POST_VehiculoMarca) ;*/
                    ?>
                    
                    
                    <?php

/*

VTI-10000	AUTOS Y
VTI-10001	FAMILIARES x
VTI-10002	SUV Y 
VTI-10003	CAMIONETAS Y 
VTI-10004	VAN x
VTI-10005	CAMION
VTI-10006	OMNIBUS x

*/

//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL)
$TipoVehiculoPasajero = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,NULL,"VTI-10006,VTI-10004,VTI-10001") ;
?>

<?php
$TipoVehiculoComercial = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,NULL,"VTI-10000,VTI-10002,VTI-10003,VTI-10005") ;
?>
                      
                      <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                        <tbody class="EstTablaReporteBody">
                          <tr>
                            <td colspan="2"><span class="EstTablaReporteSubtitulo">6. Tipo de vehículos</span></td>
                          </tr>
                          <tr>
                            <td width="167">Pasajeros:</td>
                            <td width="41">
                            <?php echo $TipoVehiculoPasajero;?>
                            </td>
                          </tr>
                          <tr>
                            <td>Comercial:</td>
                            <td><?php echo $TipoVehiculoComercial;?></td>
                          </tr>
                          </tbody>
                      </table>
                      
                      
                      
                      </td>
                      <td width="22%" align="center" valign="top">
                      
                    <?php
                    
                    $ManoObraTallerMecanica = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca);
                    
                    $ManoObraPlanchadoPintado = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,"MIN-10002,MIN-10004",$POST_VehiculoMarca);
                    
                    ?>
                      <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                        <tbody class="EstTablaReporteBody">
                          <tr>
                            <td colspan="2"><span class="EstTablaReporteSubtitulo">7. Venta mano de obra (Soles inc. IGV) (*)</span></td>
                          </tr>
                          <tr>
                            <td width="167">Taller de Mecánica:</td>
                            <td width="41"><?php echo number_format($ManoObraTallerMecanica,2);?></td>
                          </tr>
                          <tr>
                            <td>Planchado y pintura:</td>
                            <td><?php echo number_format($ManoObraPlanchadoPintado,2);?></td>
                          </tr>
                          </tbody>
                      </table></td>
                      <td width="24%" align="center" valign="top">
                      
                    <?php
                    $VentaRepuestoTallerMecanica = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca,"RTI-10000");
                    
                    $VentaRepuestoPlanchadoPintura = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10000");
					
					$VentaRepuestoAceite = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10001");
					
					$VentaRepuestoRefrigerante = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10002");
					
					
                    ?>
                    
                      <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                        <tbody class="EstTablaReporteBody">
                          <tr>
                            <td colspan="2"><span class="EstTablaReporteSubtitulo">8. Venta de repuestos (Soles inc. IGV) (**)</span></td>
                          </tr>
                          <tr>
                            <td width="167">Taller de mecánica:</td>
                            <td width="41">
                            <?php echo number_format($VentaRepuestoTallerMecanica,2);?>
                            </td>
                          </tr>
                          <tr>
                            <td>Planchado y pintura:</td>
                            <td><?php echo number_format($VentaRepuestoPlanchadoPintura,2);?></td>
                          </tr>
                          <tr>
                            <td>Aceites:</td>
                            <td><?php echo number_format($VentaRepuestoAceite,2);?></td>
                          </tr>
                          <tr>
                            <td>Refrigerantes:</td>
                            <td><?php echo number_format($VentaRepuestoRefrigerante,2);?></td>
                          </tr>
                          </tbody>
                      </table></td>
                      </tr>
                    <tr>
                      <td colspan="4">
                      
                      <p>(*) Mano de Obra por Mantenimientos, Reparaciones, Trabajos Internos, Planchado y Pintado y Reingresos<br>
                      (**) Repuestos por Mantenimientos, Reparaciones, Trabajos Internos, Planchado y Pintado y Reingresos</p></td>
                      </tr>
                    <tr>
                    <td>
                    
                    
                    </td>
                    <td></td>
                    <td colspan="2"></td>
                    </tr>
                    </table>
                    
            <?php
                break;
                
                case "VMA-10018":
            ?>
                     
                    <table class="EstTablaReporte" width="100%">
                    <tr>
                      <td width="27%" align="center" valign="top">
                        
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">1. Datos del concesionario</span></td>
                              </tr>
                            <tr>
                              <td width="95">Nombre:</td>
                              <td width="140">&nbsp;<?php echo $EmpresaNombre;?></td>
                              </tr>
                            <tr>
                              <td>Ubicación:</td>
                              <td>&nbsp;<?php echo $EmpresaDireccion;?></td>
                              </tr>
                            <tr>
                              <td>Distrito:</td>
                              <td>&nbsp;<?php echo $EmpresaDistrito;?></td>
                              </tr>
                            <tr>
                              <td>Responsable:</td>
                              <td>&nbsp;<?php echo $InsPersonal->PerNombre ?> <?php echo $InsPersonal->PerApellidoPaterno ?> <?php echo $InsPersonal->PerApellidoMaterno ?></td>
                              </tr>
                            <tr>
                              <td>Cargo:</td>
                              <td>&nbsp;<?php echo $InsPersonal->PtiNombre ?></td>
                              </tr>
                            <tr>
                              <td>Firma:</td>
                              <td>&nbsp;
                                
                                <?php
                        if(!empty($InsPersonal->PerFirma)){
                        ?>
                                <img src="../../subidos/personal_firmas/<?php echo $InsPersonal->PerFirma;?>" alt="[-]" />    
                                <?php	
                        }	
                        ?>
                                
                                
                                
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        
                        </td>
                      <td width="27%" align="center" valign="top">
                        
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">2. Datos de la instalación</span></td>
                              </tr>
                            <tr>
                              <td width="176">Tipo de    local (2S/3S):</td>
                              <td width="112">3S</td>
                              </tr>
                            <tr>
                              <td>Inicio de    operación:</td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td>Area total de    servicio (m2):</td>
                              <td>800 M2</td>
                              </tr>
                            <tr>
                              <td>Puestos de    mantenimiento:</td>
                              <td>6</td>
                              </tr>
                            <tr>
                              <td>Elevadores    disponibles:</td>
                              <td>5</td>
                              </tr>
                            <tr>
                              <td>Puestos de    reparación:</td>
                              <td>2</td>
                              </tr>
                            <tr>
                              <td>Puestos de    lavado/secado:</td>
                              <td>1</td>
                              </tr>
                            <tr>
                              <td>Estacionamientos    de clientes:</td>
                              <td>4</td>
                              </tr>
                            <tr>
                              <td>Estacionamientos    internos:</td>
                              <td>3</td>
                              </tr>
                            </tbody>
                        </table></td>
                      <td colspan="2" align="center" valign="top">
                        
                        
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">3. Datos del personal</span></td>
                              </tr>
                            <tr>
                              <td colspan="2"> <span class="EstTablaReporteSubtitulo2">Personal de operaciones</span></td>
                              </tr>
                            <tr>
                              <td width="167">Gestor del    área:</td>
                              <td width="41">1</td>
                              </tr>
                            <tr>
                              <td>Asesores de    servicio:</td>
                              <td>2</td>
                              </tr>
                            <tr>
                              <td>Asistentes    administrativos:</td>
                              <td>1</td>
                              </tr>
                            <tr>
                              <td>Otros</td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td colspan="2"> <span class="EstTablaReporteSubtitulo2">Personal técnico</span></td>
                              </tr>
                            <tr>
                              <td width="167">Jefe de    taller:</td>
                              <td>1</td>
                              </tr>
                            <tr>
                              <td>Técnicos:</td>
                              <td>4</td>
                              </tr>
                            <tr>
                              <td>Otros:</td>
                              <td>1</td>
                              </tr>
                            </tbody>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="4">
                      
                      
                    <?php
                    $CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano); // 31
                    ?>
                    
                    <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th>
                    Categoria/Dia
                    </th>
                    <?php
                    for($i=1;$i<=$CantidadDias;$i++){
                    ?>
                    <th align="center"><?php echo $i;?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                    
                    <?php
                    //$FichaIngresoMantenimientoTotalMensual = 0;
                    //$FichaIngresoMantenimiento50TotalMensual = 0;
                    //$FichaIngresoReparacionTotalMensual = 0;
                    //$FichaIngresoTotalInternoMensual = 0;
                    //$FichaIngresoTotalPlanchadoPintadoMensual = 0;
                    //$FichaIngresoTotalReingesoMensual = 0;
                    $FichaIngresoMantenimientoSumaTotal = 0;
                    $FichaIngresoMantenimiento50SumaTotal = 0;
                    $FichaIngresoReparacionSumaTotal = 0;
                    $FichaIngresoTotalInternoSumaTotal = 0;
                    $FichaIngresoTotalPlanchadoPintadoSumaTotal = 0;
                    $FichaIngresoTotalReingesoSumaTotal = 0;
                    
                    ?>
                    <tbody class="EstTablaReporteBody">
                    <?php
                    $c = 1;
                    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                        <?php
                        if($DatKilometro['km']<=50000){
                        ?>
                        <tr>
                            <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                                Servicio <?php echo $DatKilometro['km'];?>
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">
                    
                                <?php
                                $FichaIngresoMantenimientoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
                                ?>
                                <?php $FichaIngresoMantenimientoSumaTotal += $FichaIngresoMantenimientoDiarioTotal ?>
                                
                                <?php
                                if(!empty($FichaIngresoMantenimientoDiarioTotal)){
                                ?>
                                    <?php echo $FichaIngresoMantenimientoDiarioTotal;?>                    
                                <?php	
                                }
                                ?>
            
                    
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        <?php
                        }
                        ?>
                    <?php	
                    $c++;
                    }
                    ?>
                    
                    
                    
                 
                       
                        <tr>
                            <td class="EstTablaReporteColumnaEspecial1">
                                Servicio >50000
                                

  					<?php
					
					$FichaIngresoMantenimiento50TotalDiario = array();
					
                    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
                    ?>
                        <?php
                       
                        ?>
                        <?php
                        if($DatKilometro['km']>50000){
                        ?>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                            
                                <?php
                                $FichaIngresoMantenimiento50TotalDiario[$i] += $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,"FinMantenimientoKilometraje","esigual",$DatKilometro['km'],'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10001",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
								
                               	
								?>
                                
                               
                             <?php
                            }
                            ?> 
                              
                        <?php
                        }
                        ?>
                     <?php	
                    }
                    ?>
                    
                    <?php
			//		deb( $FichaIngresoMantenimiento50TotalDiario);
					?>
                    
                            </td>
                            
                            
                            
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial1">
                               
 <?php $FichaIngresoMantenimiento50SumaTotal += $FichaIngresoMantenimiento50TotalDiario[$i] ?>
                                
 
<?php
if(!empty($FichaIngresoMantenimiento50TotalDiario[$i])){
?>
	<?php echo $FichaIngresoMantenimiento50TotalDiario[$i];?>
<?php
}
?>               
                                </td>
                            <?php	
                            }
                            ?>
                            
                            
                            
                            
                        </tr>
                    
                    
                    
                        <tr>
                            <td class="EstTablaReporteColumnaEspecial2">
                                Reparaciones
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial2">
                                
                                <?php
                                $FichaIngresoReparacionTotalDiario = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10003",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
                                ?>
                    
                                <?php $FichaIngresoReparacionSumaTotal += $FichaIngresoReparacionTotalDiario ?>
                                
                                <?php
                                if(!empty($FichaIngresoReparacionTotalDiario)){
                                ?>
                                    <?php echo $FichaIngresoReparacionTotalDiario;?>
                                <?php
                                }
                                ?>
                                
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                       
                       
                       
                        <tr>
                            <td class="EstTablaReporteColumnaEspecial3">
                                Trabajo Interno
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial3">
                                
                                
                                 <?php
                    
                                $FichaIngresoTrabajoInternoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
                                ?>
                                <?php $FichaIngresoTrabajoInternoSumaTotal += $FichaIngresoTrabajoInternoDiarioTotal ?>
                                
                                
                                <?php
                                if(!empty($FichaIngresoTrabajoInternoDiarioTotal)){
                                ?>
                                    <?php echo $FichaIngresoTrabajoInternoDiarioTotal;?>
                                <?php
                                }
                                ?>
                                
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                        
                            <tr>
                            <td class="EstTablaReporteColumnaEspecial4">
                                Planchado y Pintura
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial4">
                    
                                <?php
                                $FichaIngresoPlanchadoPintadoDiarioTotal = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-".$i,$POST_Ano."-".$POST_Mes."-".$i,NULL,NULL,"MIN-10002,MIN-10004",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
                                ?>
                                
                                <?php $FichaIngresoPlanchadoPintadoSumaTotal += $FichaIngresoPlanchadoPintadoDiarioTotal ?>
            
                                <?php
                                if(!empty($FichaIngresoPlanchadoPintadoDiarioTotal)){
                                ?>
                                 <?php echo $FichaIngresoPlanchadoPintadoDiarioTotal;?>
                                <?php
                                }
                                ?>
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                              <tr>
                            <td class="EstTablaReporteColumnaEspecial5">
                               Reingresos
                            </td>
                            <?php
                            for($i=1;$i<=$CantidadDias;$i++){
                            ?>
                                <td align="center" class="EstTablaReporteColumnaEspecial5">&nbsp;</td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                       
                    
                    </tbody>
                    </table>
                    
                    
                    
                    
                      </td>
                    </tr>
                    <tr>
                      <td align="center" valign="top">
            
                    <?php
					
					//deb($FichaIngresoMantenimientoSumaTotal." - ".$FichaIngresoMantenimiento50SumaTotal);
					
                    $Mantenimiento = $FichaIngresoMantenimientoSumaTotal + $FichaIngresoMantenimiento50SumaTotal;
                    ?>  
            
                    <?php
                    $Reparacion = $FichaIngresoReparacionSumaTotal + $FichaIngresoTotalInternoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalPlanchadoPintadoSumaTotal + $FichaIngresoTotalReingesoSumaTotal;
                    ?>
            
                    <?php
                    //$TotalVIN = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,"LTI-10011,LTI-10010,LTI-10017",$POST_VehiculoMarca) ;
					$TotalVIN = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca) ;
					
					$TotalVIN = $Mantenimiento + $Reparacion;
                    ?> 
                    
                    
       
                    
                    
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                        <tbody class="EstTablaReporteBody">
                          <tr>
                            <td colspan="2"><span class="EstTablaReporteSubtitulo">5. Citas de servicio</span></td>
                          </tr>
                          <tr>
                            <td width="167">Mantenimiento:</td>
                            <td width="41">
                    
                            
                            <?php echo $Mantenimiento;?>
                            </td>
                          </tr>
                          <tr>
                            <td>Reparaci&oacute;n:</td>
                            <td>
                    
                            
                            <?php echo $Reparacion;?>       
                            
                            </td>
                          </tr>
                          <tr>
                            <td>Total VIN:</td>
                            <td><?php echo $TotalVIN;?></td>
                          </tr>
                        </tbody>
                      </table></td>
                      <td align="center" valign="top">
                      
<?php

/*

VTI-10000	AUTOS Y
VTI-10001	FAMILIARES x
VTI-10002	SUV Y 
VTI-10003	CAMIONETAS Y 
VTI-10004	VAN x
VTI-10005	CAMION
VTI-10006	OMNIBUS x

*/

//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL)
$TipoVehiculoPasajero = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,NULL,"VTI-10006,VTI-10004,VTI-10001") ;
?>

<?php
$TipoVehiculoComercial = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$POST_Ano."-".$POST_Mes."-1",$POST_Ano."-".$POST_Mes."-".$CantidadDias,NULL,NULL,"MIN-10002,MIN-10004,MIN-10001,MIN-10003,MIN-10007",NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoMarca,NULL,"VTI-10000,VTI-10002,VTI-10003,VTI-10005") ;
?>
                      
                      <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                        <tbody class="EstTablaReporteBody">
                          <tr>
                            <td colspan="2"><span class="EstTablaReporteSubtitulo">6. Tipo de vehículos</span></td>
                          </tr>
                          <tr>
                            <td width="167">Pasajeros:</td>
                            <td width="41">
                            <?php echo $TipoVehiculoPasajero;?>
                            </td>
                          </tr>
                          <tr>
                            <td>Comercial:</td>
                            <td><?php echo $TipoVehiculoComercial;?></td>
                          </tr>
                          </tbody>
                      </table>
                      
                      
                      
                      </td>
                      <td width="12%" align="center" valign="top">
					  
				<?php
                    $ManoObraTallerMecanica = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca);
                    
                    $ManoObraPlanchadoPintado = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,"MIN-10002,MIN-10004",$POST_VehiculoMarca);
                    
                    ?>
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">7. Venta mano de obra (Soles inc. IGV) (*)</span></td>
                            </tr>
                            <tr>
                              <td width="167">Taller de Mecánica:</td>
                              <td width="41"><?php echo number_format($ManoObraTallerMecanica,2);?></td>
                            </tr>
                            <tr>
                              <td>Planchado y pintura:</td>
                              <td><?php echo number_format($ManoObraPlanchadoPintado,2);?></td>
                            </tr>
                          </tbody>
                      </table></td>
                      <td width="12%" align="center" valign="top"><?php
                    $VentaRepuestoTallerMecanica = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007",$POST_VehiculoMarca,"RTI-10000");
                    
                    $VentaRepuestoPlanchadoPintura = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10000");
					
					$VentaRepuestoAceite = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10001");
					
					$VentaRepuestoRefrigerante = $InsFichaAccionProducto->MtdObtenerFichaAccionProductosTotal("SUM","amd.AmdImporte",$POST_Mes,$POST_Ano,	NULL,NULL,'fap.FapId','ASC',NULL,NULL,NULL,NULL,1,NULL,"MIN-10001,MIN-10003,MIN-10007,MIN-10002,MIN-10004",$POST_VehiculoMarca,"RTI-10002");

                    ?>
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">8. Venta de repuestos (Soles inc. IGV) (**)</span></td>
                            </tr>
                            <tr>
                              <td width="167">Taller de mecánica:</td>
                              <td width="41"><?php echo number_format($VentaRepuestoTallerMecanica,2);?></td>
                            </tr>
                            <tr>
                              <td>Planchado y pintura:</td>
                              <td><?php echo number_format($VentaRepuestoPlanchadoPintura,2);?></td>
                            </tr>
                            <tr>
                              <td>Aceite:</td>
                              <td><?php echo number_format($VentaRepuestoAceite,2);?></td>
                            </tr>
                            <tr>
                              <td>Refrigerantes:</td>
                              <td><?php echo number_format($VentaRepuestoRefrigerante,2);?></td>
                            </tr>
                          </tbody>
                      </table></td>
                      </tr>
                    <tr>
                      <td colspan="4">(*) Mano de Obra por Mantenimientos, Reparaciones, Trabajos Internos, Planchado y Pintado y Reingresos<br>
                      (**) Repuestos por Mantenimientos, Reparaciones, Trabajos Internos, Planchado y Pintado y Reingresos</td>
                      </tr>
                    <tr>
                    <td>
                    
                    
                    </td>
                    <td></td>
                    <td colspan="2"></td>
                    </tr>
                    </table>
                    
            <?php	
                break;
            }
            ?>
       
        
        </body>
        </html>


<?php	
}
?>
