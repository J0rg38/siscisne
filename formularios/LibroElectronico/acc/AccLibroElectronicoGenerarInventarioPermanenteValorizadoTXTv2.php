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
$InsFactura = new ClsFactura();
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

			if ($Serie == "") {
				$Serie = "000";
			}
			if ($Numero == "") {
				$Numero = "0000";
			}

			$Serie = str_pad($Serie, 4, '0', STR_PAD_LEFT);
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


			$TipoOperacion = "";

			if (empty($DatKardex->TopCodigo)) {
				$TipoOperacion = "10";
			} else {
				$TipoOperacion = $DatKardex->TopCodigo;
			}

			$ComprobanteTipo = "";

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


			if ($MostrarSaldoAnterior) {
				$SaldoAnterior = $Saldo;

				$libro .= $Ano . $Mes . "00" . "|C1|M" . $j . "|0003|9|07|" . $ProductoCodigo . "|||" . $FechaInventarioInicio . "|00|000|000000|16|" . $ProductoNombre . "|" . $DatKardex->UmeCodigo . "|1|"

					. (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', ''))
					. "|" . (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', ''))
					. "|" . (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', ''))

					. "|0.00|0.00|0.00|"

					. (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', ''))
					. "|" . (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', ''))
					. "|" . (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')) . "|1|\n";

				$j++;
				$MostrarSaldoAnterior = false;
			}







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

				//if ($Saldo >= 0 and $CostoUnitarioAnterior >= 0 and $CostoTotalSaldo >= 0) {

				$libro .= $Ano . $Mes . "00"  	. "|C1|M" . $j . "|0003|9|07|" . $ProductoCodigo . "|||" . $Fecha . "|" . $ComprobanteTipo . "|" . $Serie . "|" . $Numero . "|" . $TipoOperacion . "|" . $ProductoNombre . "|" . $DatKardex->UmeCodigo . "|1|"

					. (empty($DatKardex->KdxCantidad) ? '0.00' : number_format($DatKardex->KdxCantidad, 3, '.', ''))
					. "|" . (empty($DatKardex->KdxCostoUnitario) ? '0.00' : number_format($DatKardex->KdxCostoUnitario, 3, '.', ''))
					. "|" . (empty($CostoTotalActual) ? '0.00' : number_format($CostoTotalActual, 2, '.', ''))

					. "|0.00|0.00|0.00|"

					. (empty($Saldo) ? '0.00' : number_format($Saldo, 3, '.', ''))
					. "|" . (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', ''))
					. "|" . (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', ''))
					. "|1|" . $DatKardex->KdxId . "\n";
				//}


				$j++;
			}

			if ($DatKardex->KdxMovimientoTipo == 2) {

				//if (!empty($DatKardex->KdxComprobanteNumero) or !empty($DatKardex->KdxComprobanteNumero2)) {

				$TotalSalidaGeneral += $DatKardex->KdxCantidad;

				$CostoActual = $CostoUnitarioAnterior;
				$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;

				$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);

				$CostoTotalSaldo = ($Saldo * $CostoUnitarioAnterior);


				$TotalSalidaFiltro  += $DatKardex->KdxCantidad;
				$TotalCostoTotalSalidaFiltro += $CostoTotalActual;



				//if ($Saldo >= 0 and $CostoUnitarioAnterior >= 0 and $CostoTotalSaldo >= 0) {

				$libro .= $Ano . $Mes . "00" .   "|C1|M" . $j . "|0003|9|07|" . $ProductoCodigo . "|||" . $Fecha . "|" . $ComprobanteTipo . "|" . $Serie . "|" . $Numero . "|" . $TipoOperacion . "|" . $ProductoNombre . "|" . $DatKardex->UmeCodigo

					. "|1|0.00|0.00|0.00|"

					. "" . (empty($DatKardex->KdxCantidad) ? '0.00' : number_format($DatKardex->KdxCantidad, 3, '.', ''))
					. "|" . (empty($CostoActual) ? '0.00' : number_format($CostoActual, 3, '.', ''))
					. "|" . (empty($CostoTotalActual) ? '0.00' : number_format($CostoTotalActual, 2, '.', ''))

					. "|" . (empty($Saldo) ? '0.00' : number_format($Saldo, 3, '.', ''))
					. "|" . (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', ''))
					. "|" . (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')) . "|1|" . $DatKardex->KdxId . "\n";
				//}

				$j++;
				//}
			}
		}
	}

	//if ($MostrarSaldoAnterior2) {
	//	}
}


/*
* KARDEX VEHICULOS
*/

foreach ($ArrVehiculos as $DatVehiculo) {

	//deb($POST_UnidadMedidaUso);
	//MtdObtenerKardexVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="VmvFecha",$oSucursal=NULL,$oVehiculoId=NULL,$oVehiculoIngresoId=NULL)
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
			$ProductoCodigo = str_replace(":", " ", $ProductoCodigo);

			/*
			if ($Serie == "11") {
				$Serie = "FF" . $Serie;
			}

			if ($Serie == "14") {
				$Serie = "FF" . $Serie;
			}

			if ($Serie == "") {
				$Serie = "000";
			}
			if ($Numero == "") {
				$Numero = "0000";
			}

			$Serie = str_pad($Serie, 4, '0', STR_PAD_LEFT);
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

			$TipoOperacion = "";

			if (empty($DatKardexVehiculo->TopCodigo)) {
				$TipoOperacion = "10";
			} else {
				$TipoOperacion = $DatKardexVehiculo->TopCodigo;
			}

			$ComprobanteTipo = "";

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


			if ($MostrarSaldoAnterior) {
				$SaldoAnterior = $CantidadSaldo;


				$libro .= $Ano . $Mes . "00" . "|C1|MV" . $j . "|0003|9|01|" . $ProductoCodigo . "|||" . $FechaInventarioInicio . "|00|0000|000000|16|" . $ProductoNombre . "|" . $DatKardexVehiculo->UmeCodigo . "|2|"
					. (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', ''))
					. "|" . (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', ''))
					. "|" . (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', ''))
					. "|0.00|0.00|0.00|"
					. (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', ''))
					. "|" . (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', ''))
					. "|" . (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')) . "|1|\n";

				$j++;
				$MostrarSaldoAnterior = false;
			}




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

				$libro .= $Ano . $Mes . "00" . "|C1|MV" . $j . "|0003|9|01|" . $ProductoCodigo . "|||" . $Fecha . "|" . $ComprobanteTipo . "|" . $Serie . "|" . $Numero . "|" . $TipoOperacion . "|" . $ProductoNombre . "|" . $DatKardexVehiculo->UmeCodigo . "|5|"

					. (empty($DatKardexVehiculo->KdvCantidad) ? '0.00' : number_format($DatKardexVehiculo->KdvCantidad, 3, '.', ''))
					. "|" . (empty($DatKardexVehiculo->KdvCostoUnitario) ? '0.00' : number_format($DatKardexVehiculo->KdvCostoUnitario, 3, '.', ''))
					. "|" . (empty($CostoTotalActual) ? '0.00' : number_format($CostoTotalActual, 2, '.', ''))
					. "|0.00|0.00|0.00|"

					. (empty($SaldoAnterior) ? '0.00' : number_format($SaldoAnterior, 3, '.', ''))
					. "|" . (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', ''))
					. "|" . (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')) . "|1|" . $DatKardexVehiculo->KdvId . "\n";
				//}


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

				$libro .= $Ano . $Mes . "00" . "|C1|MV" . $j . "|0003|9|01|" . $ProductoCodigo . "|||" . $Fecha . "|" . $ComprobanteTipo . "|" . $Serie . "|" . $Numero . "|" . $TipoOperacion . "|" .  $ProductoNombre . "|" . $DatKardexVehiculo->UmeCodigo
					. "|5|0.00|0.00|0.00|"
					. "" . (empty($DatKardexVehiculo->KdvCantidad) ? '0.00' : number_format($DatKardexVehiculo->KdvCantidad, 3, '.', ''))
					. "|" . (empty($DatKardexVehiculo->KdvCostoUnitario) ? '0.00' : number_format($DatKardexVehiculo->KdvCostoUnitario, 3, '.', ''))
					. "|" . (empty($DatKardexVehiculo->KdvCostoTotal) ? '0.00' : number_format($DatKardexVehiculo->KdvCostoTotal, 2, '.', ''))

					. "|" . (empty($CantidadSaldo) ? '0.00' : number_format($CantidadSaldo, 3, '.', ''))
					. "|" . (empty($CostoUnitarioAnterior) ? '0.00' : number_format($CostoUnitarioAnterior, 3, '.', ''))
					. "|" . (empty($CostoTotalSaldo) ? '0.00' : number_format($CostoTotalSaldo, 2, '.', '')) . "|1|\n";
				//}

				$j++;
			}
		}


		$j++;
	}
}



$NombreArchivo = "LE" . $EmpresaCodigo . $Ano . $Mes . "00" . "130100" . "00" . "1" . "1" . "1" . "1" . ".txt";
$Ruta = '../../../generados/libros_electronicos/';

if (file_exists($Ruta . '' . $NombreArchivo)) {
	unlink($Ruta . '' . $NombreArchivo);
}

$ddf = fopen($Ruta . '' . $NombreArchivo, 'a');
fwrite($ddf, $libro);
fclose($ddf);
//	
$nombre_archivo = basename($Ruta . '' . $NombreArchivo);
header("Content-disposition: attachment; filename=" . $NombreArchivo);
header("Content-type: application/octet-stream");
readfile($Ruta . '' . $NombreArchivo);
