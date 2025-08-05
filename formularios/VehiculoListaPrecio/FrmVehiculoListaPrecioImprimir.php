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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecioDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


$InsVehiculoListaPrecio = new ClsVehiculoListaPrecio();

$InsVehiculoListaPrecio->VlpId = $GET_id;
$InsVehiculoListaPrecio->MtdObtenerVehiculoListaPrecio();

//deb($InsVehiculoListaPrecio);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Trabajo No. <?php echo $InsVehiculoListaPrecio->VlpId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssVehiculoListaPrecioImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVehiculoListaPrecioImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsVehiculoListaPrecio->VlpId)){?> 
FncVehiculoListaPrecioImprimir(); 
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
  <td width="22%" align="left" valign="top"> <img src="../../imagenes/logos/logo_impresion.png" width="150" title="Logo" alt="Logo" border="0" /></td>
  <td width="57%" align="center" valign="top">
  

  <span class="EstPlantillaImprimirEtiqueta">LISTA DE PRECIOS </span><br />
  <span class="EstPlantillaTituloCodigo"><?php echo $InsVehiculoListaPrecio->VlpId;?></span> 
  
  
 
  
  </td>
  <td width="21%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoListaPrecioImprimirTabla">

<tr>
    <td align="left" valign="top">
      
      <div class="EstVehiculoListaPrecioImprimirCapa">
        
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoListaPrecioImprimirTabla">
          <tbody class="EstVehiculoListaPrecioImprimirTablaBody">
            <tr>
              <td width="17%" align="left" valign="top" class="EstVehiculoListaPrecioImprimirEtiquetaFondo" ><span class="EstVehiculoListaPrecioImprimirEtiqueta">Lista Dealer</span></td>
              <td width="3%" align="left" valign="top" ><span class="EstVehiculoListaPrecioImprimirEtiqueta">:</span></td>
              <td width="30%" align="left" valign="top" ><span class="EstVehiculoListaPrecioImprimirContenido">
                
                <?php echo $InsVehiculoListaPrecio->VlpCodigo;?>
                
                </span>
                
              </td>
              <td width="20%" align="left" valign="top" class="EstVehiculoListaPrecioImprimirEtiquetaFondo" ><span class="EstVehiculoListaPrecioImprimirEtiqueta">Fecha Vigencia</span></td>
              <td width="3%" align="left" valign="top" ><span class="EstVehiculoListaPrecioImprimirEtiqueta">:</span></td>
              <td width="27%" align="left" valign="top" ><span class="EstVehiculoListaPrecioImprimirContenido"><?php echo $InsVehiculoListaPrecio->VlpFechaVigencia;?> </span></td>
            </tr>
          </tbody>
        </table>
        
      </div>
      
    </td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" valign="top">
    <div class="EstVehiculoListaPrecioImprimirCapa">
    
    
    <table class="EstVehiculoListaPrecioImprimirTabla" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstVehiculoListaPrecioImprimirTablaHead">
<tr>
  <th width="3%">#</th>
  <th width="6%">Marca</th>
  <th width="6%">Modelo</th>
  <th width="22%">Version</th>
<th width="8%"> Fuente</th>
<th width="11%">Precio Wholesale sin IGV.</th>
<th width="9%">Precio Cierre con IGV</th>
<th width="8%">Precio Lista con IGV</th>
<th width="9%">Bono GM</th>
<th width="9%">Bono Dealer</th>
<th width="9%">Descuento Gerencia</th>
</tr>
</thead>
<tbody class="EstVehiculoListaPrecioImprimirTablaBody">
<?php
$c = 1;
foreach($InsVehiculoListaPrecio->VehiculoListaPrecioDetalle as $DatVehiculoListaPrecioDetalle){
	
	
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId){
				$DatVehiculoListaPrecioDetalle->VldCosto = $DatVehiculoListaPrecioDetalle->VldCosto / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldCosto = $DatVehiculoListaPrecioDetalle->VldCosto;
			}

			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldPrecioCierre = $DatVehiculoListaPrecioDetalle->VldPrecioCierre / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldPrecioCierre = $DatVehiculoListaPrecioDetalle->VldPrecioCierre;
			}
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldPrecioLista = $DatVehiculoListaPrecioDetalle->VldPrecioLista / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldPrecioLista = $DatVehiculoListaPrecioDetalle->VldPrecioLista;
			}
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldBonoGM = $DatVehiculoListaPrecioDetalle->VldBonoGM / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldBonoGM = $DatVehiculoListaPrecioDetalle->VldBonoGM;
			}
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldBonoDealer = $DatVehiculoListaPrecioDetalle->VldBonoDealer / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldBonoDealer = $DatVehiculoListaPrecioDetalle->VldBonoDealer;
			}
			
			if($InsVehiculoListaPrecio->MonId<>$EmpresaMonedaId ){
				$DatVehiculoListaPrecioDetalle->VldDescuentoGerencia = $DatVehiculoListaPrecioDetalle->VldDescuentoGerencia / $InsVehiculoListaPrecio->VlpTipoCambio;
			}else{
				$DatVehiculoListaPrecioDetalle->VldDescuentoGerencia = $DatVehiculoListaPrecioDetalle->VldDescuentoGerencia;
			}
?>


<tr>
<td align="right" ><?php echo $c;?></td>
<td align="right" ><?php echo $DatVehiculoListaPrecioDetalle->VmaNombre;?></td>
<td align="right" ><?php echo $DatVehiculoListaPrecioDetalle->VmoNombre;?></td>
<td align="right" >

<?php echo $DatVehiculoListaPrecioDetalle->VveNombre;?>


</td>
<td align="right" ><?php echo $DatVehiculoListaPrecioDetalle->VldFuente;?></td>
<td align="right" ><?php echo number_format($DatVehiculoListaPrecioDetalle->VldCosto,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoListaPrecioDetalle->VldPrecioCierre,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoListaPrecioDetalle->VldPrecioLista,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoListaPrecioDetalle->VldBonoGM,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoListaPrecioDetalle->VldBonoDealer,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoListaPrecioDetalle->VldDescuentoGerencia,2);?></td>
</tr>
<?php


$c++;
}

?>
</tbody>
</table>



    
      </div>
    </td>
</tr>
<tr>
  <td colspan="5" valign="top"><div class="EstVehiculoListaPrecioImprimirCapa"></div></td>
</tr>
</table>

</body>
</html>
