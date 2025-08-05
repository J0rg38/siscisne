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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoProforma.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoProformaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


$InsVehiculoProforma = new ClsVehiculoProforma();

$InsVehiculoProforma->VprId = $GET_id;
$InsVehiculoProforma->MtdObtenerVehiculoProforma();

//deb($InsVehiculoProforma);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Trabajo No. <?php echo $InsVehiculoProforma->VprId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssVehiculoProformaImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVehiculoProformaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsVehiculoProforma->VprId)){?> 
FncVehiculoProformaImprimir(); 
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
  

  <span class="EstPlantillaImprimirEtiqueta">PROFORMAS </span><br />
  <span class="EstPlantillaTituloCodigo"><?php echo $InsVehiculoProforma->VprId;?></span> 
  
  
 
  
  </td>
  <td width="21%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoProformaImprimirTabla">

<tr>
    <td align="left" valign="top">
      
      <div class="EstVehiculoProformaImprimirCapa">
        
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoProformaImprimirTabla">
          <tbody class="EstVehiculoProformaImprimirTablaBody">
            <tr>
              <td width="17%" align="left" valign="top" class="EstVehiculoProformaImprimirEtiquetaFondo" ><span class="EstVehiculoProformaImprimirEtiqueta">Lista Dealer</span></td>
              <td width="3%" align="left" valign="top" ><span class="EstVehiculoProformaImprimirEtiqueta">:</span></td>
              <td width="30%" align="left" valign="top" ><span class="EstVehiculoProformaImprimirContenido">
                
                <?php echo $InsVehiculoProforma->VprCodigo;?>
                
                </span>
                
              </td>
              <td width="20%" align="left" valign="top" class="EstVehiculoProformaImprimirEtiquetaFondo" ><span class="EstVehiculoProformaImprimirEtiqueta">Fecha Vigencia</span></td>
              <td width="3%" align="left" valign="top" ><span class="EstVehiculoProformaImprimirEtiqueta">:</span></td>
              <td width="27%" align="left" valign="top" ><span class="EstVehiculoProformaImprimirContenido"><?php echo $InsVehiculoProforma->VprFechaVigencia;?> </span></td>
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
    <div class="EstVehiculoProformaImprimirCapa">
    
    
    <table class="EstVehiculoProformaImprimirTabla" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstVehiculoProformaImprimirTablaHead">
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
<tbody class="EstVehiculoProformaImprimirTablaBody">
<?php
$c = 1;
foreach($InsVehiculoProforma->VehiculoProformaDetalle as $DatVehiculoProformaDetalle){
	
	
			if($InsVehiculoProforma->MonId<>$EmpresaMonedaId){
				$DatVehiculoProformaDetalle->VpdCosto = $DatVehiculoProformaDetalle->VpdCosto / $InsVehiculoProforma->VprTipoCambio;
			}else{
				$DatVehiculoProformaDetalle->VpdCosto = $DatVehiculoProformaDetalle->VpdCosto;
			}

			if($InsVehiculoProforma->MonId<>$EmpresaMonedaId ){
				$DatVehiculoProformaDetalle->VpdPrecioCierre = $DatVehiculoProformaDetalle->VpdPrecioCierre / $InsVehiculoProforma->VprTipoCambio;
			}else{
				$DatVehiculoProformaDetalle->VpdPrecioCierre = $DatVehiculoProformaDetalle->VpdPrecioCierre;
			}
			
			if($InsVehiculoProforma->MonId<>$EmpresaMonedaId ){
				$DatVehiculoProformaDetalle->VpdPrecioLista = $DatVehiculoProformaDetalle->VpdPrecioLista / $InsVehiculoProforma->VprTipoCambio;
			}else{
				$DatVehiculoProformaDetalle->VpdPrecioLista = $DatVehiculoProformaDetalle->VpdPrecioLista;
			}
			
			if($InsVehiculoProforma->MonId<>$EmpresaMonedaId ){
				$DatVehiculoProformaDetalle->VpdBonoGM = $DatVehiculoProformaDetalle->VpdBonoGM / $InsVehiculoProforma->VprTipoCambio;
			}else{
				$DatVehiculoProformaDetalle->VpdBonoGM = $DatVehiculoProformaDetalle->VpdBonoGM;
			}
			
			if($InsVehiculoProforma->MonId<>$EmpresaMonedaId ){
				$DatVehiculoProformaDetalle->VpdBonoDealer = $DatVehiculoProformaDetalle->VpdBonoDealer / $InsVehiculoProforma->VprTipoCambio;
			}else{
				$DatVehiculoProformaDetalle->VpdBonoDealer = $DatVehiculoProformaDetalle->VpdBonoDealer;
			}
			
			if($InsVehiculoProforma->MonId<>$EmpresaMonedaId ){
				$DatVehiculoProformaDetalle->VpdDescuentoGerencia = $DatVehiculoProformaDetalle->VpdDescuentoGerencia / $InsVehiculoProforma->VprTipoCambio;
			}else{
				$DatVehiculoProformaDetalle->VpdDescuentoGerencia = $DatVehiculoProformaDetalle->VpdDescuentoGerencia;
			}
?>


<tr>
<td align="right" ><?php echo $c;?></td>
<td align="right" ><?php echo $DatVehiculoProformaDetalle->VmaNombre;?></td>
<td align="right" ><?php echo $DatVehiculoProformaDetalle->VmoNombre;?></td>
<td align="right" >

<?php echo $DatVehiculoProformaDetalle->VveNombre;?>


</td>
<td align="right" ><?php echo $DatVehiculoProformaDetalle->VpdFuente;?></td>
<td align="right" ><?php echo number_format($DatVehiculoProformaDetalle->VpdCosto,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoProformaDetalle->VpdPrecioCierre,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoProformaDetalle->VpdPrecioLista,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoProformaDetalle->VpdBonoGM,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoProformaDetalle->VpdBonoDealer,2);?></td>
<td align="right" ><?php echo number_format($DatVehiculoProformaDetalle->VpdDescuentoGerencia,2);?></td>
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
  <td colspan="5" valign="top"><div class="EstVehiculoProformaImprimirCapa"></div></td>
</tr>
</table>

</body>
</html>
