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

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$Respuesta = 0;

$file = $GET_Nombre;
$ruta_local = '../../../recibidos/comprobantes';

$remote_file = '/RPTA/R'.$file.'.zip';
$local_file = $ruta_local.'/R'.$file.'.zip';

$remote_file2 = '/FIRMA/R'.$file.'.xml';
$local_file2 = $ruta_local.'/R'.$file.'.xml';


$ftp_server = $SistemaIpFacturador;
$ftp_user_name = "sunat";
$ftp_user_pass = "sunat";

// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
ftp_pasv($conn_id, true);

$InsNotaCredito = new ClsNotaCredito();
$InsNotaCredito->NcrId = $GET_id;
$InsNotaCredito->NctId = $GET_ta;
//$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaAccion","ALTA",$InsNotaCredito->NcrId,$InsNotaCredito->NctId);

// upload a file
//$fp = fopen($local_file, 'w');
if (ftp_get($conn_id, $local_file, $remote_file, FTP_BINARY)) {

	//ftp_get($conn_id, $local_file2, $remote_file2, FTP_BINARY);
	
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
			
						
			$CodigoRespuesta = $CodigoRespueta + 1 - 1;
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



			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioTicket",$TicketRespuesta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioFecha",$FechaRespuesta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioHora",$HoraRespuesta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
			
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioCodigo",$CodigoRespueta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioContenido",$MensajeRespuesta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsNotaCredito->NcrId,$InsNotaCredito->NctId);

			$Observaciones = $InsNotaCredito->NcrSunatRespuestaObservacion;
			$Observaciones .= date("d/m/Y h:i:s")." - ".$xml_values[66]['value'].chr(13);
			
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaObservacion",$Observaciones,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaTicket",(!empty($TicketRespuesta)?$TicketRespuesta:$InsNotaCredito->NcrSunatRespuestaTicket),$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaTicketEstado","",$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
			
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaAccion","ALTA",$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
			$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaRespuesta",$UltimaRespuesta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);


	
		//$string = preg_replace('/\s+/', '', $string);
		//deb($string);
		//
		//$peliculas =  simplexml_load_string($string);
		
	//	print_r($peliculas);
		
		//echo $peliculas;
		
		//$xml_respuesta = simplexml_load_string($string);
		//$xml_respuesta = new SimpleXMLElement($string);
		
		//deb($xml_respuesta->IssueTime);	
		
//		printf($xml_respuesta);
		
	}

	//$xml_respuesta = file_get_contents('zip://'.realpath($local_file).'#R-'.$file.'.xml');
	
	//$zip = zip_open($local_file);

	/*if ($zip)
	  {
	  while ($zip_entry = zip_read($zip))
		{
		//echo "<p>";
		//echo "Name: " . zip_entry_name($zip_entry) . "<br />";
	
		if (zip_entry_open($zip, $zip_entry))
		  {
		  //echo "File Contents:<br/>";
		 echo  $contents = zip_entry_read($zip_entry);
		//echo "<br><br>";  
		 // $xml_respuesta = simplexml_load_string($contents);
		  
		 // deb($xml_respuesta);
		 // echo "$contents<br />";
		  zip_entry_close($zip_entry);
		  }
		//echo "</p>";
	  }
	
	zip_close($zip);
	}*/


	$Respuesta = 1;
} else {
	$Respuesta = 2;
}

// close the connection
ftp_close($conn_id);

$respuesta['NcrId'] = $InsNotaCredito->NcrId;
$respuesta['NctId'] = $InsNotaCredito->NctId;
	
$respuesta['CodigoRespuesta'] = $Respuesta;
$respuesta['ArchivoRemoto'] = $remote_file;
$respuesta['ArchivoLocal'] = $local_file;

//$respuesta['ArchivoEnviar'] = $local_file;

echo json_encode($respuesta);
?>