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

require_once($InsPoo->MtdPaqActividad().'ClsReclamo.php');
require_once($InsPoo->MtdPaqActividad().'ClsReclamoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsReclamoFoto.php');


$InsReclamo = new ClsReclamo();

$InsReclamo->RecId = $GET_id;
$InsReclamo->MtdObtenerReclamo();

//deb($InsReclamo);
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
$objPHPExcel = $objReader->load("../../plantilla/TemReclamoOtro.xls");

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
            ->setCellValue('G3', $InsReclamo->RecCodigoReclamo);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true)->setSize(14);
				   
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C12', $InsReclamo->RecFechaEmision);
$objPHPExcel->getActiveSheet()->getStyle('C12')->getFont()->setBold(true)->setSize(14);		
							   
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C9', $InsReclamo->PrvNombre.' '.$InsReclamo->PrvApellidoPaterno.' '.$InsReclamo->PrvApellidoMaterno);
$objPHPExcel->getActiveSheet()->getStyle('C9')->getFont()->setBold(true)->setSize(14);		

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C15', $InsReclamo->MonNombre);
$objPHPExcel->getActiveSheet()->getStyle('C15')->getFont()->setBold(true)->setSize(14);		

switch($InsReclamo->PrvNombre){
	
	case "F":
	
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('K9','X');
		$objPHPExcel->getActiveSheet()->getStyle('K9')->getFont()->setBold(true)->setSize(14);	
			
	break;
	
	case "S":
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('K11','X');
		$objPHPExcel->getActiveSheet()->getStyle('K11')->getFont()->setBold(true)->setSize(14);	
		
	break;
	
	case "D":
	
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('K13','X');
		$objPHPExcel->getActiveSheet()->getStyle('K13')->getFont()->setBold(true)->setSize(14);	
		
	break;
	
	case "E":
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('K15','X');
		$objPHPExcel->getActiveSheet()->getStyle('K15')->getFont()->setBold(true)->setSize(14);	
	break;
	
}





$fila = 34;
$Total = 0;
$Comentarios = "";
if(!empty($InsReclamo->ReclamoDetalle)){
	foreach($InsReclamo->ReclamoDetalle as $DatReclamoDetalle){
		
		if($InsReclamo->MonId<>$EmpresaMonedaId){
			
			$DatReclamoDetalle->RdePrecioUnitario = round($DatReclamoDetalle->RdePrecioUnitario / $InsReclamo->RecTipoCambio,2);
			$DatReclamoDetalle->RdeMonto = round($DatReclamoDetalle->RdeMonto  / $InsReclamo->RecTipoCambio,2);
			
		}
						
		
				
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatReclamoDetalle->AmoComprobanteNumero);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila, $DatReclamoDetalle->AmoComprobanteFecha);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatReclamoDetalle->ProCodigoOriginal);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila, $DatReclamoDetalle->OcoTipo);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila, $DatReclamoDetalle->AmdCantidad);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatReclamoDetalle->RdeCantidad);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatReclamoDetalle->RdePrecioUnitario);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatReclamoDetalle->RdeMonto);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $DatReclamoDetalle->RdeObservacion);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
	
		$Comentarios .= $DatReclamoDetalle->ProCodigoOriginal." / ";
				
				$Total += $DatReclamoDetalle->RdeMonto;
				
				$fila++;
				
			
		
	}
	
}


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J49', $Total);
$objPHPExcel->getActiveSheet()->getStyle('J49')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);




// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('RECLAMO Nro. '.$InsReclamo->RecId);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Thumb');
	$objDrawing->setDescription('Thumbnail Image');
	$objDrawing->setPath('../../imagenes/gm_logo.png');
	$objDrawing->setHeight(90);
	$objDrawing->setWidth(90);
	$objDrawing->setCoordinates('A1');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	
	

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');


$objPHPExcel->setActiveSheetIndex(1);


$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Thumb');
	$objDrawing->setDescription('Thumbnail Image');
	$objDrawing->setPath('../../imagenes/gm_logo.png');
	$objDrawing->setHeight(90);
	$objDrawing->setWidth(90);
	$objDrawing->setCoordinates('A1');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	
	
$foto = 1;
$desplazo =11;
$desplazo2 =29;

if(!empty($InsReclamo->AmoFoto)){
//	
	$foto = 2;


	$extension = strtolower(pathinfo($InsReclamo->AmoFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($InsReclamo->AmoFoto, '.'.$extension);  
	
	if($extension == "pdf"){
		
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A11',"No se pudo adjuntar la factura: ".$InsReclamo->AmoFoto);
		
	}else{
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Thumb');
		$objDrawing->setDescription('Thumbnail Image');
		$objDrawing->setPath('../../subidos/almacen_movimiento_entrada_fotos/'.$InsReclamo->AmoFoto);
		$objDrawing->setHeight(450);
		$objDrawing->setWidth(300);
		$objDrawing->setCoordinates('A11');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			
	}
	

	

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B29', "Nro. Ped.:: ".$InsReclamo->OcoId);
	
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A30', "Fact.:".$InsReclamo->AmoComprobanteNumero);

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A31', "".$Comentarios);
	
}


if(!empty($InsReclamo->ReclamoFoto)){
	foreach($InsReclamo->ReclamoFoto as $DatReclamoFoto){
		
		if($foto%2==0){
			
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('Thumb');
				$objDrawing->setDescription('Thumbnail Image');
				$objDrawing->setPath('../../subidos/reclamo_fotos/'.$DatReclamoFoto->RfoArchivo);
				$objDrawing->setHeight(450);
				$objDrawing->setWidth(300);
				$objDrawing->setCoordinates('G'.$desplazo);
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
				
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.($desplazo2), "Nro. Ped.: ".$InsReclamo->OcoId);
				//$objPHPExcel->getActiveSheet()->getStyle('H'.$desplazo2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.($desplazo2+1), "Fact.:".$InsReclamo->AmoComprobanteNumero);
				//$objPHPExcel->getActiveSheet()->getStyle('G'.$desplazo2+1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.($desplazo2+2), $Comentarios);

				$desplazo = $desplazo+23;
				$desplazo2 = $desplazo2 + 23;
		}else{
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('Thumb');
				$objDrawing->setDescription('Thumbnail Image');
				$objDrawing->setPath('../../subidos/reclamo_fotos/'.$DatReclamoFoto->RfoArchivo);
				$objDrawing->setHeight(450);
				$objDrawing->setWidth(300);
				$objDrawing->setCoordinates('A'.$desplazo);
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
				
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.($desplazo2), "Nro. Ped.:: ".$InsReclamo->OcoId);
				//$objPHPExcel->getActiveSheet()->getStyle('B'.$desplazo2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.($desplazo2+1), "Fact.:".$InsReclamo->AmoComprobanteNumero);
				//$objPHPExcel->getActiveSheet()->getStyle('A'.$desplazo2+1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.($desplazo2+2), "".$Comentarios);

		}
	
			
				
			
		
		$foto++;
	}
}




$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save("../../generados/".$InsReclamo->RecId.".xls");

/*
<a href="<?php echo $InsReclamo->OcoId;?>.xls">DESCARGAR: <?php echo $InsReclamo->OcoId;?>.xls</a>
*/
header("Location: ../../generados/".$InsReclamo->RecId.".xls");
?>