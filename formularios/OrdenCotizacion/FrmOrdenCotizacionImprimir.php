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

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCotizacionDetalle.php');

$InsOrdenCotizacion = new ClsOrdenCotizacion();

$InsOrdenCotizacion->OotId = $GET_id;
$InsOrdenCotizacion = $InsOrdenCotizacion->MtdObtenerOrdenCotizacion();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ORDEN DE COTIZACION No. <?php echo $InsOrdenCotizacion->OotId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssOrdenCotizacion.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsOrdenCotizacionImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsOrdenCotizacion->OotId)){?> 
FncOrdenCotizacionImprimir(); 
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
  <span class="EstPlantillaTitulo">  COTIZACION</span> A PROVEEDOR<br />
    <span class="EstPlantillaTituloCodigo"><?php echo $InsOrdenCotizacion->OotId;?></span>
  
  
  </td>
  <td width="28%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenCotizacionImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenCotizacionImprimirTabla">
    <tr>
      <td colspan="6" align="left" valign="top"><span class="EstOrdenCotizacionImprimirCabecera">Datos de Cotizacion a Proveedor</span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%" align="left" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo">&nbsp;</td>
      <td width="1%" align="left" valign="top" >&nbsp;</td>
      <td width="24%" align="left" valign="top" >&nbsp;</td>
      <td width="14%" align="left" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo"><span class="EstOrdenCotizacionImprimirEtiqueta">Fecha</span></td>
      <td width="1%" align="left" valign="top" ><span class="EstOrdenCotizacionImprimirEtiqueta">:</span></td>
      <td width="45%" align="left" valign="top" ><span class="EstOrdenCotizacionImprimirContenido"><?php echo $InsOrdenCotizacion->OotFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo"><span class="EstOrdenCotizacionImprimirEtiqueta">NUM. DOCUMENTO</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCotizacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCotizacionImprimirContenido"><?php echo $InsOrdenCotizacion->TdoNombre;?>/<?php echo $InsOrdenCotizacion->PrvNumeroDocumento;?></span></td>
      <td align="left" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo"><span class="EstOrdenCotizacionImprimirEtiqueta">PROVEEDOR</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCotizacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCotizacionImprimirContenido">
	  
	  <?php echo $InsOrdenCotizacion->PrvNombre;?> <?php echo $InsOrdenCotizacion->PrvApellidoPaterno;?> <?php echo $InsOrdenCotizacion->PrvApellidoMaterno;?>
      
	  </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo"><span class="EstOrdenCotizacionImprimirEtiqueta">COTIZACION</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCotizacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCotizacionImprimirContenido"><?php echo $InsOrdenCotizacion->CprId;?></span></td>
      <td align="left" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo"><span class="EstOrdenCotizacionImprimirEtiqueta">Estado</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCotizacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" >
        <span class="EstOrdenCotizacionImprimirContenido">
          
          <?php echo $InsOrdenCotizacion->OotEstadoDescripcion?>
          </span></td>
      <td align="left" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstOrdenCotizacionImprimirTabla">
      <thead class="EstOrdenCotizacionImprimirTablaHead">
        
        <tr>
          <th width="3%" align="center" >#</th>
          <th width="10%" align="center" >
            
            Cod. Original</th>
          <th width="58%" align="center" >
            Descripcion
            
            </th>
          <th width="9%" align="center" >U.M.</th>
          <th width="10%" align="center" >AÑO</th>
          <th width="10%" align="center" >MODELO</th>
          </tr>
        
        
        </thead>
      <tbody class="EstOrdenCotizacionImprimirTablaBody">
        <?php
	
	$i=1;
	$Total = 0;
	if(!empty($InsOrdenCotizacion->OrdenCotizacionDetalle)){
		foreach($InsOrdenCotizacion->OrdenCotizacionDetalle as $DatOrdenCotizacionDetalle){


			if($InsOrdenCotizacion->MonId<>$EmpresaMonedaId){
				$DatOrdenCotizacionDetalle->OodPrecio = $DatOrdenCotizacionDetalle->OodPrecio / $InsOrdenCotizacion->OotTipoCambio;
			}else{
				$DatOrdenCotizacionDetalle->OodPrecio = $DatOrdenCotizacionDetalle->OodPrecio;
			}

			if($InsOrdenCotizacion->MonId<>$EmpresaMonedaId ){
				$DatOrdenCotizacionDetalle->OodImporte = $DatOrdenCotizacionDetalle->OodImporte / $InsOrdenCotizacion->OotTipoCambio;
			}else{
				$DatOrdenCotizacionDetalle->OodImporte = $DatOrdenCotizacionDetalle->OodImporte;
			}
			
			
			
?>
        
        <tr>
          <td align="right" class="EstOrdenCotizacionDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstOrdenCotizacionDetalleImprimirContenido" ><?php echo $DatOrdenCotizacionDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstOrdenCotizacionDetalleImprimirContenido" ><?php echo $DatOrdenCotizacionDetalle->ProNombre;?></td>
          <td align="right" class="EstOrdenCotizacionDetalleImprimirContenido" ><?php echo $DatOrdenCotizacionDetalle->UmeNombre;?></td>
          <td align="right" class="EstOrdenCotizacionDetalleImprimirContenido" ><?php echo ($DatOrdenCotizacionDetalle->OodAno);?></td>
          <td align="right" class="EstOrdenCotizacionDetalleImprimirContenido" ><?php echo ($DatOrdenCotizacionDetalle->OodModelo);?></td>
          </tr>
        <?php	
		
		
			$Total += $DatOrdenCotizacionDetalle->OodImporte;
	
	
		$i++;
		}
		
		
	} 
	
	
	


?>
        
        
        </tbody>
    </table></td>
</tr>

  <tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="11%" align="right" valign="top"><span class="EstOrdenCotizacionImprimirEtiqueta">Observacion</span></td>
          <td width="1%" align="right" valign="top"><span class="EstOrdenCotizacionImprimirEtiqueta">:</span></td>
          <td width="49%" align="left" valign="top"><span class="EstOrdenCotizacionImprimirContenido"><?php echo $InsOrdenCotizacion->OotObservacion;?></span></td>
          <td width="20%" align="right" valign="top" class="EstOrdenCotizacionImprimirEtiquetaFondo">&nbsp;</td>
          <td width="19%" align="right" valign="top" >&nbsp;</td>
          </tr>
        </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"></td>
  </tr>

</table>

</body>
</html>
