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
if (!isset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador])){
	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = new ClsSesionObjeto();	
}

$CotizacionProductoPlanchadoDescripcion = $_POST['CotizacionProductoPlanchadoDescripcion'];
$CotizacionProductoPlanchadoImporte = $_POST['CotizacionProductoPlanchadoImporte'];
$CotizacionProductoPlanchadoEstado = $_POST['CotizacionProductoPlanchadoEstado'];

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

$InsCotizacionProductoPlanchado1 = array();
$InsCotizacionProductoPlanchado1 = $_SESSION['InsCotizacionProductoPlanchado'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$_SESSION['InsCotizacionProductoPlanchado'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsCotizacionProductoPlanchado1->Parametro1,
$CotizacionProductoPlanchadoDescripcion,
$InsCotizacionProductoPlanchado1->Parametro3,
$InsCotizacionProductoPlanchado1->Parametro4,
$CotizacionProductoPlanchadoImporte,
$CotizacionProductoPlanchadoEstado,
$InsCotizacionProductoPlanchado1->Parametro7,
$InsCotizacionProductoPlanchado1->Parametro8,
date("d/m/Y H:i:s")
);
	
	

?>