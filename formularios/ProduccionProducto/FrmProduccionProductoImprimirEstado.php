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

require_once($InsPoo->MtdPaqLogistica().'ClsProduccionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProduccionProductoDetalle.php');

$InsProduccionProducto = new ClsProduccionProducto();

$InsProduccionProducto->PprId = $GET_id;
$InsProduccionProducto = $InsProduccionProducto->MtdObtenerProduccionProducto();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TRASLADO A ALMCEN No. <?php echo $InsProduccionProducto->PprId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssProduccionProducto.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsProduccionProductoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsProduccionProducto->PprId)){?> 
FncProduccionProductoImprimir(); 
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
  <span class="EstPlantillaTitulo">TRASLADO A ALMCEN/ESTADO</span><br />
    <span class="EstPlantillaTituloCodigo"><?php echo $InsProduccionProducto->PprId;?></span>
  
  
  </td>
  <td width="28%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstProduccionProductoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstProduccionProductoImprimirTabla">
    <tr>
      <td colspan="6" align="left" valign="top"><span class="EstProduccionProductoImprimirCabecera">Datos del Conversion de Productos</span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%" align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="1%" align="left" valign="top" >&nbsp;</td>
      <td width="24%" align="left" valign="top" >&nbsp;</td>
      <td width="14%" align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo"><span class="EstProduccionProductoImprimirEtiqueta">Fecha</span></td>
      <td width="1%" align="left" valign="top" ><span class="EstProduccionProductoImprimirEtiqueta">:</span></td>
      <td width="45%" align="left" valign="top" ><span class="EstProduccionProductoImprimirContenido"><?php echo $InsProduccionProducto->PprFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo"><span class="EstProduccionProductoImprimirEtiqueta">NUM. DOCUMENTO</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirContenido"><?php echo $InsProduccionProducto->TdoNombre;?>/<?php echo $InsProduccionProducto->CliNumeroDocumento;?></span></td>
      <td align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo"><span class="EstProduccionProductoImprimirEtiqueta">CLIENTE</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirContenido">
	  
	  <?php echo $InsProduccionProducto->CliNombre;?> <?php echo $InsProduccionProducto->CliApellidoPaterno;?> <?php echo $InsProduccionProducto->CliApellidoMaterno;?>
      
	  </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo"><span class="EstProduccionProductoImprimirEtiqueta">COTIZACION</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirContenido"><?php echo $InsProduccionProducto->CprId;?></span></td>
      <td align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo"><span class="EstProduccionProductoImprimirEtiqueta">ORD. VENTA</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirContenido"><?php echo $InsProduccionProducto->VdiId;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo"><span class="EstProduccionProductoImprimirEtiqueta">ORDEN COMPRA</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirContenido">
	  

        <?php
				  
				  if(!empty($InsProduccionProducto->OcoId)){
				?>
                <?php echo $InsProduccionProducto->OcoId;?>
                <?php
				  }else{
				?>
                No tiene orden a proveedor
                <?php	  
				  }
				  
				  ?>
                
      
      </span></td>
      <td align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo"><span class="EstProduccionProductoImprimirEtiqueta">Estado</span></td>
      <td align="left" valign="top" ><span class="EstProduccionProductoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" >
        <span class="EstProduccionProductoImprimirContenido">
          
          <?php echo $InsProduccionProducto->PprEstadoDescripcion?>
          </span></td>
      <td align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo">&nbsp;</td>
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
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstProduccionProductoImprimirTabla">
      <thead class="EstProduccionProductoImprimirTablaHead">
        
        <tr>
          <th width="3%" rowspan="2" align="center" >#</th>
          <th width="6%" rowspan="2" align="center" >
            
            Cod. Original</th>
          <th width="42%" rowspan="2" align="center" >
            Descripcion          </th>
          <th width="7%" rowspan="2" align="center" >U.M.</th>
          <th width="7%" rowspan="2" align="center" >Cantidad</th>
          <th width="6%" rowspan="2" align="center" >Importe</th>
          <th colspan="2" align="center" >Back Order</th>
          <th colspan="2" align="center" >Despacho</th>
          </tr>
        <tr>
          <th width="7%" class="EstTablaListado">Fec. Llegada GM</th>
          <th width="7%" class="EstTablaListado">Status GM</th>
          <th width="7%" class="EstTablaListado">Fecha</th>
          <th width="8%" class="EstTablaListado">Cant.</th>
          </tr>
        
        
        </thead>
      <tbody class="EstProduccionProductoImprimirTablaBody">
        <?php
	
	$i=1;
	$Total = 0;
	if(!empty($InsProduccionProducto->ProduccionProductoDetalle)){
		foreach($InsProduccionProducto->ProduccionProductoDetalle as $DatProduccionProductoDetalle){


			if($InsProduccionProducto->MonId<>$EmpresaMonedaId){
				$DatProduccionProductoDetalle->PpdPrecio = $DatProduccionProductoDetalle->PpdPrecio / $InsProduccionProducto->PprTipoCambio;
			}else{
				$DatProduccionProductoDetalle->PpdPrecio = $DatProduccionProductoDetalle->PpdPrecio;
			}

			if($InsProduccionProducto->MonId<>$EmpresaMonedaId ){
				$DatProduccionProductoDetalle->PpdImporte = $DatProduccionProductoDetalle->PpdImporte / $InsProduccionProducto->PprTipoCambio;
			}else{
				$DatProduccionProductoDetalle->PpdImporte = $DatProduccionProductoDetalle->PpdImporte;
			}
			
			
			
?>
        
        <tr>
          <td align="right" class="EstProduccionProductoDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstProduccionProductoDetalleImprimirContenido" ><?php echo $DatProduccionProductoDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstProduccionProductoDetalleImprimirContenido" ><?php echo $DatProduccionProductoDetalle->ProNombre;?></td>
          <td align="right" class="EstProduccionProductoDetalleImprimirContenido" ><?php echo $DatProduccionProductoDetalle->UmeNombre;?></td>
          <td align="right" class="EstProduccionProductoDetalleImprimirContenido" ><?php echo number_format($DatProduccionProductoDetalle->PpdCantidad,2);?></td>
          <td align="right" class="EstProduccionProductoDetalleImprimirContenido" ><?php echo number_format($DatProduccionProductoDetalle->PpdImporte,2);?></td>
          <td align="center" class="EstTablaListado" ><?php echo ($DatProduccionProductoDetalle->PpdBOFecha);?></td>
          <td align="center" class="EstTablaListado" ><?php echo ($DatProduccionProductoDetalle->PpdBOEstado);?></td>
          <td align="center" class="EstTablaListado"><?php echo ($DatProduccionProductoDetalle->PleFecha);?></td>
          <td align="center" class="EstTablaListado"><?php echo number_format($DatProduccionProductoDetalle->PldCantidad,2);?></td>
          </tr>
        <?php	
		
		
			$Total += $DatProduccionProductoDetalle->PpdImporte;
	
	
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
          <td width="11%" align="right" valign="top"><span class="EstProduccionProductoImprimirEtiqueta">Observacion</span></td>
          <td width="1%" align="right" valign="top"><span class="EstProduccionProductoImprimirEtiqueta">:</span></td>
          <td width="49%" align="left" valign="top"><span class="EstProduccionProductoImprimirContenido"><?php echo $InsProduccionProducto->PprObservacion;?></span></td>
          <td width="20%" align="right" valign="top" class="EstProduccionProductoImprimirEtiquetaFondo"><span class="EstProduccionProductoImprimirEtiquetaTotal">Total:</span></td>
          <td width="19%" align="right" valign="top" ><span class="EstMonedaSimbolo"><?php
echo $InsProduccionProducto->MonSimbolo;
?></span> <span class="EstProduccionProductoImprimirContenidoTotal"><?php
echo number_format($Total, 2);
?></span></td>
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
