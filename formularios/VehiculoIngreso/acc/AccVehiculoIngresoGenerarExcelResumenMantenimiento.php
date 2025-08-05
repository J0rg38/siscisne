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




$GET_VehiculoIngresoId = $_GET['VehiculoIngresoId'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');


$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoIngreso->EinId = $GET_VehiculoIngresoId;
$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);

$NOMBRE = "RESUMEN_MANTENIMIENTOS_".$InsVehiculoIngreso->EinVIN;
$ARCHIVO = $NOMBRE.".xls";
//deb($InsVehiculoIngreso);
$objPHPExcel = new PHPExcel();
					
	$objReader = PHPExcel_IOFactory::createReader('Excel5');
	$objPHPExcel = $objReader->load($InsPoo->Ruta."plantilla/TemResumenMantenimientos.xls");
	
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			 ->setLastModifiedBy("Maarten Balliauw")
			 ->setTitle("PHPExcel Test Document")
			 ->setSubject("PHPExcel Test Document")
			 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
			 ->setKeywords("office PHPExcel php")
			 ->setCategory("Test result file");
	
	// Miscellaneous glyphs, UTF-8
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B3', 'RESUMEN DE MANTENIMIENTOS');
	$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true)->setSize(14);
								   
	
	$objPHPExcel->getActiveSheet()->getStyle('B6')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B6', 'VIN:');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C6', $InsVehiculoIngreso->EinVIN);
				
	$objPHPExcel->getActiveSheet()->getStyle('D6')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('D6', 'FECHA:');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('E6', date("d/m/Y"));
				
				
	$objPHPExcel->getActiveSheet()->getStyle('B7')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B7', 'PLACA:');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C7', $InsVehiculoIngreso->EinPlaca);
				
				
				
				
				
	$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B8', 'MARCA:');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C8', $InsVehiculoIngreso->VmaNombre);	
	
	$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('D8', 'MODELO:');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('E8', $InsVehiculoIngreso->VmoNombre);	
				
				
						
	$objPHPExcel->getActiveSheet()->getStyle('B9')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B9', 'VERSION:');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C9', $InsVehiculoIngreso->VveNombre);	
	
				
	$InsFichaIngreso = new ClsFichaIngreso();
	//MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oVehiculoMarca=NULL) {
	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("EinVIN","esigual",$InsVehiculoIngreso->EinVIN,"FinFecha","DESC",NULL,NULL,NULL,NULL,NULL,"MIN-10001");
	$ArrFichaIngresos = $ResFichaIngreso['Datos'];
										
	$fila = 12;			
	if(!empty($ArrFichaIngresos)){
		foreach($ArrFichaIngresos as $DatFichaIngreso){
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $DatFichaIngreso->FinId);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatFichaIngreso->FinFecha);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila, $DatFichaIngreso->FinVehiculoKilometraje);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatFichaIngreso->FinMantenimientoKilometraje);
			
			$fila++;
		}
		
	}
	


$objPHPExcel->getActiveSheet()->setTitle("RESUMEN DE MANTENIMIENTOS");
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save($oRuta."generados/".$this->OcoId.".xls");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$ARCHIVO.'"');
header('Cache-Control: max-age=0');

$objWriter->save('php://output');
					
							
?>