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
  header("Content-Disposition:  filename=\"REPORTE_VENTA_X_TALLER_" . date('d-m-Y') . ".xls\";");
}
?>
<html>

<head>

  <?php
  if ($_GET['P'] <> 2) {
  ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos(); ?>CssReporte.css">
    <script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias(); ?>jquery-1.7.2.min.js"></script>
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

  $POST_FechaInicio = isset($_GET['CmpFechaInicio']) ? $_GET['CmpFechaInicio'] : "01/" . date("m") . "/" . date("Y");
  $POST_FechaFin = isset($_GET['CmpFechaFin']) ? $_GET['CmpFechaFin'] : date("d/m/Y");

  $POST_ord = isset($_GET['CmpOrden']) ? $_GET['CmpOrden'] : "FinId";
  $POST_sen = isset($_GET['CmpSentido']) ? $_GET['CmpSentido'] : "DESC";

  $POST_Modalidad = $_GET['CmpModalidad'];
  $POST_Sucursal = $_GET['CmpSucursal'];
  $POST_VehiculoMarca = $_GET['CmpVehiculoMarca'];
  $POST_Sucursal = $_GET['CmpSucursal'];
  $POST_VehiculoModelo = $_GET['CmpVehiculoModelo'];


  //deb($_GET);

  require_once($InsPoo->MtdPaqReporte() . 'ClsReporteFichaIngreso.php');

  $InsReporteFichaIngreso = new ClsReporteFichaIngreso();

  //MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oCSIIncluir=NULL,$oCliente=NULL,$oUnicos=false,$oVehiculoMarca=NULL,$oModalidadIngresoUnico=false,$oSucursal=NULL,$oFecha="FinFecha",$oComprobanteFechaInicio=NULL,$oComprobanteFechaFin=NULL,$oPersonal=NULL,$oVehiculoModelo=NULL)
  $ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresosVentaxTaller(NULL, NULL, NULL, $POST_ord, $POST_sen, NULL, FncCambiaFechaAMysql($POST_FechaInicio), FncCambiaFechaAMysql($POST_FechaFin), $POST_Modalidad, NULL, NULL, NULL, false, $POST_VehiculoMarca, true, $POST_Sucursal, "FinFecha", NULL, NULL, NULL, $POST_VehiculoModelo);
  $ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];

  ?>

  <?php if ($_GET['P'] == 1) { ?>
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
      <tr>
        <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre; ?> - <?php echo $EmpresaCodigo; ?></span></td>
      </tr>
      <tr>
        <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150" />
        </td>
        <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE VENTAS X TALLER

            DEL
            <?php
            if ($POST_FechaInicio == $POST_FechaFin) {
            ?>
              <?php echo $POST_FechaInicio; ?>
            <?php
            } else {
            ?>
              <?php echo $POST_FechaInicio; ?> AL <?php echo $POST_FechaFin; ?>
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

  <?php } ?>

  <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
    <thead class="EstTablaReporteHead">
      <tr>
        <th width="2%">#</th>

        <th>LOCAL</th>
        <th>ASESOR</th>

        <th>FECHA INGRESO</th>
        <th>HORA INGRESO</th>

        <th>FECHA PROMESA</th>
        <th>HORA PROMESA</th>

        <th>OT</th>
        <th>TIPO OT</th>

        <th>SEGURO</th>
        <th>ESTADO OT</th>

        <th>TECNICO</th>
        <th>COMPROBANTE</th>
        <th>ESTADO COMPROBANTE</th>

        <th>FECHA ENTREGA</th>
        <th>HORA ENTREGA</th>
        <th>FECHA CIERRE</th>

        <th>VIN</th>
        <th>PLACA</th>
        <th>MARCA</th>
        <th>MODELO</th>
        <th>MODELO TECNICO</th>
        <th>AÑO</th>
        <th>KILOMETRAJE</th>

        <th>DOCUMENTO</th>

        <th>CLIENTE</th>
        <th>TELEFONO</th>
        <th>CORREO</th>

        <th>DIRECCION</th>
        <th>DEPARTAMENTO</th>
        <th>PROVINCIA</th>
        <th>DISTRITO</th>

        <th>DETALLE DEL SERVICIO</th>

        <th>MONEDA</th>
        <th>TC </th>

        <th>V.VENTA $</th>
        <th>V.VENTA S/</th>
        <th>P.VENTA $</th>
        <th>P.VENTA S/</th>
        <th>OBSERVACIONES</th>

      </tr>
    </thead>
    <tbody class="EstTablaReporteBody">


      <?php
      $FichaIngresoModalidadTotal = 0;
      $FichaIngresoModalidadFacturadoTotal = 0;
      $FichaIngresoModalidadNoFacturadoTotal = 0;
      $TotalHorasTrabajadas = 0;

      $c = 1;
      foreach ($ArrReporteFichaIngresos as $DatReporteFichaIngreso) {
      ?>
        <tr>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle"><?php echo $c; ?></td>

          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle"><?php echo $DatReporteFichaIngreso->SucNombre; ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle"><?php echo $DatReporteFichaIngreso->PerNombreAsesor ?> <?php echo $DatReporteFichaIngreso->PerApellidoPaternoAsesor; ?> <?php echo $DatReporteFichaIngreso->PerApellidoMaternoAsesor; ?></td>

          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo ($DatReporteFichaIngreso->FinFecha); ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo ($DatReporteFichaIngreso->FinHora); ?></td>

          <!-- FECHA PROMESA -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle">-</td>
          <!-- HORA PROMESA -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle">-</td>


          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle"> <?php echo $DatReporteFichaIngreso->FinId;  ?> </td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle"> <?php echo $DatReporteFichaIngreso->MinNombre; ?> </td>

          <!-- SEGURO -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle">- </td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle">
            <?php
            if ($DatReporteFichaIngreso->FinComprobanteVentaTipo != "") {
            ?>
              FACTURADO
            <?php
            } else {
            ?>
              ABIERTO
            <?php
            }
            ?>
          </td>


          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">
            <?php echo ($DatReporteFichaIngreso->PerNombre); ?>
            <?php echo ($DatReporteFichaIngreso->PerApellidoPaterno); ?>
            <?php echo ($DatReporteFichaIngreso->PerApellidoMaterno); ?>
          </td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">
            <?php
            if ($DatReporteFichaIngreso->FccFacturable == "2") {
            ?>
              No Facturable
            <?php
            }
            ?>

            <?php

            switch ($DatReporteFichaIngreso->FinComprobanteVentaTipo) {

              case "F":
            ?>
                <?php echo $DatReporteFichaIngreso->FtaNumero; ?> - <?php echo $DatReporteFichaIngreso->FacId; ?>
              <?php
                break;

              case "B":
              ?>
                <?php echo $DatReporteFichaIngreso->BtaNumero; ?> - <?php echo $DatReporteFichaIngreso->BolId; ?>
            <?php
                break;
            }

            ?>
          </td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right" valign="middle">Enviado </td>

          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->FinFechaEntrega;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->FinHoraEntrega;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->FinTiempoTallerConcluido;  ?></td>


          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->EinVIN;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->EinPlaca;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->VmaNombre;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->VmoNombre;  ?></td>


          <!-- MODELO TECNICO -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">-</td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->EinAnoModelo;  ?></td>

          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">
            <?php
            //  if (!empty($DatReporteFichaIngreso->FinMantenimientoKilometraje) and $DatReporteFichaIngreso->MinId == "MIN-10001") {
            ?>
            <?php echo number_format($DatReporteFichaIngreso->FinMantenimientoKilometraje);  ?>
            <?php
            //    }
            ?>
          </td>

          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->CliNombreCompleto;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->CliCelular;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->CliEmail;  ?></td>

          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->CliDireccion;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->CliDepartamento;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->CliProvincia;  ?></td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->CliDistrito;  ?></td>


          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"><?php echo $DatReporteFichaIngreso->FinNota;  ?></td>

          <!-- MONEDA -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">

            <?php
            switch ($DatReporteFichaIngreso->FinComprobanteVentaTipo) {
              case "F":
            ?>
                <?php echo $DatReporteFichaIngreso->FacMoneda; ?>
              <?php
                break;

              case "B":
              ?>
                <?php echo $DatReporteFichaIngreso->BolMoneda; ?>
              <?php
                break;

              default:
              ?>
                -
            <?php
                break;
            }
            ?>

          </td>


          <!-- TIPO CAMBIO -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">
            <?php
            switch ($DatReporteFichaIngreso->FinComprobanteVentaTipo) {
              case "F":
            ?>
                <?php echo $DatReporteFichaIngreso->FacTipoCambio; ?>
              <?php
                break;

              case "B":
              ?>
                <?php echo $DatReporteFichaIngreso->BolTipoCambio; ?>
              <?php
                break;

              default:
              ?>
                -
            <?php
                break;
            }
            ?>


          </td>

          <!-- V. VENTA $ -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">

            <?php
            switch ($DatReporteFichaIngreso->FinComprobanteVentaTipo) {

              case "F":


            ?>
                <?php if ($DatReporteFichaIngreso->FacTipoCambio != "") { ?>
                  <?php $DatReporteFichaIngreso->FacSubTotal = (($DatReporteFichaIngreso->FacSubTotal / (empty($DatReporteFichaIngreso->FacTipoCambio) ? 1 : $DatReporteFichaIngreso->FacTipoCambio))); ?>
                  <?php echo number_format($DatReporteFichaIngreso->FacSubTotal, 2); ?>

                <?php } ?>

              <?php
                break;

              case "B":
              ?>
                <?php if ($DatReporteFichaIngreso->BolTipoCambio != "") { ?>
                  <?php $DatReporteFichaIngreso->BolSubTotal = (($DatReporteFichaIngreso->BolSubTotal / (empty($DatReporteFichaIngreso->BolTipoCambio) ? 1 : $DatReporteFichaIngreso->BolTipoCambio))); ?>
                  <?php echo number_format($DatReporteFichaIngreso->BolSubTotal, 2); ?>
                <?php } ?>
              <?php
                break;

              default:
              ?>
                -
            <?php
                break;
            }
            ?>

          </td>

          <!-- V. VENTA S/ -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">

            <?php
            switch ($DatReporteFichaIngreso->FinComprobanteVentaTipo) {

              case "F":
            ?>
                <?php echo number_format($DatReporteFichaIngreso->FacSubTotal, 2); ?>
              <?php
                break;

              case "B":
              ?>
                <?php echo number_format($DatReporteFichaIngreso->BolSubTotal, 2); ?>
              <?php
                break;

              default:
              ?>
                -
            <?php
                break;
            }
            ?>

          </td>


          <!-- P. VENTA S/ -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">

            <?php
            switch ($DatReporteFichaIngreso->FinComprobanteVentaTipo) {

              case "F":
            ?>
                <?php echo number_format($DatReporteFichaIngreso->FacTotal, 2); ?>
              <?php
                break;

              case "B":
              ?>
                <?php echo number_format($DatReporteFichaIngreso->BolTotal, 2); ?>
              <?php
                break;

              default:
              ?>
                -
            <?php
                break;
            }
            ?>

          </td>

          <!-- P. VENTA $ -->
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right">

            <?php
            switch ($DatReporteFichaIngreso->FinComprobanteVentaTipo) {

              case "F":

            ?>
                <?php if ($DatReporteFichaIngreso->FacTipoCambio != "") { ?>
                  <?php $DatReporteFichaIngreso->FacTotal = (($DatReporteFichaIngreso->FacTotal / (empty($DatReporteFichaIngreso->FacTipoCambio) ? 1 : $DatReporteFichaIngreso->FacTipoCambio))); ?>
                  <?php echo number_format($DatReporteFichaIngreso->FacTotal, 2); ?>
                <?php } ?>

              <?php
                break;

              case "B":
              ?>
                <?php if ($DatReporteFichaIngreso->BolTipoCambio != "") { ?>
                  <?php $DatReporteFichaIngreso->BolTotal = (($DatReporteFichaIngreso->BolTotal / (empty($DatReporteFichaIngreso->BolTipoCambio) ? 1 : $DatReporteFichaIngreso->BolTipoCambio))); ?>
                  <?php echo number_format($DatReporteFichaIngreso->BolTotal, 2); ?>
                <?php } ?>
              <?php
                break;

              default:
              ?>
                -
            <?php
                break;
            }
            ?>



          </td>
          <td class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>" align="right"> <?php echo $DatReporteFichaIngreso->FinObservacion; ?></td>



        </tr>
      <?php
        $FichaIngresoModalidadTotal++;
        $c++;
      }
      ?>
      <tr>
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
    </tbody>
    <tfoot class="EstTablaReporteFoot">
    </tfoot>
  </table>


  <table width="100%">
    <tr>
      <td width="94%" align="right">Total Trabajado: </td>
      <td width="6%" align="right"><span class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>"><?php echo number_format($TotalHorasTrabajadas, 2); ?></span></td>
    </tr>
    <tr>
      <td align="right">Total Facturados: </td>
      <td align="right"><span class="<?php echo ($c % 2 == 0) ? "EstTablaReporteActivo" : "EstTablaReporteInactivo"; ?>"><?php echo number_format($TotalFacturado, 2); ?></span></td>
    </tr>
  </table>


  <p class="EstTablaReporteNota">
    Del
    <?php
    if ($POST_FechaInicio == $POST_FechaFin) {
    ?>
      <?php echo $POST_FechaInicio; ?>
    <?php
    } else {
    ?>
      <?php echo $POST_FechaInicio; ?> al <?php echo $POST_FechaFin; ?>
    <?php
    }
    ?>
  </p>


</body>

</html>