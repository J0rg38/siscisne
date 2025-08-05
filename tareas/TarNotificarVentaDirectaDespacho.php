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


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');


$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("../plantilla/TemReporte.xls");

// Set document properties
					$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
												 ->setLastModifiedBy("Maarten Balliauw")
												 ->setTitle("PHPExcel Test Document")
												 ->setSubject("PHPExcel Test Document")
												 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
												 ->setKeywords("office PHPExcel php")
												 ->setCategory("Test result file");







$Enviar = false;

$ProveedorNombre = "";
$ProveedorNumeroDocumento = "";

$oProveedor = "PRV-10548";
$oCondicionPago = "NPA-10001";

$oFechaInicio = "01/01/".date("Y");
$oFechaFin = date("d/m/Y");
			

$InsProveedor = new ClsProveedor();
$InsProveedor->PrvId = $oProveedor;
$InsProveedor->MtdObtenerProveedor();

$ProveedorNombre = $InsProveedor->PrvNombre." ".$InsProveedor->PrvApellidoPaterno." ".$InsProveedor->PrvApellidoMaterno;
$ProveedorNumeroDocumento = $InsProveedor->PrvNumeroDocumento;
$ProveedorTipoDocumento = $InsProveedor->TdoNombre;









// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B3', "AVISO DE VENCIMIENTO DE FACTURAS:");
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true)->setSize(14);



//////////////
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A5', "FECHA:");
$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true)->setSize(12);		

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B5', date("d/m/Y"));
$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(false)->setSize(12);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C5', "PROVEEDOR:");
$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true)->setSize(12);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D5', $ProveedorNombre);
$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(false)->setSize(12);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E5', "NUM. DOC.:");
$objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true)->setSize(12);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F5', $ProveedorTipoDocumento."/".$ProveedorNumeroDocumento);
$objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(false)->setSize(12);


				
				
				
				
	//////////////		   
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A6', "#");
$objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true)->setSize(12);		
							   
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B6', "COND. PAGO");
$objPHPExcel->getActiveSheet()->getStyle('B6')->getFont()->setBold(true)->setSize(12);		
				
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C6', "NUM. COMPROB.");
$objPHPExcel->getActiveSheet()->getStyle('C6')->getFont()->setBold(true)->setSize(12);	
				
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D6', "FECHA COMPROB.");
$objPHPExcel->getActiveSheet()->getStyle('D6')->getFont()->setBold(true)->setSize(12);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E6', "NUM. DOC.");
$objPHPExcel->getActiveSheet()->getStyle('E6')->getFont()->setBold(true)->setSize(12);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F6', "PROVEEDOR");
$objPHPExcel->getActiveSheet()->getStyle('F6')->getFont()->setBold(true)->setSize(12);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G6', "MONEDA");
$objPHPExcel->getActiveSheet()->getStyle('G6')->getFont()->setBold(true)->setSize(12);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H6', "ORD. COMPRA");
$objPHPExcel->getActiveSheet()->getStyle('H6')->getFont()->setBold(true)->setSize(12);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I6', "CRED. CANT. DIAS");
$objPHPExcel->getActiveSheet()->getStyle('I6')->getFont()->setBold(true)->setSize(12);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J6', "FECHA VENC.");
$objPHPExcel->getActiveSheet()->getStyle('J6')->getFont()->setBold(true)->setSize(12);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K6', "TOTAL");
$objPHPExcel->getActiveSheet()->getStyle('K6')->getFont()->setBold(true)->setSize(12);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L6', "AMORT.");
$objPHPExcel->getActiveSheet()->getStyle('L6')->getFont()->setBold(true)->setSize(12);	
							
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('M6', "SALDO.");
$objPHPExcel->getActiveSheet()->getStyle('M6')->getFont()->setBold(true)->setSize(12);	
									
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('N6', "VENCIMIENTO");
$objPHPExcel->getActiveSheet()->getStyle('N6')->getFont()->setBold(true)->setSize(12);	
									
					
//$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
//$InsAlmacenMovimientoEntrada->MtdNotificarAlmacenMovimientoEntradaVencimiento("jblanco@cyc.com.pe","01/01/".date("Y"),date("d/m/Y"),"NPA-10001","PRV-10548");	



			
		
$fila = 7;
			
			
			$InsMoneda = new ClsMoneda();
			$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","DESC",NULL);
			$ArrMonedas = $ResMoneda['Datos'];

			foreach($ArrMonedas as $DatMoneda){



				//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL) {
				$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,"AmoComprobanteFecha","ASC",NULL,FncCambiaFechaAMysql($oFechaInicio),FncCambiaFechaAMysql($oFechaFin),NULL,NULL,$DatMoneda->MonId,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",0,2,$oProveedor,NULL,$oCondicionPago);
				$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];
$c = 1;	
				if(!empty($ArrAlmacenMovimientoEntradas)){
				foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){


					$DatAlmacenMovimientoEntrada->AmoTotal = (($EmpresaMonedaId==$DatMoneda->MonId or empty($DatMoneda->MonId))?$DatAlmacenMovimientoEntrada->AmoTotal:($DatAlmacenMovimientoEntrada->AmoTotal/$DatAlmacenMovimientoEntrada->AmoTipoCambio));
				
					$DatAlmacenMovimientoEntrada->AmoTotal = round($DatAlmacenMovimientoEntrada->AmoTotal,2);
					
					$Mostrar = true;

					if($DatAlmacenMovimientoEntrada->NpaId == "NPA-10001"){
						
						settype($DatAlmacenMovimientoEntrada->AmoTotal ,"float");
						settype($ProveedorPagoMontoTotal ,"float");
						
						
						if(($ProveedorPagoMontoTotal+1000) < ($DatAlmacenMovimientoEntrada->AmoTotal+1000)){
							if($DatAlmacenMovimientoEntrada->AmoCantidadDia<$DatAlmacenMovimientoEntrada->AmoDiaTranscurrido){
								
							}else if ( ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) >= 1 and ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) <=3 ){
				
							}else{
								
								$Mostrar = false;
								
							}
						}
						
					}
	
				if($Mostrar){
					
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$fila,  $c);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setBold(false)->setSize(12);		
												   
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('B'.$fila, $DatAlmacenMovimientoEntrada->NpaNombre);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(false)->setSize(12);		
									
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C'.$fila, $DatAlmacenMovimientoEntrada->AmoComprobanteNumero);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getFont()->setBold(false)->setSize(12);	
									
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('D'.$fila, $DatAlmacenMovimientoEntrada->AmoComprobanteFecha);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->getFont()->setBold(false)->setSize(12);	
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E'.$fila, $DatAlmacenMovimientoEntrada->PrvNumeroDocumento);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->getFont()->setBold(false)->setSize(12);	
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F'.$fila, $DatAlmacenMovimientoEntrada->PrvNombreCompleto);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->getFont()->setBold(false)->setSize(12);	
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G'.$fila, $DatAlmacenMovimientoEntrada->MonSimbolo);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getFont()->setBold(false)->setSize(12);	
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('H'.$fila, $DatAlmacenMovimientoEntrada->OcoId);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->getFont()->setBold(false)->setSize(12);	


					if($DatAlmacenMovimientoEntrada->NpaId == "NPA-10001"){


						$cantidad = $DatAlmacenMovimientoEntrada->AmoCantidadDia;
						
						if($DatAlmacenMovimientoEntrada->AmoCantidadDia <=30){
							$TotalCredito30 += $DatAlmacenMovimientoEntrada->AmoTotal;
						}else{
							$TotalCredito30Mas += $DatAlmacenMovimientoEntrada->AmoTotal;
						}
					
					}else{
						
						$cantidad = "";
						
						$TotalContado += $DatAlmacenMovimientoEntrada->AmoTotal;
					}
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('I'.$fila, $cantidad);
					$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->getFont()->setBold(false)->setSize(12);						
										

					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('J'.$fila, $DatAlmacenMovimientoEntrada->AmoFechaVencimiento);
					$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getFont()->setBold(false)->setSize(12);	
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('K'.$fila, $DatAlmacenMovimientoEntrada->AmoTotal);
					$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->getFont()->setBold(false)->setSize(12);	
					
							
					$ProveedorPagoMontoTotal = 0;

					switch($DatAlmacenMovimientoEntrada->AmoCancelado){
					
						case 1:
							$ProveedorPagoMontoTotal = $DatAlmacenMovimientoEntrada->AmoTotal;					
						break;
					
						case 2:
									
						break;	

					}
				
			
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('L'.$fila, $ProveedorPagoMontoTotal);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->getFont()->setBold(false)->setSize(12);	
										
					settype($DatAlmacenMovimientoEntrada->AmoTotal ,"float");
					settype($ProveedorPagoMontoTotal ,"float");
					
					$AlmacenMovimientoEntradaSaldo = round($DatAlmacenMovimientoEntrada->AmoTotal,2) - round($ProveedorPagoMontoTotal,2);
		
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('M'.$fila, $AlmacenMovimientoEntradaSaldo);
				$objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->getFont()->setBold(false)->setSize(12);	
				
				
				$estado  = "";
	
					if($DatAlmacenMovimientoEntrada->NpaId == "NPA-10001"){
						
						settype($DatAlmacenMovimientoEntrada->AmoTotal ,"float");
						settype($ProveedorPagoMontoTotal ,"float");
						
						
						if(($ProveedorPagoMontoTotal+1000) < ($DatAlmacenMovimientoEntrada->AmoTotal+1000)){
							if($DatAlmacenMovimientoEntrada->AmoCantidadDia<$DatAlmacenMovimientoEntrada->AmoDiaTranscurrido){
								
								$estado .= "VENCIDO ";
								$estado .= ($DatAlmacenMovimientoEntrada->AmoDiaTranscurrido - $DatAlmacenMovimientoEntrada->AmoCantidadDia)." dias";
								
							}else if ( ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) >= 1 and ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido) <=3 ){
								
								$estado .= "POR VENCER ";				
								$estado .= ($DatAlmacenMovimientoEntrada->AmoCantidadDia - $DatAlmacenMovimientoEntrada->AmoDiaTranscurrido)." dias";
				
							}else{
								
								$estado .= "VIGENTE ";
								
							}
						}
						
					}
					
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('N'.$fila, $estado);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$fila)->getFont()->setBold(false)->setSize(12);	

					$c++;		
					$fila++;	
					
					$Enviar = true;
					
					}
					
					
							
				}
				

				
				}
				
			}
			
			
			
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J49', $Total);
//$objPHPExcel->getActiveSheet()->getStyle('J49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Rename worksheet
//$objPHPExcel->getActiveSheet()->setTitle('FACTURAS POR PAGAR AL '.date("d/m/Y"));
$objPHPExcel->getActiveSheet()->setTitle('FACTURAS POR PAGAR AL ');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save("../generados/FACTURA_X_PAGAR_".date("d-m-Y").".xls");



if($Enviar){
	
	
	
	$mensaje .= "AVISO DE VENCIMIENTO DE FACTURAS:";	
	$mensaje .= "<br>";	
	$mensaje .= "<br>";	


	$mensaje .= "Fecha de aviso: <b>".date("d/m/Y")."</b>";	
	$mensaje .= "<br>";	
	
	
		
	$mensaje .= "Proveedor: <b>".$ProveedorNombre."</b>";	
	$mensaje .= "<br>";
		
	$mensaje .= "Num.Doc.: <b>".$ProveedorTipoDocumento."/".$ProveedorNumeroDocumento."</b>";	
	$mensaje .= "<br>";		
					
	
	
	$mensaje .= "<hr>";
	$mensaje .= "<br>";
	

	$InsCorreo = new ClsCorreo();	
//MtdEnviarCorreo($CorDestinatario,$CorRemitenteCorreo,$CorRemitenteNombre,$CorAsunto,$CorContenido,$oCorRutaAdjunto=NULL,$oCorAdjunto=NULL){
	$InsCorreo->MtdEnviarCorreo("aliendo@cyc.com.pe,lmoreano@cyc.com.pe,iquezada@cyc.com.pe,scanepam@cyc.com.pe,jblanco@cyc.com.pe","sistema@cyc.com.pe","C&C S.A.C.","AVISO: FACTURAS C/ CREDITO - ".$ProveedorNombre,$mensaje,"../generados/","FACTURA_X_PAGAR_".date("d-m-Y").".xls");

}

?>