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



$POST_ProductoId = $_POST['ProductoId'];


require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


$InsProducto = new ClsProducto();
$InsPersonal = new ClsPersonal();



//deb($_SESSION['SesionId']);
if(!empty($POST_ProductoId) ){

	if(!empty($_SESSION['SesionPersonal'])){
		$InsPersonal->PerId = $_SESSION['SesionPersonal'];
		$PersonalEmail = ",".$InsPersonal->PerEmail;
	}
	
	$InsProducto->MtdNotificarProductoSinStock($POST_ProductoId,"jblanco@cyc.com.pe,aliendo@cyc.com.pe".$PersonalEmail, $_SESSION['SesionId']) ;
	
	$InsProducto->MtdEditarProductoDato("ProRevisado",1,$POST_ProductoId) ;
	$InsProducto->MtdEditarProductoDato("ProRevisadoFecha",date("Y-m-d"),$POST_ProductoId) ;
	
	echo "1";
}




?>