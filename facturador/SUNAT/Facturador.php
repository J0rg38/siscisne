<?php
set_time_limit(-1);

require_once __DIR__ . '/vendor/autoload.php';

use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;

use DOMDocument;
use DOMXPath;
use ZipArchive;
use Exception;
use SimpleXMLElement;
use DateTime;

function leerSoapFaultXML($xml)
{
    libxml_use_internal_errors(true);

    // Reemplaza los "-" por comillas para que el XML sea válido
    //$xml = str_replace(['=-', '-'], ['="', '"'], $xml);

    $dom = new DOMDocument();
    if (!$dom->loadXML($xml)) {
        return ['error' => true, 'mensaje' => 'XML inválido'];
    }

    $xpath = new DOMXPath($dom);
    $xpath->registerNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');

    $faultcodeNode = $xpath->query('//soap:Fault/faultcode')->item(0);
    $faultstringNode = $xpath->query('//soap:Fault/faultstring')->item(0);
    $messageNode = $xpath->query('//soap:Fault/detail/message')->item(0);

    return [
        'faultcode' => $faultcodeNode ? $faultcodeNode->nodeValue : null,
        'faultstring' => $faultstringNode ? $faultstringNode->nodeValue : null,
        'message' => $messageNode ? $messageNode->nodeValue : null
    ];
}

function leerSoapFaultXMLBaja($xml)
{
    // libxml_use_internal_errors(true);

    // Cargar el XML
    $dom = new DOMDocument();
    if (!$dom->loadXML($xml)) {
        return ['error' => true, 'message' => 'XML inválido'];
    }

    // Crear XPath y registrar el namespace SOAP
    $xpath = new DOMXPath($dom);
    $xpath->registerNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');

    // Consultar nodos
    $faultcodeNode = $xpath->query('//soap:Fault/faultcode')->item(0);
    $faultstringNode = $xpath->query('//soap:Fault/faultstring')->item(0);
    $messageNode = $xpath->query('//soap:Fault/detail/message')->item(0);

    /*
    if ($messageNode) {
        $messageNode = str_replace("\"", "\@", $messageNode->nodeValue);
    } else {
    }*/

    return [
        'error' => false,
        'faultcode' => $faultcodeNode ? trim($faultcodeNode->nodeValue) : null,
        'faultstring' => $faultstringNode ? trim($faultstringNode->nodeValue) : null,
        'message' => $messageNode ? trim(str_replace("\"", "aaa", $messageNode->nodeValue)) : null
    ];
}

/**
 * Descargar un archivo desde una URL y guardarlo en una carpeta específica.
 *
 * @param string $url URL del archivo a descargar.
 * @param string $nombreArchivo Nombre del archivo a guardar.
 * @return string Ruta completa del archivo descargado.
 */
function descargarArchivo($url, $nombreArchivo)
{
    global $CARPETA_DESCARGADO;

    // $carpetaDestino = 'descargado/';
    $carpetaDestino = $CARPETA_DESCARGADO;

    try {
        // Crear la carpeta si no existe
        if (!is_dir($carpetaDestino)) {
            if (!mkdir($carpetaDestino, 0777, true)) {
                throw new Exception("No se pudo crear la carpeta: $carpetaDestino");
            }
        }

        $rutaCompleta = $carpetaDestino . $nombreArchivo;

        // Descargar el contenido del archivo
        $contenido = file_get_contents($url);
        if ($contenido === false) {
            throw new Exception("No se pudo descargar el archivo desde la URL: $url");
        }

        // Guardar el archivo
        $resultado = file_put_contents($rutaCompleta, $contenido);
        if ($resultado === false) {
            throw new Exception("No se pudo guardar el archivo en: $rutaCompleta");
        }

        return $rutaCompleta;
    } catch (Exception $e) {
        echo "❌ Error al descargar archivo: " . $e->getMessage();
        return false;
    }
}


/**
 * Comprimir un archivo en formato ZIP utilizando shell_exec.
 *
 * @param string $archivoOrigen Ruta del archivo a comprimir.
 * @param string $carpetaDestino Carpeta donde se guardará el archivo ZIP.
 * @return string|bool Ruta del archivo ZIP creado o false en caso de error.
 */
function comprimirArchivoShell($archivoOrigen, $carpetaDestino)
{

    global  $CARPETA_ENVIO;

    // Verifica si el archivo fuente existe
    if (!file_exists($archivoOrigen)) {
        return false;
    }

    // Asegura que la carpeta destino exista
    if (!is_dir($CARPETA_ENVIO)) {
        mkdir($CARPETA_ENVIO, 0777, true);
    }

    // Extrae el nombre base del archivo sin extensión
    $nombreBase = pathinfo($archivoOrigen, PATHINFO_FILENAME);

    // Construye la ruta completa del archivo ZIP
    $archivoZip = rtrim($CARPETA_ENVIO, '/\\') . '/' . $nombreBase . '.zip';

    // Escapa los nombres para evitar problemas de seguridad
    $comando = 'zip -j ' . escapeshellarg($archivoZip) . ' ' . escapeshellarg($archivoOrigen);

    // Ejecuta el comando
    shell_exec($comando);

    // Verifica que se haya creado el ZIP
    return file_exists($archivoZip) ? $archivoZip : false;
}


/**
 * Firmar un documento XML utilizando un certificado PEM.
 *
 * @param string $nombreArchivo Nombre del archivo XML a firmar.
 * @return array Resultado de la firma.
 * @throws Exception Si ocurre un error durante el proceso de firma.
 */


function firmarDocumentoConPEM($nombreArchivo)
{
    global $CLAVESOL_CONTRASENA;
    global $CLAVESOL_USUARIO;

    global $URL_SERVICIO;
    global $URL_SERVICIO_CDR;

    global $CERTIFICADO;
    global $CERTIFICADO_CONTRASENA;

    global $CARPETA_DESCARGADO;
    global $CARPETA_FIRMADO;

    //$rutaCert = 'certificado/certificado-cert.pem';
    //$rutaKey = 'certificado/certificado-key.pem';
    $rutaCert = 'certificado/' . $CERTIFICADO . '-cert.pem';
    $rutaKey = 'certificado/' . $CERTIFICADO . '-key.pem';
    $rutaXML = $CARPETA_DESCARGADO . '' . $nombreArchivo;
    $rutaFirmado = $CARPETA_FIRMADO . '' . $nombreArchivo;

    if (!file_exists($rutaCert) || !file_exists($rutaKey)) {
        throw new Exception("No se encontraron los archivos .pem.");
    }


    $doc = new DOMDocument();
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = false;
    $doc->load($rutaXML);

    // Buscar el nodo ExtensionContent
    $xpath = new DOMXPath($doc);
    $xpath->registerNamespace("ext", "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
    $extensionNodes = $xpath->query('//ext:ExtensionContent');

    if ($extensionNodes->length === 0) {
        throw new Exception("No se encontró el nodo ExtensionContent en el XML.");
    }

    $extensionNode = $extensionNodes->item(0);
    while ($extensionNode->hasChildNodes()) {
        $extensionNode->removeChild($extensionNode->firstChild);
    }

    // Crear objeto de firma
    $dsig = new XMLSecurityDSig();
    $dsig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);

    $dsig->addReference(
        $doc,
        XMLSecurityDSig::SHA1,
        ['http://www.w3.org/2000/09/xmldsig#enveloped-signature'],
        ['force_uri' => true, 'uri' => '']
    );

    // Cargar clave privada
    $key = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, ['type' => 'private']);
    $key->loadKey($rutaKey, true);

    // Firmar el documento
    $dsig->sign($key);
    // Agregar el certificado público (opcional mostrar subject)
    $dsig->add509Cert(file_get_contents($rutaCert), true, false, ['subjectName' => true]);
    // Adjuntar la firma
    $dsig->appendSignature($extensionNode);

    // Modificar el nodo Signature
    $xpath = new DOMXPath($doc);
    $xpath->registerNamespace("ds", "http://www.w3.org/2000/09/xmldsig#");
    $signatureNode = $xpath->query('//ds:Signature')->item(0);


    if ($signatureNode) {
        // Eliminar prefijo "ds"
        //$signatureNode->prefix = null;

        // Establecer atributos según lo solicitado
        $signatureNode->setAttribute("Id", "SignatureSP");

        // Forzar el xmlns en Signature
        //$signatureNode->setAttribute("xmlns", "http://www.w3.org/2000/09/xmldsig#");
    }

    // Extraer DigestValue y SignatureValue
    $signedXml = $dsig->sigNode;
    $digestNode = $signedXml->getElementsByTagName('DigestValue')->item(0);
    $signatureValueNode = $signedXml->getElementsByTagName('SignatureValue')->item(0);

    $digestValue = $digestNode ? $digestNode->nodeValue : '';
    $signatureValue = $signatureValueNode ? $signatureValueNode->nodeValue : '';

    // Guardar el XML firmado
    $doc->save($rutaFirmado);

    return [
        'ok' => true,
        'archivo_nombre' => $zipNombre,
        'archivo_firmado' => $rutaFirmado,
        'archivo_zip' => $rutaZIP,
        'DigestValue' => $digestValue,
        'SignatureValue' => $signatureValue,
    ];
}


/**
 * Leer un archivo XML CDR y extraer información relevante.
 *
 * @param string $archivoZip Nombre del archivo ZIP que contiene el CDR.
 * @param string $carpeta Carpeta donde se encuentra el archivo ZIP.
 * @return array Información extraída del XML.
 * @throws Exception Si ocurre un error al procesar el archivo.
 */
function leerCDRXml($archivoZip, $carpeta = 'respuesta')
{
    global $CARPETA_CDR;

    $carpeta = $CARPETA_CDR;

    // Ruta completa al archivo ZIP
    $rutaZip = rtrim($carpeta, '/') . '/' . $archivoZip;

    $partes = explode('.', $archivoZip);

    // Carpeta temporal de extracción
    //$rutaTemp = $carpeta . '/temp_cdr';
    $rutaTemp = $carpeta . '/temp_cdr/' . $partes[0];
    if (!is_dir($rutaTemp)) {
        mkdir($rutaTemp, 0777, true);
    }

    // Descomprimir usando shell_exec
    $comando = "unzip -o " . escapeshellarg($rutaZip) . " -d " . escapeshellarg($rutaTemp);
    $resultadoShell = shell_exec($comando);

    // Verificar si se descomprimió algo
    $archivos = glob($rutaTemp . '/*.xml');
    if (empty($archivos)) {
        throw new Exception("No se encontró ningún XML descomprimido desde $rutaZip. Resultado: $resultadoShell");
    }

    // Cargar el primer XML encontrado
    $xml = simplexml_load_file($archivos[0]);

    if ($xml === false) {
        throw new Exception("No se pudo cargar el XML desde: " . $archivos[0]);
    }

    // Registrar los namespaces
    $namespaces = $xml->getNamespaces(true);

    // Extraer valores usando los namespaces
    $cbc = $xml->children($namespaces['cbc']);

    $responseDate = (string) $cbc->ResponseDate;
    $responseTime = (string) $cbc->ResponseTime;

    // Extraer valores usando los namespaces
    $docResponse = $xml->children($namespaces['cac'])->DocumentResponse;

    $referenceID = (string) $docResponse->children($namespaces['cac'])->Response->children($namespaces['cbc'])->ReferenceID;
    $responseCode = (string) $docResponse->children($namespaces['cac'])->Response->children($namespaces['cbc'])->ResponseCode;
    $description = (string) $docResponse->children($namespaces['cac'])->Response->children($namespaces['cbc'])->Description;
    //$documentID = (string) $docResponse->children($namespaces['cac'])->DocumentReference->children($namespaces['cbc'])->ID;
    $documentID = $xml->children($namespaces['cbc'])->ID;

    return array(
        'ok' => true,
        'document_id' => $documentID, //TICKET
        'reference_id' => $referenceID,
        'response_code' => $responseCode,
        'description' => $description,
        'response_date' => $responseDate,
        'response_time' => $responseTime,
    );
}


/**
 * Consultar el estado de un CDR en el servicio web de SUNAT.
 *
 * @param string $ruc RUC del emisor.
 * @param string $tipo Tipo de comprobante (03 para boleta, 01 para factura, etc.).
 * @param string $serie Serie del comprobante.
 * @param int $numero Número del comprobante.
 * @return array Resultado de la consulta.
 */
function consultarEstadoCDR($ruc, $tipo, $serie, $numero)
{
    global $CLAVESOL_CONTRASENA;
    global $CLAVESOL_USUARIO;

    global $URL_SERVICIO;
    global $URL_SERVICIO_CDR;

    global $CERTIFICADO;
    global $CERTIFICADO_CONTRASENA;

    //$usuario = '20607038431FACTUR4D';
    //$clave = 'Entre2021';
    $usuario = $CLAVESOL_USUARIO;
    $clave = $CLAVESOL_CONTRASENA;

    //$endpoint = 'https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService';
    $endpoint = $URL_SERVICIO_CDR;

    /*
"<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/"" xmlns:ser=""http://service.sunat.gob.pe"">
   <soapenv:Header>
      <wsse:Security soapenv:mustUnderstand=""1"" xmlns:wsse=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"" xmlns:wsu=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"">
         <wsse:UsernameToken wsu:Id=""UsernameToken-c175cdb9-9a32-4291-b8c7-85dff8107561"">
            <wsse:Username>*************</wsse:Username>
            <wsse:Password Type=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText"">***************</wsse:Password>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>
   <soapenv:Body>
      <ser:getStatusCdr>
         <!--Optional:-->
         <statusCdr>
            <!--Optional:-->
             <numeroComprobante>********</numeroComprobante>
            <!--Optional:-->
            <rucComprobante>******</rucComprobante>
            <!--Optional:-->
            <serieComprobante>****</serieComprobante>
            <!--Optional:-->
            <tipoComprobante>***</tipoComprobante>
         </statusCdr>
      </ser:getStatusCdr>
   </soapenv:Body>
</soapenv:Envelope>"
    */
    $soapRequest = '<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/"" xmlns:ser=""http://service.sunat.gob.pe"">
   <soapenv:Header>
      <wsse:Security soapenv:mustUnderstand=""1"" xmlns:wsse=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"" xmlns:wsu=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"">
          <wsse:UsernameToken wsu:Id=""UsernameToken-c175cdb9-9a32-4291-b8c7-85dff8107561"">
            <wsse:Username>' . htmlspecialchars($usuario, ENT_XML1) . '</wsse:Username>
            <wsse:Password>' . htmlspecialchars($clave, ENT_XML1) . '</wsse:Password>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>
   <soapenv:Body>
      <ser:getStatusCdr>
         <rucComprobante>' . htmlspecialchars($ruc, ENT_XML1) . '</rucComprobante>
         <tipoComprobante>' . htmlspecialchars($tipo, ENT_XML1) . '</tipoComprobante>
         <serieComprobante>' . htmlspecialchars($serie, ENT_XML1) . '</serieComprobante>
         <numeroComprobante>' . intval($numero) . '</numeroComprobante>
      </ser:getStatusCdr>
   </soapenv:Body>
</soapenv:Envelope>';

    $headers = array(
        'Content-Type: text/xml; charset=utf-8',
        'SOAPAction: urn:getStatusCdr',
        'Content-Length: ' . strlen($soapRequest)
    );

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $soapRequest);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // true en producción
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($response === false) {
        return array('ok' => false, 'mensaje' => 'cURL error: ' . $error);
    }

    if ($httpCode !== 200) {
        return array('ok' => false, 'mensaje' => 'HTTP status ' . $httpCode, 'response' => $response);
    }

    // Buscar el contenido base64 del CDR
    if (preg_match('/<content>(.*?)<\/content>/s', $response, $matches)) {
        $contenidoBase64 = trim($matches[1]);
        $binario = base64_decode($contenidoBase64);

        if ($binario !== false) {
            $carpetaCDR = 'respuesta/';
            if (!is_dir($carpetaCDR)) {
                mkdir($carpetaCDR, 0777, true);
            }

            $nombreArchivo = 'R-' . $ruc . '-' . $tipo . '-' . $serie . '-' . $numero . '.zip';
            $rutaZip = $carpetaCDR . $nombreArchivo;

            file_put_contents($rutaZip, $binario);

            return array(
                'ok' => true,
                'mensaje' => 'CDR recibido y guardado correctamente',
                'archivo_cdr' => $rutaZip,
                'nombreArchivo' => $nombreArchivo,
                'contenidoBase64' => $contenidoBase64
            );
        } else {
            return array('ok' => false, 'mensaje' => 'Error al decodificar contenido Base64');
        }
    } else {
        return array('ok' => false, 'mensaje' => 'No se encontró el tag <content> en la respuesta SOAP');
    }
}


function procesarComprobante($nombreArchivo, $contenidoZip)
{

    global $CLAVESOL_CONTRASENA;
    global $CLAVESOL_USUARIO;

    global  $URL_SERVICIO;

    global  $CARPETA_CDR;


    $endpoint = $URL_SERVICIO;

    $usuario = $CLAVESOL_USUARIO;
    $clave = $CLAVESOL_CONTRASENA;


    // Codificar el contenido del ZIP en base64
    $zipBase64 = base64_encode($contenidoZip);

    /*
    "<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/"" xmlns:ser=""http://service.sunat.gob.pe"">
	<soapenv:Header>
      <wsse:Security soapenv:mustUnderstand=""1"" xmlns:wsse=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"" xmlns:wsu=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"">
         <wsse:UsernameToken wsu:Id=""UsernameToken-c175cdb9-9a32-4291-b8c7-85dff8107561"">
            <wsse:Username>*********</wsse:Username>
            <wsse:Password Type=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText"">********</wsse:Password>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>  
    <soapenv:Body>      
    <ser:sendBill>   
         <fileName>***********************</fileName>
         <contentFile>*********************</contentFile>
      </ser:sendBill> 
   </soapenv:Body>
</soapenv:Envelope>"
    */
    // Armar la estructura del XML SOAP
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe">
   <soapenv:Header>
    <wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
         <wsse:UsernameToken wsu:Id="UsernameToken-c175cdb9-9a32-4291-b8c7-85dff8107561">
        <wsse:Username>' . $usuario . '</wsse:Username>
        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $clave . '</wsse:Password>
        </wsse:UsernameToken>
    </wsse:Security>
    </soapenv:Header>
    <soapenv:Body>
    <ser:sendBill>
        <fileName>' . htmlspecialchars($nombreArchivo, ENT_XML1) . '</fileName>
        <contentFile>' . $zipBase64 . '</contentFile>
    </ser:sendBill>
    </soapenv:Body>
    </soapenv:Envelope>';

    // Encabezados HTTP para la petición SOAP
    $headers = [
        "Content-type: text/xml; charset=utf-8",
        "Content-length: " . strlen($xml),
        "SOAPAction: urn:sendBill"
    ];

    // Iniciar sesión cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desactivar si hay problemas de certificado
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);


    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($response === false) {
        return array('ok' => false, 'mensaje' => 'cURL error: ' . $error);
    }

    if ($httpCode !== 200) {

        if ($httpCode == 500) {
            $resultado_leerSoapFaultXML = leerSoapFaultXML($response);
            if ($resultado_leerSoapFaultXML['error']) {
                return array('ok' => false, 'mensaje' => 'Error XML: ' . $resultado_leerSoapFaultXML['mensaje'], 'response' => $response);
            } else {
                return array('ok' => false, 'mensaje' => 'Error SOAP: ' . $resultado_leerSoapFaultXML['faultstring'] . " - Mensaje: " . $resultado_leerSoapFaultXML['message'], 'response' => $response);
            }
        } else {
            return array('ok' => false, 'mensaje' => 'HTTP status ' . $httpCode, 'response' => $response);
        }
    }


    // Extraer respuesta CDR desde el SOAP XML
    if (preg_match('/<applicationResponse>(.+)<\/applicationResponse>/s', $response, $matches)) {
        $contenidoBase64 = trim($matches[1]);
        $binario = base64_decode($contenidoBase64);

        if ($binario !== false) {
            //$carpetaCDR = 'respuesta/';
            $carpetaCDR =  $CARPETA_CDR;
            if (!is_dir($carpetaCDR)) {
                mkdir($carpetaCDR, 0777, true);
            }

            $nombreArchivo = 'R-' .  pathinfo($nombreArchivo, PATHINFO_FILENAME)  . '.zip';
            $rutaZip = $carpetaCDR . $nombreArchivo;

            file_put_contents($rutaZip, $binario);

            return array(
                'ok' => true,
                'mensaje' => 'CDR recibido y guardado correctamente',
                'archivo_cdr' => $rutaZip,
                'nombreArchivo' => $nombreArchivo,
                'contenidoBase64' => $contenidoBase64
            );
        } else {
            return array('ok' => false, 'mensaje' => 'Error al decodificar contenido Base64');
        }

        /*
        return [
            'ok' => false,
            'mensaje' => 'Comprobante enviado correctamente.',
            'cdr_zip_base64' => $cdrBase64,
            'cdr_zip' => $cdrData
        ];
        */
    } else {
        return [
            'ok' => false,
            'mensaje' => 'No se pudo extraer el CDR desde la respuesta SOAP.',
            'response' => $response
        ];
    }
}


function procesarBaja($nombreArchivo, $contenidoZip)
{

    global $CLAVESOL_CONTRASENA;
    global $CLAVESOL_USUARIO;

    global  $URL_SERVICIO;

    global  $CARPETA_CDR;

    $endpoint = $URL_SERVICIO;

    $usuario = $CLAVESOL_USUARIO;
    $clave = $CLAVESOL_CONTRASENA;

    // Codificar el contenido del ZIP en base64
    $zipBase64 = base64_encode($contenidoZip);

    // Armar la estructura del XML SOAP
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ser="http://service.sunat.gob.pe"
                  xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
  <soapenv:Header>
    <wsse:Security soapenv:mustUnderstand="0">
      <wsse:UsernameToken>
        <wsse:Username>' . $usuario . '</wsse:Username>
        <wsse:Password>' . $clave . '</wsse:Password>
      </wsse:UsernameToken>
    </wsse:Security>
  </soapenv:Header>
  <soapenv:Body>
    <ser:sendSummary>
      <fileName>' . htmlspecialchars($nombreArchivo, ENT_XML1) . '</fileName>
      <contentFile>' . $zipBase64 . '</contentFile>
    </ser:sendSummary>
  </soapenv:Body>
</soapenv:Envelope>';

    // Encabezados HTTP para la petición SOAP
    $headers = [
        "Content-type: text/xml; charset=utf-8",
        "Content-length: " . strlen($xml),
        "SOAPAction: urn:sendSummary"
    ];

    // Iniciar sesión cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desactivar si hay problemas de certificado
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);


    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($response === false) {
        return array('ok' => false, 'mensaje' => 'cURL error: ' . $error);
    }



    if ($httpCode !== 200) {

        if ($httpCode == 500) {

            $resultado_leerSoapFaultXML = leerSoapFaultXMLBaja($response);

            //var_dump($resultado_leerSoapFaultXML);
            //return array('ok' => false, 'mensaje' => 'JJJJJJJJ' . json_encode($resultado_leerSoapFaultXML), 'response' => $response);

            if ($resultado_leerSoapFaultXML['error']) {
                return array('ok' => false, 'mensaje' => 'Error XML: ' . $resultado_leerSoapFaultXML['message'], 'response' => $response);
            } else {
                return array('ok' => false, 'mensaje' => 'Error SOAP: ' . $resultado_leerSoapFaultXML['faultstring'] . " - Mensaje: " . $resultado_leerSoapFaultXML['message'], 'response' => $resultado_leerSoapFaultXML['response']);
            }
        } else {
            return array('ok' => false, 'mensaje' => 'HTTP status ' . $httpCode, 'response' => $response);
        }
    }


    // Extraer respuesta CDR desde el SOAP XML
    if (preg_match('/<applicationResponse>(.+)<\/applicationResponse>/s', $response, $matches)) {
        $contenidoBase64 = trim($matches[1]);
        $binario = base64_decode($contenidoBase64);

        if ($binario !== false) {
            //$carpetaCDR = 'respuesta/';
            $carpetaCDR =  $CARPETA_CDR;

            if (!is_dir($carpetaCDR)) {
                mkdir($carpetaCDR, 0777, true);
            }

            $nombreArchivo = 'R-' .  pathinfo($nombreArchivo, PATHINFO_FILENAME)  . '.zip';
            $rutaZip = $carpetaCDR . $nombreArchivo;

            file_put_contents($rutaZip, $binario);

            return array(
                'ok' => true,
                'mensaje' => 'CDR recibido y guardado correctamente',
                'archivo_cdr' => $rutaZip,
                'nombreArchivo' => $nombreArchivo,
                'contenidoBase64' => $contenidoBase64
            );
        } else {
            return array('ok' => false, 'mensaje' => 'Error al decodificar contenido Base64');
        }
    } else {
        return [
            'ok' => false,
            'mensaje' => 'No se pudo extraer el CDR desde la respuesta SOAP.',
            'response' => $response
        ];
    }
}



function procesarBajaResumen($nombreArchivo, $contenidoZip)
{

    global $CLAVESOL_CONTRASENA;
    global $CLAVESOL_USUARIO;

    global  $URL_SERVICIO;

    global  $CARPETA_CDR;

    $endpoint = $URL_SERVICIO;

    $usuario = $CLAVESOL_USUARIO;
    $clave = $CLAVESOL_CONTRASENA;

    // Codificar el contenido del ZIP en base64
    $zipBase64 = base64_encode($contenidoZip);

    /*
"<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/"" xmlns:ser=""http://service.sunat.gob.pe"">
<soapenv:Header>
      <wsse:Security soapenv:mustUnderstand=""1"" xmlns:wsse=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"" xmlns:wsu=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"">
         <wsse:UsernameToken wsu:Id=""UsernameToken-c175cdb9-9a32-4291-b8c7-85dff8107561"">
            <wsse:Username>****************</wsse:Username>
            <wsse:Password Type=""http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText"">***************</wsse:Password>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>
   <soapenv:Body>
      <ser:sendSummary>
         <!--Optional:-->
         <fileName>*****************</fileName>
         <!--Optional:-->
         <contentFile>***************</contentFile>
      </ser:sendSummary>
   </soapenv:Body>
</soapenv:Envelope>"
    */
    // Armar la estructura del XML SOAP
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ser="http://service.sunat.gob.pe"
                  xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
  <soapenv:Header>
    <wsse:Security soapenv:mustUnderstand="0">
      <wsse:UsernameToken>
        <wsse:Username>' . $usuario . '</wsse:Username>
        <wsse:Password>' . $clave . '</wsse:Password>
      </wsse:UsernameToken>
    </wsse:Security>
  </soapenv:Header>
  <soapenv:Body>
    <ser:sendSummary>
      <fileName>' . htmlspecialchars($nombreArchivo, ENT_XML1) . '</fileName>
      <contentFile>' . $zipBase64 . '</contentFile>
    </ser:sendSummary>
  </soapenv:Body>
</soapenv:Envelope>';

    // Encabezados HTTP para la petición SOAP
    $headers = [
        "Content-type: text/xml; charset=utf-8",
        "Content-length: " . strlen($xml),
        "SOAPAction: urn:sendSummary"
    ];

    // Iniciar sesión cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desactivar si hay problemas de certificado
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);


    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($response === false) {
        return array('ok' => false, 'mensaje' => 'cURL error: ' . $error);
    }



    if ($httpCode !== 200) {

        if ($httpCode == 500) {

            $resultado_leerSoapFaultXML = leerSoapFaultXMLBaja($response);

            //var_dump($resultado_leerSoapFaultXML);
            //return array('ok' => false, 'mensaje' => 'JJJJJJJJ' . json_encode($resultado_leerSoapFaultXML), 'response' => $response);

            if ($resultado_leerSoapFaultXML['error']) {
                return array('ok' => false, 'mensaje' => 'Error XML: ' . $resultado_leerSoapFaultXML['message'], 'response' => $response);
            } else {
                return array('ok' => false, 'mensaje' => 'Error SOAP: ' . $resultado_leerSoapFaultXML['faultstring'] . " - Mensaje: " . $resultado_leerSoapFaultXML['message'], 'response' => $resultado_leerSoapFaultXML['response']);
            }
        } else {
            return array('ok' => false, 'mensaje' => 'HTTP status ' . $httpCode, 'response' => $response);
        }
    }


    // Extraer respuesta CDR desde el SOAP XML
    if (preg_match('/<ticket>(.+)<\/ticket>/s', $response, $matches)) {
        $ticket = trim($matches[1]);

        if ($ticket != "") {

            return array(
                'ok' => true,
                'mensaje' => 'TICKET recibido y guardado correctamente',
                'ticket' => $ticket
            );
        } else {
            return array(
                'ok' => false,
                'mensaje' => 'No se encontro TICKET'
            );
        }
    } else {
        return [
            'ok' => false,
            'mensaje' => 'No se pudo encontrar el TICKET desde la respuesta SOAP.',
            'response' => $response
        ];
    }
}

/*
function procesarBaja($nombreArchivo, $contenidoZip)
{

    global $CLAVESOL_CONTRASENA;
    global $CLAVESOL_USUARIO;

    global  $URL_SERVICIO;

    global  $CARPETA_CDR;

    $endpoint = $URL_SERVICIO;

    $usuario = $CLAVESOL_USUARIO;
    $clave = $CLAVESOL_CONTRASENA;

    // Codificar el contenido del ZIP en base64
    $zipBase64 = base64_encode($contenidoZip);

    // Armar la estructura del XML SOAP
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ser="http://service.sunat.gob.pe"
                  xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
  <soapenv:Header>
    <wsse:Security soapenv:mustUnderstand="0">
      <wsse:UsernameToken>
        <wsse:Username>' . $usuario . '</wsse:Username>
        <wsse:Password>' . $clave . '</wsse:Password>
      </wsse:UsernameToken>
    </wsse:Security>
  </soapenv:Header>
  <soapenv:Body>
    <ser:sendSummary>
      <fileName>' . htmlspecialchars($nombreArchivo, ENT_XML1) . '</fileName>
      <contentFile>' . $zipBase64 . '</contentFile>
    </ser:sendSummary>
  </soapenv:Body>
</soapenv:Envelope>';

    // Encabezados HTTP para la petición SOAP
    $headers = [
        "Content-type: text/xml; charset=utf-8",
        "Content-length: " . strlen($xml),
        "SOAPAction: urn:sendSummary"
    ];

    // Iniciar sesión cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desactivar si hay problemas de certificado
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($response === false) {
        return array('ok' => false, 'mensaje' => 'cURL error: ' . $error);
    }

    if ($httpCode !== 200) {
        if ($httpCode == 500) {
            $resultado_leerSoapFaultXML = leerSoapFaultXML($response);
            if ($resultado_leerSoapFaultXML['error']) {
                return array('ok' => false, 'mensaje' => 'Error XML: ' . $resultado_leerSoapFaultXML['mensaje'], 'response' => $response);
            } else {
                return array('ok' => false, 'mensaje' => 'Error SOAP: ' . $resultado_leerSoapFaultXML['faultstring'] . " - Mensaje: " . $resultado_leerSoapFaultXML['message'], 'response' => $response);
            }
        } else {
            return array('ok' => false, 'mensaje' => 'HTTP status ' . $httpCode, 'response' => $response);
        }
    }


    // Extraer respuesta CDR desde el SOAP XML
    if (preg_match('/<applicationResponse>(.+)<\/applicationResponse>/s', $response, $matches)) {
        $contenidoBase64 = trim($matches[1]);
        $binario = base64_decode($contenidoBase64);

        if ($binario !== false) {
            //$carpetaCDR = 'respuesta/';
            $carpetaCDR =  $CARPETA_CDR;

            if (!is_dir($carpetaCDR)) {
                mkdir($carpetaCDR, 0777, true);
            }

            $nombreArchivo = 'R-' .  pathinfo($nombreArchivo, PATHINFO_FILENAME)  . '.zip';
            $rutaZip = $carpetaCDR . $nombreArchivo;

            file_put_contents($rutaZip, $binario);

            return array(
                'ok' => true,
                'mensaje' => 'CDR recibido y guardado correctamente',
                'archivo_cdr' => $rutaZip,
                'nombreArchivo' => $nombreArchivo,
                'contenidoBase64' => $contenidoBase64
            );
        } else {
            return array('ok' => false, 'mensaje' => 'Error al decodificar contenido Base64');
        }
 
    } else {
        return [
            'ok' => false,
            'mensaje' => 'No se pudo extraer el CDR desde la respuesta SOAP.',
            'response' => $response
        ];
    }
}
*/

/*
***************************************************************
* NUEVAS FUNCIONES SOAP
***************************************************************
*/

/**
 * Consultar el estado de un CDR.
 *
 * @param string $ruc RUC del emisor.
 * @param string $tipo Tipo de comprobante (03 para boleta, 01 para factura, etc.).
 * @param string $serie Serie del comprobante.
 * @param int $numero Número del comprobante.
 * @param string $cdrNombre Nombre del archivo CDR.
 * @return string Respuesta en formato JSON.
 */


function FncConsultarEstadoCDR($ruc, $tipo, $serie, $numero, $cdrNombre)
{

    $Respuesta = "";

    if ($ruc == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro RUC','CodigoRespuesta':'D106'}";
    } else if ($tipo == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro tipo de comprobante','CodigoRespuesta':'D105'}";
    } else if ($serie == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro serie de comprobante','CodigoRespuesta':'D104'}";
    } else if ($numero == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro numero de comprobante','CodigoRespuesta':'D103'}";
    } else if ($cdrNombre == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro nombre de archivo xml','CodigoRespuesta':'D102'}";
    } else {

        $resultado_consultarEstadoCDR = consultarEstadoCDR($ruc, $tipo, $serie, intval($numero));

        if ($resultado_consultarEstadoCDR['ok']) {

            $resultado_leerCDRXml =  leerCDRXml($resultado_consultarEstadoCDR['nombreArchivo']);

            if ($resultado_leerCDRXml['ok']) {

                $document_id = $resultado_leerCDRXml['document_id'];
                //$reference_id = $cdr['reference_id'];
                $response_code = $resultado_leerCDRXml['response_code'];
                $description = $resultado_leerCDRXml['description'];
                $response_date = $resultado_leerCDRXml['response_date'];
                $response_time = $resultado_leerCDRXml['response_time'];

                if ($response_code == '0') {
                    $CodigoRespuesta = "D101";
                } else {
                    $CodigoRespuesta = $response_code;
                }

                $Respuesta = "{'MensajeRespuesta':'" . $description . "','CodigoRespuesta':'" . $CodigoRespuesta . "','TicketRespuesta':'" . $document_id . "','FechaRespuesta':'" . $response_date . "','HoraRespuesta':'" . $response_time . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . $resultado_consultarEstadoCDR['contenidoBase64'] . "'}";
            } else {
                $Respuesta = "{'MensajeRespuesta':'Error al leer el CDR','CodigoRespuesta':'D108','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'2','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':''}";
            }
        } else {
            $Respuesta = "{'MensajeRespuesta':'" . $resultado_consultarEstadoCDR['mensaje'] . "','CodigoRespuesta':'" . "D107" . "','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'2','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':''}";
        }
    }

    return $Respuesta;
}

/**
 * Procesar un archivo XML y devolver la respuesta.
 *
 * @param string $oXmlUrl URL del archivo XML.
 * @param string $oXmlNombre Nombre del archivo XML.
 * @return string Respuesta en formato JSON.
 */
function FncProcesar($oXmlUrl, $oXmlNombre)
{

    $Respuesta = "";

    $oXmlNombreConExtension = $oXmlNombre . ".xml";
    $oXmlNombreConExtensionZip = $oXmlNombre . ".zip";

    if ($oXmlUrl == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro url de archivo xml','CodigoRespuesta':'P102'}";
    } else if ($oXmlNombre == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro nombre de archivo xml','CodigoRespuesta':'P103'}";
    } else {

        if (!descargarArchivo($oXmlUrl, $oXmlNombreConExtension)) {
            $Respuesta = "{'MensajeRespuesta':'No se pudo descargar el archivo xml','CodigoRespuesta':'P104'}";
        } else {

            $resultado_firmarDocumentoConPEM = firmarDocumentoConPEM($oXmlNombreConExtension);

            if (!$resultado_firmarDocumentoConPEM['ok']) {
                $Respuesta = "{'MensajeRespuesta':'No se pudo firmar el archivo xml','CodigoRespuesta':'P105'}";
            } else {

                $rutaZip = comprimirArchivoShell($resultado_firmarDocumentoConPEM['archivo_firmado'], 'envio/');

                if (!$rutaZip) {
                    $Respuesta = "{'MensajeRespuesta':'No se pudo comprimir el archivo xml','CodigoRespuesta':'P106'}";
                } else {

                    $zipBytes = file_get_contents($rutaZip);
                    $resultado_procesarComprobante = procesarComprobante($oXmlNombreConExtensionZip, $zipBytes);

                    if ($resultado_procesarComprobante['ok']) {

                        $cdr_leerCDRXml =  leerCDRXml($resultado_procesarComprobante['nombreArchivo']);

                        if ($cdr_leerCDRXml['ok']) {

                            $document_id = $cdr_leerCDRXml['document_id'];
                            //$reference_id = $cdr_leerCDRXml['reference_id'];
                            $response_code = $cdr_leerCDRXml['response_code'];
                            $description = $cdr_leerCDRXml['description'];
                            $response_date = $cdr_leerCDRXml['response_date'];
                            $response_time = $cdr_leerCDRXml['response_time'];

                            if ($response_code == '0') {
                                $CodigoRespuesta = "P101";
                            } else {
                                $CodigoRespuesta = $response_code;
                            }

                            $Respuesta = "{'MensajeRespuesta':'" . $description . "','CodigoRespuesta':'" . $CodigoRespuesta . "','TicketRespuesta':'" . $document_id . "','FechaRespuesta':'" . $response_date . "','HoraRespuesta':'" . $response_time . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . $resultado_procesarComprobante['contenidoBase64'] . "'}";
                        } else {
                            $Respuesta = "{'MensajeRespuesta':'Error al leer el CDR','CodigoRespuesta':'P108','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'2','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':''}";
                        }
                    } else {
                        $Respuesta = "{'MensajeRespuesta':'" . $resultado_procesarComprobante['mensaje'] . "','CodigoRespuesta':'" .  $resultado_procesarComprobante['response'] . "','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . "" . "'}";
                        //Console.WriteLine("{'MensajeRespuesta':'" + MensajeRespuesta + "','CodigoRespuesta':'" + CodigoRespuesta + "','TicketRespuesta':'" + TicketRespuesta + "','FechaRespuesta':'" + FechaRespuesta + "','HoraRespuesta':'" + HoraRespuesta + "','Aux':'1','DigestValue':'" + ResultadoFirma.Item2 + "','SignatureValue':'" + ResultadoFirma.Item3 + "','XmlFirmado':'" + ResultadoFirma.Item1 + "','ZIPRespuesta':'"+ ZipRespuesta + "'}");
                    }
                }
            }

            //$resultado = procesarComprobante($oXmlUrl, $oXmlNombre);

        }
    }


    return $Respuesta;
}




/**
 * Procesar un archivo XML de baja y devolver la respuesta.
 *
 * @param string $oXmlUrl URL del archivo XML.
 * @param string $oXmlNombre Nombre del archivo XML.
 * @return string Respuesta en formato JSON.
 */
function FncProcesarBaja($oXmlUrl, $oXmlNombre)
{

    global $URL_SERVICIO;

    $Respuesta = "";

    $oXmlNombreConExtension = $oXmlNombre . ".xml";
    $oXmlNombreConExtensionZip = $oXmlNombre . ".zip";

    if ($oXmlUrl == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro url de archivo xml','CodigoRespuesta':'B103'}";
    } else if ($oXmlNombre == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro nombre de archivo xml','CodigoRespuesta':'B104'}";
    } else {

        if (!descargarArchivo($oXmlUrl, $oXmlNombreConExtension)) {
            $Respuesta = "{'MensajeRespuesta':'No se pudo descargar el archivo xml','CodigoRespuesta':'B105'}";
        } else {

            $resultado_firmarDocumentoConPEM = firmarDocumentoConPEM($oXmlNombreConExtension);

            if (!$resultado_firmarDocumentoConPEM['ok']) {
                $Respuesta = "{'MensajeRespuesta':'No se pudo firmar el archivo xml','CodigoRespuesta':'B106'}";
            } else {

                $rutaZip = comprimirArchivoShell($resultado_firmarDocumentoConPEM['archivo_firmado'], 'envio/');

                if (!$rutaZip) {
                    $Respuesta = "{'MensajeRespuesta':'No se pudo comprimir el archivo xml','CodigoRespuesta':'B107'}";
                } else {

                    $zipBytes = file_get_contents($rutaZip);
                    //$Respuesta = "{'MensajeRespuesta':'gggggggggg','CodigoRespuesta':'BXXX'}";
                    $resultado_procesarBaja = procesarBaja($oXmlNombreConExtensionZip, $zipBytes);


                    if ($resultado_procesarBaja['ok']) {

                        /*
                        $cdr_leerCDRXml =  leerCDRXml($resultado_procesarBaja['nombreArchivo']);

                        if ($cdr_leerCDRXml['ok']) {

                            $document_id = $cdr_leerCDRXml['document_id'];
                            //$reference_id = $cdr_leerCDRXml['reference_id'];
                            $response_code = $cdr_leerCDRXml['response_code'];
                            $description = $cdr_leerCDRXml['description'];
                            $response_date = $cdr_leerCDRXml['response_date'];
                            $response_time = $cdr_leerCDRXml['response_time'];

                            if ($response_code != '') {
                                $CodigoRespuesta = "B101";
                                $MensajeRespuesta = "Baja procesada correctamente, se genero ticket: " . $document_id;
                            } else {
                                $CodigoRespuesta = "B102";
                                $MensajeRespuesta = "No se ha podido procesar la baja completamente, no se genero ticket";
                            }

                            $Respuesta = "{'MensajeRespuesta':'" . $MensajeRespuesta . "','CodigoRespuesta':'" . $CodigoRespuesta . "','TicketRespuesta':'" . $document_id . "','FechaRespuesta':'" . $response_date . "','HoraRespuesta':'" . $response_time . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . $resultado_procesarBaja['contenidoBase64'] . "'}";
                        } else {
                            $Respuesta = "{'MensajeRespuesta':'Error al leer el CDR','CodigoRespuesta':'B108','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'2','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':''}";
                        }*/
                    } else {
                        $Respuesta = "{'MensajeRespuesta':'" . $resultado_procesarBaja['mensaje'] . "','CodigoRespuesta':'" .  $resultado_procesarBaja['response'] . "','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . "" . "'}";
                        //Console.WriteLine("{'MensajeRespuesta':'" + MensajeRespuesta + "','CodigoRespuesta':'" + CodigoRespuesta + "','TicketRespuesta':'" + TicketRespuesta + "','FechaRespuesta':'" + FechaRespuesta + "','HoraRespuesta':'" + HoraRespuesta + "','Aux':'1','DigestValue':'" + ResultadoFirma.Item2 + "','SignatureValue':'" + ResultadoFirma.Item3 + "','XmlFirmado':'" + ResultadoFirma.Item1 + "','ZIPRespuesta':'"+ ZipRespuesta + "'}");
                    }
                }
            }

            //$resultado = procesarComprobante($oXmlUrl, $oXmlNombre);

        }
    }


    return $Respuesta;
}

function FncProcesarBajaResumen($oXmlUrl, $oXmlNombre)
{

    global $URL_SERVICIO;

    $Respuesta = "";

    $oXmlNombreConExtension = $oXmlNombre . ".xml";
    $oXmlNombreConExtensionZip = $oXmlNombre . ".zip";

    if ($oXmlUrl == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro url de archivo xml','CodigoRespuesta':'B103'}";
    } else if ($oXmlNombre == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro nombre de archivo xml','CodigoRespuesta':'B104'}";
    } else {

        if (!descargarArchivo($oXmlUrl, $oXmlNombreConExtension)) {
            $Respuesta = "{'MensajeRespuesta':'No se pudo descargar el archivo xml','CodigoRespuesta':'B105'}";
        } else {

            $resultado_firmarDocumentoConPEM = firmarDocumentoConPEM($oXmlNombreConExtension);

            if (!$resultado_firmarDocumentoConPEM['ok']) {
                $Respuesta = "{'MensajeRespuesta':'No se pudo firmar el archivo xml','CodigoRespuesta':'B106'}";
            } else {

                $rutaZip = comprimirArchivoShell($resultado_firmarDocumentoConPEM['archivo_firmado'], 'envio/');

                if (!$rutaZip) {
                    $Respuesta = "{'MensajeRespuesta':'No se pudo comprimir el archivo xml','CodigoRespuesta':'B107'}";
                } else {

                    $zipBytes = file_get_contents($rutaZip);
                    //$Respuesta = "{'MensajeRespuesta':'gggggggggg','CodigoRespuesta':'BXXX'}";
                    $resultado_procesarBaja = procesarBajaResumen($oXmlNombreConExtensionZip, $zipBytes);


                    if ($resultado_procesarBaja['ok']) {

                        $Respuesta = "{'MensajeRespuesta':'Baja procesada correctamente, se genero ticket " . $resultado_procesarBaja['ticket'] . " | mensaje: " . $resultado_procesarBaja['mensaje'] . "','CodigoRespuesta':'B101','TicketRespuesta':'" . $resultado_procesarBaja['ticket'] . "','FechaRespuesta':'','HoraRespuesta':'','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':''}";

                        /*
                        $cdr_leerCDRXml =  leerCDRXml($resultado_procesarBaja['nombreArchivo']);

                        if ($cdr_leerCDRXml['ok']) {

                            $document_id = $cdr_leerCDRXml['document_id'];
                            //$reference_id = $cdr_leerCDRXml['reference_id'];
                            $response_code = $cdr_leerCDRXml['response_code'];
                            $description = $cdr_leerCDRXml['description'];
                            $response_date = $cdr_leerCDRXml['response_date'];
                            $response_time = $cdr_leerCDRXml['response_time'];

                            if ($response_code != '') {
                                $CodigoRespuesta = "B101";
                                $MensajeRespuesta = "Baja procesada correctamente, se genero ticket: " . $document_id;
                            } else {
                                $CodigoRespuesta = "B102";
                                $MensajeRespuesta = "No se ha podido procesar la baja completamente, no se genero ticket";
                            }

                            $Respuesta = "{'MensajeRespuesta':'" . $MensajeRespuesta . "','CodigoRespuesta':'" . $CodigoRespuesta . "','TicketRespuesta':'" . $document_id . "','FechaRespuesta':'" . $response_date . "','HoraRespuesta':'" . $response_time . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . $resultado_procesarBaja['contenidoBase64'] . "'}";
                        } else {
                            $Respuesta = "{'MensajeRespuesta':'Error al leer el CDR','CodigoRespuesta':'B108','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'2','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':''}";
                        }*/
                    } else {
                        $Respuesta = "{'MensajeRespuesta':' No se ha podido procesar la baja completamente, no se genero ticket  | response: " . $resultado_procesarBaja['response'] . " | mensaje: " . $resultado_procesarBaja['mensaje'] . "','CodigoRespuesta':'B102','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . "" . "'}";
                        //Console.WriteLine("{'MensajeRespuesta':'" + MensajeRespuesta + "','CodigoRespuesta':'" + CodigoRespuesta + "','TicketRespuesta':'" + TicketRespuesta + "','FechaRespuesta':'" + FechaRespuesta + "','HoraRespuesta':'" + HoraRespuesta + "','Aux':'1','DigestValue':'" + ResultadoFirma.Item2 + "','SignatureValue':'" + ResultadoFirma.Item3 + "','XmlFirmado':'" + ResultadoFirma.Item1 + "','ZIPRespuesta':'"+ ZipRespuesta + "'}");
                    }
                }
            }

            //$resultado = procesarComprobante($oXmlUrl, $oXmlNombre);

        }
    }


    return $Respuesta;
}

/*
// === Uso de ejemplo ===
try {

    $nombreArchivo = "20607038431-03-B001-000313.xml";
    $resultado = firmarDocumentoConPEM($nombreArchivo);

    // Leer el XML firmado y reescribirlo (por si se quiere modificar, codificar, etc.)
    //$contenidoFirmado = file_get_contents($resultado['archivo_firmado']);

    //// Guardar de nuevo para asegurar
    //file_put_contents("firmado/" . $nombreArchivo, $contenidoFirmado);

    echo "✅ Archivo firmado guardado correctamente en: firmado/$nombreArchivo\n";
    echo "📌 DigestValue: " . $resultado['DigestValue'] . "\n";
    echo "✍️ SignatureValue: " . $resultado['SignatureValue'] . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

*/