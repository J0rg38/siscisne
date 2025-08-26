<?php
ini_set("display_errors", 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);
date_default_timezone_set('America/Lima');

require_once('configuraciones/CnfGeneral.php');
require_once('librerias/nusoap-0.9.5/lib/nusoap.php');

require_once('Facturador.php');

//$RUTA = 'c://AppServ/www/FULLSERVICE';

$server = new soap_server();
$server->configureWSDL('WsSUNAT', 'urn:WsSUNAT');

$server->wsdl->addComplexType(
	'Dominio',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'DomId' => array('name' => 'DomId', 'type' => 'xsd:string'),
		'DomIP' => array('name' => 'DomIP', 'type' => 'xsd:string'),
		'DomAlias' => array('name' => 'DomAlias', 'type' => 'xsd:string'),
		'DomTiempoCreacion' => array('name' => 'DomTiempoCreacion', 'type' => 'xsd:string'),
		'DomTiempoModificacion' => array('name' => 'DomTiempoModificacion', 'type' => 'xsd:string')
	)
);

$server->register(
	'MtdProcesarFactura',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdProcesarFactura',
	'urn:MtdProcesarFactura#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);

$server->register(
	'MtdDarBajaFactura',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdDarBajaFactura',
	'urn:MtdDarBajaFactura#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);


$server->register(
	'MtdProcesarBoleta',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdProcesarBoleta',
	'urn:MtdProcesarBoleta#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);

$server->register(
	'MtdDarBajaBoleta',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdDarBajaBoleta',
	'urn:MtdDarBajaBoleta#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);

$server->register(
	'MtdProcesarNotaCredito',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdProcesarNotaCredito',
	'urn:MtdProcesarNotaCredito#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);


$server->register(
	'MtdDarBajaNotaCredito',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdDarBajaNotaCredito',
	'urn:MtdDarBajaNotaCredito#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);



$server->register(
	'MtdProcesarNotaDebito',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdProcesarNotaDebito',
	'urn:MtdProcesarNotaDebito#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);


$server->register(
	'MtdDarBajaNotaDebito',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdDarBajaNotaDebito',
	'urn:MtdDarBajaNotaCredito#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);

$server->register(
	'MtdProcesarGuiaRemision',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdProcesarGuiaRemision',
	'urn:MtdProcesarGuiaRemision#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);


$server->register(
	'MtdDarBajaGuiaRemision',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdDarBajaGuiaRemision',
	'urn:MtdDarBajaGuiaRemision#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);

$server->register(
	'MtdProcesarRetencion',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdProcesarRetencion',
	'urn:MtdProcesarRetencion#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);


$server->register(
	'MtdDarBajaRetencion',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdDarBajaRetencion',
	'urn:MtdDarBajaRetencion#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);

/*
$server->register(
	'MtdConsultarEstadoTicket',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdConsultarEstadoTicket',
	'urn:MtdConsultarEstadoTicket#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);
*/
$server->register(
	'MtdProcesarResumenDiario',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdProcesarResumenDiario',
	'urn:MtdProcesarResumenDiario#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);

$server->register(
	'MtdConsultarCDR',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdConsultarCDR',
	'urn:MtdConsultarCDR#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);


/*
$server->register(
	'MtdProcesarGuiaRemision',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdProcesarGuiaRemision',
	'urn:MtdProcesarGuiaRemision#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);
*/

/*
$server->register(
	'MtdConsultarGuiaRemision',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdConsultarGuiaRemision',
	'urn:MtdConsultarGuiaRemision#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);
*/



/*
* FACTURA
*/

function MtdProcesarFactura($trama)
{

	global $RUTA;

	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";
	$respuesta = FncProcesar($XMLUrl, $XMLNombre);
	//$consulta = 'cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe Procesar ' . $XMLUrl . ' ' . $XMLNombre;
	//$respuesta = shell_exec($consulta);

	return $respuesta;
}

function MtdDarBajaFactura($trama)
{

	global $RUTA;

	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";
	//$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe Baja ' . $XMLUrl . ' ' . $XMLNombre);
	$respuesta = FncProcesarBaja($XMLUrl, $XMLNombre);

	return $respuesta;
}



/*
* BOLETA
*/
function MtdProcesarBoleta($trama)
{

	global $RUTA;

	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";
	$respuesta = FncProcesar($XMLUrl, $XMLNombre);
	//$respuesta = shell_exec($consulta);

	return $respuesta;
}


function MtdDarBajaBoleta($trama)
{

	global $RUTA;

	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";
	//$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe Baja ' . $XMLUrl . ' ' . $XMLNombre);
	$respuesta = FncProcesarBajaResumen($XMLUrl, $XMLNombre);

	return $respuesta;
}


/*
* NOTA CREDITO
*/
function MtdProcesarNotaCredito($trama)
{

	global $RUTA;

	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	//$respuesta = "";
	//$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe Procesar ' . $XMLUrl . ' ' . $XMLNombre);
	$respuesta = "";
	$respuesta = FncProcesar($XMLUrl, $XMLNombre);

	return $respuesta;
}


function MtdDarBajaNotaCredito($trama)
{

	global $RUTA;

	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";
	//$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe Baja ' . $XMLUrl . ' ' . $XMLNombre);
	$respuesta = FncProcesarBaja($XMLUrl, $XMLNombre);

	return $respuesta;
}


/*
* NOTA DEBITO
*/
function MtdProcesarNotaDebito($trama)
{

	global $RUTA;
	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	//$respuesta = "";
	//$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe Procesar ' . $XMLUrl . ' ' . $XMLNombre);
	$respuesta = "";
	$respuesta = FncProcesar($XMLUrl, $XMLNombre);

	return $respuesta;
}


function MtdDarBajaNotaDebito($trama)
{

	global $RUTA;
	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";
	//$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe Baja ' . $XMLUrl . ' ' . $XMLNombre);
	$respuesta = FncProcesarBaja($XMLUrl, $XMLNombre);

	return $respuesta;
}

/*
* CONSULTAR ESTADO
*/

/*
function MtdConsultarEstadoTicket($trama)
{

	$Ticket = json_decode($trama, true);

	$Numero = $Ticket['Numero'];

	$respuesta = "";

	$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe Consultar ' . $Numero);

	return $respuesta;
}
*/

/*
* RESUMEN DIARIO
*/

function MtdProcesarResumenDiario($trama)
{

	global $RUTA;
	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";
	$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe Resumen ' . $XMLUrl . ' ' . $XMLNombre);

	return $respuesta;
}


/*
* GUIA REMISION
*/

/*
function MtdProcesarGuiaRemision($trama) {
	
	global $RUTA;
$ComprobanteXML = json_decode($trama,true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";

	//$respuesta =  'cd '.$RUTA.'/SUNAT/GuiaRemision & PryGuiaRemisionElectronica.exe Procesar '.$XMLUrl.' '.$XMLNombre;

	$respuesta = shell_exec('cd '.$RUTA.'/SUNAT/GuiaRemision & PryGuiaRemisionElectronica.exe Procesar '.$XMLUrl.' '.$XMLNombre);
	
	return $respuesta;
	
}


function MtdDarBajaGuiaRemision($trama) {
	
	global $RUTA;
$ComprobanteXML = json_decode($trama,true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";

	$respuesta = shell_exec('cd '.$RUTA.'/SUNAT/GuiaRemision & PryGuiaRemisionElectronica.exe Baja '.$XMLUrl.' '.$XMLNombre);
	
	return $respuesta;
	
}
*/


/*
* RETENCION
*/
/*
function MtdProcesarRetencion($trama)
{

	global $RUTA;
	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";

	$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Retencion & PryRetencionElectronica.exe Procesar ' . $XMLUrl . ' ' . $XMLNombre);
	//$respuesta  ='cd '.$RUTA.'/SUNAT/Retencion & PryRetencionElectronica.exe Procesar '.$XMLUrl.' '.$XMLNombre;

	return $respuesta;
}*/

/*
function MtdDarBajaRetencion($trama)
{

	global $RUTA;
	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	$respuesta = "";

	$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Retencion & PryRetencionElectronica.exe Baja ' . $XMLUrl . ' ' . $XMLNombre);

	return $respuesta;
}
*/

function MtdConsultarCDR($trama)
{

	global $RUTA;

	$ComprobanteXML = json_decode($trama, true);

	$CDRRUC = $ComprobanteXML['CDRRUC'];
	$CDRTipoComprobante = $ComprobanteXML['CDRTipoComprobante'];
	$CDRSerie = $ComprobanteXML['CDRSerie'];
	$CDRNumero = $ComprobanteXML['CDRNumero'];
	$CDRXMLNombre = $ComprobanteXML['CDRXMLNombre'];



	$respuesta = "";
	$respuesta = FncConsultarEstadoCDR($CDRRUC, $CDRTipoComprobante, $CDRSerie, $CDRNumero, $CDRXMLNombre);

	//$respuesta = $trama;
	//$respuesta = shell_exec('cd ' . $RUTA . '/SUNAT/Factura & PryFacturaElectronica.exe ConsultarCDR ' . $CDRRUC . ' ' . $CDRTipoComprobante . ' ' . $CDRSerie . ' ' . $CDRNumero . ' ' . $CDRXMLNombre);
	//$respuesta = 'cd '.$RUTA.'/SUNAT/Factura & PryFacturaElectronica.exe ConsultarCDR '.$CDRRUC.' '.$CDRTipoComprobante.' '.$CDRSerie.' '.$CDRNumero.' '.$CDRXMLNombre;

	//$respuesta = "aaaaaaaas";
	return $respuesta;
}


/*
function MtdProcesarGuiaRemision($trama)
{

	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	//$consulta = 'cd c://AppServ/www/SUNAT & PryGuiaRemisionElectronica.exe Procesar '.$XMLUrl.' '.$XMLNombre;
	$consulta = 'cd ' . $RUTA . '/SUNAT/Factura & PryGuiaRemisionElectronica.exe Procesar ' . $XMLUrl . ' ' . $XMLNombre;

	//$respuesta = $consulta;
	$respuesta = shell_exec($consulta);

	return $respuesta;
}
*/

/*
function MtdConsultarGuiaRemision($trama)
{

	$Ticket = json_decode($trama, true);

	$Numero = $Ticket['Numero'];

	//$consulta = 'cd c://AppServ/www/SUNAT & PryGuiaRemisionElectronica.exe Consultar '.$Numero;
	$consulta = 'cd ' . $RUTA . '/SUNAT/Factura & PryGuiaRemisionElectronica.exe Consultar ' . $Numero;

	//$respuesta = $consulta;
	$respuesta = shell_exec($consulta);

	return $respuesta;
}
*/



if (isset($HTTP_RAW_POST_DATA)) {
	$input = $HTTP_RAW_POST_DATA;
} else {
	$input = implode("\r\n", file('php://input'));
}

$server->service($input);
