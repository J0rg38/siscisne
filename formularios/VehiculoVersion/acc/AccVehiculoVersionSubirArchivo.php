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
require_once($InsProyecto->MtdRutLibrerias().'class.thumb.php');
require_once($InsProyecto->MtdRutLibrerias().'thumb/image.class.php');

 
$SesionId = $_POST['SesionId'];
$Identificador = $_POST['Identificador'];
$POST_Tipo = $_POST['Tipo'];

//deb($Identificador);

$random = new Random();
$ArchivoIdentificador = $random->random_text(10, false, false, true);

$targetFolder = '../../../subidos/vehiculo_version_fotos';// Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
//	$targetPath = $targetFolder;
//	$targetFile = rtrim($targetPath,'/') . '/' . $ArchivoIdentificador.$_FILES['Filedata']['name'];
	$targetPath = $targetFolder;
	$fileName = $ArchivoIdentificador.$_FILES['Filedata']['name'];
	$fileName = str_replace(" ","_",$fileName);
	$targetFile = rtrim($targetPath,'/') . '/' . $fileName;
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','pdf'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {

		if(move_uploaded_file($tempFile,$targetFile)){

			$_SESSION['SesVveArchivo'.$Identificador] = $fileName;
			
			//echo '../../../subidos/vehiculo_version_fotos/thumb_'.$fileName;
			
			/*$img = new Zubrag_image;
			
			// initialize
			$img->max_x        = 100;
			$img->max_y        = 100;
			$img->cut_x        = 0;
			$img->cut_y        = 0;
			$img->quality      = 100;
			$img->save_to_file = true;
			$img->image_type   = -1;
			
			$img->GenerateThumbFile($targetFile, '../../../subidos/vehiculo_version_fotos/thumb_'.$fileName);
			
			
			
			
			// initialize
			$img->max_x        = 350;
			$img->max_y        = 350;
			$img->cut_x        = 0;
			$img->cut_y        = 0;
			$img->quality      = 100;
			$img->save_to_file = true;
			$img->image_type   = -1;
			
			$img->GenerateThumbFile($targetFile, '../../../subidos/vehiculo_version_fotos/thumb2_'.$fileName);
			*/
		}

		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>