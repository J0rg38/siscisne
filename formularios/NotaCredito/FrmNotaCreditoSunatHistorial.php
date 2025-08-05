<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $SistemaNombre;?> <?php echo $SistemaVersion;?> - <?php echo $EmpresaNombre;?> Sucursal: <?php echo $_SESSION['SisSucNombre'];?> - Area: <?php echo $_SESSION['SisAreNombre'];?> - Usuario: <?php echo $_SESSION['SesionNombre'];?> [<?php echo $_SESSION['SesionUsuario'];?>] </title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssPrincipal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">



<?php

$GET_Id = $_GET['Id'];
$GET_Ta = $_GET['Ta'];

//deb($_GET);

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsNotaCredito = new ClsNotaCredito();
$InsNotaCredito->NcrId = $GET_Id;
$InsNotaCredito->NctId =$GET_Ta;
$InsNotaCredito->MtdObtenerNotaCredito(false);

?>

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormularioTabla">
<tbody class="EstFormularioTablaBodu">
<tr>
  <td colspan="3"><span class="EstFormularioTitulo">RESUMEN SUNAT</span></td>
  </tr>
<tr>
  <td width="23%">&nbsp;</td>
  <td width="1%">&nbsp;</td>
  <td width="76%">&nbsp;</td>
</tr>
<tr>
  <td>Ultima Accion</td>
  <td>:</td>
  <td><?php echo $InsNotaCredito->NcrSunatUltimaAccion;?></td>
</tr>
<tr>
  <td>Ultima Respuesta</td>
  <td>:</td>
  <td><?php echo $InsNotaCredito->NcrSunatUltimaRespuesta ?></td>
</tr>
<tr>
  <td colspan="3"><span class="EstFormularioSubTitulo">SOLICITUD DE ALTA</span></td>
</tr>
<tr>
  <td>Ticket Envio</td>
  <td>:</td>
  <td><?php echo $InsNotaCredito->NcrSunatRespuestaEnvioTicket ?></td>
</tr>
<tr>
  <td>Respuesta</td>
  <td>:</td>
  <td><?php echo $InsNotaCredito->NcrSunatRespuestaEnvioCodigo ?> - <?php echo $InsNotaCredito->NcrSunatRespuestaEnvioContenido ?></td>
</tr>
<tr>
  <td colspan="3"><span class="EstFormularioSubTitulo">SOLICITUD DE BAJA</span></td>
</tr>
<tr>
  <td>Ticket Anulacion</td>
  <td>:</td>
  <td><?php echo $InsNotaCredito->NcrSunatRespuestaBajaTicket ?></td>
</tr>
<tr>
  <td>Respuesta</td>
  <td>:</td>
  <td><?php echo $InsNotaCredito->NcrSunatRespuestaBajaCodigo; ?> - <?php echo $InsNotaCredito->NcrSunatRespuestaBajaContenido; ?></td>
</tr>
<tr>
  <td colspan="3"><span class="EstFormularioSubTitulo">CONSULTA TICKET</span></td>
</tr>
<tr>
  <td>Respuesta</td>
  <td>:</td>
  <td><?php echo $InsNotaCredito->NcrSunatRespuestaConsultaCodigo; ?> - <?php echo $InsNotaCredito->NcrSunatRespuestaConsultaContenido; ?></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
<td>

</td>
<td></td>
<td>

</td>
</tr>
</tbody>
</table>


</body>
</html>