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

$SesionId = $_POST['SesionId'];
$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

//session_id($SesionId);
//session_start($SesionId);
//session_start();
//deb($_POST['PHPSESSID']);

//session_id($_POST['PHPSESSID']);
//session_start();
session_start();
if (!isset($_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

$targetFolder = '../../../subidos/ficha_accion_fotos';// Relative to the root


if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetPath = $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $Identificador.$_FILES['Filedata']['name'];
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {

		if(move_uploaded_file($tempFile,$targetFile)){
			
//			$ddf = fopen('fotos14.txt','a');
//			fwrite($ddf,'InsFichaAccionFoto'.$ModalidadIngreso.$Identificador);	
//			fclose($ddf);

			//		SesionObjeto-FichaAccionFoto
			//		Parametro1 = FafId
			//		Parametro2 =
			//		Parametro3 = FafArchivo
			//		Parametro4 = FafEstado
			//		Parametro5 = FafTiempoCreacion
			//		Parametro6 = FafTiempoModificacion

			//$_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador]->MtdAgregarSesionObjeto(1,
			$_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			NULL,
			$Identificador.$_FILES['Filedata']['name'],
			1,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s")
			);

		}

//		$RepFichaAccionFoto = $_SESSION['InsFichaAccionFoto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(false);
//		$ArrFichaAccionFotos = $RepFichaAccionFoto['Datos'];
//		deb($ArrFichaAccionFotos);
		
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>