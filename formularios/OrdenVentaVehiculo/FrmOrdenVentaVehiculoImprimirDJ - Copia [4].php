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

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');


$InsPago = new ClsPago();
$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $GET_id;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);


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
<link href="css/CssOrdenVentaVehiculoImprimirDJ.css" rel="stylesheet" type="text/css" />

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





<!--
<hr class="EstReporteLinea">

-->



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
    <tr>
      <td height="99" align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">DECLARACION JURADA</span> <br />
        <span class="EstPlantillaTituloCodigo"> <!--<?php echo $InsOrdenVentaVehiculo->OvvId;?>--></span>
        
        </td>
      <td width="10%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="9%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="32%" align="right" valign="top" >&nbsp;</td>
      <td width="49%" align="right" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
        <p align="justify">
        
       
        
        
	<span class="EstOrdenVentaVehiculoImprimirContenido">
    IMPORTACIONES <?php echo strtoupper($EmpresaNombre);?> CON RUC: <?php echo $EmpresaCodigo;?>, REPRESENTADO 
    
    POR   </span> <span class="EstOrdenVentaVehiculoImprimirEtiqueta">EL SEÑOR <?php echo strtoupper($EmpresaRepresentanteNombre);?> CON DNI: <?php echo $EmpresaRepresentanteNumeroDocumento;?></span> <span class="EstOrdenVentaVehiculoImprimirContenido">, SEGÚN PARTIDA ELECTRONICA  INSCRITA EN LOS REGISTROS PUBLICOS DE TACNA Nro.  05021273</span> <span class="EstOrdenVentaVehiculoImprimirContenido"> Y </span>
    
    
  <?php
$RepresentanteNombre = "";
$RepresentanteNumeroDocumento = "";

if(!empty($ArrOrdenVentaVehiculoPropietarios)){
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){

?>
    	<span class="EstOrdenVentaVehiculoImprimirEtiqueta">
		<?php echo $DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> CON <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>: <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?>		</span>

  <?php
		$RepresentanteNombre = "".$DatOrdenVentaVehiculoPropietario->CliRepresentanteNombre;
		$RepresentanteNumeroDocumento = "".$DatOrdenVentaVehiculoPropietario->CliRepresentanteNumeroDocumento;

	}
}
?>
    
    
    
  <?php
if(!empty($RepresentanteNombre)){
?>
    
    <span class="EstOrdenVentaVehiculoImprimirContenido">REPRESENTADO POR</span>  <span class="EstOrdenVentaVehiculoImprimirEtiqueta">EL SEÑOR(A) <?php echo $RepresentanteNombre;?>  CON DNI: <?php echo $RepresentanteNumeroDocumento;?></span>, 
    
  <?php	
}
?>
    
    
    
    <span class="EstOrdenVentaVehiculoImprimirContenido">DECLARAN QUE LA COMPRA-VENTA DEL VEHICULO <?php echo $InsOrdenVentaVehiculo->VmaNombre;?> MODELO <?php echo $InsOrdenVentaVehiculo->VmoNombre;?> <?php echo $InsOrdenVentaVehiculo->VveNombre;?>  SE EFECTUO DE LA SIGUIENTE MANERA:</span>
 
         </p>
</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="right" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>


      <td colspan="2" align="center" valign="top" >
      
       <table width="783" border="0">
      <tr>
        <td align="left" valign="middle">
        <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
         
                  <?php
				switch($InsOrdenVentaVehiculo->OvvComprobanteVenta){
					case "F":
				?>
                 FACTURA DE VENTA 
                  <?php	
					break;
					
					case "B":
				?>
                  BOLETA DE VENTA
                  <?php	
					break;
					
					default:
				?>-
                  <?php	
					break;
				}
				?>
        </span>
        </td>
        <td align="center" valign="middle">:</td>
        <td align="left" valign="middle">
        
 <span class="EstOrdenVentaVehiculoImprimirContenido">
                  
                  <?php
				switch($InsOrdenVentaVehiculo->OvvComprobanteVenta){
					case "F":
				?>
                  <?php echo $InsOrdenVentaVehiculo->OvvFacturaNumero?>
                  <?php	
					break;
					
					case "B":
				?>
                  <?php echo $InsOrdenVentaVehiculo->OvvBoletaNumero?>
                  <?php	
					break;
					
					default:
				?>-
                  <?php	
					break;
				}
				?>
</span>
                
                </td>
      </tr>
      <tr>
      <td width="356" align="left" valign="middle">
      <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
      MONTO TOTAL DE LA OPERACIÓN
      </span>
      </td>
      <td width="10" align="center" valign="middle">:</td>
      <td width="403" align="left" valign="middle">
	  
 <span class="EstOrdenVentaVehiculoImprimirContenido">
 
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
<?php echo number_format($InsOrdenVentaVehiculo->OvvTotal,2);?> 
      
      <?php echo $InsOrdenVentaVehiculo->MonNombre;?>
      </span>
      </td>
      </tr>
      </table>


</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="center" valign="top" >
      
      
      <?php
	  
	  if(!empty($ArrPagos)){
		?>

<?php
foreach($ArrPagos as $DatPago){
?>

      <table width="783" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" valign="middle">
          <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
          TIPO DE MEDIO PAGADO
          </span>
          </td>
          <td align="center" valign="middle">:</td>
          <td align="left" valign="middle">
          
		  <span class="EstOrdenVentaVehiculoImprimirContenido">
		  <?php echo strtoupper($DatPago->FpaNombre);?>
          </span>
          
          </td>
        </tr>
        <tr>
          <td align="left" valign="middle">
          <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
          Nro. DE CTA CTE M.E.
          </span>
          </td>
          <td align="center" valign="middle">:</td>
          <td align="left" valign="middle">
		  <span class="EstOrdenVentaVehiculoImprimirContenido">
		  <?php echo $DatPago->CueNumero;?>
          </span>
          </td>
        </tr>
        <tr>
          <td align="left" valign="middle">
          <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
          ENTIDAD  FINANCIERA
          </span>
          </td>
          <td align="center" valign="middle">:</td>
          <td align="left" valign="middle">
		   <span class="EstOrdenVentaVehiculoImprimirContenido">
		   <?php echo strtoupper($DatPago->BanNombre);?>
           </span>
           </td>
        </tr>
        <tr>
          <td align="left" valign="middle">
            <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
              FECHA DE  DEPÓSITO
              </span>
            </td>
          <td align="center" valign="middle">:</td>
          <td align="left" valign="middle">
            <span class="EstOrdenVentaVehiculoImprimirContenido">
              <?php echo $DatPago->PagFechaTransaccion;?>
              </span>
            </td>
        </tr>
        <tr>
          <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">MONTO DE  DEPÓSITO </span></td>
          <td align="center" valign="middle">:</td>
          <td align="left" valign="middle"><?php echo ($DatPago->MonSimbolo); ?>    
            
            <?php $DatPago->PagMonto = (($EmpresaMonedaId==$DatPago->MonId or empty($DatPago->MonId))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));?>
            <span class="EstOrdenVentaVehiculoImprimirContenido">
              <?php echo number_format($DatPago->PagMonto,2); ?>    
              </span>
              
              </td>
        </tr>
        <tr>
          <td align="left" valign="middle">
          
            
               <?php 
		   
		   if($InsOrdenVentaVehiculo->MonId <> $DatPago->MonId){
			   ?>
               
               <span class="EstOrdenVentaVehiculoImprimirEtiqueta">TIPO DE CAMBIO</span>
               <?php
		   }
			   ?>
               </td>
          <td align="center" valign="middle">
          
            
               <?php 
		   
		   if($InsOrdenVentaVehiculo->MonId <> $DatPago->MonId){
			   ?>
          :
          
          <?php
		   }
		  ?>
          
          </td>
          <td align="left" valign="middle">
		  
		   <?php 
		   
		   if($InsOrdenVentaVehiculo->MonId <> $DatPago->MonId){
			   ?>
                <span class="EstOrdenVentaVehiculoImprimirContenido">
				<?php echo ($DatPago->PagTipoCambio); ?>
                </span>
                
               <?php
		   }
		   ?>
		   
		  
           
           
		 
           
            
            
            </td>
        </tr>
        <tr>
          <td width="356" align="left" valign="middle">
          
            
               <?php 
		   
		   if($InsOrdenVentaVehiculo->MonId <> $DatPago->MonId){
			   ?>
          
          <span class="EstOrdenVentaVehiculoImprimirEtiqueta">MONTO DE  DEPÓSITO </span>
          <?php
		   }
		  ?>
          
          </td>
          <td width="10" align="center" valign="middle">
            
               <?php 
		   
		   if($InsOrdenVentaVehiculo->MonId <> $DatPago->MonId){
			   ?>
               
          :
          <?php
		   }
		  ?>
          
          </td>
          <td width="403" align="left" valign="middle">
            
            
            
           
             
               <?php 
		   
		   if($InsOrdenVentaVehiculo->MonId <> $DatPago->MonId){
			   ?>
              
              
				<?php echo ($InsOrdenVentaVehiculo->MonSimbolo); ?>
             
             <?php $DatPago->PagMonto = (($DatPago->PagMonto/$DatPago->PagTipoCambio));?>
             
             <span class="EstOrdenVentaVehiculoImprimirContenido"> <?php echo number_format($DatPago->PagMonto,2); ?> </span>
             
             
             
             
               <?php
		   }
		   ?>
           
           
          
             
             
             
             </td>
        </tr>
      </table><br />
      
<?php
}
?>
 
      
      
      
        <?php
	  }
	  
	  ?>
     
      
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" >
      
		<span class="EstOrdenVentaVehiculoImprimirContenido">
      	SE  EMITE EL PRESENTE DOCUMENTO PARA LA INSCRIPCION DEL VEHÍCULO.
		</span>
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><span class="EstOrdenVentaVehiculoImprimirContenido">
        <?php
	  list($Dia,$Mes,$Ano) = explode("/",$InsOrdenVentaVehiculo->OvvFecha);;
	  ?>
Tacna, <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?>
<?php //echo $InsOrdenVentaVehiculo->OvvFecha;?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td colspan="2" align="left" valign="top" ><!--<img src="../../imagenes/sello_cyc.png" width="246" height="130" />-->
        
  <table width="100%">
  <tr>
  <td height="150" align="center" valign="bottom">


  
    <span class="EstOrdenVentaVehiculoImprimirNota3">
    <?php echo ucwords(strtolower($EmpresaRepresentanteNombre));?><br />
    <?php echo ucwords(strtolower($EmpresaRepresentanteNumeroDocumento));?>
          </span>    
          
          
          	
	
  
  </td>
  
	<?php
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
    
   
  <td height="150" align="center" valign="bottom">
  
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




 
 
</body>
</html>
