<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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
$GET_ImprimirCodigo = $_GET['ImprimirCodigo'];
$GET_ImprimirPedido = $_GET['ImprimirPedido'];

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsCotizacionProducto = new ClsCotizacionProducto();

$InsCotizacionProducto->CprId = $GET_id;
$InsCotizacionProducto->MtdObtenerCotizacionProducto();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cotizacion No. <?php echo $InsCotizacionProducto->CprId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssCotizacionProductoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsCotizacionProductoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsCotizacionProducto->CprId)){?> 
FncCotizacionProductoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>
<?php if($_GET['P']<>1){ ?>
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
<?php }?>



<!--
<hr class="EstPlantillaLinea">-->



<div class="EstCotizacionProductoCabecera">

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

</div>


<div class="EstCotizacionProductoCabeceraAux">

</div>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionProductoImprimirTabla">

<!--<tr>
  <td height="70" valign="top">&nbsp;</td>
  <td height="70" colspan="2" valign="top">&nbsp;</td>
  <td height="70">&nbsp;</td>
</tr>-->
<tr>
  <td width="1%" valign="top">&nbsp;</td>
  <td width="98%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="2" class="EstCotizacionProductoImprimirTabla">
    <tr>
      <td colspan="6" align="center" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">
      
      <span class="EstPlantillaTitulo">COTIZACION </span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsCotizacionProducto->CprId;?></span>
        
        </td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td width="12%" align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="3%" align="left" valign="top" >&nbsp;</td>
      <td width="28%" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">Fecha </span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirFecha"><?php echo $InsCotizacionProducto->CprFecha;?></span></td>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="9%" align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">
      
      
<?php
if(!empty($InsCotizacionProducto->CliIdSeguro)){
?>
<span class="EstCotizacionProductoImprimirEtiqueta">Seguro:</span>
<?php
}
?>   
      
      </td>
      <td width="4%" align="left" valign="top" >
      

<?php
if(!empty($InsCotizacionProducto->CliIdSeguro)){
?>
<span class="EstCotizacionProductoImprimirEtiqueta">:</span>
<?php
}
?>  


</td>
      <td width="41%" align="left" valign="top" >
      
      
<?php
if(!empty($InsCotizacionProducto->CliIdSeguro)){
?>
<span class="EstCotizacionProductoImprimirContenido"><?php echo $InsCotizacionProducto->CliNombreSeguro;?> <?php echo $InsCotizacionProducto->CliApellidoPaternoSeguro;?> <?php echo $InsCotizacionProducto->CliApellidoMaternoSeguro;?>
</span>
<?php
}
?>
      
      
      </td>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">Cliente</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta">:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstCotizacionProductoImprimirCliente"><?php echo $InsCotizacionProducto->CliNombre;?> <?php echo $InsCotizacionProducto->CliApellidoPaterno;?> <?php echo $InsCotizacionProducto->CliApellidoMaterno;?></span>
        <?php
	  if(!empty($InsCotizacionProducto->CprRepresentante)){
		?>
        <br />
        <span class="EstCotizacionProductoImprimirRepresentante"><?php echo $InsCotizacionProducto->CprRepresentante;?></span>
        <?php
	  }
	  ?>
        <?php
	  /*if(!empty($InsCotizacionProducto->CprAsegurado)){
		?>
		      <br /><span class="EstCotizacionProductoImprimirRepresentante">Asegurado: <?php echo $InsCotizacionProducto->CprAsegurado;?>        </span>
        <?php
	  }*/
	  ?></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">NUM. DOC. </span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirContenido"><?php echo $InsCotizacionProducto->TdoNombre;?>/<?php echo $InsCotizacionProducto->CliNumeroDocumento;?></span></td>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">MARCA </span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirContenido"><?php echo $InsCotizacionProducto->CprMarca;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">celular </span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirContenido"><?php echo $InsCotizacionProducto->CprTelefono;?></span></td>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">MODELO </span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirContenido"><?php echo $InsCotizacionProducto->CprModelo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">Email </span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirContenido"><?php echo $InsCotizacionProducto->CprEmail;?></span></td>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">VIN </span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirContenido"><?php echo $InsCotizacionProducto->EinVIN;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">PLACA </span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirContenido"><?php echo $InsCotizacionProducto->CprPlaca;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">AÑO </span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstCotizacionProductoImprimirContenido"><?php echo $InsCotizacionProducto->CprAnoModelo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  <td width="1%">&nbsp;</td>
  </tr>
  
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top"><hr class="EstPlantillaLinea" /></td>
  <td valign="top">&nbsp;</td>
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


//
//if($InsCotizacionProducto->CprRepuesto == "SI"){
//	
//	if(count($InsCotizacionProducto->CotizacionProductoDetalle)>20){
//		
//	}
//	
//}
//
//if($InsCotizacionProducto->CprPlanchado == "SI"){
//
//	if(count($InsCotizacionProducto->CotizacionProductoPlanchado)>20){
//		
//	}
//	
//}
//
//if($InsCotizacionProducto->CprPintado == "SI"){
//
//	if(count($InsCotizacionProducto->CotizacionProductoPintado)>20){
//		
//	}
//	
//}
//
//if($InsCotizacionProducto->CprCentrado == "SI"){
//
//	if(count($InsCotizacionProducto->CotizacionProductoCentrado)>20){
//		
//	}
//	
//}
?>

<?php
if(
	count($InsCotizacionProducto->CotizacionProductoDetalle) >= 30
){
	$SaltarLineaManoObra = true;
}



if(
	count($InsCotizacionProducto->CotizacionProductoPlanchado) >= 30
){
	$SaltarLineaPlanchado = true;
}

if(
	count($InsCotizacionProducto->CotizacionProductoPintado) >= 30
){
	$SaltarLineaPintado = true;
}

if(
	count($InsCotizacionProducto->CotizacionProductoCentrado) >= 30
){
	$SaltarLineaCentrado = true;
}


if(
	count($InsCotizacionProducto->CotizacionProductoTarea) >= 30
){
	$SaltarLineaTarea = true;
}
?>

<?php
//	deb($InsCotizacionProducto->CotizacionProductoDetalle);
?>

<?php
//deb($InsCotizacionProducto->CprVerificar." - ".$InsCotizacionProducto->CprRepuesto);

//deb($InsCotizacionProducto->CprVerificar." - ".$InsCotizacionProducto->CprRepuestoVerificado);

if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprRepuesto == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprRepuestoVerificado== "Si" ) ){
?> 

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionProductoImprimirTabla">


	<tr>
		
        <td width="3" valign="top">&nbsp;</td>
  <td colspan="3" align="center" valign="top"><span class="EstCotizacionProductoImprimirCabecera">Repuestos</span></td>
  <td width="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td colspan="3" valign="top"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstCotizacionProductoImprimirTabla">
    <thead class="EstCotizacionProductoImprimirTablaHead">
      <tr>
        <th width="30" align="center" valign="middle" >Item</th>
        <?php
		if($GET_ImprimirPedido==1){
		?>
        <th width="50" align="center" valign="middle" >TIPO</th>
        <?php
		}
		?>
        
        <?php
		if($GET_ImprimirCodigo==1){
		?>
        <th width="50" align="center" valign="middle" >CODIGO</th>
        <?php
		}
		?>
        <th width="65" align="center" valign="middle" >CANT.</th>
        <th width="51" align="center" valign="middle" >UND.</th>
        <th width="439" align="center" valign="middle" >DESCRIPCION </th>
        <th width="76" align="center" valign="middle" >P/UNIT</th>
        <th width="79" align="center" valign="middle" >P/TOTAL</th>
        <?php
//if(!empty($InsCotizacionProducto->CprPorcentajeDescuento ) and $InsCotizacionProducto->CprPorcentajeDescuento <> 0.00 and $InsCotizacionProducto->CprPorcentajeDescuento <> "0.00"){
?>
        
        <th width="79" align="center" valign="middle" >DSCTO.</th>
        <th width="79" align="center" valign="middle" >P/ FINAL</th>
        <?php
//}
  ?>
        </tr>
      </thead>
    <tbody class="EstCotizacionProductoImprimirTablaBody">
      <?php


	$TotalRepuesto = 0;
	$TotalDescuento = 0;
	
	$i=1;
	if(!empty($InsCotizacionProducto->CotizacionProductoDetalle)){
		foreach($InsCotizacionProducto->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){

			if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoDetalle->CrdEstado == 1)){
	
				if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
						
						$DatCotizacionProductoDetalle->CrdPrecioBruto = ($DatCotizacionProductoDetalle->CrdPrecioBruto / $InsCotizacionProducto->CprTipoCambio);
						
						$DatCotizacionProductoDetalle->CrdImporte = ($DatCotizacionProductoDetalle->CrdImporte / $InsCotizacionProducto->CprTipoCambio);
						$DatCotizacionProductoDetalle->CrdPrecio = ($DatCotizacionProductoDetalle->CrdPrecio  / $InsCotizacionProducto->CprTipoCambio);
					
				}
				
				if(!empty($InsCotizacionProducto->CprPorcentajeDescuento)){

					$DetallePrecioBruto = ($DatCotizacionProductoDetalle->CrdPrecioBruto);
					$DetallePrecio = $DetallePrecioBruto;
					$DetalleImporte = ($DetallePrecio * $DatCotizacionProductoDetalle->CrdCantidad);
					
					$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($InsCotizacionProducto->CprPorcentajeDescuento/100));
					$DetalleDescuento = (($DetalleImporte * ( $InsCotizacionProducto->CprPorcentajeDescuento/100) ));
					$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;

				}else{
				
					$DetallePrecioBruto = ($DatCotizacionProductoDetalle->CrdPrecioBruto);
					$DetallePrecio = $DetallePrecioBruto;
					$DetalleImporte = ($DetallePrecio *  $DatCotizacionProductoDetalle->CrdCantidad);
					
					$DetallePrecioDescuento =  $DetallePrecio;
					
					$DetalleDescuento = 0;
					$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
				
				}


?>
      <tr>
        <td align="center" class="EstCotizacionProductoDetalleImprimirContenido"><?php echo $i;?></td>
        
        <?php
		if($GET_ImprimirPedido==1){
		?>
        <td align="center" class="EstCotizacionProductoDetalleImprimirContenido" >
          <?php echo $DatCotizacionProductoDetalle->CrdTipoPedido;?>
          </td>
        <?php
		}
		?>
  <?php
		if($GET_ImprimirCodigo==1){
		?>
        <td align="center" class="EstCotizacionProductoDetalleImprimirContenido" >
          
          
          <?php
        	/*	if(empty($DatCotizacionProductoDetalle->CrdCodigo)){
				?>
                <?php echo $DatCotizacionProductoDetalle->ProCodigoOriginal;?>
                <?php	
				}else{
				?>
                 <?php echo $DatCotizacionProductoDetalle->CrdCodigo;?>
                <?php	
				}*/
		            ?>
          
          <?php echo $DatCotizacionProductoDetalle->ProCodigoOriginal;?>
          
          </td>
        <?php
		}
		?>
        <td align="center" class="EstCotizacionProductoDetalleImprimirContenido" ><?php echo number_format($DatCotizacionProductoDetalle->CrdCantidad,2);?></td>
        <td align="center" class="EstCotizacionProductoDetalleImprimirContenido" ><?php echo $DatCotizacionProductoDetalle->UmeAbreviacion;?></td>
        <?php
		if($GET_ImprimirCodigo==1){
		?>
        <?php
		}
		?>
        <td align="left" class="EstCotizacionProductoDetalleImprimirContenido" ><?php //echo $DatCotizacionProductoDetalle->ProNombre;?>
          <?php echo $DatCotizacionProductoDetalle->ProNombre;?></td>
        <td align="right" class="EstCotizacionProductoDetalleImprimirContenido" >
          
          <?php echo number_format(($DetallePrecio),2);?>       
          </td>
        <td align="right" class="EstCotizacionProductoDetalleImprimirContenido" ><?php echo number_format($DetalleImporte,2);?></td>
        
        <?php
//if(!empty($InsCotizacionProducto->CprPorcentajeDescuento ) and $InsCotizacionProducto->CprPorcentajeDescuento <> 0.00 and $InsCotizacionProducto->CprPorcentajeDescuento <> "0.00"){
?>
        <td align="right" class="EstCotizacionProductoDetalleImprimirContenido" ><?php echo number_format($DetalleDescuento,2);?></td>
        <td align="right" class="EstCotizacionProductoDetalleImprimirContenido" ><?php echo number_format($DetalleImporteFinal,2);?></td>
        <?php
		
//}?>
        
        </tr>
      <?php	

			$TotalRepuesto += $DetalleImporteFinal;
			$TotalDescuento += $DetalleDescuento;
			
			
		$i++;
			}
		}
		
		
	} 
?>
      
      
      </tbody>
    </table></td>
  <td width="5" valign="top">&nbsp;</td>
</tr>

  <?php
  if($InsCotizacionProducto->CprRepuesto=="Si" or $InsCotizacionProducto->CprPintado=="Si" or $InsCotizacionProducto->CprPlanchado == "Si" or $InsCotizacionProducto->CprCentrado == "Si" or (!empty($InsCotizacionProducto->CprManoObra) and $InsCotizacionProducto->CprManoObra <> "0.00")){
	?>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="left" class="EstCotizacionProductoImprimirEtiquetaFondo">
    
    <?php
	/*if(!empty($InsCotizacionProducto->CprPorcentajeDescuento ) and $InsCotizacionProducto->CprPorcentajeDescuento <> 0.00 and $InsCotizacionProducto->CprPorcentajeDescuento <> "0.00"){	
	?>
    <span class="EstCotizacionProductoImprimirContenido">DESCUENTO APLICADO: <?php echo number_format($InsCotizacionProducto->CprPorcentajeDescuento,2);?> %</span>
    <?php
	}*/
	?>
    
    
    
    </td>
    <td align="right" class="EstTablaTotal">&nbsp;</td>
    <td align="right" class="EstTablaTotal">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td width="700" align="right" class="EstCotizacionProductoImprimirEtiquetaFondo">
    
  
    <span class="EstCotizacionProductoImprimirEtiquetaTotal">TOTAL :</span>    
 
    
    </td>
    <td width="17" align="right" class="EstTablaTotal"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?></span></td>
    <td width="120" align="right" class="EstTablaTotal">
    
    
    <span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo number_format($TotalRepuesto,2);?></span>
    
    
    </td>
    <td width="5" align="center">&nbsp;</td>
  </tr>
  <?php
  }
  ?>
  

</table>
<!--
<hr class="EstPlantillaLinea" />-->
<?php
}
?>


<?php
	///$TotalRepuesto = $TotalRepuesto;
//	if(!empty($InsCotizacionProducto->CprPorcentajeDescuento)){
//		
//		$TotalDescuento = $TotalRepuesto * ($InsCotizacionProducto->CprPorcentajeDescuento/100);
//		$TotalRepuesto = $TotalRepuesto - $TotalDescuento;
//		
//	}
	
?>


  	<?php
    if($SaltarLineaRepuesto){
    ?>
<H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>




<?php
if(!empty($InsCotizacionProducto->CprManoObra) and $InsCotizacionProducto->CprManoObra <> "0.00"){
		
		
	if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
						
		$InsCotizacionProducto->CprManoObra = round($InsCotizacionProducto->CprManoObra / $InsCotizacionProducto->CprTipoCambio,2);
					
					
	}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionProductoImprimirTabla">

<tr>
  <td width="7" align="center">&nbsp;</td>
  <td width="700" align="right"><span class="EstCotizacionProductoImprimirEtiquetaTotal">MANO DE OBRA :</span></td>
  <td width="17" align="right"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?></span></td>
  <td width="120" align="right">
    
  <span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo number_format($InsCotizacionProducto->CprManoObra,2);?></span>
    
    
  </td>
  <td width="5" align="center">&nbsp;</td>
  
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
//if($InsCotizacionProducto->CprPlanchado=="Si"){
//deb($InsCotizacionProducto->CprVerificar ." -  ".$InsCotizacionProducto->CprPlanchadoVerificado);

if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprPlanchado == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprPlanchadoVerificado == "Si" ) ){
	
	
?>
	
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionProductoImprimirTabla">
    <tr>
    
<td width="7" align="center">&nbsp;</td>
<td colspan="3" align="center"><span class="EstCotizacionProductoImprimirCabecera">Planchado</span></td>
<td width="5" align="center">&nbsp;</td>
</tr>
<tr>
  <td width="7" align="center">&nbsp;</td>
  <td colspan="3" align="center">
    
    
    
  <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstCotizacionProductoImprimirTabla">
    <thead class="EstCotizacionProductoImprimirTablaHead">
      <tr>

        <th width="23" align="center" >#</th>        
        <th width="728" align="center" > Descripcion</th>
        <th width="99" align="center" >Importe</th>

        </tr>
      </thead>
    <tbody class="EstCotizacionProductoImprimirTablaBody">
      <?php
$TotalPlanchado = 0;

$i=1;
if(!empty($InsCotizacionProducto->CotizacionProductoPlanchado)){
	foreach($InsCotizacionProducto->CotizacionProductoPlanchado as $DatCotizacionProductoPlanchado){

		if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoPlanchado->CppEstado == 1)){
			
			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
				
					$DatCotizacionProductoPlanchado->CppImporte = round($DatCotizacionProductoPlanchado->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
				
			}
?>
      
      
      <tr>
        <td align="right" class="EstCotizacionProductoDetalleImprimirContenido"><?php echo $i;?></td>
        
        <td width="728" align="right" class="EstCotizacionProductoDetalleImprimirContenido" >
          <?php echo $DatCotizacionProductoPlanchado->CppDescripcion;?></td>
        <td width="99" align="right" class="EstCotizacionProductoDetalleImprimirContenido" ><?php echo number_format($DatCotizacionProductoPlanchado->CppImporte,2);?></td>
        </tr>
  <?php	
			$TotalPlanchado += $DatCotizacionProductoPlanchado->CppImporte;
			$i++;

		}
	}
} 
?>
      </tbody>
  </table>
    
    
    
  </td>
  <td width="5" align="center">&nbsp;</td>
</tr>
<tr>
  <td width="7" align="center">&nbsp;</td>
  <td width="700" align="right" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiquetaTotal">Total :</span></td>
  <td width="17" align="right" class="EstTablaTotal"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?></span></td>
  <td width="120" align="right" class="EstTablaTotal"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo number_format($TotalPlanchado,2);?></span></td>
  <td width="5" align="center">&nbsp;</td>
  
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
//if($InsCotizacionProducto->CprPintado=="Si"){
if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprPintado == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprPintadoVerificado == "Si" ) ){
?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionProductoImprimirTabla">
	<tr>
    
    <td width="4" align="center">&nbsp;</td>
    <td colspan="3" align="center"><span class="EstCotizacionProductoImprimirCabecera">Pintado</span></td>
    <td width="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="4" align="center">&nbsp;</td>
    <td colspan="3" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstCotizacionProductoImprimirTabla">
      <thead class="EstCotizacionProductoImprimirTablaHead">
        <tr>
          <th width="22" align="center" >#</th>
          
          <th width="728" align="center" > Descripcion </th>
          <th width="99" align="center" >Importe</th>
        </tr>
      </thead>
      <tbody class="EstCotizacionProductoImprimirTablaBody">
        <?php
	
	$TotalPintado = 0;
	$i=1;
	if(!empty($InsCotizacionProducto->CotizacionProductoPintado)){
		foreach($InsCotizacionProducto->CotizacionProductoPintado as $DatCotizacionProductoPintado){

			if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoPintado->CppEstado == 1)){
	
				if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
					
					$DatCotizacionProductoPintado->CppImporte = round($DatCotizacionProductoPintado->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
					
				}
?>


        <tr>
          <td align="right" class="EstCotizacionProductoDetalleImprimirContenido"><?php echo $i;?></td>
          
          <td width="728" align="right" class="EstCotizacionProductoDetalleImprimirContenido" >
            <?php echo $DatCotizacionProductoPintado->CppDescripcion;?></td>
          <td width="99" align="right" class="EstCotizacionProductoDetalleImprimirContenido" ><?php echo number_format($DatCotizacionProductoPintado->CppImporte,2);?></td>
        </tr>
        <?php	
				$TotalPintado += $DatCotizacionProductoPintado->CppImporte;
				$i++;

			}

		}
		
	} 
?>
    
        <?php
	
	
	
	
	

?>
        </tbody>
    </table></td>
    <td width="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="4" align="center">&nbsp;</td>
    <td width="700" align="right" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiquetaTotal">Total :</span></td>
    <td width="18" align="right" class="EstTablaTotal"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?></span></td>
    <td width="120" align="right" class="EstTablaTotal"> <span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo number_format($TotalPintado,2);?></span></td>
    <td width="4" align="center">&nbsp;</td>
	
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
//if($InsCotizacionProducto->CprCentrado=="Si"){
if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprCentrado == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprCentradoVerificado == "Si" ) ){
?>




	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionProductoImprimirTabla">
	<tr>
    
<td width="5" align="center">&nbsp;</td>
<td colspan="3" align="center"><span class="EstCotizacionProductoImprimirCabecera">Centrado</span></td>
<td width="5" align="center">&nbsp;</td>
</tr>
<tr>
  <td width="5" align="center">&nbsp;</td>
  <td colspan="3" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstCotizacionProductoImprimirTabla">
  <thead class="EstCotizacionProductoImprimirTablaHead">
    <tr>
      <th width="23" align="center" >#</th>
      
      <th width="728" align="center" > Descripcion </th>
      <th width="99" align="center" >Importe</th>
      </tr>
  </thead>
  <tbody class="EstCotizacionProductoImprimirTablaBody">
    <?php
$TotalCentrado = 0;

$i=1;
if(!empty($InsCotizacionProducto->CotizacionProductoCentrado)){
	foreach($InsCotizacionProducto->CotizacionProductoCentrado as $DatCotizacionProductoCentrado){


//deb($DatCotizacionProductoPlanchado->CppEstado ." :::: ". $InsCotizacionProducto->CprVerificar);




		if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoCentrado->CppEstado == 1)){
	
			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
				$DatCotizacionProductoCentrado->CppImporte = round($DatCotizacionProductoCentrado->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
			}
?>
    
    <tr>
      <td align="right" class="EstCotizacionProductoDetalleImprimirContenido"><?php echo $i;?></td>
      <td width="728" align="right" class="EstCotizacionProductoDetalleImprimirContenido" >
        <?php echo $DatCotizacionProductoCentrado->CppDescripcion;?></td>
      <td width="99" align="right" class="EstCotizacionProductoDetalleImprimirContenido" ><?php echo number_format($DatCotizacionProductoCentrado->CppImporte,2);?></td>
      </tr>
  <?php	
			  $TotalCentrado += $DatCotizacionProductoCentrado->CppImporte;
			$i++;
		}

	}

} 
?>
    </tbody>
  </table></td>
  <td width="5" align="center">&nbsp;</td>
</tr>
<tr>
  <td width="5" align="center">&nbsp;</td>
  <td width="700" align="right" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiquetaTotal">Total :</span></td>
  <td width="21" align="right" class="EstTablaTotal"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?></span></td>
  <td width="120" align="right" class="EstTablaTotal"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo number_format($TotalCentrado,2);?></span></td>
  <td width="5" align="center">&nbsp;</td>
  
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
//if($InsCotizacionProducto->CprTarea=="Si"){
if( ($InsCotizacionProducto->CprVerificar == 2 and $InsCotizacionProducto->CprTarea == "Si") or ($InsCotizacionProducto->CprVerificar == 1 and $InsCotizacionProducto->CprTareaVerificado == "Si" ) ){
?>


	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionProductoImprimirTabla">
	<tr>
    
<td width="7" align="center">&nbsp;</td>
<td colspan="3" align="center"><span class="EstCotizacionProductoImprimirCabecera">Tareas/Reparacion</span></td>
<td width="5" align="center">&nbsp;</td>
</tr>
<tr>
  <td width="7" align="center">&nbsp;</td>
  <td colspan="3" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstCotizacionProductoImprimirTabla">
  <thead class="EstCotizacionProductoImprimirTablaHead">
    <tr>
      <th width="23" align="center" >#</th>
      
      <th width="728" align="center" > Descripcion </th>
      <th width="99" align="center" >Importe</th>
      </tr>
  </thead>
  <tbody class="EstCotizacionProductoImprimirTablaBody">
    <?php
$TotalTarea = 0;

$i=1;
if(!empty($InsCotizacionProducto->CotizacionProductoTarea)){
	foreach($InsCotizacionProducto->CotizacionProductoTarea as $DatCotizacionProductoTarea){


//deb($DatCotizacionProductoPlanchado->CppEstado ." :::: ". $InsCotizacionProducto->CprVerificar);




		if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoTarea->CppEstado == 1)){
	
			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
				$DatCotizacionProductoTarea->CppImporte = round($DatCotizacionProductoTarea->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
			}
?>
    
    <tr>
      <td align="right" class="EstCotizacionProductoDetalleImprimirContenido"><?php echo $i;?></td>
      <td width="728" align="right" class="EstCotizacionProductoDetalleImprimirContenido" >
        <?php echo $DatCotizacionProductoTarea->CppDescripcion;?></td>
      <td width="99" align="right" class="EstCotizacionProductoDetalleImprimirContenido" ><?php echo number_format($DatCotizacionProductoTarea->CppImporte,2);?></td>
      </tr>
  <?php	
			  $TotalTarea += $DatCotizacionProductoTarea->CppImporte;
			$i++;
		}

	}

} 
?>
    </tbody>
  </table></td>
  <td width="5" align="center">&nbsp;</td>
</tr>
<tr>
  <td width="7" align="center">&nbsp;</td>
  <td width="700" align="right" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiquetaTotal">Total :</span></td>
  <td width="17" align="right" class="EstTablaTotal"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?></span></td>
  <td width="120" align="right" class="EstTablaTotal"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo number_format($TotalTarea,2);?></span></td>
  <td width="5" align="center">&nbsp;</td>
  
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
    
    if($InsCotizacionProducto->CprIncluyeImpuesto == 1){
        
        $Total = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsCotizacionProducto->CprManoObra;
        $SubTotal = $Total / (($InsCotizacionProducto->CprPorcentajeImpuestoVenta/100)+1);
        $Impuesto = $Total - $SubTotal;	
        
    }else{
        
        $SubTotal = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsCotizacionProducto->CprManoObra;
        $Impuesto = $SubTotal * (($InsCotizacionProducto->CprPorcentajeImpuestoVenta/100));
        $Total = $SubTotal + $Impuesto;	
        
    }
    
    ?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionProductoImprimirTabla"> 
  <tr>
    <td width="1%">&nbsp;</td>
    <td colspan="2">
    

   
     <table class="EstTablaTotal" width="100%" cellpadding="1" cellspacing="1" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td colspan="3" align="right"><hr class="EstPlantillaLinea" /></td>
          </tr>
        <tr>
          <td width="700" align="right">
          
         
          <?php
/*if(!empty($InsCotizacionProducto->CprPorcentajeDescuento ) and $InsCotizacionProducto->CprPorcentajeDescuento <> 0.00 and $InsCotizacionProducto->CprPorcentajeDescuento <> "0.00"){
?> 
<span class="EstCotizacionProductoImprimirEtiquetaTotal">DSCTO.
 <!--(<?php echo number_format($InsCotizacionProducto->CprPorcentajeDescuento,2);?> %)-->: </span>
<?php	
}*/
?>  
         </td>
          <td align="right" ><?php
/*if(!empty($InsCotizacionProducto->CprPorcentajeDescuento ) and $InsCotizacionProducto->CprPorcentajeDescuento <> 0.00 and $InsCotizacionProducto->CprPorcentajeDescuento <> "0.00"){
?>
            <span class="EstCotizacionProductoImprimirContenidoTotal"> <?php echo $InsCotizacionProducto->MonSimbolo;?>  </span>
            <?php	
}*/
?></td>
          <td width="120" align="right" >
                  <?php
/*if(!empty($InsCotizacionProducto->CprPorcentajeDescuento ) and $InsCotizacionProducto->CprPorcentajeDescuento <> 0.00 and $InsCotizacionProducto->CprPorcentajeDescuento <> "0.00"){
?>   
          <span class="EstCotizacionProductoImprimirContenidoTotal">
		   <?php echo number_format($TotalDescuento,2);?>
          </span>
          
    <?php	
}*/
?>       
          </td>
        </tr>
        <tr>
          <td width="700" align="right"><span class="EstCotizacionProductoImprimirEtiquetaTotal">SubTotal:</span></td>
          <td width="18" align="right" ><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?></span></td>
          <td width="120" align="right" > <span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo number_format($SubTotal,2);?></span></td>
        </tr>
        <tr>
          <td width="700" align="right"><span class="EstCotizacionProductoImprimirEtiquetaTotal">I.G.V. (<?php echo $InsCotizacionProducto->CprPorcentajeImpuestoVenta;?>%):</span></td>
          <td align="right"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?></span></td>
          <td width="120" align="right"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo number_format($Impuesto,2);?></span></td>
        </tr>
        <tr>
          <td width="700" align="right"><span class="EstCotizacionProductoImprimirEtiquetaTotal">TOTAL:</span></td>
          <td align="right"><span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?></span></td>
          <td width="120" align="right">
          
          <span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo number_format($Total,2);?></span>
          
          </td>
        </tr>
        </tbody>
    </table>
    
     
    
    
    
    </td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td colspan="2" align="right">
    
<!--    <div  class="EstCapCotizacionProductoTotal">
    <table class="EstTablaTotal" width="100%" cellpadding="1" cellspacing="1" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="647" align="right" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiquetaTotal">Total:</span></td>
          <td width="124" align="right">
          
          <span class="EstCotizacionProductoImprimirContenidoTotal"><?php echo $InsCotizacionProducto->MonSimbolo;?> <?php echo number_format($Total,2);?></span>
          
          </td>
        </tr>
      </tbody>
    </table>
    </div>-->
    
    </td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstCotizacionProductoImprimirTabla">
      <tr>
        <td width="12%" align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><span class="EstCotizacionProductoImprimirEtiqueta">Observacion:</span></td>
        <td colspan="4" align="left" valign="top" ><span class="EstCotizacionProductoImprimirObservacion"><?php echo $InsCotizacionProducto->CprObservacionImpresa;?></span></td>
        <td width="2%" align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
    <td width="1%">&nbsp;</td>
  </tr>
  
 </table> 
  
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCotizacionProductoImprimirTabla">  
  <tr>
    <td width="5%">&nbsp;</td>
    <td colspan="2"><table class="EstTablaTotal" width="100%" cellpadding="1" cellspacing="1" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="58%" align="left" valign="top"><div class="EstCotizacionProductoImprimirNota1">
              
              <p><strong>Nota:</strong></p>
              <ul type="disc">
                <!-- <li>El       precio total incluye el I.G.V.</li>
                 
-->

<?php
/*if($InsCotizacionProducto->CprIncluyeImpuesto==1){
	?>
    - Los precios incluyen el I.G.V.
    <?php
	
}else{
	?>
    - Los precios no incluyen el I.G.V.
    <?php
	
}*/
?>
                <li>Precios       Validos por <?php echo $InsCotizacionProducto->CprVigencia;?> días.</li>
                
                
                <?php
				 if(!empty($InsCotizacionProducto->CprTiempoEntrega)){
				?>
                <li>
                
                Repuestos disponibles en <?php echo $InsCotizacionProducto->CprTiempoEntrega;?> d&iacute;as h&aacute;biles.
                <!-- 
                El tiempo de entrega estimado es de <?php echo $InsCotizacionProducto->CprTiempoEntrega;?>  días.
                 (<?php echo $InsCotizacionProducto->CprFechaEntrega;?>)-->.
                  </li>
                <?php	 
				 }
				 ?>
                
                <li>Los       precios en <?php echo $InsCotizacionProducto->MonNombre;?>.
                  
                  
                  
                  </li>
                
                <?php
			/*	if(!empty($InsCotizacionProducto->CprTipoCambio)){
					?>
                <li> Tipo de Cambio <?php echo $InsCotizacionProducto->CprTipoCambio;?>.    </li>                
                <?php
				}*/
				?>
                
               <!-- <li>Repuestos       originales.</li>-->
                <li>Despues de haber recibido los repuestos no se aceptan devoluciones.</li>
              <!--  <li>Repuestos disponibles en 7 d&iacute;as h&aacute;biles.</li> -->               
              <!--  <li>Repuestos       no incluyen mano de obra.</li>-->
                </ul>
              
              </div></td>
          <td height="80" colspan="2" align="center" valign="bottom" class="EstCotizacionProductoImprimirEtiquetaFondo">
		  
		  
		  <?php
		  if($InsCotizacionProducto->CprFirmaDigital==1){
		?>
            <img src="../../subidos/personal_firmas/<?php echo $InsCotizacionProducto->PerFirma;?>" alt="[<?php echo $InsCotizacionProducto->PerNombre;?> <?php echo $InsCotizacionProducto->PerApellidoPaterno;?> <?php echo $InsCotizacionProducto->PerApellidoMaterno;?>]" />
            <?php
		  }
			  
		  ?>
            <br />
            _______________________ </td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="center" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">
          
          <span class="EstCotizacionProductoImprimirFirma"><?php echo $InsCotizacionProducto->PerNombre;?> <?php echo $InsCotizacionProducto->PerApellidoPaterno;?> <?php echo $InsCotizacionProducto->PerApellidoMaterno;?> </span>
          
          </td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="center" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">
          
          
          <span class="EstCotizacionProductoImprimirNota3">
          Almacen - Ventas<br />
          Telefono: <?php echo $InsCotizacionProducto->PerTelefono;?><br />
            Celular: <?php echo $InsCotizacionProducto->PerCelular;?><br />
            Email: <?php echo $InsCotizacionProducto->PerEmail;?> </span>
            
            
            </td>
        </tr>
        <tr>
          <td align="left" valign="top">
            
            
            
            
            
            </td>
          <td width="40%" colspan="2" align="right" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo">&nbsp;</td>
        </tr>
        </tbody>
    </table></td>
    <td width="5%">&nbsp;</td>
  </tr>
  
  
</table>


        
<div class="EstCotizacionProductoPie">

        <span class="EstCotizacionProductoImprimirNota2">Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        </span>

 </div>
<div class="EstCotizacionProductoPieAux">

</div>     
        
</body>
</html>
