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


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalleFoto.php');

$InsVehiculoRecepcion = new ClsVehiculoRecepcion();

$InsVehiculoRecepcion->VreId = $GET_id;
$InsVehiculoRecepcion->MtdObtenerVehiculoRecepcion();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recepcion de Vehiculo No. <?php echo $InsVehiculoRecepcion->VreId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssVehiculoRecepcion.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVehiculoRecepcionImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsVehiculoRecepcion->VreId)){?> 
FncVehiculoRecepcionImprimir(); 
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



<div class="EstVehiculoRecepcionCabecera">

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


<div class="EstVehiculoRecepcionCabeceraAux">

</div>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoRecepcionImprimirTabla">

<!--<tr>
  <td height="70" valign="top">&nbsp;</td>
  <td height="70" colspan="2" valign="top">&nbsp;</td>
  <td height="70">&nbsp;</td>
</tr>-->
<tr>
  <td width="1%" valign="top">&nbsp;</td>
  <td width="98%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="2" class="EstVehiculoRecepcionImprimirTabla">
    <tr>
      <td colspan="6" align="center" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo">
      
      <span class="EstPlantillaTitulo">RECEPCION DE VEHICULO </span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsVehiculoRecepcion->VreId;?></span>
        
        </td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="16%" align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo">&nbsp;</td>
      <td width="3%" align="left" valign="top" >&nbsp;</td>
      <td width="35%" align="left" valign="top" >&nbsp;</td>
      <td width="12%" align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo">&nbsp;</td>
      <td width="3%" align="left" valign="top" >&nbsp;</td>
      <td width="28%" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo"><span class="EstVehiculoRecepcionImprimirEtiqueta">Fecha </span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirFecha"><?php echo $InsVehiculoRecepcion->VreFecha;?></span></td>
      <td align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo"><span class="EstVehiculoRecepcionImprimirEtiqueta">VIN </span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirContenido"><?php echo $InsVehiculoRecepcion->EinVIN;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo"><span class="EstVehiculoRecepcionImprimirEtiqueta">¿TIENE GUIA DE REMISION?. </span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirContenido">
	  
      <?php
	  
	  echo $InsVehiculoRecepcion->VreTieneGuia;
	  
	  /*switch($InsVehiculoRecepcion->VreTieneGuia){
			case "1":
		?>
        SI
        <?php	
			break;
			
			case "2":
		?>
        NO
        <?php	
			break;  
	  }*/
	  ?>
      
      </span></td>
      <td align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo"><span class="EstVehiculoRecepcionImprimirEtiqueta">MARCA </span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirContenido"><?php echo $InsVehiculoRecepcion->VmaNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo"><span class="EstVehiculoRecepcionImprimirEtiqueta">NUM. DE GUIA REMISION:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirContenido"><?php echo $InsVehiculoRecepcion->VreGuiaRemisionNumero;?></span></td>
      <td align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo"><span class="EstVehiculoRecepcionImprimirEtiqueta">MODELO </span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirContenido"><?php echo $InsVehiculoRecepcion->VmoNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo"><span class="EstVehiculoRecepcionImprimirEtiqueta">COLOR </span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirContenido"><?php echo $InsVehiculoRecepcion->EinColor;?></span></td>
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





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoRecepcionImprimirTabla">


	<tr>
		
        <td width="3" valign="top">&nbsp;</td>
  <td colspan="3" align="center" valign="top"><span class="EstVehiculoRecepcionImprimirCabecera">DETALLES</span></td>
  <td width="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td colspan="3" valign="top"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVehiculoRecepcionImprimirTabla">
    <thead class="EstVehiculoRecepcionImprimirTablaHead">
      <tr>
        <th width="21" align="center" valign="middle" >#</th>
        <th width="177" align="center" valign="middle" >ZONA COMPROMETIDA</th>
       
        <th width="191" align="center" valign="middle" >detalle del repuesto</th>
       
       
        <th width="177" align="center" valign="middle" >solucion</th>
        <th width="186" align="center" valign="middle" >observacion</th>
       
        <th width="251" align="center" valign="middle" >FOTOS</th>
       
        </tr>
      </thead>
    <tbody class="EstVehiculoRecepcionImprimirTablaBody">
      <?php


	$TotalRepuesto = 0;
	$TotalDescuento = 0;
	
	$i=1;
	if(!empty($InsVehiculoRecepcion->VehiculoRecepcionDetalle)){
		foreach($InsVehiculoRecepcion->VehiculoRecepcionDetalle as $DatVehiculoRecepcionDetalle){

		
			

?>
      <tr>
        <td align="center" class="EstVehiculoRecepcionDetalleImprimirContenido"><?php echo $i;?></td>
        <td align="right" class="EstVehiculoRecepcionDetalleImprimirContenido"><?php echo $DatVehiculoRecepcionDetalle->VrdZonaComprometida;?></td>
        
     
        <td align="right" class="EstVehiculoRecepcionDetalleImprimirContenido" >
          <?php echo $DatVehiculoRecepcionDetalle->VrdRepuestoDetalle;?>
          </td>
       

        <td align="right" class="EstVehiculoRecepcionDetalleImprimirContenido" >
          
         
          
          <?php echo $DatVehiculoRecepcionDetalle->VrdSolucion;?>
          
          </td>
        <td align="right" class="EstVehiculoRecepcionDetalleImprimirContenido" ><?php echo ($DatVehiculoRecepcionDetalle->VrdObservacion);?></td>
   
        <td align="right" class="EstVehiculoRecepcionDetalleImprimirContenido" >
        
        
<?php
if($DatVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto){
	foreach($DatVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto as $DatVehiculoRecepcionDetalleFoto){
?>

<a target="_blank" href="../../subidos/vehiculo_recepcion_fotos/<?php echo $DatVehiculoRecepcionDetalleFoto->VrfArchivo;?>">
<img src="../../subidos/vehiculo_recepcion_fotos/<?php echo $DatVehiculoRecepcionDetalleFoto->VrfArchivo;?>" alt="<?php echo $DatVehiculoRecepcionDetalleFoto->VrfArchivo;?>" title="<?php echo $DatVehiculoRecepcionDetalleFoto->VrfArchivo;?>" width="40" height="40" border="0" />
</a>

<?php	
	}
}
?>           


        </td>
      
        
        
        </tr>
      <?php	

		
			
		$i++;
			
		}
	} 
?>
      
      
      </tbody>
    </table></td>
  <td width="5" valign="top">&nbsp;</td>
</tr>



</table>












<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoRecepcionImprimirTabla"> 
  <tr>
    <td width="1%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoRecepcionImprimirTabla">
      <tr>
        <td width="12%" align="left" valign="top" class="EstVehiculoRecepcionImprimirEtiquetaFondo"><span class="EstVehiculoRecepcionImprimirEtiqueta">Observacion:</span></td>
        <td colspan="4" align="left" valign="top" ><span class="EstVehiculoRecepcionImprimirObservacion"><?php echo $InsVehiculoRecepcion->VreObservacion;?></span></td>
        <td width="2%" align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
    <td width="1%">&nbsp;</td>
  </tr>
  
 </table> 
  
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoRecepcionImprimirTabla">  
  <tr>
    <td width="5%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="5%">&nbsp;</td>
  </tr>
  
  
</table>


        
<div class="EstVehiculoRecepcionPie">

        <span class="EstVehiculoRecepcionImprimirNota2">Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        Tel&eacute;fono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe<br />
        Inscritos en los Registros P&uacute;blicos de Tacna Ficha 2986 </span>

 </div>
<div class="EstVehiculoRecepcionPieAux">

</div>     
        
</body>
</html>
