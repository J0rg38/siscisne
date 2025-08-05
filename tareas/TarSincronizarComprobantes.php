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


require_once($InsProyecto->MtdRutLibrerias().'fpdf17/fpdf.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

//50.62.8.12
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

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');


if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//$FechaInicio = date("d/m/Y");
$FechaInicio =  (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

$InsFactura = new ClsFactura();
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","DESC","10",NULL,5,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,NULL,NULL,NULL,NULL,NULL);
$ArrFacturas = $ResFactura['Datos'];

if(!empty($ArrFacturas)){
	$fila = 1;
	foreach($ArrFacturas as $DatFactura){
		
    
			if($DatFactura->MonId<>$EmpresaMonedaId ){

				$DatFactura->FacSubTotal = ($DatFactura->FacSubTotal / $DatFactura->FacTipoCambio);
				$DatFactura->FacImpuesto = ($DatFactura->FacImpuesto / $DatFactura->FacTipoCambio);
				$DatFactura->FacTotal = ($DatFactura->FacTotal / $DatFactura->FacTipoCambio);
			
			}
			
		
		echo "[Fila ".$fila."]> ";
		
		echo " ".$DatFactura->FtaNumero." ".$DatFactura->FacId;
		echo "<br>";
		echo " ".$DatFactura->CliNombre;
		echo "<br>";
		echo " ".$DatFactura->CliNumeroDocumento;
		echo "<br>";
		echo " ".$EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".pdf";
		echo "<br>";

		
		$Comprobante['Numero'] = $DatFactura->FacId;
		$Comprobante['Serie'] = $DatFactura->FtaNumero;

		$Comprobante['Fecha'] = $DatFactura->FacFechaEmision;
		$Comprobante['Cliente'] = trim($DatFactura->CliNombre);
		$Comprobante['ClienteNumeroDocumento'] = trim($DatFactura->CliNumeroDocumento);
		$Comprobante['ClienteDireccion'] = $DatFactura->FacDireccion;

		$Comprobante['Estado'] = $DatFactura->FacEstado;
		$Comprobante['Clave'] = $DatFactura->CliClaveElectronica;

		$Comprobante['SubTotal'] = $DatFactura->FacSubTotal;
		$Comprobante['Impuesto'] = $DatFactura->FacImpuesto;
		$Comprobante['Total'] = $DatFactura->FacTotal;
		
		$Comprobante['ArchivoPDFNombre'] = $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".pdf";
		$Comprobante['ArchivoXMLNombre'] = $EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".xml";
		$Comprobante['ArchivoCDRNombre'] = "R-".$EmpresaCodigo.'-01-'.$DatFactura->FtaNumero.'-'.$DatFactura->FacId.".zip";
		
		$RutaArchivoPDF = "../generados/comprobantes_pdf/".str_replace(' ', '_', $Comprobante['ArchivoPDFNombre']);
		
		$ArchivoPDF="";
		
		if(file_exists($RutaArchivoPDF)){
			$ArchivoPDF = file_get_contents($RutaArchivoPDF);				
		}

		
		$RutaArchivoXML = "../recibidos/comprobantes/".str_replace(' ', '_', $Comprobante['ArchivoXMLNombre']);
		
		$ArchivoXML="";
		
		if(file_exists($RutaArchivoXML)){
			$ArchivoXML = file_get_contents($RutaArchivoXML);				
		}
		
		
		$RutaArchivoCDR = "../recibidos/comprobantes/".str_replace(' ', '_', $Comprobante['ArchivoCDRNombre']);
		
		$ArchivoCDR = "";
		
		if(file_exists($RutaArchivoCDR)){
			$ArchivoCDR = file_get_contents($RutaArchivoCDR);				
		}
		
		$Comprobante['ArchivoPDF'] = ($ArchivoPDF);
		$Comprobante['ArchivoXML'] = ($ArchivoXML);
		$Comprobante['ArchivoCDR'] = ($ArchivoCDR);
		
		//$JnComprobante = json_encode($Comprobante);
		$json = new Services_JSON();
//		echo "JSON: ";
//		echo $json->encode($Comprobante);
//		echo "<br>";
		echo "<br>";
		echo "Procesando...";
		echo "<br>";
		
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