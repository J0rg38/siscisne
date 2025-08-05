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


session_start();
if (!isset($_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador])){
	$_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador] = new ClsSesionObjeto();
}


//SesionObjeto-TallerPedidoAlmacenMovimientoEntrada
//Parametro1 = FigId
//Parametro2 = GasId
//Parametro3 = GasComprobanteNumero
//Parametro4 = GasComprobanteFecha
//Parametro5 = GasTotal
//Parametro6 = FigEstado
//Parametro7 = GasTiempoCreacion
//Parametro8 = GasTiempoModificacion
//Parametro9 = PrvNombre
//Parametro10 = PrvApellidoPaterno
//Parametro11 = PrvApellidoMaterno
//Parametro12 = MonNombre
//Parametro13 = MonSimbolo
//Parametro14 = GasTipoCambio
//Parametro15 = MonId
//Parametro16 = GasFoto

$POST_AlmacenMovimientoEntradaId = $_POST['AlmacenMovimientoEntradaId'];
$POST_AlmacenMovimientoEntradaComprobanteNumero = $_POST['AlmacenMovimientoEntradaComprobanteNumero'];
$POST_AlmacenMovimientoEntradaComprobanteFecha = $_POST['AlmacenMovimientoEntradaComprobanteFecha'];
$POST_AlmacenMovimientoEntradaTotal = $_POST['AlmacenMovimientoEntradaTotal'];

$POST_ProveedorNombre = $_POST['ProveedorNombre'];
$POST_ProveedorApellidoPaterno = $_POST['ProveedorApellidoPaterno'];
$POST_ProveedorApellidoMaterno = $_POST['ProveedorApellidoMaterno'];

$POST_TallerPedidoAlmacenMovimientoEntradaEstado = $_POST['TallerPedidoAlmacenMovimientoEntradaEstado'];

$POST_AlmacenMovimientoEntradaMonedaNombre = $_POST['AlmacenMovimientoEntradaMonedaNombre'];
$POST_AlmacenMovimientoEntradaMonedaSimbolo = $_POST['AlmacenMovimientoEntradaMonedaSimbolo'];
$POST_AlmacenMovimientoEntradaTipoCambio = $_POST['AlmacenMovimientoEntradaTipoCambio'];
$POST_AlmacenMovimientoEntradaMonedaId = $_POST['AlmacenMovimientoEntradaMonedaId'];
$POST_AlmacenMovimientoEntradaFoto = $_POST['AlmacenMovimientoEntradaFoto'];
$POST_AlmacenMovimientoEntradaConcepto = $_POST['AlmacenMovimientoEntradaConcepto'];

$InsTallerPedidoAlmacenMovimientoEntrada1 = array();
$InsTallerPedidoAlmacenMovimientoEntrada1 = $_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsTallerPedidoAlmacenMovimientoEntrada1->Parametro1,
$InsTallerPedidoAlmacenMovimientoEntrada1->Parametro2,
(($POST_AlmacenMovimientoEntradaComprobanteNumero)),
(($POST_AlmacenMovimientoEntradaComprobanteFecha)),
(($POST_AlmacenMovimientoEntradaTotal)),
3,
$InsTallerPedidoAlmacenMovimientoEntrada1->Parametro7,
date("d/m/Y H:i:s"),

$POST_ProveedorNombre,
$POST_ProveedorApellidoPaterno,
$POST_ProveedorApellidoMaterno,

$POST_AlmacenMovimientoEntradaMonedaNombre,
$POST_AlmacenMovimientoEntradaMonedaSimbolo,
$POST_AlmacenMovimientoEntradaTipoCambio,
$POST_AlmacenMovimientoEntradaMonedaId,
$POST_AlmacenMovimientoEntradaFoto,

$POST_AlmacenMovimientoEntradaConcepto
);
?>