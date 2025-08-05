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
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');

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
										   
			  $objPHPExcel = $objReader->load("../../plantilla/TemCajaResumenEfectivo.xls");
			  
			  

		
		 

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
	



$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 14
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

$Fila = 6;
					
					
$TotalIngresos = 0;


$TotalPagoFacturas = 0;
$TotalPagoBoletas = 0;
$TotalPagoVentaDirectas = 0;
$TotalPagoOrdenVentaVehiculos = 0;

$TotalOtrosIngresos = 0;


/*
* INGRESOS
*/

//$Fila = $Fila + 2;

//$objPHPExcel->setActiveSheetIndex(0)
//						->setCellValue("B".$Fila, "INGRESOS");	
//$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(16);
//$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//						
//$Fila = $Fila + 1;

	
	/*
	* ABONOS DE CLIENTES
	*/
		
//	$InsPago = new ClsPago();
//	//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
//	$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal);
//	$ArrPagos = $ResPago['Datos'];


$InsPago = new ClsPago();
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0)
$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","1000","3",NULL,NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"ARE-10010",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal,NULL,NULL,"FAC");
$ArrPagoFacturas = $ResPago['Datos'];

$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","1000","3",NULL,NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"ARE-10010",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal,NULL,NULL,"BOL");
$ArrPagoBoletas = $ResPago['Datos'];


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","1000","3",NULL,NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"ARE-10010",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal,NULL,NULL,"VDI");
$ArrPagoVentaDirectas = $ResPago['Datos'];


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","1000","3",NULL,NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"ARE-10010",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal,NULL,NULL,"OVV");
$ArrPagoOrdenVentaVehiculos = $ResPago['Datos'];







/*
* FACTURAS
*/
	
	$Fila = $Fila + 2;
	
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("B".$Fila,"FACTURAS:");
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(16);
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':K'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);
			
			
	
	$Fila = $Fila + 1;


		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':K'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => '0066CC')
									)
										
				 )
			);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
		
		
					
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
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("D".$Fila, "DOC. REF.");	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getAlignment()->setWrapText(true);												
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
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("F".$Fila, "REF.");
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->getAlignment()->setWrapText(true);								
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
								->setCellValue("G".$Fila, "CONCEPTO");
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->getAlignment()->setWrapText(true);								
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
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setWrapText(true);
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
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("J".$Fila, "OBS.");
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->getAlignment()->setWrapText(true);
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
		
		
				
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("K".$Fila, "ABONOS RELACIONADOS");
		$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->applyFromArray(
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
	
	
	if(!empty($ArrPagoFacturas)){
		foreach($ArrPagoFacturas as $DatPagoFactura){
		
			$Referencia =	"Cliente:";
			
			//MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPagoOrdenVentaVehiculo=NULL)
			$InsPagoComprobante = new ClsPagoComprobante();
			$ResPagoComprobante = $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,'PacId','Desc',NULL,$DatPagoFactura->PagId);
			$ArrPagoComprobantes = $ResPagoComprobante['Datos'];
			
			if(!empty($ArrPagoComprobantes)){
				foreach($ArrPagoComprobantes as $DatPagoComprobante){
			
					$Referencia .= $DatPagoComprobante->CliNombre." ";
					$Referencia .= $DatPagoComprobante->CliApellidoPaterno." ";
					$Referencia .= $DatPagoComprobante->CliApellidoMaterno." ";
					
				}
			}

			$DatPagoFactura->PagMonto = (($EmpresaMonedaId==$DatPagoFactura->MonId or empty($POST_Moneda))?$DatPagoFactura->PagMonto:($DatPagoFactura->PagMonto/$DatPagoFactura->CdiTipoCambio));
	
			
			
			
			$ArrPagos2 = array();
						$ArrPagos3 = array();
						$ArrPagos4 = array();
						

						$VentaDirectaId = "";
						$OrdenVentaVehiculoId = "";
			
					
							$InsPago2 = new ClsPago();
							$ResPago2 = $InsPago2->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",NULL,NULL,NULL,NULL,$DatPagoFactura->FacId,$DatPagoFactura->FtaId);
							$ArrPagos2 = $ResPago2['Datos'];
							
							
							$InsFactura = new ClsFactura();
							$InsFactura->FacId = $DatPagoFactura->FacId;	
							$InsFactura->FtaId = $DatPagoFactura->FtaId;
							$InsFactura->MtdObtenerFactura(false);
							
							if(!empty($InsFactura->VdiId)){
								$VentaDirectaId = $InsFactura->VdiId;
							}
							
							if(!empty($InsFactura->OvvId)){
								$OrdenVentaVehiculoId = $InsFactura->OvvId;
							}
						
					
						
						if(!empty($VentaDirectaId)){
						
							$InsPago3 = new ClsPago();
							//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
							$ResPago3 = $InsPago3->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",$VentaDirectaId,NULL,NULL,NULL);
							$ArrPagos3 = $ResPago3['Datos'];
						
						}
						
						if(!empty($OrdenVentaVehiculoId)){
						
							$InsPago4 = new ClsPago();
							$ResPago4 = $InsPago4->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",NULL,$OrdenVentaVehiculoId,NULL,NULL);
							$ArrPagos4 = $ResPago4['Datos'];
						
						}
						
						
						
				
  							$OtrosAbonos = "";
                      
							if(!empty($ArrPagos2)){
								foreach($ArrPagos2 as $DatPago2){
									
									if( $DatPago2->FacId != $DatPagoFactura->FacId && $DatPago2->FtaId != $DatPagoFactura->FtaId ){
										
										 $DatPago2->PagMonto = (($EmpresaMonedaId==$DatPago2->MonId or empty($POST_Moneda))?$DatPago2->PagMonto:($DatPago2->PagMonto/$DatPago2->PagTipoCambio));
										
										//$Abono = "(2b)";
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
							
                      
                        
                        
                        
                        if(!empty($ArrPagos3)){
                            foreach($ArrPagos3 as $DatPago3){
                                    
                                $DatPago3->PagMonto = (($EmpresaMonedaId==$DatPago3->MonId or empty($POST_Moneda))?$DatPago3->PagMonto:($DatPago3->PagMonto/$DatPago3->PagTipoCambio));
                                
                               // $Abono = "(3)";
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
                                
                                ///$Abono = "(4)";
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
							->setCellValue("C".$Fila, $DatPagoFactura->FpaNombre);
			$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleRow);
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("D".$Fila, $DatPagoFactura->FtaNumero." ".$DatPagoFactura->FacId." ".$DatPagoFactura->BtaNumero." ".$DatPagoFactura->BolId);
			$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleRow);
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("E".$Fila, $DatPagoFactura->PagFecha);
			$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleRow);				
						
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("F".$Fila, $Referencia);
			$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleRow);				
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("G".$Fila, $DatPagoFactura->PagId." / ".$DatPagoFactura->PagConcepto);
             $objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleRow);                 
		
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("H".$Fila, $DatPagoFactura->MonSimbolo);
			$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleRow);
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("I".$Fila, round($DatPagoFactura->PagMonto,2));
			 $objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleRow); 
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("J".$Fila, $DatPagoFactura->PagObservacionCaja);
			$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray($styleRow);
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("K".$Fila, $OtrosAbonos);
			$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->applyFromArray($styleRow);
			
			
			$TotalPagoFacturas += $DatPagoFactura->PagMonto;
		   
			$Fila++;
			$j++;				
		}	
	}
	
	
	$Fila = $Fila + 1;
	
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("H".$Fila, "TOTAL FACTURAS:");
	$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true)->setSize(16);		
	$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("I".$Fila, $TotalPagoFacturas);
	$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setBold(true)->setSize(16);								
	$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);						
	
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);
			
			


/*
* BOLETAS
*/							
	
	
	
	
	$Fila = $Fila + 2;
	
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("B".$Fila,"BOLETAS:");
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(16);
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);
			
			
	$Fila = $Fila + 1;


		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':K'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => '0066CC')
									)
										
				 )
			);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
		
		
					
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
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("D".$Fila, "DOC. REF.");	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getAlignment()->setWrapText(true);												
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
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("F".$Fila, "REF.");
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->getAlignment()->setWrapText(true);								
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
								->setCellValue("G".$Fila, "CONCEPTO");
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->getAlignment()->setWrapText(true);								
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
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setWrapText(true);
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
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("J".$Fila, "OBS.");
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->getAlignment()->setWrapText(true);
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
		
			
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("K".$Fila, "ABONOS RELACIONADOS");
		$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->applyFromArray(
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
	
	
	if(!empty($ArrPagoBoletas)){
		foreach($ArrPagoBoletas as $DatPagoBoleta){
		
			$Referencia =	"Cliente:";
			
			//MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPagoOrdenVentaVehiculo=NULL)
			$InsPagoComprobante = new ClsPagoComprobante();
			$ResPagoComprobante = $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,'PacId','Desc',NULL,$DatPagoBoleta->PagId);
			$ArrPagoComprobantes = $ResPagoComprobante['Datos'];
			
			if(!empty($ArrPagoComprobantes)){
				foreach($ArrPagoComprobantes as $DatPagoComprobante){
			
					$Referencia .= $DatPagoComprobante->CliNombre." ";
					$Referencia .= $DatPagoComprobante->CliApellidoPaterno." ";
					$Referencia .= $DatPagoComprobante->CliApellidoMaterno." ";
					
				}
			}

			$DatPagoBoleta->PagMonto = (($EmpresaMonedaId==$DatPagoBoleta->MonId or empty($POST_Moneda))?$DatPagoBoleta->PagMonto:($DatPagoBoleta->PagMonto/$DatPagoBoleta->CdiTipoCambio));
	
			
			
			
							
							$ArrPagos2 = array();
						$ArrPagos3 = array();
						$ArrPagos4 = array();
						
                     
						$VentaDirectaId = "";
						$OrdenVentaVehiculoId = "";
			
						
							$InsPago2 = new ClsPago();
							$ResPago2 = $InsPago2->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",NULL,NULL,NULL,NULL,NULL,NULL,$DatPagoBoleta->BolId,$DatPagoBoleta->BtaId);
							$ArrPagos2 = $ResPago2['Datos'];
							
							$InsBoleta = new ClsBoleta();
							$InsBoleta->BolId = $DatPagoBoleta->BolId;	
							$InsBoleta->BtaId = $DatPagoBoleta->BtaId;
							$InsBoleta->MtdObtenerBoleta(false);
							
							if(!empty($InsBoleta->VdiId)){
								$VentaDirectaId = $InsBoleta->VdiId;
							}
							
							if(!empty($InsBoleta->OvvId)){
								$OrdenVentaVehiculoId = $InsBoleta->OvvId;
							}
							
				
				
						
						if(!empty($VentaDirectaId)){
						
							$InsPago3 = new ClsPago();
							//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
							$ResPago3 = $InsPago3->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",$VentaDirectaId,NULL,NULL,NULL);
							$ArrPagos3 = $ResPago3['Datos'];
						
						}
						
						if(!empty($OrdenVentaVehiculoId)){
						
							$InsPago4 = new ClsPago();
							$ResPago4 = $InsPago4->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",NULL,$OrdenVentaVehiculoId,NULL,NULL);
							$ArrPagos4 = $ResPago4['Datos'];
						
						}
						
						
					 $OtrosAbonos = "";
                       
                        if(!empty($ArrPagos2)){
                            foreach($ArrPagos2 as $DatPago2){
                                
                                if( $DatPago2->BolId != $DatPagoBoleta->BolId && $DatPago2->BtaId != $DatPagoBoleta->BtaId ){
                                    
									$DatPago2->PagMonto = (($EmpresaMonedaId==$DatPago2->MonId or empty($POST_Moneda))?$DatPago2->PagMonto:($DatPago2->PagMonto/$DatPago2->PagTipoCambio));
                                    
                                  //  $Abono = "(2a)";
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
                  
                        
                        
                        
                        if(!empty($ArrPagos3)){
                            foreach($ArrPagos3 as $DatPago3){
                                    
                                $DatPago3->PagMonto = (($EmpresaMonedaId==$DatPago3->MonId or empty($POST_Moneda))?$DatPago3->PagMonto:($DatPago3->PagMonto/$DatPago3->PagTipoCambio));
                                
                               // $Abono = "(3)";
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
                                
                                ///$Abono = "(4)";
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
							->setCellValue("C".$Fila, $DatPagoBoleta->FpaNombre);
			$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleRow);
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("D".$Fila, $DatPagoBoleta->FtaNumero." ".$DatPagoBoleta->FacId." ".$DatPagoBoleta->BtaNumero." ".$DatPagoBoleta->BolId);
			$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleRow);
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("E".$Fila, $DatPagoBoleta->PagFecha);
			$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleRow);				
						
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("F".$Fila, $Referencia);
			$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleRow);				
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("G".$Fila, $DatPagoBoleta->PagId." / ".$DatPagoBoleta->PagConcepto);
            $objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleRow);                  
		
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("H".$Fila, $DatPagoBoleta->MonSimbolo);
			$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleRow);
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("I".$Fila, round($DatPagoBoleta->PagMonto,2));
			 $objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleRow); 
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("J".$Fila, $DatPagoBoleta->PagObservacionCaja);
			$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray($styleRow);
			
			
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("K".$Fila, $OtrosAbonos);
			$objPHPExcel->getActiveSheet()->getStyle("K".$Fila)->applyFromArray($styleRow);
			
			
			$TotalPagoBoletas += $DatPagoBoleta->PagMonto;
		   
			$Fila++;
			$j++;				
		}	
	}
	
	
	$Fila = $Fila + 1;
	
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("H".$Fila, "TOTAL BOLETAS:");
	$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true)->setSize(16);		
	$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("I".$Fila, $TotalPagoBoletas);
	$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setBold(true)->setSize(16);		
	$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);
			
			
	/*
	* ABONO DE REPUESTOS	
	*/
	
	
	
	$Fila = $Fila + 2;
	
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("B".$Fila,"ABONOS DE REPUESTOS:");
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(16);
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);
			
			
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
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("D".$Fila, "DOC. REF.");	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getAlignment()->setWrapText(true);												
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
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("F".$Fila, "REF.");
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->getAlignment()->setWrapText(true);								
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
								->setCellValue("G".$Fila, "CONCEPTO");
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->getAlignment()->setWrapText(true);								
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
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setWrapText(true);
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
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("J".$Fila, "OBS.");
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->getAlignment()->setWrapText(true);
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
	
	
	if(!empty($ArrPagoVentaDirectas)){
		foreach($ArrPagoVentaDirectas as $DatPagoVentaDirecta){
		
			$Referencia =	"Cliente:";
			
			//MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPagoOrdenVentaVehiculo=NULL)
			$InsPagoComprobante = new ClsPagoComprobante();
			$ResPagoComprobante = $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,'PacId','Desc',NULL,$DatPagoVentaDirecta->PagId);
			$ArrPagoComprobantes = $ResPagoComprobante['Datos'];
			
			if(!empty($ArrPagoComprobantes)){
				foreach($ArrPagoComprobantes as $DatPagoComprobante){
			
					$Referencia .= $DatPagoComprobante->CliNombre." ";
					$Referencia .= $DatPagoComprobante->CliApellidoPaterno." ";
					$Referencia .= $DatPagoComprobante->CliApellidoMaterno." ";
					
				}
			}

			$DatPagoVentaDirecta->PagMonto = (($EmpresaMonedaId==$DatPagoVentaDirecta->MonId or empty($POST_Moneda))?$DatPagoVentaDirecta->PagMonto:($DatPagoVentaDirecta->PagMonto/$DatPagoVentaDirecta->CdiTipoCambio));
	
	
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("B".$Fila, $j);
			$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray($styleRow);
			
					
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("C".$Fila, $DatPagoVentaDirecta->FpaNombre);
			$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleRow);
			
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("D".$Fila,$DatPagoVentaDirecta->PagId." ". $DatPagoVentaDirecta->FtaNumero." ".$DatPagoVentaDirecta->FacId." ".$DatPagoVentaDirecta->BtaNumero." ".$DatPagoVentaDirecta->BolId);
			$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleRow);
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("E".$Fila, $DatPagoVentaDirecta->PagFecha);
			$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleRow);				
						
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("F".$Fila, $Referencia);
			$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleRow);				
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("G".$Fila, $DatPagoVentaDirecta->PagConcepto);
			$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleRow);                 
		
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("H".$Fila, $DatPagoVentaDirecta->MonSimbolo);
			$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleRow);
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("I".$Fila, round($DatPagoVentaDirecta->PagMonto,2));
			$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleRow);  
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("J".$Fila, $DatPagoVentaDirecta->PagObservacionCaja);
			$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray($styleRow);
			
			
			$TotalPagoVentaDirectas += $DatPagoVentaDirecta->PagMonto;
		   
			$Fila++;
			$j++;				
		}	
	}
	
	
	$Fila = $Fila + 1;
	
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("H".$Fila, "TOTAL ABONO DE REPUESTOS:");
	$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true)->setSize(16);		
	$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	
						
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("I".$Fila, $TotalPagoVentaDirectas);
	$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setBold(true)->setSize(16);								
	$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
	
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);
			
			
										
	/*
	* ABONO DE VEHICULOS
	*/
	
	
	
	$Fila = $Fila + 2;
	
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("B".$Fila,"ABONOS DE VEHICULOS:");
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(16);
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);
			
			
			
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
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("D".$Fila, "DOC. REF.");	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getAlignment()->setWrapText(true);												
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
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("F".$Fila, "REF.");
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->getAlignment()->setWrapText(true);								
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
								->setCellValue("G".$Fila, "CONCEPTO");
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->getAlignment()->setWrapText(true);								
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
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setWrapText(true);
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
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("J".$Fila, "OBS.");
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->getAlignment()->setWrapText(true);
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
	
	
	if(!empty($ArrPagoOrdenVentaVehiculos)){
		foreach($ArrPagoOrdenVentaVehiculos as $DatPagoOrdenVentaVehiculo){
		
			$Referencia =	"Cliente:";
			
			//MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPagoOrdenVentaVehiculo=NULL)
			$InsPagoComprobante = new ClsPagoComprobante();
			$ResPagoComprobante = $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,'PacId','Desc',"100",$DatPagoOrdenVentaVehiculo->PagId);
			$ArrPagoComprobantes = $ResPagoComprobante['Datos'];
			
			if(!empty($ArrPagoComprobantes)){
				foreach($ArrPagoComprobantes as $DatPagoComprobante){
			
					$Referencia .= $DatPagoComprobante->CliNombre." ";
					$Referencia .= $DatPagoComprobante->CliApellidoPaterno." ";
					$Referencia .= $DatPagoComprobante->CliApellidoMaterno." ";
					
				}
			}

			$DatPagoOrdenVentaVehiculo->PagMonto = (($EmpresaMonedaId==$DatPagoOrdenVentaVehiculo->MonId or empty($POST_Moneda))?$DatPagoOrdenVentaVehiculo->PagMonto:($DatPagoOrdenVentaVehiculo->PagMonto/$DatPagoOrdenVentaVehiculo->CdiTipoCambio));
	
	
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("B".$Fila, $j);
			$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->applyFromArray($styleRow);
			
					
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("C".$Fila, $DatPagoOrdenVentaVehiculo->FpaNombre);
			$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->applyFromArray($styleRow);
			
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("D".$Fila, $DatPagoOrdenVentaVehiculo->PagId." ".$DatPagoOrdenVentaVehiculo->FtaNumero." ".$DatPagoOrdenVentaVehiculo->FacId." ".$DatPagoOrdenVentaVehiculo->BtaNumero." ".$DatPagoOrdenVentaVehiculo->BolId);
			$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleRow);
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("E".$Fila, $DatPagoOrdenVentaVehiculo->PagFecha);
			$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->applyFromArray($styleRow);				
						
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("F".$Fila, $Referencia);
			$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->applyFromArray($styleRow);				
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("G".$Fila, $DatPagoOrdenVentaVehiculo->PagConcepto);
             $objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->applyFromArray($styleRow);                 
		
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("H".$Fila, $DatPagoOrdenVentaVehiculo->MonSimbolo);
			$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->applyFromArray($styleRow);
							
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("I".$Fila, round($DatPagoOrdenVentaVehiculo->PagMonto,2));
			$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->applyFromArray($styleRow);  
			
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("J".$Fila, $DatPagoOrdenVentaVehiculo->PagObservacionCaja);
			$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->applyFromArray($styleRow);
			
			
			$TotalPagoOrdenVentaVehiculos += $DatPagoOrdenVentaVehiculo->PagMonto;
		   
			$Fila++;
			$j++;				
		}	
	}
	
	
	$Fila = $Fila + 1;
	
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("H".$Fila, "TOTAL ABONO DE VEHICULOS:");
	$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true)->setSize(16);		
	$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	
						
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("I".$Fila, $TotalPagoOrdenVentaVehiculos);
	$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setBold(true)->setSize(16);								
	$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);							
							
	
	/*
	* OTROS INGRESOS
	*/
					
	$InsIngreso = new ClsIngreso();
	//MtdObtenerIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'IngId',$oSentido = 'Ingc',$oInginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="IngFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL) 
	$ResIngreso = $InsIngreso->MtdObtenerIngresos(NULL,NULL,NULL,"IngFecha","DESC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"IngFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal,NULL,5);
	$ArrIngresos = $ResIngreso['Datos'];
	
	$Fila = $Fila + 2;
	
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("B".$Fila,"OTROS INGRESOS:");
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getFont()->setBold(true)->setSize(16);
	$objPHPExcel->getActiveSheet()->getStyle("B".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);
			
			
			
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
		$objPHPExcel->getActiveSheet()->getStyle("C".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("D".$Fila, "DOC. REF.");	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("D".$Fila)->getAlignment()->setWrapText(true);												
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
		$objPHPExcel->getActiveSheet()->getStyle("E".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("F".$Fila, "REF.");
		$objPHPExcel->getActiveSheet()->getStyle("F".$Fila)->getAlignment()->setWrapText(true);								
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
								->setCellValue("G".$Fila, "CONCEPTO");
		$objPHPExcel->getActiveSheet()->getStyle("G".$Fila)->getAlignment()->setWrapText(true);								
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
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setWrapText(true);
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
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setWrapText(true);
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
								->setCellValue("J".$Fila, "OBS.");
		$objPHPExcel->getActiveSheet()->getStyle("J".$Fila)->getAlignment()->setWrapText(true);
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
		
		
		if(!empty($ArrIngresos)){
			foreach($ArrIngresos as $DatIngreso){
			
				$DatIngreso->IngMonto = (($EmpresaMonedaId==$DatIngreso->MonId or empty($POST_Moneda))?$DatIngreso->IngMonto:($DatIngreso->IngMonto/$DatIngreso->IngTipoCambio));
		
		
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("B".$Fila, $j);
							
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("C".$Fila, $DatIngreso->FpaNombre);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("D".$Fila, $DatIngreso->IngReferencia);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E".$Fila, $DatIngreso->IngFecha);
					
							
				$Referencia = "";
						  
				if(!empty($DatIngreso->PerNombre)){
				   
					$Referencia .= "  / Personal: ".$DatIngreso->PerNombre;
					$Referencia .= " ".$DatIngreso->PerApellidoPaterno;
					$Referencia .= " ".$DatIngreso->PerApellidoMaterno;
				   
			   }                
					
				if(!empty($DatIngreso->CliNombre)){
				
					$Referencia .= "  / Cliente: ".$DatIngreso->CliNombre;
					$Referencia .= " ".$DatIngreso->CliApellidoPaterno;
					$Referencia .= " ".$DatIngreso->CliApellidoMaterno;
				
				}                
								  
							  
				if(!empty($DatIngreso->PrvNombre)){
				
					$Referencia .= "  / Proveedor: ".$DatIngreso->PrvNombre;
					$Referencia .= " ".$DatIngreso->PrvApellidoPaterno;
					$Referencia .= " ".$DatIngreso->PrvApellidoMaterno;
				
				}                            
								
					
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("F".$Fila, $Referencia);
					
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
						
                              
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("G".$Fila, $Concepto);
						
			
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("H".$Fila, $DatIngreso->MonSimbolo);
								
				$objPHPExcel->setActiveSheetIndex(0)
				  				->setCellValue("I".$Fila, round($DatIngreso->IngMonto,2));
				  
			 	$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("J".$Fila, $DatIngreso->IngObservacionCaja);
				
				
				$TotalOtrosIngresos += $DatIngreso->IngMonto;
			   
				$Fila++;
				$j++;				
			}	
		}
	
		
		$Fila = $Fila + 1;
		
			
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("H".$Fila,"TOTAL OTROS INGRESOS:");
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true)->setSize(16);								
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("I".$Fila, round($TotalOtrosIngresos,2));
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setSize(16);
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':J'.$Fila)->applyFromArray(
			array('fill' 	=> array(
										'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
										'color'		=> array('rgb' => 'CCCCCC')
									)
										
				 )
			);
		
			
			
	$TotalIngresos  = $TotalOtrosIngresos + $TotalPagoBoletas + $TotalPagoFacturas + $TotalPagoVentaDirectas + $TotalPagoOrdenVentaVehiculos;
		
		
		
		$Fila = $Fila + 2;
		
			
					
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("H".$Fila,"TOTAL INGRESOS:");
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getFont()->setBold(true)->setSize(16);								
		$objPHPExcel->getActiveSheet()->getStyle("H".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("I".$Fila, round($TotalIngresos,2));
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getFont()->setSize(16);
		$objPHPExcel->getActiveSheet()->getStyle("I".$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		
					
								
								
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('COR - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/RESUMEN_CAJA_INGRESOS_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/RESUMEN_CAJA_INGRESOS_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
		
?>