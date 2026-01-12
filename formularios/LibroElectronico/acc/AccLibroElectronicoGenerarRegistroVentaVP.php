<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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

//if($_GET['P']==2){
//	header("Content-Type: text/html");
//	header("Content-Disposition:  filename=\"LE".$EmpresaCodigo.date('d-m-Y').".txt\";");
//}

$POST_Sucursal = ($_GET['Sucursal']);
$POST_Sucursal = "";

$POST_Ano = ($_GET['Ano']);
$POST_Mes = ($_GET['Mes']);


$POST_ord = isset($_GET['Orden']) ? $_GET['Orden'] : "FechaEmision";
$POST_sen = isset($_GET['Sentido']) ? $_GET['Sentido'] : "DESC";

$POST_Moneda = ($_GET['Moneda']);
$POST_VP = ($_GET['VP']);

require_once($InsPoo->MtdPaqContabilidad() . 'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica() . 'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsNotaDebito.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsTipoCambio.php');

$InsPago = new ClsPago($InsMysql);
$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda($InsMysql);
$InsCliente = new ClsCliente();
$InsNotaCredito = new ClsNotaCredito();
$InsBoleta = new ClsBoleta();
$InsNotaDebito = new ClsNotaDebito();

$FechaInicio = "01/" . $POST_Mes . "/" . $POST_Ano;
$FechaFin = FncCantidadDiaMes($POST_Ano, $POST_Mes) . "/" . $POST_Mes . "/" . $POST_Ano;

//$CantidadDias = FncCantidadDiaMes($POST_Ano,$POST_Mes);

//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL) 
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL, NULL, NULL, "FtaNumero ASC, FacId ASC", "", NULL, NULL, NULL, FncCambiaFechaAMysql($FechaInicio), FncCambiaFechaAMysql($FechaFin), NULL, NULL, NULL, NULL, NULL, $POST_Moneda, $POST_ClienteId, NULL, NULL, NULL, NULL, NULL, $POST_Personal);
$ArrFacturas = $ResFactura['Datos'];

//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL) {
$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL, NULL, NULL, "BtaNumero ASC, BolId ASC", "", NULL, NULL, FncCambiaFechaAMysql($FechaInicio), FncCambiaFechaAMysql($FechaFin), NULL, NULL, NULL, $POST_Moneda, NULL, $POST_ClienteId);
$ArrBoletas = $ResBoleta['Datos'];

//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL,$oClienteId=NULL)
$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL, NULL, NULL, "NctNumero ASC, NcrId ASC", "", 1, NULL, NULL, NULL, FncCambiaFechaAMysql($FechaInicio), FncCambiaFechaAMysql($FechaFin), NULL, $POST_Moneda, NULL, NULL, NULL, $POST_ClienteId);
$ArrNotaCreditos = $ResNotaCredito['Datos'];

//MtdObtenerNotaDebitos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NdbId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL)
$ResNotaDebito = $InsNotaDebito->MtdObtenerNotaDebitos(NULL, NULL, NULL, "NdtNumero ASC, NdbId ASC", "", 1, NULL, NULL, NULL, FncCambiaFechaAMysql($FechaInicio), FncCambiaFechaAMysql($FechaFin), NULL, $POST_Moneda, NULL, NULL, NULL);
$ArrNotaDebitos = $ResNotaDebito['Datos'];

?>

<h2>REGISTRO DE VENTAS - VISTA PRELIMINAR TXT</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="2">
	<tr>
		<th>Periodo
			<br> (COLUMNA 1)
		</th>
		<th>1. Contribuyentes del Régimen General: Número correlativo del mes o Código Único de la Operación (CUO), que es la llave única o clave única o clave primaria del software contable que identifica de manera unívoca el asiento contable en el Libro Diario o del Libro Diario de Formato Simplificado en que se registró la operación.
			2. Contribuyentes del Régimen Especial de Renta - RER: Número correlativo del mes

			<br> (COLUMNA 2)
		</th>
		<th>
			Número correlativo del asiento contable identificado en el campo 2, cuando se utilice el Código Único de la Operación (CUO). El primer dígito debe ser: "A" para el asiento de apertura del ejercicio, "M" para los asientos de movimientos o ajustes del mes o "C" para el asiento de cierre del ejercicio.
			<br> (COLUMNA 3)
		</th>
		<th>Fecha de emisión del Comprobante de Pago
			<br> (COLUMNA 4)
		</th>
		<th>Fecha de Vencimiento o Fecha de Pago (1)
			<br> (COLUMNA 5)
		</th>

		<th>Tipo de Comprobante de Pago o Documento
			<br> (COLUMNA 6)
		</th>
		<th>Número serie del comprobante de pago o documento o número de serie de la maquina registradora
			<br> (COLUMNA 7)
		</th>
		<th>Número del comprobante de pago o documento.
			Para efectos del registro de tickets o cintas emitidos por máquinas registradoras que no otorguen derecho a crédito fiscal de acuerdo a las normas de Comprobantes de Pago y opten por anotar el importe total de las operaciones realizadas por día y por máquina registradora, registrar el número inicial (2)
			Tratándose del IVAP, el usuario del servicio de pilado anotará la constancia de depósito por los retiros de bienes que hubiere efectuado
			(COLUMNA 8)
		</th>
		<th>1. Para efectos del registro de tickets o cintas emitidos por máquinas registradoras que no otorguen derecho a crédito fiscal de acuerdo a las normas de Comprobantes de Pago y opten por anotar el importe total de las operaciones realizadas por día y por máquina registradora, registrar el número final (2).
			2. Se permite la consolidación diaria de las Boletas de Venta emitidas de manera electrónica
			<br> (COLUMNA 9)
		</th>
		<th>Tipo de Documento de Identidad del cliente
			<br> (COLUMNA 10)
		</th>

		<th>Número de Documento de Identidad del cliente
			<br> (COLUMNA 11)
		</th>
		<th>Apellidos y nombres, denominación o razón social del cliente. En caso de personas naturales se debe consignar los datos en el siguiente orden: Apellido paterno, apellido materno y nombre completo.
			<br> (COLUMNA 12)
		</th>
		<th>Valor facturado de la exportación
			<br> (COLUMNA 13)
		</th>
		<th>Base imponible de la operación gravada (4)
			<br> (COLUMNA 14)
		</th>
		<th>Descuento de la Base Imponible
			<br> (COLUMNA 15)
		</th>

		<th>Impuesto General a las Ventas y/o Impuesto de Promoción Municipal
			<br> (COLUMNA 16)
		</th>
		<th>Descuento del Impuesto General a las Ventas y/o Impuesto de Promoción Municipal
			<br> (COLUMNA 17)
		</th>
		<th>Importe total de la operación exonerada
			<br> (COLUMNA 18)
		</th>
		<th>Importe total de la operación inafecta
			<br> (COLUMNA 19)
		</th>
		<th>Impuesto Selectivo al Consumo, de ser el caso.
			<br> (COLUMNA 20)
		</th>

		<th>Base imponible de la operación gravada con el Impuesto a las Ventas del Arroz Pilado
			<br> (COLUMNA 21)
		</th>
		<th>Impuesto a las Ventas del Arroz Pilado
			<br> (COLUMNA 22)
		</th>
		<th>Impuesto al Consumo de las Bolsas de Plástico.
			<br> (COLUMNA 23)
		</th>
		<th>Otros conceptos, tributos y cargos que no forman parte de la base imponible
			<br> (COLUMNA 24)
		</th>
		<th>Importe total del comprobante de pago
			<br> (COLUMNA 25)
		</th>

		<th>Código de la Moneda (Tabla 4)
			<br> (COLUMNA 26)
		</th>
		<th>Tipo de cambio (5)
			<br> (COLUMNA 27)
		</th>
		<th>Fecha de emisión del comprobante de pago o documento original que se modifica (6) o documento referencial al documento que sustenta el crédito fiscal
			<br> (COLUMNA 28)
		</th>
		<th>Tipo del comprobante de pago que se modifica (6)
			<br> (COLUMNA 29)
		</th>
		<th>Número de serie del comprobante de pago que se modifica (6) o Código de la Dependencia Aduanera
			<br> (COLUMNA 30)
		</th>

		<th>Número del comprobante de pago que se modifica (6) o Número de la DUA, de corresponder
			<br> (COLUMNA 31)
		</th>
		<th>Identificación del Contrato o del proyecto en el caso de los Operadores de las sociedades irregulares, consorcios, joint ventures u otras formas de contratos de colaboración empresarial, que no lleven contabilidad independiente.
			<br> (COLUMNA 32)
		</th>
		<th>Error tipo 1: inconsistencia en el tipo de cambio
			<br> (COLUMNA 33)
		</th>
		<th>Indicador de Comprobantes de pago cancelados con medios de pago
			<br> (COLUMNA 34)
		</th>
		<th>Estado que identifica la oportunidad de la anotación o indicación si ésta corresponde a alguna de las situaciones previstas en el inciso e) del artículo 8° de la Resolución de Superintendencia N.° 286-2009/SUNAT
			<br> (COLUMNA 35)
		</th>

		<th>Campos de libre utilización.
			<br> (COLUMNA 36)
		</th>
	</tr>



	<?php

	$NoTieneTipoCambio = false;

	$libro = "";

	$c = 1;

	$FacturaSubTotal = 0;
	$FacturaImpuesto = 0;
	$FacturaTotal = 0;

	$FacturaAmortizadoTotal = 0;
	$FacturaSaldoTotal = 0;

	$TotalCredito30 = 0;
	$TotalCredito30Mas = 0;
	$TotalContado = 0;
	$TotalFacturaNoCancelada = 0;

	foreach ($ArrFacturas as $DatFactura) {

		$DatFactura->FacSubTotal = ($DatFactura->FacSubTotal / (empty($DatFactura->FacTipoCambio) ? 1 : $DatFactura->FacTipoCambio));
		$DatFactura->FacImpuesto = ($DatFactura->FacImpuesto / (empty($DatFactura->FacTipoCambio) ? 1 : $DatFactura->FacTipoCambio));
		$DatFactura->FacTotal = ($DatFactura->FacTotal / (empty($DatFactura->FacTipoCambio) ? 1 : $DatFactura->FacTipoCambio));

		$DatFactura->FacTotalDescuento = ($DatFactura->FacTotalDescuento / (empty($DatFactura->FacTipoCambio) ? 1 : $DatFactura->FacTipoCambio));
		$DatFactura->FacTotalPagar = ($DatFactura->FacTotalPagar / (empty($DatFactura->FacTipoCambio) ? 1 : $DatFactura->FacTipoCambio));
		$DatFactura->FacTotalExonerado = ($DatFactura->FacTotalExonerado / (empty($DatFactura->FacTipoCambio) ? 1 : $DatFactura->FacTipoCambio));

		$TipoCambio = 1;

		if ($DatFactura->MonId <> $EmpresaMonedaId) {

			$InsTipoCambio = new ClsTipoCambio();
			$InsTipoCambio->MonId = $DatFactura->MonId;
			$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatFactura->FacFechaEmision);
			$InsTipoCambio->MtdObtenerTipoCambioFecha();

			$TipoCambio = $InsTipoCambio->TcaMontoVenta;
		}

		if (!empty($DatFactura->FacTipoCambioAux)) {
			$TipoCambio = $DatFactura->FacTipoCambioAux;
		}

		//NUEVO TIPO DE CAMBIO
		$DatFactura->FacSubTotal = ($DatFactura->FacSubTotal * $TipoCambio);
		$DatFactura->FacImpuesto = ($DatFactura->FacImpuesto * $TipoCambio);
		$DatFactura->FacTotal = ($DatFactura->FacTotal * $TipoCambio);

		$DatFactura->FacTotalDescuento = ($DatFactura->FacTotalDescuento * $TipoCambio);
		$DatFactura->FacTotalPagar = ($DatFactura->FacTotalPagar * $TipoCambio);
		$DatFactura->FacTotalExonerado = ($DatFactura->FacTotalExonerado * $TipoCambio);

		$DatFactura->FacTipoCambio = $TipoCambio;

		if ($DatFactura->MonId <> $EmpresaMonedaId) {
			if (empty($TipoCambio)) {
				$NoTieneTipoCambio = true;
			}
		}

		if (empty($DatFactura->FacTipoCambio)) {
			$DatFactura->FacTipoCambio = "1.000";
		}

		if (empty($DatFactura->FacFechaVencimiento)) {
			$DatFactura->FacFechaVencimiento = "01/01/0001";
		}

		//FORMATEANDO
		$DatFactura->FacSubTotal = number_format($DatFactura->FacSubTotal, 2, '.', '');
		$DatFactura->FacImpuesto = number_format($DatFactura->FacImpuesto, 2, '.', '');
		$DatFactura->FacTotal = number_format($DatFactura->FacTotal, 2, '.', '');

		$DatFactura->FacTotalDescuento = number_format($DatFactura->FacTotalDescuento, 2, '.', '');
		$DatFactura->FacTotalPagar = number_format($DatFactura->FacTotalPagar, 2, '.', '');
		$DatFactura->FacTotalExonerado = number_format($DatFactura->FacTotalExonerado, 2, '.', '');

		$Cliente = $DatFactura->CliApellidoPaterno . " " . $DatFactura->CliApellidoMaterno . " " . $DatFactura->CliNombre;
		$Cliente = trim($Cliente);
		$Cliente = substr($Cliente, 0, 100);

		$DatFactura->FacId = $DatFactura->FacId + 1 - 1;
		$DatFactura->TdoCodigo = $DatFactura->TdoCodigo + 1 - 1;

	?>
		<tr>
			<td><?php echo $POST_Ano ?><?php echo $POST_Mes ?>00</td>
			<td>02</td>
			<td><?php echo "M" . $c ?></td>
			<td><?php echo $DatFactura->FacFechaEmision ?></td>
			<td><?php echo (($DatFactura->FacFechaVencimiento)) ?></td>

			<td>01</td>
			<td><?php echo $DatFactura->FtaNumero ?></td>
			<td><?php echo $DatFactura->FacId ?></td>
			<td></td>
			<td><?php echo $DatFactura->TdoCodigo ?></td>

			<td><?php echo $DatFactura->CliNumeroDocumento ?></td>
			<td><?php echo $Cliente ?></td>
			<td>0.00</td><!-- Valor facturado de la exportación -->
			<td><?php echo ($DatFactura->FacSubTotal) ?></td><!-- Base imponible de la operación gravada (4) -->
			<td><?php echo ($DatFactura->FacTotalDescuento) ?></td><!-- Descuento de la Base Imponible -->

			<td><?php echo ($DatFactura->FacImpuesto) ?></td><!-- Impuesto General a las Ventas y/o Impuesto de Promoción Municipal -->
			<td>0.00</td><!-- Descuento del Impuesto General a las Ventas y/o Impuesto de Promoción Municipal -->
			<td><?php echo ($DatFactura->FacTotalExonerado) ?></td><!-- Importe total de la operación exonerada -->
			<td>0.00</td><!-- Importe total de la operación inafecta -->
			<td>0.00</td><!-- Impuesto Selectivo al Consumo, de ser el caso -->

			<td>0.00</td><!-- Base imponible de la operación gravada con el Impuesto a las Ventas del Arroz Pilado -->
			<td>0.00</td><!-- Impuesto a las Ventas del Arroz Pilado -->
			<td>0.00</td><!-- Impuesto al Consumo de las Bolsas de Plástico -->
			<td>0.00</td><!-- Otros conceptos, tributos y cargos que no forman parte de la base imponible -->
			<td><?php echo $DatFactura->FacTotalPagar ?></td><!-- Importe total del comprobante de pago -->

			<td><?php echo $DatFactura->MonSigla ?></td><!-- Código  de la Moneda (Tabla 4) -->
			<td><?php echo $TipoCambio ?></td><!-- Tipo de cambio (5)	 -->
			<td>01/01/0001</td><!-- Fecha de emisión del comprobante de pago o documento original que se modifica (6) o documento referencial al documento que sustenta el crédito fiscal -->
			<td>00</td><!-- Tipo del comprobante de pago que se modifica (6)	-->
			<td>-</td><!-- Número de serie del comprobante de pago que se modifica (6) o Código de la Dependencia Aduanera -->

			<td>-</td><!-- Número del comprobante de pago que se modifica (6) o Número de la DUA, de corresponder -->
			<td></td><!-- Identificación del Contrato o del proyecto en el caso de los Operadores de las sociedades irregulares, consorcios, joint ventures u otras formas de contratos de colaboración empresarial, que no lleven contabilidad independiente. -->
			<td></td><!-- Error tipo 1: inconsistencia en el tipo de cambio -->
			<td>1</td><!-- Indicador de Comprobantes de pago cancelados con medios de pago -->
			<td>1</td><!-- Estado que identifica la oportunidad de la anotación o indicación si ésta corresponde a alguna de las situaciones previstas en el inciso e) del artículo 8° de la Resolución de Superintendencia N.° 286-2009/SUNAT -->

			<td></td><!-- Campos de libre utilización. -->
		</tr>

	<?php
		//$libro .= $POST_Ano . $POST_Mes . "00" . "|02|M" . $c . "|" . $DatFactura->FacFechaEmision . "|" . (($DatFactura->FacFechaVencimiento)) . "|01|" . $DatFactura->FtaNumero . "|" . $DatFactura->FacId . "|" . "|" . $DatFactura->TdoCodigo . "|" . $DatFactura->CliNumeroDocumento . "|" . $Cliente . "|0.00|" . ($DatFactura->FacSubTotal) . "|" . ($DatFactura->FacTotalDescuento) . "|" . ($DatFactura->FacImpuesto) . "|0.00|" . ($DatFactura->FacTotalExonerado) . "|0.00|0.00|0.00|0.00|0.00|" . $DatFactura->FacTotalPagar . "|" . $DatFactura->MonSigla . "|" . $TipoCambio . "|01/01/0001|00|-|-|||1|1|\n";

		$FacturaSubTotal += $DatFactura->FacSubTotal;
		$FacturaImpuesto += $DatFactura->FacImpuesto;
		$FacturaTotal += $DatFactura->FacTotal;


		$FacturaAmortizadoTotal += $ClientePagoMontoTotal;
		$FacturaSaldoTotal += $FacturaSaldo;

		$c++;
	}



	//$c=1;
	$BoletaSubTotal = 0;
	$BoletaImpuesto = 0;
	$BoletaTotal = 0;

	$BoletaAmortizadoTotal = 0;
	$BoletaSaldoTotal = 0;

	$TotalCredito30 = 0;
	$TotalCredito30Mas = 0;
	$TotalContado = 0;
	$TotalBoletaNoCancelada = 0;

	foreach ($ArrBoletas as $DatBoleta) {

		$DatBoleta->BolSubTotal = ($DatBoleta->BolSubTotal / (empty($DatBoleta->BolTipoCambio) ? 1 : $DatBoleta->BolTipoCambio));
		$DatBoleta->BolImpuesto = ($DatBoleta->BolImpuesto / (empty($DatBoleta->BolTipoCambio) ? 1 : $DatBoleta->BolTipoCambio));
		$DatBoleta->BolTotal = ($DatBoleta->BolTotal / (empty($DatBoleta->BolTipoCambio) ? 1 : $DatBoleta->BolTipoCambio));

		$DatBoleta->BolTotalDescuento = ($DatBoleta->BolTotalDescuento / (empty($DatBoleta->BolTipoCambio) ? 1 : $DatBoleta->BolTipoCambio));
		$DatBoleta->BolTotalPagar = ($DatBoleta->BolTotalPagar / (empty($DatBoleta->BolTipoCambio) ? 1 : $DatBoleta->BolTipoCambio));
		$DatBoleta->BolTotalExonerado = ($DatBoleta->BolTotalExonerado / (empty($DatBoleta->BolTipoCambio) ? 1 : $DatBoleta->BolTipoCambio));

		$TipoCambio = 1;

		if ($DatBoleta->MonId <> $EmpresaMonedaId) {
			$InsTipoCambio = new ClsTipoCambio();
			$InsTipoCambio->MonId = $DatBoleta->MonId;
			$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatBoleta->BolFechaEmision);
			$InsTipoCambio->MtdObtenerTipoCambioFecha();
			$TipoCambio = $InsTipoCambio->TcaMontoVenta;
		}

		if (!empty($DatBoleta->BolTipoCambioAux)) {
			$TipoCambio = $DatBoleta->BolTipoCambioAux;
		}

		//NUEVO TIPO DE CAMBIO
		$DatBoleta->BolSubTotal = ($DatBoleta->BolSubTotal * $TipoCambio);
		$DatBoleta->BolImpuesto = ($DatBoleta->BolImpuesto * $TipoCambio);
		$DatBoleta->BolTotal = ($DatBoleta->BolTotal * $TipoCambio);

		$DatBoleta->BolTotalDescuento = ($DatBoleta->BolTotalDescuento * $TipoCambio);
		$DatBoleta->BolTotalPagar = ($DatBoleta->BolTotalPagar * $TipoCambio);
		$DatBoleta->BolTotalExonerado = ($DatBoleta->BolTotalExonerado * $TipoCambio);

		$DatBoleta->BolTipoCambio = $TipoCambio;

		if ($DatBoleta->MonId <> $EmpresaMonedaId) {
			if (empty($TipoCambio)) {
				$NoTieneTipoCambio = true;
			}
		}

		if (empty($DatBoleta->BolTipoCambio)) {
			$DatBoleta->BolTipoCambio = "1.000";
		}

		if (empty($DatBoleta->BolFechaVencimiento)) {
			$DatBoleta->BolFechaVencimiento = "01/01/0001";
		}

		$DatBoleta->BolSubTotal = number_format($DatBoleta->BolSubTotal, 2, '.', '');
		$DatBoleta->BolImpuesto = number_format($DatBoleta->BolImpuesto, 2, '.', '');
		$DatBoleta->BolTotal = number_format($DatBoleta->BolTotal, 2, '.', '');

		$DatBoleta->BolTotalDescuento = number_format($DatBoleta->BolTotalDescuento, 2, '.', '');
		$DatBoleta->BolTotalPagar = number_format($DatBoleta->BolTotalPagar, 2, '.', '');
		$DatBoleta->BolTotalExonerado = number_format($DatBoleta->BolTotalExonerado, 2, '.', '');

		$Cliente = $DatBoleta->CliApellidoPaterno . " " . $DatBoleta->CliApellidoMaterno . " " . $DatBoleta->CliNombre;
		$Cliente = trim($Cliente);
		$Cliente = substr($Cliente, 0, 100);

		$DatBoleta->BolId = $DatBoleta->BolId + 1 - 1;
		$DatBoleta->TdoCodigo = $DatBoleta->TdoCodigo + 1 - 1;

	?>
		<tr>
			<td><?php echo $POST_Ano ?><?php echo $POST_Mes ?>00</td> <!-- Periodo -->
			<td>02</td> <!-- 1. Contribuyentes del Régimen General: Número correlativo del mes o Código Único de la Operación (CUO), que es la llave única o clave única o clave primaria del software contable que identifica de manera unívoca el asiento contable en el Libro Diario o del Libro Diario de Formato Simplificado en que se registró la operación.
2. Contribuyentes del Régimen Especial de Renta - RER:  Número correlativo del mes -->
			<td><?php echo "M" . $c ?></td><!-- Número correlativo del asiento contable identificado en el campo 2, cuando se utilice el Código Único de la Operación (CUO). El primer dígito debe ser: "A" para el asiento de apertura del ejercicio, "M" para los asientos de movimientos o ajustes del mes o "C" para el asiento de cierre del ejercicio.-->
			<td><?php echo $DatBoleta->BolFechaEmision ?></td><!-- Fecha de emisión del Comprobante de Pago -->
			<td><?php echo (($DatBoleta->BolFechaVencimiento)) ?></td><!-- Fecha de Vencimiento o Fecha de Pago (1) -->

			<td>03</td> <!-- Tipo de Comprobante de Pago -->
			<td><?php echo $DatBoleta->BtaNumero ?></td> <!-- Número serie del comprobante de pago o documento o número de serie de la maquina registradora -->
			<td><?php echo $DatBoleta->BolId ?></td> <!-- Número del comprobante de pago o documento.-->
			<td></td>
			<td><?php echo $DatBoleta->TdoCodigo ?></td>

			<td><?php echo $DatBoleta->CliNumeroDocumento ?></td><!-- Número de Documento de Identidad del cliente -->
			<td><?php echo $Cliente ?></td><!-- Apellidos y nombres, denominación o razón social  del cliente. En caso de personas naturales se debe consignar los datos en el siguiente orden: Apellido paterno, apellido materno y nombre completo. -->
			<td>0.00</td><!-- Valor facturado de la exportación  -->
			<td><?php echo ($DatBoleta->BolSubTotal) ?></td><!-- Base imponible de la operación gravada (4) -->
			<td><?php echo ($DatBoleta->BolTotalDescuento) ?></td><!-- Descuento de la Base Imponible-->

			<td><?php echo ($DatBoleta->BolImpuesto) ?></td><!-- Impuesto General a las Ventas y/o Impuesto de Promoción Municipal -->
			<td>0.00</td><!-- Descuento del Impuesto General a las Ventas y/o Impuesto de Promoción Municipal -->
			<td><?php echo ($DatBoleta->BolTotalExonerado) ?></td><!-- Importe total de la operación exonerada -->
			<td>0.00</td><!-- Importe total de la operación inafecta -->
			<td>0.00</td><!-- Impuesto Selectivo al Consumo, de ser el caso. -->

			<td>0.00</td><!-- Indicador de Comprobantes de pago cancelados con medios de pago -->
			<td>0.00</td><!-- Impuesto a las Ventas del Arroz Pilado  -->
			<td>0.00</td><!-- Impuesto al Consumo de las Bolsas de Plástico. -->
			<td>0.00</td><!-- Otros conceptos, tributos y cargos que no forman parte de la base imponible. -->
			<td><?php echo $DatBoleta->BolTotalPagar ?></td>

			<td><?php echo $DatBoleta->MonSigla ?></td><!-- Código  de la Moneda (Tabla 4) -->
			<td><?php echo $DatBoleta->BolTipoCambio ?></td><!-- Tipo de cambio (5)	 -->
			<td>01/01/0001</td><!-- Fecha de emisión del comprobante de pago o documento original que se modifica (6) o documento referencial al documento que sustenta el crédito fiscal -->
			<td>00</td><!-- Tipo del comprobante de pago que se modifica (6)	-->
			<td>-</td><!-- Número de serie del comprobante de pago que se modifica (6) o Código de la Dependencia Aduanera -->

			<td>-</td><!-- Número del comprobante de pago que se modifica (6) o Número de la DUA, de corresponder -->
			<td></td><!-- Identificación del Contrato o del proyecto en el caso de los Operadores de las sociedades irregulares, consorcios, joint ventures u otras formas de contratos de colaboración empresarial, que no lleven contabilidad independiente. -->
			<td> </td><!-- Error tipo 1: inconsistencia en el tipo de cambio -->
			<td>1</td><!-- Indicador de Comprobantes de pago cancelados con medios de pago -->
			<td>1</td> <!-- Estado que identifica la oportunidad de la anotación o indicación si ésta corresponde a alguna de las situaciones previstas en el inciso e) del artículo 8° de la Resolución de Superintendencia N.° 286-2009/SUNAT -->

			<td></td><!-- Campos de libre utilización. -->
		</tr>
	<?php
		//$libro .= $POST_Ano . $POST_Mes . "00" . "|02|M" . $c . "|" . $DatBoleta->BolFechaEmision . "|" . (($DatBoleta->BolFechaVencimiento)) . "|03|" . $DatBoleta->BtaNumero . "|" . $DatBoleta->BolId . "|" . "|" . $DatBoleta->TdoCodigo . "|" . $DatBoleta->CliNumeroDocumento . "|" . $Cliente . "|0.00|" . ($DatBoleta->BolSubTotal) . "|" . ($DatBoleta->BolTotalDescuento) . "|" . ($DatBoleta->BolImpuesto) . "|0.00|" . ($DatBoleta->BolTotalExonerado) . "|0.00|0.00|0.00|0.00|0.00|" . $DatBoleta->BolTotalPagar . "|" . $DatBoleta->MonSigla . "|" . $DatBoleta->BolTipoCambio . "|01/01/0001|00|-|-|||1|1|\n";

		$BoletaSubTotal += $DatBoleta->BolSubTotal;
		$BoletaImpuesto += $DatBoleta->BolImpuesto;
		$BoletaTotal += $DatBoleta->BolTotal;

		$BoletaAmortizadoTotal += $ClientePagoMontoTotal;
		$BoletaSaldoTotal += $BoletaSaldo;

		$c++;
	}



	//$c=1;
	$NotaCreditoSubTotal = 0;
	$NotaCreditoImpuesto = 0;
	$NotaCreditoTotal = 0;

	$NotaCreditoAmortizadoTotal = 0;
	$NotaCreditoSaldoTotal = 0;

	$TotalCredito30 = 0;
	$TotalCredito30Mas = 0;
	$TotalContado = 0;
	$TotalNotaCreditoNoCancelada = 0;

	foreach ($ArrNotaCreditos as $DatNotaCredito) {

		$DatNotaCredito->NcrSubTotal = ($DatNotaCredito->NcrSubTotal / (empty($DatNotaCredito->NcrTipoCambio) ? 1 : $DatNotaCredito->NcrTipoCambio));
		$DatNotaCredito->NcrImpuesto = ($DatNotaCredito->NcrImpuesto / (empty($DatNotaCredito->NcrTipoCambio) ? 1 : $DatNotaCredito->NcrTipoCambio));
		$DatNotaCredito->NcrTotal = ($DatNotaCredito->NcrTotal / (empty($DatNotaCredito->NcrTipoCambio) ? 1 : $DatNotaCredito->NcrTipoCambio));

		$DatNotaCredito->NcrTotalDescuento = ($DatNotaCredito->NcrTotalDescuento / (empty($DatNotaCredito->NcrTipoCambio) ? 1 : $DatNotaCredito->NcrTipoCambio));
		$DatNotaCredito->NcrTotalPagar = ($DatNotaCredito->NcrTotalPagar / (empty($DatNotaCredito->NcrTipoCambio) ? 1 : $DatNotaCredito->NcrTipoCambio));
		$DatNotaCredito->NcrTotalExonerado = ($DatNotaCredito->NcrTotalExonerado / (empty($DatNotaCredito->NcrTipoCambio) ? 1 : $DatNotaCredito->NcrTipoCambio));


		$TipoCambio = 1;

		if ($DatNotaCredito->MonId <> $EmpresaMonedaId) {
			$InsTipoCambio = new ClsTipoCambio();
			$InsTipoCambio->MonId = $DatNotaCredito->MonId;
			//$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaCredito->NcrFechaEmision);
			$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaCredito->DocFechaEmision);
			$InsTipoCambio->MtdObtenerTipoCambioFecha();
			$TipoCambio = $InsTipoCambio->TcaMontoVenta;
		}

		if (!empty($DatNotaCredito->NcrTipoCambioAux)) {
			$TipoCambio = $DatNotaCredito->NcrTipoCambioAux;
		}

		//NUEVO TIPO DE CAMBIO
		$DatNotaCredito->NcrSubTotal = ($DatNotaCredito->NcrSubTotal * $TipoCambio);
		$DatNotaCredito->NcrImpuesto = ($DatNotaCredito->NcrImpuesto * $TipoCambio);
		$DatNotaCredito->NcrTotal = ($DatNotaCredito->NcrTotal * $TipoCambio);

		$DatNotaCredito->NcrTotalDescuento = ($DatNotaCredito->NcrTotalDescuento * $TipoCambio);
		$DatNotaCredito->NcrTotalPagar = ($DatNotaCredito->NcrTotalPagar * $TipoCambio);
		$DatNotaCredito->NcrTotalExonerado = ($DatNotaCredito->NcrTotalExonerado * $TipoCambio);


		$DatNotaCredito->NcrTipoCambio = $TipoCambio;

		if ($DatNotaCredito->MonId <> $EmpresaMonedaId) {
			if (empty($TipoCambio)) {
				$NoTieneTipoCambio = true;
			}
		}

		if (empty($DatNotaCredito->NcrTipoCambio)) {
			$DatNotaCredito->NcrTipoCambio = "1.000";
		}

		if (empty($DatNotaCredito->NcrFechaVencimiento)) {
			$DatNotaCredito->NcrFechaVencimiento = "01/01/0001";
		}


		//NOTA DE CREDITO ES NEGATIVO
		$DatNotaCredito->NcrTotal = ($DatNotaCredito->NcrTotal * -1);
		$DatNotaCredito->NcrSubTotal = ($DatNotaCredito->NcrSubTotal * -1);
		$DatNotaCredito->NcrImpuesto = ($DatNotaCredito->NcrImpuesto * -1);

		$DatNotaCredito->NcrTotalDescuento = ($DatNotaCredito->NcrTotalDescuento * -1);
		$DatNotaCredito->NcrTotalPagar = ($DatNotaCredito->NcrTotalPagar * -1);
		$DatNotaCredito->NcrTotalExonerado = ($DatNotaCredito->NcrTotalExonerado * -1);

		//FORMATEANDO
		$DatNotaCredito->NcrTotal = number_format($DatNotaCredito->NcrTotal, 2, '.', '');
		$DatNotaCredito->NcrSubTotal = number_format($DatNotaCredito->NcrSubTotal, 2, '.', '');
		$DatNotaCredito->NcrImpuesto = number_format($DatNotaCredito->NcrImpuesto, 2, '.', '');

		$DatNotaCredito->NcrTotalDescuento = number_format($DatNotaCredito->NcrTotalDescuento, 2, '.', '');
		$DatNotaCredito->NcrTotalPagar = number_format($DatNotaCredito->NcrTotalPagar, 2, '.', '');
		$DatNotaCredito->NcrTotalExonerado = number_format($DatNotaCredito->NcrTotalExonerado, 2, '.', '');


		$Cliente = $DatNotaCredito->CliApellidoPaterno . " " . $DatNotaCredito->CliApellidoMaterno . " " . $DatNotaCredito->CliNombre;
		$Cliente = trim($Cliente);
		$Cliente = substr($Cliente, 0, 100);

		$DatNotaCredito->NcrId = $DatNotaCredito->NcrId + 1 - 1;
		$DatNotaCredito->TdoCodigo = $DatNotaCredito->TdoCodigo + 1 - 1;

	?>

		<tr>
			<td><?php echo $POST_Ano ?><?php echo $POST_Mes ?> 00</td>
			<td>02</td>
			<td><?php echo "M" . $c ?></td>
			<td><?php echo $DatNotaCredito->NcrFechaEmision ?></td>
			<td><?php echo $DatNotaCredito->NcrFechaVencimiento ?></td>

			<td>07</td>
			<td><?php echo $DatNotaCredito->NctNumero ?></td>
			<td><?php echo $DatNotaCredito->NcrId ?></td>
			<td></td>
			<td><?php echo $DatNotaCredito->TdoCodigo ?></td>

			<td><?php echo $DatNotaCredito->CliNumeroDocumento ?></td>
			<td><?php echo $Cliente ?></td>
			<td>0.00</td>
			<td><?php echo ($DatNotaCredito->NcrSubTotal) ?></td>
			<td><?php echo ($DatNotaCredito->NcrTotalDescuento) ?></td>

			<td><?php echo ($DatNotaCredito->NcrImpuesto) ?></td>
			<td>0.00</td>
			<td><?php echo ($DatNotaCredito->NcrTotalExonerado) ?></td>
			<td>0.00</td>
			<td>0.00</td>

			<td>0.00</td>
			<td>0.00</td>
			<td>0.00</td>
			<td>0.00</td>
			<td><?php echo $DatNotaCredito->NcrTotalPagar ?></td> <!-- Total a pagar -->

			<td><?php echo $DatNotaCredito->MonSigla ?></td> <!-- Código  de la Moneda (Tabla 4) -->
			<td><?php echo $DatNotaCredito->NcrTipoCambio ?></td> <!-- Tipo de cambio aplicado -->
			<td><?php echo $DatNotaCredito->DocFechaEmision ?></td> <!-- Fecha de emisión del comprobante de pago o documento original que se modifica (6) o documento referencial al documento que sustenta el crédito fiscal -->
			<td><?php echo $DatNotaCredito->DocTipoDocumentoCodigo ?></td> <!-- Tipo del comprobante de pago que se modifica (6)	-->
			<td><?php echo $DatNotaCredito->DtaNumero ?></td> <!-- Número de serie del comprobante de pago que se modifica (6) o Código de la Dependencia Aduanera -->

			<td><?php echo $DatNotaCredito->DocId ?></td><!-- Número del comprobante de pago que se modifica (6) o Número de la DUA, de corresponder -->
			<td></td><!-- Identificación del Contrato o del proyecto en el caso de los Operadores de las sociedades irregulares, consorcios, joint ventures u otras formas de contratos de colaboración empresarial, que no lleven contabilidad independiente. -->
			<td></td><!-- Error tipo 1: inconsistencia en el tipo de cambio -->
			<td>1</td><!-- Indicador de Comprobantes de pago cancelados con medios de pago -->
			<td>1</td><!-- Estado que identifica la oportunidad de la anotación o indicación si ésta corresponde a alguna de las situaciones previstas en el inciso e) del artículo 8° de la Resolución de Superintendencia N.° 286-2009/SUNAT -->

			<td></td><!-- Campos de libre utilización. -->

		</tr>
	<?php
		//$libro .= $POST_Ano . $POST_Mes . "00" . "|02|M" . $c . "|" . $DatNotaCredito->NcrFechaEmision . "|" . $DatNotaCredito->NcrFechaVencimiento . "|07|" . $DatNotaCredito->NctNumero . "|" . $DatNotaCredito->NcrId . "|" . "|" . $DatNotaCredito->TdoCodigo . "|" . $DatNotaCredito->CliNumeroDocumento . "|" . $Cliente . "|0.00|" . ($DatNotaCredito->NcrSubTotal) . "|" . ($DatNotaCredito->NcrTotalDescuento) . "|" . ($DatNotaCredito->NcrImpuesto) . "|0.00|" . ($DatNotaCredito->NcrTotalExonerado) . "|0.00|0.00|0.00|0.00|0.00|" . $DatNotaCredito->NcrTotalPagar . "|" . $DatNotaCredito->MonSigla . "|" . $DatNotaCredito->NcrTipoCambio . "|" . $DatNotaCredito->DocFechaEmision . "|" . $DatNotaCredito->DocTipoDocumentoCodigo . "|" . $DatNotaCredito->DtaNumero . "|" . $DatNotaCredito->DocId . "|||1|1|\n";

		$NotaCreditoSubTotal += $DatNotaCredito->NcrSubTotal;
		$NotaCreditoImpuesto += $DatNotaCredito->NcrImpuesto;
		$NotaCreditoTotal += $DatNotaCredito->NcrTotal;

		$NotaCreditoAmortizadoTotal += $ClientePagoMontoTotal;
		$NotaCreditoSaldoTotal += $NotaCreditoSaldo;

		$c++;
	}


	//$c=1;
	$NotaDebitoSubTotal = 0;
	$NotaDebitoImpuesto = 0;
	$NotaDebitoTotal = 0;

	$NotaDebitoAmortizadoTotal = 0;
	$NotaDebitoSaldoTotal = 0;

	$TotalCredito30 = 0;
	$TotalCredito30Mas = 0;
	$TotalContado = 0;
	$TotalNotaDebitoNoCancelada = 0;

	foreach ($ArrNotaDebitos as $DatNotaDebito) {

		$DatNotaDebito->NdbSubTotal = ($DatNotaDebito->NdbSubTotal / (empty($DatNotaDebito->NdbTipoCambio) ? 1 : $DatNotaDebito->NdbTipoCambio));
		$DatNotaDebito->NdbImpuesto = ($DatNotaDebito->NdbImpuesto / (empty($DatNotaDebito->NdbTipoCambio) ? 1 : $DatNotaDebito->NdbTipoCambio));
		$DatNotaDebito->NdbTotal = ($DatNotaDebito->NdbTotal / (empty($DatNotaDebito->NdbTipoCambio) ? 1 : $DatNotaDebito->NdbTipoCambio));

		$DatNotaDebito->NdbTotalDescuento = ($DatNotaDebito->NdbTotalDescuento / (empty($DatNotaDebito->NdbTipoCambio) ? 1 : $DatNotaDebito->NdbTipoCambio));
		$DatNotaDebito->NdbTotalPagar = ($DatNotaDebito->NdbTotalPagar / (empty($DatNotaDebito->NdbTipoCambio) ? 1 : $DatNotaDebito->NdbTipoCambio));
		$DatNotaDebito->NdbTotalExonerado = ($DatNotaDebito->NdbTotalExonerado / (empty($DatNotaDebito->NdbTipoCambio) ? 1 : $DatNotaDebito->NdbTipoCambio));


		$TipoCambio = 1;

		if ($DatNotaDebito->MonId <> $EmpresaMonedaId) {
			$InsTipoCambio = new ClsTipoCambio();
			$InsTipoCambio->MonId = $DatNotaDebito->MonId;
			//$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaDebito->NdbFechaEmision);
			$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaDebito->DocFechaEmision);
			$InsTipoCambio->MtdObtenerTipoCambioFecha();
			$TipoCambio = $InsTipoCambio->TcaMontoVenta;
		}

		if (!empty($DatNotaDebito->NdbTipoCambioAux)) {
			$TipoCambio = $DatNotaDebito->NdbTipoCambioAux;
		}


		//NUEVO TIPO DE CAMBIO
		$DatNotaDebito->NdbSubTotal = ($DatNotaDebito->NdbSubTotal * $TipoCambio);
		$DatNotaDebito->NdbImpuesto = ($DatNotaDebito->NdbImpuesto * $TipoCambio);
		$DatNotaDebito->NdbTotal = ($DatNotaDebito->NdbTotal * $TipoCambio);

		$DatNotaDebito->NdbTotalDescuento = ($DatNotaDebito->NdbTotalDescuento * $TipoCambio);
		$DatNotaDebito->NdbTotalPagar = ($DatNotaDebito->NdbTotalPagar * $TipoCambio);
		$DatNotaDebito->NdbTotalExonerado = ($DatNotaDebito->NdbTotalExonerado * $TipoCambio);

		$DatNotaDebito->NdbTipoCambio = $TipoCambio;

		if ($DatNotaDebito->MonId <> $EmpresaMonedaId) {
			if (empty($TipoCambio)) {
				$NoTieneTipoCambio = true;
			}
		}

		if (empty($DatNotaDebito->NdbTipoCambio)) {
			$DatNotaDebito->NdbTipoCambio = "1.000";
		}

		if (empty($DatNotaDebito->NdbFechaVencimiento)) {
			$DatNotaDebito->NdbFechaVencimiento = "01/01/0001";
		}

		//FORMATEANDO
		$DatNotaDebito->NdbTotal = number_format($DatNotaDebito->NdbTotal, 2, '.', '');
		$DatNotaDebito->NdbSubTotal = number_format($DatNotaDebito->NdbSubTotal, 2, '.', '');
		$DatNotaDebito->NdbImpuesto = number_format($DatNotaDebito->NdbImpuesto, 2, '.', '');

		$DatNotaDebito->NdbTotalDescuento = number_format($DatNotaDebito->NdbTotalDescuento, 2, '.', '');
		$DatNotaDebito->NdbTotalPagar = number_format($DatNotaDebito->NdbTotalPagar, 2, '.', '');
		$DatNotaDebito->NdbTotalExonerado = number_format($DatNotaDebito->NdbTotalExonerado, 2, '.', '');


		$Cliente = $DatNotaDebito->CliApellidoPaterno . " " . $DatNotaDebito->CliApellidoMaterno . " " . $DatNotaDebito->CliNombre;
		$Cliente = trim($Cliente);
		$Cliente = substr($Cliente, 0, 100);

		$DatNotaDebito->NdbId = $DatNotaDebito->NdbId + 1 - 1;
		$DatNotaDebito->TdoCodigo = $DatNotaDebito->TdoCodigo + 1 - 1;



	?>

		<tr>
			<td><?php echo $POST_Ano ?><?php echo $POST_Mes ?>00</td>
			<td>02</td>
			<td><?php echo "M" . $c ?></td>
			<td><?php echo $DatNotaDebito->NdbFechaEmision ?></td>
			<td><?php echo $DatNotaDebito->NdbFechaVencimiento ?></td>

			<td>08</td>
			<td><?php echo $DatNotaDebito->NctNumero ?></td>
			<td><?php echo $DatNotaDebito->NdbId ?></td>
			<td></td>
			<td><?php echo $DatNotaDebito->TdoCodigo ?></td>

			<td><?php echo $DatNotaDebito->CliNumeroDocumento ?></td><!-- Número de Documento de Identidad del cliente -->
			<td><?php echo $Cliente ?></td><!-- Apellidos y nombres, denominación o razón social  del cliente. En caso de personas naturales se debe consignar los datos en el siguiente orden: Apellido paterno, apellido materno y nombre completo. -->
			<td>0.00</td><!-- Valor facturado de la exportación  -->
			<td><?php echo ($DatNotaDebito->NdbSubTotal) ?></td><!-- Base imponible de la operación gravada (4) -->
			<td><?php echo ($DatNotaDebito->NdbTotalDescuento) ?></td><!-- Descuento de la Base Imponible -->

			<td><?php echo ($DatNotaDebito->NdbImpuesto) ?></td><!-- Impuesto General a las Ventas y/o Impuesto de Promoción Municipal -->
			<td>0.00</td><!-- Descuento del Impuesto General a las Ventas y/o Impuesto de Promoción Municipal -->
			<td><?php echo ($DatNotaDebito->NdbTotalExonerado) ?></td><!-- Importe total de la operación exonerada -->
			<td>0.00</td><!-- Importe total de la operación inafecta  -->
			<td>0.00</td><!-- Impuesto Selectivo al Consumo, de ser el caso. -->

			<td>0.00</td> <!-- Indicador de Comprobantes de pago cancelados con medios de pago. -->
			<td>0.00</td> <!-- Impuesto a las Ventas del Arroz Pilado. -->
			<td>0.00</td> <!-- Impuesto al Consumo de las Bolsas de Plástico. -->
			<td>0.00</td> <!-- Otros conceptos, tributos y cargos que no forman parte de la base imponible -->
			<td><?php echo $DatNotaDebito->NdbTotalPagar ?></td> <!-- Importe total del comprobante de pago -->

			<td><?php echo $DatNotaDebito->MonSigla ?></td> <!-- Código  de la Moneda (Tabla 4) -->
			<td><?php echo $DatNotaDebito->NdbTipoCambio ?></td> <!-- Tipo de cambio aplicado -->
			<td><?php echo $DatNotaDebito->DocFechaEmision ?></td> <!-- Fecha de emisión del comprobante de pago o documento original que se modifica (6) o documento referencial al documento que sustenta el crédito fiscal -->
			<td><?php echo $DatNotaDebito->DocTipoDocumentoCodigo ?></td> <!-- Tipo del comprobante de pago que se modifica (6)	-->
			<td><?php echo $DatNotaDebito->DtaNumero ?></td> <!-- Número de serie del comprobante de pago que se modifica (6) o Código de la Dependencia Aduanera -->

			<td><?php echo $DatNotaDebito->DocId ?></td> <!-- Número del comprobante de pago que se modifica (6) o Número de la DUA, de corresponder -->
			<td></td> <!-- Identificación del Contrato o del proyecto en el caso de los Operadores de las sociedades irregulares, consorcios, joint ventures u otras formas de contratos de colaboración empresarial, que no lleven contabilidad independiente. -->
			<td></td> <!-- Error tipo 1: inconsistencia en el tipo de cambio -->
			<td>1</td> <!-- Indicador de Comprobantes de pago cancelados con medios de pago -->
			<td>1</td> <!-- Estado que identifica la oportunidad de la anotación o indicación si ésta corresponde a alguna de las situaciones previstas en el inciso e) del artículo 8° de la Resolución de Superintendencia N.° 286-2009/SUNAT -->

			<td></td><!-- Campos de libre utilización. -->
		</tr>

	<?php

		//$libro .= $POST_Ano . $POST_Mes . "00" . "|02|M" . $c . "|" . $DatNotaDebito->NdbFechaEmision . "|" . $DatNotaDebito->NdbFechaVencimiento . "|08|" . $DatNotaDebito->NctNumero . "|" . $DatNotaDebito->NdbId . "|" . "|" . $DatNotaDebito->TdoCodigo . "|" . $DatNotaDebito->CliNumeroDocumento . "|" . $Cliente . "|0.00|" . ($DatNotaDebito->NdbSubTotal) . "|" . ($DatNotaDebito->NdbTotalDescuento) . "|" . ($DatNotaDebito->NdbImpuesto) . "|0.00|" . ($DatNotaDebito->NdbTotalExonerado) . "|0.00|0.00|0.00|0.00|0.00|" . $DatNotaDebito->NdbTotalPagar . "|" . $DatNotaDebito->MonSigla . "|" . $DatNotaDebito->NdbTipoCambio . "|" . $DatNotaDebito->DocFechaEmision . "|" . $DatNotaDebito->DocTipoDocumentoCodigo . "|" . $DatNotaDebito->DtaNumero . "|" . $DatNotaDebito->DocId . "|||1|1|\n";
		$NotaDebitoSubTotal += $DatNotaDebito->NdbSubTotal;
		$NotaDebitoImpuesto += $DatNotaDebito->NdbImpuesto;
		$NotaDebitoTotal += $DatNotaDebito->NdbTotal;

		$NotaDebitoAmortizadoTotal += $ClientePagoMontoTotal;
		$NotaDebitoSaldoTotal += $NotaDebitoSaldo;

		$c++;
	}

	?>
</table>

<?php

if ($NoTieneTipoCambio) {
	$libro = "Una de las filas no tiene tipo de cambio";
}

$NombreArchivo = "LE" . $EmpresaCodigo . $POST_Ano . $POST_Mes . "00" . "140100" . "00" . "1" . "1" . "1" . "1" . ".txt";
?>

<h3>Nombre del Archivo:</h3>

<?php
echo  $NombreArchivo;
