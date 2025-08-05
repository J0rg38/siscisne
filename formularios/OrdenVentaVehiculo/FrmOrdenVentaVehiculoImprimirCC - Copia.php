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


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');

$GET_id = $_GET['Id'];
$GET_M = $_GET['M'];

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

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
      <td height="99" colspan="4" align="center" valign="top">
      
		<?php
        if($GET_M=="1"){
        ?>
			<img src="../../imagenes/dj_cabecera.jpg" align="[Cabecera]" title="Cabecera"  />
        <?php 
        }
        ?>
      
      
      </td>
      </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="2" align="center" valign="top">
        
        
        <span class="EstPlantillaTitulo">CARTA DE RESPONSABILIDAD</span><br />
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
        
       
	<span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo strtoupper($EmpresaNombre);?> con número de RUC: <?php echo $EmpresaCodigo;?> y con domicilio en la </span><span class="EstOrdenVentaVehiculoImprimirEtiqueta"> <?php echo strtoupper($EmpresaRepresentanteNombre);?> </span><span class="EstOrdenVentaVehiculoImprimirContenido"> NO SE RESPONSABILIZA en forma general por las ocurrencias o posibles daños e inconvenientes que pueda presentar la unidad (abajo detallada), despues de la entrega del vehiculo, el mismo que sera entregado sin tarjeta de propiedad y placas, la cual es recibida por el Sr(a).</span></p>
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
      <td colspan="2" align="left" valign="top" >   <span class="EstOrdenVentaVehiculoImprimirContenido">
          DETALLE DE UNIDAD
          </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td width="9%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="800" colspan="2" align="left" valign="top" >
        
        
        <?php
	  
	  if(!empty($ArrPagos)){
		?>
        
        <?php
foreach($ArrPagos as $DatPago){
?>
        
        <table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="356" align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
                MARCA</span></td>
            <td width="10" align="center" valign="middle">:</td>
            <td width="403" align="left" valign="middle">
              
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo strtoupper($DatPago->VmaNombre);?>
                </span>
              
              </td>
            </tr>
  
          
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">MODELO</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"><?php echo $DatPago->VmoNombre;?></span></td>
            </tr>
  
    
          
          <tr>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
                CLASE</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo $DatPago->EinClase;?>
                </span>
              </td>
            </tr>
       
          
          
          <tr>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
                CHASIS</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo strtoupper($DatPago->EinVIN);?>
                </span>
              </td>
            </tr>
          
          
          <tr>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirEtiqueta">
                MOTOR</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">
              <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo $DatPago->EinNumeroMotor;?>
                </span>
              </td>
            </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">CILINDRADA</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">  <span class="EstOrdenVentaVehiculoImprimirContenido">
                <?php echo $DatPago->PagFechaTransaccion;?>
                </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">COLOR</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"> <?php echo $DatPago->EinColor;?> </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">AÑO MODELO</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"> <?php echo $DatPago->EinAnoModelo;?> </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">AÑO FABRICACION</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"> <?php echo $DatPago->EinAnoFabricacion;?> </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">PLACA</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">PENDIENTE</td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">TARJETA</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">PENDIENTE</td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">F. DE ENTREGA</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">PENDIENTE</td>
          </tr>
          <tr>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirEtiqueta">ASESOR</span></td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><span class="EstOrdenVentaVehiculoImprimirContenido"> <?php echo $DatPago->PerNombre;?> <?php echo $DatPago->PerApellidoPaterno;?> <?php echo $DatPago->PerApellidoMaterno;?> </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="center" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          </table><br />
        
        <?php
}
?>
        
        
        
        
        <?php
	  }
	  
	  ?>
        <br />
        
        <span class="EstOrdenVentaVehiculoImprimirContenido">
          SE  EMITE EL PRESENTE DOCUMENTO PARA LA INSCRIPCION DEL VEHÍCULO.
          </span>
        <br />
        
        <span class="EstOrdenVentaVehiculoImprimirContenido">
          <?php
	//  list($Dia,$Mes,$Ano) = explode("/",$InsOrdenVentaVehiculo->OvvFecha);;
	  list($Dia,$Mes,$Ano) = explode("/",date("d/m/Y"));;
	  ?>
          Tacna, <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?>
          <?php //echo $InsOrdenVentaVehiculo->OvvFecha;?>
          </span>
        <!--<img src="../../imagenes/sello_cyc.png" width="246" height="130" />-->
        <br />
        <table width="100%" align="center">
          <tr>
            <td height="140" align="center" valign="top">&nbsp;</td>
            <td height="140" align="center" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td width="50%" height="140" align="center" valign="top">
              
              
              
              <span class="EstOrdenVentaVehiculoImprimirNota3">
                <?php echo ucwords(strtolower($EmpresaRepresentanteNombre));?><br />
                <?php echo ucwords(strtolower($EmpresaRepresentanteNumeroDocumento));?>
                </span>    
              
              
              
              
              
              </td>
            
            
            
            
            <td width="50%" height="140" align="center" valign="top">
              
              
              
              <?php
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	?>
              <?php
	if($DatOrdenVentaVehiculoPropietario->OvpFirmaDJ=="1"){
	?>
              <span class="EstOrdenVentaVehiculoImprimirNota3"> <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> <br />
                
                <?php echo $DatOrdenVentaVehiculoPropietario->TdoNombre;?>:  <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?><br />
                </span>    <br />  <br />  <br />  <br /><br /><br />
              <?php	 
	}
	?>
              
              
              <?php
	}
	?>  
              </td>
            
            
            </tr>
          </table>
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="center" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">
        
        
        <?php
        if($GET_M=="1"){
        ?>
        <img src="../../imagenes/dj_pie.jpg" alt="" align="[Pie]" title="Pie"  />
        <?php 
        }
        ?>
        
        
        </td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>




 
 
</body>
</html>
