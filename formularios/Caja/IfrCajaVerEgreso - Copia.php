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
$POST_FormaPago = ($_GET['FormaPago']);
$POST_Sucursal = ($_GET['Sucursal']);
$POST_IncluirSaldoInicial = ($_GET['IncluirSaldoInicial']);

$POST_Origen = ("REPUESTOS");
$POST_Origen = ("");


require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngreso.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

?>


<?php
$InsDesembolso = new ClsDesembolso();
//MtdObtenerDesembolsos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DesId',$oSentido = 'Desc',$oDesinacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="DesFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL,$oFormaPago=NULL) {
$ResDesembolso = $InsDesembolso->MtdObtenerDesembolsos(NULL,NULL,NULL,"DesFecha","DESC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"DesFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal,$POST_FormaPago);
$ArrDesembolsos = $ResDesembolso['Datos'];
?>

<?php
$InsIngreso = new ClsIngreso();
//MtdObtenerIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'IngId',$oSentido = 'Ingc',$oInginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="IngFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL,$oFormaPago=NULL,$oTipo=NULL) 
$ResIngreso = $InsIngreso->MtdObtenerIngresos(NULL,NULL,NULL,"IngFecha","DESC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"IngFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal,$POST_FormaPago,1);
$ArrIngresos = $ResIngreso['Datos'];
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
  <td width="54%" rowspan="2" align="center" valign="top">RESUMEN DE EGRESOS</td>
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

                  
<?php
if($POST_IncluirSaldoInicial=="1"){
?>

                    <tr>
                      <td width="27%" align="left" valign="top"><span class="EstFormularioSubTitulo">SALDOS INICIALES</span></td>
                    </tr>
<?php
}
?>          
                    
                    <tr>
                      <td align="left" valign="top">
                        
                        
                        
                        
                        
  <?php
$TotalIngresos = 0;
$TotalEgresos = 0;
?>
                        
                         
                        
                        
                        
<?php
if($POST_IncluirSaldoInicial=="1"){
?>

       
                            
      <?php
    $TotalOtrosIngresos = 0;
    
    
    ?>
                            Otros Ingresos
                            
                            <table width="100%" border="0" cellpadding="1" cellspacing="2" class="EstTablaListado">
                              <thead class="EstTablaListadoHead">
                                <tr>
                                  <th width="2%">#
                                    
                                  </th>
                                  <th width="11%">F.P.</th>
                                  <th width="8%">Ref.</th>
                                  <th width="7%">Fecha</th>
                                  <th width="31%">Afectado</th>
                                  <th width="31%">Concepto</th>
                                  <th width="14%">Obs.</th>
                                  <th width="13%">Moneda</th>
                                  <th width="14%">Monto</th>
                                </tr>
                              </thead>
                              <tbody class="EstTablaListadoBody">
      <?php
    $i=1;
    if(!empty($ArrIngresos)){
        foreach($ArrIngresos as $DatIngreso){
            
            $DatIngreso->IngMonto = (($EmpresaMonedaId==$DatIngreso->MonId or empty($POST_Moneda))?$DatIngreso->IngMonto:($DatIngreso->IngMonto/$DatIngreso->IngTipoCambio));
    ?>
                                
                                <tr>
                                  <td>
                                    <?php echo $i;?>
                                  </td>
                                  <td><?php echo $DatIngreso->FpaNombre?></td>
                                  <td>
                                    
                                    
                                    
                                    <?php echo $DatIngreso->IngReferencia;?>
                                    
                                  </td>
                                  <td><?php echo $DatIngreso->IngFecha;?></td>
                                  <td>&nbsp;</td>
                                  <td> 
                                    <?php echo $DatIngreso->IngId;?> / 
                                    <?php echo $DatIngreso->IngConcepto;?> 
                                    
                                    <?php
               if(!empty($DatIngreso->FinId)){
            ?>
                                    / O.T.: <?php echo $DatIngreso->FinId;?> 
                                    
                                    <?php	   
               }
               ?>
                                    
                                    
                                    <?php
               if(!empty($DatIngreso->VdiId)){
            ?>
                                    / V.D.: <?php echo $DatIngreso->VdiId;?>
                                    
                                    <?php	   
               }
               ?>
                                    
                                    <?php
               if(!empty($DatIngreso->OvvId)){
            ?>
                                    / O.V.V.: <?php echo $DatIngreso->OvvId;?>
                                    
                                    <?php	   
               }
               ?>
                                    
                                    
                                    <?php
               if(!empty($DatIngreso->PerNombre)){
                ?>
                                    / Personal: <?php echo $DatIngreso->PerNombre;?>
                                    <?php echo $DatIngreso->PerApellidoPaterno;?>
                                    <?php echo $DatIngreso->PerApellidoMaterno;?> 
                                    <?php
               }
               ?>
                                    
                                    <?php
               if(!empty($DatIngreso->CliNombre)){
                ?>
                                    / Cliente: <?php echo $DatIngreso->CliNombre;?>
                                    <?php echo $DatIngreso->CliApellidoPaterno;?>
                                    <?php echo $DatIngreso->CliApellidoMaterno;?> 
                                    <?php
               }
               ?>
                                    
                                    
                                    <?php
               if(!empty($DatIngreso->PrvNombre)){
                ?>
                                    / Proveedor: <?php echo $DatIngreso->PrvNombre;?>
                                    <?php echo $DatIngreso->PrvApellidoPaterno;?>
                                    <?php echo $DatIngreso->PrvApellidoMaterno;?>
                                    <?php
               }
               ?>
                                    
                                    
                                    
                                    
                                    
                                  </td>
                                  <td align="right"><?php echo $DatIngreso->IngObservacionCaja;?></td>
                                  <td align="right"><?php echo $DatIngreso->MonSimbolo?></td>
                                  <td align="right"><?php echo number_format($DatIngreso->IngMonto,2)?></td>
                                </tr>
                                
                                
                                
      <?php	
            $TotalOtrosIngresos += $DatIngreso->IngMonto;
            $i++;
        }
        }
    ?>
                              </tbody>
                            </table>     
                            
                            <hr /> 
      <?php
    
    ?>
    
    
  <?php
}
?>                    
                          
                        
                        
                        
  <?php
//$TotalIngresos  = $TotalFacturas + $TotalBoletas + $TotalPagos;
$TotalIngresos  = $TotalOtrosIngresos + $TotalPagos;
?>                  
                        
                        
                        
                        
                        
                        
                        
                      </td>
                    </tr>
                    
                    
                    <?php
if($POST_IncluirSaldoInicial=="1"){
?>

                    <tr>
                      <td align="right">TOTAL SALDOS INICIALES: <?php echo number_format($TotalIngresos,2);?></td>
                    </tr>
<?php
}
?>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">EGRESOS</span></td>
                    </tr>
                    <tr>
                      <td align="left"><?php
/*$InsGasto = new ClsGasto();
//MtdObtenerGastos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GasId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFecha="GasFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL) {
$ResGasto = $InsGasto->MtdObtenerGastos(NULL,NULL,NULL,"GasFecha","DESC",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Moneda,"GasFecha",0,NULL,NULL,$POST_Sucursal);
$ArrGastos = $ResGasto['Datos'];*/
?>
                        <?php
/*$TotalGastos = 0;
if(!empty($ArrGastos)){
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
$TotalDesembolsos = 0;
?>
Desembolsos
<table width="100%" border="0" cellpadding="1" cellspacing="2" class="EstTablaListado">
  <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%"># </th>
      <th width="11%">F.P.</th>
      <th width="8%">Ref.</th>
      <th width="7%">Fecha</th>
      <th width="31%">Afectado</th>
      <th width="31%">Concepto</th>
      <th width="12%">Obs.</th>
      <th width="12%">Moneda</th>
      <th width="17%">Monto</th>
    </tr>
  </thead>
  <tbody class="EstTablaListadoBody">
    <?php
	$i=1;
	if(!empty($ArrDesembolsos)){
		foreach($ArrDesembolsos as $DatDesembolso){
		
			$DatDesembolso->DesMonto = (($EmpresaMonedaId==$DatDesembolso->MonId or empty($POST_Moneda))?$DatDesembolso->DesMonto:($DatDesembolso->DesMonto/$DatDesembolso->DesTipoCambio));
?>
    <tr>
      <td><?php echo $i;?></td>
      <td><?php echo $DatDesembolso->FpaNombre?></td>
      <td><?php echo $DatDesembolso->DesReferencia;?></td>
      <td><?php echo $DatDesembolso->DesFecha;?></td>
      <td>&nbsp;</td>
      <td><?php echo $DatDesembolso->DesId;?> / <?php echo $DatDesembolso->DesConcepto;?>
        <?php
		   if(!empty($DatDesembolso->FinId)){
		?>
        / O.T.: <?php echo $DatDesembolso->FinId;?>
        <?php	   
		   }
		   ?>
        <?php
		   if(!empty($DatDesembolso->VdiId)){
		?>
        / V.D.: <?php echo $DatDesembolso->VdiId;?>
        <?php	   
		   }
		   ?>
        <?php
		   if(!empty($DatDesembolso->OvvId)){
		?>
        / O.V.V.: <?php echo $DatDesembolso->OvvId;?>
        <?php	   
		   }
		   ?>
        <?php
		   if(!empty($DatDesembolso->PerNombre)){
			?>
        / Personal: <?php echo $DatDesembolso->PerNombre;?> <?php echo $DatDesembolso->PerApellidoPaterno;?> <?php echo $DatDesembolso->PerApellidoMaterno;?>
        <?php
		   }
		   ?>
        <?php
		   if(!empty($DatDesembolso->CliNombre)){
			?>
        / Cliente: <?php echo $DatDesembolso->CliNombre;?> <?php echo $DatDesembolso->CliApellidoPaterno;?> <?php echo $DatDesembolso->CliApellidoMaterno;?>
        <?php
		   }
		   ?>
        <?php
		   if(!empty($DatDesembolso->PrvNombre)){
			?>
        / Proveedor: <?php echo $DatDesembolso->PrvNombre;?> <?php echo $DatDesembolso->PrvApellidoPaterno;?> <?php echo $DatDesembolso->PrvApellidoMaterno;?>
        <?php
		   }
		   ?></td>
      <td align="right"><?php echo $DatDesembolso->DesObservacionCaja;?></td>
      <td align="right"><?php echo $DatPago->MonSimbolo?></td>
      <td align="right"><?php echo number_format($DatDesembolso->DesMonto,2)?></td>
    </tr>
    <?php	
			$TotalDesembolsos += $DatDesembolso->DesMonto;
			$i++;
		}
	}
?>
  </tbody>
</table>
<hr />
<?php

?>
<?php
//$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
//
////MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL,$oSucursal=NULL) {
//$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,"AmoFecha","ASC",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoFecha",0,0,NULL,NULL,NULL,2,NULL,$POST_Sucursal);
//$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];
?>
<?php
//$TotalCompras = 0;
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
//$TotalEgresos = $TotalGastos + $TotalDesembolsos + $TotalCompras;
$TotalEgresos = $TotalDesembolsos;
?></td>
                    </tr>
                    <tr>
                      <td align="right">TOTAL EGRESOS: <?php echo number_format($TotalEgresos,2);?></td>
                    </tr>
                    <tr>
                    <td align="right">
                    
                    
<?php
if($POST_IncluirSaldoInicial=="1"){
?>

<?php
$Saldo = $TotalIngresos - $TotalEgresos;
?>
                    TOTAL SALDO: <?php echo number_format($Saldo,2);?>
                    
<?php
}
?>                    
                    
                    </td>
                    </tr>
        </table>



         

                             
  