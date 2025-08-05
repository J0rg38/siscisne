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

$POST_OvvId = $_POST['OvvId'];
$Identificador = $_POST['Identificador'];

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

session_start();
if (!isset($_SESSION['InsFacturaDetalle'.$Identificador])){
	$_SESSION['InsFacturaDetalle'.$Identificador] = new ClsSesionObjeto();
}

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $POST_OvvId;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();


$_SESSION['InsFacturaDatoAdicional1'.$Identificador] = $InsOrdenVentaVehiculo->VmaNombre;
$_SESSION['InsFacturaDatoAdicional2'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica7)?$InsOrdenVentaVehiculo->EinCaracteristica7:$InsOrdenVentaVehiculo->VveCaracteristica7);

$_SESSION['InsFacturaDatoAdicional3'.$Identificador] = (empty($InsOrdenVentaVehiculo->EinNombre)?$InsOrdenVentaVehiculo->VmoNombre:$InsOrdenVentaVehiculo->EinNombre);
$_SESSION['InsFacturaDatoAdicional4'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica8)?$InsOrdenVentaVehiculo->EinCaracteristica8:$InsOrdenVentaVehiculo->VveCaracteristica8);

$_SESSION['InsFacturaDatoAdicional5'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoFabricacion;
$_SESSION['InsFacturaDatoAdicional6'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica9)?$InsOrdenVentaVehiculo->EinCaracteristica9:$InsOrdenVentaVehiculo->VveCaracteristica9);

$_SESSION['InsFacturaDatoAdicional7'.$Identificador] = $InsOrdenVentaVehiculo->EinNumeroMotor;
$_SESSION['InsFacturaDatoAdicional8'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica10)?$InsOrdenVentaVehiculo->EinCaracteristica10:$InsOrdenVentaVehiculo->VveCaracteristica10);

$_SESSION['InsFacturaDatoAdicional9'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica1)?$InsOrdenVentaVehiculo->EinCaracteristica1:$InsOrdenVentaVehiculo->VveCaracteristica1);
$_SESSION['InsFacturaDatoAdicional10'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica11)?$InsOrdenVentaVehiculo->EinCaracteristica11:$InsOrdenVentaVehiculo->VveCaracteristica11);

$_SESSION['InsFacturaDatoAdicional11'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica2)?$InsOrdenVentaVehiculo->EinCaracteristica2:$InsOrdenVentaVehiculo->VveCaracteristica2);
$_SESSION['InsFacturaDatoAdicional12'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica12)?$InsOrdenVentaVehiculo->EinCaracteristica12:$InsOrdenVentaVehiculo->VveCaracteristica12);

$_SESSION['InsFacturaDatoAdicional13'.$Identificador] = $InsOrdenVentaVehiculo->EinVIN;
$_SESSION['InsFacturaDatoAdicional14'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica13)?$InsOrdenVentaVehiculo->EinCaracteristica13:$InsOrdenVentaVehiculo->VveCaracteristica13);

$_SESSION['InsFacturaDatoAdicional15'.$Identificador] = $InsOrdenVentaVehiculo->EinColor;
$_SESSION['InsFacturaDatoAdicional16'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica14)?$InsOrdenVentaVehiculo->EinCaracteristica14:$InsOrdenVentaVehiculo->VveCaracteristica14);

	
$_SESSION['InsFacturaDatoAdicional17'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica3)?$InsOrdenVentaVehiculo->EinCaracteristica3:$InsOrdenVentaVehiculo->VveCaracteristica3);
$_SESSION['InsFacturaDatoAdicional18'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica15)?$InsOrdenVentaVehiculo->EinCaracteristica15:$InsOrdenVentaVehiculo->VveCaracteristica15);
		
$_SESSION['InsFacturaDatoAdicional19'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica4)?$InsOrdenVentaVehiculo->EinCaracteristica4:$InsOrdenVentaVehiculo->VveCaracteristica4);
$_SESSION['InsFacturaDatoAdicional20'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica16)?$InsOrdenVentaVehiculo->EinCaracteristica16:$InsOrdenVentaVehiculo->VveCaracteristica16);
		
$_SESSION['InsFacturaDatoAdicional21'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica5)?$InsOrdenVentaVehiculo->EinCaracteristica5:$InsOrdenVentaVehiculo->VveCaracteristica5);
$_SESSION['InsFacturaDatoAdicional22'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica17)?$InsOrdenVentaVehiculo->EinCaracteristica17:$InsOrdenVentaVehiculo->VveCaracteristica17);
		
$_SESSION['InsFacturaDatoAdicional23'.$Identificador] = $InsOrdenVentaVehiculo->EinDUA;

$_SESSION['InsFacturaDatoAdicional24'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica18)?$InsOrdenVentaVehiculo->EinCaracteristica18:$InsOrdenVentaVehiculo->VveCaracteristica18);

$_SESSION['InsFacturaDatoAdicional25'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica19)?$InsOrdenVentaVehiculo->EinCaracteristica19:$InsOrdenVentaVehiculo->VveCaracteristica19);

$_SESSION['InsFacturaDatoAdicional26'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica20)?$InsOrdenVentaVehiculo->EinCaracteristica20:$InsOrdenVentaVehiculo->VveCaracteristica20);

$_SESSION['InsFacturaDatoAdicional27'.$Identificador] = ($InsOrdenVentaVehiculo->EinAnoModelo);


?>