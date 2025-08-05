<?php
session_start();
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

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoVehiculoDetalle.php');

$InsTrasladoVehiculo = new ClsTrasladoVehiculo();

$InsTrasladoVehiculo->TveId = $GET_id;
$InsTrasladoVehiculo->MtdObtenerTrasladoVehiculo();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Traslado de Vehiculo No.<?php echo $InsTrasladoVehiculo->TveId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssTrasladoVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsTrasladoVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsTrasladoVehiculo->TveId)){?> 
FncTrasladoVehiculoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>

<?php
if ($_GET['P'] <> 1) {
?>

<form method="get" enctype="multipart/form-data" action="#">
	<input type="hidden" name="Id" id="Id" value="<?php   echo $GET_id;?>" />
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
  <td colspan="3" align="left" valign="top"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top">
  
		<img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
        
        </td>
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">TRASLADO DE VEHICULO
  <br /><?php echo $InsTrasladoVehiculo->TveId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTrasladoVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstTrasladoVehiculoImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstTrasladoVehiculoImprimirCabecera">Datos de la Traslado de Vehiculo</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstTrasladoVehiculoImprimirEtiquetaFondo"><span class="EstTrasladoVehiculoImprimirEtiqueta"> Fecha de Traslado:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstTrasladoVehiculoImprimirContenido"><?php echo $InsTrasladoVehiculo->TveFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstTrasladoVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoVehiculoImprimirEtiquetaFondo"><span class="EstTrasladoVehiculoImprimirEtiqueta"> Referencia:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoVehiculoImprimirContenido"><?php echo $InsTrasladoVehiculo->TveReferencia;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstTrasladoVehiculoImprimirEtiquetaFondo"><span class="EstTrasladoVehiculoImprimirEtiqueta">Responsable:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoVehiculoImprimirContenido"><?php echo $InsTrasladoVehiculo->PerNombre;?> <?php echo $InsTrasladoVehiculo->PerApellidoPaterno;?> <?php echo $InsTrasladoVehiculo->PerApellidoMaterno;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoVehiculoImprimirEtiquetaFondo"><span class="EstTrasladoVehiculoImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstTrasladoVehiculoImprimirContenido">
        
         <?php echo $InsTrasladoVehiculo->TveEstadoDescripcion;?>
          <?php
		/*switch($InsTrasladoVehiculo->TveEstado){
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
      <td align="left" valign="top" class="EstTrasladoVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoVehiculoImprimirEtiquetaFondo"><span class="EstTrasladoVehiculoImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstTrasladoVehiculoImprimirContenido"><?php echo $InsTrasladoVehiculo->TveObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstTrasladoVehiculoImprimirTabla">
      <thead class="EstTrasladoVehiculoImprimirTablaHead">
        
        <tr>
          <th width="4%" align="center" >#</th>
          <th width="4%" align="center" >
            
            VIN</th>
          <th width="24%" align="center" >Marca</th>
          <th width="20%" align="center" >Modelo</th>
          <th width="23%" align="center" >
            Version</th>
          <th width="13%" align="center" >Color Exterior</th>
          <th width="13%" align="center" >Color Interior</th>
          <th width="13%" align="center" >Año/Fab.</th>
          <th width="13%" align="center" >Año/Mod.</th>
          <th width="13%" align="center" >U.M.</th>
          <th width="7%" align="center" >Cantidad</th>
          </tr>
        
        
        </thead>
      <tbody class="EstTrasladoVehiculoImprimirTablaBody">
        <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsTrasladoVehiculo->TrasladoVehiculoDetalle)){
		
		foreach($InsTrasladoVehiculo->TrasladoVehiculoDetalle as $DatTrasladoVehiculoDetalle){


			
			
			
?>
        
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoVehiculoDetalle->EinVIN;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoVehiculoDetalle->VmaNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoVehiculoDetalle->VmoNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoVehiculoDetalle->VveNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoVehiculoDetalle->EinColor;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoVehiculoDetalle->EinColorInterior;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoVehiculoDetalle->EinAnoFabricacion;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoVehiculoDetalle->EinAnoModelo;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoVehiculoDetalle->UmeNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatTrasladoVehiculoDetalle->TvdCantidad,2);?></td>
          </tr>
        <?php	
	
		$i++;
		}
	} 
	


?>
        
        
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right" >&nbsp;</td>
          <td align="right" >&nbsp;</td>
          <td align="right" >&nbsp;</td>
          <td align="right" >&nbsp;</td>
          <td align="right" >&nbsp;</td>
          <td align="right" >&nbsp;</td>
          <td align="right" >&nbsp;</td>
          <td align="right" >&nbsp;</td>
          <td align="right" >&nbsp;</td>
          <td align="right" >&nbsp;</td>
          </tr>
        
        
        </tbody>
      </table>
    
    
    
    
    </td>
</tr>

  <tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="5">
  
  
  <table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="21%" align="left">&nbsp;</td>
  <td width="39%" align="left">&nbsp;</td>
  <td width="18%" align="right" class="EstTrasladoVehiculoImprimirEtiquetaFondo">&nbsp;</td>
  <td width="22%" align="right" class="EstTrasladoVehiculoImprimirContenidoTotal">&nbsp;</td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
