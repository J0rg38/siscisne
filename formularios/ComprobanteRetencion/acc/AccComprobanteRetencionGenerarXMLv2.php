<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
////require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');



$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsComprobanteRetencion->CrnId = $GET_id;
$InsComprobanteRetencion->CrtId = $GET_ta;
$InsComprobanteRetencion->MtdObtenerComprobanteRetencion();


//deb($InsComprobanteRetencion->CrnTipoCambio);
if($InsComprobanteRetencion->MonId<>$EmpresaMonedaId){
	
	$InsComprobanteRetencion->CrnTotalRetenido = round($InsComprobanteRetencion->CrnTotalRetenido/$InsComprobanteRetencion->CrnTipoCambio,2);	
	$InsComprobanteRetencion->CrnTotalPagar = round($InsComprobanteRetencion->CrnTotalPagar/$InsComprobanteRetencion->CrnTipoCambio,2);	
	$InsComprobanteRetencion->CrnTotalBruto = round($InsComprobanteRetencion->CrnTotalBruto/$InsComprobanteRetencion->CrnTipoCambio,2);	
	
}
	

$InsComprobanteRetencion->CrnTotalRetenido = round($InsComprobanteRetencion->CrnTotalRetenido,2);
$InsComprobanteRetencion->CrnTotalPagar = round($InsComprobanteRetencion->CrnTotalPagar,2);
$InsComprobanteRetencion->CrnTotalBruto = round($InsComprobanteRetencion->CrnTotalBruto,2);



$NOMBRE = $EmpresaCodigo.'-20-'.$InsComprobanteRetencion->CrtNumero.'-'.$InsComprobanteRetencion->CrnId;
$ARCHIVO = $NOMBRE.'.xml';

$domtree = new DOMDocument('1.0', 'ISO-8859-1');
//$domtree->preserveWhiteSpace = false;
$domtree->formatOutput = true;
$domtree->xmlStandalone = false;

/* create the root element of the xml tree */
$xmlRoot = $domtree->createElement("Retention");
/* append it to the document created */
$xmlRoot = $domtree->appendChild($xmlRoot);

/*

<Retention
xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:Retention-1"
xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
xmlns:ccts="urn:un:unece:uncefact:documentation:2"
xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2"
xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1"
xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
*/
$xmlRoot->setAttribute('xmlns', 'urn:sunat:names:specification:ubl:peru:schema:xsd:Retention-1');
$xmlRoot->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$xmlRoot->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$xmlRoot->setAttribute('xmlns:ccts', 'urn:un:unece:uncefact:documentation:2');
$xmlRoot->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
$xmlRoot->setAttribute('xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
$xmlRoot->setAttribute('xmlns:qdt', 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2');
$xmlRoot->setAttribute('xmlns:sac', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1');
$xmlRoot->setAttribute('xmlns:udt', 'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2');
$xmlRoot->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

//ext:UBLExtensions
$UBLExtensions = $domtree->createElement("ext:UBLExtensions");
$UBLExtensions = $xmlRoot->appendChild($UBLExtensions);
	
	//ext:UBLExtension
	$UBLExtension = $domtree->createElement("ext:UBLExtension");
	$UBLExtension = $UBLExtensions->appendChild($UBLExtension);
	
		//sac:ExtensionContent
		$ExtensionContent = $domtree->createElement("ext:ExtensionContent");
		$ExtensionContent = $UBLExtension->appendChild($ExtensionContent);

//ext:UBLVersionID
$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","2.0");
$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);

//ext:CustomizationID
$CustomizationID = $domtree->createElement("cbc:CustomizationID","1.0");
$CustomizationID = $xmlRoot->appendChild($CustomizationID);

//cac:Signature
$Signature = $domtree->createElement("cac:Signature");
$Signature = $xmlRoot->appendChild($Signature);

	//cbc:ID
	$ID = $domtree->createElement("cbc:ID","IDSignSP");
	$ID = $Signature->appendChild($ID);
	
	//cac:SignatoryParty
	$SignatoryParty = $domtree->createElement("cac:SignatoryParty");
	$SignatoryParty = $Signature->appendChild($SignatoryParty);
	
		//cac:PartyIdentification
		$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
		$PartyIdentification = $SignatoryParty->appendChild($PartyIdentification);
	
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$EmpresaCodigo);
			$ID = $PartyIdentification->appendChild($ID);
		
			//cac:PartyName
			$base = $SignatoryParty->appendChild($domtree->createElement( 'cac:PartyName' ));
			
			//cac:Name		
			$name = $base->appendChild($domtree->createElement('cbc:Name')); 
			$name->appendChild($domtree->createCDATASection( $EmpresaNombre )); 
			
	//cac:DigitalSignatureAttachment
	$DigitalSignatureAttachment = $domtree->createElement("cac:DigitalSignatureAttachment");
	$DigitalSignatureAttachment = $Signature->appendChild($DigitalSignatureAttachment);

		//cac:ExternalReference
		$ExternalReference = $domtree->createElement("cac:ExternalReference");
		$ExternalReference = $DigitalSignatureAttachment->appendChild($ExternalReference);
			
			//cbc:URI
			$URI = $domtree->createElement("cbc:URI","#SignatureSP");
			$URI = $ExternalReference->appendChild($URI);


//cbc:ID
$ID = $domtree->createElement("cbc:ID",$InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsComprobanteRetencion->CrnFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);
	
			
//cac:AgentParty
$AgentParty = $domtree->createElement("cac:AgentParty");
$AgentParty = $xmlRoot->appendChild($AgentParty);

	//cbc:CustomerAssignedAccountID
	$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
	$PartyIdentification = $AgentParty->appendChild($PartyIdentification);
	
		//cbc:ID 
		$ID = $domtree->createElement("cbc:ID",$EmpresaCodigo);
		$ID->setAttribute('schemeID', "6");
		$ID = $PartyIdentification->appendChild($ID);	
	
	
 	//cac:PartyName
	$PartyName = $domtree->createElement("cac:PartyName");
	$PartyName = $AgentParty->appendChild($PartyName);
	
		//cbc:Name		
		$Name = $domtree->createElement("cbc:Name");
		$Name = $PartyName->appendChild($Name);
		$Name->appendChild($domtree->createCDATASection($EmpresaNombre)); 


	//cac:PostalAddress
	$PostalAddress = $domtree->createElement("cac:PostalAddress");
	$PostalAddress = $AgentParty->appendChild($PostalAddress);

		//cac:ID
		$ID = $domtree->createElement("cbc:ID",$EmpresaCodigoUbigeo );
		$ID = $PostalAddress->appendChild($ID);
		
		//cac:StreetName
		$StreetName = $domtree->createElement("cbc:StreetName",$EmpresaDireccion);
		$StreetName = $PostalAddress->appendChild($StreetName);
		
		////cbc:CitySubdivisionName
		//$CitySubdivisionName = $domtree->createElement("cbc:CitySubdivisionName");
		//$CitySubdivisionName = $PostalAddress->appendChild($CitySubdivisionName);
		
		////cbc:CityName
		$CityName = $domtree->createElement("cbc:CityName",$EmpresaProvincia);
		$CityName = $PostalAddress->appendChild($CityName);		
		
		//cbc:CountrySubentity
		$CountrySubentity = $domtree->createElement("cbc:CountrySubentity",$EmpresaDepartamento);
		$CountrySubentity = $PostalAddress->appendChild($CountrySubentity);		
		
		//cbc:District
		$District = $domtree->createElement("cbc:District",$EmpresaDistrito);
		$District = $PostalAddress->appendChild($District);				
		
		//cac:Country
		$Country = $domtree->createElement("cbc:Country");
		$Country = $PostalAddress->appendChild($Country);			
		
			//cvc:IdentificationCode
			$IdentificationCode = $domtree->createElement("cbc:IdentificationCode",$EmpresaPaisAbreviacion);
			$IdentificationCode = $Country->appendChild($IdentificationCode);
				
		
		
		
		
		
	//cac:PartyLegalEntity
	$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
	$PartyLegalEntity = $AgentParty->appendChild($PartyLegalEntity);		

		//cbc:Name		
		$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
		$RegistrationName->appendChild($domtree->createCDATASection( $EmpresaNombre )); 



//cac:ReceiverParty
$ReceiverParty = $domtree->createElement("cac:ReceiverParty");
$ReceiverParty = $xmlRoot->appendChild($ReceiverParty);
			
	//cac:PartyIdentification
	$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
	$PartyIdentification = $ReceiverParty->appendChild($PartyIdentification);
	
		//cbc:ID 
		$ID = $domtree->createElement("cbc:ID",$EmpresaCodigo);
		$ID->setAttribute('schemeID', "6");
		$ID = $PartyIdentification->appendChild($ID);	
	
	//cac:PartyName
	$PartyName = $domtree->createElement("cac:PartyName");
	$PartyName = $ReceiverParty->appendChild($PartyName);
	
		//cbc:Name
		$Name = $domtree->createElement("cbc:Name");
		$Name = $PartyName->appendChild($Name);
		$Name->appendChild($domtree->createCDATASection($EmpresaNombre)); 







	//cac:PostalAddress
	$PostalAddress = $domtree->createElement("cac:PostalAddress");
	$PostalAddress = $ReceiverParty->appendChild($PostalAddress);
	
		//cbc:ID
		$ID = $domtree->createElement("cbc:ID",$EmpresaCodigoUbigeo);
		$ID = $PostalAddress->appendChild($ID);
		
		//cbc:StreetName
		$StreetName = $domtree->createElement("cbc:StreetName",$EmpresaDireccion);
		$StreetName = $PostalAddress->appendChild($StreetName);
			
		////cbc:CitySubdivisionName
		//$CitySubdivisionName = $domtree->createElement("cbc:CitySubdivisionName",XXXXXX);
		//$CitySubdivisionName = $PostalAddress->appendChild($CitySubdivisionName);
		
		//cbc:CityName
		$CityName = $domtree->createElement("cbc:CityName",$EmpresaProvincia);
		$CityName = $PostalAddress->appendChild($CityName);		
		
		//cbc:CountrySubentity
		$CountrySubentity = $domtree->createElement("cbc:CountrySubentity",$EmpresaDepartamento);
		$CountrySubentity = $PostalAddress->appendChild($CountrySubentity);			
		
		//cbc:District
		$District = $domtree->createElement("cbc:District",$EmpresaDistrito);
		$District = $PostalAddress->appendChild($District);				
		
		//cac:Country
		$Country = $domtree->createElement("cac:Country");
		$Country = $PostalAddress->appendChild($Country);			
		
			//cac:Country
			$IdentificationCode = $domtree->createElement("cbc:IdentificationCode",$EmpresaPaisAbreviacion);
			$IdentificationCode = $Country->appendChild($IdentificationCode);	
			
			
			
			
			
		
	//cac:PartyLegalEntity
	$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
	$PartyLegalEntity = $ReceiverParty->appendChild($PartyLegalEntity);

		//cbc:RegistrationName
		$RegistrationName = $domtree->createElement("cbc:RegistrationName");
		$RegistrationName = $PartyLegalEntity->appendChild($RegistrationName);
		$RegistrationName->appendChild($domtree->createCDATASection($EmpresaNombre)); 

	//sac:SUNATRetentionSystemCode
	$SUNATRetentionSystemCode = $domtree->createElement("sac:SUNATRetentionSystemCode","01");
	$SUNATRetentionSystemCode = $xmlRoot->appendChild($SUNATRetentionSystemCode);
		
	//sac:SUNATRetentionPercent
	$SUNATRetentionPercent = $domtree->createElement("sac:SUNATRetentionPercent","3.00");
	$SUNATRetentionPercent = $xmlRoot->appendChild($SUNATRetentionPercent);	
	
	if(!empty($InsComprobanteRetencion->CrnObservacionImpresa)){
		//cbc:Note
		$Note = $domtree->createElement("cbc:Note",$InsComprobanteRetencion->CrnObservacionImpresa);
		$Note = $xmlRoot->appendChild($Note);				
	}

	/*
	Importe total Retenido
	Obligatorio. Importe total retenido del Comprobante de Retención Electrónico. Este importe siempre es en Nuevos soles. Este valor debe ser igual a la suma a los importes retenidos (campo 52) por cada comprobante relacionado.
	*/
	//cbc:InvoicedQuantity currencyID="PEN"
	$TotalInvoiceAmount = $domtree->createElement("cbc:TotalInvoiceAmount",number_format($InsComprobanteRetencion->CrnTotalRetenido,2, '.', ''));
	$TotalInvoiceAmount->setAttribute('currencyID', $InsComprobanteRetencion->MonSigla);
	$TotalInvoiceAmount = $xmlRoot->appendChild($TotalInvoiceAmount);	
	
	/*
	Importe total Pagado
	Obligatorio. Importe total pagado del Comprobante de Retención Electrónico. Este importe siempre es en Nuevos soles. Este valor deber ser igual a la suma de los montos totales pagados (campo 55) por cada comprobante relacionado.
	*/
	//cbc:InvoicedQuantity unitCode="NIU"
	$SUNATTotalPaid = $domtree->createElement("sac:SUNATTotalPaid",number_format($InsComprobanteRetencion->CrnTotalPagar,2, '.', ''));
	$SUNATTotalPaid->setAttribute('currencyID', $InsComprobanteRetencion->MonSigla);
	$SUNATTotalPaid = $xmlRoot->appendChild($SUNATTotalPaid);	
		
/*
01 FACTURA 
07 NOTA DE CRÉDITO 
08 NOTA DE DÉBITO 
12 TICKET DE MAQUINA REGISTRADORA
*/				
			
$fila = 1;
if(!empty($InsComprobanteRetencion->ComprobanteRetencionDetalle)){
	foreach($InsComprobanteRetencion->ComprobanteRetencionDetalle as $DatComprobanteRetencionDetalle){
		
		if($InsComprobanteRetencion->MonId<>$EmpresaMonedaId){
			
			$DatComprobanteRetencionDetalle->CedTotal = round($DatComprobanteRetencionDetalle->CedTotal/$InsComprobanteRetencion->CrnTipoCambio,2);
			$DatComprobanteRetencionDetalle->CedPagado = round($DatComprobanteRetencionDetalle->CedPagado/$InsComprobanteRetencion->CrnTipoCambio,2);
			$DatComprobanteRetencionDetalle->CedRetenido = round($DatComprobanteRetencionDetalle->CedRetenido/$InsComprobanteRetencion->CrnTipoCambio,2);
		
		}

		//sac:SUNATRetentionDocumentReference
		$SUNATRetentionDocumentReference = $domtree->createElement("sac:SUNATRetentionDocumentReference");
		$SUNATRetentionDocumentReference = $xmlRoot->appendChild($SUNATRetentionDocumentReference);	
		
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$DatComprobanteRetencionDetalle->CedSerie."-".$DatComprobanteRetencionDetalle->CedNumero);
			$ID->setAttribute('schemeID', $DatComprobanteRetencionDetalle->CedTipoDocumento);
			$ID = $SUNATRetentionDocumentReference->appendChild($ID);	
		
			//cbc:IssueDate
			$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($DatComprobanteRetencionDetalle->CedFechaEmision));
			$IssueDate = $SUNATRetentionDocumentReference->appendChild($IssueDate);	
			
			//cbc:TotalInvoiceAmount
			$TotalInvoiceAmount = $domtree->createElement("cbc:TotalInvoiceAmount",number_format($DatComprobanteRetencionDetalle->CedTotal,2, '.', ''));
			$TotalInvoiceAmount->setAttribute('currencyID', $InsComprobanteRetencion->MonSigla);//REVISAR MAS ADELANTE
			$TotalInvoiceAmount = $SUNATRetentionDocumentReference->appendChild($TotalInvoiceAmount);	

			//cbc:IssueDate
			$Payment = $domtree->createElement("cac:Payment");
			$Payment = $SUNATRetentionDocumentReference->appendChild($Payment);	
				
				/*
				Número de pago
				Obligatorio.
				Corresponde al número correlativo de pago, utilizado para pagos parciales. Si fuera un único pago deberá indicar 1.
				Este valor no se puede repetir para un mismo comprobante relacionado.
				*/
				//cbc:IssueDate
				$ID = $domtree->createElement("cbc:ID","1");
				$ID = $Payment->appendChild($ID);	
				
				/*
				Importe del pago sin retención
Obligatorio. Importe de pago en moneda original, no incluye la retención. Debe indicarse en la misma moneda del importe total del comprobante relacionado.
El importe de pago no debe ser mayor al importe total del comprobante relacionado
				*/
				//cbc:TotalInvoiceAmount
				$PaidAmount = $domtree->createElement("cbc:PaidAmount",number_format($DatComprobanteRetencionDetalle->CedPagado,2, '.', ''));
				$PaidAmount->setAttribute('currencyID', $InsComprobanteRetencion->MonSigla);
				$PaidAmount = $Payment->appendChild($PaidAmount);	
				
				//cbc:PaidDate
				$PaidDate = $domtree->createElement("cbc:PaidDate",FncCambiaFechaAMysql($DatComprobanteRetencionDetalle->CedFechaEmision));//CONFIRMA CON EWDWIN
				$PaidDate = $Payment->appendChild($PaidDate);	
		
		
			//cbc:IssueDate
			$SUNATRetentionInformation = $domtree->createElement("sac:SUNATRetentionInformation");
			$SUNATRetentionInformation = $SUNATRetentionDocumentReference->appendChild($SUNATRetentionInformation);	

				/*
				Importe retenido
				Obligatorio. Importe de la retención en moneda nacional.
				*/						
				//sac:SUNATRetentionAmount
				$SUNATRetentionAmount = $domtree->createElement("sac:SUNATRetentionAmount",number_format($DatComprobanteRetencionDetalle->CedRetenido,2, '.', ''));
				$SUNATRetentionAmount->setAttribute('currencyID', $InsComprobanteRetencion->MonSigla);
				$SUNATRetentionAmount = $SUNATRetentionInformation->appendChild($SUNATRetentionAmount);	
				
				//sac:SUNATRetentionDate
				$SUNATRetentionDate = $domtree->createElement("sac:SUNATRetentionDate",FncCambiaFechaAMysql($InsComprobanteRetencion->CrnFechaEmision));
				$SUNATRetentionDate = $SUNATRetentionInformation->appendChild($SUNATRetentionDate);	
				
				/*
				Monto total a pagar (neto)
				Obligatorio. Monto total pagado en moneda nacional incluida la retención.
				*/
				//sac:SUNATNetTotalPaid
				$SUNATNetTotalPaid = $domtree->createElement("sac:SUNATNetTotalPaid",number_format($DatComprobanteRetencionDetalle->CedPagado,2, '.', ''));
				$SUNATNetTotalPaid->setAttribute('currencyID', $InsComprobanteRetencion->MonSigla);
				$SUNATNetTotalPaid = $SUNATRetentionInformation->appendChild($SUNATNetTotalPaid);	

				////cac:ExchangeRate
//				$ExchangeRate = $domtree->createElement("cac:ExchangeRate");
//				$ExchangeRate = $SUNATRetentionInformation->appendChild($ExchangeRate);	
//				
//					//cbc:SourceCurrencyCode
//					$SourceCurrencyCode = $domtree->createElement("cbc:SourceCurrencyCode","PEN");
//					$SourceCurrencyCode = $ExchangeRate->appendChild($SourceCurrencyCode);	
//					
//					//cbc:TargetCurrencyCode
//					$TargetCurrencyCode = $domtree->createElement("cbc:TargetCurrencyCode","PEN");
//					$TargetCurrencyCode = $ExchangeRate->appendChild($TargetCurrencyCode);	
//
//					//cbc:CalculationRate
//					$CalculationRate = $domtree->createElement("cbc:CalculationRate","1.00");
//					$CalculationRate = $ExchangeRate->appendChild($CalculationRate);	
//					
//					//cbc:Date
//					$Date = $domtree->createElement("cbc:Date",0000-00-00);
//					$Date = $ExchangeRate->appendChild($Date);	
						
		$fila++;
	}
}

if(file_exists('../../../generados/comprobantes_xml/'.$ARCHIVO)){
	unlink('../../../generados/comprobantes_xml/'.$ARCHIVO);
}

$domtree->save('../../../generados/comprobantes_xml/'.$ARCHIVO,LIBXML_NOEMPTYTAG );

$respuesta['CodigoRespuesta'] = "1";
$respuesta['Nombre'] = $NOMBRE;

echo json_encode($respuesta);
?>