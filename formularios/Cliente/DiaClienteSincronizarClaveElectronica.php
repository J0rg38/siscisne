 <?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsCliente = new ClsCliente();
$InsCliente->CliId = $GET_id;
$InsCliente->MtdObtenerCliente();

//echo "=================================";
//echo "<br>";
echo "Sincronizar clave electronica";
//echo "<br>";
//echo "=================================";
echo "<br>";


echo "Num. Doc.: ".$InsCliente->CliNumeroDocumento;
echo "<br>";
echo "Nombre: ".$InsCliente->CliNombre;
echo "<br>";

$client = new nusoap_client('http://50.62.8.123/comprobantes/webservice/WsCliente.php?wsdl','wsdl');

$err = $client->getError();

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//$json = new Services_JSON();
		
//echo "<br>";
echo "Procesando...";
echo "<br>";

$Comprobante['ClienteNumeroDocumento'] = $InsCliente->CliNumeroDocumento;
$Comprobante['ClienteClaveElectronica'] = $InsCliente->CliClaveElectronica;
		
//$param = array(	'oComprobante' => $json->encode($Comprobante));
$param = array(	'oComprobante' => json_encode($Comprobante));

$Respuesta = $client->call('MtdActualizarClienteClaveElectronica', $param);

echo "Respuesta: ".$Respuesta;
echo "<br>";

switch($Respuesta){
	case 1:
		echo "Se sincronizo correctamente la clave electronica";
		echo "<br>";	
	break;
	
	case 2:
		echo "No se pudo sincronizar la clave electronica, intente nuevamente";
		echo "<br>";	
	break;
	
	case 3:
		echo "No se pudo identificar al cliente";
		echo "<br>";
	break;
	
	default:
		echo "Ha ocurrido un error interno";
		echo "<br>";
	break;
	
}

echo "<br>";
echo "<br>";

echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");
echo "<br>";
?>
