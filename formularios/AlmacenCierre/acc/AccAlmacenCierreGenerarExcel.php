<?php
session_start();
////PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

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





$GET_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

list($Dia,$Mes,$Ano) = explode("/",$GET_FechaInicio);

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenCierre.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

$InsAlmacenCierre = new ClsAlmacenCierre();
$InsAlmacen = new ClsAlmacen();
$InsAlmacenProducto = new ClsAlmacenProducto();

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objReader = PHPExcel_IOFactory::createReader('Excel5');

$objPHPExcel = $objReader->load("../../../plantilla/TemAlmacenCierre.xls");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");


//MtdObtenerAlmacenes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AlmId',$oSentido = 'Desc',$oPaginacion = '0,10')

$InsAlmacen = new ClsAlmacen();
$ResAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,'AlmNombre','ASC',NULL);
$ArrAlmacenes = $ResAlmacen['Datos'];

///deb($ArrAlmacenes);
$hoja = 0;

if(!empty($ArrAlmacenes)){
	foreach($ArrAlmacenes as $DatAlmacen){

		
		// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex($hoja)
					->setCellValue('A5', 'Almacen:');
		$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true)->setSize(12);
		$objPHPExcel->setActiveSheetIndex($hoja)
					->setCellValue('B5', $DatAlmacen->AlmNombre);

				
		//MtdObtenerAlmacenProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAlmacen=NULL,$oProducto=NULL,$oAno=NULL)
		$ResAlmacenProducto = $InsAlmacenProducto->MtdObtenerAlmacenProductos(NULL,NULL,'AprId','Desc','',NULL,$DatAlmacen->AlmId,NULL,$Ano);
		$ArrAlmacenProductos = $ResAlmacenProducto['Datos'];

		///deb($ArrAlmacenProductos);
		
		$fila = 8;
		if(!empty($ArrAlmacenProductos)){
			foreach($ArrAlmacenProductos as $DatAlmacenProducto){
				
				$objPHPExcel->setActiveSheetIndex($hoja)
					->setCellValue('A'.$fila, $DatAlmacenProducto->ProCodigoOriginal);
				//$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true)->setSize(12);
		
				$objPHPExcel->setActiveSheetIndex($hoja)
					->setCellValue('B'.$fila, $DatAlmacenProducto->ProNombre);
					
					$objPHPExcel->setActiveSheetIndex($hoja)
					->setCellValue('C'.$fila, $DatAlmacenProducto->UmeAbreviacion);
					
					$objPHPExcel->setActiveSheetIndex($hoja)
					->setCellValue('D'.$fila, $DatAlmacenProducto->AprStockReal);
					
				//FncConvertirNumeroALetraExcel
				
				$fila++;	
			}
		}
		
		//$GET_FechaInicio
			
				
		$hoja++;
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($DatAlmacen->AlmNombre);

	}
}
													   
				
				

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$GET_FechaInicio = eregi_replace("/","_",$GET_FechaFin);
$GET_FechaFin = eregi_replace("/","_",$GET_FechaFin);

$NombreArchivo = $GET_FechaInicio."_".$GET_FechaFin;

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save("../../../generados/".$NombreArchivo.".xls");

//$objWriter->save(str_replace('.php', '.xls', __FILE__));
?>
<input type="hidden" name="CmpAlmacenCierreArchivo" id="CmpAlmacenCierreArchivo" value="<?php echo $NombreArchivo;?>.xls" />
<a target="_blank" href="generados/<?php echo $NombreArchivo;?>.xls">Archivo de Cierre: <?php echo $NombreArchivo;?>.xls</a>
<?php
//header("Location: ../../generados/".$InsOrdenCompra->OcoId.".xls");
?>