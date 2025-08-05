<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');




$POST_finicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:date("d/m/Y");
$POST_ffin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['CmpOrden'])?$_GET['CmpOrden']:"EinFichaIngresoFechaPredecida";
$POST_sen = isset($_GET['CmpSentido'])?$_GET['CmpSentido']:"DESC";

$POST_VehiculoMarca = isset($_GET['VehiculoMarca'])?$_GET['VehiculoMarca']:"";

require_once($InsPoo->MtdPaqReporte().'ClsReportePredictivoMantenimiento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

$InsReportePredictivoMantenimiento = new ClsReportePredictivoMantenimiento();
$InsVehiculoMarca = new ClsVehiculoMarca();
//MtdObtenerReportePredictivoMantenimientos($oFechaInicio=NULL,$oFechaFin=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL){

if(!empty($POST_VehiculoMarca)){
	
	$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
	$InsVehiculoMarca->MtdObtenerVehiculoMarca();
	$VehiculoMarcaNombre = strtoupper($InsVehiculoMarca->VmaNombre);
	
}


$ResReportePredictivoMantenimiento = $InsReportePredictivoMantenimiento->MtdObtenerReportePredictivoMantenimientos(FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_ord,$POST_sen,NULL,$POST_VehiculoMarca,NULL);
$ArrReportePredictivoMantenimientos = $ResReportePredictivoMantenimiento['Datos'];


$NOMBRE = "PREDICTIVO_MANTENIMIENTOS_ENVIAR_SMS_".FncCambiaFechaAMysql($POST_finicio)."-".FncCambiaFechaAMysql($POST_ffin);
$ARCHIVO = $NOMBRE.".xls";
//deb($InsVehiculoIngreso);
$objPHPExcel = new PHPExcel();
					
	$objReader = PHPExcel_IOFactory::createReader('Excel5');
	$objPHPExcel = $objReader->load($InsPoo->Ruta."plantilla/TemGeneral.xls");
	
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			 ->setLastModifiedBy("Maarten Balliauw")
			 ->setTitle("PHPExcel Test Document")
			 ->setSubject("PHPExcel Test Document")
			 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
			 ->setKeywords("office PHPExcel php")
			 ->setCategory("Test result file");
	
	
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'MteReferencia');

	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B1', 'MteFecha');

	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C1', 'MteDestino');
				
	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('D1', 'MteContenido');

	$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('E1', 'MteEstado');
				
				
	$objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('F1', 'MteTiempoCreacion');				
				
	$objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('G1', 'MteTiempoModificacion');		
		
										
	$fila = 2;			
	if(!empty($ArrReportePredictivoMantenimientos)){
		foreach($ArrReportePredictivoMantenimientos as $DatReportePredictivoMantenimiento){
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$fila, $DatReportePredictivoMantenimiento->EinVIN);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, date("Y-m-d"));
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatReportePredictivoMantenimiento->CliCelular);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila, (empty($VehiculoMarcaNombre)?"CYC":$VehiculoMarcaNombre)." te informa que esta proximo tu mantenimiento de vehiculo, separa tu cita a los numeros 950312564 y 950309755");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, 1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila, date("Y-m-d H:i:s"));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila, date("Y-m-d H:i:s"));
			
			$fila++;
		}
		
	}
	


$objPHPExcel->getActiveSheet()->setTitle("tblmtemensajetexto");
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save($oRuta."generados/".$this->OcoId.".xls");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$ARCHIVO.'"');
header('Cache-Control: max-age=0');

$objWriter->save('php://output');
					
							
?>