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

if ($_GET['P'] == 2) {
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition:  filename=\"REPORTE_VENTA_MESON_" . date('d-m-Y') . ".xls\";");
}
?>
<html>

<head>

  <?php
  if ($_GET['P'] <> 2) {
  ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos(); ?>CssReporte.css">
    <script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias(); ?>jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/JsReporteVentaDirectaResumen.js"></script>
  <?php
  }
  ?>

</head>

<body>
  <script type="text/javascript">
    $().ready(function() {
      <?php if ($_GET['P'] == 1) { ?>
        setTimeout("window.close();", 2500);
        window.print();

      <?php } ?>
    });
  </script>
  <?php

  $POST_finicio = isset($_POST['CmpFechaInicio']) ? $_POST['CmpFechaInicio'] : "01/" . date("m/Y");
  $POST_ffin = isset($_POST['CmpFechaFin']) ? $_POST['CmpFechaFin'] : date("d/m/Y");

  $POST_ClienteId = $_POST['CmpClienteId'];
  $POST_ClienteNombre = $_POST['CmpClienteNombre'];

  $POST_ord = isset($_POST['CmpOrden']) ? $_POST['CmpOrden'] : "VdiId";
  $POST_sen = isset($_POST['CmpSentido']) ? $_POST['CmpSentido'] : "DESC";

  $POST_Moneda = ($_POST['CmpMoneda']);

  $POST_ConOrdenCompra = ($_POST['CmpConOrdenCompra']);


  require_once($InsPoo->MtdPaqLogistica() . 'ClsPedidoCompra.php');
  require_once($InsPoo->MtdPaqLogistica() . 'ClsPedidoCompraDetalle.php');

  require_once($InsPoo->MtdPaqAlmacen() . 'ClsVentaDirecta.php');
  require_once($InsPoo->MtdPaqAlmacen() . 'ClsVentaDirectaDetalle.php');
  require_once($InsPoo->MtdPaqLogistica() . 'ClsCliente.php');
  require_once($InsPoo->MtdPaqContabilidad() . 'ClsMoneda.php');

  require_once($InsPoo->MtdPaqAlmacen() . 'ClsVentaConcretadaDetalle.php');
  require_once($InsPoo->MtdPaqContabilidad() . 'ClsFacturaDetalle.php');
  require_once($InsPoo->MtdPaqContabilidad() . 'ClsBoletaDetalle.php');
  require_once($InsPoo->MtdPaqContabilidad() . 'ClsTipoCambio.php');

  require_once($InsPoo->MtdPaqReporte() . 'ClsReporteVentaDirecta.php');
  require_once($InsPoo->MtdPaqAlmacen() . 'ClsProducto.php');
  require_once($InsPoo->MtdPaqAlmacen() . 'ClsProductoVehiculoVersion.php');

  require_once($InsPoo->MtdPaqAlmacen() . 'ClsProductoAno.php');
  require_once($InsPoo->MtdPaqAlmacen() . 'ClsListaPrecio.php');
  
  $InsVentaDirectaDetalle = new ClsVentaDirectaDetalle($InsMysql);
  $InsCliente = new ClsCliente($InsMysql);
  $InsMoneda = new ClsMoneda($InsMysql);
  $InsReporteVentaDirecta = new ClsReporteVentaDirecta($InsMysql);
  $InsTipoCambio = new ClsTipoCambio($InsMysql);
  $InsProducto = new ClsProducto($InsMysql);




  $ResReporteVentaDirecta = $InsReporteVentaDirecta->MtdObtenerVentaDirectaDetalles(NULL, NULL, NULL, 'VddId', 'Desc', NULL, NULL, NULL, NULL, FncCambiaFechaAMysql($POST_finicio), FncCambiaFechaAMysql($POST_ffin), $POST_Moneda, $POST_ClienteId, $POST_ConOrdenCompra);
  $ArrReporteVentaDirectas = $ResReporteVentaDirecta['Datos'];
  //$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,0,NULL,NULL,$POST_Moneda,$POST_ClienteId,$POST_ConOrdenCompra);
  //$ArrVentaDirectas = $ResVentaDirecta['Datos'];
  $POST_Moneda = (empty($POST_Moneda) ? $EmpresaMonedaId : $POST_Moneda);
  //deb($POST_Moneda);
  $InsMoneda = new ClsMoneda($InsMysql);
  $InsMoneda->MonId = $POST_Moneda;
  $InsMoneda->MtdObtenerMoneda();

  ?>

  <?php if ($_GET['P'] == 1) { ?>
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
      <tr>
        <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre; ?> - <?php echo $EmpresaCodigo; ?></span></td>
      </tr>
      <tr>
        <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150" />
        </td>
        <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE VENTAS X MESON DEL
            <?php
            if ($POST_finicio == $POST_ffin) {
            ?>
              <?php echo $POST_finicio; ?>
            <?php
            } else {
            ?>
              <?php echo $POST_finicio; ?> AL <?php echo $POST_ffin; ?>
            <?php
            }
            ?>



          </span></td>
        <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y"); ?> <?php echo date("H:i:s"); ?> <?php echo date("a"); ?></span> <br />

          <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario']; ?></span>
        </td>
      </tr>
    </table>
    <hr class="EstReporteLinea">

    <style type="text/css">
      tbody.EstTablaReporteBody td {
        white-space: nowrap;
      }
    </style>
  <?php } ?>



  <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
    <thead class="EstTablaReporteHead">

      <tr>
        <th rowspan="2" align="center">#</th>
        <th colspan="8" align="center">DATOS DE NV MESON</th>
        <th colspan="7" align="center">DATOS CLIENTE</th>

        <th colspan="5" align="center">DATOS FACTURACIÓN (sin igv)</th>
        <th colspan="3" align="center">DETALLE DE REPUESTOS</th>

        <th colspan="8" align="center"> DETALLE EN SOLES </th>
        <th colspan="8" align="center"> DETALLE EN DOLARES </th>
        <th rowspan="2" align="center">OBSERVACIONES</th>
      </tr>

      <tr>
        <th align="center">SEDE</th>
        <th align="center">NOTA DE VENTA</th>
        <th align="center">NUM COT</th>
        <th align="center">MAYOREO</th>
        <th align="left">ASESOR</th>
        <th align="center">FECHA APERTURA COT</th>
        <th align="center">FECHA VENTA</th>
        <th align="center">FECHA CIERRE</th>

        <th align="center">DOCUMENTO</th>
        <th align="center">CLIENTE</th>
        <th align="center">CORREO</th>
        <th align="center">DIRECCION</th>
        <th align="center">DEPARTAMENTO</th>
        <th align="center">PROVINCIA</th>
        <th align="center">DISTRITO</th>


        <th align="center">TC</th>
        <th align="center">MONEDA</th>
        <th align="center">PRECIO TOTAL FACTURA</th>
        <th align="center">FECHA FACTURACION</th>
        <th align="center">FACTURA MESON</th>

        <th align="center">CODIGO</th>
        <th align="center">DESCRIPCION</th>
        <th align="center">CANTIDAD</th>

        <th align="center">PRECIO</th>
        <th align="center">DSCO MARCA</th>
        <th align="center">DSCO DEALER</th>
        <th align="center">DSCO TOTAL</th>
        <th align="center">PRECIO TOTAL</th>
        <th align="center">COSTO UNIT</th>
        <th align="center">COSTO TOTAL</th>
        <th align="center">MARGEN TOTAL</th>

        <th align="center">PRECIO</th>
        <th align="center">DSCO MARCA</th>
        <th align="center">DSCO DEALER</th>
        <th align="center">DSCO TOTAL</th>
        <th align="center">PRECIO TOTAL</th>
        <th align="center">COSTO UNIT</th>
        <th align="center">COSTO TOTAL</th>
        <th align="center">MARGEN TOTAL</th>

      </tr>
    </thead>
    <tbody class="EstTablaReporteBody">


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
          <!-- DATOS DE NV MESON -->
          <td bgcolor="#eb7434" align="right" valign="middle"><?php echo $c; ?></td>
          <td bgcolor="#eb7434" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->SucNombre); ?></td>
          <td bgcolor="#eb7434" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->VdiId); ?></td>
          <td bgcolor="#eb7434" align="right" valign="top"></td>
          <td bgcolor="#eb7434" align="right" valign="top">NO</td>
          <td bgcolor="#eb7434" align="right" valign="top">
            <?php echo ($DatReporteVentaDirecta->PerNombre); ?>
            <?php echo ($DatReporteVentaDirecta->PerApellidoPaterno); ?>
            <?php echo ($DatReporteVentaDirecta->PerApellidoMaterno); ?>
          </td>
          <td bgcolor="#eb7434" align="right" valign="top">-</td>
          <td bgcolor="#eb7434" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->VdiFecha); ?></td>
          <td bgcolor="#eb7434" align="right" valign="top">-</td>

          <!-- DATOS CLIENTE -->
          <td bgcolor="#34eb6b" align="right" valign="top"><?php echo ($DatReporteVentaDirecta->CliNumeroDocumento); ?></td>
          <td bgcolor="#34eb6b" align="right" valign="top">
            <?php echo ($DatReporteVentaDirecta->CliNombre); ?>
            <?php echo ($DatReporteVentaDirecta->CliApellidoPaterno); ?>
            <?php echo ($DatReporteVentaDirecta->CliApellidoMaterno); ?>
          </td>
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

        ?>



      <?php
        $c++;
      }
      ?>

      <tr>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td colspan="4" align="right">SUMA TOTAL:</td>
        <td align="right">&nbsp;</td>
        <td align="right">

          <?php echo $InsMoneda->MonSimbolo; ?> <?php echo number_format($VentaDirectaSumaTotal, 2); ?></td>
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
        <td align="right"><?php echo $InsMoneda->MonSimbolo; ?> <?php echo number_format($FacturaSumaTotal, 2); ?></td>
      </tr>


    </tbody>
    <tfoot class="EstTablaReporteFoot">
    </tfoot>
  </table>





</body>

</html>