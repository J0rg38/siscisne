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
if (!isset($_SESSION['InsCotizacionProductoTarea'.$Identificador])){
	$_SESSION['InsCotizacionProductoTarea'.$Identificador] = new ClsSesionObjeto();	
}

$CotizacionProductoTareaDescripcion = $_POST['CotizacionProductoTareaDescripcion'];
$CotizacionProductoTareaImporte = $_POST['CotizacionProductoTareaImporte'];
$CotizacionProductoTareaEstado = $_POST['CotizacionProductoTareaEstado'];

//						SesionObjeto-CotizacionProductoTarea
//						Parametro1 = CppId
//						Parametro2 = CppDescripcion
//						Parametro3 = CppPrecio
//						Parametro4 = CppCantidad
//						Parametro5 = CppImporte
//						Parametro6 = CppEstado
//						Parametro7 = CppTipo
//						Parametro8 = CppTiempoCreacion
//						Parametro9 = CppTiempoModificacion

$InsCotizacionProductoTarea1 = array();
$InsCotizacionProductoTarea1 = $_SESSION['InsCotizacionProductoTarea'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$_SESSION['InsCotizacionProductoTarea'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsCotizacionProductoTarea1->Parametro1,
$CotizacionProductoTareaDescripcion,
$InsCotizacionProductoTarea1->Parametro3,
$InsCotizacionProductoTarea1->Parametro4,
$CotizacionProductoTareaImporte,
$CotizacionProductoTareaEstado,
$InsCotizacionProductoTarea1->Parametro7,
$InsCotizacionProductoTarea1->Parametro8,
date("d/m/Y H:i:s")
);
?>