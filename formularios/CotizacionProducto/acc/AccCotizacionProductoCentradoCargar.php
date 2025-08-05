<?php
session_start();
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

$POST_CotizacionProductoId = $_POST['CotizacionProductoId'];
	
	require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');
	
	
	$ArrCentrados = array(
	"Centrado y cuadrado de capot",
	"Centrado y cuadrado de puerta maletero",
	"Centrado de puerta delantera LH",
	"Centrado de puerta posterior LH",
	"Centrar y cuadrar compacto delantero",
	"Centrar y cuadrar compacto posterior",
	"Centrar y cuadrar tina radiador"
	);
	
	foreach($ArrCentrados as $DatCentrado){

		$InsCotizacionProductoCentrado = new ClsCotizacionProductoPlanchadoPintado();

		$InsCotizacionProductoCentrado->CppId = NULL;
		$InsCotizacionProductoCentrado->CprId = $POST_CotizacionProductoId;
		$InsCotizacionProductoCentrado->CppDescripcion = strtoupper($DatCentrado);						
		$InsCotizacionProductoCentrado->CppPrecio = 0;
		$InsCotizacionProductoCentrado->CppCantidad = 1;
		$InsCotizacionProductoCentrado->CppImporte = 0;
		$InsCotizacionProductoCentrado->CppTipo = "C";
		$InsCotizacionProductoCentrado->CppEstado = 2;
		$InsCotizacionProductoCentrado->CppTiempoCreacion = date("Y-m-d H:i:s");
		$InsCotizacionProductoCentrado->CppTiempoModificacion = date("Y-m-d H:i:s");

		if($InsCotizacionProductoCentrado->MtdRegistrarCotizacionProductoPlanchadoPintado()){
			
		}
	
	}

?>