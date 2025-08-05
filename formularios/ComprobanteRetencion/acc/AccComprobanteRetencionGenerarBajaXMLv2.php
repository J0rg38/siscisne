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
require_once($InsPoo->MtdPaqContabilidad().'ClsResumenBaja.php');



$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsComprobanteRetencion->CrnId = $GET_id;
$InsComprobanteRetencion->CrtId = $GET_ta;
$InsComprobanteRetencion->MtdObtenerComprobanteRetencion();


$InsResumenBaja = new ClsResumenBaja();
$BajaNumeracion = $InsResumenBaja->MtdGenerarResumenBajaNumeracion();


$NOMBRE = $EmpresaCodigo."-RA-".date("Ymd")."-".$BajaNumeracion;
$ARCHIVO = $NOMBRE.".xml";
$NOMBRE_INTERNO = "RA-".date("Ymd")."-".$BajaNumeracion;


$domtree = new DOMDocument('1.0', 'ISO-8859-1');
//$domtree->preserveWhiteSpace = false;
$domtree->formatOutput = true;
$domtree->xmlStandalone = false;

/* create the root element of the xml tree */
$xmlRoot = $domtree->createElement("VoidedDocuments");
/* append it to the document created */
$xmlRoot = $domtree->appendChild($xmlRoot);


$xmlRoot->setAttribute('xmlns', 'urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1');
$xmlRoot->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$xmlRoot->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$xmlRoot->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
$xmlRoot->setAttribute('xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
$xmlRoot->setAttribute('xmlns:sac', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1');
$xmlRoot->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

//ext:UBLExtensions
$UBLExtensions = $domtree->createElement("ext:UBLExtensions");
$UBLExtensions = $xmlRoot->appendChild($UBLExtensions);

//ext:UBLExtension2
$UBLExtension2 = $domtree->createElement("ext:UBLExtension");
$UBLExtension2 = $UBLExtensions->appendChild($UBLExtension2);

//sac:ExtensionContent2
$ExtensionContent2 = $domtree->createElement("ext:ExtensionContent");
$ExtensionContent2 = $UBLExtension2->appendChild($ExtensionContent2);

//ext:UBLVersionID
$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","2.0");
$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);

//ext:CustomizationID
$CustomizationID = $domtree->createElement("cbc:CustomizationID","1.0");
$CustomizationID = $xmlRoot->appendChild($CustomizationID);

//cbc:ID
$ID = $domtree->createElement("cbc:ID",$NOMBRE_INTERNO);
$ID = $xmlRoot->appendChild($ID);

//cbc:ReferenceDate
$ReferenceDate = $domtree->createElement("cbc:ReferenceDate",FncCambiaFechaAMysql($InsComprobanteRetencion->CrnFechaEmision));
$ReferenceDate = $xmlRoot->appendChild($ReferenceDate);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",date("Y-m-d"));
$IssueDate = $xmlRoot->appendChild($IssueDate);

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

	//cbc:ID
	$DigitalSignatureAttachment = $domtree->createElement("cac:DigitalSignatureAttachment");
	$DigitalSignatureAttachment = $Signature->appendChild($DigitalSignatureAttachment);

		//cac:ExternalReference
		$ExternalReference = $domtree->createElement("cac:ExternalReference");
		$ExternalReference = $DigitalSignatureAttachment->appendChild($ExternalReference);
			
			//cbc:URI
			$URI = $domtree->createElement("cbc:URI","#SignatureSP");
			$URI = $ExternalReference->appendChild($URI);


//cac:AccountingSupplierParty
$AccountingSupplierParty = $domtree->createElement("cac:AccountingSupplierParty");
$AccountingSupplierParty = $xmlRoot->appendChild($AccountingSupplierParty);

	//cbc:CustomerAssignedAccountID
	$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$EmpresaCodigo);
	$CustomerAssignedAccountID = $AccountingSupplierParty->appendChild($CustomerAssignedAccountID);
	
	//cbc:AdditionalAccountID
	$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID","6");
	$AdditionalAccountID = $AccountingSupplierParty->appendChild($AdditionalAccountID);

	//cac:Party
	$Party = $domtree->createElement("cac:Party");
	$Party = $AccountingSupplierParty->appendChild($Party);
	
		//cac:PartyLegalEntity
		$base = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
		
		//cac:Name		
		$name = $base->appendChild($domtree->createElement('cbc:RegistrationName')); 
		$name->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
		
		//cac:VoidedDocumentsLine
		$VoidedDocumentsLine = $domtree->createElement("sac:VoidedDocumentsLine");
		$VoidedDocumentsLine = $xmlRoot->appendChild($VoidedDocumentsLine);	
			
			//cbc:ID
			$LineID = $domtree->createElement("cbc:LineID",1);
			$LineID = $VoidedDocumentsLine->appendChild($LineID);	
			
			//cbc:DocumentTypeCode
			$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","01");
			$DocumentTypeCode = $VoidedDocumentsLine->appendChild($DocumentTypeCode);	
			
			//cbc:DocumentSerialID
			$DocumentSerialID = $domtree->createElement("sac:DocumentSerialID",$InsComprobanteRetencion->CrtNumero);
			$DocumentSerialID = $VoidedDocumentsLine->appendChild($DocumentSerialID);	
			
			//cbc:DocumentNumberID
			$DocumentNumberID = $domtree->createElement("sac:DocumentNumberID",$InsComprobanteRetencion->CrnId);
			$DocumentNumberID = $VoidedDocumentsLine->appendChild($DocumentNumberID);	
			
			//cac:VoidReasonDescription
			$VoidReasonDescription = $domtree->createElement("sac:VoidReasonDescription","BAJA");
			$VoidReasonDescription = $VoidedDocumentsLine->appendChild($VoidReasonDescription);	
				

if(file_exists('../../../generados/comprobantes_xml/'.$ARCHIVO)){
	unlink('../../../generados/comprobantes_xml/'.$ARCHIVO);
}else{
	
}

$domtree->save('../../../generados/comprobantes_xml/'.$ARCHIVO,LIBXML_NOEMPTYTAG );

$InsResumenBaja = new ClsResumenBaja();
$InsResumenBaja->CrnId = $InsComprobanteRetencion->CrnId;
$InsResumenBaja->CrtId = $InsComprobanteRetencion->CrtId;
$InsResumenBaja->RbaFecha = date("Y-m-d");
$InsResumenBaja->RbaNumeracion = $BajaNumeracion;
$InsResumenBaja->RbaArchivo = $NOMBRE;
$InsResumenBaja->RbaEstado = 3;
$InsResumenBaja->RbaTiempoCreacion = date("Y-m-d H:i:s");
$InsResumenBaja->RbaTiempoModificacion = date("Y-m-d H:i:s");
$InsResumenBaja->MtdRegistrarResumenBaja();

//$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaBajaId",$BajaNumeracion,$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);

$respuesta['CodigoRespuesta'] = "1";
$respuesta['Nombre'] = $NOMBRE;
$respuesta['Id'] = $InsResumenBaja->RbaId;

echo json_encode($respuesta);

?>