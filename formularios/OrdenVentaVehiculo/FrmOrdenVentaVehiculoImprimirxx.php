

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

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $GET_id;

//deb($InsOrdenVentaVehiculo->OvvId);
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();



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
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">


      <span class="EstPlantillaTitulo">ORDEN DE VENTA DE VEHICULO</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsOrdenVentaVehiculo->OvvId;?></span>
    
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirCabecera">Datos de la Cotizacion de Producto</span></td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="3%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="47%" align="right" valign="top" >
        
        <?php echo $InsOrdenVentaVehiculo->OvvFecha;?>
      </td>
      <td width="47%" align="right" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" >
        
        <p>&nbsp;</p></td>
      <td colspan="2" align="left" valign="top" >
      
		<p>
			<span class="EstOrdenVentaVehiculoImprimirEtiqueta">Señor (a): </span><br /><?php echo $InsOrdenVentaVehiculo->CliNombre;?>
        </p>
        
        <p>
            <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
            Presente.- 
            </span>
        </p>
        <p>
        	<span class="EstOrdenVentaVehiculoImprimirEtiqueta">
            Estimado cliente: 
            </span>
            </p>
        <p> La presente tiene por objeto saludarle y a la vez adjuntarle el detalle de la orden de venta de vehiculo de nuestro nuevo modelo 
		
        <?php 
		/*if(empty($InsOrdenVentaVehiculo->VehNombre)){
		?>
			<?php echo $InsOrdenVentaVehiculo->VmaNombre;?> <?php echo $InsOrdenVentaVehiculo->VmoNombre;?> <?php echo $InsOrdenVentaVehiculo->VveNombre;?>. 		
        <?php	
		}else{
		?>
    		<?php echo $InsOrdenVentaVehiculo->VehNombre;?>    
        <?php	
		}*/
		?>

        <?php echo $InsOrdenVentaVehiculo->VmaNombre;?> <?php echo $InsOrdenVentaVehiculo->VmoNombre;?> <?php echo $InsOrdenVentaVehiculo->VveNombre;?>. 		
        
        </p></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
      
		<?php
		
		//deb($InsOrdenVentaVehiculo->VveId);
		//deb($InsOrdenVentaVehiculo->VveFoto);
		if(!empty($InsOrdenVentaVehiculo->VveFoto)){
		?>
			<img src="../../subidos/vehiculo_version_fotos/<?php echo $InsOrdenVentaVehiculo->VveFoto;?>" width="334" height="214" />
		<?php
		}
		?>
		
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
      
      
      <table width="738" height="59" border="1">
      <tr>
      <td width="257" align="center" valign="middle">
      
      <?php echo $InsOrdenVentaVehiculo->VmaNombre;?> <?php echo $InsOrdenVentaVehiculo->VmoNombre;?> <?php echo $InsOrdenVentaVehiculo->VveNombre;?>
      
      </td>
      <td width="256" align="center" valign="middle">
      
      Precio 
      <?php echo $InsOrdenVentaVehiculo->MonSimbolo;?>


<?php

			if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){
				if(!empty($InsOrdenVentaVehiculo->OvvTipoCambio)){
					$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,2);

				}else{
					$InsOrdenVentaVehiculo->OvvTotal = 0;
				}
			}
			
?>

<?php echo $InsOrdenVentaVehiculo->OvvTotal;?> Inc. IGV
      
      </td>
      </tr>
      </table>



      
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    
    
    
    
    
<!--    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" >
      
      
      
      <?php //echo $InsOrdenVentaVehiculo->VehInformacion;?>
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>-->
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
        
        
        
        
        
        
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
      
<p>
<span class="EstOrdenVentaVehiculoImprimirEtiqueta">Precio incluye: </span>
</p>
<p>
<!--Juego de pisos, Tramite de Tarjetas y Placas-->

<b>
	
  					
			<?php
			for($i=1;$i<5;$i++){
			?>
            
                <?php
			  	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta)){	
					foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta ){
						$aux = '';
						if($DatOrdenVentaVehiculoCondicionVenta->CcvCondicionVenta==$ArrCondicionVentas[$i]['Valor']){
							$aux = 'checked="checked"';						
							break;
						}					
					}
				}				
				?>
                
                <?php
				if($aux){
				?>
					<?php echo $ArrCondicionVentas[$i]['Nombre']?><br />
				<?php					
				}
				?>


                
			<?php	
			}
			?>  
    				
			<?php 
			echo $InsOrdenVentaVehiculo->OvvCondicionVentaOtro;
			?>
                    
</b>
</p>


<p>
<?php echo $InsOrdenVentaVehiculo->OvvObservacion;?>
</p>
<p>
Garantía 02 años ó 50,000 kilómetros, lo que ocurra primero
</p>
<p>
Agradeciendo de antemano la atención a la presente, quedamos de usted.
</p>
Atentamente;
<br />

</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="center" valign="top" ><!--<img src="../../imagenes/sello_cyc.png" width="246" height="130" />-->

      
      <br />
      
      
<!--      C. & C. S.A.C.-->


<span class="EstOrdenVentaVehiculoImprimirFirma">
<?php echo $InsOrdenVentaVehiculo->PerNombre;?> 
<?php echo $InsOrdenVentaVehiculo->PerApellidoPaterno;?> 
<?php echo $InsOrdenVentaVehiculo->PerApellidoMaterno;?> </span>

Asesor Comercial<br />
<?php echo $EmpresaNombre;?><br />

<span class="EstOrdenVentaVehiculoImprimirNota3">
Telefono: <?php echo $InsOrdenVentaVehiculo->PerTelefono;?><br />
Celular: <?php echo $InsOrdenVentaVehiculo->PerCelular;?><br />
Email: <?php echo $InsOrdenVentaVehiculo->PerEmail;?> 
</span>
            
            




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

<div class="EstOrdenVentaVehiculoPie">

        <span class="EstOrdenVentaVehiculoImprimirNota2">Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        Tel&eacute;fono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe<br />
        Inscritos en los Registros P&uacute;blicos de Tacna Ficha 2986 </span>

 </div>
 
 
</body>
</html>
