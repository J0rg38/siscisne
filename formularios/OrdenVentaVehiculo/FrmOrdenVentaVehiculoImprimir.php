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


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $GET_id;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();

if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){

		$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		
		$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			
	}	
	

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










<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
    <tr>
      <td width="3%" align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">ORDEN DE VENTA DE VEHICULO</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsOrdenVentaVehiculo->OvvId;?></span>
        
        </td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >  
        <span class="EstOrdenVentaVehiculoImprimirTitulo">
          Cliente:
          </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="right" valign="top" ><table  class="EstOrdenVentaVehiculoImprimirTabla" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="12%" align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">RUC/DNI:</span></td>
          <td width="38%" align="left" valign="top">
          
          
          <span class="EstOrdenVentaVehiculoImprimirContenido"> <?php echo $InsOrdenVentaVehiculo->TdoNombre;?>: <?php echo $InsOrdenVentaVehiculo->CliNumeroDocumento;?> 
          
          
          
                  
<?php
		  
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
			<?php
			if($DatOrdenVentaVehiculoPropietario->CliId<>$InsOrdenVentaVehiculo->CliId){
?><br />
			<?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>: <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?> 
<?php		
			}
			?>
<?php
		}
	}
?>
          </span>
          
          </td>
          <td width="19%" align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Fecha:</span></td>
          <td width="31%" align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->OvvFecha;?></span></td>
        </tr>
        <tr>
          <td align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Nombres:</span></td>
          <td align="left" valign="top">
    
      <span class="EstOrdenVentaVehiculoImprimirContenido">
	  
	  <?php echo $InsOrdenVentaVehiculo->CliNombre;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoPaterno;?> <?php echo $InsOrdenVentaVehiculo->CliApellidoMaterno;?> 
            
<?php
		  
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
?>
			<?php
			if($DatOrdenVentaVehiculoPropietario->CliId<>$InsOrdenVentaVehiculo->CliId){
?><br />
				<?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?>
<?php		
			}
			?>
<?php
		}
	}
?>
        
         </span> 
          
          
          </td>
          <td align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Asesor de Ventas:</span></td>
          <td align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirContenido"> <?php echo $InsOrdenVentaVehiculo->PerNombre;?> <?php echo $InsOrdenVentaVehiculo->PerApellidoPaterno;?> <?php echo $InsOrdenVentaVehiculo->PerApellidoMaterno;?> </span></td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Contacto:</span></td>
          <td align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirContenido">
            <?php
		if(!empty($InsOrdenVentaVehiculo->PerTelefono)){
		?>
            Tel.: <?php echo $InsOrdenVentaVehiculo->PerTelefono;?>
            <?php
		}
		?>
            <?php
		if(!empty($InsOrdenVentaVehiculo->PerCelular)){
		?>
            / Cel.:<?php echo $InsOrdenVentaVehiculo->PerCelular;?>
            <?php
		}
		?>
            <?php
		if(!empty($InsOrdenVentaVehiculo->PerEmail)){
		?>
            /Email: <?php echo $InsOrdenVentaVehiculo->PerEmail;?>
            <?php
		}
		?>
          </span></td>
        </tr>
      </table></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >  
        <span class="EstOrdenVentaVehiculoImprimirTitulo">
          Vehiculo:
          </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="right" valign="top" >
      
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPlantillaImprimirTabla">
        <thead class="EstPlantillaImprimirTablaHead">
          <tr>
            <th width="31%">VIN</th>
            <th width="51%">Modelo</th>
            <th width="18%">Precio</th>
          </tr>
        </thead>
        <tbody class="EstPlantillaImprimirTablaBody">
          <tr>
            <td align="center" valign="middle"><span class="EstOrdenVentaVehiculoImprimirMarcaModeloVersionPrincipal"><?php echo $InsOrdenVentaVehiculo->EinVIN;?></span></td>
            <td align="center" valign="middle"><span class="EstOrdenVentaVehiculoImprimirMarcaModeloVersionPrincipal"><?php echo $InsOrdenVentaVehiculo->VmaNombre;?> <?php echo $InsOrdenVentaVehiculo->VmoNombre;?> <?php echo $InsOrdenVentaVehiculo->VveNombre;?>
              <?php //echo $InsOrdenVentaVehiculo->OvvAdicional;?>
              <?php
		if(!empty($InsOrdenVentaVehiculo->OvvAnoFabricacion)){
		?>
              - Fabricacion <?php echo $InsOrdenVentaVehiculo->OvvAnoFabricacion;?>
              <?php	
		}
		?>
              <?php
		if(!empty($InsOrdenVentaVehiculo->OvvAnoModelo)){
		?>
              - Modelo <?php echo $InsOrdenVentaVehiculo->OvvAnoModelo;?>
              <?php	
		}
		?>
        
        </span></td>
            <td align="center"><span class="EstOrdenVentaVehiculoImprimirPrecio"><?php echo $InsOrdenVentaVehiculo->MonSimbolo;?></span> <span class="EstOrdenVentaVehiculoImprimirPrecio"><?php echo number_format($InsOrdenVentaVehiculo->OvvTotal,2);?></span></td>
          </tr>
        </tbody>
      </table></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="47%" align="right" valign="top" >&nbsp;</td>
      <td width="47%" align="right" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" ><table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><?php
		

		if(!empty($InsOrdenVentaVehiculo->OvvFoto)){
		?>
            <img src="../../subidos/cotizacion_vehiculo_fotos/<?php echo $InsOrdenVentaVehiculo->OvvFoto;?>" alt="" height="105"  /> <br />
            <span class="EstOrdenVentaVehiculoImprimirSubContenido">* Foto Referencial</span>
            <?php
		}else if(!empty($InsOrdenVentaVehiculo->VveFoto)){
			
		?>
            <img src="../../subidos/vehiculo_version_fotos/<?php echo $InsOrdenVentaVehiculo->VveFoto;?>" alt="" height="105"  /> <br />
            <span class="EstOrdenVentaVehiculoImprimirReferencias">* Foto Referencial</span>
            <?php
		}
		?></td>
          <td align="center"><?php
		if(!empty($InsOrdenVentaVehiculo->VveFotoLateral)){
			
		?>
            <img src="../../subidos/vehiculo_version_fotos/<?php echo $InsOrdenVentaVehiculo->VveFotoLateral;?>" alt="" height="105"  /> <br />
            <span class="EstOrdenVentaVehiculoImprimirReferencias">Foto Lateral</span>
            <?php
		}
		?></td>
          <td align="center"><?php
		if(!empty($InsOrdenVentaVehiculo->VveFotoPosterior)){
			
		?>
            <img src="../../subidos/vehiculo_version_fotos/<?php echo $InsOrdenVentaVehiculo->VveFotoPosterior;?>" alt="" height="105"  /> <br />
            <span class="EstOrdenVentaVehiculoImprimirReferencias">Foto Posterior</span>
            <?php
		}
		?></td>
          </tr>
        </table></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
        
        
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPlantillaImprimirTabla">
        <thead class="EstPlantillaImprimirTablaHead">
          <tr>
            <th width="33">Condicion de venta</th>
            <th width="33">Obsequios y Accesorios</th>
            <th width="33">Mantenimientos Gratuitos</th>
            </tr>
           </thead>
            <tbody class="EstPlantillaImprimirTablaHead">
           
          <tr>
            <td height="150" align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirContenido">
              <?php
			  	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta)){	
					foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta ){
				?>
              - <?php echo $DatOrdenVentaVehiculoCondicionVenta->CovNombre;?><br />
              <?php						
					}
				}else{
				?>
                
                <?php	
				}
				?>
              <?php
if(!empty($InsOrdenVentaVehiculo->OvvCondicionVentaOtro)){
?>
              - <?php echo $InsOrdenVentaVehiculo->OvvCondicionVentaOtro;?>
              <?php	
}
?>
              </span></td>
            <td height="150" align="left" valign="top"> 
              
              
              <span class="EstOrdenVentaVehiculoImprimirContenido"><?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){	
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio ){
?>
                -  <?php echo $DatOrdenVentaVehiculoObsequio->ObsNombre;?><br />
                <?php						
	}
}				
?></span>
              
              
              
              <?php
if(!empty($InsOrdenVentaVehiculo->OvvObsequioOtro)){
?>
              - <?php echo $InsOrdenVentaVehiculo->OvvObsequioOtro;?>
              <?php	
}
?>	</td>
            <td height="150" align="left" valign="top">
              
              <span class="EstOrdenVentaVehiculoImprimirContenido">       
                <?php

if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento)){	
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento as $DatOrdenVentaVehiculoMantenimiento ){
?>
                - <?php echo $DatOrdenVentaVehiculoMantenimiento->OvmKilometraje;?> km<br />
                <?php			
		}
	}			
	
?></span>
              </td>
            </tr>
            
             </tbody>
          </table>
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
        
        
        
        <?php
if(!empty( $InsOrdenVentaVehiculo->OvvObservacion)){
?>
        
        
        <!--<table border="0" cellpadding="0" cellspacing="0" class="EstPlantillaImprimirTabla">
        <thead class="EstPlantillaImprimirTablaHead">
          <tr>
            <th>Observaciones</th>
            </tr>
           </thead>
            <tbody class="EstPlantillaImprimirTablaHead">
           
          <tr>
            <td height="150" align="left" valign="top">   <span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->OvvObservacion;?></span></td>
            </tr>
            
             </tbody>
          </table>-->
          
          
          
        <br />
        
        <span class="EstOrdenVentaVehiculoImprimirTitulo">
          Observaciones:
          </span>
        
        <br />
        
        <p align="justify">
          <span class="EstAsignacionVentaVehiculoImprimirContenido">
            <?php echo $InsOrdenVentaVehiculo->OvvObservacion;?>
            </span>
          </p>
        
        <?php	
}
?>
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>


<p align="right">
        <span class="EstPlantillaPie">
        
        
         <?php echo $EmpresaNombre;?> - R.U.C.: <?php echo $EmpresaCodigo;?><br />
        Arequipa: Av. Jacinto Ibañez 490 Parque Industrial – Telf. 054-232741 / Av. Parra 253 – Cercado – Arequipa  -Telf. 054-204620 / Av. Ejército 1059 - Cayma
        
        
      <!--  Inscritos en los Registros P&uacute;blicos de Tacna Ficha 2986 --></span>
</p>

 
 
</body>
</html>
