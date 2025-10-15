<?php
require_once('../../../proyecto/ClsProyecto.php');
$InsProyecto->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfFormularioNota.php');

////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes() . 'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases() . 'ClsSesion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias() . 'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases() . 'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones() . 'ClsConexion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones() . 'FncGeneral.php');

// --- NUEVO: Sanitizar entradas con valores por defecto ---
$Identificador = $_POST['Identificador'] ?? '';
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'] ?? "0";
$POST_PorcentajeImpuestoVenta = (float)($_POST['PorcentajeImpuestoVenta'] ?? 0);
$POST_IncluyeSelectivo = $_POST['IncluyeSelectivo'] ?? "0";
$POST_PorcentajeImpuestoSelectivo = (float)($_POST['PorcentajeImpuestoSelectivo'] ?? 0);

$POST_Descuento = (float)($_POST['Descuento'] ?? 0);
$POST_Gratuito = ($_POST['Gratuito'] ?? 2);
$POST_Exonerado = ($_POST['Exonerado'] ?? 2);

session_start();
if (!isset($_SESSION['InsFacturaDetalle' . $Identificador])) {
	$_SESSION['InsFacturaDetalle' . $Identificador] = new ClsSesionObjeto();
} else {
	$_SESSION['InsFacturaDetalle' . $Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFacturaDetalle' . $Identificador]);
}

// Obtener item
$Item = $_POST['Item'] ?? null;
if ($Item === null) {
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode([
		'ok' => false,
		'error' => 'Falta parámetro Item'
	]);
	exit;
}

$InsFacturaDetalle1 = $_SESSION['InsFacturaDetalle' . $Identificador]->MtdObtenerSesionObjeto($Item);

// --- NUEVO: Inicializaciones seguras ---
$Cantidad = isset($_POST['Cantidad']) ? (float)$_POST['Cantidad'] : 0;
$Importe  = isset($_POST['Importe']) ? (float)$_POST['Importe'] : 0;

if ($Cantidad <= 0) {
	$Precio = 0;
} else {
	$Precio = round(($Importe / $Cantidad), 6);
}

$Descuento = 0.0;
$Impuesto = 0.0;
$ImpuestoSelectivo = 0.0;
$ValorVenta = 0.0;

// --- Cálculos ---
if ($POST_IncluyeImpuesto == "1") {
	if ($POST_Exonerado == "1") {
		$ValorVenta = $Importe;
		$Descuento = $POST_Descuento;
		//$ValorVenta -= $Descuento;
		$ValorVenta = $ValorVenta - $Descuento;
		$Impuesto = 0.0;

		if ($POST_IncluyeSelectivo === "1") {
			$ImpuestoSelectivo = $ValorVenta * ($POST_PorcentajeImpuestoSelectivo / 100);
		}
	} else {
		if ($POST_Gratuito == "1") {
			$ValorVenta = ($Importe / (($POST_PorcentajeImpuestoVenta / 100) + 1));
			$Descuento = $POST_Descuento;
			//$ValorVenta -= $Descuento;
			$ValorVenta = $ValorVenta - $Descuento;
			$Impuesto = 0.0;
			if ($POST_IncluyeSelectivo === "1") {
				$ImpuestoSelectivo = $ValorVenta * ($POST_PorcentajeImpuestoSelectivo / 100);
			}
		} else {
			$ValorVenta = ($Importe / (($POST_PorcentajeImpuestoVenta / 100) + 1));
			$Descuento = ($POST_Descuento);
			$ValorVenta = round($ValorVenta - $Descuento, 6);
			$Impuesto = round((($ValorVenta) * ($POST_PorcentajeImpuestoVenta / 100)), 6);
			if ($POST_IncluyeSelectivo == "1") {
				$ImpuestoSelectivo = $ValorVenta * ($POST_PorcentajeImpuestoSelectivo / 100);
			}
		}
	}
} else {
	// Escenario sin impuesto incluido (se deja lógica básica; puedes ajustar)
	/*$ValorVenta = $Importe;
	$Descuento = $POST_Descuento;
	$ValorVenta -= $Descuento;
	$Impuesto = 0.0; // Si se desea calcular fuera, adaptar aquí
	if ($POST_IncluyeSelectivo === "1") {
		$ImpuestoSelectivo = $ValorVenta * ($POST_PorcentajeImpuestoSelectivo / 100);
	}*/
}

// Guardar edición en sesión
$_SESSION['InsFacturaDetalle' . $Identificador]->MtdEditarSesionObjeto(
	$Item,
	1,
	$InsFacturaDetalle1->Parametro1,
	addslashes($_POST['Descripcion'] ?? ''),
	NULL,
	$Precio,
	$Cantidad,
	$Importe,
	$InsFacturaDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	$InsFacturaDetalle1->Parametro9,
	$InsFacturaDetalle1->Parametro10,
	NULL,
	$_POST['FacturaDetalleTipo'] ?? '',
	$_POST['UnidadMedida'] ?? '',
	$InsFacturaDetalle1->Parametro14,
	$InsFacturaDetalle1->Parametro15,
	$InsFacturaDetalle1->Parametro16,
	$InsFacturaDetalle1->Parametro17,
	$_POST['Codigo'] ?? '',
	$ValorVenta,
	$Impuesto,
	$Descuento,
	$POST_Gratuito,
	$POST_Exonerado,
	$POST_IncluyeSelectivo,
	$ImpuestoSelectivo
);

// --- NUEVO: Respuesta JSON ---
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
	'ok' => true,
	'item' => $Item,
	'identificador' => $Identificador,
	'cantidad' => $Cantidad,
	'precioUnitario' => round($Precio, 6),
	'importe' => round($Importe, 6),
	'valorVenta' => round($ValorVenta, 6),
	'descuento' => round($Descuento, 6),
	'impuesto' => round($Impuesto, 6),
	'impuestoSelectivo' => round($ImpuestoSelectivo, 6),
	'incluyeImpuesto' => ($POST_IncluyeImpuesto === "1"),
	'incluyeSelectivo' => ($POST_IncluyeSelectivo === "1"),
	'gratuito' => ($POST_Gratuito === "1"),
	'exonerado' => ($POST_Exonerado === "1"),
	'porcentajeImpuesto' => $POST_PorcentajeImpuestoVenta,
	'porcentajeImpuestoSelectivo' => $POST_PorcentajeImpuestoSelectivo,
	'timestamp' => date('c')
], JSON_UNESCAPED_UNICODE);
exit;
