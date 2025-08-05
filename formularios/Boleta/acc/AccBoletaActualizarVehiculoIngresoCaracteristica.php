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
if (!isset($_SESSION['InsBoletaDetalle'.$Identificador])){
	$_SESSION['InsBoletaDetalle'.$Identificador] = new ClsSesionObjeto();
}

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $POST_OvvId;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();


$_SESSION['InsBoletaDatoAdicional1'.$Identificador] = $InsOrdenVentaVehiculo->VmaNombre;
$_SESSION['InsBoletaDatoAdicional2'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica7)?$InsOrdenVentaVehiculo->EinCaracteristica7:$InsOrdenVentaVehiculo->VveCaracteristica7);

$_SESSION['InsBoletaDatoAdicional3'.$Identificador] = (empty($InsOrdenVentaVehiculo->EinNombre)?$InsOrdenVentaVehiculo->VmoNombre:$InsOrdenVentaVehiculo->EinNombre);
$_SESSION['InsBoletaDatoAdicional4'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica8)?$InsOrdenVentaVehiculo->EinCaracteristica8:$InsOrdenVentaVehiculo->VveCaracteristica8);

$_SESSION['InsBoletaDatoAdicional5'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoFabricacion;
$_SESSION['InsBoletaDatoAdicional6'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica9)?$InsOrdenVentaVehiculo->EinCaracteristica9:$InsOrdenVentaVehiculo->VveCaracteristica9);

$_SESSION['InsBoletaDatoAdicional7'.$Identificador] = $InsOrdenVentaVehiculo->EinNumeroMotor;
$_SESSION['InsBoletaDatoAdicional8'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica10)?$InsOrdenVentaVehiculo->EinCaracteristica10:$InsOrdenVentaVehiculo->VveCaracteristica10);

$_SESSION['InsBoletaDatoAdicional9'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica1)?$InsOrdenVentaVehiculo->EinCaracteristica1:$InsOrdenVentaVehiculo->VveCaracteristica1);
$_SESSION['InsBoletaDatoAdicional10'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica11)?$InsOrdenVentaVehiculo->EinCaracteristica11:$InsOrdenVentaVehiculo->VveCaracteristica11);

$_SESSION['InsBoletaDatoAdicional11'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica2)?$InsOrdenVentaVehiculo->EinCaracteristica2:$InsOrdenVentaVehiculo->VveCaracteristica2);
$_SESSION['InsBoletaDatoAdicional12'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica12)?$InsOrdenVentaVehiculo->EinCaracteristica12:$InsOrdenVentaVehiculo->VveCaracteristica12);

$_SESSION['InsBoletaDatoAdicional13'.$Identificador] = $InsOrdenVentaVehiculo->EinVIN;
$_SESSION['InsBoletaDatoAdicional14'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica13)?$InsOrdenVentaVehiculo->EinCaracteristica13:$InsOrdenVentaVehiculo->VveCaracteristica13);

$_SESSION['InsBoletaDatoAdicional15'.$Identificador] = $InsOrdenVentaVehiculo->EinColor;
$_SESSION['InsBoletaDatoAdicional16'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica14)?$InsOrdenVentaVehiculo->EinCaracteristica14:$InsOrdenVentaVehiculo->VveCaracteristica14);

	
$_SESSION['InsBoletaDatoAdicional17'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica3)?$InsOrdenVentaVehiculo->EinCaracteristica3:$InsOrdenVentaVehiculo->VveCaracteristica3);
$_SESSION['InsBoletaDatoAdicional18'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica15)?$InsOrdenVentaVehiculo->EinCaracteristica15:$InsOrdenVentaVehiculo->VveCaracteristica15);
		
$_SESSION['InsBoletaDatoAdicional19'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica4)?$InsOrdenVentaVehiculo->EinCaracteristica4:$InsOrdenVentaVehiculo->VveCaracteristica4);
$_SESSION['InsBoletaDatoAdicional20'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica16)?$InsOrdenVentaVehiculo->EinCaracteristica16:$InsOrdenVentaVehiculo->VveCaracteristica16);
		
$_SESSION['InsBoletaDatoAdicional21'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica5)?$InsOrdenVentaVehiculo->EinCaracteristica5:$InsOrdenVentaVehiculo->VveCaracteristica5);
$_SESSION['InsBoletaDatoAdicional22'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica17)?$InsOrdenVentaVehiculo->EinCaracteristica17:$InsOrdenVentaVehiculo->VveCaracteristica17);
		
$_SESSION['InsBoletaDatoAdicional23'.$Identificador] = $InsOrdenVentaVehiculo->EinDUA;

$_SESSION['InsBoletaDatoAdicional24'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica18)?$InsOrdenVentaVehiculo->EinCaracteristica18:$InsOrdenVentaVehiculo->VveCaracteristica18);

$_SESSION['InsBoletaDatoAdicional25'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica19)?$InsOrdenVentaVehiculo->EinCaracteristica19:$InsOrdenVentaVehiculo->VveCaracteristica19);

$_SESSION['InsBoletaDatoAdicional26'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica20)?$InsOrdenVentaVehiculo->EinCaracteristica20:$InsOrdenVentaVehiculo->VveCaracteristica20);


$_SESSION['InsBoletaDatoAdicional27'.$Identificador] =  $InsOrdenVentaVehiculo->EinAnoModelo;

?>