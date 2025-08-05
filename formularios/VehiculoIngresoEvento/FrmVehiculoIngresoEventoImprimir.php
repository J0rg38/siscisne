<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta      = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes() . 'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases() . 'ClsSesion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMensaje.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones() . 'ClsConexion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones() . 'FncGeneral.php');

$GET_id = $_GET['Id'];
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoIngresoEvento.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsVehiculoIngresoEvento = new ClsVehiculoIngresoEvento();

$InsVehiculoIngresoEvento->VieId = $GET_id;
$InsVehiculoIngresoEvento = $InsVehiculoIngresoEvento->MtdObtenerVehiculoIngresoEvento();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Incidente  No. 
<?php echo $InsVehiculoIngresoEvento->VieId;?>
</title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssVehiculoIngresoEventoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVehiculoIngresoEventoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsVehiculoIngresoEvento->VieId)) {
?> 
FncVehiculoIngresoEventoImprimir(); 
<?php
}
?>

<?php
if ($_GET['P'] == 1) {
?>
	setTimeout("window.close();",1500);
<?php
}
?>
	
});
</script>

</head>
<body>

<?php
if ($_GET['P'] <> 1) {
?>

<form method="get" enctype="multipart/form-data" action="#">
	<input type="hidden" name="Id" id="Id" value="<?php
    echo $GET_id;
?>" />
	<input type="hidden" name="P" id="P" value="1" />
    <table cellpadding="0" cellspacing="0" border="0">
    <tr>
    <td>
    </td>
    <td>&nbsp;</td>
    <td>
        <input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
    </td>
    </tr>
    </table>
</form>

<?php
}
?>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top">
  
		<img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
        
        
    </td>
  <td width="52%" align="center" valign="top"><span class="EstPlantillaTitulo">INCIDENTE<br /><?php echo $InsVehiculoIngresoEvento->VieId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoIngresoEventoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoIngresoEventoImprimirTabla">
    <tr>
      <td width="24%" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta"> Fecha de Incidente:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->VieFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta">Reportado por:</span></td>
      <td width="29%" align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->PerNombre;?></span><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->PerApellidoPaterno;?></span><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->PerApellidoMaterno;?></span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstVehiculoIngresoEventoImprimirContenido">
          
          <?php echo $InsVehiculoIngresoEvento->VieEstadoDescripcion;?>
          <?php
		/*switch($InsVehiculoIngresoEvento->VieEstado){
			case 1:
	?>
         Pendiente
          <?php
			break;
						
			case 3:
	?>
          Realizado
          <?php
			break;
		}*/
	?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  

<tr>
  <td colspan="5" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoIngresoEventoImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirCabecera">Datos del Vehiculo</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta"> VIN:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->EinVIN;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta">PLACA:</span></td>
      <td width="29%" align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->EinPlaca;?></span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta">MARCA:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->VmaNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta">MODELO:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->VmoNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta">VERSION:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->VveNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
    
    
    
    
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoIngresoEventoImprimirTabla">
      <tr>
        <td colspan="3" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirCabecera">Datos de la Instalación</td>
        </tr>
      <tr>
        <td width="19%" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta"> RefERENCIA:</span></td>
        <td width="78%" align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->VieReferencia;?></span></td>
        <td width="3%" align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta">OBSERVACIONES:</span></td>
        <td align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->VieObservacionInterna;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
    
    
    
    
    
    </td>
</tr>
</table>
 
</body>
</html>
