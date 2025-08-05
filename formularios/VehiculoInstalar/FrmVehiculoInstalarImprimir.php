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
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoInstalar.php');
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoInstalarDetalle.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsVehiculoInstalar = new ClsVehiculoInstalar();

$InsVehiculoInstalar->VisId = $GET_id;
$InsVehiculoInstalar = $InsVehiculoInstalar->MtdObtenerVehiculoInstalar();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Instalacion de Accesorios  No. 
<?php echo $InsVehiculoInstalar->VisId;?>
</title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssVehiculoInstalarImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVehiculoInstalarImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsVehiculoInstalar->VisId)) {
?> 
FncVehiculoInstalarImprimir(); 
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
  <br /><?php echo $InsVehiculoInstalar->VisId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoInstalarImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoInstalarImprimirTabla">
    <tr>
      <td width="24%" align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta"> Fecha de INSTALACION:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->VisFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta">Aprobado por</span></td>
      <td width="29%" align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->PerNombre;?></span><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->PerApellidoPaterno;?></span><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->PerApellidoMaterno;?></span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstVehiculoInstalarImprimirContenido">
          
          <?php echo $InsVehiculoInstalar->VisEstadoDescripcion;?>
          <?php
		/*switch($InsVehiculoInstalar->VisEstado){
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
      <td align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  

<tr>
  <td colspan="5" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoInstalarImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top" class="EstVehiculoInstalarImprimirCabecera">Datos del Vehiculo y/o Cliente</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta"> VIN:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->EinVIN;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta">PLACA:</span></td>
      <td width="29%" align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->EinPlaca;?></span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta">MARCA:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->VmaNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta">MODELO:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->VmoNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta">VERSION:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->VveNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta">CLIENTE:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->CliNombre;?></span> <span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->CliApellidoPaterno;?><?php echo $InsVehiculoInstalar->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
</tr>
<tr>
  <td colspan="5" valign="top">
  
  
  
  
  
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoInstalarImprimirTabla">
    <tr>
      <td colspan="3" align="left" valign="top" class="EstVehiculoInstalarImprimirCabecera">Datos de la Instalación</td>
      </tr>
    <tr>
      <td width="19%" align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta"> RefERENCIA:</span></td>
      <td width="78%" align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->VisReferencia;?></span></td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoInstalarImprimirEtiquetaFondo"><span class="EstVehiculoInstalarImprimirEtiqueta">OBSERVACIONES:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoInstalarImprimirContenido"><?php echo $InsVehiculoInstalar->VisObservacionInterna;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
    
    
    
    
    
    </td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVehiculoInstalarImprimirTabla">
      <thead class="EstVehiculoInstalarImprimirTablaHead">
        
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
      <tbody class="EstVehiculoInstalarImprimirTablaBody">
        <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsVehiculoInstalar->VehiculoInstalarDetalle)){
		
		foreach($InsVehiculoInstalar->VehiculoInstalarDetalle as $DatVehiculoInstalarDetalle){

			
?>
        
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoInstalarDetalle->ProId;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoInstalarDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoInstalarDetalle->ProNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoInstalarDetalle->UmeNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatVehiculoInstalarDetalle->VsdCantidad,2);?></td>
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
