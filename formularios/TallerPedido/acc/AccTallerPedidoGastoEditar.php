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
if (!isset($_SESSION['InsTallerPedidoGasto'.$Identificador])){
	$_SESSION['InsTallerPedidoGasto'.$Identificador] = new ClsSesionObjeto();
}


//SesionObjeto-TallerPedidoGasto
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

$POST_GastoId = $_POST['GastoId'];
$POST_GastoComprobanteNumero = $_POST['GastoComprobanteNumero'];
$POST_GastoComprobanteFecha = $_POST['GastoComprobanteFecha'];
$POST_GastoTotal = $_POST['GastoTotal'];

$POST_ProveedorNombre = $_POST['ProveedorNombre'];
$POST_ProveedorApellidoPaterno = $_POST['ProveedorApellidoPaterno'];
$POST_ProveedorApellidoMaterno = $_POST['ProveedorApellidoMaterno'];

$POST_TallerPedidoGastoEstado = $_POST['TallerPedidoGastoEstado'];

$POST_GastoMonedaNombre = $_POST['GastoMonedaNombre'];
$POST_GastoMonedaSimbolo = $_POST['GastoMonedaSimbolo'];
$POST_GastoTipoCambio = $_POST['GastoTipoCambio'];
$POST_GastoMonedaId = $_POST['GastoMonedaId'];
$POST_GastoFoto = $_POST['GastoFoto'];
$POST_GastoConcepto = $_POST['GastoConcepto'];

$InsTallerPedidoGasto1 = array();
$InsTallerPedidoGasto1 = $_SESSION['InsTallerPedidoGasto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$_SESSION['InsTallerPedidoGasto'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsTallerPedidoGasto1->Parametro1,
$InsTallerPedidoGasto1->Parametro2,
(($POST_GastoComprobanteNumero)),
(($POST_GastoComprobanteFecha)),
(($POST_GastoTotal)),
3,
$InsTallerPedidoGasto1->Parametro7,
date("d/m/Y H:i:s"),

$POST_ProveedorNombre,
$POST_ProveedorApellidoPaterno,
$POST_ProveedorApellidoMaterno,

$POST_GastoMonedaNombre,
$POST_GastoMonedaSimbolo,
$POST_GastoTipoCambio,
$POST_GastoMonedaId,
$POST_GastoFoto,

$POST_GastoConcepto
);
?>