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
    
	


$POST_FechaInicio = empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio'];
$POST_FechaFin = empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin'];
$POST_Moneda = (empty($_GET['Moneda'])?$EmpresaMonedaId:$_GET['Moneda']);
$POST_FormaPago = ($_GET['FormaPago']);
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Origen = ("");

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngreso.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsSucursal = new ClsSucursal();
$InsSucursal->SucId =  $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();
	
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
										   
			  $objPHPExcel = $objReader->load("../../plantilla/TemCajaH.xls");
			  
			  

		
		 

$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("C4", $InsSucursal->SucNombre);

$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("I5", date("d/m/Y"));

$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("C5", $POST_FechaInicio);
	
$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("C6", $POST_FechaFin);	
											
$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("I4", $_SESSION['SesionUsuario']);		
	


$InsPago = new ClsPago();
////MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0,$oNoTieneComprobante=false)
//$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal);
//$ArrPagos = $ResPago['Datos'];
$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,"3",NULL,NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal);
$ArrPagos = $ResPago['Datos'];

$InsIngreso = new ClsIngreso();
//MtdObtenerIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'IngId',$oSentido = 'Ingc',$oInginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="IngFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL) 
//$ResIngreso = $InsIngreso->MtdObtenerIngresos(NULL,NULL,NULL,"IngFecha","DESC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"IngFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal);
//$ArrIngresos = $ResIngreso['Datos'];

$ResIngreso = $InsIngreso->MtdObtenerIngresos(NULL,NULL,NULL,"IngFecha","DESC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"IngFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal,$POST_FormaPago,5);
$ArrIngresos = $ResIngreso['Datos'];



$InsDesembolso = new ClsDesembolso();
//MtdObtenerDesembolsos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DesId',$oSentido = 'Desc',$oDesinacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="DesFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL) {
$ResDesembolso = $InsDesembolso->MtdObtenerDesembolsos(NULL,NULL,NULL,"DesFecha","DESC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"DesFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal,$POST_FormaPago);
$ArrDesembolsos = $ResDesembolso['Datos'];


$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 12
       // 'name'  => 'Verdana'
    ));
	
	
$styleRow = array(
				  'borders' => array(
										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
										'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
										'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
									)
				 );
				 



	
	
	
$Fila = 8;
				
					
$TotalIngresos = 0;
$TotalEgresos = 0;



/*
* INGRESOS
*/

//$Fila = $Fila + 2;

$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("B".$Fila, "INGRESOS");	
$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						
$Fila = $Fila + 1;

	
	/*
	* ABONOS DE CLIENTES
	*/
		

	
	$Fila = $Fila + 1;
	
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("B".$Fila,"Abonos de Clientes:");
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(14);
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
	$Fila = $Fila + 1;


		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => '0066CC')
									)
										
				 )
			);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
					
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("B".$Fila, "#");	
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray($styleArray);								
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		


						
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("C".$Fila, "F.P.");	
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
								
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("D".$Fila, "REF.");	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleArray);												
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
								
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E".$Fila, "FECHA");	
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
										
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("F".$Fila, "CONCEPTO");
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
											
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("G".$Fila, "OBS.");
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
											
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("H".$Fila, "MONEDA");
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
											
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("I".$Fila, "MONTO");	
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);		
		
	
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("J".$Fila, "ABONOS RELACIONADOS");	
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);			
			
	
	
	$Fila = $Fila + 1;
						
	$j=1;
	$TotalPagos = 0;
	
	if(!empty($ArrPagos)){
		foreach($ArrPagos as $DatPago){
		
			$DatPago->PagMonto = (($EmpresaMonedaId==$DatPago->MonId or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));
			
				$ArrPagos2 = array();
						$ArrPagos3 = array();
						$ArrPagos4 = array();
						
						$VentaDirectaId = "";
						$OrdenVentaVehiculoId = "";
			
						if(!empty($DatPago->BolId) and !empty($DatPago->BtaId)){
							
							$InsPago2 = new ClsPago();
							$ResPago2 = $InsPago2->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","","3",NULL,NULL,NULL,NULL,NULL,NULL,$DatPago->BolId,$DatPago->BtaId);
							$ArrPagos2 = $ResPago2['Datos'];
							
							$InsBoleta = new ClsBoleta();
							$InsBoleta->BolId = $DatPago->BolId;	
							$InsBoleta->BtaId = $DatPago->BtaId;
							$InsBoleta->MtdObtenerBoleta(false);
							
							if(!empty($InsBoleta->VdiId)){
								$VentaDirectaId = $InsBoleta->VdiId;
							}
							
							if(!empty($InsBoleta->OvvId)){
								$OrdenVentaVehiculoId = $InsBoleta->OvvId;
							}
							
						}else if(!empty($DatPago->FacId) and !empty($DatPago->FtaId)){
						
							$InsPago2 = new ClsPago();
							$ResPago2 = $InsPago2->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","","3",NULL,NULL,NULL,NULL,$DatPago->FacId,$DatPago->FtaId);
							$ArrPagos2 = $ResPago2['Datos'];
							
							
							$InsFactura = new ClsFactura();
							$InsFactura->FacId = $DatPago->FacId;	
							$InsFactura->FtaId = $DatPago->FtaId;
							$InsFactura->MtdObtenerFactura(false);
							
							if(!empty($InsFactura->VdiId)){
								$VentaDirectaId = $InsFactura->VdiId;
							}
							
							if(!empty($InsFactura->OvvId)){
								$OrdenVentaVehiculoId = $InsFactura->OvvId;
							}
						
						}
				
						
						if(!empty($VentaDirectaId)){
						
							$InsPago3 = new ClsPago();
							//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
							$ResPago3 = $InsPago3->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","","3",$VentaDirectaId,NULL,NULL,NULL);
							$ArrPagos3 = $ResPago3['Datos'];
						
						}
						
						if(!empty($OrdenVentaVehiculoId)){
						
							$InsPago4 = new ClsPago();
							$ResPago4 = $InsPago4->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","","3",NULL,$OrdenVentaVehiculoId,NULL,NULL);
							$ArrPagos4 = $ResPago4['Datos'];
						
						}
						
						
						
						   $OtrosAbonos = "";
                        
                        if(!empty($DatPago->BolId) and !empty($DatPago->BtaId)){
                        
                        if(!empty($ArrPagos2)){
                            foreach($ArrPagos2 as $DatPago2){
                                
                                if( $DatPago2->BolId != $DatPago->BolId && $DatPago2->BtaId != $DatPago->BtaId ){
                                    
									$DatPago2->PagMonto = (($EmpresaMonedaId==$DatPago2->MonId or empty($POST_Moneda))?$DatPago2->PagMonto:($DatPago2->PagMonto/$DatPago2->PagTipoCambio));
                                    
                                    $Abono = "";
                                    
                                   // if(!empty($DatPago2->PagFechaTransaccion)){
//                                        $Abono .= " Fec. Transac.: ".$DatPago2->PagFechaTransaccion;
//                                    }
//                                    
                                    if(!empty($DatPago2->PagNumeroTransaccion)){
                                        $Abono .= " Num. Transac.: ".$DatPago2->PagNumeroTransaccion;
                                    }
                                    
                                    $OtrosAbonos .=  "Fecha: ".$DatPago2->PagFecha." ".$Abono." Monto: ".$DatPago2->MonSimbolo." ".number_format($DatPago2->PagMonto,2)."  ";
                                    
                                }
                                
                                
                            }
                        }
                        
                        }else if(!empty($DatPago->FacId) and !empty($DatPago->FtaId)){
                        
							if(!empty($ArrPagos2)){
								foreach($ArrPagos2 as $DatPago2){
									
									if( $DatPago2->FacId != $DatPago->FacId && $DatPago2->FtaId != $DatPago->FtaId ){
										
										 $DatPago2->PagMonto = (($EmpresaMonedaId==$DatPago2->MonId or empty($POST_Moneda))?$DatPago2->PagMonto:($DatPago2->PagMonto/$DatPago2->PagTipoCambio));
										
										$Abono = "";
										//
//										if(!empty($DatPago2->PagFechaTransaccion)){
//											$Abono .= " Fec. Transac.: ".$DatPago2->PagFechaTransaccion;
//										}
										
										if(!empty($DatPago2->PagNumeroTransaccion)){
											$Abono .= " Num. Transac.: ".$DatPago2->PagNumeroTransaccion;
										}
										 
										$OtrosAbonos .=  "Fecha: ".$DatPago2->PagFecha." ".$Abono." Monto: ".$DatPago2->MonSimbolo." ".number_format($DatPago2->PagMonto,2)."  ";
										
									}
									
									
								}
							}
							
                        
                        }
                        
                        
                        
                        
                        if(!empty($ArrPagos3)){
                            foreach($ArrPagos3 as $DatPago3){
                                    
                                $DatPago3->PagMonto = (($EmpresaMonedaId==$DatPago3->MonId or empty($POST_Moneda))?$DatPago3->PagMonto:($DatPago3->PagMonto/$DatPago3->PagTipoCambio));
                                
                                $Abono = "";
                                
                               // if(!empty($DatPago3->PagFechaTransaccion)){
//                                    $Abono .= " Fec. Transac.: ".$DatPago3->PagFechaTransaccion;
//                                }
                                
                                if(!empty($DatPago3->PagNumeroTransaccion)){
                                    $Abono .= " Num. Transac.: ".$DatPago3->PagNumeroTransaccion;
                                }
								
								
                                
                                $OtrosAbonos .=  "Fecha: ".$DatPago3->PagFecha." ".$Abono." Monto: ".$DatPago3->MonSimbolo." ".number_format($DatPago3->PagMonto,2)."  ";
                                
                            }
                        }		
                        
                        
                        
                        if(!empty($ArrPagos4)){
                            foreach($ArrPagos4 as $DatPago4){
                                
                                $DatPago4->PagMonto = (($EmpresaMonedaId==$DatPago4->MonId or empty($POST_Moneda))?$DatPago4->PagMonto:($DatPago4->PagMonto/$DatPago4->PagTipoCambio));
                                
                                $Abono = "";
                                
                              //  if(!empty($DatPago4->PagFechaTransaccion)){
//                                    $Abono .= " Fec. Transac.: ".$DatPago4->PagFechaTransaccion;
//                                }
                                
                                if(!empty($DatPago4->PagNumeroTransaccion)){
                                    $Abono .= " Num. Transac.: ".$DatPago4->PagNumeroTransaccion;
                                }
                                
                                $OtrosAbonos .=  "Fecha: ".$DatPago4->PagFecha." ".$Abono." Monto: ".$DatPago4->MonSimbolo." ".number_format($DatPago4->PagMonto,2)."  ";
                                
                            }
                        }		
	
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("B".$Fila, $j);
			$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray($styleRow);
						
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("C".$Fila, $DatPago->FpaNombre);
			$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleRow);
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("D".$Fila, $DatPago->FtaNumero." ".$DatPago->FacId." ".$DatPago->BtaNumero." ".$DatPago->BolId);
			$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleRow);
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("E".$Fila, $DatPago->PagFecha);
			$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleRow);
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("F".$Fila, $DatPago->PagId." / ".$DatPago->PagConcepto);
            $objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleRow);
			                  
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("G".$Fila, $DatPago->PagObservacionCaja);
			$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleRow);
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("H".$Fila, $DatPago->MonSimbolo);
			$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleRow);
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("I".$Fila, round($DatPago->PagMonto,2));
			$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleRow);
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("J".$Fila, $OtrosAbonos);
			$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray($styleRow);
			  
			$TotalPagos += $DatPago->PagMonto;
		   
			$Fila++;
			$j++;				
		}	
	}

	
	/*
	* OTROS INGRESOS
	*/
					
	
	
	$Fila = $Fila + 1;
	
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("B".$Fila,"Otros Ingresos:");
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(14);
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
	$Fila = $Fila + 1;
					
		
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => '0066CC')
									)
										
				 )
			);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
					
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("B".$Fila, "#");	
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true);		
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray($styleArray);						
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		


						
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("C".$Fila, "F.P.");	
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
								
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("D".$Fila, "REF.");	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleArray);												
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
								
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E".$Fila, "FECHA");	
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
										
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("F".$Fila, "CONCEPTO");
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
											
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("G".$Fila, "OBS.");
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
											
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("H".$Fila, "MONEDA");
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
											
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("I".$Fila, "MONTO");	
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleArray);	
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);			
				
												
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("J".$Fila, "-");	
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray($styleArray);	
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);			
									

		$Fila = $Fila + 1;
		
		$j = 1;
		$TotalOtrosIngresos = 0;
		
		if(!empty($ArrIngresos)){
			foreach($ArrIngresos as $DatIngreso){
			
				$DatIngreso->IngMonto = (($EmpresaMonedaId==$DatIngreso->MonId or empty($POST_Moneda))?$DatIngreso->IngMonto:($DatIngreso->IngMonto/$DatIngreso->IngTipoCambio));
		
		
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("B".$Fila, $j);
				$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray($styleRow);
							
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("C".$Fila, $DatIngreso->FpaNombre);
				$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleRow);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("D".$Fila, $DatIngreso->IngReferencia);
				$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleRow);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E".$Fila, $DatIngreso->IngFecha);
				$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleRow);				
							
					$Concepto = "";
					$Concepto .= "".$DatIngreso->IngId." / ".$DatIngreso->IngConcepto;
	
				   if(!empty($DatIngreso->FinId)){
					   
					   $Concepto .= " / O.T.: ".$DatIngreso->FinId;
					   
				   }
				   
					 if(!empty($DatIngreso->VdiId)){
					   
					   $Concepto .= " / V.D.: ".$DatIngreso->VdiId;
					   
				   }
				   
				   
				   if(!empty($DatIngreso->OvvId)){
					   
					   $Concepto .= " / O.V.V.: ".$DatIngreso->OvvId;
					   
				   }          
								  
					if(!empty($DatIngreso->PerNombre)){
					   
						$Concepto .= "  / Personal: ".$DatIngreso->PerNombre;
						$Concepto .= " ".$DatIngreso->PerApellidoPaterno;
						$Concepto .= " ".$DatIngreso->PerApellidoMaterno;
					   
				   }                
						
					if(!empty($DatIngreso->CliNombre)){
					
						$Concepto .= "  / Cliente: ".$DatIngreso->CliNombre;
						$Concepto .= " ".$DatIngreso->CliApellidoPaterno;
						$Concepto .= " ".$DatIngreso->CliApellidoMaterno;
					
					}                
									  
								  
					if(!empty($DatIngreso->PrvNombre)){
					
						$Concepto .= "  / Proveedor: ".$DatIngreso->PrvNombre;
						$Concepto .= " ".$DatIngreso->PrvApellidoPaterno;
						$Concepto .= " ".$DatIngreso->PrvApellidoMaterno;
					
					}                            
									
                              
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("F".$Fila, $Concepto);
				$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleRow);
						
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("G".$Fila, $DatIngreso->IngObservacionCaja);
				$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleRow);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("H".$Fila, $DatIngreso->MonSimbolo);
				$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleRow);
								
				$objPHPExcel->setActiveSheetIndex(0)
				  				->setCellValue("I".$Fila, round($DatIngreso->IngMonto,2));
				 $objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleRow);
				 
				  $objPHPExcel->setActiveSheetIndex(0)
				  				->setCellValue("J".$Fila,"-");
				 $objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleRow);
				 
				$TotalOtrosIngresos += $DatIngreso->IngMonto;
			   
				$Fila++;
				$j++;				
			}	
		}
	

		$TotalIngresos  = $TotalOtrosIngresos + $TotalPagos;
		
		
		
		$Fila = $Fila + 1;
		
			
					
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("H".$Fila,"TOTAL INGRESOS:");
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true)->setSize(16);								

		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("I".$Fila, round($TotalIngresos,2));
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setSize(16);
		
					
							
		/*
		* EGRESOS
		*/		
						
		$Fila = $Fila + 1;

		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("B".$Fila, "EGRESOS");	
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(16);
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				
		$Fila = $Fila + 1;
					
		/*
		* DESEMBOLSOS
		*/		
					
		
		
		
		$Fila = $Fila + 1;

		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("B".$Fila, "Desembolsos");	
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(14);
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		
				
		$Fila = $Fila + 1;	
		
				
		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => '0066CC')
									)
										
				 )
			);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
					
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("B".$Fila, "#");	
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray($styleArray);							
		$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		


						
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("C".$Fila, "F.P.");	
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
								
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("D".$Fila, "REF.");	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getFont()->setBold(true);		
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleArray);											
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
								
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E".$Fila, "FECHA");	
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleArray);	
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
										
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("F".$Fila, "CONCEPTO");
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleArray);	
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
											
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("G".$Fila, "OBS.");
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleArray);	
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
											
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("H".$Fila, "MONEDA");
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleArray);	
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
											
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("I".$Fila, "MONTO");	
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleArray);	
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);			
		
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("J".$Fila, "-");	
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray($styleArray);	
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);			
					
		
		
//$objPHPExcel->getActiveSheet()->getStyle('B20:L'.$fila)->applyFromArray(
//	array(
//		  'borders' => array(
//		  						'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
//								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
//								
//								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
//								'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
//							)
//		 )
//	);

		
		
		
		
		$Fila = $Fila + 2;	
	
		$j=1;
		$TotalDesembolsos = 0;
		
		if(!empty($ArrDesembolsos)){
			foreach($ArrDesembolsos as $DatDesembolso){
			
				$DatDesembolso->DesMonto = (($EmpresaMonedaId==$DatDesembolso->MonId or empty($POST_Moneda))?$DatDesembolso->DesMonto:($DatDesembolso->PagMonto/$DatPago->DesTipoCambio));
		
		
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("B".$Fila, $j);
				$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray($styleRow);
				
							
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("C".$Fila, $DatDesembolso->FpaNombre);
				$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleRow);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("D".$Fila, $DatDesembolso->DesReferencia);
				$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleRow);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E".$Fila, $DatDesembolso->DesFecha);
				$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleRow);


								
			$Concepto = "";	
            $Concepto .= "".$DatDesembolso->DesId." / ".$DatDesembolso->DesConcepto;	
            			
			if(!empty($DatDesembolso->FinId)){
					
				$Concepto .= " / O.T.:".$DatDesembolso->FinId;			
		
			}
		  
		   if(!empty($DatDesembolso->VdiId)){
			   
			   $Concepto .= " / V.D.: ".$DatDesembolso->VdiId;			
		  
		   }
		  
		   if(!empty($DatDesembolso->OvvId)){
			   
			    $Concepto .= " / O.V.V.: ".$DatDesembolso->OvvId;
		 
		   }
		
		   if(!empty($DatDesembolso->PerNombre)){
			   
			    $Concepto .= " / Personal: ".$DatDesembolso->PerNombre." ".$DatDesembolso->PerApellidoPaterno." ".$DatDesembolso->PerApellidoMaterno;
				
		   }
		
		   if(!empty($DatDesembolso->CliNombre)){
			   
			   $Concepto .= " / Cliente: ".$DatDesembolso->CliNombre." ".$DatDesembolso->CliApellidoPaterno." ".$DatDesembolso->CliApellidoMaterno;
			
		   }
		  
		   if(!empty($DatDesembolso->PrvNombre)){
			   
			   $Concepto .= " / Proveedor: ".$DatDesembolso->PrvNombre." ".$DatDesembolso->PrvApellidoPaterno." ".$DatDesembolso->PrvApellidoMaterno;
			
		   }
		   
		   
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("F".$Fila, $DatDesembolso->DesId.' / '.$DatDesembolso->DesConcepto.' '.$Concepto);
				$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleRow);
						
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("G".$Fila, $DatDesembolso->PagObservacionCaja);
				$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleRow);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("H".$Fila, $DatDesembolso->MonSimbolo);
				$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleRow);				
								
				$objPHPExcel->setActiveSheetIndex(0)
				  				->setCellValue("I".$Fila, round($DatDesembolso->DesMonto,2));
 				$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleRow);
				
				$objPHPExcel->setActiveSheetIndex(0)
				  				->setCellValue("J".$Fila, "-");
 				$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray($styleRow);
				  
			   $TotalDesembolsos += $DatDesembolso->DesMonto;
		  
				 
				$Fila++;
				$j++;				
			}	
		}
	 
	 
		
		$TotalEgresos = $TotalDesembolsos;

	
		$Fila = $Fila + 2;
		
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("H".$Fila,"TOTAL EGRESOS:");
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true)->setSize(16);								

		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("I".$Fila, round($TotalEgresos,2));
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setSize(16);
		
		
									
									
		$TotalSaldo = $TotalIngresos - $TotalEgresos;

		
		
		
		
		$Fila = $Fila + 2;
		
				
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("H".$Fila,"TOTAL SALDO:");
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true)->setSize(16);								

		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("I".$Fila, round($TotalSaldo,2));
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setSize(16);
		
			
		
		
		//if($i>$j){
//			$Fila = $Fila+2;
//			
//			$objPHPExcel->setActiveSheetIndex(0)
//				->setCellValue("A".$Fila, "SALDO:");
//				
//			$objPHPExcel->setActiveSheetIndex(0)
//				->setCellValue("B".$Fila, round($TotalSaldo,2));
//		}else{
//			
//			$objPHPExcel->setActiveSheetIndex(0)
//				->setCellValue("A".$Fila2, "SALDO:");
//				
//			$Fila2 = $Fila2+2;
//			$objPHPExcel->setActiveSheetIndex(0)
//				->setCellValue("B".$Fila2, round($TotalSaldo,2));
//		}
//		
		
									
					
					
$objPHPExcel->getActiveSheet()->getStyle('B6:J'.$objPHPExcel->getActiveSheet()->getHighestRow())
    ->getAlignment()->setWrapText(false); 						
					
					
								
													
								
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('COR - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/CAJA_DIARIA_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/CAJA_DIARIA_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
		
?>