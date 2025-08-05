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

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

$POST_ManoObraImporte = $_POST['ManoObraImporte'];
$POST_ManoObraDescripcion = $_POST['ManoObraDescripcion'];
$POST_ManoObraId = $_POST['ManoObraId'];

session_start();
if (!isset($_SESSION['InsFichaIngresoManoObra'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoManoObra'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}
/*
SesionObjeto-FichaIngresoManoObra
Parametro1 = FmoId
Parametro2 =
Parametro3 = FmoDescripcion
Parametro4 = FmoImporte
Parametro5 =
Parametro6 = 
Parametro7 = FmoTiempoCreacion
Parametro8 = FmoTiempoModificacion
*/
	
$_SESSION['InsFichaIngresoManoObra'.$ModalidadIngreso.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
NULL,
$POST_ManoObraDescripcion,
$POST_ManoObraImporte,
NULL,
NULL,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s")
);


?>