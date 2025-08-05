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


 require_once($InsProyecto->MtdRutLibrerias().'class.random.php');
 
$SesionId = $_POST['SesionId'];
$Identificador = $_POST['Identificador'];
$POST_Tipo = $_POST['Tipo'];


$random = new Random();
$FotoIdentificador = $random->random_text(10, false, false, true);


session_start();
if (!isset($_SESSION['InsProveedorComunicadoFoto'.$Identificador])){
	$_SESSION['InsProveedorComunicadoFoto'.$Identificador] = new ClsSesionObjeto();
}

$targetFolder = '../../../subidos/venta_directa';// Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetPath = $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $FotoIdentificador.$_FILES['Filedata']['name'];
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','pdf'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {

		if(move_uploaded_file($tempFile,$targetFile)){

	//		SesionObjeto-ProveedorComunicadoFoto
	//		Parametro1 = VdfId
	//		Parametro2 =
	//		Parametro3 = VdfArchivo
	//		Parametro4 = VdfEstado
	//		Parametro5 = VdfTiempoCreacion
	//		Parametro6 = VdfTiempoModificacion
	//		Parametro7 = VdfTipo
	
			$_SESSION['InsProveedorComunicadoFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			NULL,
			$FotoIdentificador.$_FILES['Filedata']['name'],
			3,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s"),
			$POST_Tipo
			);

		}

		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>