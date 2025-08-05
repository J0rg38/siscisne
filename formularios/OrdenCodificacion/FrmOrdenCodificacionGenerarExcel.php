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


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCodificacion.php');


$InsOrdenCodificacion = new ClsOrdenCodificacion();

$InsOrdenCodificacion->OciId = $GET_id;
$InsOrdenCodificacion->MtdObtenerOrdenCodificacion();

//deb($InsOrdenCodificacion);
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
$objPHPExcel = $objReader->load("../../plantilla/TemOrdenCodificacionGM.xls");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

				   
							   
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C13', $InsOrdenCodificacion->OciId);
$objPHPExcel->getActiveSheet()->getStyle('C13')->getFont()->setBold(true)->setSize(14);		


$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C14', $InsOrdenCodificacion->OciFecha);		
			
 $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C15', $InsOrdenCodificacion->OciHora);		  
			
 $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C16', $InsOrdenCodificacion->PerNombre.' '.$InsOrdenCodificacion->PerApellidoPaterno.' '.$InsOrdenCodificacion->PerApellidoMaterno);	
			
				
 $objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C17', $InsOrdenCodificacion->OciSolicitanteCargo);	
			
 $objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C18', $InsOrdenCodificacion->OciDealerSucursal);	
			
			
 $objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C19', $InsOrdenCodificacion->OciDescripcionPN);				
				
 $objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C20', $InsOrdenCodificacion->OciVIN);								

 $objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C21', $InsOrdenCodificacion->OciVehiculoModelo);	
			
 $objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C22', $InsOrdenCodificacion->OciVehiculoAnoFabricacion);	
			
			 $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C23', $InsOrdenCodificacion->OciVehiculoMotorCilindrada);				
									
if(!empty($InsOrdenCodificacion->OciFoto)){
	
	
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Thumb');
	$objDrawing->setDescription('Thumbnail Image');
	$objDrawing->setPath('../../subidos/orden_codificacion_fotos/'.$InsOrdenCodificacion->OciFoto);
	$objDrawing->setHeight(800);
	$objDrawing->setWidth(600);
	$objDrawing->setCoordinates('B27');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	
	
}


	
	
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Consulta Tecnica PN - GM ');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save("../../generados/".$InsOrdenCodificacion->OciId.".xls");

//$objWriter->save(str_replace('.php', '.xls', __FILE__));


if($GET_Enviado == 1){
	
	if($InsOrdenCodificacion->OciEstado == 1){

		if($InsOrdenCodificacion->MtdActualizarEstadoOrdenCodificacion($InsOrdenCodificacion->OciId,3)){
	
			//$InsOrdenCodificacion = new ClsOrdenCodificacion();
//			$InsOrdenCodificacion->OciId = $InsOrdenCodificacion->OciId;
//			$InsOrdenCodificacion->MtdObtenerOrdenCodificacion();
//			
//			if($InsOrdenCodificacion->MtdActualizarEstadoOrdenCodificacion($InsOrdenCodificacion->OciId,3)){
//				
//				$InsOrdenCodificacion->OciTotal += $InsOrdenCodificacion->PcoTotal;
//				
//				$InsOrdenCodificacion->MtdEditarOrdenCodificacionDato("OciTotal",$InsOrdenCodificacion->OciTotal,$InsOrdenCodificacion->OciId);
//			
//			}
			
		}

	}

}

/*
<a href="<?php echo $InsOrdenCodificacion->OciId;?>.xls">DESCARGAR: <?php echo $InsOrdenCodificacion->OciId;?>.xls</a>
*/
header("Location: ../../generados/".$InsOrdenCodificacion->OciId.".xls");
?>