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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REGISTRO_VENTAS_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
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

$POST_finicio = isset($_GET['CmpFechaInicio'])?$_GET['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_GET['CmpFechaFin'])?$_GET['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['CmpOrden'])?$_GET['CmpOrden']:"FechaEmision";
$POST_sen = isset($_GET['CmpSentido'])?$_GET['CmpSentido']:"DESC";

$POST_Moneda = ($_GET['CmpMoneda']);

$POST_ClienteNombre = ($_GET['CmpClienteNombre']);
$POST_ClienteNumeroDocumento = ($_GET['CmpClienteNumeroDocumento']);
$POST_ClienteId = ($_GET['CmpClienteId']);

$POST_CondicionPago = ($_GET['CmpCondicionPago']);
$POST_Personal = ($_GET['CmpPersonal']);


$POST_Filtro = ($_GET['CmpFiltro']);
$POST_Sucursal = ($_GET['CmpSucursal']);

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteComprobanteVenta.php');

$InsPago = new ClsPago();
$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsCliente = new ClsCliente();
$InsNotaCredito = new ClsNotaCredito();
$InsBoleta = new ClsBoleta();
$InsNotaCredito = new ClsNotaCredito();
$InsNotaDebito = new ClsNotaDebito();
$InsReporteComprobanteVenta = new ClsReporteComprobanteventa();
//
//if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
//	
//	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
//	$ArrClientes = $ResCliente['Datos'];
//	
//	if(!empty($ArrClientes)){
//		foreach($ArrClientes as $DatCliente){
//			$POST_ClienteId = $DatCliente->CliId;
//		}
//	}
//
//}
//
//
//if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
//	
//	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","contiene",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
//	$ArrClientes = $ResCliente['Datos'];
//	
//	if(!empty($ArrClientes)){
//		foreach($ArrClientes as $DatCliente){
//			$POST_ClienteId = $DatCliente->CliId;
//		}
//	}
//
//}


//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL,$oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
$ResFactura = $InsReporteComprobanteVenta->MtdObtenerFacturas("CliNombre,CliNumeroDocumento","contiene",$POST_Filtro,"Fac".$POST_ord,$POST_sen,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,NULL,NULL,$POST_Moneda,$POST_ClienteId,NULL,NULL,NULL,NULL,NULL,$POST_Personal,NULL,$POST_Sucursal);
$ArrFacturas = $ResFactura['Datos'];

//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
$ResBoleta = $InsReporteComprobanteVenta->MtdObtenerBoletas("CliNombre,CliNumeroDocumento","contiene",$POST_Filtro,"Bol".$POST_ord,$POST_sen,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,$POST_Moneda,NULL,$POST_ClienteId,NULL,NULL,NULL,$POST_Sucursal);
$ArrBoletas = $ResBoleta['Datos'];


//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL,$oClienteId=NULL,$oNoProcesdado=false)
$ResNotaCredito = $InsReporteComprobanteVenta->MtdObtenerNotaCreditos("CliNombre,CliNumeroDocumento","contiene",$POST_Filtro,"Ncr".$POST_ord,$POST_sen,1,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,$POST_Moneda,NULL,NULL,$POST_Sucursal,$POST_ClienteId);
$ArrNotaCreditos = $ResNotaCredito['Datos'];

//MtdObtenerNotaDebitos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NdbId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL) {
$ResNotaDebito = $InsReporteComprobanteVenta->MtdObtenerNotaDebitos("CliNombre,CliNumeroDocumento","contiene",$POST_Filtro,"Ndb".$POST_ord,$POST_sen,1,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,$POST_Moneda,NULL,NULL,$POST_Sucursal);
$ArrNotaDebitos = $ResNotaDebito['Datos'];


?>

<?php
if($_GET['P']==2){
?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">&nbsp;</td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REGISTRO DE VENTAS DEL
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
  <td width="23%" align="right" valign="top">&nbsp;</td>
</tr>
</table>
<?php	
}
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">

    <img src="../../imagenes/logos/logo_reporte.png" width="243" height="59" />

  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REGISTRO DE VENTAS DEL
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
          <th width="2%" rowspan="2">#</th>
          <th width="10%" rowspan="2">Número correlativo del registro o código unico de la operación</th>
          <th width="10%" rowspan="2">Fecha de emisión del comprobante de pago o documento</th>
          <th width="10%" rowspan="2">Fecha de vencimiento y/o pago</th>
          <th colspan="3">COMROBANTE DE PAGO O DOCUMENTO</th>
          <th colspan="3">INFORMACION DEL CLIENTE</th>
          <th width="5%" rowspan="2">Valor facturado de la exportación</th>
          <th width="5%" rowspan="2">Base imponible de la operación gravada</th>
          <th colspan="2">IMPORTE TOTAL DE LA OPERACION</th>
          <th width="7%" rowspan="2">IGV Y/O IPM</th>
          <th width="7%" rowspan="2">Otros tributos y cargos que no forman parte de la base imponible</th>
          <th width="7%" rowspan="2">Importe total del comprobante de pago</th>
          <th width="7%" rowspan="2">Tipo de cambio</th>
          <th colspan="4">Referencia del comprobante de pago o documento original que se modifica</th>
          <th width="7%" rowspan="2">estado</th>
          <th width="7%" rowspan="2">total Descuento</th>
          <th width="7%" rowspan="2">total Venta Gratuita</th>
          <th colspan="2">SUNAT</th>
          <th width="7%" rowspan="2">Moneda</th>
          </tr>
        <tr>
          <th width="10%">tipo (Tabla 10)</th>
          <th width="10%">N° serie o N° de serie de la maquina registradora</th>
          <th width="10%">Número</th>
          <th width="5%">Tipo (Tabla12)</th>
          <th width="5%">Número</th>
          <th width="5%">Apellidos y nombres, denominación o razon social</th>
          <th width="31%">exonerada</th>
          <th width="7%">Inafecta</th>
          <th width="7%">fecha</th>
          <th width="7%">Tipo (Tabla 10)</th>
          <th width="7%">Serie</th>
          <th width="7%">Nro. del comprobante de pago o documento</th>
          <th width="7%">Accion</th>
          <th width="7%">Rpta.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		
		$FacturaSubTotal = 0;
		$FacturaImpuesto = 0;
		$FacturaTotal = 0;
		
		$FacturaAmortizadoTotal = 0;
		$FacturaSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalFacturaNoCancelada = 0;
		
        foreach($ArrFacturas as $DatFactura){
			
			//
//			$DatFactura->FacSubTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFactura->FacSubTotal:($DatFactura->FacSubTotal/$DatFactura->FacTipoCambio));
//			$DatFactura->FacImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFactura->FacImpuesto:($DatFactura->FacImpuesto/$DatFactura->FacTipoCambio));
//			$DatFactura->FacTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFactura->FacTotal:($DatFactura->FacTotal/$DatFactura->FacTipoCambio));
//			
			/*$DatFactura->FacSubTotal = round($DatFactura->FacSubTotal,2);
			$DatFactura->FacImpuesto = round($DatFactura->FacImpuesto,2);
			$DatFactura->FacTotal = round($DatFactura->FacTotal,2);*/
			
			
			$DatFactura->FacSubTotal = ($DatFactura->FacSubTotal/(empty($DatFactura->FacTipoCambio)?1:$DatFactura->FacTipoCambio));
			$DatFactura->FacImpuesto = ($DatFactura->FacImpuesto/(empty($DatFactura->FacTipoCambio)?1:$DatFactura->FacTipoCambio));
			$DatFactura->FacTotal = ($DatFactura->FacTotal/(empty($DatFactura->FacTipoCambio)?1:$DatFactura->FacTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatFactura->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatFactura->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatFactura->FacFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			if(!empty($DatFactura->FacTipoCambioAux)){
				$TipoCambio = $DatFactura->FacTipoCambioAux;
			}
			
			
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacFechaVencimiento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >01</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FtaNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->TdoCodigo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" > <?php echo $DatFactura->CliApellidoPaterno;  ?> <?php echo $DatFactura->CliApellidoMaterno;  ?> <?php echo $DatFactura->CliNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
			<?php
			if($DatFactura->MonId<>$EmpresaMonedaId){
			?>
            
				<?php
                if(!empty($TipoCambio)){
                ?>
                 
                    <?php $DatFactura->FacSubTotal = ($DatFactura->FacSubTotal*$TipoCambio);?>
              
                <?php	
                }else{

					$DatFactura->FacSubTotal = 0;

                ?>
                    
                    No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatFactura->FacFechaEmision;?>)
                    
                <?php	
                }
                ?>
        
			<?php	
			}
            ?>
		 
          <?php echo number_format($DatFactura->FacSubTotal,2);?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >000</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		      <?php
			if($DatFactura->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php $DatFactura->FacImpuesto = ($DatFactura->FacImpuesto*$TipoCambio);?>
              
          
            <?php	
			}else{
				
				$DatFactura->FacImpuesto = 0;
			?>
            
				No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatFactura->FacFechaEmision;?>)
                
            <?php	
			}
			?>
        
        <?php	
			}
		  ?>
          
          
		  <?php echo number_format($DatFactura->FacImpuesto,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		    
          <?php
			if($DatFactura->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php $DatFactura->FacTotal =  ($DatFactura->FacTotal*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatFactura->FacTotal = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatFactura->FacFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php echo number_format($DatFactura->FacTotal,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php //echo $DatFactura->FacTipoCambio;  ?><?php echo $TipoCambio;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo  $DatFactura->FacEstadoDescripcion;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatFactura->FacTotalDescuento,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatFactura->FacTotalGratuito,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacSunatUltimaAccion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->FacSunatUltimaRespuesta;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFactura->MonSimbolo;  ?></td>
          </tr>
        <?php	
			
			$FacturaSubTotal += round($DatFactura->FacSubTotal,2);
			$FacturaImpuesto += round($DatFactura->FacImpuesto,2);
			$FacturaTotal += round($DatFactura->FacTotal,2);
			
			
			$FacturaAmortizadoTotal += $ClientePagoMontoTotal;
			$FacturaSaldoTotal += $FacturaSaldo;
			
		$c++;
        }
        ?>
        
        
        
         <?php
		//$c=1;
		$BoletaSubTotal = 0;
		$BoletaImpuesto= 0;
		$BoletaTotal = 0;
		
		$BoletaAmortizadoTotal = 0;
		$BoletaSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalBoletaNoCancelada = 0;
		
        foreach($ArrBoletas as $DatBoleta){
			
			 
				
			//$DatBoleta->BolSubTotal = round($DatBoleta->BolSubTotal,2);
//			$DatBoleta->BolImpuesto = round($DatBoleta->BolImpuesto,2);
//			$DatBoleta->BolTotal = round($DatBoleta->BolTotal,2);

			$DatBoleta->BolSubTotal = ($DatBoleta->BolSubTotal/(empty($DatBoleta->BolTipoCambio)?1:$DatBoleta->BolTipoCambio));
			$DatBoleta->BolImpuesto = ($DatBoleta->BolImpuesto/(empty($DatBoleta->BolTipoCambio)?1:$DatBoleta->BolTipoCambio));
			$DatBoleta->BolTotal = ($DatBoleta->BolTotal/(empty($DatBoleta->BolTipoCambio)?1:$DatBoleta->BolTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatBoleta->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatBoleta->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatBoleta->BolFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			
			if(!empty($DatBoleta->BolTipoCambioAux)){
				$TipoCambio = $DatBoleta->BolTipoCambioAux;
			}
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">&nbsp;</td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->BolFechaEmision;  ?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->BolFechaVencimiento;  ?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">03</td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->BtaNumero;  ?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->BolId;  ?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->TdoCodigo;  ?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoleta->CliNumeroDocumento;  ?>
          </td>
          
          
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"> <?php echo $DatBoleta->CliApellidoPaterno;  ?> <?php echo $DatBoleta->CliApellidoMaterno;  ?> <?php echo $DatBoleta->CliNombre;  ?></span></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		  
		  
          
          <?php
			if($DatBoleta->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php $DatBoleta->BolSubTotal =  ($DatBoleta->BolSubTotal*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatBoleta->BolSubTotal = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatBoleta->BolFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
          
          
		  <?php echo number_format($DatBoleta->BolSubTotal,2);?>
          
          
          
          
          </td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >0.00</td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
          
          
		  
		  
		      <?php
			if($DatBoleta->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php  $DatBoleta->BolImpuesto = ($DatBoleta->BolImpuesto*$TipoCambio);?>
          
            <?php	
			}else{
				
					$DatBoleta->BolImpuesto = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatBoleta->BolFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
		  
		  <?php echo number_format($DatBoleta->BolImpuesto,2);?>
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		
        
		<?php
		
			if($DatBoleta->MonId<>$EmpresaMonedaId){
			
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
             <?php $DatBoleta->BolTotal = ($DatBoleta->BolTotal*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatBoleta->BolTotal = 0;
				
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatBoleta->BolFechaEmision;?>)
            <?php	
			}
			?>
        
		<?php	
        	}
        ?>
        
		  
		  <?php echo number_format($DatBoleta->BolTotal,2);?>
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php //echo $DatBoleta->BolTipoCambio;  ?>
          
          <?php echo $TipoCambio;?>
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo  $DatBoleta->BolEstadoDescripcion;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatBoleta->BolSubTotal,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatBoleta->BolTotalGratuito,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->BolSunatUltimaAccion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->BolSunatUltimaRespuesta;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoleta->MonSimbolo;  ?></td>
          </tr>
        <?php	
			
			$BoletaSubTotal += round($DatBoleta->BolSubTotal,2);
			$BoletaImpuesto += round($DatBoleta->BolImpuesto,2);
			$BoletaTotal += round($DatBoleta->BolTotal,2);
			
			$BoletaAmortizadoTotal += $ClientePagoMontoTotal;
			$BoletaSaldoTotal += $BoletaSaldo;
			
		$c++;
        }
        ?> 
         
        <?php
		//$c=1;
		$NotaCreditoSubTotal = 0;
		$NotaCreditoImpuesto = 0;
		$NotaCreditoTotal = 0;
		
		$NotaCreditoAmortizadoTotal = 0;
		$NotaCreditoSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalNotaCreditoNoCancelada = 0;
		
        foreach($ArrNotaCreditos as $DatNotaCredito){
			
 	
			//$DatNotaCredito->NcrTotal = round($DatNotaCredito->NcrTotal,2);
//			$DatNotaCredito->NcrSubTotal = round($DatNotaCredito->NcrSubTotal,2);
//			$DatNotaCredito->NcrImpuesto = round($DatNotaCredito->NcrImpuesto,2);
//			
			
			$DatNotaCredito->NcrSubTotal = ($DatNotaCredito->NcrSubTotal/(empty($DatNotaCredito->NcrTipoCambio)?1:$DatNotaCredito->NcrTipoCambio));
			$DatNotaCredito->NcrImpuesto = ($DatNotaCredito->NcrImpuesto/(empty($DatNotaCredito->NcrTipoCambio)?1:$DatNotaCredito->NcrTipoCambio));
			$DatNotaCredito->NcrTotal = ($DatNotaCredito->NcrTotal/(empty($DatNotaCredito->NcrTipoCambio)?1:$DatNotaCredito->NcrTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatNotaCredito->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatNotaCredito->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaCredito->NcrFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			
			
			if(!empty($DatNotaCredito->NcrTipoCambioAux)){
				$TipoCambio = $DatNotaCredito->NcrTipoCambioAux;
			}
			
			
			$DatNotaCredito->NcrTotal = ($DatNotaCredito->NcrTotal*-1);
			$DatNotaCredito->NcrSubTotal = ($DatNotaCredito->NcrSubTotal*-1);
			$DatNotaCredito->NcrImpuesto = ($DatNotaCredito->NcrImpuesto*-1);
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >07</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NctNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->TdoNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		  <?php echo $DatNotaCredito->CliApellidoPaterno;  ?>  <?php echo $DatNotaCredito->CliApellidoMaterno;  ?>  <?php echo $DatNotaCredito->CliNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          
          <?php
			if($DatNotaCredito->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>

				<?php  $DatNotaCredito->NcrSubTotal = ($DatNotaCredito->NcrSubTotal*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatNotaCredito->NcrSubTotal = 0;
				
			?>
				No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaCredito->NcrFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php echo number_format($DatNotaCredito->NcrSubTotal,2);?>
          
          
          
          
          
          
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php
			if($DatNotaCredito->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php  $DatNotaCredito->NcrImpuesto = ($DatNotaCredito->NcrImpuesto*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatNotaCredito->NcrImpuesto = 0;
				
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaCredito->NcrFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php echo number_format($DatNotaCredito->NcrImpuesto,2);?>
          
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
          
          <?php
			if($DatNotaCredito->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
             <?php $DatNotaCredito->NcrTotal = ($DatNotaCredito->NcrTotal*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatNotaCredito->NcrTotal = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaCredito->NcrFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		
		  <?php echo number_format($DatNotaCredito->NcrTotal,2);?>
          
         
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $TipoCambio;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DocFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DocTipoDocumentoCodigo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DtaNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->DocId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo  $DatNotaCredito->NcrEstadoDescripcion;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatNotaCredito->NcrTotalDescuento,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatNotaCredito->NcrTotalGratuito,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrSunatUltimaAccion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->NcrSunatUltimaRespuesta;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCredito->MonSimbolo;  ?></td>
          </tr>
        <?php	
			
			$NotaCreditoSubTotal += round($DatNotaCredito->NcrSubTotal,2);
			$NotaCreditoImpuesto += round($DatNotaCredito->NcrImpuesto,2);
			$NotaCreditoTotal += round($DatNotaCredito->NcrTotal,2);
			
			$NotaCreditoAmortizadoTotal += $ClientePagoMontoTotal;
			$NotaCreditoSaldoTotal += $NotaCreditoSaldo;
			
		$c++;
        }
        ?>
        
          
          
          
             <?php
		//$c=1;
		$NotaDebitoSubTotal = 0;
		$NotaDebitoImpuesto = 0;
		$NotaDebitoTotal = 0;
		
		$NotaDebitoAmortizadoTotal = 0;
		$NotaDebitoSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalNotaDebitoNoCancelada = 0;
		
        foreach($ArrNotaDebitos as $DatNotaDebito){
			
 	
			//$DatNotaDebito->NdbTotal = round($DatNotaDebito->NdbTotal,2);
//			$DatNotaDebito->NdbSubTotal = round($DatNotaDebito->NdbSubTotal,2);
//			$DatNotaDebito->NdbImpuesto = round($DatNotaDebito->NdbImpuesto,2);
//			
			
			$DatNotaDebito->NdbSubTotal = ($DatNotaDebito->NdbSubTotal/(empty($DatNotaDebito->NdbTipoCambio)?1:$DatNotaDebito->NdbTipoCambio));
			$DatNotaDebito->NdbImpuesto = ($DatNotaDebito->NdbImpuesto/(empty($DatNotaDebito->NdbTipoCambio)?1:$DatNotaDebito->NdbTipoCambio));
			$DatNotaDebito->NdbTotal = ($DatNotaDebito->NdbTotal/(empty($DatNotaDebito->NdbTipoCambio)?1:$DatNotaDebito->NdbTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatNotaDebito->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatNotaDebito->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaDebito->NdbFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			
			
			if(!empty($DatNotaDebito->NdbTipoCambioAux)){
				$TipoCambio = $DatNotaDebito->NdbTipoCambioAux;
			}
			
		//	
//			$DatNotaDebito->NdbTotal = ($DatNotaDebito->NdbTotal*-1);
//			$DatNotaDebito->NdbSubTotal = ($DatNotaDebito->NdbSubTotal*-1);
//			$DatNotaDebito->NdbImpuesto = ($DatNotaDebito->NdbImpuesto*-1);
//			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->NdbFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >08</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->NdtNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->NdbId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->TdoNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		  <?php echo $DatNotaDebito->CliApellidoPaterno;  ?>  <?php echo $DatNotaDebito->CliApellidoMaterno;  ?>  <?php echo $DatNotaDebito->CliNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          
          <?php
			if($DatNotaDebito->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
             <?php  $DatNotaDebito->NdbSubTotal = ($DatNotaDebito->NdbSubTotal*$TipoCambio);?>
          
            <?php	
			}else{
				
				 $DatNotaDebito->NdbSubTotal = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaDebito->NdbFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php  echo number_format($DatNotaDebito->NdbSubTotal,2);?>
          
          
          
          
          
          
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php
			if($DatNotaDebito->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
             <?php  $DatNotaDebito->NdbImpuesto = ($DatNotaDebito->NdbImpuesto*$TipoCambio);?>
          
            <?php	
			}else{
				
					$DatNotaDebito->NdbImpuesto = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaDebito->NdbFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php echo number_format($DatNotaDebito->NdbImpuesto,2);?>
          
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >0.00</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
          
          <?php
			if($DatNotaDebito->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php  $DatNotaDebito->NdbTotal = ($DatNotaDebito->NdbTotal*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatNotaDebito->NdbTotal = 0;
				
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaDebito->NdbFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  
		
		  <?php echo number_format($DatNotaDebito->NdbTotal,2);?>
          
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php //echo $DatNotaDebito->NdbTipoCambio;  ?>
          
          <?php echo $TipoCambio;?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->DocFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->DocTipoDocumentoCodigo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->DtaNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->DocId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo  $DatNotaDebito->NdbEstadoDescripcion;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatNotaDebito->NdbTotalDescuento,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo number_format($DatNotaDebito->NdbTotalGratuito,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->NdbSunatUltimaAccion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->NdbSunatUltimaRespuesta;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebito->MonSimbolo;  ?></td>
          </tr>
        <?php	
			
			$NotaDebitoSubTotal += round($DatNotaDebito->NdbSubTotal,2);
			$NotaDebitoImpuesto += round($DatNotaDebito->NdbImpuesto,2);
			$NotaDebitoTotal += round($DatNotaDebito->NdbTotal,2);
			
			$NotaDebitoAmortizadoTotal += $ClientePagoMontoTotal;
			$NotaDebitoSaldoTotal += $NotaDebitoSaldo;
			
		$c++;
        }
        ?>
        
          <tr>
          
          
          
          
          
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        
        <?php
		$SumaSubTotales = 0;
		$SumaImpuestos = 0;
		$SumaTotales = 0;
		?>
        
        <table width="623" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="84">Comprobante de Venta</th>
          <th width="121">Base imponible de la operación gravada</th>
          <th width="153">IGV Y/O IPM</th>
          <th width="153">Importe total del comprobante de pago</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
   
        <?php
		$SumaSubTotales = $FacturaSubTotal + $BoletaSubTotal + $NotaCreditoSubTotal +  $NotaDebitoSubTotal;
		$SumaImpuestos = $FacturaImpuesto + $BoletaImpuesto + $NotaCreditoImpuesto  + $NotaDebitoImpuesto;
		$SumaTotales = $FacturaTotal + $BoletaTotal + $NotaCreditoTotal + $NotaDebitoTotal;
		?>
          <tr>
            <td align="right">Facturas:</td>
            <td align="right"><?php echo number_format($FacturaSubTotal,2);?></td>
            <td align="right"><?php echo number_format($FacturaImpuesto,2);?></td>
            <td align="right"><?php echo number_format($FacturaTotal,2);?></td>
          </tr>
          <tr>
            <td align="right">Boletas:</td>
            <td align="right"><?php echo number_format($BoletaSubTotal,2);?></td>
            <td align="right"><?php echo number_format($BoletaImpuesto,2);?></td>
            <td align="right"><?php echo number_format($BoletaTotal,2);?></td>
          </tr>
          <tr>
            <td align="right">Notas de Credito:</td>
            <td align="right"><?php echo number_format($NotaCreditoSubTotal,2);?></td>
            <td align="right"><?php echo number_format($NotaCreditoImpuesto,2);?></td>
            <td align="right"><?php echo number_format($NotaCreditoTotal,2);?></td>
          </tr>
          <tr>
            <td align="right">Notas de Debito:</td>
            <td align="right"><?php echo number_format($NotaDebitoSubTotal,2);?></td>
            <td align="right"><?php echo number_format($NotaDebitoSubTotal,2);?></td>
            <td align="right"><?php echo number_format($NotaDebitoTotal,2);?></td>
          </tr>
          <tr>
          
            <td align="right">Totales:</td>
            <td align="right"><?php echo number_format($SumaSubTotales,2);?></td>
            <td align="right"><?php echo number_format($SumaImpuestos,2);?></td>
            <td align="right"><?php echo number_format($SumaTotales,2);?></td>
          </tr>
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
</body>
</html>