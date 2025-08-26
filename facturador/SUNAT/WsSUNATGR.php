<?php
ini_set("display_errors", 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);
date_default_timezone_set('America/Lima');

//CONFIGURACIONES
require_once('configuraciones/CnfGeneral.php');
//LIBRERIAS
require_once('librerias/nusoap-0.9.5/lib/nusoap.php');
//OTRAS CLASES
require_once('FacturadorGuia2.php');

$server = new soap_server();
$server->configureWSDL('WsSUNATGR', 'urn:WsSUNATGR');

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
	'MtdConsultarGuiaRemision',
	array('trama' => 'xsd:string'),
	array('return' => 'xsd:string'),
	'urn:MtdConsultarGuiaRemision',
	'urn:MtdConsultarGuiaRemision#expediente',
	'rpc', //POSIBLE ERROR
	'encoded',
	'Este guarda la trama del expediente que recibe como parametro en la base de datos correspondiente'
);


/*
* GUIA REMISION
*/

function MtdProcesarGuiaRemision($trama)
{

	global $RUTA;

	$ComprobanteXML = json_decode($trama, true);

	$XMLUrl = $ComprobanteXML['XMLUrl'];
	$XMLNombre = $ComprobanteXML['XMLNombre'];

	/*
	if (empty($RUTA)) {
		$consulta = 'PryGuiaRemisionElectronica.exe Procesar ' . $XMLUrl . ' ' . $XMLNombre;
	} else {
		$consulta = 'cd ' . $RUTA . '/SUNAT/Factura & PryGuiaRemisionElectronica.exe Procesar ' . $XMLUrl . ' ' . $XMLNombre;
	}

	$respuesta = shell_exec($consulta);*/

	$respuesta = FncProcesar($XMLUrl, $XMLNombre);

	return $respuesta;
}


function MtdConsultarGuiaRemision($trama)
{

	global $RUTA;

	$Ticket = json_decode($trama, true);

	$Numero = $Ticket['CDRTicketNumero'];
	$Nombre = $Ticket['CDRXMLNombre'];

	/*
	if (empty($RUTA)) {
		$consulta = 'PryGuiaRemisionElectronica.exe Consultar ' . $Numero . ' ' . $Nombre;
	} else {
		$consulta = 'cd ' . $RUTA . '/SUNAT/Factura & PryGuiaRemisionElectronica.exe Consultar ' . $Numero . ' ' . $Nombre;
	}
	$respuesta = shell_exec($consulta);*/

	$respuesta = FncConsultarEstadoCDR($Numero, $Nombre);

	//$respuesta = ($Numero, $Nombre);
	//$respuesta = "TEST";
	return $respuesta;
}


if (isset($HTTP_RAW_POST_DATA)) {
	$input = $HTTP_RAW_POST_DATA;
} else {
	$input = implode("\r\n", file('php://input'));
}

$server->service($input);
