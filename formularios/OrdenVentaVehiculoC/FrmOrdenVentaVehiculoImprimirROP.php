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


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');


$InsPago = new ClsPago();
$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $GET_id;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(true);


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,NULL,$InsOrdenVentaVehiculo->OvvId,NULL,NULL);
$ArrPagos = $ResPago['Datos'];


$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId', 'Desc',NULL,$InsOrdenVentaVehiculo->OvvId,NULL);
$ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Venta de Vehiculo No. <?php echo $InsOrdenVentaVehiculo->OvvId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssOrdenVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsOrdenVentaVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsOrdenVentaVehiculo->OvvId)){?> 
FncOrdenVentaVehiculoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>






<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> <br /><?php echo $EmpresaCodigo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">REGISTRO DE OPERACIONES EN EFECTIVO DE MAYOR CUANTÍA</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php //echo $InsOrdenVentaVehiculo->OvvId;?></span>
        
        </td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="3%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">Ley 27693 y modificatoria Ley Nº 28306  - ORGANISMO SUPERVISOR UIDF</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">codigo de empresa :</span></td>
      <td colspan="3" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="24%" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">CODIGO OFICIAL DE CUMPLIMIENTO :</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido"> 16554402</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">FECHA :</span></td>
      <td colspan="3" align="left" valign="top" >
        
        <span class="EstOrdenVentaVehiculoImprimirContenido"><?php
	  list($Dia,$Mes,$Ano) = explode("/",$InsOrdenVentaVehiculo->OvvFecha);;
	  ?>
          Tacna, <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">TRANSACCIÓN :</span></td>
      <td colspan="3" align="left" valign="top" >
        
        <span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->VmaNombre;?> <?php echo $InsOrdenVentaVehiculo->VmoNombre;?> <?php echo $InsOrdenVentaVehiculo->VveNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">MONEDA : </span></td>
      <td align="left" valign="top" > <span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->MonNombre;?></span></td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">IMPTE EFECTIVO : </span></td>
      <td align="left" valign="top" >
      
      
        <?php

			if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){
				if(!empty($InsOrdenVentaVehiculo->OvvTipoCambio)){
					$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,2);

				}else{
					$InsOrdenVentaVehiculo->OvvTotal = 0;
				}
			}
			
?>
   <span class="EstOrdenVentaVehiculoImprimirContenido">            
  <?php echo number_format($InsOrdenVentaVehiculo->OvvTotal,2);?>
  </span>
  
  
  
  </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="center" valign="top" ><hr /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">solicitante :</span></td>
      <td colspan="3" align="left" valign="top" >
      
      
      <span class="EstOrdenVentaVehiculoImprimirContenido"> 
	  
<?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
		<?php echo $DatOrdenVentaVehiculoPropietario->CliNombre?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno?> /
<?php		
	}
}
?>
<!--<br />-->

<?php
/*if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>

		 <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>: <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?> / 

<?php		
	}
}*/
?>
	  
	
       </span>
       
       
       
       </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $InsOrdenVentaVehiculo->TdoNombre;?> :</span></td>
      <td colspan="3" align="left" valign="top" >
      
      <span class="EstOrdenVentaVehiculoImprimirContenido"> <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>

		 <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?> / 

<?php		
	}
}
?></span>

</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">DIRECCION :</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
        <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
        <?php echo $DatOrdenVentaVehiculoPropietario->CliDireccion;?>
        <?php	
		
		break;	
	}
}
?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">TELEFONO :</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
        <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
        <?php echo $DatOrdenVentaVehiculoPropietario->CliTelefono;?> - <?php echo $DatOrdenVentaVehiculoPropietario->CliCelular;?>
        <?php	
		
		break;	
	}
}
?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">OCUPACION :</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
        <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
        <?php echo $DatOrdenVentaVehiculoPropietario->CliActividadEconomica;?>
        <?php	
		
		break;	
	}
}
?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" ><hr /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">ORDENANTE :</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
        <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
        <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno?> /
        <?php		
	}
}
?>
        <!--<br />-->
        <?php
/*if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>

		 <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>: <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?> / 

<?php		
	}
}*/
?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $InsOrdenVentaVehiculo->TdoNombre;?> :</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
        <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
        <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?> /
        <?php		
	}
}
?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">DIRECCION :</span></td>
      <td colspan="3" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" ><hr /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">ORDENANTE :</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">EL MISMO</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">DNI :</span></td>
      <td colspan="3" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">DIRECCION :</span></td>
      <td colspan="3" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" ><hr /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" ><p><span class="EstOrdenVentaVehiculoImprimirContenido">ORIGEN DE LOS FONDOS:  DECLARO BAJO JURAMENTO QUE LOS FONDOS DE ESTA TRANSACCION PROCEDE DE ACTIVIDADES LICITAS.</span></p>
        <p><span class="EstOrdenVentaVehiculoImprimirContenido">LO CUAL NO PROVIENE Y NO CONSTITUYE LAVADO DE ACTIVOS Y OTROS DELITOS RELACION DOS CON LA MINERIA INFORMAL Y CRIMEN ORGANIZADO</span></p></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" ><!--<img src="../../imagenes/sello_cyc.png" width="246" height="130" />-->
        
        <table width="100%">
          <tr>
            <?php
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
            
            
            <td height="100" align="center" valign="bottom">
              
              <span class="EstOrdenVentaVehiculoImprimirNota3"> <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> <br />
                
                <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>:  <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?><br />
                </span>    
              
              
              </td>
            <?php
	}
	?>
            
            </tr>
          </table>
        
        
        
        
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>




 
 
</body>
</html>
