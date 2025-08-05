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

$remote_file = '/FIRMA/'.$file.'.xml';
$local_file = $ruta_local.'/'.$file.'.xml';

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
		
		$string = file_get_contents($local_file);
		$parser = xml_parser_create('');
  
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($string), $xml_values);
		xml_parser_free($parser);

		$InsBoleta = new ClsBoleta();
		$InsBoleta->BolId = $GET_id;
		$InsBoleta->BtaId = $GET_ta;
		
		$digestvalue = "";
		$signaturevalue = "";

//deb($xml_values);
		for($i=10;$i<=150;$i++){

			if($xml_values[$i]['tag']=="ds:DigestValue"){
				$digestvalue = $xml_values[$i]['value'];
			}

			if($xml_values[$i]['tag']=="ds:SignatureValue"){
				$signaturevalue = $xml_values[$i]['value'];
			}

		}
		
		
		
	//	deb($xml_values[42]['value']);
		//deb($xml_values[0][42]->value);
		//deb($xml_values[0][45]->value);
		
		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioDigestValue",$digestvalue,$InsBoleta->BolId,$InsBoleta->BtaId);
		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioSignatureValue",$signaturevalue,$InsBoleta->BolId,$InsBoleta->BtaId);
		
//		/*
//		31 TICKET
//		34 FECHA
//		35 HORA
//		65 RESPUESTA CODIGO
//		59 RUC /X
//		66 RESPUESTA
//		*/
//		
//		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTicket",$xml_values[31]['value'],$InsBoleta->BolId,$InsBoleta->BtaId);
//		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioFecha",$xml_values[34]['value'],$InsBoleta->BolId,$InsBoleta->BtaId);
//		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioHora",$xml_values[35],$InsBoleta->BolId,$InsBoleta->BtaId);
//		
//		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioCodigo",$xml_values[65]['value'],$InsBoleta->BolId,$InsBoleta->BtaId);
//		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioContenido",$xml_values[66]['value'],$InsBoleta->BolId,$InsBoleta->BtaId);
//		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsBoleta->BolId,$InsBoleta->BtaId);
//		
//		$Observaciones = $InsBoleta->BolSunatRespuestaObservacion;
//		$Observaciones .= date("d/m/Y h:i:s")." - ".$xml_values[66]['value'].chr(13);
//		
//		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaObservacion",$Observaciones,$InsBoleta->BolId,$InsBoleta->BtaId);
//		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicket",(!empty($xml_values[31]['value'])?$xml_values[31]['value']:$InsBoleta->BolSunatRespuestaTicket),$InsBoleta->BolId,$InsBoleta->BtaId);
//		$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicketEstado","",$InsBoleta->BolId,$InsBoleta->BtaId);
	if(empty($digestvalue) or empty($signaturevalue)){
		$Respuesta = 3;
	}else{
		$Respuesta = 1;	
	}
	
} else {
	$Respuesta = 2;
}

// close the connection
ftp_close($conn_id);

$respuesta['Nombre'] = $GET_Nombre;
$respuesta['CodigoRespuesta'] = $Respuesta;
$respuesta['ArchivoRemoto'] = $remote_file;
$respuesta['ArchivoLocal'] = $local_file;

$respuesta['DigestValue'] = $digestvalue;
$respuesta['SignatureValue'] = $signaturevalue;
//$respuesta['ArchivoEnviar'] = $local_file;

echo json_encode($respuesta);
?>