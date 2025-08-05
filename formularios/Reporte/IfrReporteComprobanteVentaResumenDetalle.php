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
	header("Content-Disposition:  filename=\"REGISTRO_VENTAS_DETALLE_".date('d-m-Y').".xls\";");
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

$POST_FechaInicio = isset($_GET['CmpFechaInicio'])?$_GET['CmpFechaInicio']:"01/01/".date("Y");
$POST_FechaFin = isset($_GET['CmpFechaFin'])?$_GET['CmpFechaFin']:date("d/m/Y");

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
require_once($InsPoo->MtdPaqReporte().'ClsReporteComprobanteVentaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');


$InsPago = new ClsPago();
$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsCliente = new ClsCliente();
$InsNotaCredito = new ClsNotaCredito();
$InsBoleta = new ClsBoleta();
$InsNotaCredito = new ClsNotaCredito();
$InsNotaDebito = new ClsNotaDebito();
$InsReporteComprobanteVentaDetalle = new ClsReporteComprobanteVentaDetalle();
$InsProducto = new ClsProducto();


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


//MtdObtenerFacturaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFactura=NULL,$oTalonario=NULL,$oAlmacenMovimientoDetalleId=NULL,$oFacturaEstado=NULL,$oVentaDirectaDetalleId=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oMoneda=NULL,$oTalonario=NULL) {
$ResFactura = $InsReporteComprobanteVentaDetalle->MtdObtenerFacturaDetalles("CliNombre,CliNumeroDocumento","contiene",$POST_Filtro,"Fac".$POST_ord,$POST_sen,NULL,NULL,NULL,NULL,"1,5",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_Sucursal,$POST_Moneda,$POST_Talonario);
$ArrFacturaDetalles = $ResFactura['Datos'];

//MtdObtenerFacturaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFactura=NULL,$oTalonario=NULL,$oAlmacenMovimientoDetalleId=NULL,$oFacturaEstado=NULL,$oVentaDirectaDetalleId=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oMoneda=NULL,$oTalonario=NULL) {
$ResBoleta = $InsReporteComprobanteVentaDetalle->MtdObtenerBoletaDetalles("CliNombre,CliNumeroDocumento","contiene",$POST_Filtro,"Bol".$POST_ord,$POST_sen,NULL,NULL,NULL,NULL,"1,5",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_Sucursal,$POST_Moneda,$POST_Talonario);
$ArrBoletaDetalles = $ResBoleta['Datos'];


//MtdObtenerNotaCreditoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oNotaCredito=NULL,$oTalonario=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oMoneda=NULL,$oTalonario=NULL) {
$ResNotaCredito = $InsReporteComprobanteVentaDetalle->MtdObtenerNotaCreditoDetalles("CliNombre,CliNumeroDocumento","contiene",$POST_Filtro,"Ncr".$POST_ord,$POST_sen,1,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_Sucursal,$POST_Moneda,$POST_Talonario);
$ArrNotaCreditoDetalles = $ResNotaCredito['Datos'];

//MtdObtenerNotaDebitoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NddId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oNotaDebito=NULL,$oTalonario=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oMoneda=NULL,$oTalonario=NULL) {
$ResNotaDebito = $InsReporteComprobanteVentaDetalle->MtdObtenerNotaDebitoDetalles("CliNombre,CliNumeroDocumento","contiene",$POST_Filtro,"Ndb".$POST_ord,$POST_sen,1,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_Sucursal,$POST_Moneda,$POST_Talonario);
$ArrNotaDebitoDetalles = $ResNotaDebito['Datos'];

//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProNombre","ASC","500",1,$POST_ProductoTipo,NULL,NULL,NULL,NULL,NULL,false,$POST_Referencia,NULL,0,$POST_ProductoCategoria,false,NULL,$POST_ProductoCalculoPrecio);
$ArrProductos = $ResProducto['Datos'];
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REGISTRO DE VENTAS DETALLADO DEL
      <?php
  if($POST_FechaInicio == $POST_FechaFin){
?>
      <?php echo $POST_FechaInicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_FechaInicio; ?> AL <?php echo $POST_FechaFin; ?>
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REGISTRO DE VENTAS DETALLADO DEL
      <?php
  if($POST_FechaInicio == $POST_FechaFin){
?>
      <?php echo $POST_FechaInicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_FechaInicio; ?> AL <?php echo $POST_FechaFin; ?>
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
          <th width="2%">#</th>
          <th width="10%">FECHA</th>
          <th width="10%">TIPO</th>
          <th width="10%">SERIE</th>
          <th width="10%">NUMERO</th>
          <th width="10%">DOCUMENTO</th>
          <th width="10%">RAZON SOCIAL ADQUIRIENTE</th>
          <th width="5%">CODIGO</th>
          <th width="5%">VALOR</th>
          <th width="7%">IGV</th>
          <th width="7%">IMPORTE</th>

<?php
if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
?>

          <th width="80"><?php echo $DatProducto->ProCodigoOriginal;?></th>
<?php	
	}
}
?>
          
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
		
        foreach($ArrFacturaDetalles as $DatFacturaDetalle){
			
			//
//			$DatFacturaDetalle->FdeValorVenta = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFacturaDetalle->FdeValorVenta:($DatFacturaDetalle->FdeValorVenta/$DatFacturaDetalle->FacTipoCambio));
//			$DatFacturaDetalle->FdeImpuesto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFacturaDetalle->FdeImpuesto:($DatFacturaDetalle->FdeImpuesto/$DatFacturaDetalle->FacTipoCambio));
//			$DatFacturaDetalle->FdeImporte = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFacturaDetalle->FdeImporte:($DatFacturaDetalle->FdeImporte/$DatFacturaDetalle->FacTipoCambio));
//			
			/*$DatFacturaDetalle->FdeValorVenta = round($DatFacturaDetalle->FdeValorVenta,2);
			$DatFacturaDetalle->FdeImpuesto = round($DatFacturaDetalle->FdeImpuesto,2);
			$DatFacturaDetalle->FdeImporte = round($DatFacturaDetalle->FdeImporte,2);*/
			
			
			$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta/(empty($DatFacturaDetalle->FacTipoCambio)?1:$DatFacturaDetalle->FacTipoCambio));
			$DatFacturaDetalle->FdeImpuesto = ($DatFacturaDetalle->FdeImpuesto/(empty($DatFacturaDetalle->FacTipoCambio)?1:$DatFacturaDetalle->FacTipoCambio));
			$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte/(empty($DatFacturaDetalle->FacTipoCambio)?1:$DatFacturaDetalle->FacTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatFacturaDetalle->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatFacturaDetalle->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatFacturaDetalle->FacFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			if(!empty($DatFacturaDetalle->FacTipoCambioAux)){
				$TipoCambio = $DatFacturaDetalle->FacTipoCambioAux;
			}
			
			
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFacturaDetalle->FacFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >01</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFacturaDetalle->FtaNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFacturaDetalle->FacId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFacturaDetalle->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" > <?php echo $DatFacturaDetalle->CliApellidoPaterno;  ?> <?php echo $DatFacturaDetalle->CliApellidoMaterno;  ?> <?php echo $DatFacturaDetalle->CliNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatFacturaDetalle->FdeCodigo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
			<?php
			if($DatFacturaDetalle->MonId<>$EmpresaMonedaId){
			?>
            
				<?php
                if(!empty($TipoCambio)){
                ?>
                 
                    <?php $DatFacturaDetalle->NddValorVenta = ($DatFacturaDetalle->NddValorVenta*$TipoCambio);?>
              
                <?php	
                }else{

					$DatFacturaDetalle->NddValorVenta = 0;

                ?>
                    
                    No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatFacturaDetalle->FacFechaEmision;?>)
                    
                <?php	
                }
                ?>
        
			<?php	
			}
            ?>
		 
          <?php echo number_format($DatFacturaDetalle->FdeValorVenta,2);?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		      <?php
			if($DatFacturaDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php $DatFacturaDetalle->FdeImpuesto = ($DatFacturaDetalle->FdeImpuesto*$TipoCambio);?>
              
          
            <?php	
			}else{
				
				$DatFacturaDetalle->FdeImpuesto = 0;
			?>
            
				No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatFacturaDetalle->FacFechaEmision;?>)
                
            <?php	
			}
			?>
        
        <?php	
			}
		  ?>
          
          
		  <?php echo number_format($DatFacturaDetalle->FdeImpuesto,2);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		    
          <?php
			if($DatFacturaDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php $DatFacturaDetalle->FdeImporte =  ($DatFacturaDetalle->FdeImporte*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatFacturaDetalle->FdeImporte = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatFacturaDetalle->FacFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php echo number_format($DatFacturaDetalle->FdeImporte,2);?></td>
          
                   <?php
if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
?>
 
 
 <td width="80" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
 
 
<?php

$DatProducto->ProCodigoOriginal = trim($DatProducto->ProCodigoOriginal);
$DatFacturaDetalle->FdeCodigo = trim($DatFacturaDetalle->FdeCodigo);

if($DatProducto->ProCodigoOriginal == $DatFacturaDetalle->FdeCodigo ){
?>
	  <?php echo number_format($DatFacturaDetalle->FdeCantidad,2);?>
<?php
}
?>
 
 
 
 </td>
          
<?php
	}
}
?>
          
          </tr>
        <?php	
			
			$FacturaSubTotal += round($DatFacturaDetalle->FdeValorVenta,2);
			$FacturaImpuesto += round($DatFacturaDetalle->FdeImpuesto,2);
			$FacturaTotal += round($DatFacturaDetalle->FdeImporte,2);
			
			
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
		
        foreach($ArrBoletaDetalles as $DatBoletaDetalle){
			
			 
				
			//$DatBoletaDetalle->BdeValorVenta = round($DatBoletaDetalle->BdeValorVenta,2);
//			$DatBoletaDetalle->BdeImpuesto = round($DatBoletaDetalle->BdeImpuesto,2);
//			$DatBoletaDetalle->BdeImporte = round($DatBoletaDetalle->BdeImporte,2);

			$DatBoletaDetalle->BdeValorVenta = ($DatBoletaDetalle->BdeValorVenta/(empty($DatBoletaDetalle->BolTipoCambio)?1:$DatBoletaDetalle->BolTipoCambio));
			$DatBoletaDetalle->BdeImpuesto = ($DatBoletaDetalle->BdeImpuesto/(empty($DatBoletaDetalle->BolTipoCambio)?1:$DatBoletaDetalle->BolTipoCambio));
			$DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte/(empty($DatBoletaDetalle->BolTipoCambio)?1:$DatBoletaDetalle->BolTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatBoletaDetalle->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatBoletaDetalle->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatBoletaDetalle->BolFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			
			if(!empty($DatBoletaDetalle->BolTipoCambioAux)){
				$TipoCambio = $DatBoletaDetalle->BolTipoCambioAux;
			}
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoletaDetalle->BolFechaEmision;  ?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>">03</td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoletaDetalle->BtaNumero;  ?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoletaDetalle->BolId;  ?></td>
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><?php echo $DatBoletaDetalle->CliNumeroDocumento;  ?>
          </td>
          
          
          <td width="10%" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"><span class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"> <?php echo $DatBoletaDetalle->CliApellidoPaterno;  ?> <?php echo $DatBoletaDetalle->CliApellidoMaterno;  ?> <?php echo $DatBoletaDetalle->CliNombre;  ?></span></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatBoletaDetalle->BdeCodigo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		  
		  
          
          <?php
			if($DatBoletaDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php $DatBoletaDetalle->BdeValorVenta =  ($DatBoletaDetalle->BdeValorVenta*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatBoletaDetalle->BdeValorVenta = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatBoletaDetalle->BolFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
          
          
		  <?php echo number_format($DatBoletaDetalle->BdeValorVenta,2);?>
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
          
          
		  
		  
		      <?php
			if($DatBoletaDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php  $DatBoletaDetalle->BdeImpuesto = ($DatBoletaDetalle->BdeImpuesto*$TipoCambio);?>
          
            <?php	
			}else{
				
					$DatBoletaDetalle->BdeImpuesto = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatBoletaDetalle->BolFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
		  
		  <?php echo number_format($DatBoletaDetalle->BdeImpuesto,2);?>
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		
        
		<?php
		
			if($DatBoletaDetalle->MonId<>$EmpresaMonedaId){
			
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
             <?php $DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatBoletaDetalle->BdeImporte = 0;
				
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatBoletaDetalle->BolFechaEmision;?>)
            <?php	
			}
			?>
        
		<?php	
        	}
        ?>
        
		  
		  <?php echo number_format($DatBoletaDetalle->BdeImporte,2);?>
          
          
          </td>
         
          <?php
if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
?>
 <td width="80" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >
 
 
 
  
<?php

$DatProducto->ProCodigoOriginal = trim($DatProducto->ProCodigoOriginal);
$DatBoletaDetalle->BdeCodigo = trim($DatBoletaDetalle->BdeCodigo);

if($DatProducto->ProCodigoOriginal == $DatBoletaDetalle->BdeCodigo ){
?>
	  <?php echo number_format($DatBoletaDetalle->BdeCantidad,2);?>
<?php
}
?>
 
 
 
 
 </td>
          
<?php
	}
}
?>
          </tr>
        <?php	
			
			$BoletaSubTotal += round($DatBoletaDetalle->BdeValorVenta,2);
			$BoletaImpuesto += round($DatBoletaDetalle->BdeImpuesto,2);
			$BoletaTotal += round($DatBoletaDetalle->BdeImporte,2);
			
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
		
        foreach($ArrNotaCreditoDetalles as $DatNotaCreditoDetalle){
			
 	
			//$DatNotaCreditoDetalle->NcdImporte = round($DatNotaCreditoDetalle->NcdImporte,2);
//			$DatNotaCreditoDetalle->NcdValorVenta = round($DatNotaCreditoDetalle->NcdValorVenta,2);
//			$DatNotaCreditoDetalle->NcdImpuesto = round($DatNotaCreditoDetalle->NcdImpuesto,2);
//			
			
			$DatNotaCreditoDetalle->NcdValorVenta = ($DatNotaCreditoDetalle->NcdValorVenta/(empty($DatNotaCreditoDetalle->NcrTipoCambio)?1:$DatNotaCreditoDetalle->NcrTipoCambio));
			$DatNotaCreditoDetalle->NcdImpuesto = ($DatNotaCreditoDetalle->NcdImpuesto/(empty($DatNotaCreditoDetalle->NcrTipoCambio)?1:$DatNotaCreditoDetalle->NcrTipoCambio));
			$DatNotaCreditoDetalle->NcdImporte = ($DatNotaCreditoDetalle->NcdImporte/(empty($DatNotaCreditoDetalle->NcrTipoCambio)?1:$DatNotaCreditoDetalle->NcrTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatNotaCreditoDetalle->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatNotaCreditoDetalle->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaCreditoDetalle->NcrFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			
			
			if(!empty($DatNotaCreditoDetalle->NcrTipoCambioAux)){
				$TipoCambio = $DatNotaCreditoDetalle->NcrTipoCambioAux;
			}
			
			
			$DatNotaCreditoDetalle->NcdImporte = ($DatNotaCreditoDetalle->NcdImporte*-1);
			$DatNotaCreditoDetalle->NcdValorVenta = ($DatNotaCreditoDetalle->NcdValorVenta*-1);
			$DatNotaCreditoDetalle->NcdImpuesto = ($DatNotaCreditoDetalle->NcdImpuesto*-1);
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCreditoDetalle->NcrFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >07</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCreditoDetalle->NctNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCreditoDetalle->NcrId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCreditoDetalle->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		  <?php echo $DatNotaCreditoDetalle->CliApellidoPaterno;  ?>  <?php echo $DatNotaCreditoDetalle->CliApellidoMaterno;  ?>  <?php echo $DatNotaCreditoDetalle->CliNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaCreditoDetalle->NcdCodigo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          
          <?php
			if($DatNotaCreditoDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>

				<?php  $DatNotaCreditoDetalle->NcdValorVenta = ($DatNotaCreditoDetalle->NcdValorVenta*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatNotaCreditoDetalle->NcdValorVenta = 0;
				
			?>
				No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaCreditoDetalle->NcrFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php echo number_format($DatNotaCreditoDetalle->NcdValorVenta,2);?>
          
          
          
          
          
          
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php
			if($DatNotaCreditoDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php  $DatNotaCreditoDetalle->NcdImpuesto = ($DatNotaCreditoDetalle->NcdImpuesto*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatNotaCreditoDetalle->NcdImpuesto = 0;
				
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaCreditoDetalle->NcrFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php echo number_format($DatNotaCreditoDetalle->NcdImpuesto,2);?>
          
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
          
          <?php
			if($DatNotaCreditoDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
             <?php $DatNotaCreditoDetalle->NcdImporte = ($DatNotaCreditoDetalle->NcdImporte*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatNotaCreditoDetalle->NcdImporte = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaCreditoDetalle->NcrFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		
		  <?php echo number_format($DatNotaCreditoDetalle->NcdImporte,2);?>
          
         
          
          </td>
          
                   <?php
if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
?>
 <td width="80" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php

$DatProducto->ProCodigoOriginal = trim($DatProducto->ProCodigoOriginal);
$DatNotaCreditoDetalle->NcdCodigo = trim($DatNotaCreditoDetalle->NcdCodigo);

if($DatProducto->ProCodigoOriginal == $DatNotaCreditoDetalle->NcdCodigo ){
?>
   <?php echo number_format($DatNotaCreditoDetalle->NcdCantidad,2);?>
   <?php
}
?></td>
          
<?php
	}
}
?>
          
          </tr>
        <?php	
			
			$NotaCreditoSubTotal += round($DatNotaCreditoDetalle->NcdValorVenta,2);
			$NotaCreditoImpuesto += round($DatNotaCreditoDetalle->NcdImpuesto,2);
			$NotaCreditoTotal += round($DatNotaCreditoDetalle->NcdImporte,2);
			
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
		
        foreach($ArrNotaDebitoDetalles as $DatNotaDebitoDetalle){
			
 	
			//$DatNotaDebitoDetalle->NddImporte = round($DatNotaDebitoDetalle->NddImporte,2);
//			$DatNotaDebitoDetalle->NddValorVenta = round($DatNotaDebitoDetalle->NddValorVenta,2);
//			$DatNotaDebitoDetalle->NddImpuesto = round($DatNotaDebitoDetalle->NddImpuesto,2);
//			
			
			$DatNotaDebitoDetalle->NddValorVenta = ($DatNotaDebitoDetalle->NddValorVenta/(empty($DatNotaDebitoDetalle->NdbTipoCambio)?1:$DatNotaDebitoDetalle->NdbTipoCambio));
			$DatNotaDebitoDetalle->NddImpuesto = ($DatNotaDebitoDetalle->NddImpuesto/(empty($DatNotaDebitoDetalle->NdbTipoCambio)?1:$DatNotaDebitoDetalle->NdbTipoCambio));
			$DatNotaDebitoDetalle->NddImporte = ($DatNotaDebitoDetalle->NddImporte/(empty($DatNotaDebitoDetalle->NdbTipoCambio)?1:$DatNotaDebitoDetalle->NdbTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatNotaDebitoDetalle->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatNotaDebitoDetalle->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaDebitoDetalle->NdbFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			
			
			if(!empty($DatNotaDebitoDetalle->NdbTipoCambioAux)){
				$TipoCambio = $DatNotaDebitoDetalle->NdbTipoCambioAux;
			}
			
		//	
//			$DatNotaDebitoDetalle->NddImporte = ($DatNotaDebitoDetalle->NddImporte*-1);
//			$DatNotaDebitoDetalle->NddValorVenta = ($DatNotaDebitoDetalle->NddValorVenta*-1);
//			$DatNotaDebitoDetalle->NddImpuesto = ($DatNotaDebitoDetalle->NddImpuesto*-1);
//			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebitoDetalle->NdbFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >08</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebitoDetalle->NdtNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebitoDetalle->NdbId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebitoDetalle->CliNumeroDocumento;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
		  <?php echo $DatNotaDebitoDetalle->CliApellidoPaterno;  ?>  <?php echo $DatNotaDebitoDetalle->CliApellidoMaterno;  ?>  <?php echo $DatNotaDebitoDetalle->CliNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatNotaDebitoDetalle->NdbCodigo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          
          <?php
			if($DatNotaDebitoDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
             <?php  $DatNotaDebitoDetalle->NddValorVenta = ($DatNotaDebitoDetalle->NddValorVenta*$TipoCambio);?>
          
            <?php	
			}else{
				
				 $DatNotaDebitoDetalle->NddValorVenta = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaDebitoDetalle->NdbFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php  echo number_format($DatNotaDebitoDetalle->NddValorVenta,2);?>
          
          
          
          
          
          
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php
			if($DatNotaDebitoDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
             <?php  $DatNotaDebitoDetalle->NddImpuesto = ($DatNotaDebitoDetalle->NddImpuesto*$TipoCambio);?>
          
            <?php	
			}else{
				
					$DatNotaDebitoDetalle->NddImpuesto = 0;
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaDebitoDetalle->NdbFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php echo number_format($DatNotaDebitoDetalle->NddImpuesto,2);?>
          
          
          
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  
          
          <?php
			if($DatNotaDebitoDetalle->MonId<>$EmpresaMonedaId){
		?>
        	<?php
			if(!empty($TipoCambio)){
			?>
            
             <?php  $DatNotaDebitoDetalle->NddImporte = ($DatNotaDebitoDetalle->NddImporte*$TipoCambio);?>
          
            <?php	
			}else{
				
				$DatNotaDebitoDetalle->NddImporte = 0;
				
			?>
            No se encontro Tipo de Cambio <?php die("Error de Tipo de Cambio");?> (<?php echo $DatNotaDebitoDetalle->NdbFechaEmision;?>)
            <?php	
			}
			?>
        
        <?php	
				
			}
		  ?>
          
		  <?php echo number_format($DatNotaDebitoDetalle->NddImporte,2);?>
          
          </td>
          
                   <?php
if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
?>
 <td width="80" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" ><?php

$DatProducto->ProCodigoOriginal = trim($DatProducto->ProCodigoOriginal);
$DatNotaDebitoDetalle->NddCodigo = trim($DatNotaDebitoDetalle->NddCodigo);

if($DatProducto->ProCodigoOriginal == $DatNotaDebitoDetalle->NddCodigo ){
?>
   <?php echo number_format($DatNotaDebitoDetalle->NddCantidad,2);?>
   <?php
}
?></td>
          
<?php
	}
}
?>
          
          </tr>
        <?php	
			
			$NotaDebitoSubTotal += round($DatNotaDebitoDetalle->NddValorVenta,2);
			$NotaDebitoImpuesto += round($DatNotaDebitoDetalle->NddImpuesto,2);
			$NotaDebitoTotal += round($DatNotaDebitoDetalle->NddImporte,2);
			
			$NotaDebitoAmortizadoTotal += $ClientePagoMontoTotal;
			$NotaDebitoSaldoTotal += $NotaDebitoSaldo;
			
		$c++;
        }
        ?>
        
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
       
        
</body>
</html>