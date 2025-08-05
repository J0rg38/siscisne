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

<?php
$GET_VehiculoIngresoId = $_GET['VehiculoIngresoId'];
$GET_VehiculoIngresoVIN = $_GET['VehiculoIngresoVIN'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsVehiculoIngreso = new ClsVehiculoIngreso();

$InsVehiculoIngreso->EinId = $GET_VehiculoIngresoId;
$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);


?>
<!--<style type="text/css">
@import url('comunes/Cliente/css/CssCliente.css');
</style>-->

<?php
if(!empty($GET_VehiculoIngresoId)){
?>
    
    <div class="EstFormularioArea">
    <table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstFormulario">
    
    <tr>
      <td>&nbsp;</td>
      <td width="709">Resumen de Mantenimientos:<br />
      
	<span class="EstFormularioEtiqueta">MARCA:</span>   <?php echo $InsVehiculoIngreso->VmaNombre;?> 
	<span class="EstFormularioEtiqueta">MODELO: </span>  <?php echo $InsVehiculoIngreso->VmoNombre;?> 
	 <span class="EstFormularioEtiqueta">VERSION: </span> <?php echo $InsVehiculoIngreso->VveNombre;?> <br />
	<span class="EstFormularioEtiqueta">VIN:</span> <?php echo $InsVehiculoIngreso->EinVIN;?> 
 <span class="EstFormularioEtiqueta">PLACA:</span> <?php echo $InsVehiculoIngreso->EinPlaca;?> 
       </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="1" align="left">&nbsp;</td>
      <td align="left">
      
      
    <?php
        switch($InsVehiculoIngreso->VmaId){
            case "VMA-10018":
    ?>
    <?php
        if(!empty($InsPlanMantenimiento->PmaChevroletKilometrajesResumen)){
    ?>
    <table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstTablaListado">
    <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%" align="center">#</th>
      <th width="21%" align="center">Km / Mant.</th>
      <th width="40%" align="center">Sucursal</th>
      <th width="40%" align="center">OT</th>
      <th width="37%" align="center">Fecha</th>
    </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    
    <?php
    //		foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatVehiculoPromocion30k){
        
            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesNuevo as $DatKilometroEtiqueta => $DatKilometro){
    ?>
    
            <?php
			$InsFichaIngreso = new ClsFichaIngreso();
            $InsFichaIngreso->MtdObtenerFichaIngresoMantenimientos($GET_VehiculoIngresoId,$DatKilometro['km']);
            ?>
            
            <tr>
            
            <td align="center"><?php echo $c;?></td>
            <td align="right"><?php echo  $DatKilometro['km'];?> km</td>
            <td align="right"><?php
            echo $InsFichaIngreso->SucNombre;
            ?></td>
            <td align="right">
          
            <?php
            echo $InsFichaIngreso->FinId;
            ?>
            
            </td>
            <td align="right">
                <?php
            echo $InsFichaIngreso->FinFecha;
            ?>
            </td>
            </tr>
    <?php
            }
    ?>
    
    
        </tbody>
        </table>
        
     <?php
        }else{
    ?>
        No se encontro informacion de mantenimients
    <?php		
        }
    ?>   
    
    <?php	
            break;
            
            default:
    ?>
    <?php
        if(!empty($InsPlanMantenimiento->PmaChevroletKilometrajesResumen)){
    ?>
    <table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstTablaListado">
    <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%" align="center">#</th>
      <th width="21%" align="center">Km / Mant.</th>
      <th width="40%" align="center">Sucursal</th>
      <th width="40%" align="center">OT</th>
      <th width="37%" align="center">Fecha</th>
    </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    
    <?php
    //		foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatVehiculoPromocion30k){
        
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajesNuevo as $DatKilometroEtiqueta => $DatKilometro){
    ?>
    
            <?php
			$InsFichaIngreso = new ClsFichaIngreso();
            $InsFichaIngreso->MtdObtenerFichaIngresoMantenimientos($GET_VehiculoIngresoId,$DatKilometro['km']);
            ?>
            
            <tr>
            
            <td align="center"><?php echo $c;?></td>
            <td align="right"><?php echo  $DatKilometro['km'];?> km</td>
            <td align="right"><?php
            echo $InsFichaIngreso->SucNombre;
            ?></td>
            <td align="right">
          
            <?php
            echo $InsFichaIngreso->FinId;
            ?>
            
            </td>
            <td align="right">
                <?php
            echo $InsFichaIngreso->FinFecha;
            ?>
            </td>
            </tr>
    <?php
            }
    ?>
    
    
        </tbody>
        </table>
        
     <?php
        }else{
    ?>
        No se encontro informacion de mantenimients
    <?php		
        }
    ?>   
    
    <?php
            break;
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

<?php	
}else{
?>
	No se encontro informacion del vehiculo
<?php	
}
?>




</body>
</html>
