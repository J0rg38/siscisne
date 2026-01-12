<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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
//	header("Content-type: application/vnd.ms-excel");
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_KPI_".date('d-m-Y').".xls\";");
//}


define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias() . 'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias() . 'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');



$POST_FechaInicio = empty($_GET['CmpFechaInicio']) ? date("d/m/Y") : $_GET['CmpFechaInicio'];
$POST_FechaFin = empty($_GET['CmpFechaFin']) ? date("d/m/Y") : $_GET['CmpFechaFin'];
$POST_Moneda = (empty($_GET['CmpMoneda']) ? $EmpresaMonedaId : $_GET['CmpMoneda']);

$POST_Sucursal = (($_GET['CmpSucursal']));
$POST_VehiculoMarca = (($_GET['CmpVehiculoMarca']));
$POST_TipoReporte = (($_GET['CmpTipoReporte']));

require_once($InsPoo->MtdPaqReporte() . 'ClsReporteFichaIngreso.php');


require_once($InsPoo->MtdPaqReporte() . 'ClsReporteVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsProductoVehiculoVersion.php');

require_once($InsPoo->MtdPaqAlmacen() . 'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqActividad() . 'ClsModalidadIngreso.php');

//MESON
require_once($InsPoo->MtdPaqAlmacen() . 'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsVentaDirectaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen() . 'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsTipoCambio.php');


$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
$InsProducto = new ClsProducto();
$InsTipoCambio = new ClsTipoCambio($InsMysql);
$InsModalidadIngreso = new ClsModalidadIngreso();
//MESON
$InsReporteVentaDirecta = new ClsReporteVentaDirecta($InsMysql);

$modalidad = '';

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos($oCampo = NULL, $oFiltro = NULL, $oOrden = 'MinId', $oSentido = 'Desc', $oPaginacion = '100', $oUso = NULL, $oEstado = 1);
$ArrModalidadIngreso = $ResModalidadIngreso['Datos'];

$ArrReporteFichaIngreso = array();
$ArrReporteVentaDirectas = array();

if ($POST_TipoReporte == 'TALLER_BYP') {

  foreach ($ArrModalidadIngreso as $ModalidadIngreso) {
    if ($ModalidadIngreso->MinUso == 'TALLER_BYP') {
      $modalidad .= $ModalidadIngreso->MinId . ',';
    }
  }
  //TALLLER
  $ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresosVentaxTallerDetallado(NULL, NULL, NULL, "RfpFecha", "ASC", NULL, NULL, NULL, $POST_Sucursal, FncCambiaFechaAMysql($POST_FechaInicio), FncCambiaFechaAMysql($POST_FechaFin), $POST_VehiculoMarca, $modalidad);
  $ArrReporteFichaIngreso = $ResReporteFichaIngreso['Datos'];
} else if ($POST_TipoReporte == 'TALLER_MEC') {
  foreach ($ArrModalidadIngreso as $ModalidadIngreso) {
    if ($ModalidadIngreso->MinUso == 'TALLER_MEC') {
      $modalidad .= $ModalidadIngreso->MinId . ',';
    }
  }

  //TALLLER
  $ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresosVentaxTallerDetallado(NULL, NULL, NULL, "RfpFecha", "ASC", NULL, NULL, NULL, $POST_Sucursal, FncCambiaFechaAMysql($POST_FechaInicio), FncCambiaFechaAMysql($POST_FechaFin), $POST_VehiculoMarca, $modalidad);
  $ArrReporteFichaIngreso = $ResReporteFichaIngreso['Datos'];
} else if ($POST_TipoReporte == 'MESON') {

  //MESON
  $ResReporteVentaDirecta = $InsReporteVentaDirecta->MtdObtenerVentaDirectaDetalles(NULL, NULL, NULL, 'VddId', 'Desc', NULL, NULL, NULL, NULL, FncCambiaFechaAMysql($POST_FechaInicio), FncCambiaFechaAMysql($POST_FechaFin), $POST_Moneda, $POST_ClienteId, $POST_ConOrdenCompra);
  $ArrReporteVentaDirectas = $ResReporteVentaDirecta['Datos'];
} else if ($POST_TipoReporte == 'TODOS') {

  //TALLLER
  $ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresosVentaxTallerDetallado(NULL, NULL, NULL, "RfpFecha", "ASC", NULL, NULL, NULL, $POST_Sucursal, FncCambiaFechaAMysql($POST_FechaInicio), FncCambiaFechaAMysql($POST_FechaFin), $POST_VehiculoMarca, $modalidad);
  $ArrReporteFichaIngreso = $ResReporteFichaIngreso['Datos'];

  //MESON
  $ResReporteVentaDirecta = $InsReporteVentaDirecta->MtdObtenerVentaDirectaDetalles(NULL, NULL, NULL, 'VddId', 'Desc', NULL, NULL, NULL, NULL, FncCambiaFechaAMysql($POST_FechaInicio), FncCambiaFechaAMysql($POST_FechaFin), $POST_Moneda, $POST_ClienteId, $POST_ConOrdenCompra);
  $ArrReporteVentaDirectas = $ResReporteVentaDirecta['Datos'];
}





?>

<?php
if ($_GET['P'] <> 2 and !empty($_GET['P'])) {
?>
  <link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos(); ?>CssReporte.css">
  <script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias(); ?>jquery-1.7.2.min.js"></script>
<?php
}
?>

<?php if ($_GET['P'] == 1) { ?>
  <script type="text/javascript">
    $().ready(function() {
      setTimeout("window.close();", 2500);
      window.print();
    });
  </script>
<?php } ?>

<?php if ($_GET['P'] == 1) { ?>
  <table cellpadding="0" cellspacing="0" width="100%" border="0">
    <tr>
      <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre; ?> - <?php echo $EmpresaCodigo; ?></span></td>
    </tr>
    <tr>
      <td width="23%" rowspan="2" align="left" valign="top">


      </td>
      <td width="54%" rowspan="2" align="center" valign="top">REPORTE DE VENTA DE TALLER DETALLADO</td>
      <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y"); ?> <?php echo date("H:i:s"); ?> <?php echo date("a"); ?></span> <br />

        <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario']; ?></span>
      </td>
    </tr>
    <tr>
      <td align="right" valign="top">A&ntilde;o: <?php echo $POST_Ano; ?></td>
    </tr>
  </table>

  <hr class="EstReporteLinea">

<?php } ?>







<table class="EstTablaReporte" width="100%">
  <tr>
    <td width="100%" colspan="2" align="center" valign="top"><span class="EstFormularioSubTitulo"></span></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top">


      <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaListadoHead">
          <tr>
            <th rowspan="2">#</th>
            <th colspan="13">DATOS DE OT</th>
            <th colspan="8">DATOS DE VEHICULO</th>
            <th colspan="9">DATOS DE CLIENTE</th>
            <th colspan="6">DATOS FACTURACION (sin igv)</th>
            <th colspan="4">DETALLE DE TRABAJOS</th>

            <th colspan="8">DETALLE EN SOLES</th>
            <th colspan="8">DETALLE EN DOLARES</th>

            <th rowspan="2">OBSERVACIONES</th>
          </tr>
          <tr>
            <!-- DATOS DE OT -->
            <th> SEDE</th>
            <th> NUM. OT </th>

            <th>SEGURO</th>
            <th>NUM COT (Meson)</th>
            <th>MAYOREO (Meson)</th>

            <th> ASESOR</th>
            <th> TECNICO ASIGNADO</th>
            <th> FECHA APERTURA</th>
            <th> FECHA VENTA (meson)</th>
            <th>FECHA CIERRE</th>
            <th>TIPO OT</th>
            <th>ESTADO</th>
            <th>KILOMETRAJE OT</th>

            <!-- DATOS DE VEHICULO -->
            <th>PLACA </th>
            <th>VIN </th>
            <th>MOTOR</th>
            <th>MARCA </th>
            <th>MODELO TECNICO </th>
            <th>COLOR </th>
            <th>AÑO FABRICACION </th>
            <th>AÑO MODELO </th>

            <!-- DATOS DE CLIENTE -->
            <th>TIPO DOC </th>
            <th>DOCUMENTO </th>
            <th>CLIENTE </th>
            <th>CELULAR </th>
            <th>CORREO </th>
            <th>DIRECCION </th>
            <th>DEPARTAMENTO </th>
            <th>PROVINCIA</th>
            <th>DISTRITO </th>

            <!-- DATOS FACTURACION (sin igv) -->
            <th>TC VENTA </th>
            <th>MONEDA </th>
            <th>PRECIO TOTAL FACTURA </th>
            <th>CANT FACTURADA </th>
            <th>FECHA FACTURACION </th>
            <th>FACTURA OT </th>

            <!-- DATOS DETALLE TRABAJOS -->
            <th>TIPO </th>
            <th>CODIGO </th>
            <th>DESCRIPCION </th>
            <th>CANT SOLICITADA </th>

            <!-- DATOS DETALLE EN SOLES -->
            <th>PRECIO </th>
            <th>DSCTO MARCA </th>
            <th>DSCTO DEALER </th>
            <th>DSCTO TOTAL </th>
            <th>PRECIO TOTAL </th>
            <th>COSTO UNITARIO </th>
            <th>COSTO TOTAL </th>
            <th>MARGEN TOTAL </th>

            <!-- DATOS DETALLE EN DOLARES -->
            <th>PRECIO </th>
            <th>DSCTO MARCA </th>
            <th>DSCTO DEALER </th>
            <th>DSCTO TOTAL </th>
            <th>PRECIO TOTAL </th>
            <th>COSTO UNITARIO </th>
            <th>COSTO TOTAL </th>
            <th>MARGEN TOTAL</th>

          </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
          <?php
          $i = 1;
          $TotalEntradas = 0;
          $TotalSalidas = 0;
          $TotalSaldos = 0;
          $Color = "FFFFFF";

          $UltimaFecha = "";
          $Flag = 2;

          foreach ($ArrReporteFichaIngreso as $DatReporteFichaIngreso) {

            if ($i % 2 == 0) {
              $Color = "CCCCCC";
            } else {
              $Color = "FFFFFF";
            }

            $CostoSoles = 0;
            $CostoTotalSoles = 0;

            $CostoDolares = 0;
            $CostoTotalDolares = 0;

            $MargenTotalSoles = 0;
            $MargenTotalDolares = 0;

            $PrecioDolares = 0;
            $PrecioTotalDolares = 0;
            $DescuentoTotalDolares = 0;

            $InsProducto->ProId = $DatReporteFichaIngreso->ProId;
            $InsProducto->MtdObtenerProducto(false);

            if ($InsProducto->ProCosto >= 0) {
              $CostoSoles = $InsProducto->ProCosto;
              $CostoTotalSoles = $CostoSoles * $DatReporteFichaIngreso->RfpCantidad;
              $MargenTotalSoles = $DatReporteFichaIngreso->RfpImporte - $CostoTotalSoles;
            }

            $TipoCambio = 1;

            if ($DatReporteFichaIngreso->RfpTipoCambio == "0.00" || $DatReporteFichaIngreso->RfpTipoCambio == "") {

              $InsTipoCambio = new ClsTipoCambio();
              $InsTipoCambio->MonId = "MON-10001";
              //$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatReporteFichaIngreso->NcrFechaEmision);
              $InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatReporteFichaIngreso->FinFecha);
              $InsTipoCambio->MtdObtenerTipoCambioFecha();

              $TipoCambio = $InsTipoCambio->TcaMontoVenta;
            } else {
              $TipoCambio = $DatReporteFichaIngreso->RfpTipoCambio;
            }

            if ($TipoCambio > 1) {
              $CostoDolares = $CostoSoles / $TipoCambio;
              $CostoTotalDolares = $CostoDolares * $DatReporteFichaIngreso->RfpCantidad;

              $PrecioDolares = $DatReporteFichaIngreso->RfpPrecio / $TipoCambio;
              $PrecioTotalDolares = $DatReporteFichaIngreso->RfpImporte / $TipoCambio;

              $DescuentoTotalDolares = $DatReporteFichaIngreso->RfpDescuento / $TipoCambio;

              $MargenTotalDolares = $PrecioTotalDolares - $CostoTotalDolares;
            }


          ?>

            <tr>
              <td><?php echo $i; ?></td>

              <!-- DATOS DE OT -->
              <td bgcolor="#eb7434"><?php echo $DatReporteFichaIngreso->SucNombre; ?></td>
              <td bgcolor="#eb7434"> <?php echo $DatReporteFichaIngreso->FinId; ?></td>
              <td bgcolor="#eb7434">Sin info de seguro</td>
              <td bgcolor="#eb7434"><!-- NUM COT --></td>
              <td bgcolor="#eb7434"><!-- MAYOREO --></td>

              <td bgcolor="#eb7434"><?php echo $DatReporteFichaIngreso->RfpVendedor; ?></td>
              <td bgcolor="#eb7434"><?php echo $DatReporteFichaIngreso->RfpAsesorAccesorio; ?></td>

              <td bgcolor="#eb7434"><?php echo $DatReporteFichaIngreso->FinFecha; ?></td>
              <td bgcolor="#eb7434">-</td>
              <td bgcolor="#eb7434">-</td>
              <td bgcolor="#eb7434"><?php echo $DatReporteFichaIngreso->MinNombre; ?></td>
              <td bgcolor="#eb7434">FACTURADO</td>
              <td bgcolor="#eb7434"><?php echo $DatReporteFichaIngreso->FinVehiculoKilometraje; ?></td>

              <!-- DATOS DE VEHICULO -->
              <td bgcolor="#34eb6b"><?php echo $DatReporteFichaIngreso->EinPlaca; ?></td>
              <td bgcolor="#34eb6b"><?php echo $DatReporteFichaIngreso->EinVin; ?></td>
              <td bgcolor="#34eb6b"><?php echo $DatReporteFichaIngreso->EinNumeroMotor; ?></td>
              <td bgcolor="#34eb6b"><?php echo $DatReporteFichaIngreso->VmaNombre; ?></td>
              <td bgcolor="#34eb6b"><?php echo $DatReporteFichaIngreso->VmoNombre; ?></td>
              <td bgcolor="#34eb6b"><?php echo $DatReporteFichaIngreso->EinColor; ?></td>
              <td bgcolor="#34eb6b"><?php echo $DatReporteFichaIngreso->EinAnoFabricacion; ?></td>
              <td bgcolor="#34eb6b"><?php echo $DatReporteFichaIngreso->EinAnoModelo; ?></td>

              <!-- DATOS DE CLIENTE -->
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->TdoNombre; ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->CliNumeroDocumento; ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->CliNombre; ?> <?php echo $DatReporteFichaIngreso->CliApellidoPaterno; ?> <?php echo $DatReporteFichaIngreso->CliApellidoMaterno; ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->CliCelular; ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->CliEmail; ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->CliDireccion; ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->CliDepartamento; ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->CliProvincia; ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->CliDistrito; ?></td>

              <!-- DATOS FACTURACION (sin igv) -->
              <td bgcolor="#348ceb"> <?php echo number_format($TipoCambio, 2); ?> </td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->MonNombre; ?></td>
              <td bgcolor="#348ceb"><?php echo number_format($DatReporteFichaIngreso->RfpImporte, 2); ?></td>
              <td bgcolor="#348ceb"><?php echo number_format($DatReporteFichaIngreso->RfpCantidad, 2); ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->RfpFecha; ?></td>
              <td bgcolor="#348ceb"><?php echo $DatReporteFichaIngreso->RfpDoc; ?></td>

              <!-- DETALLE DE TRABAJOS -->
              <td bgcolor="#3564a6">
                <?php
                if ($DatReporteFichaIngreso->ProValidarStock == 1) {
                ?>
                  Insumos
                <?php
                } else {
                ?>
                  Mano. O y Otros
                <?php
                }
                ?>
              </td>
              <td bgcolor="#3564a6"><?php echo $DatReporteFichaIngreso->RfpCodigo; ?></td>
              <td bgcolor="#3564a6"><?php echo $DatReporteFichaIngreso->RfpDescripcion; ?></td>
              <td bgcolor="#3564a6"><?php echo number_format($DatReporteFichaIngreso->RfpCantidad, 2, '.', ','); ?></td>

              <!-- DATOS DETALLE EN SOLES -->
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($DatReporteFichaIngreso->RfpPrecio, 2, '.', ','); ?></td>
              <td bgcolor="#ada358" align="right" valign="top">0.00</td>
              <td bgcolor="#ada358" align="right" valign="top">0.00</td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($DatReporteFichaIngreso->RfpDescuento, 2, '.', ','); ?></td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($DatReporteFichaIngreso->RfpImporte, 2, '.', ','); ?></td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($CostoSoles, 2); ?></td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($CostoTotalSoles, 2); ?></td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($MargenTotalSoles, 2); ?></td>

              <!-- DETALLE EN DOLARES -->
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($PrecioDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top">0.00</td>
              <td bgcolor="#d98da0" align="right" valign="top">0.00</td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($DescuentoTotalDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($PrecioTotalDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($CostoDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($CostoTotalDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($MargenTotalDolares, 2); ?></td>

              <td bgcolor="<?php echo $Color; ?>"><?php echo $DatReporteFichaIngreso->FinObservacion; ?></td>


            </tr>

          <?php


            $i++;
          }

          ?>

          <!-- VENTAS MESON -->

          <?php
          $VentaDirectaSumaTotal = 0;
          $FacturaSumaTotal = 0;
          $c = 1;
          $fondo = "";
          //$fondo = "#CCCCCC";
          $VentaDirectaIdAnterior = "";

          foreach ($ArrReporteVentaDirectas as $DatReporteVentaDirecta) {

            $CostoSoles = 0;
            $CostoTotalSoles = 0;

            $CostoDolares = 0;
            $CostoTotalDolares = 0;

            $MargenTotalSoles = 0;
            $MargenTotalDolares = 0;

            $PrecioDolares = 0;
            $PrecioTotalDolares = 0;
            $DescuentoTotalDolares = 0;

            $InsProducto->ProId = $DatReporteVentaDirecta->ProId;
            $InsProducto->MtdObtenerProducto(false);

            if ($InsProducto->ProCosto >= 0) {
              $CostoSoles = $InsProducto->ProCosto;
              $CostoTotalSoles = $CostoSoles * $DatReporteVentaDirecta->VddCantidad;

              $MargenTotalSoles = $DatReporteVentaDirecta->VddImporte - $CostoTotalSoles;
            }

            $TipoCambio = 1;

            if ($DatReporteVentaDirecta->VdiTipoCambio == "0.00" || $DatReporteVentaDirecta->VdiTipoCambio == "") {

              $InsTipoCambio = new ClsTipoCambio();
              $InsTipoCambio->MonId = "MON-10001";
              //$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatReporteVentaDirecta->NcrFechaEmision);
              $InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatReporteVentaDirecta->VdiFecha);
              $InsTipoCambio->MtdObtenerTipoCambioFecha();

              $TipoCambio = $InsTipoCambio->TcaMontoVenta;
            } else {
              $TipoCambio = $DatReporteVentaDirecta->VdiTipoCambio;
            }

            if ($TipoCambio > 1) {
              $CostoDolares = $CostoSoles / $TipoCambio;
              $CostoTotalDolares = $CostoDolares * $DatReporteVentaDirecta->VddCantidad;

              $PrecioDolares = $DatReporteVentaDirecta->VddPrecioBruto / $TipoCambio;
              $PrecioTotalDolares = $DatReporteVentaDirecta->VddImporte / $TipoCambio;

              $DescuentoTotalDolares = $DatReporteVentaDirecta->VddDescuento / $TipoCambio;

              $MargenTotalDolares = $PrecioTotalDolares - $CostoTotalDolares;
            }

          ?>



            <tr id="Fila_<?php echo $c; ?>">

              <td align="right" valign="middle"><?php echo $c; ?></td>

              <!-- DATOS DE NV MESON -->
              <td bgcolor="#eb7434" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->SucNombre); ?></td>
              <td bgcolor="#eb7434" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->VdiId); ?></td>
              <td bgcolor="#eb7434" align="right" valign="top">SEGURO</td>
              <td bgcolor="#eb7434" align="right" valign="top">-</td>
              <td bgcolor="#eb7434" align="right" valign="top">NO</td>
              <td bgcolor="#eb7434" align="right" valign="top">
                <?php echo ($DatReporteVentaDirecta->PerNombre); ?>
                <?php echo ($DatReporteVentaDirecta->PerApellidoPaterno); ?>
                <?php echo ($DatReporteVentaDirecta->PerApellidoMaterno); ?>
              </td>

              <td bgcolor="#eb7434" align="right" valign="top">No Alica <!-- TECNICO ASIGNADO --></td>
              <td bgcolor="#eb7434" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->VdiFecha); ?></td>
              <td bgcolor="#eb7434" align="right" valign="top">-</td>
              <td bgcolor="#eb7434" align="right" valign="top">No Aplica <!-- FECHA CIERRE --></td>

              <td bgcolor="#eb7434" align="right" valign="top">No Aplica <!-- TIPO OT --></td>
              <td bgcolor="#eb7434" align="right" valign="top">No Aplica <!-- ESTADO --></td>
              <td bgcolor="#eb7434" align="right" valign="top">No Aplica <!-- KILOMETRAJE OT --></td>

              <!-- DATOS VEHICULO (DE TALLER) -->
              <td align="right" valign="top">No Aplica </td>
              <td align="right" valign="top">No Aplica </td>
              <td align="right" valign="top">No Aplica </td>
              <td align="right" valign="top">No Aplica </td>
              <td align="right" valign="top">No Aplica </td>

              <td align="right" valign="top">No Aplica </td>
              <td align="right" valign="top">No Aplica </td>
              <td align="right" valign="top">No Aplica </td>


              <!-- DATOS CLIENTE -->
              <td bgcolor="#34eb6b" align="right" valign="top">No Aplica <!-- TIPO DOC --></td>
              <td bgcolor="#34eb6b" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->CliNumeroDocumento); ?></td>
              <td bgcolor="#34eb6b" align="right" valign="top">
                <?php echo ($DatReporteVentaDirecta->CliNombre); ?>
                <?php echo ($DatReporteVentaDirecta->CliApellidoPaterno); ?>
                <?php echo ($DatReporteVentaDirecta->CliApellidoMaterno); ?>
              </td>
              <td bgcolor="#34eb6b" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->CliCelular); ?></td>
              <td bgcolor="#34eb6b" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->CliEmail); ?></td>
              <td bgcolor="#34eb6b" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->CliDireccion); ?></td>
              <td bgcolor="#34eb6b" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->CliDepartamento); ?></td>
              <td bgcolor="#34eb6b" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->CliProvincia); ?></td>
              <td bgcolor="#34eb6b" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->CliDistrito); ?></td>

              <!-- DATOS FACTURACIÓN (sin igv) -->
              <td bgcolor="#348ceb" align="right" valign="top">
                <?php echo number_format($TipoCambio, 2); ?>
              </td>
              <td bgcolor="#348ceb" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->MonNombre); ?></td>
              <td bgcolor="#348ceb" align="right" valign="top">

                <?php $DatReporteVentaDirecta->VddImporte = (($EmpresaMonedaId == $POST_Moneda or empty($POST_Moneda)) ? $DatReporteVentaDirecta->VddImporte : ($DatReporteVentaDirecta->VddImporte / $DatReporteVentaDirecta->VdiTipoCambio)); ?>

                <?php
                if ($DatReporteVentaDirecta->VdiIncluyeImpuesto == 2) {
                  $DatReporteVentaDirecta->VddImporte = $DatReporteVentaDirecta->VddImporte * 1.18;
                }
                ?>

                <?php echo number_format($DatReporteVentaDirecta->VddImporte, 2); ?>

              </td>
              <td bgcolor="#348ceb" align="right" valign="top">
                >No Aplica <!-- CANT FACTURADA -->
              </td>

              <td bgcolor="#348ceb" align="right" valign="top">

                <?php
                $FacturaId = "";
                $FacturaTalonarioId = "";
                $FacturaFecha = "";
                $FacturaTalonarioNumero = "";
                $FacturaRevisar = false;
                $FacturaDetalleImporte = 0;
                ?>

                <?php
                $InsFacturaDetalle = new ClsFacturaDetalle();
                $ResFacturaDetalle = $InsFacturaDetalle->MtdObtenerFacturaDetalles(NULL, NULL, 'FdeId', 'Desc', NULL, NULL, NULL, NULL, 5, $DatReporteVentaDirecta->VddId);
                $ArrFacturaDetalles = $ResFacturaDetalle['Datos'];
                ?>

                <?php
                if (!empty($ArrFacturaDetalles)) {
                  foreach ($ArrFacturaDetalles as $DatFacturaDetalle) {
                ?>

                    <?php echo $FacturaFecha = $DatFacturaDetalle->FacFechaEmision; ?><br>

                <?php
                  }
                }
                ?>


                <?php
                $BoletaId = "";
                $BoletaTalonarioId = "";
                $BoletaFecha = "";
                $BoletaTalonarioNumero = "";
                $BoletaRevisar = false;
                $BoletaImporte = 0;
                ?>

                <?php
                $InsBoletaDetalle = new ClsBoletaDetalle();
                $ResBoletaDetalle = $InsBoletaDetalle->MtdObtenerBoletaDetalles(NULL, NULL, 'BdeId', 'Desc', NULL, NULL, NULL, NULL, 5, $DatReporteVentaDirecta->VddId);
                $ArrBoletaDetalles = $ResBoletaDetalle['Datos'];
                ?>

                <?php
                if (!empty($ArrBoletaDetalles)) {
                  foreach ($ArrBoletaDetalles as $DatBoletaDetalle) {
                ?>
                    <?php echo $BoletaFecha = $DatBoletaDetalle->BolFechaEmision; ?><br>
                <?php
                  }
                }
                ?>

                &nbsp;
              </td>
              <td bgcolor="#348ceb" align="right" valign="top">


                <?php
                $FacturaId = "";
                $FacturaTalonarioId = "";
                $FacturaFecha = "";
                $FacturaTalonarioNumero = "";
                $FacturaRevisar = false;
                $FacturaDetalleImporte = 0;
                ?>


                <?php
                $InsFacturaDetalle = new ClsFacturaDetalle();
                $ResFacturaDetalle = $InsFacturaDetalle->MtdObtenerFacturaDetalles(NULL, NULL, 'FdeId', 'Desc', NULL, NULL, NULL, NULL, 5, $DatReporteVentaDirecta->VddId);
                $ArrFacturaDetalles = $ResFacturaDetalle['Datos'];
                ?>

                <?php
                if (!empty($ArrFacturaDetalles)) {
                  foreach ($ArrFacturaDetalles as $DatFacturaDetalle) {
                ?>
                    <?php
                    $FacturaId = $DatFacturaDetalle->FacId;
                    $FacturaTalonarioNumero = $DatFacturaDetalle->FtaNumero;
                    ?>

                    <?php echo $FacturaTalonarioNumero; ?> - <?php echo $FacturaId; ?><br>

                <?php
                  }
                }
                ?>






                <?php
                $BoletaId = "";
                $BoletaTalonarioId = "";
                $BoletaFecha = "";
                $BoletaTalonarioNumero = "";
                $BoletaRevisar = false;
                $BoletaImporte = 0;
                ?>


                <?php
                $InsBoletaDetalle = new ClsBoletaDetalle();
                $ResBoletaDetalle = $InsBoletaDetalle->MtdObtenerBoletaDetalles(NULL, NULL, 'BdeId', 'Desc', NULL, NULL, NULL, NULL, 5, $DatReporteVentaDirecta->VddId);
                $ArrBoletaDetalles = $ResBoletaDetalle['Datos'];
                ?>

                <?php
                if (!empty($ArrBoletaDetalles)) {
                  foreach ($ArrBoletaDetalles as $DatBoletaDetalle) {
                ?>
                    <?php
                    $BoletaId = $DatBoletaDetalle->BolId;
                    $BoletaTalonarioNumero = $DatBoletaDetalle->BtaNumero;
                    ?>

                    <?php echo $BoletaTalonarioNumero; ?> - <?php echo $BoletaId; ?><br>

                <?php
                  }
                }
                ?>
                &nbsp;
              </td>



              <!-- DETALLE DE REPUESTOS -->
              <td bgcolor="#3564a6" align="right" valign="top">
                TIPO
              </td>
              <td bgcolor="#3564a6" align="right" valign="top">
                <?php echo ($DatReporteVentaDirecta->ProCodigoOriginal); ?>
              </td>
              <td bgcolor="#3564a6" align="right" valign="top">
                <?php echo ($DatReporteVentaDirecta->ProNombre); ?>
              </td>
              <td bgcolor="#3564a6" align="right" valign="top"><?php echo number_format($DatReporteVentaDirecta->VddCantidad, 2); ?></td>


              <!-- DETALLE EN SOLES -->
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($DatReporteVentaDirecta->VddPrecioBruto, 2); ?></td>
              <td bgcolor="#ada358" align="right" valign="top">0.00</td>
              <td bgcolor="#ada358" align="right" valign="top">0.00</td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($DatReporteVentaDirecta->VddDescuento, 2); ?></td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($DatReporteVentaDirecta->VddImporte, 2); ?></td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($CostoSoles, 2); ?></td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($CostoTotalSoles, 2); ?></td>
              <td bgcolor="#ada358" align="right" valign="top"><?php echo number_format($MargenTotalSoles, 2); ?></td>

              <!-- DETALLE EN DOLARES -->
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($PrecioDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top">0.00</td>
              <td bgcolor="#d98da0" align="right" valign="top">0.00</td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($DescuentoTotalDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($PrecioTotalDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($CostoDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($CostoTotalDolares, 2); ?></td>
              <td bgcolor="#d98da0" align="right" valign="top"><?php echo number_format($MargenTotalDolares, 2); ?></td>

              <!-- OBSERVACIONES -->
              <td align="right" valign="top">
                <?php echo ($DatReporteVentaDirecta->VdiObservacion); ?>
              </td>
            </tr>
          <?php
            $c++;
          }
          ?>

        </tbody>
        <tfoot class="EstTablaListadoFoot">

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>

        </tfoot>

      </table>

      <hr />


      <?php
      $TotalEgresos = $TotalReporteResumenVentas;
      ?>



    </td>
  </tr>
</table>