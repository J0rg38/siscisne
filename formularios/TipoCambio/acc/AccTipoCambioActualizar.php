<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = "../../../";
$InsProyecto->Ruta = "../../../";

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


?>

<?php
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

//$InsTipoCambio = new ClsTipoCambio();
//if(($_SESSION['SisTipoCambio'])==2){

$InsTipoCambio = new ClsTipoCambio();
$InsTipoCambio->MonId = "MON-10001";
$InsTipoCambio->TcaFecha = date("Y-m-d");
$InsTipoCambio->MtdObtenerTipoCambioActual();

//deb($InsTipoCambio->TcaId);

if(empty($InsTipoCambio->TcaId)){
	
	if($InsTipoCambio->ObtenerTipoCambioInternet()){
		// $_SESSION['SisTipoCambio'] = 2;
		echo "1";
	}else{
		echo "2";	
	}

}else{
	echo "1";		
}

//}else{
//	echo "1";
//}
?>