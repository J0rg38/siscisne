<?php
session_start();
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


require_once($InsProyecto->MtdRutLibrerias().'class.random.php');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        



 
$SesionId = $_POST['SesionId'];
$Identificador = $_POST['Identificador'];
$POST_Tipo = $_POST['Tipo'];

//deb($Identificador);

$random = new Random();
$FotoIdentificador = $random->random_text(10, false, false, true);

$targetFolder = '../../../subidos/procesador_archivos';// Relative to the root

$ArchivoProcesado = "";

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetPath = $targetFolder;
	$File = LimpiarNombreArchivo($FotoIdentificador.$_FILES['Filedata']['name']);
	$targetFile = rtrim($targetPath,'/') . '/' . $File;
	// Validate the file type
	$fileTypes = array('csv'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	$ArchivoProcesado = "PROCESADO_".$File;
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {

		if(move_uploaded_file($tempFile,$targetFile)){

			$_SESSION['SesPrcArchivo1'.$Identificador] = $File;
		
					
			

				// Create new PHPExcel object
				$objPHPExcel = new PHPExcel();
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				// Set document properties
				$objPHPExcel->getProperties()->setCreator($EmpresaNombre)
										   ->setLastModifiedBy($EmpresaNombre)
										   ->setTitle($EmpresaNombre)
										   ->setSubject($EmpresaNombre)
										   ->setDescription($EmpresaNombre)
										   ->setKeywords($EmpresaNombre)
										   ->setCategory($EmpresaNombre);
										   
				$objPHPExcel = $objReader->load("../../../plantilla/TemGeneral.xls");
				
			
				//DATOS CONCESIONARIO
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',"ITEM");
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12);	
				$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('B1',"FECHA");
				$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true)->setSize(12);	
				$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
											
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('C1',"ASESOR");
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('D1',"DISTRIBUIDORA");
					$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
										
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('E1',"NRO. DOCUMENTO");
					$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('F1',"NOMBRE");
					$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
										
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('G1',"APELLIDOS");
					$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
										
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('H1',"CELULAR");
					$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
										
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('I1',"EMAIL");
					$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('J1',"CIUDAD");
					$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('K1',"MODELO");
					$objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
										
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('L1',"COMENTARIOS DE CLIENTE");
					$objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('M1',"TIPO COMPRA");
					$objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true)->setSize(12);	
					$objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	

		$fila =2;
		if (($gestor = fopen($targetFolder."/".$_SESSION['SesPrcArchivo1'.$Identificador], "r")) !== FALSE) {
			
			//$data = trim(preg_replace('/\s+/g', '', $data));
			//while (($datos = fgetcsv($gestor, 1000, "\t")) !== FALSE) {
			$item = 1;
			
			while (($datos = fgetcsv($gestor, 0, "\t")) !== FALSE) {
			//while (($datos = fgetcsv($gestor, 0, ",", "\"", "\"")) !== FALSE) {
				
				$numero = count($datos);
				//echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
				
				
			//	$objPHPExcel->setActiveSheetIndex(0)
			//		->setCellValue('A'.$fila,"".$fila);
					
				$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
				$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
										
				$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
				
				$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
				
				$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
				
				$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	

				$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
				
				$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
				
				$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
																
					$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);		
										
				$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
				$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);							
										
			$objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);	
			
				
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$fila,$item);
						
																																			
				for ($c=0; $c < $numero; $c++) {
					
					//echo $datos[$c] . " / ";
					
					if($c==1){//FECHA
						
						//echo $datos[$c] . " / ";
						
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('B'.$fila,$datos[$c]);
						//jbalog("","PV",$datos[$c]);
					}
					
					
					if($c==25){//distirbuidora
						
						//echo $datos[$c] . " / ";
						
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('D'.$fila,$datos[$c]);
						//jbalog("","PV",$datos[$c]);
					}
					
					
					if($c==72){//DNI
						
						//echo $datos[$c] . " / ";
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('E'.$fila,$datos[$c]);
					
					}
					
					if($c==66){//NOMBRE
						
						//echo $datos[$c] . " / ";
						
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('F'.$fila,$datos[$c]);
					
					}
					
						if($c==67){//APELLIDOS
						
						//echo $datos[$c] . " / ";
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('G'.$fila,$datos[$c]);
					
					}
					
					if($c==58){//CELULAR
						
					//	echo $datos[$c] . " / ";
						
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('H'.$fila,$datos[$c]);
					
					}
					
					if($c==51){//EMAIL
						
						//echo $datos[$c] . " / ";
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('I'.$fila,$datos[$c]);
					
					}
					
					if($c==71){//CIUDAD
						
						//echo $datos[$c] . " / ";
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('J'.$fila,$datos[$c]);
					
					}
					
					if($c==18){//MODELO
						
						//echo $datos[$c] . " / ";
						
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('K'.$fila,$datos[$c]);
					
					}
					
					if($c==36){//COMENTARIOS
						
						//echo $datos[$c] . " / ";
						
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('L'.$fila,$datos[$c]);
					
					}
					
					if($c==40){//TIPO COMPRA
						
						//echo $datos[$c] . " / ";
						$datos[$c] = str_replace("\"","",$datos[$c]);
						$datos[$c] = str_replace(array("\r", "\n"), '', $datos[$c]);
						
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('M'.$fila,$datos[$c]);
					
					}
					
				}
				
				$item++;
				///echo  " FINAL \n";
				
				$fila++;
			}
			
			fclose($gestor);
			
		}
			
					  
		$objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
       
	    $objWriter->save("../../../generados/procesadores/".$ArchivoProcesado.".xls");
        
		$_SESSION['SesPrcArchivo1Procesado'.$Identificador] = $ArchivoProcesado.".xls";
		
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
       // header("Location: ../../generados/reportes/COS_".$InsVehiculoMarca->VmaNombre."_".$SucursalNombreArchivo."_".$POST_Ano."_".$POST_Mes.".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
		//exit();	  
			  	
		}

		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>