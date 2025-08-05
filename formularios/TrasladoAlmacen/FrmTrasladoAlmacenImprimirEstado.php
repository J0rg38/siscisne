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

require_once($InsPoo->MtdPaqLogistica().'ClsTrasladoAlmacen.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTrasladoAlmacenDetalle.php');

$InsTrasladoAlmacen = new ClsTrasladoAlmacen();

$InsTrasladoAlmacen->TalId = $GET_id;
$InsTrasladoAlmacen = $InsTrasladoAlmacen->MtdObtenerTrasladoAlmacen();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TRASLADO A ALMCEN No. <?php echo $InsTrasladoAlmacen->TalId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssTrasladoAlmacen.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsTrasladoAlmacenImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsTrasladoAlmacen->TalId)){?> 
FncTrasladoAlmacenImprimir(); 
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
    <span class="EstPlantillaTituloCodigo"><?php echo $InsTrasladoAlmacen->TalId;?></span>
  
  
  </td>
  <td width="28%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTrasladoAlmacenImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstTrasladoAlmacenImprimirTabla">
    <tr>
      <td colspan="6" align="left" valign="top"><span class="EstTrasladoAlmacenImprimirCabecera">Datos del Transferencia entre Almacenes</span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%" align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo">&nbsp;</td>
      <td width="1%" align="left" valign="top" >&nbsp;</td>
      <td width="24%" align="left" valign="top" >&nbsp;</td>
      <td width="14%" align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenImprimirEtiqueta">Fecha</span></td>
      <td width="1%" align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirEtiqueta">:</span></td>
      <td width="45%" align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirContenido"><?php echo $InsTrasladoAlmacen->TalFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenImprimirEtiqueta">NUM. DOCUMENTO</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirContenido"><?php echo $InsTrasladoAlmacen->TdoNombre;?>/<?php echo $InsTrasladoAlmacen->CliNumeroDocumento;?></span></td>
      <td align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenImprimirEtiqueta">CLIENTE</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirContenido">
	  
	  <?php echo $InsTrasladoAlmacen->CliNombre;?> <?php echo $InsTrasladoAlmacen->CliApellidoPaterno;?> <?php echo $InsTrasladoAlmacen->CliApellidoMaterno;?>
      
	  </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenImprimirEtiqueta">COTIZACION</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirContenido"><?php echo $InsTrasladoAlmacen->CprId;?></span></td>
      <td align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenImprimirEtiqueta">ORD. VENTA</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirContenido"><?php echo $InsTrasladoAlmacen->VdiId;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenImprimirEtiqueta">ORDEN COMPRA</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirContenido">
	  

        <?php
				  
				  if(!empty($InsTrasladoAlmacen->OcoId)){
				?>
                <?php echo $InsTrasladoAlmacen->OcoId;?>
                <?php
				  }else{
				?>
                No tiene orden a proveedor
                <?php	  
				  }
				  
				  ?>
                
      
      </span></td>
      <td align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenImprimirEtiqueta">Estado</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoAlmacenImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" >
        <span class="EstTrasladoAlmacenImprimirContenido">
          
          <?php echo $InsTrasladoAlmacen->TalEstadoDescripcion?>
          </span></td>
      <td align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo">&nbsp;</td>
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
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstTrasladoAlmacenImprimirTabla">
      <thead class="EstTrasladoAlmacenImprimirTablaHead">
        
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
      <tbody class="EstTrasladoAlmacenImprimirTablaBody">
        <?php
	
	$i=1;
	$Total = 0;
	if(!empty($InsTrasladoAlmacen->TrasladoAlmacenDetalle)){
		foreach($InsTrasladoAlmacen->TrasladoAlmacenDetalle as $DatTrasladoAlmacenDetalle){


			if($InsTrasladoAlmacen->MonId<>$EmpresaMonedaId){
				$DatTrasladoAlmacenDetalle->TadPrecio = $DatTrasladoAlmacenDetalle->TadPrecio / $InsTrasladoAlmacen->TalTipoCambio;
			}else{
				$DatTrasladoAlmacenDetalle->TadPrecio = $DatTrasladoAlmacenDetalle->TadPrecio;
			}

			if($InsTrasladoAlmacen->MonId<>$EmpresaMonedaId ){
				$DatTrasladoAlmacenDetalle->TadImporte = $DatTrasladoAlmacenDetalle->TadImporte / $InsTrasladoAlmacen->TalTipoCambio;
			}else{
				$DatTrasladoAlmacenDetalle->TadImporte = $DatTrasladoAlmacenDetalle->TadImporte;
			}
			
			
			
?>
        
        <tr>
          <td align="right" class="EstTrasladoAlmacenDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstTrasladoAlmacenDetalleImprimirContenido" ><?php echo $DatTrasladoAlmacenDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstTrasladoAlmacenDetalleImprimirContenido" ><?php echo $DatTrasladoAlmacenDetalle->ProNombre;?></td>
          <td align="right" class="EstTrasladoAlmacenDetalleImprimirContenido" ><?php echo $DatTrasladoAlmacenDetalle->UmeNombre;?></td>
          <td align="right" class="EstTrasladoAlmacenDetalleImprimirContenido" ><?php echo number_format($DatTrasladoAlmacenDetalle->TadCantidad,2);?></td>
          <td align="right" class="EstTrasladoAlmacenDetalleImprimirContenido" ><?php echo number_format($DatTrasladoAlmacenDetalle->TadImporte,2);?></td>
          <td align="center" class="EstTablaListado" ><?php echo ($DatTrasladoAlmacenDetalle->TadBOFecha);?></td>
          <td align="center" class="EstTablaListado" ><?php echo ($DatTrasladoAlmacenDetalle->TadBOEstado);?></td>
          <td align="center" class="EstTablaListado"><?php echo ($DatTrasladoAlmacenDetalle->PleFecha);?></td>
          <td align="center" class="EstTablaListado"><?php echo number_format($DatTrasladoAlmacenDetalle->PldCantidad,2);?></td>
          </tr>
        <?php	
		
		
			$Total += $DatTrasladoAlmacenDetalle->TadImporte;
	
	
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
          <td width="11%" align="right" valign="top"><span class="EstTrasladoAlmacenImprimirEtiqueta">Observacion</span></td>
          <td width="1%" align="right" valign="top"><span class="EstTrasladoAlmacenImprimirEtiqueta">:</span></td>
          <td width="49%" align="left" valign="top"><span class="EstTrasladoAlmacenImprimirContenido"><?php echo $InsTrasladoAlmacen->TalObservacion;?></span></td>
          <td width="20%" align="right" valign="top" class="EstTrasladoAlmacenImprimirEtiquetaFondo"><span class="EstTrasladoAlmacenImprimirEtiquetaTotal">Total:</span></td>
          <td width="19%" align="right" valign="top" ><span class="EstMonedaSimbolo"><?php
echo $InsTrasladoAlmacen->MonSimbolo;
?></span> <span class="EstTrasladoAlmacenImprimirContenidoTotal"><?php
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
