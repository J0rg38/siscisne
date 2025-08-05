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
$GET_Fecha = $_GET['Fecha'];


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
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
<link href="css/CssOrdenVentaVehiculoImprimirAE.css" rel="stylesheet" type="text/css" />

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
      <td colspan="3" align="left" valign="top"><!--<img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  />-->
      
      <?php
	  
	  //deb($InsCotizacionVehiculo->VmaId);
	  switch($InsOrdenVentaVehiculo->VmaId){
		  case "VMA-10017":
	?>
     <img src="../../imagenes/membretes/cabecera_chevrolet.png" width="100%"  />
    <?php  
		  break;
		  
		  case "VMA-10018":
	?>
     <img src="../../imagenes/membretes/cabecera_isuzu.png" width="100%"  />
    <?php	  
		  break;
		  
		  default:
		 ?>
          <img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  />
         <?php 
		  break;
	  }
	  ?>
      
      
      
      </td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="34%" align="left" valign="top">&nbsp;</td>
      <td width="28%" align="center" valign="top">&nbsp;</td>
      <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php //echo date("d/m/Y");?> <?php //echo date("H:i:s");?> <?php //echo date("a");?></span> - 
        <span class="EstPlantillaDatosImpresion"><?php //echo $_SESSION['SesionUsuario'];?></span></td>
      <td width="0%" align="right" valign="top">&nbsp;</td>
    </tr>
    </table>










<hr class="EstReporteLinea">



<!--
<hr class="EstReporteLinea">

-->



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">ACTA DE ENTREGA</span> <br />
        <span class="EstPlantillaTituloCodigo"> <!--<?php echo $InsOrdenVentaVehiculo->OvvId;?>--></span>
        
        </td>
      <td width="5%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="7%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="43%" align="left" valign="top" >
        
        
        <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
          Señores:
          </span>
        
        
        
        
        
        </td>
      <td width="45%" align="right" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
      
      <?php
	  
	 /* if(!empty($GET_Fecha)){
		  
		   list($Dia,$Mes,$Ano) = explode("/",$GET_Fecha);;
	?>
    		
		 <!-- Tacna,--> <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?>
	   
    <?php 
	  }else{*/
	  ?>
       
	   <?php
		  if(!empty($InsOrdenVentaVehiculo->OvvActaEntregaFecha)){
			?>
				 <?php
		  list($Dia,$Mes,$Ano) = explode("/",$InsOrdenVentaVehiculo->OvvActaEntregaFecha);;
		  ?>
			<!--Tacna,--> <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?>
	  <?php //echo $InsOrdenVentaVehiculo->OvvFecha;?>
	  
			<?php  
		  }else{
			?>
			<!--Tacna, --><!--<?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?>-->
            NO TIENE FECHA DE ENTREGA
			<?php  
		  }
		  ?>
          
      <?php
	//  }
	  ?>
      
     
  
  
        </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
      
      
  <?php
$RepresentanteNombre = "";
$RepresentanteNumeroDocumento = "";

if(!empty($ArrOrdenVentaVehiculoPropietarios)){
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){

?>
    	<span class="EstOrdenVentaVehiculoImprimirContenido">
		<?php echo $DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> </span><br />

  <?php
		
	}
}
?>

</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">De nuestra consideración:</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
       <span class="EstOrdenVentaVehiculoImprimirContenido">Por medio de la presente le hacemos entrega del vehiculo marca <?php echo $InsOrdenVentaVehiculo->VmaNombre;?> modelo <?php echo $InsOrdenVentaVehiculo->VmoNombre;?> <?php echo $InsOrdenVentaVehiculo->VveNombre;?>, solicitado por usted. Se detalla a continuaci&oacute;n el vehiculo</span>
          
         
  </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirTabla" ><!--<hr class="EstReporteLinea">--><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Datos del Vehiculo:</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      
      
      <td colspan="2" align="center" valign="top"  >
        
        <table width="555" border="0" class="EstOrdenVentaVehiculoImprimirTabla"> 
        <thead class="EstOrdenVentaVehiculoImprimirHead">
          <tr>
            <th align="left" valign="middle">&nbsp;</th>
            <th align="center" valign="middle">&nbsp;</th>
            <th align="left" valign="middle">&nbsp;</th>
          </tr>
          </thead>
          <tbody class="EstOrdenVentaVehiculoImprimirBody">
          <tr>
            <td width="235" align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
                
                Marca               </span>
              </td>
            <td width="5" align="center" valign="middle">:</td>
            <td width="463" align="left" valign="middle">
              
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                
                <?php echo $InsOrdenVentaVehiculo->VmaNombre;?>
                </span>
              
              </td>
            </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Modelo </span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->VmoNombre;?> <?php echo $InsOrdenVentaVehiculo->VveNombre;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Color </span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo $InsOrdenVentaVehiculo->EinColor;?>
                </span>
              </td>
            </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Chasis </span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinVIN;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Motor</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinNumeroMotor;?></span></td>
            </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Año Fab.</span></td>
            <td align="center" valign="middle">&nbsp;</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinAnoFabricacion;?></span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Año Mod.</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $InsOrdenVentaVehiculo->EinAnoModelo;?></span></td>
            </tr>
		</tbody>
          </table>
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><!--<hr class="EstReporteLinea">--></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Accesorios:</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="100" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="100" colspan="2" align="left" valign="top" >
      
      
    
      
      <span class="EstOrdenVentaVehiculoImprimirAccesorios">
	  <!--<pre>-->
	  <?php echo ltrim($InsOrdenVentaVehiculo->OvvActaEntregaDescripcion);?>
     <!-- </pre>-->
     
     
      </span>
      
      
      <?php
	  
	  //deb($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio);
	  if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){
	?>	
 <!-- <span class="EstOrdenVentaVehiculoImprimirContenido"> Otros accesorios instalados: </span>--><br />
  
    	 <span class="EstOrdenVentaVehiculoImprimirAccesorios">
    	 <?php
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
			
			if($DatOrdenVentaVehiculoObsequio->ObsUso == "2"){
		?>
        	- <?php echo $DatOrdenVentaVehiculoObsequio->ObsNombre;?> <br />
        <?php
			}
			
		}
		?>
           </span> <br />
           
    <?php	  
	  }
	  ?>
    <br />
      </td>
      <td height="100" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirEtiqueta">Obsequios:</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="100" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="100" colspan="2" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirAccesorios"><?php echo ltrim($InsOrdenVentaVehiculo->OvvActaEntregaDescripcion);?>
          <!-- </pre>-->
      </span>
        <?php
	  
	  //deb($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio);
	  if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){
	?>
      <!--  <span class="EstOrdenVentaVehiculoImprimirContenido"> Otros accesorios instalados: </span>--><br />
      
        <span class="EstOrdenVentaVehiculoImprimirAccesorios">
        <?php
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
			
			if($DatOrdenVentaVehiculoObsequio->ObsUso == "1"){
		?>
- <?php echo $DatOrdenVentaVehiculoObsequio->ObsNombre;?> <br />
<?php
			}
		}
		?>
        </span>
        <?php	  
	  }
	  ?>
        <br /></td>
      <td height="100" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
        
        <span class="EstOrdenVentaVehiculoImprimirContenido">
          Quedando conforme el cliente con la entrega del vehiculo, quedando bajo la responsabilidad del cliente e traslado o movilizacion del mismo al destino que estime conveniente.</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">Atentamente</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><!--<img src="../../imagenes/sello_cyc.png" width="246" height="130" />-->
        
        <table width="100%">
          <tr>
           
            
            <?php
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
            
            
            <td width="50%" height="130" align="center" valign="bottom">
              
              <span class="EstOrdenVentaVehiculoImprimirFirma"> <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> <br />
                
                <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>:  <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?><br />
                </span>    
              
              
              </td>
            <?php	
   break;
	}
	?>
             <td width="50%" height="130" align="center" valign="bottom">
              
              
              
              <span class="EstOrdenVentaVehiculoImprimirFirma">
              <?php echo $InsOrdenVentaVehiculo->PerNombre		  ?>
               <?php echo $InsOrdenVentaVehiculo->PerApellidoPaterno		  ?>
                <?php echo $InsOrdenVentaVehiculo->PerApellidoMaterno		  ?><br />
                
                   <?php echo $InsOrdenVentaVehiculo->TdoNombrePersonal; ?>: <?php echo $InsOrdenVentaVehiculo->PerNumeroDocumento		  ?>
                 
                
                </span>    
              
              
              
              
              
              </td>
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
