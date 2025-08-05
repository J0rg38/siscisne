<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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

session_start();
if (!isset($_SESSION['InsProductoCodigoReemplazo'.$Identificador])){
	$_SESSION['InsProductoCodigoReemplazo'.$Identificador] = new ClsSesionObjeto();
}


//SesionObjeto-InsProductoCodigoReemplazo
//Parametro1 = PcrId
//Parametro2 = PcrNumero
//Parametro6 = PcrEstado
//Parametro7 = PcrTiempoCreacion
//Parametro8 = PcrTiempoModificacion	

$ProductoCodigoReemplazoNumero = ($_POST['ProductoCodigoReemplazoNumero']);

$_SESSION['InsProductoCodigoReemplazo'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
$ProductoCodigoReemplazoNumero,
1,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s")
);

?>