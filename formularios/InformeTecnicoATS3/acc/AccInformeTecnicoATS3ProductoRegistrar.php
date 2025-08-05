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

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsInformeTecnicoATS3Producto'.$Identificador])){
	$_SESSION['InsInformeTecnicoATS3Producto'.$Identificador] = new ClsSesionObjeto();
}
//SesionObjeto-InsInformeTecnicoATS3Producto
//Parametro1 = ItpId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = FapId
//Parametro5 = ProNombre
//Parametro6 = ItpCantidad
//Parametro7 = ItpValorUnitario
//Parametro8 = ItpValorTotal	
//Parametro9 = ItpEstado	
//Parametro10 = ItpTiempoCreacion		
//Parametro11 = ItpTiempoModificacion	
//Parametro11 = UmeNombre	
//Parametro12 = ProCodigoOriginal
//Parametro13 = ProCodigoAlternativo

$ProductoId = ($_POST['ProductoId']);
$UnidadMedidaId = ($_POST['UnidadMedidaId']);
$InformeTecnicoATS3ProductoCantidad = ($_POST['InformeTecnicoProductoCantidad']);
$InformeTecnicoATS3ProductoValorTotal = ($_POST['InformeTecnicoProductoValorTotal']);
$InformeTecnicoATS3ProductoValorUnitario= ($InformeTecnicoATS3ProductoValorTotal/$InformeTecnicoATS3ProductoCantidad);

$InsProducto = new ClsProducto();
$InsProducto->ProId = $ProductoId;
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedida->UmeId = $UnidadMedidaId;
$InsUnidadMedida->MtdObtenerUnidadMedida();

$_SESSION['InsInformeTecnicoATS3Producto'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
$ProductoId,
$UnidadMedidaId,
NULL,

$InsProducto->ProNombre,
$InformeTecnicoATS3ProductoCantidad,
$InformeTecnicoATS3ProductoValorUnitario,
$InformeTecnicoATS3ProductoValorTotal,
3,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"),
$InsUnidadMedida->UmeNombre,

$InsProducto->ProCodigoOriginal,
$InsProducto->ProCodigoAlternativo
);

?>