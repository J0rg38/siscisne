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


require_once($InsProyecto->MtdRutLibrerias().'class.thumb.php');


$SesionId = $_POST['SesionId'];
$Identificador = $_POST['Identificador'];
$POST_Item = $_POST['Item'];

//session_id($SesionId);
//session_start($SesionId);
//session_start();
//deb($_POST['PHPSESSID']);

//session_id($_POST['PHPSESSID']);
//session_start();
session_start();
if (!isset($_SESSION['InsVehiculoRecepcionDetalleFoto'.$POST_Item.$Identificador])){
	$_SESSION['InsVehiculoRecepcionDetalleFoto'.$POST_Item.$Identificador] = new ClsSesionObjeto();
}

$targetFolder = '../../../subidos/vehiculo_recepcion_fotos';// Relative to the root


if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetPath = $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {

		if(move_uploaded_file($tempFile,$targetFile)){
			
//			$ddf = fopen('fotos14.txt','a');
//			fwrite($ddf,'InsVehiculoRecepcionDetalleFoto'.$POST_Item.$Identificador);	
//			fclose($ddf);

			//		SesionObjeto-VehiculoRecepcionDetalleFoto
			//		Parametro1 = VrfId
			//		Parametro2 = VrdId
			//		Parametro3 = VrfArchivo
			//		Parametro4 = VrfEstado
			//		Parametro5 = VrfTiempoCreacion
			//		Parametro6 = VrfTiempoModificacion
			

			$file_name = $_FILES['Filedata']['name'];
						
			$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			$nombre_base = basename($file_name, '.'.$extension);  

	
			$mythumb = new thumb();
			$mythumb->loadImage($targetFolder.'/'.$file_name);
			$mythumb->crop(800, 600,'bottom');
			$mythumb->save($targetFolder.'/'.$nombre_base.'_thumb.'.$extension, 100);
			
			
			

			//$_SESSION['InsFichaAccionProducto'.$POST_Item.$Identificador]->MtdAgregarSesionObjeto(1,
			$_SESSION['InsVehiculoRecepcionDetalleFoto'.$POST_Item.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			NULL,
//			$_FILES['Filedata']['name'],
			$nombre_base.'_thumb.'.$extension,
			1,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s")
			);
			
				
			

		}

//		$RepFichaAccionFoto = $_SESSION['InsVehiculoRecepcionDetalleFoto'.$POST_Item.$Identificador]->MtdObtenerSesionObjetos(false);
//		$ArrFichaAccionFotos = $RepFichaAccionFoto['Datos'];
//		deb($ArrFichaAccionFotos);
		
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>