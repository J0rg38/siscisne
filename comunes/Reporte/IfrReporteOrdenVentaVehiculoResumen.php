<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_VENTA_VEHICULO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="js/JsReporteOrdenVentaVehiculoResumen.js"></script>

<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"OvvId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

$POST_ConCotizacion = ($_POST['CmpConCotizacion']);

$POST_Personal = $_POST['CmpPersonal'];


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsCliente = new ClsCliente();
$InsMoneda = new ClsMoneda();
$InsPago = new ClsPago();

if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}

if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","contiene",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}



//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0)

//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0)

$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,$POST_Moneda,$POST_Personal,$POST_ClienteId,$POST_ConCotizacion);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];


$POST_Moneda = (empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda);

//deb($POST_Moneda);

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();


?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="243" height="59" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE ORDENES DE VENTA   DEL
      <?php
  if($POST_finicio == $POST_ffin){
?>
      <?php echo $POST_finicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_finicio; ?> AL <?php echo $POST_ffin; ?>
      <?php  
  }
?>



 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        
      
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th width="10%" rowspan="2">ORD. VEN.</th>
          <th colspan="6" align="center">ESTADO GENERAL</th>
          <th colspan="4">DATOS DEL CLIENTE</th>
          <th colspan="3" align="center">FACTURACION</th>
          <th colspan="2" align="center">ABONOS</th>
          <th colspan="2" align="center">SALDO</th>
          </tr>
        <tr>
          <th width="2%">#</th>
          <th width="2%">&nbsp;</th>
          <th width="8%">COT. REF.</th>
          <th width="11%" align="center">TOTAL</th>
          <th width="11%" align="center">ESTADO</th>
          <th width="11%" align="center">MONEDA</th>
          <th width="11%" align="center">T.C.</th>
          <th width="11%" align="center">TOTAL</th>
          <th width="8%">TIPO CLI.</th>
          <th width="8%">TIPO DOC.</th>
          <th width="8%">NUM. DOC.</th>
          <th width="25%">CLIENTE</th>
          <th width="5%" align="center">COMPROB. EMITIDO</th>
          <th width="6%" align="center">FECHA</th>
          <th width="6%" align="center">TOTAL</th>
          <th width="6%" align="center">FECHA</th>
          <th width="3%" align="center">MONTO</th>
          <th width="3%" align="center">FACTURA</th>
          <th width="3%" align="center">ORDEN</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$OrdenVentaVehiculoSumaTotal = 0;
		$TotalFacturado = 0;
		$TotalAbonado = 0;
		
		$c=1;
        foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){



			
        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   >
                  <?php
				  if($_GET['P']<>2){
			 ?>
             <input onClick="javascript:FncAgregarSeleccionado();" type="checkbox" name="cmp_seleccionar[]" id="cmp_seleccionar[]"  value="<?php echo $DatOrdenVentaVehiculo->AmoId; ?>"  />
             <?php 
				  }
				  ?>
                  
                  
                </td>
                <td  align="right" valign="top"   >
				<a target="_blank" href="../../principal.php?Mod=OrdenVentaVehiculo&Form=VerEstado&Id=<?php echo ($DatOrdenVentaVehiculo->OvvId);?>">
				<?php echo ($DatOrdenVentaVehiculo->OvvId);?>
                </a>
                </td>
                <td  align="right" valign="top"   >&nbsp; <?php echo ($DatOrdenVentaVehiculo->CprId);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->OvvFecha);?></td>
                <td align="right" valign="top"  >
                  
                  
  <?php echo ($DatOrdenVentaVehiculo->OvvEstadoDescripcion);?>
                </td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->MonNombre);?></td>
                <td align="right" valign="top"  >&nbsp;<?php echo ($DatOrdenVentaVehiculo->OvvTipoCambio);?></td>
                <td align="right" valign="top"  >
				
				
				<?php $DatOrdenVentaVehiculo->OvvTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatOrdenVentaVehiculo->OvvTotal:($DatOrdenVentaVehiculo->OvvTotal/$DatOrdenVentaVehiculo->OvvTipoCambio));?>
                  <?php echo number_format($DatOrdenVentaVehiculo->OvvTotal,2);?>
                  
                  
                  </td>
                <td  align="right" valign="top"   >
				
				<?php echo (empty($DatOrdenVentaVehiculo->LtiAbreviatura)?$DatOrdenVentaVehiculo->LtiNombre:$DatOrdenVentaVehiculo->LtiAbreviatura)//FncCortarTexto($DatOrdenVentaVehiculo->LtiNombre,15);?>
				<?php //echo ($DatOrdenVentaVehiculo->LtiNombre);;?></td>
                <td  align="right" valign="top"   ><?php echo ($DatOrdenVentaVehiculo->TdoNombre);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatOrdenVentaVehiculo->CliNumeroDocumento);?></td>
                <td  align="right" valign="top"   >
                
               
               
                <?php echo ($DatOrdenVentaVehiculo->CliNombre);?>
                <?php echo ($DatOrdenVentaVehiculo->CliApellidoPaterno);?>
                <?php echo ($DatOrdenVentaVehiculo->CliApellidoMaterno);?>
               
                </td>
                    <td align="right" valign="top"  >
                      <?php
				switch($DatOrdenVentaVehiculo->OvvComprobanteVenta){
					case "F":
				?>
                      <?php echo $DatOrdenVentaVehiculo->OvvFacturaNumero?>
                      <?php	
					break;
					
					case "B":
				?>
                      <?php echo $DatOrdenVentaVehiculo->OvvBoletaNumero?>
                      <?php	
					break;
					
					default:
				?>
                      -
                    <?php	
					break;
				}
				?>&nbsp;</td>
                    <td align="right" valign="top"  >


 <?php
				switch($DatOrdenVentaVehiculo->OvvComprobanteVenta){
					case "F":
				?>
                



 
                      <?php echo $DatOrdenVentaVehiculo->OvvFacturaFecha?>
                      <?php	
					break;
					
					case "B":
				?>
                      <?php echo $DatOrdenVentaVehiculo->OvvBoletaFecha?>
                      <?php	
					break;
					
					default:
				?>
                      -
                    <?php	
					break;
				}
				?>
                
                &nbsp;
                     
                
					</td>
                    <td align="right" valign="top"  >



 
				<?php
				
				$TotalFactura = 0;
				switch($DatOrdenVentaVehiculo->OvvComprobanteVenta){
					case "F":
				?>


						<?php $TotalFactura = $DatOrdenVentaVehiculo->OvvFacturaTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatOrdenVentaVehiculo->OvvFacturaTotal:($DatOrdenVentaVehiculo->OvvFacturaTotal/$DatOrdenVentaVehiculo->OvvFacturaTipoCambio));?>
						
						<?php echo number_format($DatOrdenVentaVehiculo->OvvFacturaTotal,2);?>
                        
                      <?php	
					break;
					
					case "B":
				?>

						<?php $TotalFactura = $DatOrdenVentaVehiculo->OvvBoletaTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatOrdenVentaVehiculo->OvvBoletaTotal:($DatOrdenVentaVehiculo->OvvBoletaTotal/$DatOrdenVentaVehiculo->OvvBoletaTipoCambio));?>
 
						<?php echo number_format($DatOrdenVentaVehiculo->OvvBoletaTotal,2)?>


                      <?php	
					break;
					
					default:
				?>
                      -
                    <?php	
					break;
				}
				?>
                
                <?php
				$TotalFacturado += $TotalFactura;
				?>
                &nbsp;
                </td>
                      
                      
                    <?php
                    $TotalAbono = 0;
                    $FechaUltimoAbono = "";
					?>
                     
                    
                    <?php
                    $InsPago = new ClsPago();

//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL)
                    $ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,'PagId','Desc',NULL,NULL,NULL,$DatOrdenVentaVehiculo->OvvId,NULL,NULL,NULL,NULL,NULL,NULL);
                    $ArrPagos = $ResPago['Datos'];
                    ?>
                    
                    
                        <?php
                        foreach($ArrPagos as $DatPago){
                        ?>
                        <?php $DatPago->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));?>
                        
                            <?php $TotalAbono += $DatPago->PagMonto;?>
                            
                            <?php
                            $FechaUltimoAbono = $DatPago->PagFecha;
                            ?>
                        <?php	
                        }
                        ?>
                    
                      <?php	
                 
                    
                    $TotalAbonado += $TotalAbono;
                    ?>
                    
                    <td align="right" valign="top"  ><?php echo ($FechaUltimoAbono);?>&nbsp;
                    
                    </td>
                    <td align="right" valign="top"  >
                    
                        <?php echo number_format($TotalAbono,2);?>
                    
                    </td>
                    <td align="right" valign="top"  >
                        
                        <?php
                        $SaldoFactura = 0;
						?>
                        
                        <?php
						if(!empty($DatOrdenVentaVehiculo->OvvFacturaNumero) or !empty($DatOrdenVentaVehiculo->OvvBoletaNumero)){
						?>
								 <?php
                                $SaldoFactura = $TotalFactura - $TotalAbono;
                                ?>
                        <?php	
						}
						
						?>
                       
                        
                        <?php echo number_format($SaldoFactura,2);?>
                    
                    </td>
                    <td align="right" valign="top"  >
                    
                        <?php 
                        $SaldoOrden = 0;
                        $SaldoOrden = $DatOrdenVentaVehiculo->OvvTotal - $TotalAbono;
                        ?>
                        
                        <?php echo number_format($SaldoOrden,2);?>
                    
                    </td>

</tr>
		<?php	
			$OrdenVentaVehiculoSumaTotal += $DatOrdenVentaVehiculo->OvvTotal;
		?>
  		
      
      
              
        <?php
		 $c++;
        }
        ?>
        
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="5" align="right"> TOTAL ORDEN:</td>
            <td align="right"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($OrdenVentaVehiculoSumaTotal,2);?></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="2" align="right">TOTAL FACTURADO</td>
            <td align="right"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalFacturado,2);?></td>
            <td align="right">TOTAL ABONADO</td>
            <td align="right"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalAbonado,2);?></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>