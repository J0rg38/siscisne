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
////require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

$GET_Nombre = $_GET['Nombre'];
$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];


require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$Respuesta = 0;

$file = $GET_Nombre;
$ruta_local = '../../../recibidos/comprobantes';

$remote_file = '/RPTA/R'.$file.'.zip';
$local_file = $ruta_local.'/R'.$file.'.zip';

$ftp_server = $SistemaIpFacturador;
$ftp_user_name = "sunat";
$ftp_user_pass = "sunat";
// set up basic connection
$conn_id = ftp_connect($ftp_server);
// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
ftp_pasv($conn_id, true);

// upload a file
//$fp = fopen($local_file, 'w');
if (ftp_get($conn_id, $local_file, $remote_file, FTP_BINARY)) {	
	$Respuesta = 1;
} else {
	$Respuesta = 2;
}

// close the connection
ftp_close($conn_id);

$respuesta['CodigoRespuesta'] = $Respuesta;
$respuesta['ArchivoRemoto'] = $remote_file;
$respuesta['ArchivoLocal'] = $local_file;
$respuesta['Nombre'] = 'R'.$file.'.zip';

echo json_encode($respuesta);
?>