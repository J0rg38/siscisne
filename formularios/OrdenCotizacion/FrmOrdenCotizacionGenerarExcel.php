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


require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');



$GET_id = $_GET['Id'];
$GET_Enviado = $_GET['Enviado'];


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacionDetalle.php');

$InsOrdenCotizacion = new ClsOrdenCotizacion();

$InsOrdenCotizacion->OotId = $GET_id;
$InsOrdenCotizacion->MtdObtenerOrdenCotizacion();

//deb($InsOrdenCotizacion);
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
$objPHPExcel = $objReader->load("../../plantilla/TemOrdenCotizacion".(($InsOrdenCotizacion->OotTipo<>"ALM")?"GM":"").".xls");

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
            ->setCellValue('F8', 'COTIZACION - C&C');
$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true)->setSize(14);
			
															   
							   
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F9', $InsOrdenCotizacion->OotId);
$objPHPExcel->getActiveSheet()->getStyle('F9')->getFont()->setBold(true)->setSize(14);		


//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('C11', 'CÓDIGO SAP');
$objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
	
	
	
	
	
	
$objPHPExcel->getActiveSheet()->getStyle('D11')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
	
$objPHPExcel->getActiveSheet()->getStyle('E11')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
			
			
			
			
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('C12', 'Codigo Dealer');
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('E12', '8001200006');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C13', 'Fecha');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E13', $InsOrdenCotizacion->OotFecha);


$objPHPExcel->getActiveSheet()->getStyle('C12')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
	
	
$objPHPExcel->getActiveSheet()->getStyle('D12')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
	
$objPHPExcel->getActiveSheet()->getStyle('E12')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
	
	
	
	
	
	
$objPHPExcel->getActiveSheet()->getStyle('C13')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
	
$objPHPExcel->getActiveSheet()->getStyle('D13')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
	
	
$objPHPExcel->getActiveSheet()->getStyle('E13')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);


	



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
            ->setCellValue('C14', 'Hora');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E14', $InsOrdenCotizacion->OotHora);						
		
		
$objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
	
	
$objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
	

$objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);	
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
					
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('B17', '#');		

//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('C16', 'DEALER');					
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('C17', 'GM Part Number');
$objPHPExcel->getActiveSheet()->getStyle('C17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
$objPHPExcel->getActiveSheet()->getStyle('C17')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								
								
								
								
	
	
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('D17', 'GM PN Replace');		
$objPHPExcel->getActiveSheet()->getStyle('D17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
$objPHPExcel->getActiveSheet()->getStyle('D17')->getFont()->setBold(true);	
$objPHPExcel->getActiveSheet()->getStyle('D17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								                             
	
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('E16', 'DEALER');
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('E17', 'Cantidad de Pedido');
$objPHPExcel->getActiveSheet()->getStyle('E17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
$objPHPExcel->getActiveSheet()->getStyle('E17')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 							   
							  
							   	
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('F16', 'GM');
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('F17', 'Partes a Atender');
$objPHPExcel->getActiveSheet()->getStyle('F17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
$objPHPExcel->getActiveSheet()->getStyle('F17')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							   
							   			
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('G16', 'GM');	
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('G17', 'B/O');
$objPHPExcel->getActiveSheet()->getStyle('G17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);

$objPHPExcel->getActiveSheet()->getStyle('G17')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

							   	
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('H16', 'GM');			
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('H17', 'Descripcion');
$objPHPExcel->getActiveSheet()->getStyle('H17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
$objPHPExcel->getActiveSheet()->getStyle('H17')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							   
							   
							   				
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('I17', 'Año');
$objPHPExcel->getActiveSheet()->getStyle('I17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
$objPHPExcel->getActiveSheet()->getStyle('I17')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('I17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
							   
							   				
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('J17', 'Modelo');
$objPHPExcel->getActiveSheet()->getStyle('J17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
$objPHPExcel->getActiveSheet()->getStyle('J17')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('J17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
							   
	
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('K16', 'GM');	
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('K17', 'Precio');
$objPHPExcel->getActiveSheet()->getStyle('K17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);
$objPHPExcel->getActiveSheet()->getStyle('K17')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('K17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   							   
							   
							   				
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('L17', 'Total');
$objPHPExcel->getActiveSheet()->getStyle('L17')->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
								'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
							)
		 )
	);			
$objPHPExcel->getActiveSheet()->getStyle('L17')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('L17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

















$objPHPExcel->getActiveSheet()->getStyle('C17:L17')->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('rgb' => '8DB4E3')
							)
		  						
		 )
	);






$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G14', 'Notas:');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H14', $InsOrdenCotizacion->OotObservacion);
			
			
			


$fila = 18;
$indice = 1;



$Total = 0;
if(!empty($InsOrdenCotizacion->OrdenCotizacionDetalle)){
	foreach($InsOrdenCotizacion->OrdenCotizacionDetalle as $DatOrdenCotizacionDetalle){

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatOrdenCotizacionDetalle->ProCodigoOriginal);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
		array('fill' 	=> array(
									'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
									'color'		=> array('rgb' => '8DB4E3')
								)
									
			 )
		);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//D
		
		$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		
		
		
		
		//E
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatOrdenCotizacionDetalle->OodCantidad);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		
		//F
		
		$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		
		//G
		
		$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		
		//H
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatOrdenCotizacionDetalle->ProNombre);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		
		
		//I
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatOrdenCotizacionDetalle->OodAno);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		
		//J
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatOrdenCotizacionDetalle->OodModelo);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		
		
		//K
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, 0);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
		array('fill' 	=> array(
									'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
									'color'		=> array('rgb' => '8DB4E3')
								)
									
			 )
		);
		
		
		//L
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, 0);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
									'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
		array('fill' 	=> array(
									'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
									'color'		=> array('rgb' => '8DB4E3')
								)
									
			 )
		);
		
		
		$fila++;
		$indice++;
		
		
		
		}
		
		}
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$fila.':K'.$fila)->applyFromArray(
		array(
			  'borders' => array(
									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
								)
			 )
		);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
		array('fill' 	=> array(
									'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
									'color'		=> array('rgb' => '8DB4E3')
								)
									
			 )
		);


//
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
	
//$objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':L'.$fila)->applyFromArray(
//	array('fill' 	=> array(
//								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
//								'color'		=> array('argb' => 'FFFFFF00')
//							),
//		 )
//	);
	
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, "TOTAL:");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $Total);

				$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
					array(
						  'borders' => array(
												'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
												'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
												'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
												'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
											)
						 )
					);

//$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
//$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
//$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Cotizacion GM ');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save("../../generados/".$InsOrdenCotizacion->OotId.".xls");

//$objWriter->save(str_replace('.php', '.xls', __FILE__));



if($GET_Enviado == 1){
	
	if($InsOrdenCotizacion->OotEstado == 1){

		if($InsOrdenCotizacion->MtdActualizarEstadoOrdenCotizacion($InsOrdenCotizacion->OotId,3)){
	
			//$InsOrdenCotizacion = new ClsOrdenCotizacion();
//			$InsOrdenCotizacion->OotId = $InsOrdenCotizacion->OotId;
//			$InsOrdenCotizacion->MtdObtenerOrdenCotizacion();
//			
//			if($InsOrdenCotizacion->MtdActualizarEstadoOrdenCotizacion($InsOrdenCotizacion->OotId,3)){
//				
//				$InsOrdenCotizacion->OotTotal += $InsOrdenCotizacion->PcoTotal;
//				
//				$InsOrdenCotizacion->MtdEditarOrdenCotizacionDato("OotTotal",$InsOrdenCotizacion->OotTotal,$InsOrdenCotizacion->OotId);
//			
//			}
			
		}

	}

}

/*
<a href="<?php echo $InsOrdenCotizacion->OotId;?>.xls">DESCARGAR: <?php echo $InsOrdenCotizacion->OotId;?>.xls</a>
*/
header("Location: ../../generados/".$InsOrdenCotizacion->OotId.".xls");
?>