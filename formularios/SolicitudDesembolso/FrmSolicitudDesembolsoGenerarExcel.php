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

require_once($InsPoo->MtdPaqLogistica().'ClsSolicitudDesembolso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsSolicitudDesembolsoDetalle.php');

$InsSolicitudDesembolso = new ClsSolicitudDesembolso();

$InsSolicitudDesembolso->SdsId = $GET_id;
$InsSolicitudDesembolso->MtdObtenerSolicitudDesembolso();

if($InsSolicitudDesembolso->MonId <> $EmpresaMonedaId){
	
	$InsSolicitudDesembolso->SdsMonto = ($InsSolicitudDesembolso->SdsMonto/$InsSolicitudDesembolso->SdsTipoCambio);
	
}

//deb($InsSolicitudDesembolso);
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

$objPHPExcel = $objReader->load("../../plantilla/TemSolicitudDesembolsoAutorizacion.xls");

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
										->setCellValue('D6', $InsSolicitudDesembolso->SdsFecha);
							$objPHPExcel->getActiveSheet()->getStyle('D6')->getFont()->setBold(true)->setSize(14);		
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D7', $InsSolicitudDesembolso->MonNombre);
							$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F7', $InsSolicitudDesembolso->SdsTipoCambio);
							$objPHPExcel->getActiveSheet()->getStyle('F7')->getFont()->setBold(false)->setSize(12);	
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D8', $InsSolicitudDesembolso->TgaNombre);
							$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F8', $InsSolicitudDesembolso->AreNombre);
							$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(false)->setSize(12);
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D9', $InsSolicitudDesembolso->SdsCliente);
							$objPHPExcel->getActiveSheet()->getStyle('D9')->getFont()->setBold(false)->setSize(12);
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D10', $InsSolicitudDesembolso->SdsVIN);
							$objPHPExcel->getActiveSheet()->getStyle('D10')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F10', $InsSolicitudDesembolso->SdsPlaca);
							$objPHPExcel->getActiveSheet()->getStyle('F10')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D11', $InsSolicitudDesembolso->PerNombre." ".$InsSolicitudDesembolso->PerApellidoPaterno." ".$InsSolicitudDesembolso->PerApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('D11')->getFont()->setBold(false)->setSize(12);
						
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D12', $InsSolicitudDesembolso->SdsDescripcion);
							$objPHPExcel->getActiveSheet()->getStyle('D12')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D14', $InsSolicitudDesembolso->SdsObservacionImpresa);
							$objPHPExcel->getActiveSheet()->getStyle('D12')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F11', $InsSolicitudDesembolso->FinId);
							$objPHPExcel->getActiveSheet()->getStyle('F11')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('E15', $InsSolicitudDesembolso->MonSimbolo);
							$objPHPExcel->getActiveSheet()->getStyle('E15')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F15', $InsSolicitudDesembolso->SdsMonto);
							$objPHPExcel->getActiveSheet()->getStyle('F15')->getFont()->setBold(false)->setSize(12);

// Rename worksheet
					$objPHPExcel->getActiveSheet()->setTitle($InsSolicitudDesembolso->SdsId);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save("../../generados/solicitud_desembolso/".$InsSolicitudDesembolso->SdsId.".xls");

//$objWriter->save(str_replace('.php', '.xls', __FILE__));




/*
<a href="<?php echo $InsSolicitudDesembolso->SdsId;?>.xls">DESCARGAR: <?php echo $InsSolicitudDesembolso->SdsId;?>.xls</a>
*/
header("Location: ../../generados/solicitud_desembolso/".$InsSolicitudDesembolso->SdsId.".xls");
?>