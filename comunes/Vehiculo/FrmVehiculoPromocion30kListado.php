<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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

$GET_VehiculoIngresoId = $_GET['VehiculoIngresoId'];
$GET_VehiculoIngresoVIN = $_GET['VehiculoIngresoVIN'];

require_once($InsPoo->MtdPaqVentas().'ClsVehiculoPromocion20k.php');
require_once($InsPoo->MtdPaqVentas().'ClsVehiculoPromocion30k.php');

$InsVehiculoPromocion30k = new ClsVehiculoPromocion30k();
$ResVehiculoPromocion30k = $InsVehiculoPromocion30k->MtdObtenerVehiculoPromocion30ks(NULL,NULL,'EinVIN','ASC',NULL,$GET_VehiculoIngresoId);
$ArrVehiculoPromocion30ks = $ResVehiculoPromocion30k['Datos'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssPrincipal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
</head>
<body>
<!--<style type="text/css">
@import url('comunes/Cliente/css/CssCliente.css');
</style>-->

<div class="EstFormularioArea">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstFormulario">

<tr>
  <td>&nbsp;</td>
  <td width="709">Resumen Promocion 20k</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="1" align="left">&nbsp;</td>
  <td align="left">
  
<?php
	if(!empty($ArrVehiculoPromocion30ks)){
?>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstTablaListado">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" rowspan="2" align="center">#</th>
  <th width="6%" rowspan="2" align="center">VIN</th>
  <th colspan="2" align="center">1 km</th>
  <th colspan="2" align="center">5 km</th>
  <th colspan="2" align="center">10 km</th>
  <th colspan="2" align="center">15 km</th>
  <th colspan="2" align="center">20 km</th>
  <th colspan="2" align="center">30</th>
  </tr>
<tr>
  <th width="50" align="center">OT </th>
  <th width="50" align="center">Fecha </th>
  
  <th width="50" align="center">OT </th>
  <th width="50" align="center">Fecha </th>
  
  <th width="50" align="center">OT </th>
  <th width="50" align="center">Fecha </th>
  
  <th width="50" align="center">OT </th>
  <th width="50" align="center">Fecha </th>
  
  <th width="50" align="center">OT </th>
  <th width="50" align="center">Fecha</th>
  <th width="50" align="center">OT</th>
  <th width="50" align="center">Fecha </th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">

<?php
		foreach($ArrVehiculoPromocion30ks as $DatVehiculoPromocion30k){
?>
        <tr>
        
        <td align="center"><?php echo $c;?></td>
        <td align="right"><?php echo $DatVehiculoPromocion30k->EinVIN;?></td>
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinId1000;?></td>
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinFecha1000;?></td>
        
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinId5000;?></td>
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinFecha5000;?></td>
        
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinId10000;?></td>
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinFecha10000;?></td>
        
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinId15000;?></td>
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinFecha15000;?></td>
        
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinId20000;?></td>
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinFecha20000;?></td>
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinId30000;?></td>
        <td width="50" align="right"><?php echo $DatVehiculoPromocion30k->FinFecha30000;?></td>
        
        </tr>
<?php
		}
?>


	</tbody>
	</table>
    
 <?php
	}else{
?>
	No se encontro informacion de 20k
<?php		
	}
?>   
   </td>
  <td width="1" align="left">&nbsp;</td>
</tr>


<tr>
  <td>&nbsp;</td>
  <td>
  
  
  </td>
  <td>&nbsp;</td>
</tr>
</table>


</div>





</body>
</html>
