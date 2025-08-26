<?php
date_default_timezone_set('America/Lima');
set_time_limit(1200);

require_once __DIR__ . '/vendor/autoload.php';

//CONFIGURACIONES
require_once('configuraciones/CnfGeneral.php');

use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;

use DOMDocument;
use DOMXPath;
use ZipArchive;
use Exception;
use SimpleXMLElement;
use DateTime;


function lineaTieneMasDeUnaHora($rutaArchivo = "sunatapi.txt")
{
    guardarLog("lineaTieneMasDeUnaHora");

    if (!file_exists($rutaArchivo)) {
        return false; // Si el archivo no existe, no hay nada que validar
    }

    $linea = trim(file_get_contents($rutaArchivo)); // Leer toda la línea (único registro)
    //guardarLog($linea);

    if (empty($linea)) {
        return false; // Si está vacío
    }

    $partes = explode('|', $linea, 2);
    if (count($partes) < 2) {
        return false; // Estructura inválida
    }

    $fechaTexto = trim($partes[0]); // Ej: 2025-06-06 15:00:00
    $timestampLinea = strtotime($fechaTexto);

    if ($timestampLinea === false) {
        return false; // Fecha inválida
    }

    $timestampAhora = time();
    $diferenciaSegundos = $timestampAhora - $timestampLinea;
    $diferenciaHoras = $diferenciaSegundos / 3600;

    guardarLog("Fecha leída: " . $fechaTexto);
    guardarLog("Timestamp leído: " . $timestampLinea);
    guardarLog("Timestamp ahora: " . $timestampAhora);
    guardarLog("Diferencia en horas: " . $diferenciaHoras);

    return $diferenciaHoras <= 1;
}


function guardarTextoUnicoConFecha($texto, $rutaArchivo = "sunatapi.txt")
{
    // Obtener la fecha y hora actual
    $fechaHora = date("Y-m-d H:i:s");

    // Formar la línea a guardar
    $linea = $fechaHora . " | " . $texto . PHP_EOL;

    // Escribir (sobrescribe el archivo)
    file_put_contents($rutaArchivo, $linea);  // sin FILE_APPEND
}

function obtenerContenidoDeSegundaColumna($rutaArchivo = "sunatapi.txt")
{
    if (!file_exists($rutaArchivo)) {
        return null; // Archivo no existe
    }

    $linea = trim(file_get_contents($rutaArchivo));

    //var_dump( $linea);

    if (empty($linea)) {
        return null; // Línea vacía
    }

    $partes = explode('|', $linea, 2);

    if (count($partes) < 2) {
        return null; // No hay segunda columna
    }
    //var_dump($partes[1]);

    return trim($partes[1]); // Retornar la segunda columna limpia
}

/*
function guardarLog($texto, $rutaArchivo = "log.txt")
{
    // Obtener la fecha y hora actual
    $fechaHora = date("Y-m-d H:i:s");

    // Formar la línea a guardar
    $linea = $fechaHora . " | " . $texto . PHP_EOL;

    // Escribir (sobrescribe el archivo)
    file_put_contents($rutaArchivo, $linea, FILE_APPEND);  // sin FILE_APPEND
}
*/


function guardarLog($texto, $rutaArchivo = "log.txt")
{
    // Obtener la fecha y hora actual
    $fechaHora = date("Y-m-d H:i:s");

    // Formar la línea a guardar
    $linea = $fechaHora . " | " . $texto . PHP_EOL;

    // Abrir el archivo en modo escritura y añadir (append)
    $archivo = fopen($rutaArchivo, "a"); // "a" para escribir al final del archivo

    if ($archivo) {
        fwrite($archivo, $linea);
        fclose($archivo);
    } else {
        // Manejar error si no se puede abrir el archivo
        error_log("No se pudo abrir el archivo de log: $rutaArchivo");
    }
}

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

/**
 * Descargar un archivo desde una URL y guardarlo en una carpeta específica.
 *
 * @param string $url URL del archivo a descargar.
 * @param string $nombreArchivo Nombre del archivo a guardar.
 * @return string Ruta completa del archivo descargado.
 */
function descargarArchivo($url, $nombreArchivo)
{
    global $CARPETA_DESCARGADO_GR;

    //$carpetaDestino = 'descargado/';
    $carpetaDestino = $CARPETA_DESCARGADO_GR . '';

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


/**
 * Firmar un documento XML utilizando un certificado PEM.
 *
 * @param string $nombreArchivo Nombre del archivo XML a firmar.
 * @return array Resultado de la firma.
 * @throws Exception Si ocurre un error durante el proceso de firma.
 */


function firmarDocumentoConPEM($nombreArchivo)
{
    //echo "firmarDocumentoConPEM";

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

    //var_dump($rutaXML);
    //echo "<br>";

    //var_dump($rutaCert);
    //echo "<br>";

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

    //var_dump("aaaa");

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

    //var_dump("bbb");
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

    //var_dump($rutaFirmado);
    //echo "<br>";

    // Guardar el XML firmado
    $doc->save($rutaFirmado);

    return [
        'ok' => true,
        // 'archivo_nombre' => $zipNombre,
        'archivo_firmado' => $rutaFirmado,
        //  'archivo_zip' => $rutaZIP,
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

    guardarLog("leerCDRXml");

    global $CARPETA_CDR_GR;

    $carpeta = $CARPETA_CDR_GR;

    guardarLog($carpeta);

    // Ruta completa al archivo ZIP
    $rutaZip = rtrim($carpeta, '/') . '/' . $archivoZip;

    $partes = explode('.', $archivoZip);

    // Carpeta temporal de extracción
    $rutaTemp = $carpeta . '/temp_cdr/' . $partes[0];
    if (!is_dir($rutaTemp)) {
        mkdir($rutaTemp, 0777, true);
    }

    guardarLog($rutaTemp);

    // Descomprimir usando shell_exec
    $comando = "unzip -o " . escapeshellarg($rutaZip) . " -d " . escapeshellarg($rutaTemp);
    $resultadoShell = shell_exec($comando);

    guardarLog($comando);

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
    $documentID = (string) $docResponse->children($namespaces['cac'])->DocumentReference->children($namespaces['cbc'])->ID;

    $DocumentDescription = (string) $docResponse->children($namespaces['cac'])->DocumentReference->children($namespaces['cbc'])->DocumentDescription;

    return array(
        'ok' => true,
        'document_id' => $documentID, //TICKET
        'reference_id' => $referenceID,
        'response_code' => $responseCode,
        'description' => $description,
        'URLRespuesta' => $DocumentDescription,
        'response_date' => $responseDate,
        'response_time' => $responseTime,
    );
}


/**
 * Obtener un token de acceso para la API de SUNAT.
 *
 * @return string Token de acceso.
 * @throws Exception Si ocurre un error al obtener el token.
 */


function obtenerTokenSunat()
{

    guardarLog("obtenerTokenSunat");

    global $URL_SERVICIO_TOKEN;
    global $URL_SERVICIO_GUIAREMISION;
    global $URL_SERVICIO_GUIAREMISIONC;

    global $CLAVESOL_USUARIO_OTRO;
    global $CLAVESOL_CONTRASENA_OTRO;

    global $API_CLIENTEID;
    global $API_SECRET;

    global $RUC;

    if (!lineaTieneMasDeUnaHora()) {

        guardarLog("lineaTieneMasDeUnaHora ARRIBA");

        //var_dump("lineaTieneMasDeUnaHora. aaaa");
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

        // Tiempo de espera aumentado
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6000); // segundos para conectar
        curl_setopt($ch, CURLOPT_TIMEOUT, 9000);        // segundos total ejecución

        // Forzar uso de TLS 1.2
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

        // Omitir validación de certificado si es necesario (no recomendable en producción)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);


        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //return "SSSSS".$httpCode." - ".$CLAVESOL_CONTRASENA_OTRO;

        if (curl_errno($ch)) {
            // throw new Exception('Curl error: ' . curl_error($ch));
            return 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);

        if ($httpCode !== 200) {
            //throw new Exception("HTTP $httpCode: $response");
            return "HTTP $httpCode: $response";
        }

        // Decodificar respuesta JSON y obtener access_token
        $json = json_decode($response, true);

        if (!isset($json['access_token'])) {
            //throw new Exception('Token no encontrado en la respuesta: ' . $response);
            return 'Token no encontrado en la respuesta: ' . $response;
        }

        // Guardar el texto en el archivo (sobrescribe si ya existe)
        //$rutaArchivo = date("Y-m-d H:i:s") . "|" . "tokenapi.txt";
        //file_put_contents($rutaArchivo, $json['access_token']);
        guardarTextoUnicoConFecha($json['access_token']);

        return $json['access_token'];
    } else {

        guardarLog("lineaTieneMasDeUnaHora ABAJO");
        //var_dump("lineaTieneMasDeUnaHora bbbb");

        $access_token = obtenerContenidoDeSegundaColumna();

        // guardarLog("access_token: " . $access_token);

        if ($access_token != "") {
            return $access_token;
        } else {
            return "";
        }
    }
}



/**
 * Enviar un documento a la API de SUNAT.
 *
 * @param string $oTramaArchivo Contenido del archivo a enviar.
 * @param string $oNombreArchivo Nombre del archivo a enviar.
 * @param string $oToken Token de autorización.
 * @param string $oRutaArchivoZip Ruta del archivo ZIP.
 * @return array Resultado de la operación.
 */
function MtdEnviarDocumentoAPI($oTramaArchivo, $oNombreArchivo, $oToken, $oRutaArchivoZip)
{

    guardarLog("MtdEnviarDocumentoAPI");

    global $URL_SERVICIO_GUIAREMISION;

    $oNombreArchivo =  pathinfo($oNombreArchivo, PATHINFO_FILENAME);

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
    $numeroComprobante =  ($parts[3]);

    guardarLog("numeroComprobante*: " . $numeroComprobante);

    $nuevo_api_url_gre = $URL_SERVICIO_GUIAREMISION . "-" . $serieComprobante . "-" . $numeroComprobante;

    guardarLog("nuevo_api_url_gre: " . $nuevo_api_url_gre);

    guardarLog("oRutaArchivoZip: " . $oRutaArchivoZip);

    //var_dump($nuevo_api_url_gre);
    //echo "<br>";
    // Calcular hash del archivo zip
    if (!file_exists($oRutaArchivoZip)) {
        return array(
            'ok' => false,
            'mensaje' => "Archivo ZIP no encontrado"
        );
    }

    $hash = (hash_file('sha256', $oRutaArchivoZip));

    guardarLog("hash: " . $hash);

    $postData = json_encode([
        "archivo" => [
            "nomArchivo" => $oNombreArchivo . ".zip",
            "arcGreZip" =>  $zipBase64,
            "hashZip" => $hash
        ]
    ]);

    guardarLog("postData: " . $postData);

    $ch = curl_init($nuevo_api_url_gre);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $oToken",
        "Content-Type: application/json",
        "Accept: application/json"
    ]);

    // Tiempo de espera aumentado
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6000); // segundos para conectar
    curl_setopt($ch, CURLOPT_TIMEOUT, 12000);        // segundos total ejecución

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $responseBody = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    guardarLog("httpCode: " . $httpCode);
    guardarLog("responseBody: " . $responseBody);

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

    guardarLog("MtdConsultarTicketAPI");

    global $URL_SERVICIO_GUIAREMISIONC;
    global $CARPETA_CDR_GR;

    // $nuevo_api_url_gre = $URL_SERVICIO_GUIAREMISIONC . "" . $oTicket;
    $nuevo_api_url_gre = rtrim($URL_SERVICIO_GUIAREMISIONC, '/') . '/' . $oTicket;

    guardarLog($nuevo_api_url_gre);
    //var_dump($oToken);

    $headers = [
        "Authorization: Bearer $oToken",
        "Accept: application/json",
        "Content-Type: application/json"
    ];
    /*
    return array(
        'ok' => FALSE,
        'mensaje' => 'CDR recibido y guardado correctamente SFDSDFFSFSD: ' . $oTicket

    );
    exit();*/

    guardarLog("curl_init: ");

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $nuevo_api_url_gre);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // para obtener la respuesta
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // desactiva validación SSL (solo si es necesario)
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    // ⏱️ Tiempo de espera aumentado
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10000); // tiempo máximo para conectar
    curl_setopt($ch, CURLOPT_TIMEOUT, 12000);        // tiempo máximo total de la solicitud

    $responseBody = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    //var_dump($nuevo_api_url_gre);
    //var_dump($ch);

    curl_close($ch);

    guardarLog("httpCode: " . $httpCode);
    guardarLog("responseBody: " . $responseBody);
    //var_dump($httpCode);
    //var_dump($responseBody);
    //exit();

    if ($httpCode === 200 && $responseBody) {
        $json = json_decode($responseBody, true);

        guardarLog("codRespuesta: " . $json['codRespuesta']);

        if (isset($json)) {

            guardarLog("indCdrGenerado: " . $json['indCdrGenerado']);

            $rutaZip = "";
            $nombreArchivo = "";

            $contenidoBase64 = trim($json['arcCdr']);
            $binario = base64_decode($contenidoBase64);

            if ($binario !== false) {
                //$carpetaCDR = 'respuesta/';
                $carpetaCDR =  $CARPETA_CDR_GR;
                if (!is_dir($carpetaCDR)) {
                    mkdir($carpetaCDR, 0777, true);
                }

                $nombreArchivo =   pathinfo($oTicket, PATHINFO_FILENAME)  . '.zip';
                $rutaZip = $carpetaCDR . $nombreArchivo;

                file_put_contents($rutaZip, $binario);

                /*return array(
                    'ok' => true,
                    'mensaje' => 'CDR recibido y guardado correctamente',
                    'archivo_cdr' => $rutaZip,
                    'nombreArchivo' => $nombreArchivo,
                    'contenidoBase64' => $contenidoBase64
                );*/
            }

            return array(
                'ok' => true,
                'mensaje' => 'CDR recibido y guardado correctamente',
                //'response' => $responseBody,
                'codRespuesta' => $json['codRespuesta'],
                'indCdrGenerado' => $json['indCdrGenerado'],
                'numError' => $json['error']['numError'],
                'desError' => $json['error']['desError'],
                'arcCdr' => $json['arcCdr'],
                'archivo_cdr' => $rutaZip,
                'nombreArchivo' => $nombreArchivo
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


function FncConsultarEstadoCDR($oTicketNumero, $oXMLNombre)
{
    guardarLog("FncConsultarEstadoCDR");

    //guardarLog("aaaaaaaaaaaaaaaa", "log2.txt");

    //guardarLog("oTicketNumero " . $oTicketNumero, "log2.txt");
    //guardarLog("oXMLNombre " . $oXMLNombre, "log2.txt");

    $Respuesta = "";

    if ($oTicketNumero == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro numero de ticket','CodigoRespuesta':'D102'}";
    } else if ($oXMLNombre == "") {
        $Respuesta = "{'MensajeRespuesta':'No se encontro nombre de archivo','CodigoRespuesta':'D103'}";
    } else {

        //guardarLog("bbbbb ");
        $access_token = obtenerTokenSunat();

        guardarLog("access_token: " . $access_token);
        //guardarLog("access_token ***: " . $access_token);
        //guardarLog($access_token);
        //$access_token = "CAPIBARA";
        //$Respuesta = "{'MensajeRespuesta':'" . $access_token . "','CodigoRespuesta':'D1xxxx'}";

        if ($access_token != "") {

            $resultado_MtdConsultarTicketAPI = MtdConsultarTicketAPI($oTicketNumero,   $access_token);

            if ($resultado_MtdConsultarTicketAPI['ok']) {

                if ($resultado_MtdConsultarTicketAPI['codRespuesta'] != '') {

                    if ($resultado_MtdConsultarTicketAPI['codRespuesta'] == '0') {

                        if ($resultado_MtdConsultarTicketAPI['arcCdr'] != '') {

                            guardarLog($resultado_MtdConsultarTicketAPI['nombreArchivo']);

                            $resultado_leerCDRXml =  leerCDRXml($resultado_MtdConsultarTicketAPI['nombreArchivo']);

                            if ($resultado_leerCDRXml['ok']) {

                                $document_id = $resultado_leerCDRXml['document_id'];
                                //$reference_id = $cdr['reference_id'];
                                $response_code = $resultado_leerCDRXml['response_code'];
                                $description = $resultado_leerCDRXml['description'];
                                $response_date = $resultado_leerCDRXml['response_date'];
                                $response_time = $resultado_leerCDRXml['response_time'];
                                $contenidoBase64 = $resultado_leerCDRXml['contenidoBase64'];
                                $URLRespuesta = $resultado_leerCDRXml['URLRespuesta'];

                                if ($response_code == '0') {
                                    $CodigoRespuesta = "D101";
                                } else {
                                    $CodigoRespuesta = $response_code;
                                }
                                $Respuesta = "{'MensajeRespuesta':'" . $description . "','CodigoRespuesta':'" . $CodigoRespuesta . "','TicketRespuesta':'" . $document_id . "','FechaRespuesta':'" . $response_date . "','HoraRespuesta':'" . $response_time . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . $contenidoBase64 . "','URLRespuesta':'" . $URLRespuesta . "'}";
                            } else {
                                $Respuesta = "{'MensajeRespuesta':'Error al leer el CDR','CodigoRespuesta':'D108','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'2','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':''}";
                            }
                        } else {
                            $Respuesta = "{'MensajeRespuesta':'No se pudo encontrar el archivo CDR','CodigoRespuesta':'D106'}";
                        }
                    } else  if ($resultado_MtdConsultarTicketAPI['codRespuesta'] == '99') {

                        $codRespuesta = $resultado_MtdConsultarTicketAPI['codRespuesta'];
                        $indCdrGenerado = $resultado_MtdConsultarTicketAPI['indCdrGenerado'];
                        $numError = $resultado_MtdConsultarTicketAPI['numError'];
                        $desError = $resultado_MtdConsultarTicketAPI['desError'];

                        $MensajeRespuesta = "codRespuesta " . $codRespuesta . " indCdrGenerado " .  $indCdrGenerado . " numError " .  $numError . " desError " .  $desError;

                        $Respuesta = "{'MensajeRespuesta':'" .   $MensajeRespuesta . "','CodigoRespuesta':'" .  $codRespuesta . "','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'2','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':''}";
                    } else {
                        $Respuesta = "{'MensajeRespuesta':'No se pudo identificar el codigo de respuesta','CodigoRespuesta':'D105'}";
                    }
                } else {
                    $Respuesta = "{'MensajeRespuesta':'No se pudo obtener un codigo de respuesta','CodigoRespuesta':'D104'}";
                }
            } else {
                $Respuesta = "{'MensajeRespuesta':'" . $resultado_MtdConsultarTicketAPI['mensaje'] . "','CodigoRespuesta':'" . "D109" . "','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'2','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':''}";
            }
        } else {
            $Respuesta = "{'MensajeRespuesta':'No se pudo obtener el token de acceso','CodigoRespuesta':'D107'}";
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

    guardarLog("FncProcesar");

    guardarLog("oXmlUrl: " . $oXmlUrl);
    guardarLog("oXmlNombre: " . $oXmlNombre);

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

                $rutaZip = comprimirArchivoShell($resultado_firmarDocumentoConPEM['archivo_firmado']);

                guardarLog("rutaZip: " . $rutaZip);

                if (!$rutaZip) {
                    $Respuesta = "{'MensajeRespuesta':'No se pudo comprimir el archivo xml','CodigoRespuesta':'P106'}";
                } else {

                    $access_token = obtenerTokenSunat();

                    guardarLog("access_token: " . $access_token);

                    if ($access_token != "") {

                        $zipBytes = file_get_contents($rutaZip);
                        $resultado_MtdEnviarDocumentoAPI = MtdEnviarDocumentoAPI($zipBytes, $oXmlNombreConExtension, $access_token, $rutaZip);

                        if ($resultado_MtdEnviarDocumentoAPI['ok']) {

                            $numTicket = $resultado_MtdEnviarDocumentoAPI['numTicket'];
                            $fecRecepcion = $resultado_MtdEnviarDocumentoAPI['fecRecepcion'];

                            if ($numTicket != "") {
                                $CodigoRespuesta = "P101";
                                $MensajeRespuesta = "numTicket " +   $numTicket + " fecRecepcion " + $fecRecepcion;
                            } else {
                                $CodigoRespuesta = "P107";
                                $MensajeRespuesta = "No se pudo obtener el numTicket";
                            }

                            $Respuesta = "{'MensajeRespuesta':'" . $MensajeRespuesta . "','CodigoRespuesta':'" . $CodigoRespuesta . "','TicketRespuesta':'" . $numTicket . "','FechaRespuesta':'" . $fecRecepcion . "','HoraRespuesta':'" . "" . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . "" . "'}";
                        } else {
                            $Respuesta = "{'MensajeRespuesta':'" . $resultado_MtdEnviarDocumentoAPI['mensaje'] . "','CodigoRespuesta':'" .  "P108" . "','TicketRespuesta':'" . "" . "','FechaRespuesta':'" . "" . "','HoraRespuesta':'" . "" . "','Aux':'1','DigestValue':'','SignatureValue':'','XmlFirmado':'','ZIPRespuesta':'" . "" . "'}";
                        }
                    } else {
                        $Respuesta = "{'MensajeRespuesta':'No se pudo obtener el token de acceso','CodigoRespuesta':'P109'}";
                    }
                }
            }

            //$resultado = procesarComprobante($oXmlUrl, $oXmlNombre);

        }
    }


    return $Respuesta;
}
