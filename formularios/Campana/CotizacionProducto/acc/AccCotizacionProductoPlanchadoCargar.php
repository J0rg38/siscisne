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


	$ArrPlanchados = array(
	"Planchado y centrado de capot",
	"Planchado y centrado de puerta maletero",
	"Planchado de puerta delantera LH",
	"Planchado de puerta posterior LH",
	"Centrar y cuadrar compacto delantero",
	"Centrar y cuadrar compacto posterior",
	"Centrar y cuadrar tina radiador"
	);
	
	foreach($ArrPlanchados as $DatPlanchado){
	
		$InsCotizacionProductoPlanchado = new ClsCotizacionProductoPlanchadoPintado();
		$InsCotizacionProductoPlanchado->CppId = NULL;
		$InsCotizacionProductoPlanchado->CprId = $POST_CotizacionProductoId;
		$InsCotizacionProductoPlanchado->CppDescripcion = strtoupper($DatPlanchado);
		$InsCotizacionProductoPlanchado->CppPrecio = 0;
		$InsCotizacionProductoPlanchado->CppCantidad = 1;
		$InsCotizacionProductoPlanchado->CppImporte = 0;
		$InsCotizacionProductoPlanchado->CppTipo = "L";
		$InsCotizacionProductoPlanchado->CppEstado = 2;
		$InsCotizacionProductoPlanchado->CppTiempoCreacion = date("Y-m-d H:i:s");
		$InsCotizacionProductoPlanchado->CppTiempoModificacion = date("Y-m-d H:i:s");
	
		if($InsCotizacionProductoPlanchado->MtdRegistrarCotizacionProductoPlanchadoPintado()){
			
		}

	}
	
//}
	

?>