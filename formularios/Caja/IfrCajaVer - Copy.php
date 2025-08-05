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

//if($_GET['P']==2){
//	header("Content-type: application/vnd.ms-excel");
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_KPI_".date('d-m-Y').".xls\";");
//}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_FechaInicio = empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio'];
$POST_FechaFin = empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin'];
$POST_Moneda = (empty($_GET['Moneda'])?$EmpresaMonedaId:$_GET['Moneda']);

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
?>

<?php
if($_GET['P']<>2 and !empty($_GET['P'])){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

<?php if($_GET['P']==1){?> 
<script type="text/javascript">

$().ready(function() {
	setTimeout("window.close();",2500);	
	window.print(); 
});

</script>
<?php }?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" rowspan="2" align="left" valign="top">
  
  
  <?php
        if(!empty($InsVehiculoMarca->VmaFoto)){
        ?>
    <img src="../../subidos/vehiculo_marca/<?php echo $InsVehiculoMarca->VmaFoto;?>" width="271" height="92" />
    <?php
        }else{
        ?>
-
<?php	
        }
        ?></td>
  <td width="54%" rowspan="2" align="center" valign="top">CAJA DIARIA</td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
<tr>
  <td align="right" valign="top">A&ntilde;o: <?php echo $POST_Ano;?></td>
</tr>
</table>

<hr class="EstReporteLinea">

<?php }?>
                

                     
  
                    


<table class="EstTablaReporte" width="100%">
                    <tr>
                      <td width="27%" align="center" valign="top"><span class="EstFormularioSubTitulo">INGRESOS</span></td>
                      <td width="27%" align="center" valign="top"><span class="EstFormularioSubTitulo">EGRESOS</span></td>
                    </tr>
                    <tr>
                      <td align="center" valign="top">
           
           
           
           
          
<?php
$TotalIngresos = 0;
$TotalEgresos = 0;
?>
        
                      
<?php

$InsFactura = new ClsFactura();
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","ASC",NULL,$_SESSION['SisSucId'],5,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,NULL,"NPA-10000",NULL,$POST_Moneda);
$ArrFacturas = $ResFactura['Datos'];
?>

<?php
if(!empty($ArrFacturas)){
?>
Facturas
 
           <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
           <thead class="EstTablaListadoHead">
            <tr>
           <th width="8%">#
           
           </th>
           <th width="13%">Ref.</th>
           <th width="12%">Fecha</th>
           <th width="48%">Concepto</th>
           <th width="19%">Obs.</th>
           <th width="19%">Monto</th>
           </tr>
           </thead>
           <tbody class="EstTablaListadoBody">
<?php
$i=1;
$TotalFacturas = 0;
	foreach($ArrFacturas as $DatFactura){
		
		$DatFactura->FacTotal = (($EmpresaMonedaId==$DatFactura->MonId or empty($POST_Moneda))?$DatFactura->FacTotal:($DatFactura->FacTotal/$DatFactura->FacTipoCambio));
?>

 <tr>
           <td>
           <?php echo $i;?>
           </td>
           <td><?php 	echo $DatFactura->FtaNumero;?> - <?php echo $DatFactura->FacId?></td>
           <td><?php echo $DatFactura->FacFechaEmision?></td>
           <td>Comprobantes / O.T.: <?php echo $DatFactura->FinId?> / V.D.: <?php echo $DatFactura->VdiId?></td>
           <td align="right"><?php echo $DatFactura->FacObsevacionCaja?></td>
           <td align="right"><?php echo number_format($DatFactura->FacTotal,2)?></td>
           </tr>
	
    
    
<?php
		$TotalFacturas += $DatFactura->FacTotal;
		$i++;
	}
	
?>
   </tbody>
          </table>   
          
          <hr />   
<?php
}
?>
      
  
  
  
  
              
<?php

$InsBoleta = new ClsBoleta();
$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,"BolFechaEmision","ASC",NULL,5,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,"NPA-10000",$POST_Moneda,NULL,NULL);
$ArrBoletas = $ResBoleta['Datos'];


?>

<?php
if(!empty($ArrBoletas)){
?>
Boletas
 
           <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
           <thead class="EstTablaListadoHead">
            <tr>
           <th width="8%">#
           
           </th>
           <th width="13%">Ref.</th>
           <th width="12%">Fecha</th>
           <th width="48%">Concepto</th>
           <th width="19%">Obs.</th>
           <th width="19%">Monto</th>
           </tr>
           </thead>
           <tbody class="EstTablaListadoBody">
<?php
$i=1;
$TotalBoletas = 0;

	foreach($ArrBoletas as $DatBoleta){
		
		$DatBoleta->BolTotal = (($EmpresaMonedaId==$DatBoleta->MonId or empty($POST_Moneda))?$DatBoleta->BolTotal:($DatBoleta->BolTotal/$DatBoleta->BolTipoCambio));
?>

 <tr>
           <td>
           <?php echo $i;?>
           </td>
           <td><?php 	echo $DatBoleta->BtaNumero;?> - <?php echo $DatBoleta->BolId?></td>
           <td><?php echo $DatBoleta->BolFechaEmision?></td>
           <td>Comprobantes / O.T.: <?php echo $DatBoleta->FinId?> / V.D.: <?php echo $DatBoleta->VdiId?></td>
           <td align="right"><?php echo $DatBoleta->BolObservacionCaja?></td>
           <td align="right"><?php echo number_format($DatBoleta->BolTotal,2)?></td>
           </tr>
	
    
    
<?php
		$TotalBoletas += $DatBoleta->BolTotal;
		$i++;
	}
	
?>
   </tbody>
 </table>    
          
     <hr />           
<?php
}
?>
   
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                     
              
<?php

$InsPago = new ClsPago();
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",NULL,NULL,$POST_Sucursal);
$ArrPagos = $ResPago['Datos'];

?>

<?php
$TotalPagos = 0;

if(!empty($ArrPagos)){
?>
Abonos de Clientes
 
           <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
           <thead class="EstTablaListadoHead">
            <tr>
           <th width="8%">#
           
           </th>
           <th width="13%">Ref.</th>
           <th width="12%">Fecha</th>
           <th width="48%">Concepto</th>
           <th width="19%">Obs.</th>
           <th width="19%">Monto</th>
           </tr>
           </thead>
           <tbody class="EstTablaListadoBody">
<?php
$i=1;


	foreach($ArrPagos as $DatPago){
		
		$DatPago->PagMonto = (($EmpresaMonedaId==$DatPago->MonId or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));

?>

			<tr>
           <td>
           <?php echo $i;?>
           </td>
           <td> <?php echo $DatPago->PagId?></td>
           <td><?php echo $DatPago->PagFecha?></td>
           <td>Abono de Clientes / V.D.: <?php echo $DatPago->VdiId?></td>
           <td align="right"><?php echo $DatPago->PagObservacionCaja?></td>
           <td align="right"><?php echo number_format($DatPago->PagMonto,2);?></td>
           </tr>
	
    
    
<?php
		$TotalPagos += $DatPago->PagMonto;
		$i++;
	}
	
?>
   </tbody>
 </table>    
          
               
<?php
}
?>
   
<?php
$TotalIngresos  = $TotalFacturas + $TotalBoletas + $TotalPagos;
?>                  
                      
                      
                      
                      
                      
                      
                      
                      </td>
                      <td align="center" valign="top">
                      
<?php

$InsGasto = new ClsGasto();
//MtdObtenerGastos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GasId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFecha="GasFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL) {
$ResGasto = $InsGasto->MtdObtenerGastos(NULL,NULL,NULL,"GasFecha","DESC",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Moneda,"GasFecha",0,NULL,NULL,$POST_Sucursal);
$ArrGastos = $ResGasto['Datos'];

?>

<?php
$TotalGastos = 0;
/*if(!empty($ArrGastos)){
?>
 Gastos
 
           <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
           <thead class="EstTablaListadoHead">
            <tr>
           <th width="8%">#
           
           </th>
           <th width="25%">Ref.</th>
           <th width="17%">Fecha</th>
           <th width="31%">Concepto</th>
           <th width="19%">Monto</th>
           </tr>
           </thead>
           <tbody class="EstTablaListadoBody">
<?php
$i=1;

	foreach($ArrGastos as $DatGasto){
		
		$DatGasto->GasTotal = (($EmpresaMonedaId==$DatGasto->MonId or empty($POST_Moneda))?$DatGasto->GasTotal:($DatGasto->GasTotal/$DatGasto->GasTipoCambio));
?>

 <tr>
           <td>
           <?php echo $i;?>
           </td>
           <td><?php echo $DatGasto->GasId?></td>
           <td><?php echo $DatGasto->GasFecha?></td>
           <td>
          
             
           
           Gastos <?php echo $DatGasto->GasConcepto?> / O.T.: <?php echo $DatGasto->FinId?> / V.D.: <?php echo $DatGasto->VdiId?> / O.V.V.: <?php echo $DatGasto->OvvId?> /
           
            
           <?php echo $DatGasto->PerNombre;?>
            <?php echo $DatGasto->PerApellidoPaterno;?>
             <?php echo $DatGasto->PerApellidoMaterno;?> /
             
              <?php echo $DatGasto->CliNombre;?>
            <?php echo $DatGasto->CliApellidoPaterno;?>
             <?php echo $DatGasto->CliApellidoMaterno;?> /
           
           
            <?php echo $DatGasto->PrvNombre;?>
            <?php echo $DatGasto->PrvApellidoPaterno;?>
             <?php echo $DatGasto->PrvApellidoMaterno;?> /
           
           
           </td>
           <td><?php echo number_format($DatGasto->GasTotal,2)?></td>
           </tr>
	
    
    
<?php	
		$TotalGastos += $DatPago->GasTotal;
		$i++;
	}
	
?>
   </tbody>
          </table>     
          
          <hr /> 
<?php
}*/
?>
      

  
  
  
<?php
$InsDesembolso = new ClsDesembolso();
//MtdObtenerDesembolsos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DesId',$oSentido = 'Desc',$oDesinacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="DesFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL) {
$ResDesembolso = $InsDesembolso->MtdObtenerDesembolsos(NULL,NULL,NULL,"DesFecha","DESC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"DesFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal);
$ArrDesembolsos = $ResDesembolso['Datos'];

?>
  
<?php
$TotalDesembolsos = 0;

if(!empty($ArrDesembolsos)){
?>
Desembolsos
 
           <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
           <thead class="EstTablaListadoHead">
            <tr>
           <th width="8%">#
           
           </th>
           <th width="13%">Ref.</th>
           <th width="12%">Fecha</th>
           <th width="48%">Concepto</th>
           <th width="19%">Obs.</th>
           <th width="19%">Monto</th>
           </tr>
           </thead>
           <tbody class="EstTablaListadoBody">
<?php
$i=1;

	foreach($ArrDesembolsos as $DatDesembolso){
		
		$DatDesembolso->DesMonto = (($EmpresaMonedaId==$DatDesembolso->MonId or empty($POST_Moneda))?$DatDesembolso->DesMonto:($DatDesembolso->DesMonto/$DatDesembolso->DesTipoCambio));
?>

 <tr>
           <td>
           <?php echo $i;?>
           </td>
           <td><?php echo $DatDesembolso->DesId;?></td>
           <td><?php echo $DatDesembolso->DesFecha;?></td>
           <td> <?php echo $DatDesembolso->DesConcepto;?>/ O.T.: <?php echo $DatDesembolso->FinId;?> / V.D.: <?php echo $DatDesembolso->VdiId;?> / O.V.V.: <?php echo $DatDesembolso->OvvId;?>
           
             <?php echo $DatDesembolso->PerNombre;?>
            <?php echo $DatDesembolso->PerApellidoPaterno;?>
             <?php echo $DatDesembolso->PerApellidoMaterno;?> /
             
              <?php echo $DatDesembolso->CliNombre;?>
            <?php echo $DatDesembolso->CliApellidoPaterno;?>
             <?php echo $DatDesembolso->CliApellidoMaterno;?> /
           
           
            <?php echo $DatDesembolso->PrvNombre;?>
            <?php echo $DatDesembolso->PrvApellidoPaterno;?>
             <?php echo $DatDesembolso->PrvApellidoMaterno;?> /
           
           
           
           </td>
           <td align="right"><?php echo $DatDesembolso->DesObservacionCaja;?></td>
           <td align="right"><?php echo number_format($DatDesembolso->DesMonto,2)?></td>
           </tr>
	
    
    
<?php	
		$TotalDesembolsos += $DatDesembolso->DesMonto;
		$i++;
	}
	
?>
   </tbody>
          </table>     
          
          <hr /> 
<?php
}
?>
      
      
      
<?php
$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();

//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL,$oSucursal=NULL) {
$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,"AmoFecha","ASC",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoFecha",0,0,NULL,NULL,NULL,2,NULL,$POST_Sucursal);
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];
?> 
     

  
<?php
$TotalCompras = 0;
/*
if(!empty($ArrAlmacenMovimientoEntradas)){
?>
Compras
 
           <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
           <thead class="EstTablaListadoHead">
            <tr>
           <th width="8%">#
           
           </th>
           <th width="25%">Ref.</th>
           <th width="17%">Fecha</th>
           <th width="31%">Concepto</th>
           <th width="19%">Monto</th>
           </tr>
           </thead>
           <tbody class="EstTablaListadoBody">
<?php
$i=1;

	foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){
		
		$DatAlmacenMovimientoEntrada->AmoTotal = (($EmpresaMonedaId==$DatAlmacenMovimientoEntrada->MonId or empty($POST_Moneda))?$DatAlmacenMovimientoEntrada->AmoTotal:($DatAlmacenMovimientoEntrada->AmoTotal/$DatAlmacenMovimientoEntrada->AmoTipoCambio));
?>

 <tr>
           <td>
           <?php echo $i;?>
           </td>
           <td><?php echo $DatAlmacenMovimientoEntrada->AmoComprobanteNumero; ?></td>
           <td><?php echo $DatAlmacenMovimientoEntrada->AmoFecha;?></td>
           <td>
           
           
           Compras <?php echo $DatAlmacenMovimientoEntrada->AmoId; ?> / O.T.: <?php echo $DatAlmacenMovimientoEntrada->FinId;?> / V.D.: <?php echo $DatAlmacenMovimientoEntrada->VdiId;?> / O.V.V.: <?php echo $DatAlmacenMovimientoEntrada->OvvId;?>
           
           / 
		   
		   <?php echo $DatAlmacenMovimientoEntrada->PrvNombre;?>
           <?php echo $DatAlmacenMovimientoEntrada->PrvApellidoPaterno;?>
           <?php echo $DatAlmacenMovimientoEntrada->PrvApellidoMaterno;?>
           
           </td>
           <td><?php echo number_format($DatAlmacenMovimientoEntrada->AmoTotal,2)?></td>
           </tr>
	
    
    
<?php	
		$TotalCompras += $DatAlmacenMovimientoEntrada->AmoTotal;
		$i++;
	}
	
?>
   </tbody>
          </table>     
          
          <hr /> 
<?php
}*/
?>
      
      
      
      
      
      
      
  <?php
  $TotalEgresos = $TotalGastos + $TotalDesembolsos + $TotalCompras;
  ?>
    
  
  
  </td>
                    </tr>
                    <tr>
                      <td>TOTAL INGRESOS: <?php echo number_format($TotalIngresos,2);?></td>
                      <td>TOTAL EGRESOS: <?php echo number_format($TotalEgresos,2);?></td>
                    </tr>
                    <tr>
                    <td colspan="2" align="center">
                    
<?php
$Saldo = $TotalIngresos - $TotalEgresos;
?>
                    SALDO: <?php echo number_format($Saldo,2);?></td>
                    </tr>
        </table>



         

                             
  