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
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoIngresoEventoDetalle.php');
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
  <td colspan="3" align="left" valign="top"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top">
  
		<img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
        
        
    </td>
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">INSTALACION DE ACCESORIOS
  <br /><?php echo $InsVehiculoIngresoEvento->VieId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoIngresoEventoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoIngresoEventoImprimirTabla">
    <tr>
      <td width="24%" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta"> Fecha de INSTALACION:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->VieFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta">Aprobado por</span></td>
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
      <td colspan="5" align="left" valign="top" class="EstVehiculoIngresoEventoImprimirCabecera">Datos del Vehiculo y/o Cliente</td>
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
    <tr>
      <td align="left" valign="top" class="EstVehiculoIngresoEventoImprimirEtiquetaFondo"><span class="EstVehiculoIngresoEventoImprimirEtiqueta">CLIENTE:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->CliNombre;?></span> <span class="EstVehiculoIngresoEventoImprimirContenido"><?php echo $InsVehiculoIngresoEvento->CliApellidoPaterno;?><?php echo $InsVehiculoIngresoEvento->MonNombre;?></span></td>
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
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVehiculoIngresoEventoImprimirTabla">
      <thead class="EstVehiculoIngresoEventoImprimirTablaHead">
        
        <tr>
          <th width="6%" align="center" >#</th>
          <th width="6%" align="center" >
            
            Id</th>
          <th width="13%" align="center" >Cod. Original</th>
          <th width="50%" align="center" >
            Descripcion
            
            </th>
          <th width="12%" align="center" >U.M.</th>
          <th width="13%" align="center" >Cantidad</th>
          </tr>
        
        
        </thead>
      <tbody class="EstVehiculoIngresoEventoImprimirTablaBody">
        <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsVehiculoIngresoEvento->VehiculoIngresoEventoDetalle)){
		
		foreach($InsVehiculoIngresoEvento->VehiculoIngresoEventoDetalle as $DatVehiculoIngresoEventoDetalle){

			
?>
        
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoIngresoEventoDetalle->ProId;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoIngresoEventoDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoIngresoEventoDetalle->ProNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoIngresoEventoDetalle->UmeNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatVehiculoIngresoEventoDetalle->VsdCantidad,2);?></td>
          </tr>
        <?php	
	
		
		$i++;
		}
	} 
	
	



?>
        
        
        </tbody>
      </table>
    
    
    
    
    </td>
</tr>
</table>
 
</body>
</html>
