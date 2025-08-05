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

require_once($InsPoo->MtdPaqAlmacen() . 'ClsTrasladoAlmacenSalida.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsTrasladoAlmacenSalidaDetalle.php');

$InsTrasladoAlmacenSalida = new ClsTrasladoAlmacenSalida();

$InsTrasladoAlmacenSalida->TasId = $GET_id;
$InsTrasladoAlmacenSalida        = $InsTrasladoAlmacenSalida->MtdObtenerTrasladoAlmacenSalida();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PEDIDO DE COMPRA No. <?php echo $InsTrasladoAlmacenSalida->TasId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssTrasladoAlmacenSalidaImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsTrasladoAlmacenSalidaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsTrasladoAlmacenSalida->TasId)){?> 
FncTrasladoAlmacenSalidaImprimir(); 
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
  <span class="EstPlantillaTitulo">TRANSFERENCIA DE ALMACEN - SALIDA</span><br />
    <span class="EstPlantillaTituloCodigo"><?php echo $InsTrasladoAlmacenSalida->TasId;?></span>
  
  
  </td>
  <td width="28%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTrasladoAlmacenSalidaImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstTrasladoAlmacenSalidaImprimirTabla">
    <tr>
      <td colspan="6" align="left" valign="top"><span class="EstTrasladoAlmacenSalidaImprimirCabecera">Datos de la transferencia</span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="20%" align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">Fecha</span></td>
      <td width="1%" align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
      <td width="29%" align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirContenido"><?php echo $InsTrasladoAlmacenSalida->TasFecha;?></span></td>
      <td width="13%" align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="1%" align="left" valign="top" >&nbsp;</td>
      <td width="34%" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">Almacen Origen</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirContenido"> <?php echo $InsTrasladoAlmacenSalida->AlmNombre?></span></td>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">Almacen Destino</span></td>
      <td align="left" valign="top" ><p>:</p></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirContenido"><?php echo $InsTrasladoAlmacenSalida->AlmNombreDestino?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">RESPONSABLE</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirContenido"> <?php echo $InsTrasladoAlmacenSalida->PerNombre;?> <?php echo $InsTrasladoAlmacenSalida->PerApellidoMaterno;?> <?php echo $InsTrasladoAlmacenSalida->PerApellidoMaterno;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirCabecera">Datos de despacho</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">Empresa de Transportes</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirContenido"> <?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporte;?></span></td>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">Doc. Ref.</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirContenido"> <?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporteDocumento;?></span></td>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">FECHA Doc. Ref.</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirContenido"> <?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporteFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">TIPO DE ENVIO</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirContenido"> <?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporteTipoEnvio;?></span></td>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">CLAVE DE ENVIO</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirContenido"> <?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporteClave;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">Estado</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" >
        <span class="EstTrasladoAlmacenSalidaImprimirContenido">
          
          <?php echo $InsTrasladoAlmacenSalida->TasEstadoDescripcion?>
          </span></td>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenSalidaImprimirEtiquetaFondo">&nbsp;</td>
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
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstTrasladoAlmacenSalidaImprimirTabla">
      <thead class="EstTrasladoAlmacenSalidaImprimirTablaHead">
        
        <tr>
          <th width="3%" align="center" >#</th>
          <th width="10%" align="center" >
            
            Cod. Original</th>
          <th width="58%" align="center" >
            Descripcion
            
            </th>
          <th width="9%" align="center" >U.M.</th>
          <th width="10%" align="center" >Cantidad</th>
          </tr>
        
        
        </thead>
      <tbody class="EstTrasladoAlmacenSalidaImprimirTablaBody">
        <?php
	
	$i=1;
	$Total = 0;
	if(!empty($InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle)){
		foreach($InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle as $DatTrasladoAlmacenSalidaDetalle){

?>
        
        <tr>
          <td align="right" class="EstTrasladoAlmacenSalidaDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstTrasladoAlmacenSalidaDetalleImprimirContenido" ><?php echo $DatTrasladoAlmacenSalidaDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstTrasladoAlmacenSalidaDetalleImprimirContenido" ><?php echo $DatTrasladoAlmacenSalidaDetalle->ProNombre;?></td>
          <td align="right" class="EstTrasladoAlmacenSalidaDetalleImprimirContenido" ><?php echo $DatTrasladoAlmacenSalidaDetalle->UmeNombre;?></td>
          <td align="right" class="EstTrasladoAlmacenSalidaDetalleImprimirContenido" ><?php echo number_format($DatTrasladoAlmacenSalidaDetalle->TsdCantidad,2);?></td>
          </tr>
        <?php	
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
          <td width="22%" align="right" valign="top"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">Observacion</span></td>
          <td width="3%" align="right" valign="top"><span class="EstTrasladoAlmacenSalidaImprimirEtiqueta">:</span></td>
          <td width="75%" align="left" valign="top"><span class="EstTrasladoAlmacenSalidaImprimirContenido"><?php echo $InsTrasladoAlmacenSalida->TasObservacion;?></span></td>
          </tr>
        </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="left"><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="5" align="center"></td>
  </tr>

</table>

</body>
</html>
