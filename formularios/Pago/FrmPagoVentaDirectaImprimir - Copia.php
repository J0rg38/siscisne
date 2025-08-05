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

require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqContabilidad() . 'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsPagoComprobante.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

$InsPago = new ClsPago();

$InsPago->PagId = $GET_id;
$InsPago->MtdObtenerPago();

	if($InsPago->MonId<>$EmpresaMonedaId ){
		$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
	}
	
$InsVentaDirecta = new ClsVentaDirecta();

$InsVentaDirecta->VdiId = $InsPago->VdiId;
$InsVentaDirecta->MtdObtenerVentaDirecta();


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,$InsVentaDirecta->VdiId,NULL,$POST_CondicionPago,$InsVentaDirecta->MonId);
$ArrPagos = $ResPago['Datos'];

$Pagos = 0;
if(!empty($ArrPagos)){
	foreach($ArrPagos as $DatPago){
		
		 $Pagos += (($EmpresaMonedaId==$InsVentaDirecta->MonId or empty($InsVentaDirecta->MonId))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));

	}
}

$InsVentaDirecta->VdiTotal = (($EmpresaMonedaId==$InsVentaDirecta->MonId or empty($InsVentaDirecta->MonId))?$InsVentaDirecta->VdiTotal:($InsVentaDirecta->VdiTotal/$InsVentaDirecta->VdiTipoCambio));

$Saldo = $InsVentaDirecta->VdiTotal - $Pagos;
?>
      


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Cobro No. <?php
echo $InsPago->PagId;
?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssPagoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsPagoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsPago->PagId)) {
?> 
FncPagoImprimir(); 
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







<?php /*if($_GET['P']<>1){ ?>
<form method="get" enctype="multipart/form-data" action="#">
<input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
<input type="hidden" name="Ta" id="Ta" value="<?php echo $GET_ta;?>" />
<input type="hidden" name="P" id="P" value="1" />

<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
	<input name="ImprimirCodigo" id="ImprimirCodigo" type="checkbox" value="1" <?php echo ($GET_ImprimirCodigo==1)?'checked="checked"':'';?>  /> Imprimir Codigos</td>
<td>&nbsp;</td>
<td>
	<input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
</td>
</tr>
</table>

</form>
<?php }*/?>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  <td align="left" valign="top">&nbsp;</td>
  </tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="3" align="left" valign="top"><img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  /></td>
  <td align="right" valign="top">&nbsp;</td>
</tr>
<tr>
  <td width="1%" align="left" valign="top">&nbsp;</td>
  <td width="34%" align="left" valign="top">&nbsp;</td>
  <td width="28%" align="center" valign="top">&nbsp;</td>
  <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
  <td width="0%" align="right" valign="top">&nbsp;</td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">


<tr>
  <td width="1%" valign="top">&nbsp;</td>
  <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPagoImprimirTabla">
    <tr>
      <td colspan="6" align="center" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPlantillaTitulo">ABONO DE ORDEN DE VENTA</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsPago->PagId;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="12%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="1%" align="left" valign="top" >&nbsp;</td>
      <td width="53%" align="left" valign="top" >&nbsp;</td>
      <td colspan="3" align="right" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">
        <?php 
list($Dia,$Mes,$Ano) = explode("/",$InsPago->PagFecha);
?>
        <?php
if ($_GET['P'] != 1) {
?>
        Tacna,
        <?php
}
?>
        &nbsp; <?php echo $Dia;?> &nbsp;
        <?php
if ($_GET['P'] != 1) {
?>
        de
        <?php
}
?>
        &nbsp; <?php echo FncConvertirMes($Mes);?> &nbsp;
        
        del
        <?php
$Digito = substr($Ano,3,1);
?>
        201<?php echo $Digito;?> </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">NUM. DOC. </span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta"> :</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstPagoImprimirContenido"><?php echo $InsVentaDirecta->TdoNombre;?>/<?php echo $InsVentaDirecta->CliNumeroDocumento;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">Cliente</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstPagoImprimirCliente">
        
        <?php echo $InsVentaDirecta->CliNombre;?>
        <?php echo $InsVentaDirecta->CliApellidoPaterno;?>
        <?php echo $InsVentaDirecta->CliApellidoMaterno;?>
        </span>
        
        
        
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  <td width="1%">&nbsp;</td>
  </tr><tr>
  <td valign="top">&nbsp;</td>
  <td colspan="2" valign="top">
   <div  class="EstCapPagoTotal">
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPagoImprimirTabla">
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">REFERENCIA</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstPagoImprimirObservacion"><?php echo $InsPago->PagReferencia;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">CONCEPTO:</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstPagoImprimirObservacion"><?php echo $InsPago->PagConcepto;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">FORMA DE PAGO:</span></td>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td width="18%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirContenido">
        <?php
	  echo ($InsPago->FpaNombre)
	  ?>
      </span></td>
      <td width="17%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">
      <?php
	  if(!empty($InsPago-> PagNumeroTransaccion)){
	?>
     <span class="EstPagoImprimirEtiqueta">NUM. TRANSAC.:</span>
      
    <?php
	  }
	  ?>
      
     
      
      </td>
      <td width="3%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">
      
      <?php
	  if(!empty($InsPago-> PagNumeroTransaccion)){
	?>
      <span class="EstPagoImprimirEtiqueta">:</span>
      
      <?php
	  }
	  ?>
      
      </td>
      <td width="14%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">
      
          <?php
	  if(!empty($InsPago-> PagNumeroTransaccion)){
	?>
      <span class="EstPagoImprimirContenido">
        <?php
	  echo ($InsPago-> PagNumeroTransaccion)
	  ?>
      </span>
       <?php
	  }
	  ?>
      
      </td>
      <td width="17%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">
      
      
          <?php
	  if(!empty($InsPago-> PagFechaTransaccion)){
	?>
      <span class="EstPagoImprimirEtiqueta">FECHA TRANSAC.</span>
       <?php
	  }
	  ?>
      
      </td>
      <td width="3%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">
      
       
          <?php
	  if(!empty($InsPago-> PagFechaTransaccion)){
	?>
      <span class="EstPagoImprimirEtiqueta">:</span>
       <?php
	  }
	  ?>
      
     
      
      
      
      </td>
      <td width="10%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">
        
        
        <?php
	  if(!empty($InsPago-> PagFechaTransaccion)){
	?>
        <span class="EstPagoImprimirContenido">
          <?php
	  echo ($InsPago->PagFechaTransaccion)
	  ?>
          </span>
        <?php
	  }
	  ?>
        
        
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">MONTO:</span></td>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td colspan="7" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirContenido">
        <?php
	  echo number_format($InsPago->PagMonto,2)
	  ?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta"> La suma de </span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td colspan="7" align="left" valign="top" ><?php
//list($parte_entero,$parte_decimal) = explode(".",$InsFactura->FacTotal);
$Total = round($InsPago->PagMonto,2);
list($parte_entero,$parte_decimal) = explode(".",$Total);

if(empty($parte_decimal)){
	$parte_decimal = 0;
}
$numalet= new CNumeroaletra;
$numalet->setNumero($parte_entero);
$numalet->setMayusculas(1);
$numalet->setGenero(1);
$numalet->setMoneda("");
$numalet->setPrefijo("");
$numalet->setSufijo("");
?>
        <span class="EstPagoImprimirContenido"> <?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100 <?php echo $InsPago->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">vendedor</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstPagoImprimirObservacion"><?php echo $InsVentaDirecta->PerNombre;?> <?php echo $InsVentaDirecta->PerApellidoPaterno;?> <?php echo $InsVentaDirecta->PerApellidoMaterno;?>
        
  <?php
if(!empty($InsVentaDirecta->PerTelefono)){
?>
        Telef.: <?php echo $InsVentaDirecta->PerTelefono;?>/
  <?php	
}
?> 
        
  <?php
if(!empty($InsVentaDirecta->PerCelular)){
?>
        Cel.: <?php echo $InsVentaDirecta->PerCelular;?>/
  <?php
}
?>   
        
  <?php
if(!empty($InsVentaDirecta->PerEmail)){
?>
        Email: <?php echo $InsVentaDirecta->PerEmail;?>/
  <?php
}
?>   
        
        
        </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">Observacion:</span></td>
      <td width="2%" align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td colspan="7" align="left" valign="top" ><span class="EstPagoImprimirObservacion"><?php echo $InsPago->PagObservacionImpresa;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
  </div>
  </td>
  <td>&nbsp;</td>
</tr>
</table>




<?php
$SaltarLineaRepuesto = false;
$SaltarLineaManoObra = false;
$SaltarLineaPlanchado = false;
$SaltarLineaPintado = false;
$SaltarLineaCentrado = false;
$SaltarLineaTarea = false;
//$SaltarLineaTotales = false;

?>

<?php
if(
	count($InsVentaDirecta->VentaDirectaDetalle) >= 30
){
	$SaltarLineaManoObra = true;
}



if(
	count($InsVentaDirecta->VentaDirectaPlanchado) >= 30
){
	$SaltarLineaPlanchado = true;
}

if(
	count($InsVentaDirecta->VentaDirectaPintado) >= 30
){
	$SaltarLineaPintado = true;
}

if(
	count($InsVentaDirecta->VentaDirectaCentrado) >= 30
){
	$SaltarLineaCentrado = true;
}


if(
	count($InsVentaDirecta->VentaDirectaTarea) >= 30
){
	$SaltarLineaTarea = true;
}
?>



<?php
if($InsVentaDirecta->VdiRepuesto == "Si"){
?> 

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">


	<tr>
		
        <td width="1%" valign="top">&nbsp;</td>
  <td width="98%" colspan="2" valign="top"><span class="EstPagoImprimirCabecera">Repuestos</span></td>
  <td width="1%" valign="top">&nbsp;</td>
</tr>
<tr>
  <td width="1%" valign="top">&nbsp;</td>
  <td colspan="2" valign="top"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstPagoImprimirTabla">
    <thead class="EstPagoImprimirTablaHead">
      <tr>
        <th width="3%" align="center" >#</th>
        <?php
		if($GET_ImprimirCodigo==1){
		?>
        <th width="21%" align="center" >Cod. Original</th>
        <?php
		}
		?>
        <th width="16%" align="center" >Cantidad</th>
        
        <th width="39%" align="center" > Nombre </th>
        <th width="10%" align="center" >Precio</th>
        <th width="11%" align="center" >Importe</th>
        </tr>
      </thead>
    <tbody class="EstPagoImprimirTablaBody">
      <?php
	
	$TotalRepuesto = 0;
	$i=1;
	if(!empty($InsVentaDirecta->VentaDirectaDetalle)){
		foreach($InsVentaDirecta->VentaDirectaDetalle as $DatVentaDirectaDetalle){

			if($DatVentaDirectaDetalle->VddEstado == 1){
		
				if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				
					$DatVentaDirectaDetalle->VddPrecioVenta = round($DatVentaDirectaDetalle->VddPrecioVenta / $InsVentaDirecta->VdiTipoCambio,2);
					$DatVentaDirectaDetalle->VddImporte = round($DatVentaDirectaDetalle->VddImporte / $InsVentaDirecta->VdiTipoCambio,2);
				
				}
				
				
				
		?>
      
      <tr>
        <td align="center" class="EstPagoDetalleImprimirContenido"><?php echo $i;?></td>
        
        <?php
				if($GET_ImprimirCodigo==1){
				?>
        <td align="right" class="EstPagoDetalleImprimirContenido" >
          
          <?php echo $DatVentaDirectaDetalle->ProCodigoOriginal;?>
          
          </td>
        
        
        <?php
				}
				?>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaDetalle->VddCantidad,2);?></td>
        
        
        
        <td align="left" class="EstPagoDetalleImprimirContenido" ><?php //echo $DatVentaDirectaDetalle->ProNombre;?>
          <?php echo $DatVentaDirectaDetalle->ProNombre;?></td>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><?php echo number_format(($DatVentaDirectaDetalle->VddPrecioVenta),2);?></td>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaDetalle->VddImporte,2);?></td>
        </tr>
      <?php	
		
					$TotalRepuesto += $DatVentaDirectaDetalle->VddImporte;
					
					
				$i++;
				
				
			}
	

			
		}
		
		
	} 
?>
      
      <?php
	
	
	


	


?> <tr>
        <td align="center" class="EstPagoDetalleImprimirContenido">&nbsp;</td>
        
         <?php
				if($GET_ImprimirCodigo==1){
				?>
        <td align="right" class="EstPagoDetalleImprimirContenido" >&nbsp;</td>
        
        <?php
				}
		?>
        <td colspan="3" align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirEtiquetaTotal">TOTAL POR REPUESTOS:</span></td>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalRepuesto,2);?></span></td>
        </tr>
      </tbody>
    </table></td>
  <td valign="top">&nbsp;</td>
</tr>

  <?php
  if($InsVentaDirecta->VdiPintado=="Si" or $InsVentaDirecta->VdiPlanchado == "Si" or $InsVentaDirecta->VdiCentrado == "Si" or $InsVentaDirecta->VdiTarea == "Si" or (!empty($InsVentaDirecta->VdiManoObra) and $InsVentaDirecta->VdiManoObra <> "0.00")){
	?>
  <?php
  }
  ?>
  

</table>

<?php
}
?>





  	<?php
    if($SaltarLineaRepuesto){
    ?>
<H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>




<?php
if(!empty($InsVentaDirecta->VdiManoObra) and $InsVentaDirecta->VdiManoObra <> "0.00"){
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">

<tr>

<td width="1%" align="center">&nbsp;</td>
<td colspan="2" align="left"><span class="EstPagoImprimirCabecera">Mano de Obra</span></td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td width="87%" align="right"><span class="EstPagoImprimirEtiquetaTotal">TOTAL POR MANO DE OBRA:</span></td>
<td width="11%" align="right">

<span class="EstPagoImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($InsVentaDirecta->VdiManoObra,2);?></span>


</td>
<td align="center">&nbsp;</td>

	</tr>
</table>
 <?php  
}
?>





     <?php
    if($SaltarLineaManoObra){
    ?>
        <H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?> 

<?php
//if($InsVentaDirecta->VdiPlanchado=="Si"){
//deb($InsVentaDirecta->VdiVerificar ." -  ".$InsVentaDirecta->VdiPlanchadoVerificado);

if( $InsVentaDirecta->VdiPlanchado == "Si"){
	
	
?>
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">
    <tr>
    
<td width="1%" align="center">&nbsp;</td>
<td width="98%" colspan="2" align="left"><span class="EstPagoImprimirCabecera">Planchado</span></td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
  <td width="1%" align="center">&nbsp;</td>
  <td colspan="2" align="center">
    
    
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstPagoImprimirTabla">
      <thead class="EstPagoImprimirTablaHead">
        <tr>
          <th width="3%" align="center" >#</th>
          
          <th width="86%" align="center" > Nombre </th>
          <th width="11%" align="center" >Importe</th>
          </tr>
        </thead>
      <tbody class="EstPagoImprimirTablaBody">
        <?php
$TotalPlanchado = 0;

$i=1;
if(!empty($InsVentaDirecta->VentaDirectaPlanchado)){
	foreach($InsVentaDirecta->VentaDirectaPlanchado as $DatVentaDirectaPlanchado){

		
			
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				
					$DatVentaDirectaPlanchado->VdtImporte = round($DatVentaDirectaPlanchado->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
				
			}
?>
        
        
        
        <tr>
          <td align="right" class="EstPagoDetalleImprimirContenido"><?php echo $i;?></td>
          
          <td align="right" class="EstPagoDetalleImprimirContenido" >
            <?php echo $DatVentaDirectaPlanchado->VdtDescripcion;?></td>
          <td align="right" class="EstPagoDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaPlanchado->VdtImporte,2);?></td>
          </tr>
        <?php	
			$TotalPlanchado += $DatVentaDirectaPlanchado->VdtImporte;
			$i++;

		}
	
} 
?> <tr>
          <td align="right" class="EstPagoDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirEtiquetaTotal">Total POR PLANCHADO:</span></td>
          <td align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalPlanchado,2);?></span></td>
          </tr>
        </tbody>
      </table>
    
    
    
    </td>
  <td width="1%" align="center">&nbsp;</td>
</tr>
</table>

<?php  
}
?>
    
    
          

	<?php
    if($SaltarLineaPlanchado){
    ?>
<H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>

<?php
//if($InsVentaDirecta->VdiPintado=="Si"){
if($InsVentaDirecta->VdiPintado == "Si" ){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">
	<tr>
    
    <td width="1%" align="center">&nbsp;</td>
    <td width="98%" colspan="2" align="left"><span class="EstPagoImprimirCabecera">Pintado</span></td>
    <td width="1%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%" align="center">&nbsp;</td>
    <td colspan="2" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstPagoImprimirTabla">
      <thead class="EstPagoImprimirTablaHead">
        <tr>
          <th width="3%" align="center" >#</th>
          
          <th width="86%" align="center" > Nombre </th>
          <th width="11%" align="center" >Importe</th>
        </tr>
      </thead>
      <tbody class="EstPagoImprimirTablaBody">
        <?php
	
	$TotalPintado = 0;
	$i=1;
	if(!empty($InsVentaDirecta->VentaDirectaPintado)){
		foreach($InsVentaDirecta->VentaDirectaPintado as $DatVentaDirectaPintado){

			
	
				if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
					
						$DatVentaDirectaPintado->VdtImporte = round($DatVentaDirectaPintado->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
					
				}
?>


        
        <tr>
          <td align="right" class="EstPagoDetalleImprimirContenido"><?php echo $i;?></td>
          
          <td align="right" class="EstPagoDetalleImprimirContenido" >
            <?php echo $DatVentaDirectaPintado->VdtDescripcion;?></td>
          <td align="right" class="EstPagoDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaPintado->VdtImporte,2);?></td>
        </tr>
        <?php	
				$TotalPintado += $DatVentaDirectaPintado->VdtImporte;
				$i++;

			

		}
		
	} 
?>
    
        <?php
	
	
	
	
	

?><tr>
          <td align="right" class="EstPagoDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirEtiquetaTotal">Total POR PINTADO:</span></td>
          <td align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalPintado,2);?></span></td>
        </tr>
        </tbody>
    </table></td>
    <td width="1%" align="center">&nbsp;</td>
  </tr>
</table>  
<?php  
}
?>
 
  

	<?php
    if($SaltarLineaPintado){
    ?>
<H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>

<?php
//if($InsVentaDirecta->VdiCentrado=="Si"){
if( $InsVentaDirecta->VdiCentrado == "Si"){
?>




<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">
	<tr>
    
<td width="1%" align="center">&nbsp;</td>
<td width="98%" colspan="2" align="left"><span class="EstPagoImprimirCabecera">Centrado</span></td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
  <td width="1%" align="center">&nbsp;</td>
  <td colspan="2" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstPagoImprimirTabla">
    <thead class="EstPagoImprimirTablaHead">
      <tr>
        <th width="3%" align="center" >#</th>
        
        <th width="86%" align="center" > Nombre </th>
        <th width="11%" align="center" >Importe</th>
        </tr>
      </thead>
    <tbody class="EstPagoImprimirTablaBody">
      <?php
$TotalCentrado = 0;

$i=1;
if(!empty($InsVentaDirecta->VentaDirectaCentrado)){
	foreach($InsVentaDirecta->VentaDirectaCentrado as $DatVentaDirectaCentrado){


//deb($DatVentaDirectaPlanchado->VdtEstado ." :::: ". $InsVentaDirecta->VdiVerificar);




		
	
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				$DatVentaDirectaCentrado->VdtImporte = round($DatVentaDirectaCentrado->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
			}
?>
      
      
      <tr>
        <td align="right" class="EstPagoDetalleImprimirContenido"><?php echo $i;?></td>
        <td align="right" class="EstPagoDetalleImprimirContenido" >
          <?php echo $DatVentaDirectaCentrado->VdtDescripcion;?></td>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaCentrado->VdtImporte,2);?></td>
        </tr>
      <?php	
			  $TotalCentrado += $DatVentaDirectaCentrado->VdtImporte;
			$i++;
		

	}

} 
?> <tr>
        <td align="right" class="EstPagoDetalleImprimirContenido">&nbsp;</td>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirEtiquetaTotal">Total POR CENTRADO:</span></td>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalCentrado,2);?></span></td>
        </tr>
      </tbody>
    </table></td>
  <td width="1%" align="center">&nbsp;</td>
</tr>
</table>
<?php  
}
?>  
  



	<?php
    if($SaltarLineaCentrado){
    ?>
<H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>

<?php
//if($InsVentaDirecta->VdiTarea=="Si"){
if($InsVentaDirecta->VdiTarea == "Si"){
?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">
	<tr>
    
<td width="1%" align="center">&nbsp;</td>
<td width="98%" colspan="2" align="left"><span class="EstPagoImprimirCabecera">Tareas/Reparacion</span></td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
  <td width="1%" align="center">&nbsp;</td>
  <td colspan="2" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstPagoImprimirTabla">
    <thead class="EstPagoImprimirTablaHead">
      <tr>
        <th width="3%" align="center" >#</th>
        
        <th width="86%" align="center" > Nombre </th>
        <th width="11%" align="center" >Importe</th>
        </tr>
      </thead>
    <tbody class="EstPagoImprimirTablaBody">
      <?php
$TotalTarea = 0;

$i=1;
if(!empty($InsVentaDirecta->VentaDirectaTarea)){
	foreach($InsVentaDirecta->VentaDirectaTarea as $DatVentaDirectaTarea){


//deb($DatVentaDirectaPlanchado->VdtEstado ." :::: ". $InsVentaDirecta->VdiVerificar);




		
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				$DatVentaDirectaTarea->VdtImporte = round($DatVentaDirectaTarea->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
			}
?>
      
      
      <tr>
        <td align="right" class="EstPagoDetalleImprimirContenido"><?php echo $i;?></td>
        <td align="right" class="EstPagoDetalleImprimirContenido" >
          <?php echo $DatVentaDirectaTarea->VdtDescripcion;?></td>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaTarea->VdtImporte,2);?></td>
        </tr>
      <?php	
			  $TotalTarea += $DatVentaDirectaTarea->VdtImporte;
			$i++;
	
	}

} 
?>  <tr>
        <td align="right" class="EstPagoDetalleImprimirContenido">&nbsp;</td>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirEtiquetaTotal">Total POR TAREAS/REPARACION:</span></td>
        <td align="right" class="EstPagoDetalleImprimirContenido" ><span class="EstPagoImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalTarea,2);?></span></td>
        </tr>
      </tbody>
    </table></td>
  <td width="1%" align="center">&nbsp;</td>
</tr>
</table>


<?php  
}
?>  

  	<?php
    if($SaltarLineaTarea){
    ?>
<H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>
    
    
    
 
 
     <?php
	 
	// deb($TotalRepuesto);



	//if($InsVentaDirecta->VdiIncluyeImpuesto == 1){
//		
//		$TotalBruto = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
//		
//		$SubTotal = $TotalBruto / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$SubTotal = $SubTotal - $InsVentaDirecta->VdiDescuento;
//		
//		$InsVentaDirecta->VdiManoObra = $InsVentaDirecta->VdiManoObra / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$TotalPlanchado = $InsVentaDirecta->VdiPlanchadoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$TotalPintado = $InsVentaDirecta->VdiPintadoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$TotalCentrado = $InsVentaDirecta->VdiCentradoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$TotalTarea = $InsVentaDirecta->VdiTareaTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		
//		
//	}else{
//
//		$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiTotalBruto - $InsVentaDirecta->VdiDescuento;
//
//	}
	
//	$SubTotal = $SubTotal + $InsVentaDirecta->VdiManoObra + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea;
//	$Impuesto = $SubTotal * ($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100);
//	$Total = $SubTotal + $Impuesto;	
	
	
	
	
	if($InsVentaDirecta->VdiIncluyeImpuesto == 1){
		
		$Total = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
		$SubTotal = $Total / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
		$Impuesto = $Total - $SubTotal;	
		
	}else{
		
		$SubTotal = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
		$Impuesto = $SubTotal * (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100));
		$Total = $SubTotal + $Impuesto;	
		
	}
	
	
	
?>


 
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">

  <tr>
    <td width="1%">&nbsp;</td>
    <td width="98%" colspan="2">
    

   
   
     <table class="EstTablaTotal" width="100%" cellpadding="1" cellspacing="1" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="854" align="right">&nbsp;</td>
          <td width="100" align="right" >&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><span class="EstPagoImprimirEtiquetaTotal">Total:</span></td>
          <td align="right"><span class="EstPagoImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($Total,2);?></span></td>
        </tr>
        <tr>
          <td align="right"><span class="EstPagoImprimirEtiquetaTotal">SALDO RESTANTE:</span></td>
          <td align="right"><span class="EstPagoImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($Saldo,2);?></span></td>
        </tr>
        </tbody>
    </table>
    
     
    
    
    
    
    </td>
    <td width="1%">&nbsp;</td>
  </tr>
</table>


<!--<div class="EstPagoPie">

        <span class="EstPagoImprimirNota2">Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        Tel&eacute;fono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe<br />
  Inscritos en los Registros P&uacute;blicos de Tacna Ficha 2986 </span>

</div>


<div class="EstPagoPieAux">

</div>   --> 



</body>
</html>
