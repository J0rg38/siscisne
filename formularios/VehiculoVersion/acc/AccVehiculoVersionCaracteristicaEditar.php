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

$Identificador = $_POST['Identificador'];
//$POST_VehiculoVersionCaracteristicaSeccionId = $_POST['VehiculoVersionCaracteristicaSeccionId'];
$POST_VehiculoVersionCaracteristicaDescripcion = $_POST['VehiculoVersionCaracteristicaDescripcion'];
$POST_VehiculoVersionCaracteristicaValor = $_POST['VehiculoVersionCaracteristicaValor'];
$POST_VehiculoVersionCaracteristicaAnoModelo = $_POST['VehiculoVersionCaracteristicaAnoModelo'];
$POST_VehiculoCaracteristicaSeccion = $_POST['VehiculoCaracteristicaSeccion'];

session_start();
if (!isset($_SESSION['InsVehiculoVersionCaracteristica'.$Identificador])){
	$_SESSION['InsVehiculoVersionCaracteristica'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();
$InsVehiculoCaracteristicaSeccion->VcsId = $POST_VehiculoCaracteristicaSeccion;
$InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSeccion();

//	SesionObjeto-VehiculoVersionCaracteristica
//	Parametro1 = VvcId
//	Parametro2 = VveId
//	Parametro3 = VcsId

//	Parametro4 = VvcDescripcion
//	Parametro5 = VvcValor
//	Parametro6 = VvcAnoModelo
//	Parametro7 = VvcTiempoCreacion
//	Parametro8 = VvcTiempoModificacion
//	Parametro9 = VcsNombre

$InsVehiculoVersionCaracteristica1 = array();
$InsVehiculoVersionCaracteristica1 = $_SESSION['InsVehiculoVersionCaracteristica'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$_SESSION['InsVehiculoVersionCaracteristica'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsVehiculoVersionCaracteristica1->Parametro1,
$InsVehiculoVersionCaracteristica1->Parametro2,
$POST_VehiculoCaracteristicaSeccion,
$POST_VehiculoVersionCaracteristicaDescripcion,
$POST_VehiculoVersionCaracteristicaValor,
$POST_VehiculoVersionCaracteristicaAnoModelo,
$InsVehiculoVersionCaracteristica1->Parametro7,
date("d/m/Y H:i:s"),
$InsVehiculoCaracteristicaSeccion->VcsNombre
);

?>