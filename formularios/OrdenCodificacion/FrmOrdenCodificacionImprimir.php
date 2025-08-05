<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCodificacion.php');


$InsOrdenCodificacion = new ClsOrdenCodificacion();

$InsOrdenCodificacion->OciId = $GET_id;
$InsOrdenCodificacion = $InsOrdenCodificacion->MtdObtenerOrdenCodificacion();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ORDEN DE COTIZACION No. <?php echo $InsOrdenCodificacion->OciId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssOrdenCodificacion.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsOrdenCodificacionImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsOrdenCodificacion->OciId)){?> 
FncOrdenCodificacionImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" /></td>
  <td width="52%" align="center" valign="top">
  <span class="EstPlantillaTitulo"> CONSULTA TECNICA DE PN</span><br />
    <span class="EstPlantillaTituloCodigo"><?php echo $InsOrdenCodificacion->OciId;?></span>
  
  
  </td>
  <td width="28%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenCodificacionImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenCodificacionImprimirTabla">
    <tr>
      <td colspan="6" align="left" valign="top"><span class="EstOrdenCodificacionImprimirCabecera">Datos de Consulta Tecnica PN a Proveedor</span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%" align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo">&nbsp;</td>
      <td width="1%" align="left" valign="top" >&nbsp;</td>
      <td width="24%" align="left" valign="top" >&nbsp;</td>
      <td width="14%" align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">Fecha</span></td>
      <td width="1%" align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td width="45%" align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">NUM. DOCUMENTO</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->TdoNombre;?>/<?php echo $InsOrdenCodificacion->PrvNumeroDocumento;?></span></td>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">PROVEEDOR</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido">
	  
	  <?php echo $InsOrdenCodificacion->PrvNombre;?> <?php echo $InsOrdenCodificacion->PrvApellidoPaterno;?> <?php echo $InsOrdenCodificacion->PrvApellidoMaterno;?>
      
	  </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">NOMBRE DEL SOLICITANTE</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciSolicitante;?></span></td>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">CARGO  DEL SOLICITANTE</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciSolicitanteCargo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">DEALER/SUCURSAL</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciDealerSucursal;?></span></td>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">DESCRIPCION PN SOLICITADO</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciDescripcionPN;?></span></td>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">VIN</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciVIN;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">MODELO</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciVehiculoModelo;?></span></td>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">AÑO FABRICACION</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciVehiculoAnoFabricacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">MOTOR/CILINDRADA</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciVehiculoMotorCilindrada;?></span></td>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo"><span class="EstOrdenCodificacionImprimirEtiqueta">Estado</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" >
        <span class="EstOrdenCodificacionImprimirContenido">
          
          <?php echo $InsOrdenCodificacion->OciEstadoDescripcion?>
          </span></td>
      <td align="left" valign="top" class="EstOrdenCodificacionImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5" align="center"><table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="14%" align="left" valign="top"><span class="EstOrdenCodificacionImprimirEtiqueta">Observacion</span></td>
          <td width="1%" align="right" valign="top"><span class="EstOrdenCodificacionImprimirEtiqueta">:</span></td>
          <td width="85%" align="left" valign="top"><span class="EstOrdenCodificacionImprimirContenido"><?php echo $InsOrdenCodificacion->OciObservacionImpresa;?></span></td>
          </tr>
        </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="center"></td>
  </tr>

</table>

</body>
</html>
