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

$POST_Sucursal = "";

$POST_Ano = ($_GET['Ano']);
$POST_Mes = ($_GET['Mes']);

$POST_FechaInicio = "01/" . $POST_Mes . "/" . $POST_Ano;
$POST_FechaFin = FncCantidadDiaMes($POST_Ano, $POST_Mes) . "/" . $POST_Mes . "/" . $POST_Ano;
$FechaInventarioInicio = "01/01/" . $POST_Ano;

require_once($InsPoo->MtdPaqContabilidad() . 'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica() . 'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsNotaDebito.php');

require_once($InsPoo->MtdPaqAlmacen() . 'ClsKardexVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsVehiculo.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsMoneda.php');


$InsPago = new ClsPago($InsMysql);
$InsFactura = new ClsFactura($InsMysql);
$InsMoneda = new ClsMoneda($InsMysql);
$InsCliente = new ClsCliente($InsMysql);
$InsNotaCredito = new ClsNotaCredito($InsMysql);
$InsBoleta = new ClsBoleta($InsMysql);
$InsNotaDebito = new ClsNotaDebito($InsMysql);
$InsKardexVehiculo = new ClsKardexVehiculo($InsMysql);
$InsVehiculo = new ClsVehiculo($InsMysql);

require_once($InsPoo->MtdPaqAlmacen() . 'ClsKardex.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsProducto.php');
require_once($InsPoo->MtdPaqEmpresa() . 'ClsSucursal.php');

$InsKardex = new ClsKardex($InsMysql);
$InsProducto = new ClsProducto($InsMysql);
$InsSucursal = new ClsSucursal($InsMysql);


$aux = explode("/", $POST_FechaInicio);
$KardexFechaInicio = "01/01/" . $aux[2];

$InsSucursal->SucId = $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();

$InventarioFechaInicio = (empty($InsSucursal->SucInventarioFechaInicio) ? $SistemaInventarioFecha : $InsSucursal->SucInventarioFechaInicio);

list($Dia, $Mes, $Ano) = explode("/", $POST_FechaInicio);

//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL, NULL, NULL, "ProNombre", "ASC", NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, true, NULL, NULL, 0, NULL, false, NULL, NULL, false);
$ArrProductos = $ResProducto['Datos'];

//MtdObtenerVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VehId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoTipo=NULL,$oEstado=NULL)
$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos(NULL, NULL, NULL, "VehCodigoIdentificador", "ASC", NULL, NULL, NULL, NULL, NULL, 1);
$ArrVehiculos = $ResVehiculo['Datos'];

$libro = "";
?>


<table width="100%" border="1" cellspacing="0" cellpadding="2">
	<tr>
		<th>#
		</th>

		<th>Periodo
			<br> (COLUMNA 1) 1
		</th>
		<th>Código Único de la Operación (CUO), que es la llave única o clave única o clave primaria del software contable que identifica de manera unívoca el asiento contable en el Libro Diario en que se registró la operación.
			<br> (COLUMNA 2)
		</th>
		<th>Número correlativo del asiento contable identificado en el campo 2.
			El primer dígito debe ser: "A" para el asiento de apertura del ejercicio, "M" para los asientos de movimientos o ajustes del mes o "C" para el
			asiento de cierre del ejercicio.
			<br> (COLUMNA 3)
		</th>
		<th>Código de establecimiento anexo:
			<br> (COLUMNA 4)
		</th>
		<th>Código del catálogo utilizado.
			<br> (COLUMNA 5)
		</th>

		<th>Tipo de existencia
			<br> (COLUMNA 6)
		</th>
		<th>Código propio de la existencia correspondiente al catálogo señalado en el campo 5.
			<br> (COLUMNA 7)
		</th>
		<th>Código del catálogo utilizado.
			<br> (COLUMNA 8)
		</th>
		<th>Código de la existencia correspondiente al catálogo señalado en el campo 8.
			<br> (COLUMNA 9)
		</th>
		<th>Fecha de emisión del documento de traslado, comprobante de pago, documento interno o similar
			<br> (COLUMNA 10)
		</th>

		<th>Tipo del documento de traslado, comprobante de pago, documento interno o similar
			<br> (COLUMNA 11)
		</th>
		<th>Número de serie del documento de traslado, comprobante de pago, documento interno o
			similar
			<br> (COLUMNA 12)
		</th>
		<th>Número del documento de traslado,
			comprobante de pago, documento interno o similar
			<br> (COLUMNA 13)
		</th>
		<th>Tipo de operación efectuada
			<br> (COLUMNA 14)
		</th>
		<th>Descripción de la existencia
			<br> (COLUMNA 15)
		</th>

		<th>Código de la unidad de medida de la existencia
			<br> (COLUMNA 16)
		</th>
		<th>Código del Método de valuación de existencias aplicado
			<br> (COLUMNA 17)
		</th>
		<th>Cantidad de unidades físicas del bien ingresado (la primera tupla corresponde al saldo inicial)
			<br> (COLUMNA 18)
		</th>
		<th>Costo unitario del bien ingresado
			<br> (COLUMNA 19)
		</th>
		<th>Costo total del bien ingresado
			<br> (COLUMNA 20)
		</th>

		<th>Cantidad de unidades físicas del bien retirado
			<br> (COLUMNA 21)
		</th>
		<th>Costo unitario del bien retirado
			<br> (COLUMNA 22)
		</th>
		<th>Costo total del bien retirado
			<br> (COLUMNA 23)
		</th>
		<th>Cantidad de unidades físicas del saldo final
			<br> (COLUMNA 24)
		</th>
		<th>Costo unitario del saldo final
			<br> (COLUMNA 25)
		</th>

		<th>Costo total del saldo final
			<br> (COLUMNA 26)
		</th>
		<th>Indica el estado de la operación
			<br> (COLUMNA 27)
		</th>
		<th>Campos de libre utilización.
			<br> (COLUMNA 28)
		</th>

	</tr>


	<?php

	$j = 1;

	foreach ($ArrProductos as $DatProducto) {

		$ResKardex = $InsKardex->MtdObtenerKardexs(NULL, NULL, NULL, 'IFNULL(amo.AmoComprobanteFecha,amd.AmdFecha) ', 'ASC', NULL, $DatProducto->ProId, NULL, FncCambiaFechaAMysql($POST_FechaFin), 3, $POST_Moneda, "IFNULL(amo.AmoComprobanteFecha,amd.AmdFecha)", $POST_Almacen, $POST_Sucursal);
		$ArrKardexs = $ResKardex['Datos'];


		$TotalMovimientoEntradas = 0;
		$TotalMovimientoSalidas = 0;


		$TotalEntradaGeneral = 0;
		$TotalSalidaGeneral = 0;

		//
		$TotalEntradaCantidadItem = 0;
		$TotalEntradaUnitarioItem = 0;
		$TotalEntradaTotalItem = 0;

		$TotalSalidaCantidadItem = 0;
		$TotalSalidaUnitarioItem = 0;
		$TotalSalidaTotalItem = 0;

		$TotalSaldoCantidadItem = 0;
		$TotalSaldoUnitarioItem = 0;
		$TotalSaldoTotalItem = 0;


		$TotalEntradaFiltro = 0;
		$TotalCostoTotalEntradaFiltro = 0;

		$TotalSalidaFiltro = 0;
		$TotalCostoTotalSalidaFiltro = 0;

		$MostrarSaldoAnterior = true;

		$Primera = true;
		//$MostrarInventario = true;	
		$MostratTotales = false;


		$Saldo = 0;
		$CostoUnitarioAnterior = 0;
		$CostoTotalSaldo = 0;

		$CostoActual = 0;
		$CostoTotalActual = 0;


		foreach ($ArrKardexs as $DatKardex) {

			$DatKardex->KdxCostoUnitario = (($EmpresaMonedaId == $POST_Moneda or empty($POST_Moneda)) ? $DatKardex->KdxCostoUnitario : ($DatKardex->KdxCostoUnitario / $DatKardex->KdxTipoCambio));

			if (FncConvetirTimestamp($DatKardex->KdxFecha) < FncConvetirTimestamp($POST_FechaInicio)) {

				if ($DatKardex->KdxMovimientoTipo == 1) {

					$TotalEntradaGeneral += $DatKardex->KdxCantidad;

					$CostoActual = $DatKardex->KdxCostoUnitario;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;

					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);

					if ($Primera) {
						$CostoUnitarioAnterior = $CostoActual;
						$Primera = false;
					} else {
						//$CostoUnitarioAnterior = round(($CostoUnitarioAnterior + $CostoActual)/2,2);	
						$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual) / 2);
					}

					// $TotalEntradaCantidadItem += $DatKardex->KdxCantidad;
					$TotalCostoTotalEntradaItem += $CostoTotalActual;
				}

				if ($DatKardex->KdxMovimientoTipo == 2) {
					$TotalSalidaGeneral += $DatKardex->KdxCantidad;

					$CostoActual = $CostoUnitarioAnterior;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;

					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);
				}
			} else {

	?>




				<?php

				//VARIABLES - INICIO
				switch ($DatKardex->KdxMovimientoTipo) {
					case 1:
						$Fecha = $DatKardex->KdxComprobanteFecha;
						if (empty($Fecha)) {
							$Fecha = $DatKardex->KdxFecha;
						}
						break;

					case 2:
						$Fecha = $DatKardex->KdxFecha;
						break;

					default:
						break;
				}

				$Serie = "";
				$Numero = "";

				if (empty($DatKardex->KdxComprobanteNumero)) {
					list($Serie, $Numero) = explode("-", $DatKardex->KdxComprobanteNumero2);
				} else {
					list($Serie, $Numero) = explode("-", $DatKardex->KdxComprobanteNumero);
				}

				$ProductoNombre = $DatKardex->ProNombre;
				$ProductoNombre = trim($ProductoNombre);
				$ProductoNombre = substr($ProductoNombre, 0, 80);

				$ProductoCodigo  = $DatKardex->ProCodigoOriginal;
				$ProductoCodigo = trim($ProductoCodigo);
				$ProductoCodigo = str_replace(":", " ", $ProductoCodigo);


				/*
				if ($Serie == "11") {
					$Serie = "FF" . $Serie;
				}

				if ($Serie == "14") {
					$Serie = "FF" . $Serie;
				}
				*/

				/*
				if ($Serie == "") {
					$Serie = "000";
				}
				if ($Numero == "") {
					$Numero = "0000";
				}
				*/

				if ($Serie != "") {
					$Serie = str_pad($Serie, 4, '0', STR_PAD_LEFT);
				}

				if ($Numero != "") {
					$Numero = (int) $Numero;
					$Numero = str_pad($Numero, 6, '0', STR_PAD_LEFT);
				}


				if ($Numero == "") {
					$Numero = "0";
				}

				$TipoOperacion = ""; //COLUMNA 14

				if (empty($DatKardex->TopCodigo)) {
					$TipoOperacion = "10";
				} else {
					$TipoOperacion = $DatKardex->TopCodigo;
				}

				$ComprobanteTipo = ""; //COLUMNA 11

				if (empty($DatKardex->CtiCodigo)) {
					$ComprobanteTipo = "00"; //ERA 00
					$TipoOperacion = "10";
				} else {
					$ComprobanteTipo = $DatKardex->CtiCodigo;
				}


				if ($TipoOperacion == "05" && (($Serie == "") && ($Numero == "0") || ($Serie == "INVENTARIO") && ($Numero != ""))) {
					$TipoOperacion = "10";
					$ComprobanteTipo = "00";
				}

				//$TipoOperacion != "01"
				if (
					$TipoOperacion == "01"
					|| $TipoOperacion == "02"
					|| $TipoOperacion == "03"
					|| $TipoOperacion == "04"
					|| $TipoOperacion == "05"
					|| $TipoOperacion == "06"
				) {
				} else {
					$Serie = "";
					$Numero = "0";
				}

				/*
				if (
					$TipoOperacion == "16"
				) {
					$ComprobanteTipo = "00";
				}
				*/

				//VARIABLES - FIN

				?>




				<?php
				if ($MostrarSaldoAnterior) {
					$SaldoAnterior = $Saldo;
				?>

					<tr>
						<td> <?php echo $j	?>.- </td>
						<td> <?php echo $Ano . $Mes . "00"	?> </td>
						<td> C1 </td>
						<td> <?php echo "M" . $j; ?> </td>
						<td> 0003 </td>
						<td> 9 </td>

						<td> 07 </td>
						<td> <?php echo $ProductoCodigo; ?> </td>
						<td> &nbsp; </td>
						<td> &nbsp; </td>
						<td> <?php echo $FechaInventarioInicio; ?> </td>
						<td> 00 </td>

						<td> 0000 </td>
						<td> 000000 </td>
						<td> 16 </td>
						<td> <?php echo $ProductoNombre; ?> </td>
						<td> <?php echo $DatKardex->UmeCodigo; ?> </td>

						<td> 1 </td>
						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')); ?> </td>

						<td align="right" bgcolor="#CCCCCC"> 0.00 </td>
						<td align="right"> 0.00 </td>
						<td align="right"> 0.00 </td>

						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')); ?> </td>

						<td> 1 </td>
						<td> &nbsp; </td>
					</tr>
				<?php
					$j++;
					$MostrarSaldoAnterior = false;
				}
				?>


				<?php
				if ($DatKardex->KdxMovimientoTipo == 1) {

					$TotalEntradaGeneral += $DatKardex->KdxCantidad;

					$CostoActual = $DatKardex->KdxCostoUnitario;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;

					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);

					if ($Primera) {
						$CostoUnitarioAnterior = $CostoActual;
						$Primera = false;
					} else {
						$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual) / 2);
					}

					$CostoTotalSaldo = ($CostoUnitarioAnterior * $Saldo);

					$TotalEntradaFiltro += $DatKardex->KdxCantidad;
					$TotalCostoTotalEntradaFiltro += $CostoTotalActual;
				?>

					<tr>
						<td> <?php echo $j	?>.- </td>
						<td> <?php echo $Ano . $Mes . "00"	?> </td>
						<td> C1 </td>
						<td> <?php echo "M" . $j; ?> </td>
						<td> 0003 </td>
						<td> 9 </td>

						<td> 07 </td>
						<td> <?php echo $ProductoCodigo; ?> </td>
						<td> &nbsp; </td>
						<td> &nbsp; </td>
						<td> <?php echo $Fecha; ?> </td>
						<td> <?php echo $ComprobanteTipo; ?> </td>

						<td> <?php echo $Serie; ?> </td>
						<td> <?php echo $Numero; ?> </td>
						<td> <?php echo $TipoOperacion; ?> </td>
						<td> <?php echo $ProductoNombre; ?> </td>
						<td> <?php echo $DatKardex->UmeCodigo; ?> </td>

						<td> 1 </td>
						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($DatKardex->KdxCantidad) ? '0.00' : number_format($DatKardex->KdxCantidad, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($DatKardex->KdxCostoUnitario) ? '0.00' : number_format($DatKardex->KdxCostoUnitario, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalActual) ? '0.00' : number_format($CostoTotalActual, 2, '.', '')); ?> </td>

						<td align="right" bgcolor="#CCCCCC"> 0.00 </td>
						<td align="right"> 0.00 </td>
						<td align="right"> 0.00 </td>

						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($Saldo) ? '0.00' : number_format($Saldo, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')); ?> </td>

						<td> 1 </td>
						<td> <?php echo $DatKardex->KdxId; ?> </td>
					</tr>
				<?php

					$j++;
				}

				if ($DatKardex->KdxMovimientoTipo == 2) {

					$TotalSalidaGeneral += $DatKardex->KdxCantidad;

					$CostoActual = $CostoUnitarioAnterior;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;

					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);

					$CostoTotalSaldo = ($Saldo * $CostoUnitarioAnterior);


					$TotalSalidaFiltro  += $DatKardex->KdxCantidad;
					$TotalCostoTotalSalidaFiltro += $CostoTotalActual;


				?>
					<tr>
						<td> <?php echo $j	?>.- </td>

						<td> <?php echo $Ano . $Mes . "00"    ?> </td>
						<td> C1 </td>
						<td> <?php echo "M" . $j; ?> </td>
						<td> 0003 </td>
						<td> 9 </td>

						<td> 07 </td>
						<td> <?php echo $ProductoCodigo; ?> </td>
						<td> &nbsp; </td>
						<td> &nbsp; </td>
						<td> <?php echo $Fecha; ?> </td>
						<td> <?php echo $ComprobanteTipo; ?> </td>

						<td> <?php echo $Serie; ?> </td>
						<td> <?php echo $Numero; ?> </td>
						<td> <?php echo $TipoOperacion; ?> </td>
						<td> <?php echo $ProductoNombre; ?> </td>
						<td> <?php echo $DatKardex->UmeCodigo; ?> </td>

						<td> 1 </td>
						<td align="right" bgcolor="#CCCCCC"> 0.00 </td>
						<td align="right"> 0.00 </td>
						<td align="right"> 0.00 </td>

						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($DatKardex->KdxCantidad) ? '0.00' : number_format($DatKardex->KdxCantidad, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoActual) ? '0.00' : number_format($CostoActual, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalActual) ? '0.00' : number_format($CostoTotalActual, 2, '.', '')); ?> </td>

						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($Saldo) ? '0.00' : number_format($Saldo, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')); ?> </td>

						<td> 1 </td>
						<td> <?php echo $DatKardex->KdxId; ?> </td>
					</tr>

	<?php
					$j++;
				}
			}
		}
	}

	?>


	<?php


	/*
* KARDEX VEHICULOS
*/

	foreach ($ArrVehiculos as $DatVehiculo) {

		//deb($POST_UnidadMedidaUso);
		//MtdObtenerKardexVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="VmvFecha",$oSucursal=NULL,$oVehiculoId=NULL,$oVehiculoIngresoId=NULL)
		//$ResKardexVehiculo = $InsKardexVehiculo->MtdObtenerKardexVehiculos(NULL, NULL, NULL, 'ein.EinVIN, vmd.VmdFecha ASC ', '', NULL, NULL, FncCambiaFechaAMysql($KardexFechaInicio), FncCambiaFechaAMysql($POST_FechaFin), $POST_UnidadMedidaUso, $POST_Moneda, "vmd.VmdFecha", $POST_SucursalId, $DatVehiculo->VehId, NULL);
		//$ArrKardexVehiculos = $ResKardexVehiculo['Datos'];

		$ResKardexVehiculo = $InsKardexVehiculo->MtdObtenerKardexVehiculos(NULL, NULL, NULL, 'ein.EinVIN,vmd.VmdFecha ASC,(vmd.VmdTiempoCreacion) ASC', '', NULL, NULL, FncCambiaFechaAMysql($KardexFechaInicio), FncCambiaFechaAMysql($POST_FechaFin), $POST_UnidadMedidaUso, $POST_Moneda, "vmd.VmdFecha", $POST_SucursalId, $DatVehiculo->VehId, NULL);
		$ArrKardexVehiculos = $ResKardexVehiculo['Datos'];

		$InsVehiculo->VehId = $DatVehiculo->VehId;
		$InsVehiculo->MtdObtenerVehiculo(false);


		//$CostoTotalMovimientoEntradas = 0;
		//$CostoTotalMovimientoSalidas = 0;

		$TotalMovimientoEntradas = 0;
		$TotalMovimientoSalidas = 0;

		//$TotalMontoMovimientoEntradas = 0;
		//$TotalMontoMovimientoSalidas = 0;

		$TotalEntradaGeneral = 0;
		$TotalSalidaGeneral = 0;

		//$MostrarSaldoAnterior = true;
		//$MostrarSaldoAnterior2 = true;
		$MostrarSaldoInicial = true;
		$MostrarSaldoAnterior = false;

		//	$j = 1;
		$Primera = true;
		$MostrarInventario = true;

		foreach ($ArrKardexVehiculos as $DatKardexVehiculo) {

			$DatKardexVehiculo->KdvCostoUnitario = (($EmpresaMonedaId == $POST_Moneda or empty($POST_Moneda)) ? $DatKardexVehiculo->KdvCostoUnitario : ($DatKardexVehiculo->KdvCostoUnitario / $DatKardexVehiculo->KdvTipoCambio));
			$DatKardexVehiculo->KdvCostoIngreso = (($EmpresaMonedaId == $POST_Moneda or empty($POST_Moneda)) ? $DatKardexVehiculo->KdvCostoIngreso : ($DatKardexVehiculo->KdvCostoIngreso / $DatKardexVehiculo->KdvTipoCambio));

			$DatKardexVehiculo->VehCodigoIdentificador = str_replace(" ", "", $DatKardexVehiculo->VehCodigoIdentificador);
			//$DatKardexVehiculo->CtiCodigo = $DatKardexVehiculo->CtiCodigo + 1 -1 ;
			//$DatKardexVehiculo->TopCodigo = $DatKardexVehiculo->TopCodigo + 1 -1 ;

			//VARIABLES - INICIO

			/*
			$Fecha = "01/01/0001";

			switch ($DatKardexVehiculo->KdvMovimientoTipo) {
				case 1:
					$Fecha = $DatKardexVehiculo->KdvComprobanteFecha;
					break;

				case 2:
					$Fecha = $DatKardexVehiculo->KdvFecha;
					break;

				default:
					break;
			}


			$Serie = "";
			$Numero = "";

			if (empty($DatKardexVehiculo->KdvComprobanteNumero)) {
				list($Serie, $Numero) = explode("-", $DatKardexVehiculo->KdvComprobanteNumero2);
			} else {
				list($Serie, $Numero) = explode("-", $DatKardexVehiculo->KdvComprobanteNumero);
			}


			$ProductoNombre = $DatKardexVehiculo->VmoNombre . " " . $DatKardexVehiculo->VveNombre;
			$ProductoNombre = trim($ProductoNombre);
			$ProductoNombre = substr($ProductoNombre, 0, 80);
			*/

			//VARIABLES - FIN

			if ($DatKardexVehiculo->EinVIN != $VINAnterior) {
				$VINAnterior = $DatKardexVehiculo->EinVIN;
				$MostrarSaldoAnterior = FALSE;
				$TotalEntradaGeneral = 0;
				$TotalSalidaGeneral = 0;
			}


			if (FncConvetirTimestamp($DatKardexVehiculo->KdvFecha) < FncConvetirTimestamp($POST_FechaInicio)) {

				if ($DatKardexVehiculo->KdvMovimientoTipo == 1) {

					$TotalEntradaGeneral += $DatKardexVehiculo->KdvCantidad;

					$CostoActual = $DatKardexVehiculo->KdvCostoUnitario;
					$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;

					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);

					if ($Primera) {
						$CostoUnitarioAnterior = $CostoActual;
						$Primera = false;
					} else {
						//$CostoUnitarioAnterior = round(($CostoUnitarioAnterior + $CostoActual)/2,2);	
						$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual) / 2);
					}
				}

				if ($DatKardexVehiculo->KdvMovimientoTipo == 2) {

					$TotalSalidaGeneral += $DatKardexVehiculo->KdvCantidad;

					$CostoActual = $CostoUnitarioAnterior;
					$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;

					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);
				}

				$MostrarSaldoAnterior = true;
			} else {

				//$MostrarSaldoAnterior2 = false;
				//$MostrarSaldoAnterior = false;

	?>

				<?php
				/*if ($DatKardexVehiculo->EinVIN != $VINAnterior) {
					$VINAnterior = $DatKardexVehiculo->EinVIN;
					$MostrarSaldoAnterior = true;
					$TotalEntradaGeneral = 0;
					$TotalSalidaGeneral = 0;
				}*/
				?>

				<?php


				//VARIABLES - INICIO
				switch ($DatKardexVehiculo->KdvMovimientoTipo) {
					case 1:
						$Fecha = $DatKardexVehiculo->KdvComprobanteFecha;
						break;

					case 2:
						$Fecha = $DatKardexVehiculo->KdvFecha;
						break;

					default:
						break;
				}

				$Serie = "";
				$Numero = "";

				if (empty($DatKardexVehiculo->KdvComprobanteNumero)) {
					list($Serie, $Numero) = explode("-", $DatKardexVehiculo->KdvComprobanteNumero2);
				} else {
					list($Serie, $Numero) = explode("-", $DatKardexVehiculo->KdvComprobanteNumero);
				}

				$ProductoNombre = $DatKardexVehiculo->VmoNombre . " " . $DatKardexVehiculo->VveNombre;
				$ProductoNombre = trim($ProductoNombre);
				$ProductoNombre = substr($ProductoNombre, 0, 80);

				$ProductoCodigo  = $DatKardexVehiculo->EinVIN;
				$ProductoCodigo = trim($ProductoCodigo);
				$ProductoCodigo = str_replace(":", "_", $ProductoCodigo);


				/*
if ($Serie == "11") {
	$Serie = "FF" . $Serie;
}

if ($Serie == "14") {
	$Serie = "FF" . $Serie;
}
*/

				/*
if ($Serie == "") {
	$Serie = "000";
}
if ($Numero == "") {
	$Numero = "0000";
}
*/
				if ($Serie != "") {
					$Serie = str_pad($Serie, 4, '0', STR_PAD_LEFT);
				}

				if ($Numero != "") {
					$Numero = (int) $Numero;
					$Numero = str_pad($Numero, 6, '0', STR_PAD_LEFT);
				}


				if ($Numero == "") {
					$Numero = "0";
				}

				$TipoOperacion = ""; //COLUMNA 14

				if (empty($DatKardexVehiculo->TopCodigo)) {
					$TipoOperacion = "10";
				} else {
					$TipoOperacion = $DatKardexVehiculo->TopCodigo;
				}

				$ComprobanteTipo = ""; //COLUMNA 11

				if (empty($DatKardexVehiculo->CtiCodigo)) {
					$ComprobanteTipo = "00"; //ERA 00
					$TipoOperacion = "10";
				} else {
					$ComprobanteTipo = $DatKardexVehiculo->CtiCodigo;
				}

				if ($TipoOperacion == "05" && (($Serie == "") && ($Numero == "0") || ($Serie == "INVENTARIO") && ($Numero != ""))) {
					$TipoOperacion = "10";
					$ComprobanteTipo = "00";
				}

				if (
					$TipoOperacion == "01"
					|| $TipoOperacion == "02"
					|| $TipoOperacion == "03"
					|| $TipoOperacion == "04"
					|| $TipoOperacion == "05"
					|| $TipoOperacion == "06"
				) {
				} else {
					$Serie = "";
					$Numero = "0";
				}

				/*
				if (
					$TipoOperacion == "16"
				) {
					$ComprobanteTipo = "00";
				}
				*/


				//VARIABLES - FIN

				?>

				<?php
				if ($MostrarSaldoAnterior) {
					$SaldoAnterior = $CantidadSaldo;

				?>

					<tr>
						<td> <?php echo $j	?>.- </td>
						<td> <?php echo $Ano . $Mes . "00"; ?></td>
						<td> C1 </td>
						<td> <?php echo "MV" . $j; ?> </td>
						<td> 0003 </td>
						<td> 9 </td>

						<td> 01 </td>
						<td> <?php echo $ProductoCodigo; ?> </td>
						<td> &nbsp; </td>
						<td> &nbsp; </td>
						<td> <?php echo $FechaInventarioInicio; ?> </td>
						<td> 00 </td>


						<td> 0000 </td>
						<td> 000000 </td>
						<td> 16 </td>
						<td> <?php echo $ProductoNombre; ?> </td>
						<td> <?php echo $DatKardexVehiculo->UmeCodigo; ?> </td>

						<td> 2</td>
						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')); ?> </td>

						<td align="right" bgcolor="#CCCCCC"> 0.00 </td>
						<td align="right"> 0.00 </td>
						<td align="right"> 0.00 </td>

						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')); ?> </td>

						<td> 1 </td>
						<td> </td>
					</tr>

				<?php
					$j++;
					$MostrarSaldoAnterior = false;
				}
				?>


				<?php
				if ($DatKardexVehiculo->KdvMovimientoTipo == 1) {

					$TotalEntradaGeneral += $DatKardexVehiculo->KdvCantidad;

					//$CantidadEntrada = $DatKardexVehiculo->KdvCantidad;
					$CostoActual = $DatKardexVehiculo->KdvCostoUnitario;
					$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;
					//$CostoTotalMovimientoEntradas += $CostoTotalActual;

					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);

					if ($Primera) {
						$CostoTotalAnterior = $CostoTotalActual;
						$Primera = false;
					} else {
						$CostoTotalAnterior = (($CostoTotalAnterior + $CostoActual));
					}

					$CostoTotalSaldo = ($CostoTotalAnterior);
					$CostoUnitarioSaldo = $CostoTotalSaldo / (empty($CantidadSaldo) ? 1 : $CantidadSaldo);


					//SETEANDO VARIABLES
					/*$CantidadSaldo = $CantidadSaldo + 1 - 1;
					$CostoUnitarioSaldo = $CostoUnitarioSaldo + 1 - 1;
					$CostoTotalSaldo = $CostoTotalSaldo + 1 - 1;

					//$CantidadEntrada = $CantidadEntrada + 1 - 1;
					$DatKardexVehiculo->KdxCostoUnitario = $DatKardexVehiculo->KdxCostoUnitario + 1 - 1;
					$CostoTotalActual = $CostoTotalActual + 1 - 1;*/

					//if ($CantidadSaldo >= 0 and $CostoUnitarioSaldo >= 0 and $CostoTotalSaldo >= 0) {
				?>

					<tr>
						<td> <?php echo $j	?>.- </td>

						<td> <?php echo $Ano . $Mes . "00"; ?></td>
						<td> C1 </td>
						<td> <?php echo "MV" . $j; ?> </td>
						<td> 0003 </td>
						<td> 9 </td>

						<td> 01 </td>
						<td> <?php echo $ProductoCodigo; ?> </td>
						<td> &nbsp; </td>
						<td> &nbsp; </td>
						<td> <?php echo $Fecha; ?> </td>
						<td> <?php echo $ComprobanteTipo; ?> </td>

						<td> <?php echo $Serie; ?> </td>
						<td> <?php echo $Numero; ?> </td>
						<td> <?php echo $TipoOperacion; ?> </td>
						<td> <?php echo $ProductoNombre; ?> </td>
						<td> <?php echo $DatKardexVehiculo->UmeCodigo; ?> </td>

						<td> 5</td>
						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($DatKardexVehiculo->KdvCantidad) ? '0.00' : number_format($DatKardexVehiculo->KdvCantidad, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($DatKardexVehiculo->KdvCostoUnitario) ? '0.00' : number_format($DatKardexVehiculo->KdvCostoUnitario, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalActual) ? '0.00' : number_format($CostoTotalActual, 2, '.', '')); ?> </td>

						<td align="right" bgcolor="#CCCCCC"> 0.00 </td>
						<td align="right"> 0.00 </td>
						<td align="right"> 0.00 </td>

						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')); ?> </td>

						<td> 1 </td>
						<td> <?php echo $DatKardexVehiculo->KdvId; ?> </td>

					</tr>
				<?php
					$j++;
				}

				if ($DatKardexVehiculo->KdvMovimientoTipo == 2) {


					$TotalSalidaGeneral += $DatKardexVehiculo->KdvCantidad;
					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);

					//$CantidadSalida = $DatKardexVehiculo->KdvCantidad;
					$CostoActual = $DatKardexVehiculo->KdvCostoIngreso;
					$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;

					//$CostoTotalMovimientoSalidas += $CostoTotalActual;

					$CostoTotalAnterior = (($CostoTotalAnterior - $CostoActual));

					$CostoTotalSaldo = ($CostoTotalAnterior - $CostoTotalActual);
					$CostoUnitarioSaldo = $CostoTotalSaldo / (empty($CantidadSaldo) ? 1 : $CantidadSaldo);


					//SETEANDO VARIABLES
					/*$CantidadSaldo = $CantidadSaldo + 1 - 1;
					$CostoUnitarioSaldo = $CostoUnitarioSaldo + 1 - 1;
					$CostoTotalSaldo = $CostoTotalSaldo + 1 - 1;
 
					//$CantidadSalida = $CantidadSalida + 1 - 1;
					$CostoActual = $CostoActual + 1 - 1;
					$CostoTotalActual = $CostoTotalActual + 1 - 1;*/

					//if ($CantidadSaldo >= 0 and $CostoUnitarioSaldo >= 0 and $CostoTotalSaldo >= 0) {
				?>
					<tr>
						<td> <?php echo $j	?>.- </td>
						<td> <?php echo $Ano . $Mes . "00"; ?></td>
						<td> C1 </td>
						<td> <?php echo "MV" . $j; ?> </td>
						<td> 0003 </td>
						<td> 9 </td>

						<td> 01 </td>
						<td> <?php echo $ProductoCodigo; ?> </td>
						<td> &nbsp; </td>
						<td> &nbsp; </td>
						<td> <?php echo $Fecha; ?> </td>
						<td> <?php echo $ComprobanteTipo; ?> </td>

						<td> <?php echo $Serie; ?> </td>
						<td> <?php echo $Numero; ?> </td>
						<td> <?php echo $TipoOperacion; ?> </td>
						<td> <?php echo $ProductoNombre; ?> </td>
						<td> <?php echo $DatKardexVehiculo->UmeCodigo; ?> </td>

						<td> 5 </td>
						<td align="right" bgcolor="#CCCCCC"> 0.00 </td>
						<td align="right"> 0.00 </td>
						<td align="right"> 0.00 </td>

						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($DatKardexVehiculo->KdvCantidad) ? '0.00' : number_format($DatKardexVehiculo->KdvCantidad, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($DatKardexVehiculo->KdvCostoUnitario) ? '0.00' : number_format($DatKardexVehiculo->KdvCostoUnitario, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($DatKardexVehiculo->KdvCostoTotal) ? '0.00' : number_format($DatKardexVehiculo->KdvCostoTotal, 2, '.', '')); ?> </td>

						<td align="right" bgcolor="#CCCCCC"> <?php echo (empty($CantidadSaldo) ? '0.00' : number_format($CantidadSaldo, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', '')); ?> </td>
						<td align="right"> <?php echo (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')); ?> </td>

						<td> 1 </td>
						<td> <?php echo $DatKardexVehiculo->KdvId; ?> </td>
					</tr>
	<?php
					$j++;
				}
			}
		}
	}


	?>
</table>

<?php

$NombreArchivo = "LE" . $EmpresaCodigo . $Ano . $Mes . "00" . "130100" . "00" . "1" . "1" . "1" . "1" . ".txt";


?>

<h3>Nombre del Archivo:</h3>

<?php
echo  $NombreArchivo;
