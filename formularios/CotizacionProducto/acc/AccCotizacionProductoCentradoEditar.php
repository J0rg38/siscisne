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
if (!isset($_SESSION['InsCotizacionProductoCentrado'.$Identificador])){
	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = new ClsSesionObjeto();	
}

$CotizacionProductoCentradoDescripcion = $_POST['CotizacionProductoCentradoDescripcion'];
$CotizacionProductoCentradoImporte = $_POST['CotizacionProductoCentradoImporte'];
$CotizacionProductoCentradoEstado = $_POST['CotizacionProductoCentradoEstado'];


//						SesionObjeto-CotizacionProductoPlanchado
//						Parametro1 = CppId
//						Parametro2 = CppDescripcion
//						Parametro3 = CppPrecio
//						Parametro4 = CppCantidad
//						Parametro5 = CppImporte
//						Parametro6 = CppEstado
//						Parametro7 = CppTipo
//						Parametro8 = CppTiempoCreacion
//						Parametro9 = CppTiempoModificacion

$InsCotizacionProductoCentrado1 = array();
$InsCotizacionProductoCentrado1 = $_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsCotizacionProductoCentrado1->Parametro1,
$CotizacionProductoCentradoDescripcion,
$InsCotizacionProductoCentrado1->Parametro3,
$InsCotizacionProductoCentrado1->Parametro4,
$CotizacionProductoCentradoImporte,
$CotizacionProductoCentradoEstado,
$InsCotizacionProductoCentrado1->Parametro7,
$InsCotizacionProductoCentrado1->Parametro8,
date("d/m/Y H:i:s")
);

?>