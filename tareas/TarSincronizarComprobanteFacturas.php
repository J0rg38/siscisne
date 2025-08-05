<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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


//require_once('../librerias/nusoap-0.9.5/lib/nusoap.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');
//require_once('../librerias/JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');

require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');


//require_once($InsProyecto->MtdRutLibrerias().'fpdf17/fpdf.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

$client = new nusoap_client('http://50.62.8.123/comprobantes/webservice/WsComprobante.php?wsdl','wsdl');

$err = $client->getError();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>

<body>
<?php

$GET_Accion = $_GET['Accion'];

$ftp_server = "50.62.8.123";
$ftp_user_name = "comprobantes";
$ftp_user_pass = "comprobantes";


require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//$FechaInicio = date("d/m/Y");
$FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

$InsFactura = new ClsFactura();
// MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL) {
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","DESC",NULL,NULL,NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,NULL,NULL,NULL,NULL,NULL);
$ArrFacturas = $ResFactura['Datos'];


if(!empty($ArrFacturas)){
	$fila = 1;
	foreach($ArrFacturas as $DatFactura){
		
		
		if($DatFactura->MonId<>$EmpresaMonedaId){

				$DatFactura->FacSubTotal = ($DatFactura->FacSubTotal / $DatFactura->FacTipoCambio);
				$DatFactura->FacImpuesto = ($DatFactura->FacImpuesto  / $DatFactura->FacTipoCambio);
				$DatFactura->FacTotal = ($DatFactura->FacTotal / $DatFactura->FacTipoCambio);
				
		}


		echo "<b>";
		echo "[Fila ".$fila."]> ";
		echo "</b>";
				
		echo " ".$DatFactura->FtaNumero." ".$DatFactura->FacId;
		echo "<br>";
		
		echo " ".$DatFactura->CliNumeroDocumento;
		echo "<br>";
		
		echo " ".$DatFactura->CliNombre." ".$DatFactura->CliApellidoPaterno." ".$DatFactura->CliApellidoMaterno;
		echo "<br>";
		
		echo " ".$DatFactura->FacTotal;
		echo "<br>";
		echo "<br>";
		$Comprobante['Numero'] = $DatFactura->FacId;
		$Comprobante['Serie'] = $DatFactura->FtaNumero;
		
		$Comprobante['Fecha'] = $DatFactura->FacFechaEmision;
		$Comprobante['Cliente'] = $DatFactura->CliNombre." ".$DatFactura->CliApellidoPaterno." ".$DatFactura->CliApellidoMaterno;
		$Comprobante['ClienteNumeroDocumento'] = $DatFactura->CliNumeroDocumento;
		$Comprobante['ClienteDireccion'] = $DatFactura->FacDireccion;
		$Comprobante['ClienteEmail'] = $DatFactura->CliEmail;
		
		$Comprobante['Estado'] = $DatFactura->FacEstado;
		$Comprobante['Clave'] = $DatFactura->CliClaveElectronica;
		
		$Comprobante['MonedaId'] = $DatFactura->MonId;
		
		$Comprobante['SubTotal'] = $DatFactura->FacSubTotal;
		$Comprobante['Impuesto'] = $DatFactura->FacImpuesto;
		$Comprobante['Total'] = $DatFactura->FacTotal;
		$Comprobante['Tipo'] = 1;
		$Comprobante['TipoComprobante'] = 1;





		$Comprobante['ArchivoPDFNombre'] = $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".pdf";
		$Comprobante['ArchivoXMLNombre'] = $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".xml";
		$Comprobante['ArchivoCDRNombre'] = 'R-'.$EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".zip";
		
		echo "<br>";
		echo "RutaArchivoPDF_alt: ";
		echo $RutaArchivoPDF_alt = "../generados/comprobantes_pdf/".str_replace(' ', '_', $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".pdf");
		echo "<br>";
		echo "<br>";		
		//echo "RutaArchivoXML: ";
		//echo $RutaArchivoXML = "../generados/comprobantes/".str_replace(' ', '_', $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".xml");
		//echo "<br>";
		echo "RutaArchivoXML_alt: ";
		echo $RutaArchivoXML_alt = "../generados/comprobantes_fir/".str_replace(' ', '_', $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".xml");
		echo "<br>";
		echo "RutaArchivoXML_alt2: ";
		echo $RutaArchivoXML_alt2 = "../recibidos/comprobantes/".str_replace(' ', '_', $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".xml");
		echo "<br>";
		echo "<br>";
			
		echo "RutaArchivoCDR: ";
		echo $RutaArchivoCDR_alt = "../generados/comprobantes_cdr/R-".str_replace(' ', '_', $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".zip");		
		echo "<br>";
		echo "RutaArchivoCDR_alt: ";
		echo $RutaArchivoCDR_alt2 = "../recibidos/comprobantes/R".str_replace(' ', '_', $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".zip");		
		echo "<br>";
		
		$ArchivoPDF="";
		$ArchivoXML="";
		$ArchivoCDR="";
		
		echo "<br>";	
		echo "<br>";	
		
		if(file_exists($RutaArchivoPDF_alt)){			
			//$ArchivoPDF = file_get_contents($RutaArchivoPDF);	
			$RutaArchivoPDF = $RutaArchivoPDF_alt;
			echo "Existe archivo RutaArchivoPDF_alt";
			echo "<br>";				
		}else{
			echo "No existe archivo PDF";
			echo "<br>";	
		}

		//http://192.168.10.2:8080/sistema/recibidos/comprobantes/20410705878-01-B002-000296.xml
		if(file_exists($RutaArchivoXML_alt)){
			//$ArchivoXML = file_get_contents($RutaArchivoXML_alt);	
			$RutaArchivoXML = $RutaArchivoXML_alt;
			echo "Existe archivo RutaArchivoXML_alt";
			echo "<br>";				
		}else if(file_exists($RutaArchivoXML_alt2)){
			//$ArchivoXML = file_get_contents($RutaArchivoXML_alt2);	
			$RutaArchivoXML = $RutaArchivoXML_alt2;
			echo "Existe archivo RutaArchivoXML_alt2";
			echo "<br>";				
		}else{
			echo "No existe archivo XML";
			echo "<br>";		
		}
		
		if(file_exists($RutaArchivoCDR_alt)){
			//$ArchivoCDR = file_get_contents($RutaArchivoCDR);	
			$RutaArchivoCDR = $RutaArchivoCDR_alt;
			echo "Existe archivo RutaArchivoCDR_alt";
			echo "<br>";			
		}else if(file_exists($RutaArchivoCDR_alt2)){
			//$ArchivoCDR = file_get_contents($RutaArchivoCDR_alt);	
			$RutaArchivoCDR = $RutaArchivoCDR_alt2;
			echo "Existe archivo RutaArchivoCDR_alt2";
			echo "<br>";				
		}else{
			echo "No existe archivo CDR";
			echo "<br>";			
		}
		
		//if(!empty($ArchivoPDF)){
//			$ArchivoPDF = base64_encode($ArchivoPDF);
//		}
//		
//		if(!empty($ArchivoXML)){
//			$ArchivoXML = base64_encode($ArchivoXML);
//		}
//		
//		if(!empty($ArchivoCDR)){
//			$ArchivoCDR = base64_encode($ArchivoCDR);
//		}
		
		//$Comprobante['ArchivoPDF'] = ($ArchivoPDF);
		//$Comprobante['ArchivoXML'] = ($ArchivoXML);
		//$Comprobante['ArchivoCDR'] = ($ArchivoCDR);
		
					
					
		echo "<br>";	
		echo "<br>";	
			
			$Respuesta = 0;
			
			$file = $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId;
			$remote_filePDF = '/comprobantes_pdf/'.$EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".pdf";
			$remote_fileXML = '/comprobantes_xml/'.$EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".xml";
			$remote_fileCDR = '/comprobantes_cdr/R-'.$EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".zip";
			
			$local_filePDF = $RutaArchivoPDF;
			$local_fileXML = $RutaArchivoXML;
			$local_fileCDR = $RutaArchivoCDR;
			
			// set up basic connection
			$conn_id = ftp_connect($ftp_server);
			
			// login with username and password
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
			ftp_pasv($conn_id, true);
					
			
			// upload a file
			if (ftp_put($conn_id, $remote_filePDF, $local_filePDF, FTP_ASCII)) {
				echo "FTP subio PDF correctamente.";
				echo "<br>";
				$Respuesta = 1;
			} else {
				echo "FTP no subio PDF.";
				echo "<br>";
				$Respuesta = 2;
			}
			
			if (ftp_put($conn_id, $remote_fileXML, $local_fileXML, FTP_ASCII)) {
				echo "FTP subio XML correctamente.";
				echo "<br>";
				$Respuesta = 1;
			} else {
				echo "FTP no subio XML.";
				echo "<br>";
				$Respuesta = 2;
			}
						
			
						
			if (ftp_put($conn_id, $remote_fileCDR, $local_fileCDR, FTP_ASCII)) {
				echo "FTP subio CDR correctamente.";
				echo "<br>";
				$Respuesta = 1;
			} else {
				echo "FTP no subio CDR.";
				echo "<br>";
				$Respuesta = 2;
			}
			
			// close the connection
			ftp_close($conn_id);
			
			
		
//		deb($ArchivoPDF);
		//$JnComprobante = json_encode($Comprobante);
		$json = new Services_JSON();
		
		echo "<br>";
		echo "Procesando...";
		echo "<br>";
//		echo "JSON: ";
		//echo $json->encode($Comprobante);
//		echo "<br>";
		//$param = array(	'oComprobante' => json_encode($Comprobante));
		$param = array(	'oComprobante' => $json->encode($Comprobante));
		
		$Respuesta = $client->call('MtdProcesarComprobante', $param);

		echo "Respuesta: ".$Respuesta;
		echo "<br>";
		
		switch($Respuesta){
			case 1:
				echo "Se registro correctamente el comprobante";
				echo "<br>";
			break;
			
			case 2:
				echo "No se pudo registrar el comprobante";
				echo "<br>";
			break;
			
			case 3:
				echo "Se edito correctamente el comprobante";
				echo "<br>";
			break;
			
			case 4:
				echo "No se pudo editar el comprobante";
				echo "<br>";
			break;
			
			case 5:
				echo "Cliente no identificado";
				echo "<br>";
			break;
			
			
			default:
			
			break;
		}
		
		$fila++;	
		
		echo "<br>";		
	}
}else{
	echo "No se encontraron facturas<br />";
}

//				$param = array(
//				'oId' => $DatVentaDirectaExterna->VdiId,
//				'oCampo' => "VdiResultado",
//				'oDato' => $Resultado);
//				$EditoVentaDirectaDato  = $client->call('MtdEditarVentaDirectaDato', $param);

echo "------------------------------------------<br />";
echo "Proceso Terminado<br />";
echo date("d/m/Y H:i:s")."<br />";
echo "------------------------------------------<br />";
?>


</body>
</html>