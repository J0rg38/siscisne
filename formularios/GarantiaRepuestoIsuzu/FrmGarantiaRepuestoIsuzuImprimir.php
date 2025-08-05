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

require_once($InsPoo->MtdPaqActividad().'ClsGarantiaRepuestoIsuzu.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaRepuestoIsuzuManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaRepuestoIsuzuDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaRepuestoIsuzuLlamada.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');


$InsGarantiaRepuestoIsuzu = new ClsGarantiaRepuestoIsuzu();

$InsGarantiaRepuestoIsuzu->GriId = $GET_id;
$InsGarantiaRepuestoIsuzu->MtdObtenerGarantiaRepuestoIsuzu();

if($InsGarantiaRepuestoIsuzu->MonId <> $EmpresaMonedaId){
	if(empty($InsGarantiaRepuestoIsuzu->GriTipoCambio)){
		die("No se encontro tipo de cambio.");
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO DE RECLAMACION ISUZU No. <?php echo $InsGarantiaRepuestoIsuzu->GriId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssGarantiaRepuestoIsuzuImprimir.css" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="js/JsGarantiaRepuestoIsuzuImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsGarantiaRepuestoIsuzu->GriId)){?> 
FncGarantiaRepuestoIsuzuImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>
<style type="text/css" media="print">
/*    .page
    {
     -webkit-transform: rotate(-90deg); -moz-transform:rotate(-90deg);
     filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    }*/
</style>
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
	<!--<input name="ImprimirCodigo" id="ImprimirCodigo" type="checkbox" value="1" <?php echo ($GET_ImprimirCodigo==1)?'checked="checked"':'';?>  /> Imprimir Codigos--></td>
<td>&nbsp;</td>
<td>
	<input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
</td>
</tr>
</table>

</form>
<?php }?>

<!--<hr class="EstPlantillaLinea">-->

<div class="rotate">



<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstGarantiaRepuestoIsuzuImprimirTabla">

<tr>
  <td colspan="2" align="center" valign="top"><span class="EstPlantillaTitulo">HOJA DE GRIANTÍA POST-ENTREGA- REPUESTOS/ALMACEN</span> </td>
</tr>
<tr>
  <td colspan="2" valign="top">
  
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstGarantiaRepuestoIsuzuImprimirTabla">
      <tbody class="EstGarantiaRepuestoIsuzuImprimirTablaBody">
        <tr>
          <td colspan="5" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirSubTituloFondo"><span class="EstGarantiaRepuestoIsuzuImprimirSubTitulo">INFORMACION VEHICULAR</span></td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">
            
            <span class="EstGarantiaRepuestoIsuzuImprimirModalidadIngreso">
              <?php
		  	echo $InsGarantiaRepuestoIsuzu->MinNombre
		  ?>
              
              </span>
          </td>
          </tr>
        <tr>
          <td width="124" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">PLACA: </span></td>
          <td width="131" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">VIN: </span></td>
          <td colspan="3" align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">MODELO VEHICULAR</span></td>
      
 
      
          <td width="234" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirSubTituloFondo">
     
           <span class="EstGarantiaRepuestoIsuzuImprimirSubTitulo">N°: <?php echo $InsGarantiaRepuestoIsuzu->GriId;?></span>
          
          </td>
          </tr>
        <tr>
          <td rowspan="2" align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirContenido"><?php echo $InsGarantiaRepuestoIsuzu->EinPlaca;?></span></td>
          <td rowspan="2" align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirContenido"><?php echo $InsGarantiaRepuestoIsuzu->EinVIN;?></span></td>
          <td colspan="3" rowspan="2" align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirContenido">
            
            <?php echo $InsGarantiaRepuestoIsuzu->GriModelo;?><br />
            Color: <?php echo $InsGarantiaRepuestoIsuzu->EinColor;?> A&ntilde;o Fab.: <?php echo $InsGarantiaRepuestoIsuzu->EinAnoFabricacion;?> Nro. Motor: <?php echo $InsGarantiaRepuestoIsuzu->EinNumeroMotor;?>
            </span>
            
          </td>
          <td align="left" valign="middle">
            
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido"> Orden de Trabajo: <?php echo $InsGarantiaRepuestoIsuzu->FinId;?></span>
            
          </td>
        </tr>
        <tr>
          <td align="left" valign="middle">
         <span class="EstGarantiaRepuestoIsuzuImprimirContenido"> Boletin de Servicio: <?php echo $InsGarantiaRepuestoIsuzu->CamBoletinCodigo;?></span>
          </td>
        </tr>
        </table>
        
  </td>
</tr>
<tr>
  <td colspan="2" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" valign="top">
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstGarantiaRepuestoIsuzuImprimirTabla">
      <tbody class="EstGarantiaRepuestoIsuzuImprimirTablaBody">
        <tr>
          <td colspan="8" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirSubTituloFondo"><span class="EstGarantiaRepuestoIsuzuImprimirSubTitulo">INFORMACION GENERAL</span> <br /></td>
          </tr>
        <tr>
          <td width="210" rowspan="2" align="left" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">
            
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido">
              Identificación Concesionario:<br />
              Nombre:  C & C S.A.C<br />
              Dirección:  Urb. Los cedros Mz B Lt 10<br />
              Ciudad:   Tacna
              </span>
            
          </td>
          <td width="579" colspan="-4" rowspan="2" align="left" valign="top" >
          
          
          
          <span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">IDENTIFICACION PROPIETARIO</span>
            
            <span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Nombre:</span> 
            
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido"><?php echo $InsGarantiaRepuestoIsuzu->CliNombre;?> <?php echo $InsGarantiaRepuestoIsuzu->CliApellidoPaterno;?> <?php echo $InsGarantiaRepuestoIsuzu->CliApellidoMaterno;?></span><br />
            
            <span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Telefono:</span> 
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido"><?php echo $InsGarantiaRepuestoIsuzu->GriTelefono;?></span>
            
            <span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Celular:</span> 
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido"><?php echo $InsGarantiaRepuestoIsuzu->GriCelular;?></span><br />
            
             
            <span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Direccion:</span> 
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido"><?php echo $InsGarantiaRepuestoIsuzu->GriDireccion;?></span><br />
            
            <span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Ciudad:</span> 
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido"><?php echo $InsGarantiaRepuestoIsuzu->GriCiudad;?></span><br />
            
            <span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Poliza N°: </span>
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido"><?php echo $InsGarantiaRepuestoIsuzu->EinPoliza;?></span><br />            
            
            
            
            
            
            </td>
          <td width="71" colspan="-4" rowspan="2" align="center" valign="middle" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Fecha DE FORMULARIO DE RECLAMACION ISUZU</span></td>
          <td width="169" colspan="-6" align="center" valign="middle"><span class="EstGarantiaRepuestoIsuzuImprimirContenido">Fecha de Apertura: <?php echo $InsGarantiaRepuestoIsuzu->GriFechaEmision;?></span></td>
        </tr>
        <tr>
          <td width="169" colspan="-6" align="center" valign="middle"><span class="EstGarantiaRepuestoIsuzuImprimirContenido">Fecha de Cierre: <?php echo $InsGarantiaRepuestoIsuzu->FinTiempoTrabajoTerminado;?></span></td>
        </tr>
        </table>
  
  </td>
</tr>
<tr>
  <td colspan="2" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstGarantiaRepuestoIsuzuImprimirTabla">
      <tbody class="EstGarantiaRepuestoIsuzuImprimirTablaBody">
        <tr>
          <td colspan="12" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirSubTituloFondo"><span class="EstGarantiaRepuestoIsuzuImprimirSubTitulo">DETALLE DEL TRABAJO REALIZADO</span><br /></td>
        </tr>
        <tr>
          <td colspan="5" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Fecha DE VENTa vehicular</span></td>
          <td colspan="4" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">tiempo del trabajo</span></td>
          <td width="161" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">KILOMETRAJE</span></td>
          <td width="143" colspan="2" align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">N° LINEA (ELEVADOR)</span></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirContenido">Fecha: <?php echo $InsGarantiaRepuestoIsuzu->GriFechaVenta;?></span></td>
          <td colspan="4" rowspan="2" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">&nbsp;</td>
          <td rowspan="2" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirContenido"><?php echo number_format($InsGarantiaRepuestoIsuzu->FinVehiculoKilometraje,2);?></span></td>
          <td colspan="2" rowspan="2" align="center" valign="top" >1</td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirContenido">Dealer: <?php echo $InsGarantiaRepuestoIsuzu->OncNombre;?></span></td>
          </tr>
        <tr>
          <td width="31" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">1</span></td>
          <td width="40" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">2</span></td>
          <td width="34" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">3</span></td>
          <td width="37" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">4</span></td>
          <td width="47" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">5</span></td>
          <td colspan="4" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">TEMPARIO SERVICE INFORMATION</span></td>
          <td colspan="3" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">CAUSA DE PROBLEMA</span></td>
          </tr>
        <tr>
          <td width="31" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">6</span></td>
          <td width="40" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">7</span></td>
          <td width="34" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">8</span></td>
          <td width="37" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">9</span></td>
          <td width="47" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">10</span></td>
          <td width="121" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Operación Nº</span></td>
          <td width="47" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">T</span></td>
          <td width="127" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">VALOR</span></td>
          <td width="93" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">M/O</span></td>
          <td colspan="3" rowspan="3" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirContenido">
		  
          <?php
		 /* if(empty($InsGarantiaRepuestoIsuzu->GriCausa)){
			 ?>
              <?php $InsGarantiaRepuestoIsuzu->GriCausa = $InsGarantiaRepuestoIsuzu->FccCausa;?>
             <?php
		  }*/
		  ?>
		 <?php echo $InsGarantiaRepuestoIsuzu->GriCausa;?>
         
          
          </span></td>
          </tr>
        <tr>
          <td width="31" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">11</span></td>
          <td width="40" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">12</span></td>
          <td width="34" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">13</span></td>
          <td width="37" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">14</span></td>
          <td width="47" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">15</span></td>
          <td rowspan="6" align="right" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><?php
	if(!empty($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra)){
		foreach($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra as $DatGarantiaRepuestoIsuzuManoObra){
	?>
            <?php echo $DatGarantiaRepuestoIsuzuManoObra->GopNumero;?><br />
            <?php
		}
	}
	?></td>
          <td rowspan="6" align="right" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><?php
	if(!empty($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra)){
		foreach($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra as $DatGarantiaRepuestoIsuzuManoObra){
	?>
            <?php echo number_format($DatGarantiaRepuestoIsuzuManoObra->GopTiempo,2);?><br />
            <?php
		}
	}
	?></td>
          <td rowspan="6" align="right" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><?php
	if(!empty($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra)){
		foreach($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra as $DatGarantiaRepuestoIsuzuManoObra){
			
			if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId){
				$DatGarantiaRepuestoIsuzuManoObra->GopValor = round($DatGarantiaRepuestoIsuzuManoObra->GopValor / $InsGarantiaRepuestoIsuzu->GriTipoCambio,2);				
			}
	?>
            <?php echo number_format($DatGarantiaRepuestoIsuzuManoObra->GopValor,2);?><br />
            <?php
		}
	}
	?></td>
          <td rowspan="6" align="right" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><?php
	  $TotalManoObra = 0;
	  ?>
            <?php
	if(!empty($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra)){
		foreach($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra as $DatGarantiaRepuestoIsuzuManoObra){
			
			
			if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId){
				$DatGarantiaRepuestoIsuzuManoObra->GopCosto = round($DatGarantiaRepuestoIsuzuManoObra->GopCosto / $InsGarantiaRepuestoIsuzu->GriTipoCambio,2);
				
			}
			
			
	?>
            <?php echo number_format($DatGarantiaRepuestoIsuzuManoObra->GopCosto,2);?><br />
            <?php $TotalManoObra += $DatGarantiaRepuestoIsuzuManoObra->GopCosto;?>
            <?php
		}
	}
	?></td>
          </tr>
        <tr align="center">
          <td width="31" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">16</span></td>
          <td width="40" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">17</span></td>
          <td width="34" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">18</span></td>
          <td width="37" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">19</span></td>
          <td width="47" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">20</span></td>
          </tr>
        <tr>
          <td colspan="5" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Devolución / Rechazo</span></td>
          <td colspan="3" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">SOLUCION AL PROBLEMA</span></td>
          </tr>
        <tr>
          <td width="31" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">21</span></td>
          <td width="40" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">22</span></td>
          <td width="34" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">23</span></td>

          <td width="37" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">24</span></td>
          <td width="47" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">25</span></td>
          <td colspan="3" rowspan="4" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"> <?php echo $InsGarantiaRepuestoIsuzu->GriSolucion;?></td>
          </tr>
        <tr align="center">
          <td width="31" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">26</span></td>
          <td width="40" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">27</span></td>
          <td width="34" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">28</span></td>
          <td width="37" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">29</span></td>
          <td width="47" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">30</span></td>
          </tr>
        <tr align="center">
          <td width="31" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">31</span></td>
          <td width="40" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">32</span></td>
          <td width="34" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">33</span></td>
          <td width="37" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">34</span></td>
          <td width="47" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">35</span></td>
          </tr>
        <tr>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">36</span></td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">37</span></td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">38</span></td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">39</span></td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">40</span></td>
          <td colspan="3" align="right" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">TOTAL MANO DE OBRA:</span></td>
          <td align="right" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><?php echo number_format($TotalManoObra,2);?></td>
          </tr>
        </table></td>
</tr>
<tr>
  <td colspan="2" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" valign="top">
  
  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="EstGarantiaRepuestoIsuzuImprimirTabla">
      <tbody class="EstGarantiaRepuestoIsuzuImprimirTablaBody">
        <tr>
          <td width="31" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">item</span></td>
          <td width="70" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">M/O</span></td>
          <td width="83" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">T.C.</span></td>
          <td width="81" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">P</span></td>
          <td width="78" align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">NUMERO DE REP.</span></td>
          <td width="412" align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">DESCRIPCION</span></td>
          <td width="134" colspan="-1" align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">CANT.</span></td>
          <td width="146" align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">COSTO</span></td>
          </tr>
        
        
        <?php
		
		$SubTotalRepuestoStock = 0;
	$item = 1;	
	if(!empty($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuDetalle)){
		foreach($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuDetalle as $DatGarantiaRepuestoIsuzuDetalle){
	?>
           

        <tr>
          <td align="right" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><?php echo $item;?>.- </td>
          <td align="right" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">&nbsp;</td>
          <td align="left" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">&nbsp;</td>
          <td align="left" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">&nbsp;</td>
          <td align="center" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">
            
            <?php echo $DatGarantiaRepuestoIsuzuDetalle->ProCodigoOriginal;?>
           
            </span></td>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">
            
            <?php echo $DatGarantiaRepuestoIsuzuDetalle->ProNombre;?><br />
           
            </span></td>
          <td colspan="-1" align="right" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">
          
            <?php echo number_format($DatGarantiaRepuestoIsuzuDetalle->GdeCantidad,2);?>
           

            </span></td>
          <td align="right" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">
            
            <?php

			if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId){
				$DatGarantiaRepuestoIsuzuDetalle->GdeCostoTotal = round($DatGarantiaRepuestoIsuzuDetalle->GdeCostoTotal / $InsGarantiaRepuestoIsuzu->GriTipoCambio,2);
			}
			
			
	?>
            <?php echo number_format($DatGarantiaRepuestoIsuzuDetalle->GdeCostoTotal,2);?><br />
            <?php $SubTotalRepuestoStock += $DatGarantiaRepuestoIsuzuDetalle->GdeCostoTotal;?>
            
          </span></td>
          </tr>
          
             <?php
			 $item++;
		}
	}
	?>         
          
            <tr>
               <td colspan="8" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">&nbsp;</td>
            </tr>
            <tr>
          <td colspan="2" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">FORMULARIO DE RECLAMACION ISUZU</span></td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">POLITICA</span></td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">CAMPAÑA</span></td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">OTRO</span></td>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Sub total Repuestos Stock</span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantiaRepuestoIsuzu->MonSimbolo);?></td>
          <td align="right" valign="top" ><?php echo number_format($SubTotalRepuestoStock,2); ?></td>
          </tr>
        <tr>
          <td colspan="2" align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">
            
            <?php
	if($InsGarantiaRepuestoIsuzu->MinId == "MIN-10000"){
	?>
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido">X</span>
            <?php
	}
	?>          </td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><?php
	if($InsGarantiaRepuestoIsuzu->MinId == "MIN-10010"){
	?>
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido">X</span>
            <?php
	}
	?></td>
          <td align="center" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><?php
	if($InsGarantiaRepuestoIsuzu->MinId == "MIN-10008"){
	?>
            <span class="EstGarantiaRepuestoIsuzuImprimirContenido">X</span>
            <?php
	}
	?></td>
          <td align="center" valign="top" >&nbsp;</td>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">% Factor</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsGarantiaRepuestoIsuzu->MonSimbolo);?></td>
          <td align="right" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="5" rowspan="8" align="left" valign="top" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo">
          <?php echo $InsGarantiaRepuestoIsuzu->AmoId;?>


<?php
	/*if(!empty($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra)){
		foreach($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra as $DatGarantiaRepuestoIsuzuManoObra){
	?>
            <?php echo $DatGarantiaRepuestoIsuzuManoObra->GopTransaccionNumero;?><br />
            <?php
		}
	}*/
	?>
    
    
    
          
          
          
          </td>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Sub total Repuestos Otros</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsGarantiaRepuestoIsuzu->MonSimbolo);?></td>
          <td align="right" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">% Factor</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsGarantiaRepuestoIsuzu->MonSimbolo);?></td>
          <td align="right" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Total Repuestos</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsGarantiaRepuestoIsuzu->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            <?php
	  $TotalRepuestos = $SubTotalRepuestoStock;
	  $SubTotal = $TotalManoObra + $TotalRepuestos;
      $Impuesto = $SubTotal * ($InsGarantiaRepuestoIsuzu->GriPorcentajeImpuestoVenta/100);
	  $Total = $SubTotal + $Impuesto;
	  ?>
            
            <?php echo number_format($TotalRepuestos,2);?>
          </td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Total Mano de Obra</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsGarantiaRepuestoIsuzu->MonSimbolo);?></td>
          <td align="right" valign="top" >
            <?php echo number_format($TotalManoObra,2);?></td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Total (Base Imponible)</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsGarantiaRepuestoIsuzu->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            <?php echo number_format($SubTotal,2);?>
            
          </td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">IGV 18%</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsGarantiaRepuestoIsuzu->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            
            
            <?php
	  echo number_format($Impuesto,2);
	  ?>
          </td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstGarantiaRepuestoIsuzuImprimirEtiqueta">Total </span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsGarantiaRepuestoIsuzu->MonSimbolo);?></td>
          <td align="right" valign="top" ><?php
	  echo number_format($Total,2);
	  ?></td>
          </tr>
        <tr>
          <td height="60" colspan="2" rowspan="2" align="center" valign="bottom" >
            
            
            <?php echo $InsGarantiaRepuestoIsuzu->CliNombre;?> <?php echo $InsGarantiaRepuestoIsuzu->CliApellidoPaterno;?> <?php echo $InsGarantiaRepuestoIsuzu->CliApellidoMaterno;?><br />
            _________________________<br />
            CLIENTE  <?php echo $InsGarantiaRepuestoIsuzu->TdoNombre;?>: <?php echo $InsGarantiaRepuestoIsuzu->CliNumeroDocumento;?>
            &nbsp;
            
            </td>
          <td rowspan="2" align="center" valign="bottom" >
            
            <?php echo $InsGarantiaRepuestoIsuzu->PerNombre;?> <?php echo $InsGarantiaRepuestoIsuzu->PerApellidoPaterno;?> <?php echo $InsGarantiaRepuestoIsuzu->PerApellidoMaterno;?><br />
            ________________________<br />
            MECANICO RESPONSABLE
            &nbsp; </td>
        </tr>
        <tr>
          <td colspan="5" align="center" valign="middle" class="EstGarantiaRepuestoIsuzuImprimirEtiquetaFondo"><img src="../../imagenes/firma_garantia.png" alt=""  /> <br />
            Firma y Sello del Concesionario </td>
        </tr>
        </table>
  
  </td>
</tr>
<tr>
  <td colspan="2" valign="top"></tbody>
  </td>
  </tr>

 
</table>



<?PHP
/*
?>
<div class="saltopagina"></div>



<?php
if(!empty($InsGarantiaRepuestoIsuzu->FinFotoVIN)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsGarantiaRepuestoIsuzu->FinFotoVIN;?>" width="261" height="159"   />

<?php
}
?>

<?php
if(!empty($InsGarantiaRepuestoIsuzu->FinFotoFrontal)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsGarantiaRepuestoIsuzu->FinFotoFrontal;?>" width="261" height="159"   />

<?php
}
?>


<?php
if(!empty($InsGarantiaRepuestoIsuzu->FinFotoCupon)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsGarantiaRepuestoIsuzu->FinFotoCupon;?>" width="261" height="159"   />

<?php
}
?>


<?php
if(!empty($InsGarantiaRepuestoIsuzu->FinFotoMantenimiento)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsGarantiaRepuestoIsuzu->FinFotoMantenimiento;?>" width="261" height="159"   />

<?php
}
?>

    

<?php
$i = 1;
if(!empty($InsGarantiaRepuestoIsuzu->FichaAccionFoto)){
	foreach($InsGarantiaRepuestoIsuzu->FichaAccionFoto as $DatFichaAccionFoto){
?>
	
	<img src="../../subidos/ficha_accion_fotos/<?php echo $DatFichaAccionFoto->FafArchivo;?>" width="261" height="159"  align="<?php echo $DatFichaAccionFoto->FafArchivo;?>" />
    
    <?php
	if($i%2==0){
	?>
    <br />
    <?php
	}
	?>
    
<?php
	$i++;
	}
}
?>
<?PHP
*/
?>

</div>
</body>
</html>
