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


$InsBoleta = new ClsBoleta();
$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;

// upload a file
//$fp = fopen($local_file, 'w');
if (ftp_get($conn_id, $local_file, $remote_file, FTP_BINARY)) {

	
	$z = new ZipArchive();

	if ($z->open($local_file)) {

		
		$string = $z->getFromName('R-'.$file.'.xml');
		
		$parser = xml_parser_create('');
  
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($string), $xml_values);
		xml_parser_free($parser);

//deb($xml_values);

			$InsBoleta = new ClsBoleta();
			$InsBoleta->BolId = $GET_id;
			$InsBoleta->BtaId = $GET_ta;
			
			/*
			31 TICKET
			34 FECHA
			35 HORA
			65 RESPUESTA CODIGO
			59 RUC /X
			66 RESPUESTA
			*/
			
			$FechaRespuesta = "";
			$HoraRespuesta = "";
			$TicketRespuesta = "";
			$MensajeRespuesta = "";
			$CodigoRespueta = "";
			
			for($i=0;$i<=81;$i++){
					
				if($xml_values[$i]['tag']=="cbc:ID" and $xml_values[$i]['level']==2){
					$TicketRespuesta = $xml_values[$i]['value'];
				}
				
				if($xml_values[$i]['tag']=="cbc:ResponseDate" and $xml_values[$i]['level']==2){
					$FechaRespuesta = $xml_values[$i]['value'];
				}
				
				if($xml_values[$i]['tag']=="cbc:ResponseTime" and $xml_values[$i]['level']==2){
					$HoraRespuesta = $xml_values[$i]['value'];
				}
				
				if($xml_values[$i]['tag']=="cbc:ResponseCode" and $xml_values[$i]['level']==4){
					$CodigoRespueta = $xml_values[$i]['value'];
					//if($CodigoRespueta=="0" || $CodigoRespueta==0){
					//	$CodigoRespueta = "0001";
					//
				}
				
				if($xml_values[$i]['tag']=="cbc:Description" and $xml_values[$i]['level']==4){
					$MensajeRespuesta = $xml_values[$i]['value'];
				}
				
			}
			
						
			$CodigoRespuesta = $Trama['CodigoRespuesta'] + 1 - 1;
			$UltimaRespuesta = "";
			
			if($CodigoRespuesta>= 100 and $CodigoRespuesta <=1999){
				$UltimaRespuesta = "EXCEPCION";
			}else if($CodigoRespuesta>= 2000 and $CodigoRespuesta <=3999){
				$UltimaRespuesta = "RECHAZO";	
			}else if($CodigoRespuesta>= 4000){
				$UltimaRespuesta = "OBSERVADO";	
			}else{
				$UltimaRespuesta = "APROBADO";
			}

			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTicket",$TicketRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);
			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioFecha",$FechaRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);
			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioHora",$HoraRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);
			
			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioCodigo",$CodigoRespueta,$InsBoleta->BolId,$InsBoleta->BtaId);
			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioContenido",$MensajeRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);
			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsBoleta->BolId,$InsBoleta->BtaId);

			$Observaciones = $InsBoleta->BolSunatRespuestaObservacion;
			$Observaciones .= date("d/m/Y h:i:s")." - ".$xml_values[66]['value'].chr(13);
			
			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaObservacion",$Observaciones,$InsBoleta->BolId,$InsBoleta->BtaId);
			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicket",(!empty($TicketRespuesta)?$TicketRespuesta:$InsBoleta->BolSunatRespuestaTicket),$InsBoleta->BolId,$InsBoleta->BtaId);
			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicketEstado","",$InsBoleta->BolId,$InsBoleta->BtaId);
			
			$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaAccion","ALTA",$InsBoleta->BolId,$InsBoleta->BtaId);
			$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaRespuesta",$UltimaRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);

	}

	$Respuesta = 1;
} else {
	$Respuesta = 2;
}

// close the connection
ftp_close($conn_id);


	
$respuesta['CodigoRespuesta'] = $Respuesta;
$respuesta['ArchivoRemoto'] = $remote_file;
$respuesta['ArchivoLocal'] = $local_file;

//$respuesta['ArchivoEnviar'] = $local_file;

echo json_encode($respuesta);
?>