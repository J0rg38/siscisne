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

require_once($InsPoo->MtdPaqActividad().'ClsReclamo.php');
require_once($InsPoo->MtdPaqActividad().'ClsReclamoFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsReclamoDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');


$InsReclamo = new ClsReclamo();

$InsReclamo->GarId = $GET_id;
$InsReclamo->MtdObtenerReclamo();

if($InsReclamo->MonId <> $EmpresaMonedaId){
	if(empty($InsReclamo->GarTipoCambio)){
		die("No se encontro tipo de cambio.");
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RECLAMO No. <?php echo $InsReclamo->GarId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssReclamoImprimir.css" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="js/JsReclamoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsReclamo->GarId)){?> 
FncReclamoImprimir(); 
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



<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstReclamoImprimirTabla">

<tr>
  <td colspan="2" align="center" valign="top"><span class="EstPlantillaTitulo">HOJA DE RECANTÍA POST-ENTREGA- REPUESTOS/ALMACEN</span> </td>
</tr>
<tr>
  <td colspan="2" valign="top">
  
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstReclamoImprimirTabla">
      <tbody class="EstReclamoImprimirTablaBody">
        <tr>
          <td colspan="5" align="center" valign="top" class="EstReclamoImprimirSubTituloFondo"><span class="EstReclamoImprimirSubTitulo">INFORMACION VEHICULAR</span></td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo">
            
            <span class="EstReclamoImprimirModalidadIngreso">
              <?php
		  	echo $InsReclamo->MinNombre
		  ?>
              
              </span>
          </td>
          </tr>
        <tr>
          <td width="124" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">PLACA: </span></td>
          <td width="131" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">VIN: </span></td>
          <td colspan="3" align="center" valign="top" ><span class="EstReclamoImprimirEtiqueta">MODELO VEHICULAR</span></td>
      
 
      
          <td width="234" align="center" valign="top" class="EstReclamoImprimirSubTituloFondo">
     
           <span class="EstReclamoImprimirSubTitulo">N°: <?php echo $InsReclamo->GarId;?></span>
          
          </td>
          </tr>
        <tr>
          <td rowspan="2" align="center" valign="top" ><span class="EstReclamoImprimirContenido"><?php echo $InsReclamo->EinPlaca;?></span></td>
          <td rowspan="2" align="center" valign="top" ><span class="EstReclamoImprimirContenido"><?php echo $InsReclamo->EinVIN;?></span></td>
          <td colspan="3" rowspan="2" align="center" valign="top" ><span class="EstReclamoImprimirContenido">
            
            <?php echo $InsReclamo->GarModelo;?><br />
            Color: <?php echo $InsReclamo->EinColor;?> A&ntilde;o Fab.: <?php echo $InsReclamo->EinAnoFabricacion;?> Nro. Motor: <?php echo $InsReclamo->EinNumeroMotor;?>
            </span>
            
          </td>
          <td align="left" valign="middle">
            
            <span class="EstReclamoImprimirContenido"> Orden de Trabajo: <?php echo $InsReclamo->FinId;?></span>
            
          </td>
        </tr>
        <tr>
          <td align="left" valign="middle">
         <span class="EstReclamoImprimirContenido"> Boletin de Servicio: <?php echo $InsReclamo->CamBoletinCodigo;?></span>
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
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstReclamoImprimirTabla">
      <tbody class="EstReclamoImprimirTablaBody">
        <tr>
          <td colspan="8" align="center" valign="top" class="EstReclamoImprimirSubTituloFondo"><span class="EstReclamoImprimirSubTitulo">INFORMACION GENERAL</span> <br /></td>
          </tr>
        <tr>
          <td width="210" rowspan="2" align="left" valign="top" class="EstReclamoImprimirEtiquetaFondo">
            
            <span class="EstReclamoImprimirContenido">
              Identificación Concesionario:<br />
              Nombre:  C & C S.A.C<br />
              Dirección:  Urb. Los cedros Mz B Lt 10<br />
              Ciudad:   Tacna
              </span>
            
          </td>
          <td width="579" colspan="-4" rowspan="2" align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">IDENTIFICACION PROPIETARIO</span>
            
            <span class="EstReclamoImprimirEtiqueta">Nombre:</span> 
            
            <span class="EstReclamoImprimirContenido"><?php echo $InsReclamo->CliNombre;?> <?php echo $InsReclamo->CliApellidoPaterno;?> <?php echo $InsReclamo->CliApellidoMaterno;?></span><br />
            
            <span class="EstReclamoImprimirEtiqueta">Telefono:</span> 
            <span class="EstReclamoImprimirContenido"><?php echo $InsReclamo->GarTelefono;?></span>
            
            <span class="EstReclamoImprimirEtiqueta">Celular:</span> 
            <span class="EstReclamoImprimirContenido"><?php echo $InsReclamo->GarCelular;?></span><br />
            
             
            <span class="EstReclamoImprimirEtiqueta">Direccion:</span> 
            <span class="EstReclamoImprimirContenido"><?php echo $InsReclamo->GarDireccion;?></span><br />
            
            <span class="EstReclamoImprimirEtiqueta">Ciudad:</span> 
            <span class="EstReclamoImprimirContenido"><?php echo $InsReclamo->GarCiudad;?></span><br />
            
            <span class="EstReclamoImprimirEtiqueta">Poliza N°: </span>
            <span class="EstReclamoImprimirContenido"><?php echo $InsReclamo->EinPoliza;?></span><br />            </td>
          <td width="71" colspan="-4" rowspan="2" align="center" valign="middle" ><span class="EstReclamoImprimirEtiqueta">Fecha DE RECLAMO</span></td>
          <td width="169" colspan="-6" align="center" valign="middle"><span class="EstReclamoImprimirContenido">Fecha de Apertura: <?php echo $InsReclamo->GarFechaEmision;?></span></td>
        </tr>
        <tr>
          <td width="169" colspan="-6" align="center" valign="middle"><span class="EstReclamoImprimirContenido">Fecha de Cierre: <?php echo $InsReclamo->FinTiempoTrabajoTerminado;?></span></td>
        </tr>
        </table>
  
  </td>
</tr>
<tr>
  <td colspan="2" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstReclamoImprimirTabla">
      <tbody class="EstReclamoImprimirTablaBody">
        <tr>
          <td colspan="12" align="center" valign="top" class="EstReclamoImprimirSubTituloFondo"><span class="EstReclamoImprimirSubTitulo">DETALLE DEL TRABAJO REALIZADO</span><br /></td>
        </tr>
        <tr>
          <td colspan="5" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">Fecha DE VENTa vehicular</span></td>
          <td colspan="4" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">tiempo del trabajo</span></td>
          <td width="161" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">KILOMETRAJE</span></td>
          <td width="143" colspan="2" align="center" valign="top" ><span class="EstReclamoImprimirEtiqueta">N° LINEA (ELEVADOR)</span></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirContenido">Fecha: <?php echo $InsReclamo->GarFechaVenta;?></span></td>
          <td colspan="4" rowspan="2" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo">&nbsp;</td>
          <td rowspan="2" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirContenido"><?php echo number_format($InsReclamo->FinVehiculoKilometraje,2);?></span></td>
          <td colspan="2" rowspan="2" align="center" valign="top" >1</td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirContenido">Dealer: <?php echo $InsReclamo->OncNombre;?></span></td>
          </tr>
        <tr>
          <td width="31" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">1</span></td>
          <td width="40" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">2</span></td>
          <td width="34" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">3</span></td>
          <td width="37" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">4</span></td>
          <td width="47" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">5</span></td>
          <td colspan="4" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">TEMPARIO SERVICE INFORMATION</span></td>
          <td colspan="3" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">CAUSA DE PROBLEMA</span></td>
          </tr>
        <tr>
          <td width="31" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">6</span></td>
          <td width="40" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">7</span></td>
          <td width="34" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">8</span></td>
          <td width="37" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">9</span></td>
          <td width="47" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">10</span></td>
          <td width="121" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">Operación Nº</span></td>
          <td width="47" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">T</span></td>
          <td width="127" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">VALOR</span></td>
          <td width="93" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">M/O</span></td>
          <td colspan="3" rowspan="3" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirContenido">
		  
          <?php
		  if(empty($InsReclamo->GarCausa)){
			 ?>
              <?php $InsReclamo->GarCausa = $InsReclamo->FccCausa;?>
             <?php
		  }
		  ?>
		 <?php echo $InsReclamo->GarCausa;?>
         
          
          </span></td>
          </tr>
        <tr>
          <td width="31" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">11</span></td>
          <td width="40" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">12</span></td>
          <td width="34" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">13</span></td>
          <td width="37" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">14</span></td>
          <td width="47" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">15</span></td>
          <td rowspan="6" align="right" valign="top" class="EstReclamoImprimirEtiquetaFondo"><?php
	if(!empty($InsReclamo->ReclamoFoto)){
		foreach($InsReclamo->ReclamoFoto as $DatReclamoFoto){
	?>
            <?php echo $DatReclamoFoto->GopNumero;?><br />
            <?php
		}
	}
	?></td>
          <td rowspan="6" align="right" valign="top" class="EstReclamoImprimirEtiquetaFondo"><?php
	if(!empty($InsReclamo->ReclamoFoto)){
		foreach($InsReclamo->ReclamoFoto as $DatReclamoFoto){
	?>
            <?php echo number_format($DatReclamoFoto->GopTiempo,2);?><br />
            <?php
		}
	}
	?></td>
          <td rowspan="6" align="right" valign="top" class="EstReclamoImprimirEtiquetaFondo"><?php
	if(!empty($InsReclamo->ReclamoFoto)){
		foreach($InsReclamo->ReclamoFoto as $DatReclamoFoto){
			
			if($InsReclamo->MonId<>$EmpresaMonedaId){
				$DatReclamoFoto->GopValor = round($DatReclamoFoto->GopValor / $InsReclamo->GarTipoCambio,2);				
			}
	?>
            <?php echo number_format($DatReclamoFoto->GopValor,2);?><br />
            <?php
		}
	}
	?></td>
          <td rowspan="6" align="right" valign="top" class="EstReclamoImprimirEtiquetaFondo"><?php
	  $TotalManoObra = 0;
	  ?>
            <?php
	if(!empty($InsReclamo->ReclamoFoto)){
		foreach($InsReclamo->ReclamoFoto as $DatReclamoFoto){
			
			
			if($InsReclamo->MonId<>$EmpresaMonedaId){
				$DatReclamoFoto->GopCosto = round($DatReclamoFoto->GopCosto / $InsReclamo->GarTipoCambio,2);
				
			}
			
			
	?>
            <?php echo number_format($DatReclamoFoto->GopCosto,2);?><br />
            <?php $TotalManoObra += $DatReclamoFoto->GopCosto;?>
            <?php
		}
	}
	?></td>
          </tr>
        <tr align="center">
          <td width="31" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">16</span></td>
          <td width="40" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">17</span></td>
          <td width="34" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">18</span></td>
          <td width="37" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">19</span></td>
          <td width="47" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">20</span></td>
          </tr>
        <tr>
          <td colspan="5" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">Devolución / Rechazo</span></td>
          <td colspan="3" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">SOLUCION AL PROBLEMA</span></td>
          </tr>
        <tr>
          <td width="31" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">21</span></td>
          <td width="40" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">22</span></td>
          <td width="34" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">23</span></td>

          <td width="37" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">24</span></td>
          <td width="47" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">25</span></td>
          <td colspan="3" rowspan="4" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"> <?php echo $InsReclamo->GarSolucion;?></td>
          </tr>
        <tr align="center">
          <td width="31" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">26</span></td>
          <td width="40" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">27</span></td>
          <td width="34" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">28</span></td>
          <td width="37" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">29</span></td>
          <td width="47" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">30</span></td>
          </tr>
        <tr align="center">
          <td width="31" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">31</span></td>
          <td width="40" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">32</span></td>
          <td width="34" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">33</span></td>
          <td width="37" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">34</span></td>
          <td width="47" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">35</span></td>
          </tr>
        <tr>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">36</span></td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">37</span></td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">38</span></td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">39</span></td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">40</span></td>
          <td colspan="3" align="right" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">TOTAL MANO DE OBRA:</span></td>
          <td align="right" valign="top" class="EstReclamoImprimirEtiquetaFondo"><?php echo number_format($TotalManoObra,2);?></td>
          </tr>
        </table></td>
</tr>
<tr>
  <td colspan="2" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" valign="top">
  
  <table width="100%" border="0" cellpadding="2" cellspacing="0" class="EstReclamoImprimirTabla">
      <tbody class="EstReclamoImprimirTablaBody">
        <tr>
          <td width="31" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">item</span></td>
          <td width="71" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">M/O</span></td>
          <td width="84" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">T.C.</span></td>
          <td width="82" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">P</span></td>
          <td width="79" align="center" valign="top" ><span class="EstReclamoImprimirEtiqueta">NUMERO DE REP.</span></td>
          <td width="418" align="center" valign="top" ><span class="EstReclamoImprimirEtiqueta">DESCRIPCION</span></td>
          <td width="107" colspan="-1" align="center" valign="top" ><span class="EstReclamoImprimirEtiqueta">CANT.</span></td>
          <td width="118" align="center" valign="top" ><span class="EstReclamoImprimirEtiqueta">COSTO</span></td>
          <td width="107" align="center" valign="top" ><span class="EstReclamoImprimirEtiqueta">CREDITO</span></td>
        </tr>
        
        
        <?php
		
		$SubTotalRepuestoStock = 0;
	$item = 1;	
	if(!empty($InsReclamo->ReclamoDetalle)){
		foreach($InsReclamo->ReclamoDetalle as $DatReclamoDetalle){
	?>
           

        <tr>
          <td align="right" valign="top" class="EstReclamoImprimirEtiquetaFondo"><?php echo $item;?>.- </td>
          <td align="right" valign="top" class="EstReclamoImprimirEtiquetaFondo">&nbsp;</td>
          <td align="left" valign="top" class="EstReclamoImprimirEtiquetaFondo">&nbsp;</td>
          <td align="left" valign="top" class="EstReclamoImprimirEtiquetaFondo">&nbsp;</td>
          <td align="center" valign="top" ><span class="EstReclamoImprimirEtiquetaFondo">
            
            <?php echo $DatReclamoDetalle->GdeCodigo;?>
           
            </span></td>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiquetaFondo">
            
            <?php echo $DatReclamoDetalle->GdeDescripcion;?><br />
           
            </span></td>
          <td colspan="-1" align="right" valign="top" ><span class="EstReclamoImprimirEtiquetaFondo">
          
            <?php echo number_format($DatReclamoDetalle->GdeCantidad,2);?>
           

            </span></td>
          <td align="right" valign="top" ><span class="EstReclamoImprimirEtiquetaFondo">
   
            <?php

			if($InsReclamo->MonId<>$EmpresaMonedaId){
				$DatReclamoDetalle->GdeCosto = round($DatReclamoDetalle->GdeCosto / $InsReclamo->GarTipoCambio,2);
			}
			
			
	?>
            <?php echo number_format($DatReclamoDetalle->GdeCosto,2);?><br />
            <?php $SubTotalRepuestoStock += $DatReclamoDetalle->GdeCosto;?>

            </span></td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
          
             <?php
			 $item++;
		}
	}
	?>         
          
            <tr>
               <td colspan="10" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo">&nbsp;</td>
            </tr>
            <tr>
          <td colspan="2" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">RECLAMO</span></td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">POLITICA</span></td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">CAMPAÑA</span></td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><span class="EstReclamoImprimirEtiqueta">OTRO</span></td>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">Sub total Repuestos Stock</span></td>
          <td align="right" valign="top" ><?php echo ($InsReclamo->MonSimbolo);?></td>
          <td align="right" valign="top" ><?php echo number_format($SubTotalRepuestoStock,2); ?></td>
          <td colspan="2" align="right" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="2" align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo">
            
            <?php
	if($InsReclamo->MinId == "MIN-10000"){
	?>
            <span class="EstReclamoImprimirContenido">X</span>
            <?php
	}
	?>          </td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><?php
	if($InsReclamo->MinId == "MIN-10010"){
	?>
            <span class="EstReclamoImprimirContenido">X</span>
            <?php
	}
	?></td>
          <td align="center" valign="top" class="EstReclamoImprimirEtiquetaFondo"><?php
	if($InsReclamo->MinId == "MIN-10008"){
	?>
            <span class="EstReclamoImprimirContenido">X</span>
            <?php
	}
	?></td>
          <td align="center" valign="top" >&nbsp;</td>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">% Factor</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsReclamo->MonSimbolo);?></td>
          <td align="right" valign="top" >&nbsp;</td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="5" rowspan="8" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo">&nbsp;</td>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">Sub total Repuestos Otros</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsReclamo->MonSimbolo);?></td>
          <td align="right" valign="top" >&nbsp;</td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">% Factor</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsReclamo->MonSimbolo);?></td>
          <td align="right" valign="top" >&nbsp;</td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">Total Repuestos</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsReclamo->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            <?php
	  $TotalRepuestos = $SubTotalRepuestoStock;
	  $SubTotal = $TotalManoObra + $TotalRepuestos;
      $Impuesto = $SubTotal * ($InsReclamo->GarPorcentajeImpuestoVenta/100);
	  $Total = $SubTotal + $Impuesto;
	  ?>
            
            <?php echo number_format($TotalRepuestos,2);?>
            </td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">Total Mano de Obra</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsReclamo->MonSimbolo);?></td>
          <td align="right" valign="top" >
            <?php echo number_format($TotalManoObra,2);?></td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">Total (Base Imponible)</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsReclamo->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            <?php echo number_format($SubTotal,2);?>
            
            </td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">IGV 18%</span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsReclamo->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            
            
            <?php
	  echo number_format($Impuesto,2);
	  ?>
            </td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="top" ><span class="EstReclamoImprimirEtiqueta">Total </span></td>
          <td colspan="-1" align="right" valign="top" ><?php echo ($InsReclamo->MonSimbolo);?></td>
          <td align="right" valign="top" ><?php
	  echo number_format($Total,2);
	  ?></td>
          <td align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td height="60" colspan="2" rowspan="2" align="center" valign="bottom" >
            
            
            <?php echo $InsReclamo->CliNombre;?> <?php echo $InsReclamo->CliApellidoPaterno;?> <?php echo $InsReclamo->CliApellidoMaterno;?><br />
            _________________________<br />
            CLIENTE  <?php echo $InsReclamo->TdoNombre;?>: <?php echo $InsReclamo->CliNumeroDocumento;?>
            &nbsp;
            
            </td>
          <td colspan="2" rowspan="2" align="center" valign="bottom" >
            
            <?php echo $InsReclamo->PerNombre;?> <?php echo $InsReclamo->PerApellidoPaterno;?> <?php echo $InsReclamo->PerApellidoMaterno;?><br />
            ____________________________<br />
            MECANICO RESPONSABLE
            &nbsp; </td>
        </tr>
        <tr>
          <td colspan="5" align="center" valign="middle" class="EstReclamoImprimirEtiquetaFondo"><img src="../../imagenes/firma_garantia.png" alt=""  /> <br />
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
if(!empty($InsReclamo->FinFotoVIN)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsReclamo->FinFotoVIN;?>" width="261" height="159"   />

<?php
}
?>

<?php
if(!empty($InsReclamo->FinFotoFrontal)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsReclamo->FinFotoFrontal;?>" width="261" height="159"   />

<?php
}
?>


<?php
if(!empty($InsReclamo->FinFotoCupon)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsReclamo->FinFotoCupon;?>" width="261" height="159"   />

<?php
}
?>


<?php
if(!empty($InsReclamo->FinFotoMantenimiento)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsReclamo->FinFotoMantenimiento;?>" width="261" height="159"   />

<?php
}
?>

    

<?php
$i = 1;
if(!empty($InsReclamo->FichaAccionFoto)){
	foreach($InsReclamo->FichaAccionFoto as $DatFichaAccionFoto){
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
