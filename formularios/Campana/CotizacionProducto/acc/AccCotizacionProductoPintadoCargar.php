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


	$ArrPintados = array(
	"PARACHOQUE DELANTERO",
	"PARACHOQUE POSTERIOR",
	"PUERTA DELANTERA LH",
	"PUERTA POSTERIOR LH",
	"CAPOT",
	"PUERTA MALETERO",
	"ESPEJO RETROVISOR DELANTERO LH"
	);

	foreach($ArrPintados as $DatPintado){

		$InsCotizacionProductoPintado = new ClsCotizacionProductoPlanchadoPintado();
		$InsCotizacionProductoPintado->CppId = NULL;
		$InsCotizacionProductoPintado->CprId = $POST_CotizacionProductoId;
		$InsCotizacionProductoPintado->CppDescripcion = strtoupper($DatPintado);						
		$InsCotizacionProductoPintado->CppPrecio = 0;
		$InsCotizacionProductoPintado->CppCantidad = 1;
		$InsCotizacionProductoPintado->CppImporte = 0;
		$InsCotizacionProductoPintado->CppTipo = "I";
		$InsCotizacionProductoPintado->CppEstado = 2;
		$InsCotizacionProductoPintado->CppTiempoCreacion = date("Y-m-d H:i:s");
		$InsCotizacionProductoPintado->CppTiempoModificacion = date("Y-m-d H:i:s");
	
		if($InsCotizacionProductoPintado->MtdRegistrarCotizacionProductoPlanchadoPintado()){
			
		}
	
		
	}	

?>