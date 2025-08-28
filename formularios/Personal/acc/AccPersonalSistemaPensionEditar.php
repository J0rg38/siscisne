<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes() . 'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases() . 'ClsSesion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias() . 'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases() . 'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones() . 'ClsConexion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones() . 'FncGeneral.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsPersonalSistemaPension'.$Identificador])){
	$_SESSION['InsPersonalSistemaPension'.$Identificador] = new ClsSesionObjeto();
}

/*
SesionObjeto-PersonalSistemaPensionListado
Parametro1 = PspId
Parametro2 = SpeId
Parametro3 = Fecha
Parametro4 = CodigoUnico
Parametro5 = SpeNombre

Parametro6 = TiempoCreacion
Parametro7 = TiempoModificacion
*/

$InsPersonalSistemaPension1 = array();
$InsPersonalSistemaPension1 = $_SESSION['InsPersonalSistemaPension'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
		
$_SESSION['InsPersonalSistemaPension'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,$InsPersonalSistemaPension1->Parametro1,$InsPersonalSistemaPension1->Parametro2,$_POST['Fecha'],$_POST['CodigoUnico'],$InsPersonalSistemaPension1->Parametro5,$InsPersonalSistemaPension1->Parametro6,date("d/m/Y H:i:s"));
			

?>