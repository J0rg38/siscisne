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


require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnico.php');
require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnicoOperacion.php');
require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnicoProducto.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsInformeTecnico = new ClsInformeTecnico();
$InsPersonal = new ClsPersonal();
$InsFichaIngreso = new ClsFichaIngreso();

$InsInformeTecnico->IteId = $GET_id;
$InsInformeTecnico->MtdObtenerInformeTecnico();	
//

//deb($InsInformeTecnico->FinId);
$InsFichaIngreso->FinId = $InsInformeTecnico->FinId ;
$InsFichaIngreso->MtdObtenerFichaIngreso(false);


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
//$objPHPExcel = $objReader->load("../../plantilla/TemInformeTecnicoATS3.xls");
$objPHPExcel = $objReader->load("../../plantilla/TemInformeTecnicoATS3.xls");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

// Miscellaneous glyphs, UTF-8
//$objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('F8', 'INFORME TECNICO ATS3S - C&C S.A.C.');
//$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H5', $InsInformeTecnico->IteId);
$objPHPExcel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true)->setSize(14);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C6', $InsInformeTecnico->IteSedeLocal);
$objPHPExcel->getActiveSheet()->getStyle('C6')->getFont()->setBold(false)->setSize(14);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H6', $InsInformeTecnico->IteFecha);
$objPHPExcel->getActiveSheet()->getStyle('H6')->getFont()->setBold(true)->setSize(14);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C7', $InsInformeTecnico->IteContactoGM);
$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(false)->setSize(14);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H7', $InsInformeTecnico->IteFechaVenta);
$objPHPExcel->getActiveSheet()->getStyle('H7')->getFont()->setBold(false)->setSize(14);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C8', $InsInformeTecnico->EinVIN);
$objPHPExcel->getActiveSheet()->getStyle('C8')->getFont()->setBold(false)->setSize(14);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H8', $InsInformeTecnico->EinPlaca);
$objPHPExcel->getActiveSheet()->getStyle('H8')->getFont()->setBold(false)->setSize(14);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C9', $InsInformeTecnico->VmaNombre." ".$InsInformeTecnico->VmoNombre." ".$InsInformeTecnico->VveNombre);
$objPHPExcel->getActiveSheet()->getStyle('C9')->getFont()->setBold(false)->setSize(14);	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H9', $InsInformeTecnico->FinVehiculoKilometraje);
$objPHPExcel->getActiveSheet()->getStyle('H9')->getFont()->setBold(false)->setSize(14);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A13', $InsInformeTecnico->IteCondicion);
$objPHPExcel->getActiveSheet()->getStyle('A13')->getFont()->setBold(false)->setSize(14);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A21', $InsInformeTecnico->IteCausa);
$objPHPExcel->getActiveSheet()->getStyle('A21')->getFont()->setBold(false)->setSize(14);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A29', $InsInformeTecnico->IteCorreccion);
$objPHPExcel->getActiveSheet()->getStyle('A29')->getFont()->setBold(false)->setSize(14);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A37', $InsInformeTecnico->IteConclusion);
$objPHPExcel->getActiveSheet()->getStyle('A37')->getFont()->setBold(false)->setSize(14);

if($InsInformeTecnico->IteSolucionSatisfactoria == "1"){
	
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G43', 'X');
$objPHPExcel->getActiveSheet()->getStyle('G43')->getFont()->setBold(false)->setSize(14);

}else{

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('I43', 'X');
	$objPHPExcel->getActiveSheet()->getStyle('I43')->getFont()->setBold(false)->setSize(14);
	
}


$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C45', $InsInformeTecnico->PerNombre.' '.$InsInformeTecnico->PerApellidoPaterno.' '.$InsInformeTecnico->PerApellidoMaterno);
$objPHPExcel->getActiveSheet()->getStyle('C45')->getFont()->setBold(false)->setSize(14);

$objPHPExcel->setActiveSheetIndex(1);

if(!empty($InsFichaIngreso->FinFotoVIN)){
	
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Thumb');
	$objDrawing->setDescription('Thumbnail Image');
	$objDrawing->setPath('../../subidos/ficha_ingreso_fotos/'.$InsFichaIngreso->FinFotoVIN);
	$objDrawing->setHeight(100);
	$objDrawing->setWidth(100);
	$objDrawing->setCoordinates('A7');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	
}

						
if(!empty($InsFichaIngreso->FinFotoFrontal)){
	
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Thumb');
	$objDrawing->setDescription('Thumbnail Image');
	$objDrawing->setPath('../../subidos/ficha_ingreso_fotos/'.$InsFichaIngreso->FinFotoFrontal);
	$objDrawing->setHeight(100);
	$objDrawing->setWidth(100);
	$objDrawing->setCoordinates('D7');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());		
	
}

if(!empty($InsFichaIngreso->FinFotoCupon)){
	
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Thumb');
	$objDrawing->setDescription('Thumbnail Image');
	$objDrawing->setPath('../../subidos/ficha_ingreso_fotos/'.$InsFichaIngreso->FinFotoCupon);
	$objDrawing->setHeight(100);
	$objDrawing->setWidth(100);
	$objDrawing->setCoordinates('A30');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());	
	
}

if(!empty($InsFichaIngreso->FinFotoMantenimiento)){
	
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Thumb');
	$objDrawing->setDescription('Thumbnail Image');
	$objDrawing->setPath('../../subidos/ficha_ingreso_fotos/'.$InsFichaIngreso->FinFotoMantenimiento);
	$objDrawing->setHeight(100);
	$objDrawing->setWidth(100);
	$objDrawing->setCoordinates('E30');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());	

}

if(!empty($InsInformeTecnico->FinId)){
	
	$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
	$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$InsInformeTecnico->FinId,NULL);
	$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];

	if(!empty($ArrFichaIngresoModalidades)){
		foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
			
			$InsFichaAccion = new ClsFichaAccion();
			$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatFichaIngresoModalidad->FimId,NULL,NULL,NULL);
			$ArrFichaAcciones = $ResFichaAccion['Datos'];
			
			if(!empty($ArrFichaAcciones)){
				foreach($ArrFichaAcciones as $DatFichaAccion){
						
				  	$InsFichaAccionFoto = new ClsFichaAccionFoto();
					$ResFichaAccionFoto = $InsFichaAccionFoto->MtdObtenerFichaAccionFotos(NULL,NULL,'FafId','ASC',NULL,$DatFichaAccion->FccId,NULL);
					$ArrFichaAccionFotos = $ResFichaAccionFoto['Datos'];
					  
					  
						$columna = 10;
						$fila = 7;
						$foto = 1;
						if(!empty($ArrFichaAccionFotos)){
							foreach($ArrFichaAccionFotos as $DatFichaAccionFoto){
			
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName('Thumb');
								$objDrawing->setDescription('Thumbnail Image');
								$objDrawing->setPath('../../subidos/ficha_accion_fotos/'.$DatFichaAccionFoto->FafArchivo);
								$objDrawing->setHeight(100);
								$objDrawing->setWidth(100);
								$objDrawing->setCoordinates(FncConvertirNumeroALetraExcel($columna).$fila);
								$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
									
								if($foto%3==0){
									$fila = $fila + 3;
									$columna = 10;
								}
								
								$columna = $columna + 3;
								$foto++;
			
							}
						}	
						
						
				}
			}
						
		}
		
	}
}




	//SesionObjeto-InsInformeTecnicoATS3Operacion
	//Parametro1 = ItoId
	//Parametro2 = ItoNumero
	//Parametro3 = ItoTiempo
	//Parametro4 = ItoCostoHora
	//Parametro5 = ItoValorTotal
	//Parametro6 = ItoEstado
	//Parametro7 = ItoTiempoCreacion
	//Parametro8 = ItoTiempoModificacion
	//Parametro9 = FaeId
				
	$objPHPExcel->setActiveSheetIndex(2);		
				
	$fila = 19;
	
	if(!empty($InsInformeTecnico->InformeTecnicoOperacion)){
		foreach($InsInformeTecnico->InformeTecnicoOperacion as $DatInformeTecnicoOperacion){
	
			if($InsInformeTecnico->MonId<>$EmpresaMonedaId ){
	
				$DatInformeTecnicoOperacion->ItoCostoHora = round($DatInformeTecnicoOperacion->ItoCostoHora / $InsInformeTecnico->IteTipoCambio,2);
				$DatInformeTecnicoOperacion->ItoValorTotal = round($DatInformeTecnicoOperacion->ItoValorTotal / $InsInformeTecnico->IteTipoCambio,2);
	
			}
	
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('B'.$fila, $DatInformeTecnicoOperacion->ItoNumero);
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('C'.$fila, $DatInformeTecnicoOperacion->ItoTiempo);
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('D'.$fila, $DatInformeTecnicoOperacion->ItoCostoHora);
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('F'.$fila, $DatInformeTecnicoOperacion->ItoValorTotal);
			
			$fila++;
		}
	}
				


	//SesionObjeto-InsInformeTecnicoATS3Producto
	//Parametro1 = ItpId
	//Parametro2 = ProId
	//Parametro3 = UmeId
	//Parametro4 = FapId
	//Parametro5 = ProNombre
	//Parametro6 = ItpCantidad
	//Parametro7 = ItpValorUnitario
	//Parametro8 = ItpValorTotal	
	//Parametro9 = ItpEstado	
	//Parametro10 = ItpTiempoCreacion		
	//Parametro11 = ItpTiempoModificacion	
	//Parametro12 = UmeNombre	
	//Parametro13 = ProCodigoOriginal
	//Parametro14 = ProCodigoAlternativo
	
	$objPHPExcel->setActiveSheetIndex(2);	

	$fila = 5;
	if(!empty($InsInformeTecnico->InformeTecnicoProducto)){
		foreach($InsInformeTecnico->InformeTecnicoProducto as $DatInformeTecnicoProducto){	
		
		
			if($InsInformeTecnico->MonId<>$EmpresaMonedaId ){
			
				$DatInformeTecnicoProducto->ItpValorUnitario = round($DatInformeTecnicoProducto->ItpValorUnitario / $InsInformeTecnico->IteTipoCambio,2);
				$DatInformeTecnicoProducto->ItpValorTotal = round($DatInformeTecnicoProducto->ItpValorTotal / $InsInformeTecnico->IteTipoCambio,2);
				
			}
			
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('B'.$fila, $DatInformeTecnicoProducto->ProCodigoOriginal);
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('C'.$fila, $DatInformeTecnicoProducto->ProNombre);
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('D'.$fila, $DatInformeTecnicoProducto->ItpCantidad);
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('E'.$fila, $DatInformeTecnicoProducto->ItpValorUnitario);
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue('F'.$fila, $DatInformeTecnicoProducto->ItpValorTotal);
					
			$fila++;
	
		}
	}			







// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('ATS3 '.$InsInformeTecnico->IteId);


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save("../../generados/".$InsInformeTecnico->IteId.".xls");

header("Location: ../../generados/".$InsInformeTecnico->IteId.".xls");
?>