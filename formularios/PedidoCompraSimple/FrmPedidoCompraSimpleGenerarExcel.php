<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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


require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

$GET_id = $_GET['Id'];
$GET_Enviado = $_GET['Enviado'];

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');


$InsPedidoCompra = new ClsPedidoCompra();

$InsPedidoCompra->PcoId = $GET_id;
$InsPedidoCompra->MtdObtenerPedidoCompra();

//deb($InsPedidoCompra);
/** Error reporting */
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
//date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objReader = PHPExcel_IOFactory::createReader('Excel5');

$objPHPExcel = $objReader->load("../../plantilla/TemPedidoCompraOtro.xls");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K6', $InsPedidoCompra->PcoId);
$objPHPExcel->getActiveSheet()->getStyle('K6')->getFont()->setBold(true)->setSize(14);
	
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K8', $InsPedidoCompra->PcoFecha);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E8', $InsPedidoCompra->PrvNombre.' '.$InsPedidoCompra->PrvApellidoPaterno.' '.$InsPedidoCompra->PrvApellidoMaterno);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E9', $InsPedidoCompra->TdoNombre.'/'.$InsPedidoCompra->PrvNumeroDocumento);			
				
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E10', $InsPedidoCompra->MonNombre);			
	


$fila = 15;
$indice = 1;

$Total = 0;
if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
	foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
		

			
		if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
			$DatPedidoCompraDetalle->PcdImporte = round($DatPedidoCompraDetalle->PcdImporte / $DatPedidoCompraDetalle->PcoTipoCambio,2);
			$DatPedidoCompraDetalle->PcdPrecio = round($DatPedidoCompraDetalle->PcdPrecio  / $DatPedidoCompraDetalle->PcoTipoCambio,2);
		}
		
		
				//BB
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $indice);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
												'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
											)
						 )
					);
				
		
				//CC
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatPedidoCompraDetalle->PcdCodigo);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
										
											)
						 )
					);
					
				
				//DD
				$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
										
											)
						 )
					);
				//EE	
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatPedidoCompraDetalle->ProNombre);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
											)
						 )
					);
					
				//FF
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila, $DatPedidoCompraDetalle->PcdCantidad);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
											)
						 )
					);
					
				//GG
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila, $DatPedidoCompraDetalle->UmeNombre);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
											)
						 )
					);
				
				//HH	
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatPedidoCompraDetalle->PcdPrecio);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
											)
						 )
					);
					
				//II
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatPedidoCompraDetalle->PcdImporte);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
											)
						 )
					);
				//JJ	
					$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
											)
						 )
					);
					
				//KK
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $DatPedidoCompraDetalle->PcdObservacion);
				$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
												'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
											)
						 )
					);	
					
				
				$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
				
				$fila++;
				$indice++;
			
			

		
	}
	
}

	if($InsPedidoCompra->PcoIncluyeImpuesto==2){
		$SubTotal = round($TotalBruto,6);
		$Impuesto = round(($SubTotal * ($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)),6);
		$Total = round($SubTotal + $Impuesto,6);
	}else{
		$Total = round($TotalBruto,6);	
		$SubTotal = round($Total / (($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)+1),6);
		$Impuesto = round(($Total - $SubTotal),6);
	}
	
	
$fila = $fila + 3;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E11', $InsPedidoCompra->PcoObservacionImpresa);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, "SUBTOTAL:");
$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, number_format($SubTotal,2));

$fila = $fila + 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, "IMPUESTO:");
$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, number_format($Impuesto,2));

$fila = $fila + 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, "TOTAL:");
$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, number_format($Total,2));


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle($InsPedidoCompra->PcoId);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save("../../generados/".$InsPedidoCompra->PcoId.".xls");

//$objWriter->save(str_replace('.php', '.xls', __FILE__));

/*
<a href="<?php echo $InsPedidoCompra->PcoId;?>.xls">DESCARGAR: <?php echo $InsPedidoCompra->PcoId;?>.xls</a>
*/
header("Location: ../../generados/".$InsPedidoCompra->PcoId.".xls");
?>