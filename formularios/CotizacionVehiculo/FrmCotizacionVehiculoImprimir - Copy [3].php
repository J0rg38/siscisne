<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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

$GET_id = $_GET['Id'];


require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoFoto.php');
//require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();

$InsCotizacionVehiculo->CveId = $GET_id;
$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo();

$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cotizacion No. <?php echo $InsCotizacionVehiculo->CveId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssCotizacionVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsCotizacionVehiculoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsCotizacionVehiculo->CveId)){?> 
FncCotizacionVehiculoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>


<div class="EstCotizacionVehiculoCabecera">

    <table cellpadding="0" cellspacing="0" width="100%" border="0">
<!--    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>-->
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top">
     
      
      <?php
	  
	  //deb($InsCotizacionVehiculo->VmaId);
	  switch($InsCotizacionVehiculo->VmaId){
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
          <img src="../../imagenes/membretes/cabecera_simplet.png" width="100%"  />
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
      <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
        <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
      <td width="0%" align="right" valign="top">&nbsp;</td>
    </tr>
    </table>

</div>









<hr class="EstReporteLinea">




   <table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstCotizacionVehiculoImprimirTabla">
    <tr>
      <td width="3%" align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">


      <span class="EstPlantillaTitulo">COTIZACION</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsCotizacionVehiculo->CveId;?></span>
    
        </td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="46%" align="left" valign="top" > <span class="EstCotizacionVehiculoImprimirEtiqueta">Señor (a): </span></td>
      <td width="48%" align="right" valign="top" > <span class="EstCotizacionVehiculoImprimirContenido">
	  
      <?php
	  list($Dia,$Mes,$Ano) = explode("/",$InsCotizacionVehiculo->CveFecha);;
	  ?>
      
      
	  <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?>
	  
	  <?php //echo $InsCotizacionVehiculo->CveFecha;?>
      
      
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" > <span class="EstCotizacionVehiculoImprimirContenido">
         
		  <?php echo $InsCotizacionVehiculo->CliNombre;?> <?php echo $InsCotizacionVehiculo->CliApellidoPaterno;?> <?php echo $InsCotizacionVehiculo->CliApellidoMaterno;?><br />
          
          <?php echo $InsCotizacionVehiculo->TdoNombre;?>:
          <?php echo $InsCotizacionVehiculo->CliNumeroDocumento;?> </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >  <span class="EstCotizacionVehiculoImprimirEtiqueta">
            Estimado cliente: 
            </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >   <span class="EstCotizacionVehiculoImprimirContenido">
        La presente tiene por objeto saludarle y a la vez adjuntar el detalle de la cotización de nuestro nuevo modelo 
          </span> <span class="EstCotizacionVehiculoImprimirMarcaModeloVersion">
          <?php echo $InsCotizacionVehiculo->VmaNombre;?> <?php echo $InsCotizacionVehiculo->VmoNombre;?> <?php echo $InsCotizacionVehiculo->VveNombre;?>. 		
          </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
      
		<?php
		

		if(!empty($InsCotizacionVehiculo->CveFoto)){
		?>
			<img src="../../subidos/cotizacion_vehiculo_fotos/<?php echo $InsCotizacionVehiculo->CveFoto;?>" width="362"  />
            <br />
            * Foto Referencial
		<?php
		}else if(!empty($InsCotizacionVehiculo->VveFoto)){
			
		?>
        	<img src="../../subidos/vehiculo_version_fotos/<?php echo $InsCotizacionVehiculo->VveFoto;?>" width="362"  />
            <br />
            * Foto Referencial
        <?php
		}
		?>
		
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
      
      
      <table width="750" height="40" border="1" cellpadding="1" cellspacing="0">
      <tr>
      <td width="217" align="center" valign="middle">
        
         <span class="EstCotizacionVehiculoImprimirMarcaModeloVersionPrincipal">
        <?php echo $InsCotizacionVehiculo->VmaNombre;?> <?php echo $InsCotizacionVehiculo->VmoNombre;?> <?php echo $InsCotizacionVehiculo->VveNombre;?>  <?php //echo $InsCotizacionVehiculo->CveAdicional;?> 
        
        
         <?php echo $InsCotizacionVehiculo->CveAdicional;?>
         
        <?php
		if(!empty($InsCotizacionVehiculo->CveAnoFabricacion)){
		?>
         - Fabricacion <?php echo $InsCotizacionVehiculo->CveAnoFabricacion;?>        
        <?php	
		}
		?>

          <?php
		if(!empty($InsCotizacionVehiculo->CveAnoModelo)){
		?>
        - Modelo <?php echo $InsCotizacionVehiculo->CveAnoModelo;?>
        <?php	
		}
		?>       
        
         
        
         
         </span>
      </td>
      </tr>
      </table>



      
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    
    
    
    
    
<!--    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="4" align="left" valign="top" >
      
      
      
      <?php //echo $InsCotizacionVehiculo->VehInformacion;?>
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>-->
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" ><table width="750" height="59" border="1" cellpadding="1" cellspacing="0">
        <tr>
          <td width="494" align="left" valign="middle"><?php
//deb($InsCotizacionVehiculo->CveDescuento);
			if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId){
				
				if(!empty($InsCotizacionVehiculo->CveTipoCambio)){
					
					$InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal / $InsCotizacionVehiculo->CveTipoCambio,2);
					$InsCotizacionVehiculo->CvePrecio = round($InsCotizacionVehiculo->CvePrecio / $InsCotizacionVehiculo->CveTipoCambio,2);
					$InsCotizacionVehiculo->CveDescuento = round($InsCotizacionVehiculo->CveDescuento / $InsCotizacionVehiculo->CveTipoCambio,2);
					
				}else{
					
					$InsCotizacionVehiculo->CveTotal = 0;
					$InsCotizacionVehiculo->CvePrecio = 0;
					$InsCotizacionVehiculo->CveDescuento = 0;
					
				}
			}
			
?>
            <span class="EstCotizacionVehiculoImprimirPrecioEtiqueta">PRECIO LISTA:</span> <span class="EstCotizacionVehiculoImprimirPrecio"> <?php echo $InsCotizacionVehiculo->MonSimbolo;?> <?php echo number_format($InsCotizacionVehiculo->CvePrecio,2);?></span>
            <?php
//deb($InsCotizacionVehiculo->CveDescuento);
if(!empty($InsCotizacionVehiculo->CveDescuento)){
?>
            <br />
            <span class="EstCotizacionVehiculoImprimirPrecioEtiqueta">
              PRECIO C/ DESCUENTO. : 
              
              </span>
            <span class="EstCotizacionVehiculoImprimirPrecio">
              <?php echo $InsCotizacionVehiculo->MonSimbolo;?> <?php echo number_format($InsCotizacionVehiculo->CveTotal,2);?>
              </span>
            <?php	
}
?></td>
          <td width="242" align="center" valign="middle">Inc. IGV </td>
          </tr>
        </table></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
        
        
        
        
        <?php

//deb($InsVehiculoVersion->VehiculoVersionCaracteristica);


if(!empty($ArrVehiculoCaracteristicaSecciones)){
	$secciones=0;
	foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
		
	
	
				if(!empty($InsCotizacionVehiculo->VehiculoVersionCaracteristica)){	
					foreach($InsCotizacionVehiculo->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){

						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId){
							$secciones++;
							break;
						}
					}
				}
				
	}
}

if(!empty($ArrVehiculoCaracteristicaSecciones)){
	$i=1;
	foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
		
	$MostrarSeccion = false;
	
				if(!empty($InsCotizacionVehiculo->VehiculoVersionCaracteristica)){	
					foreach($InsCotizacionVehiculo->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){

						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId){
							$MostrarSeccion = true;
							break;
						}
					}
				}
							
	?>
	<?php
	if($MostrarSeccion){
	?>
        
        <table width="750" border="1" cellpadding="1" cellspacing="0" class="EstCotizacionVehiculoImprimirCaracteristica">
          <thead class="EstCotizacionVehiculoImprimirCaracteristicaHead">
            <tr>
            
   
    
      
              <th width="<?php echo (($InsCotizacionVehiculo->VmaId=="VMA-10018")?'33%':'67%')?>" align="center" ><?php echo $DatVehiculoCaracteristicaSeccion->VcsNombre?></th>
              <th width="<?php echo (($InsCotizacionVehiculo->VmaId=="VMA-10018")?'67%':'33%');?>" align="center" class="EstCotizacionVehiculoImprimirCaracteristicaSeccion">
                <?php echo $InsCotizacionVehiculo->VveNombre;?>
                </th>
              </tr>
  </thead>
  <tbody class="EstCotizacionVehiculoImprimirCaracteristicaBody">
    
    <?php
				if(!empty($InsCotizacionVehiculo->VehiculoVersionCaracteristica)){	
					foreach($InsCotizacionVehiculo->VehiculoVersionCaracteristica as $DatVehiculoVersionCaracteristica ){
			?>
    
    <?php
						if($DatVehiculoVersionCaracteristica->VcsId == $DatVehiculoCaracteristicaSeccion->VcsId){
			?>
    
    <tr>
      <td align="left">
        
        
        <?php echo stripslashes($DatVehiculoVersionCaracteristica->VvcDescripcion);?>
        
        
        </td>
      <td align="center">
        <?php
		if($InsCotizacionVehiculo->VmaId=="VMA-10018"){
			$Garantia = $DatVehiculoVersionCaracteristica->VvcValor;
		}else{
			$Garantia = "";
		}
		?>
        <?php echo stripslashes($DatVehiculoVersionCaracteristica->VvcValor);?>
        
        </td>
      </tr>
    
    <?php					
				
						}	
					}
				}	
							
			?>
    
  </tbody>
          </table>
       
       <?php
	   if($secciones <> $i){
		  ?>
          <br />	      
          <?php 
	   }
	   ?>
       
      
	<?php
		$i++;
	}
	?>
        <?php
	}
}
?>
        
        
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
      
<p>
<span class="EstCotizacionVehiculoImprimirEtiqueta">Precio incluye: </span>
</p>
<p>
<!--Juego de pisos, Tramite de Tarjetas y Placas-->

<span class="EstCotizacionVehiculoImprimirContenido">
	
  					

            
                <?php
			  	if(!empty($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta)){	
					foreach($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta as $DatCotizacionVehiculoCondicionVenta ){
				?>
                	-  <?php echo $DatCotizacionVehiculoCondicionVenta->CovNombre;?> 
                <?php						
					}
				}				
				?>
         

			
<?php
if(!empty($InsCotizacionVehiculo->CveCondicionVentaOtro)){
?>
- <?php echo $InsCotizacionVehiculo->CveCondicionVentaOtro;?>
<?php	
}
?>

                    
</span>
</p>


<?php
if(!empty( $InsCotizacionVehiculo->CveObservacion)){
?>
    
    <p align="justify">
    <span class="EstCotizacionVehiculoImprimirEtiqueta">
    OBSERVACIONES:
    </span>
    </p>
    
    
    <p>
    
    <span class="EstCotizacionVehiculoImprimirObservacion">
    
    <?php echo $InsCotizacionVehiculo->CveObservacion;?>
    
    </span>
    
    </p>
<?php	
}
?>





<p>

<p align="justify">
<span class="EstCotizacionVehiculoImprimirEtiqueta">
ENTREGA:
</span>
</p>

<p align="justify">
<span class="EstCotizacionVehiculoImprimirContenido">
- La entrega esta sujeta a la disponibilidad de stock y colores al momento de su decisi&oacute;n de compra.  Confirmada la disponibilidad de stock asignado el veh&iacute;culo solicitado, el cliente deber&aacute; proporcionar a <?php echo $EmpresaNombre;?> los documentos necesarios a fin de iniciar ante Registros P&uacute;blicos el registro vehicular de su propiedad. <?php echo $EmpresaNombre;?> le brindar&aacute; el detalle oportuno de los documentos que se requiere para dicho prop&oacute;sito. El registro vehicular demora alrededor de 15 (quince) dias &uacute;tiles para la entrega de la tarjeta de propiedad y placas de rodaje, este plazo rige luego de presentar el expediente ante Registros P&uacute;blicos. Si existiera alguna observaci&oacute;n de Registros P&uacute;blicos durante el tr&aacute;mite del registro vehicular que ocasione demora en la entrega del vehiculo, este retraso no sera imputable a <?php echo $EmpresaNombre;?>.
</span>
</p>


</p>
<span class="EstCotizacionVehiculoImprimirContenido">

<?php
if(!empty($Garantia)){
?>

<?php	echo $Garantia;?>

<?php
}else{
?>
- Garantía 05 años ó 100,000 kilómetros, lo que ocurra primero
<?php	
}
?>


</span>	
</p>




        <?php 
		/*if(!empty($InsCotizacionVehiculo->CveFechaVigencia)){
		?>	 <span class="EstCotizacionVehiculoImprimirEtiqueta">Vigencia de la cotizaci&oacute;n hasta el</span>
        <?php  echo $InsCotizacionVehiculo->CveFechaVigencia;?>        
        <?php
		}*/
		?>
        
        <?php
		if(!empty($InsCotizacionVehiculo->CveFechaVigencia)){
		?>
        
        <p>
        <span class="EstCotizacionVehiculoImprimirEtiqueta">Vigencia:</span>
		</p>
		
        <p>
        <span class="EstCotizacionVehiculoImprimirContenido">
        - Cotizaci&oacute;n válida hasta el <?php echo $InsCotizacionVehiculo->CveFechaVigencia; ?>
        </span> 
        </p>
        
        
        <?php	
		}
		?>
       
           <?php
		if(!empty($InsCotizacionVehiculo->CotizacionVehiculoFoto)){
		?>
        
        <p>
        <span class="EstCotizacionVehiculoImprimirEtiqueta">Fotos Adicionales:</span>
		</p>
		
          <p align="center">
        <span class="EstCotizacionVehiculoImprimirContenido">
      
      
        <?php
		foreach($InsCotizacionVehiculo->CotizacionVehiculoFoto as $DatCotizacionVehiculoFoto){
		?>
        <img height="160" src="../../subidos/cotizacion_vehiculo_fotos/<?php echo $DatCotizacionVehiculoFoto->CvfArchivo?>" alt="<?php echo $DatCotizacionVehiculoFoto->CvfArchivo?>" title="<?php echo $DatCotizacionVehiculoFoto->CvfArchivo?>" border="0" />
        <?php	
		}
		?>
      
        </span> 
        </p>
        
        
        <?php	
		}
		?>     
        
        <p>
        <span class="EstCotizacionVehiculoImprimirEtiqueta">Numeros de Cuenta:</span>
		</p>
		
        <p>
        <span class="EstCotizacionVehiculoImprimirContenido">

		
		- <b>SCOTIABANK</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  - <b>BANCO DE CREDITO DEL PERU</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - <b>BANCO CONTINENTAL</b><br />
        SOLES	417-0004349431 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SOLES	540-1628672076  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  SOLES	232-0100038147<br />
        DOLARES	417-0002869779 &nbsp; DOLARES	540-1670811132 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DOLARES	232-0100025991<br />
        
   		<br />
        
        - <b>INTERBANK</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;  - <b>CAJA MUNICIPAL DE TACNA</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - <b>BANCO DE LA NACION</b><br />
        SOLES	340-3000552702 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SOLES	001-211101924591 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  SOLES	0-1510704500<br />
        DOLARES	340-3000552795 &nbsp;&nbsp;  DOLARES	001-212101924593<br />
        
       
       <!--- <b>SCOTIABANK</b><br />
        SOLES	417-0004349431<br />
        DOLARES	417-0002869779<br />
        
        - <b>BANCO DE CREDITO DEL PERU</b><br />
        SOLES	540-1628672076<br />
        DOLARES	540-1670811132<br />
        
        - <b>BANCO CONTINENTAL</b><br />
        SOLES	232-0100038147<br />
        DOLARES	232-0100025991<br />
        
        - <b>INTERBANK</b><br />
        SOLES	340-3000552702<br />
        DOLARES	340-3000552795<br />
        
        - <b>CAJA MUNICIPAL DE TACNA</b><br />
        SOLES	001-211101924591<br />
        DOLARES	001-212101924593<br />
        
        - <b>BANCO DE LA NACION</b><br />
        SOLES	0-1510704500<br />-->


        </span> 
        </p>
 <!--       
        SCOTIABANK
SOLES	417-0004349431
DOLARES	417-0002869779

BANCO DE CREDITO DEL PERU
SOLES	540-1628672076
DOLARES	540-1670811132

BANCO CONTINENTAL
SOLES	232-0100038147
DOLARES	232-0100025991

INTERBANK
SOLES	340-3000552702
DOLARES	340-3000552795

CAJA MUNICIPAL DE TACNA
SOLES	001-211101924591
DOLARES	001-212101924593

BANCO DE LA NACION
SOLES	0-1510704500
       --> 
        
<p>	
	<span class="EstCotizacionVehiculoImprimirContenido">
Agradeciendo de antemano la atención a la presente, quedamos de usted.
	</span>
</p>

<!--<p>
<span class="EstCotizacionVehiculoImprimirEtiqueta">
Atentamente,
</span>
</p>-->

</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="center" valign="bottom" ><!--<img src="../../imagenes/sello_cyc.png" width="246" height="130" />-->

      
      <br />
      
      
<!--      C. & C. S.A.C.-->


            
<?php

/*	  if(!empty($InsCotizacionVehiculo->PerFirma)){
?>
<img src="../../../subidos/personal_firmas/<?php echo $InsCotizacionVehiculo->PerFirma;?>" width="163" height="97" />
<br />
<?php
	 
	  }*/
?>         
<span class="EstCotizacionVehiculoImprimirNota3">
<?php echo $InsCotizacionVehiculo->PerNombre;?> 
<?php echo $InsCotizacionVehiculo->PerApellidoPaterno;?> 
<?php echo $InsCotizacionVehiculo->PerApellidoMaterno;?> 
<br />
Asesor Comercial<br />
<?php echo $EmpresaNombre;?><br />


Telefono: <?php echo $InsCotizacionVehiculo->PerTelefono;?><br />
Celular: <?php echo $InsCotizacionVehiculo->PerCelular;?><br />
Email: <?php echo $InsCotizacionVehiculo->PerEmail;?> 
</span>



      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
 
  
<br />
<!--<div class="EstCotizacionVehiculoPie">-->
<p align="center">
        <span class="EstCotizacionVehiculoImprimirNota2">
        
        <?php echo $EmpresaNombre;?> - R.U.C.: <?php echo $EmpresaCodigo;?><br />
        Arequipa: Av. Jacinto Ibañez 490 Parque Industrial – Telf. 054-232741 / Av. Parra 253 – Cercado – Arequipa  -Telf. 054-204620 / Av. Ejército 1059 - Cayma
        </span>
</p>
<!-- </div>-->
 
</body>
</html>
