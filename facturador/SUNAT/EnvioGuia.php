<?php
//PARA HACER PRUEBAS
require_once __DIR__ . '/vendor/autoload.php';

use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;

//CONFIGURACIONES
//require_once('configuraciones/CnfGeneral.php');
//CERTIFICADO
$CERTIFICADO = 'certificado2024';
$CERTIFICADO_CONTRASENA = '';
//CLAVE SOL
//$CLAVESOL_USUARIO = '20607780928FACTU';
//$CLAVESOL_CONTRASENA = 'Decor2024*';

$CLAVESOL_USUARIO = '20607780928RLPDEALO';
$CLAVESOL_CONTRASENA = 'RLPDEALO24';

//$CLAVESOL_USUARIO_OTRO = '20607780928MODDATOS';
//$CLAVESOL_CONTRASENA_OTRO = 'MODDATOS';

$CLAVESOL_USUARIO_OTRO = '20607780928LOVIFICT';
$CLAVESOL_CONTRASENA_OTRO = 'ablesproc89R';

$RUC = '20607780928';

//DATOS API
$API_CLIENTEID = "3d0b932e-9a37-47a1-b3c6-4512cadb6c67";
$API_SECRET = "MKdIPhK1LeJrWThw/tZ6pQ==";
//$API_CLIENTEID = "test-85e5b0ae-255c-4891-a595-0b98c65c9854";
//$API_SECRET = "test-Hty/M6QshYvPgItX2P0+Kw==";

//URL FACTURA
$URL_SERVICIO = 'https://ose.nubefact.com/ol-ti-itcpe/billService';
$URL_SERVICIO_CDR = 'https://ose.nubefact.com/ol-ti-itcpe/billService';
//$URL_SERVICIO_CDR_BETA = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem/billConsultService';

//URL GUIA REMISION
$COD_CPE = "09";
$URL_SERVICIO_TOKEN = "https://api-seguridad.sunat.gob.pe/v1/clientessol/" . $API_CLIENTEID . "/oauth2/token";
$URL_SERVICIO_GUIAREMISION = "https://api-cpe.sunat.gob.pe/v1/contribuyente/gem/comprobantes/" . $RUC . "-" . $COD_CPE . "";
$URL_SERVICIO_GUIAREMISIONC = "https://api-cpe.sunat.gob.pe/v1/contribuyente/gem/comprobantes/envios/";
//$URL_SERVICIO_TOKEN = "https://gre-test.nubefact.com/v1/clientessol/" . $API_CLIENTEID . "/oauth2/token";
//$URL_SERVICIO_GUIAREMISION = "https://gre-test.nubefact.com/v1/contribuyente/gem/comprobantes/" . $RUC . "-" . $COD_CPE . "";
//$URL_SERVICIO_GUIAREMISIONC = "https://gre-test.nubefact.com/v1/contribuyente/gem/comprobantes/envios/";

//CERTIFICADO
$CARPETA_CERTIFICADO = 'certificado/';

//CARPETAS
$CARPETA_CDR = 'respuesta/';
$CARPETA_ENVIO = 'envio/';
$CARPETA_DESCARGADO = 'descargado/';
$CARPETA_FIRMADO = 'firmado/';

//CARPETAS GUIA REMISION
$CARPETA_CDR_GR = 'respuestag/';
$CARPETA_ENVIO_GR = 'enviog/';
$CARPETA_DESCARGADO_GR = 'descargadog/';
$CARPETA_FIRMADO_GR = 'firmadog/';






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


function firmarDocumentoConPEM($nombreArchivo)
{
    global $CLAVESOL_CONTRASENA;
    global $CLAVESOL_USUARIO;

    global $URL_SERVICIO;
    global $URL_SERVICIO_CDR;

    global $CERTIFICADO;
    global $CERTIFICADO_CONTRASENA;

    global $CARPETA_DESCARGADO_GR;
    global $CARPETA_FIRMADO_GR;

    //$rutaCert = 'certificado/certificado-cert.pem';
    //$rutaKey = 'certificado/certificado-key.pem';
    $rutaCert = 'certificado/' . $CERTIFICADO . '-cert.pem';
    $rutaKey = 'certificado/' . $CERTIFICADO . '-key.pem';
    //$rutaXML = 'descargado/' . $nombreArchivo;
    $rutaXML =  $CARPETA_DESCARGADO_GR . '' . $nombreArchivo;
    $rutaFirmado = $CARPETA_FIRMADO_GR . '' . $nombreArchivo;

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




function comprimirArchivoShell($archivoOrigen)
{
    global  $CARPETA_ENVIO_GR;

    // Verifica si el archivo fuente existe
    if (!file_exists($archivoOrigen)) {
        return false;
    }

    // Asegura que la carpeta destino exista
    if (!is_dir($CARPETA_ENVIO_GR)) {
        mkdir($CARPETA_ENVIO_GR, 0777, true);
    }

    // Extrae el nombre base del archivo sin extensión
    $nombreBase = pathinfo($archivoOrigen, PATHINFO_FILENAME);

    // Construye la ruta completa del archivo ZIP
    $archivoZip = rtrim($CARPETA_ENVIO_GR, '/\\') . '/' . $nombreBase . '.zip';

    // Escapa los nombres para evitar problemas de seguridad
    $comando = 'zip -j ' . escapeshellarg($archivoZip) . ' ' . escapeshellarg($archivoOrigen);

    // Ejecuta el comando
    shell_exec($comando);

    // Verifica que se haya creado el ZIP
    return file_exists($archivoZip) ? $archivoZip : false;
}

function obtenerTokenSunat()
{

    global $URL_SERVICIO_TOKEN;
    global $URL_SERVICIO_GUIAREMISION;
    global $URL_SERVICIO_GUIAREMISIONC;

    global $CLAVESOL_USUARIO_OTRO;
    global $CLAVESOL_CONTRASENA_OTRO;

    global $API_CLIENTEID;
    global $API_SECRET;

    global $RUC;


    // Construir el cuerpo POST en formato x-www-form-urlencoded
    $postData = http_build_query([
        'grant_type'    => 'password',
        'scope'         => 'https://api-cpe.sunat.gob.pe',
        'client_id'     => $API_CLIENTEID,
        'client_secret' => $API_SECRET,
        'username'      => $CLAVESOL_USUARIO_OTRO,
        'password'      => $CLAVESOL_CONTRASENA_OTRO
    ]);

    $ch = curl_init($URL_SERVICIO_TOKEN);

    // Configurar CURL para hacer POST
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'Accept: application/json'
    ]);

    // Forzar uso de TLS 1.2
    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

    // Omitir validación de certificado si es necesario (no recomendable en producción)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);


    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("HTTP $httpCode: $response");
    }

    // Decodificar respuesta JSON y obtener access_token
    $json = json_decode($response, true);

    if (!isset($json['access_token'])) {
        throw new Exception('Token no encontrado en la respuesta: ' . $response);
    }

    return $json['access_token'];
}


function MtdEnviarDocumentoAPI($oTramaArchivo, $oNombreArchivo, $oToken, $oRutaArchivoZip)
{

    global $URL_SERVICIO_GUIAREMISION;

    $zipBase64 = base64_encode($oTramaArchivo);

    // Separar nombre del archivo
    $parts = explode('-', $oNombreArchivo);
    if (count($parts) < 4) {
        return array(
            'ok' => false,
            'mensaje' => "Nombre de archivo inválido"
        );
    }

    $serieComprobante = $parts[2];
    $numeroComprobante = $parts[3];
    $nuevo_api_url_gre = $URL_SERVICIO_GUIAREMISION . "-" . $serieComprobante . "-" . $numeroComprobante;

    echo $nuevo_api_url_gre;
    echo "<br>";
    // Calcular hash del archivo zip
    if (!file_exists($oRutaArchivoZip)) {
        return array(
            'ok' => false,
            'mensaje' => "Archivo ZIP no encontrado"
        );
    }

    $hash = (hash_file('sha256', $oRutaArchivoZip));

    $postData = json_encode([
        "archivo" => [
            "nomArchivo" => $oNombreArchivo . ".zip",
            "arcGreZip" =>  $zipBase64,
            "hashZip" => $hash
        ]
    ]);

    $ch = curl_init($nuevo_api_url_gre);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $oToken",
        "Content-Type: application/json",
        "Accept: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $responseBody = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200 && $responseBody) {
        $json = json_decode($responseBody, true);

        if (isset($json['numTicket'], $json['fecRecepcion'])) {
            return array(
                'ok' => true,
                'mensaje' => 'Guia de Remisión enviada correctamente',
                'numTicket' => $json['numTicket'],
                'fecRecepcion' => $json['fecRecepcion'],
            );
        } else {
            return array(
                'ok' => false,
                'mensaje' => $responseBody
            );
        }
    } else {
        return array(
            'ok' => false,
            'mensaje' => "HTTP $httpCode - $curlError - " . strip_tags($responseBody)
        );
    }
}


function MtdConsultarTicketAPI($oTicket, $oToken)
{

    global $URL_SERVICIO_GUIAREMISIONC;

    $nuevo_api_url_gre = $URL_SERVICIO_GUIAREMISIONC . "" . $oTicket;

    $headers = [
        "Authorization: Bearer $oToken",
        "Accept: application/json",
        "Content-Type: application/json"
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $nuevo_api_url_gre);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // para obtener la respuesta
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // desactiva validación SSL (solo si es necesario)
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


    $responseBody = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    /*
    $responseBody = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    
    if (curl_errno($ch)) {
        $errorMsg = curl_error($ch);
        curl_close($ch);
        return [$errorMsg, false];
    }

    curl_close($ch);
*/

    if ($httpCode === 200 && $responseBody) {
        $json = json_decode($responseBody, true);

        if (isset($json)) {
            return array(
                'ok' => true,
                'mensaje' => 'CDR recibido y guardado correctamente',
                'response' => $responseBody,
                'codRespuesta' => $json['codRespuesta'],
                'indCdrGenerado' => $json['indCdrGenerado'],
                'numError' => $json['error']['numError'],
                'desError' => $json['error']['desError'],
                'arcCdr' => $json['arcCdr']
            );
        } else {
            return array(
                'ok' => false,
                'mensaje' => $responseBody
            );
        }
    } else {
        return array(
            'ok' => false,
            'mensaje' => "HTTP $httpCode - $curlError - " . strip_tags($responseBody)
        );
    }
}




$ticket =  "0dbeec52-5bda-4d04-8d02-b379be1ac244";

$access_token = obtenerTokenSunat();

if ($access_token) {

    echo "Token obtenido correctamente: " . $access_token;
    echo "<br>";

    $resultado_MtdConsultarTicketAPI = MtdConsultarTicketAPI($ticket, $access_token);

    if ($resultado_MtdConsultarTicketAPI['ok']) {

        echo "Consulta finalizada: mensaje: " . $resultado_MtdConsultarTicketAPI['mensaje'] . " | response:" . $resultado_MtdConsultarTicketAPI['response'];
        echo "<br>";

        if ($resultado_MtdConsultarTicketAPI['arcCdr'] != '') {
        } else {
        }

        echo "<br>";
        if ($resultado_MtdConsultarTicketAPI['codRespuesta'] == '99') {

            echo "indCdrGenerado: " . $resultado_MtdConsultarTicketAPI['indCdrGenerado'] . "\n";
            echo "<br>";
            echo "numError: " . $resultado_MtdConsultarTicketAPI['numError'] . "\n";
            echo "<br>";
            echo "desError: " . $resultado_MtdConsultarTicketAPI['desError'] . "\n";
            echo "<br>";
        } else {
            echo "Error: " . $resultado_MtdConsultarTicketAPI['mensaje'];
            echo "<br>";
        }
    } else {
        echo "Error: " . $resultado_MtdConsultarTicketAPI['mensaje'];
        echo "<br>";
    }
} else {
    echo "Error al obtener el token.";
    echo "<br>";
}



exit();

$xml = "20607780928-09-T001-5";

$access_token = obtenerTokenSunat();

if ($access_token) {

    echo "Token obtenido correctamente: " . $access_token;
    echo "<br>";

    $resultado_firmarDocumentoConPEM = firmarDocumentoConPEM($xml . ".xml");

    if ($resultado_firmarDocumentoConPEM['ok']) {

        $rutaFirmado = $resultado_firmarDocumentoConPEM['archivo_firmado'];
        $zipNombre = $resultado_firmarDocumentoConPEM['archivo_zip'];

        echo "rutaFirmado: " . $rutaFirmado;
        echo "<br>";
        echo "<br>";

        $rutaZip = comprimirArchivoShell($rutaFirmado, $CARPETA_ENVIO_GR);

        if ($rutaZip) {
            echo "ZIP creado en: $rutaZip";
            echo "<br>";

            $zipBytes = file_get_contents($rutaZip);

            $resultado_MtdEnviarDocumentoAPI = MtdEnviarDocumentoAPI($zipBytes, $xml, $access_token, $rutaZip);

            if ($resultado_MtdEnviarDocumentoAPI['ok']) {
                echo "Procesado: " . $resultado_MtdEnviarDocumentoAPI['mensaje'];
                echo "<br>";
                echo "numTicket: " . $resultado_MtdEnviarDocumentoAPI['numTicket'];
                echo "<br>";
                echo "fecRecepcion: " . $resultado_MtdEnviarDocumentoAPI['fecRecepcion'];
                echo "<br>";
            } else {
                echo "Error: " . $resultado_MtdEnviarDocumentoAPI['mensaje'];
                echo "<br>";
            }
        } else {
            echo "No se pudo comprimir el archivo.";
            echo "<br>";
        }
    } else {
        echo "Error: " . $resultado_firmarDocumentoConPEM['mensaje'];
        echo "<br>";
    }
} else {
    echo "Error al obtener el token.";
    echo "<br>";
}
