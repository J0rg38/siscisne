<?php
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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


$GET_id = $_GET['Id'];



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
//require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
//require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');


$InsOrdenCompra = new ClsOrdenCompra();

$InsOrdenCompra->OcoId = $GET_id;
$InsOrdenCompra->MtdObtenerOrdenCompra();

//deb($InsOrdenCompra);
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
$objPHPExcel = $objReader->load("plantilla/TemOrdenCompra.xls");

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
            ->setCellValue('F8', 'ORDEN DE COMPRA PERU - C&C');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F9', $InsOrdenCompra->OcoId);
			

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C12', 'Codigo Dealer:');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D12', '8001200006');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C13', 'Fecha:');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D13', $InsOrdenCompra->OcoFecha);

			
//$objPHPExcel->getActiveSheet()->getStyle("G8")->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle("G8")->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->getStyle("C12")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle("D12")->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->getStyle("C13")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle("D13")->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);


$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C14', 'Hora:');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D14', $InsOrdenCompra->OcoHora);						
					
					
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B19', '#');		
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C19', 'GM Part Number');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D19', 'GM PN Replace');		
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E19', 'Cantidad de Pedido');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F19', 'Partes a Atender');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G19', 'B/O');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H19', 'Descripcion');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I19', 'Año');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J19', 'Modelo');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K19', 'Precio');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L19', 'Total');
			



$objPHPExcel->getActiveSheet()->getStyle('B19:L19')->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('argb' => 'CCCCCCCC')
							),
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
								
								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
								'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
							)
		 )
	);




$fila = 20;
$indice = 1;


$Total = 0;
foreach($InsOrdenCompra->OrdenCompraDetalle as $DatOrdenCompraDetalle){

	if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
		$DatOrdenCompraDetalle->OcdImporte = round($DatOrdenCompraDetalle->OcdImporte / $InsOrdenCompra->OcoTipoCambio,2);
		$DatOrdenCompraDetalle->OcdPrecio = round($DatOrdenCompraDetalle->OcdPrecio  / $InsOrdenCompra->OcoTipoCambio,2);
	}
			
			
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $indice);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatOrdenCompraDetalle->OcdCodigoOtro);
;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatOrdenCompraDetalle->OcdCantidad);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatOrdenCompraDetalle->ProNombre);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatOrdenCompraDetalle->OcdAno);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatOrdenCompraDetalle->OcdModelo);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $DatOrdenCompraDetalle->OcdPrecio);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $DatOrdenCompraDetalle->OcdImporte);
	
	$Total += $DatOrdenCompraDetalle->OcdImporte;
	
	$fila++;
	$indice++;
}




$objPHPExcel->getActiveSheet()->getStyle('B20:L'.$fila)->applyFromArray(
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
//	array('fill' 	=> array(
//								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
//								'color'		=> array('argb' => 'FFFFFF00')
//							),
//		 )
//	);
	
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, "TOTAL:");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $Total);

//foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
//	
////	$InsPedidoCompra = new ClsPedidoCompra();
////	$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
////	$InsPedidoCompra->MtdObtenerPedidoCompra();
////	
////	foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
////
////		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $indice);
////		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatPedidoCompraDetalle->OcdCodigoOtro);
////		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatPedidoCompraDetalle->OcdCantidad);
////		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatPedidoCompraDetalle->ProNombre);
////		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $DatPedidoCompraDetalle->OcdPrecio);
////		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $DatPedidoCompraDetalle->OcdImporte);
////
////	}
//
//}


//$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
//$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
//$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Ord. Comp. GM ');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($InsOrdenCompra->OcoId.".xls");

//$objWriter->save(str_replace('.php', '.xls', __FILE__));
?>


<a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>