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
$POST_Area = ("ARE-10010");
//$POST_Origen = ("REPUESTOS");
$POST_Origen = ("");


require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngreso.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

?>


<?php
$InsPago = new ClsPago();
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0)
$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","1000","3",NULL,NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"ARE-10010",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal,NULL,NULL,"FAC");
$ArrPagoFacturas = $ResPago['Datos'];

$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","1000","3",NULL,NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"ARE-10010",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal,NULL,NULL,"BOL");
$ArrPagoBoletas = $ResPago['Datos'];


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","1000","3",NULL,NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"ARE-10010",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal,NULL,NULL,"VDI");
$ArrPagoVentaDirectas = $ResPago['Datos'];


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","1000","3",NULL,NULL,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"ARE-10010",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",$POST_Origen,$POST_FormaPago,$POST_Sucursal,NULL,NULL,"OVV");
$ArrPagoOrdenVentaVehiculos = $ResPago['Datos'];


?>


<?php
$InsIngreso = new ClsIngreso();
//MtdObtenerIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'IngId',$oSentido = 'Ingc',$oInginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="IngFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL,$oFormaPago=NULL) 
$ResIngreso = $InsIngreso->MtdObtenerIngresos(NULL,NULL,NULL,"IngFecha","DESC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"IngFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal,$POST_FormaPago,5);
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
  <td width="54%" rowspan="2" align="center" valign="top">RESUMEN DE INGRESOS A CAJA</td>
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
                      <td width="27%" align="left" valign="top"></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top">
                   
                        
  <?php
$TotalIngresos = 0;

?>
                        
                 
                    
                    
<?php
$TotalPagoFacturas = 0;
$TotalPagoBoletas = 0;
$TotalPagoVentaDirectas = 0;
$TotalPagoOrdenVentaVehiculos = 0;

$TotalOtrosIngresos = 0;

?>


<?php
                
                
                if(!empty($ArrPagoFacturas)){
				?>
                
                
<span class="EstFormularioSubTitulo">FACTURAS</span>
                    
                        
                        <table width="100%" border="0" cellpadding="1" cellspacing="2" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="2%">#
                                
                              </th>
                              <th width="6%">F.P.</th>
                              <th width="6%">Doc. Ref.</th>
                              <th width="7%">Fecha</th>
                              <th width="21%">Ref.</th>
                              <th width="25%">Concepto</th>
                              <th width="5%">No. Transaccion</th>
                              <th width="5%">Fec. Transaccion</th>
                              <th width="6%">Det. Transaccion</th>
                              <th width="2%">Moneda</th>
                              <th width="5%">Monto</th>
                              <th width="9%">Obs.</th>
                              <th width="9%">Abonos Relacionados</th>
                            </tr>
                          </thead>
                          <tbody class="EstTablaListadoBody">
				
                
                <?php	
					$i=1;
                    foreach($ArrPagoFacturas as $DatPagoFactura){
                        
                        $DatPagoFactura->PagMonto = (($EmpresaMonedaId==$DatPagoFactura->MonId or empty($POST_Moneda))?$DatPagoFactura->PagMonto:($DatPagoFactura->PagMonto/$DatPagoFactura->PagTipoCambio));
                
				
				
						$ArrPagos2 = array();
						$ArrPagos3 = array();
						$ArrPagos4 = array();
						

						$VentaDirectaId = "";
						$OrdenVentaVehiculoId = "";
			
					
							$InsPago2 = new ClsPago();
							$ResPago2 = $InsPago2->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",NULL,NULL,NULL,NULL,$DatPagoFactura->FacId,$DatPagoFactura->FtaId);
							$ArrPagos2 = $ResPago2['Datos'];
							
							
							$InsFactura = new ClsFactura();
							$InsFactura->FacId = $DatPagoFactura->FacId;	
							$InsFactura->FtaId = $DatPagoFactura->FtaId;
							$InsFactura->MtdObtenerFactura(false);
							
							if(!empty($InsFactura->VdiId)){
								$VentaDirectaId = $InsFactura->VdiId;
							}
							
							if(!empty($InsFactura->OvvId)){
								$OrdenVentaVehiculoId = $InsFactura->OvvId;
							}
						
					
						
						if(!empty($VentaDirectaId)){
						
							$InsPago3 = new ClsPago();
							//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
							$ResPago3 = $InsPago3->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",$VentaDirectaId,NULL,NULL,NULL);
							$ArrPagos3 = $ResPago3['Datos'];
						
						}
						
						if(!empty($OrdenVentaVehiculoId)){
						
							$InsPago4 = new ClsPago();
							$ResPago4 = $InsPago4->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",NULL,$OrdenVentaVehiculoId,NULL,NULL);
							$ArrPagos4 = $ResPago4['Datos'];
						
						}
						
					
					
					
					
					
                ?>
                                            
                    
                    <tr>
                      <td>
                        <?php echo $i;?>
                      </td>
                      <td><?php echo $DatPagoFactura->FpaNombre?></td>
                      <td>
					  
					  
					 <!-- <?php echo $DatPagoFactura->PagNumeroRecibo?>-->
                       <?php echo $DatPagoFactura->FtaNumero;?> <?php echo $DatPagoFactura->FacId;?>
                       <?php echo $DatPagoFactura->BtaNumero;?> <?php echo $DatPagoFactura->BolId;?>
                      
                      </td>
                      <td><?php echo $DatPagoFactura->PagFecha?></td>
                      <td>
                      
Cliente:
  <?php
//MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPago=NULL)
$InsPagoComprobante = new ClsPagoComprobante();
$ResPagoComprobante = $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,'PacId','Desc',NULL,$DatPagoFactura->PagId);
$ArrPagoComprobantes = $ResPagoComprobante['Datos'];
?>

<?php
if(!empty($ArrPagoComprobantes)){
	foreach($ArrPagoComprobantes as $DatPagoComprobante){
?> 
		
		<?php		echo $DatPagoComprobante->CliNombre;?> 
		<?php		echo $DatPagoComprobante->CliApellidoPaterno;?>
        <?php		echo $DatPagoComprobante->CliApellidoMaterno;?>
        
        
<?php	
	}
}
?>

</td>
                      <td><?php echo $DatPagoFactura->PagId?>/<?php echo $DatPagoFactura->PagConcepto?></td>
                      <td><?php echo $DatPagoFactura->PagNumeroTransaccion?></td>
                      <td><?php echo $DatPagoFactura->PagFechaTransaccion?></td>
                      <td><?php echo $DatPagoFactura->BanNombre?> - <?php echo $DatPagoFactura->CueNumero?></td>
                      <td align="right"><?php echo $DatPagoFactura->MonSimbolo?></td>
                      <td align="right"><?php echo number_format($DatPagoFactura->PagMonto,2);?></td>
                      <td align="right"><?php echo $DatPagoFactura->PagObservacionCaja?></td>
                      <td align="left">
                      
                      
<?php


  							$OtrosAbonos = "";
                      
							if(!empty($ArrPagos2)){
								foreach($ArrPagos2 as $DatPago2){
									
									if( $DatPago2->FacId != $DatPagoFactura->FacId && $DatPago2->FtaId != $DatPagoFactura->FtaId ){
										
										 $DatPago2->PagMonto = (($EmpresaMonedaId==$DatPago2->MonId or empty($POST_Moneda))?$DatPago2->PagMonto:($DatPago2->PagMonto/$DatPago2->PagTipoCambio));
										
										//$Abono = "(2b)";
										$Abono = "";
										//
//										if(!empty($DatPago2->PagFechaTransaccion)){
//											$Abono .= " <b>Fec. Transac.:</b> ".$DatPago2->PagFechaTransaccion;
//										}
										
										if(!empty($DatPago2->PagNumeroTransaccion)){
											$Abono .= " <b>Num. Transac.:</b> ".$DatPago2->PagNumeroTransaccion;
										}
										 
										$OtrosAbonos .=  "<b>Fecha: </b>".$DatPago2->PagFecha." ".$Abono." <b>Monto: </b>".$DatPago2->MonSimbolo." ".number_format($DatPago2->PagMonto,2)." <br> ";
										
									}
									
									
								}
							}
							
                      
                        
                        
                        
                        if(!empty($ArrPagos3)){
                            foreach($ArrPagos3 as $DatPago3){
                                    
                                $DatPago3->PagMonto = (($EmpresaMonedaId==$DatPago3->MonId or empty($POST_Moneda))?$DatPago3->PagMonto:($DatPago3->PagMonto/$DatPago3->PagTipoCambio));
                                
                               // $Abono = "(3)";
								$Abono = "";
                                
                               // if(!empty($DatPago3->PagFechaTransaccion)){
//                                    $Abono .= " <b>Fec. Transac.:</b> ".$DatPago3->PagFechaTransaccion;
//                                }
                                
                                if(!empty($DatPago3->PagNumeroTransaccion)){
                                    $Abono .= " <b>Num. Transac.:</b> ".$DatPago3->PagNumeroTransaccion;
                                }
								
								
                                
                                $OtrosAbonos .=  "<b>Fecha: </b>".$DatPago3->PagFecha." ".$Abono." <b>Monto:</b> ".$DatPago3->MonSimbolo." ".number_format($DatPago3->PagMonto,2)." <br> ";
                                
                            }
                        }		
                        
                        
                        
                        if(!empty($ArrPagos4)){
                            foreach($ArrPagos4 as $DatPago4){
                                
                                $DatPago4->PagMonto = (($EmpresaMonedaId==$DatPago4->MonId or empty($POST_Moneda))?$DatPago4->PagMonto:($DatPago4->PagMonto/$DatPago4->PagTipoCambio));
                                
                                ///$Abono = "(4)";
								$Abono = "";
                                
                              //  if(!empty($DatPago4->PagFechaTransaccion)){
//                                    $Abono .= " <b>Fec. Transac.:</b> ".$DatPago4->PagFechaTransaccion;
//                                }
                                
                                if(!empty($DatPago4->PagNumeroTransaccion)){
                                    $Abono .= " <b>Num. Transac.:</b> ".$DatPago4->PagNumeroTransaccion;
                                }
                                
                                $OtrosAbonos .=  "<b>Fecha: </b>".$DatPago4->PagFecha." ".$Abono." <b>Monto:</b> ".$DatPago4->MonSimbolo." ".number_format($DatPago4->PagMonto,2)." <br> ";
                                
                            }
                        }		
?>						


						<?php echo $OtrosAbonos;?>
                      </td>
                    </tr>
                                          
                                            
                  <?php
                        $TotalPagoFacturas += $DatPagoFactura->PagMonto;
                        $i++;
                    }
?>
				

                
                
                <tr>
                      <td colspan="7" align="right">
                      
                      <span class="EstFormularioEtiqueta">
                      TOTAL FACTURAS:
                      </span>
                      </td>
                      <td align="right"><?php echo number_format($TotalPagoFacturas,2);?></td>
                      <td align="right">-</td>
                      <td align="right">&nbsp;</td>
                    </tr>
                    
                    
                          </tbody>
                        </table>    
                        
                    <hr />   
                        
                        
                        	<?php
                }
                ?>       
  <?php

?>
                        
                        
  
<?php
               
                
                if(!empty($ArrPagoBoletas)){
			?>


<span class="EstFormularioSubTitulo">BOLETAS</span>

                    
                        
                        <table width="100%" border="0" cellpadding="1" cellspacing="2" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="2%">#
                                
                              </th>
                              <th width="5%">F.P.</th>
                              <th width="7%">Doc. Ref.</th>
                              <th width="7%">Fecha</th>
                              <th width="21%">Ref.</th>
                              <th width="25%">Concepto</th>
                              <th width="5%">No. Transaccion</th>
                              <th width="5%">Fec. Transaccion</th>
                              <th width="6%">Det. Transaccion</th>
                              <th width="2%">Moneda</th>
                              <th width="5%">Monto</th>
                              <th width="9%">Obs.</th>
                              <th width="9%">Abonos Relacionados</th>
                            </tr>
                          </thead>
                          <tbody class="EstTablaListadoBody">
				
            
            <?php
			
					 $i=1;
                    foreach($ArrPagoBoletas as $DatPagoBoleta){
                        
                        $DatPagoBoleta->PagMonto = (($EmpresaMonedaId==$DatPagoBoleta->MonId or empty($POST_Moneda))?$DatPagoBoleta->PagMonto:($DatPagoBoleta->PagMonto/$DatPagoBoleta->PagTipoCambio));
                			
							
							
							
							
							$ArrPagos2 = array();
						$ArrPagos3 = array();
						$ArrPagos4 = array();
						
                     
						$VentaDirectaId = "";
						$OrdenVentaVehiculoId = "";
			
						
							$InsPago2 = new ClsPago();
							$ResPago2 = $InsPago2->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",NULL,NULL,NULL,NULL,NULL,NULL,$DatPagoBoleta->BolId,$DatPagoBoleta->BtaId);
							$ArrPagos2 = $ResPago2['Datos'];
							
							$InsBoleta = new ClsBoleta();
							$InsBoleta->BolId = $DatPagoBoleta->BolId;	
							$InsBoleta->BtaId = $DatPagoBoleta->BtaId;
							$InsBoleta->MtdObtenerBoleta(false);
							
							if(!empty($InsBoleta->VdiId)){
								$VentaDirectaId = $InsBoleta->VdiId;
							}
							
							if(!empty($InsBoleta->OvvId)){
								$OrdenVentaVehiculoId = $InsBoleta->OvvId;
							}
							
				
				
						
						if(!empty($VentaDirectaId)){
						
							$InsPago3 = new ClsPago();
							//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
							$ResPago3 = $InsPago3->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",$VentaDirectaId,NULL,NULL,NULL);
							$ArrPagos3 = $ResPago3['Datos'];
						
						}
						
						if(!empty($OrdenVentaVehiculoId)){
						
							$InsPago4 = new ClsPago();
							$ResPago4 = $InsPago4->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","100","3",NULL,$OrdenVentaVehiculoId,NULL,NULL);
							$ArrPagos4 = $ResPago4['Datos'];
						
						}
						
					
					
					
					
                ?>
                                            
                    <tr>
                      <td>
                        <?php echo $i;?>
                      </td>
                      <td><?php echo $DatPagoBoleta->FpaNombre?></td>
                      <td>
					  
					  
					 <!-- <?php echo $DatPagoBoleta->PagNumeroRecibo?>-->
                       <?php echo $DatPagoBoleta->FtaNumero;?> <?php echo $DatPagoBoleta->FacId;?>
                       <?php echo $DatPagoBoleta->BtaNumero;?> <?php echo $DatPagoBoleta->BolId;?>
                      
                      </td>
                      <td><?php echo $DatPagoBoleta->PagFecha?></td>
                      <td>Cliente:
<?php
//MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPago=NULL)
$InsPagoComprobante = new ClsPagoComprobante();
$ResPagoComprobante = $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,'PacId','Desc',NULL,$DatPagoBoleta->PagId);
$ArrPagoComprobantes = $ResPagoComprobante['Datos'];
?>
                        <?php
if(!empty($ArrPagoComprobantes)){
	foreach($ArrPagoComprobantes as $DatPagoComprobante){
?>
                        <?php		echo $DatPagoComprobante->CliNombre;?>
                        <?php		echo $DatPagoComprobante->CliApellidoPaterno;?>
                        <?php		echo $DatPagoComprobante->CliApellidoMaterno;?>
                      <?php	
	}
}
?></td>
                      <td><?php echo $DatPagoBoleta->PagId?>/<?php echo $DatPagoBoleta->PagConcepto?></td>
                      <td><?php echo $DatPagoBoleta->PagNumeroTransaccion?></td>
                      <td><?php echo $DatPagoBoleta->PagFechaTransaccion?></td>
                      <td><?php echo $DatPagoBoleta->BanNombre?> - <?php echo $DatPagoBoleta->CueNumero?></td>
                      <td align="right"><?php echo $DatPagoBoleta->MonSimbolo?></td>
                      <td align="right"><?php echo number_format($DatPagoBoleta->PagMonto,2);?></td>
                      <td align="right"><?php echo $DatPagoBoleta->PagObservacionCaja?></td>
                      <td align="left">
                      
                     <?php
						
                        $OtrosAbonos = "";
                       
                        if(!empty($ArrPagos2)){
                            foreach($ArrPagos2 as $DatPago2){
                                
                                if( $DatPago2->BolId != $DatPagoBoleta->BolId && $DatPago2->BtaId != $DatPagoBoleta->BtaId ){
                                    
									$DatPago2->PagMonto = (($EmpresaMonedaId==$DatPago2->MonId or empty($POST_Moneda))?$DatPago2->PagMonto:($DatPago2->PagMonto/$DatPago2->PagTipoCambio));
                                    
                                  //  $Abono = "(2a)";
                                    $Abono = "";
                                   // if(!empty($DatPago2->PagFechaTransaccion)){
//                                        $Abono .= " <b>Fec. Transac.:</b> ".$DatPago2->PagFechaTransaccion;
//                                    }
//                                    
                                    if(!empty($DatPago2->PagNumeroTransaccion)){
                                        $Abono .= " <b>Num. Transac.:</b> ".$DatPago2->PagNumeroTransaccion;
                                    }
                                    
                                    $OtrosAbonos .=  "<b>Fecha: </b>".$DatPago2->PagFecha." ".$Abono." <b>Monto: </b>".$DatPago2->MonSimbolo." ".number_format($DatPago2->PagMonto,2)." <br> ";
                                    
                                }
                                
                                
                            }
                        }
                  
                        
                        
                        
                        if(!empty($ArrPagos3)){
                            foreach($ArrPagos3 as $DatPago3){
                                    
                                $DatPago3->PagMonto = (($EmpresaMonedaId==$DatPago3->MonId or empty($POST_Moneda))?$DatPago3->PagMonto:($DatPago3->PagMonto/$DatPago3->PagTipoCambio));
                                
                               // $Abono = "(3)";
								$Abono = "";
                                
                               // if(!empty($DatPago3->PagFechaTransaccion)){
//                                    $Abono .= " <b>Fec. Transac.:</b> ".$DatPago3->PagFechaTransaccion;
//                                }
                                
                                if(!empty($DatPago3->PagNumeroTransaccion)){
                                    $Abono .= " <b>Num. Transac.:</b> ".$DatPago3->PagNumeroTransaccion;
                                }
								
								
                                
                                $OtrosAbonos .=  "<b>Fecha: </b>".$DatPago3->PagFecha." ".$Abono." <b>Monto:</b> ".$DatPago3->MonSimbolo." ".number_format($DatPago3->PagMonto,2)." <br> ";
                                
                            }
                        }		
                        
                        
                        
                        if(!empty($ArrPagos4)){
                            foreach($ArrPagos4 as $DatPago4){
                                
                                $DatPago4->PagMonto = (($EmpresaMonedaId==$DatPago4->MonId or empty($POST_Moneda))?$DatPago4->PagMonto:($DatPago4->PagMonto/$DatPago4->PagTipoCambio));
                                
                                ///$Abono = "(4)";
								$Abono = "";
                                
                              //  if(!empty($DatPago4->PagFechaTransaccion)){
//                                    $Abono .= " <b>Fec. Transac.:</b> ".$DatPago4->PagFechaTransaccion;
//                                }
                                
                                if(!empty($DatPago4->PagNumeroTransaccion)){
                                    $Abono .= " <b>Num. Transac.:</b> ".$DatPago4->PagNumeroTransaccion;
                                }
                                
                                $OtrosAbonos .=  "<b>Fecha: </b>".$DatPago4->PagFecha." ".$Abono." <b>Monto:</b> ".$DatPago4->MonSimbolo." ".number_format($DatPago4->PagMonto,2)." <br> ";
                                
                            }
                        }		
					  
					  ?>
                      
                      <?php echo $OtrosAbonos ?>
                      
                      
                      
                      </td>
                    </tr>
                                          
                                            
                  <?php
                        $TotalPagoBoletas += $DatPagoBoleta->PagMonto;
                        $i++;
                    }
			?>
            
          <tr>
                      <td colspan="7" align="right">
                      <span class="EstFormularioEtiqueta">
                      TOTAL BOLETAS:
                      </span>
                      </td>
                      <td align="right"><?php echo number_format($TotalPagoBoletas,2);?></td>
                      <td align="right">-</td>
                      <td align="right">&nbsp;</td>
                    </tr>
                          </tbody>
                        </table>    
                        
                      <hr />   
                          <?php
                }
                ?>       
  <?php

?>
           
           
           
           <?php
                
                
                if(!empty($ArrPagoVentaDirectas)){
				?>
           
<span class="EstFormularioSubTitulo">ABONO DE REPUESTOS</span>

                    
                        
                        <table width="100%" border="0" cellpadding="1" cellspacing="2" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="2%">#
                                
                              </th>
                              <th width="5%">F.P.</th>
                              <th width="7%">Ref.</th>
                              <th width="6%">Fecha</th>
                              <th width="21%">Ref.</th>
                              <th width="25%">Concepto</th>
                              <th width="5%">No. Transaccion</th>
                              <th width="5%">Fec. Transaccion</th>
                              <th width="6%">Det. Transaccion</th>
                              <th width="2%">Moneda</th>
                              <th width="5%">Monto</th>
                              <th width="9%">Obs.</th>
                              <th width="9%">-</th>
                            </tr>
                          </thead>
                          <tbody class="EstTablaListadoBody">
				
                
                <?php
					$i=1;
                    foreach($ArrPagoVentaDirectas as $DatPagoVentaDirecta){
                        
                        $DatPagoVentaDirecta->PagMonto = (($EmpresaMonedaId==$DatPagoVentaDirecta->MonId or empty($POST_Moneda))?$DatPagoVentaDirecta->PagMonto:($DatPagoVentaDirecta->PagMonto/$DatPagoVentaDirecta->PagTipoCambio));
                
                ?>
                                            
                    <tr>
                      <td>
                        <?php echo $i;?>
                      </td>
                      <td><?php echo $DatPagoVentaDirecta->FpaNombre?></td>
                      <td>
					  
					  
					 <!-- <?php echo $DatPagoVentaDirecta->PagNumeroRecibo?>-->
                       <?php echo $DatPagoVentaDirecta->FtaNumero;?> <?php echo $DatPagoVentaDirecta->FacId;?>
                       <?php echo $DatPagoVentaDirecta->BtaNumero;?> <?php echo $DatPagoVentaDirecta->BolId;?>
                       <?php echo $DatPagoVentaDirecta->PagId?>
                      
                      </td>
                      <td><?php echo $DatPagoVentaDirecta->PagFecha?></td>
                      <td>Cliente:
                        <?php
//MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPago=NULL)
$InsPagoComprobante = new ClsPagoComprobante();
$ResPagoComprobante = $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,'PacId','Desc',NULL,$DatPagoVentaDirecta->PagId);
$ArrPagoComprobantes = $ResPagoComprobante['Datos'];
?>
                        <?php
if(!empty($ArrPagoComprobantes)){
	foreach($ArrPagoComprobantes as $DatPagoComprobante){
?>
                        <?php		echo $DatPagoComprobante->CliNombre;?>
                        <?php		echo $DatPagoComprobante->CliApellidoPaterno;?>
                        <?php		echo $DatPagoComprobante->CliApellidoMaterno;?>
                      <?php	
	}
}
?></td>
                      <td><?php echo $DatPagoVentaDirecta->PagConcepto?></td>
                      <td><?php echo $DatPagoVentaDirecta->PagNumeroTransaccion?></td>
                      <td><?php echo $DatPagoVentaDirecta->PagFechaTransaccion?></td>
                      <td><?php echo $DatPagoVentaDirecta->BanNombre?> - <?php echo $DatPagoVentaDirecta->CueNumero?></td>
                      <td align="right"><?php echo $DatPagoVentaDirecta->MonSimbolo?></td>
                      <td align="right"><?php echo number_format($DatPagoVentaDirecta->PagMonto,2);?></td>
                      <td align="right"><?php echo $DatPagoVentaDirecta->PagObservacionCaja?></td>
                      <td align="right">-</td>
                    </tr>
                                          
                                            
                  <?php
                        $TotalPagoVentaDirectas += $DatPagoVentaDirecta->PagMonto;
                        $i++;
                    }
				?>
                
             
                
                <tr>
                      <td colspan="7" align="right">
                      
                      
                      <span class="EstFormularioEtiqueta">
                      TOTAL ABONO REPUESTOS:
                      </span>
                      </td>
                      <td align="right"><?php echo number_format($TotalPagoVentaDirectas,2);?></td>
                      <td align="right">-</td>
                      <td align="right">&nbsp;</td>
                    </tr>
                          </tbody>
                        </table>    
                        
                     <hr />    
                        
                           <?php
                }
                ?>
                
                      
  <?php

?>
                                         
   <?php
                
                
                if(!empty($ArrPagoOrdenVentaVehiculos)){
				?>
					
                    
                    <span class="EstFormularioSubTitulo">ABONO DE VEHICULOS</span>

                    
                        
                        <table width="100%" border="0" cellpadding="1" cellspacing="2" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="2%">#
                                
                              </th>
                              <th width="5%">F.P.</th>
                              <th width="7%">Ref.</th>
                              <th width="6%">Fecha</th>
                              <th width="21%">Ref.</th>
                              <th width="25%">Concepto</th>
                              <th width="5%">No. Transaccion</th>
                              <th width="5%">Fec. Transaccion</th>
                              <th width="6%">Det. Transaccion</th>
                              <th width="2%">Moneda</th>
                              <th width="5%">Monto</th>
                              <th width="9%">Obs.</th>
                              <th width="9%">-</th>
                            </tr>
                          </thead>
                          <tbody class="EstTablaListadoBody">
				
                
                <?php
					$i=1;
                    foreach($ArrPagoOrdenVentaVehiculos as $DatPagoOrdenVentaVehiculo){
                        
                        $DatPagoOrdenVentaVehiculo->PagMonto = (($EmpresaMonedaId==$DatPagoOrdenVentaVehiculo->MonId or empty($POST_Moneda))?$DatPagoOrdenVentaVehiculo->PagMonto:($DatPagoOrdenVentaVehiculo->PagMonto/$DatPagoOrdenVentaVehiculo->PagTipoCambio));
                
                ?>
                                            
                    <tr>
                      <td>
                        <?php echo $i;?>
                      </td>
                      <td><?php echo $DatPagoOrdenVentaVehiculo->FpaNombre?></td>
                      <td>
					  
					  
					 <!-- <?php echo $DatPagoOrdenVentaVehiculo->PagNumeroRecibo?>-->
                       <?php echo $DatPagoOrdenVentaVehiculo->FtaNumero;?> <?php echo $DatPagoOrdenVentaVehiculo->FacId;?>
                       <?php echo $DatPagoOrdenVentaVehiculo->BtaNumero;?> <?php echo $DatPagoOrdenVentaVehiculo->BolId;?>
                      
					  <?php echo $DatPagoOrdenVentaVehiculo->PagId?>
                      
                      </td>
                      <td><?php echo $DatPagoOrdenVentaVehiculo->PagFecha?></td>
                      <td>Cliente:
                        <?php
//MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPago=NULL)
$InsPagoComprobante = new ClsPagoComprobante();
$ResPagoComprobante = $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,'PacId','Desc',NULL,$DatPagoOrdenVentaVehiculo->PagId);
$ArrPagoComprobantes = $ResPagoComprobante['Datos'];
?>
                        <?php
if(!empty($ArrPagoComprobantes)){
	foreach($ArrPagoComprobantes as $DatPagoComprobante){
?>
                        <?php		echo $DatPagoComprobante->CliNombre;?>
                        <?php		echo $DatPagoComprobante->CliApellidoPaterno;?>
                        <?php		echo $DatPagoComprobante->CliApellidoMaterno;?>
                      <?php	
	}
}
?></td>
                      <td><?php echo $DatPagoOrdenVentaVehiculo->PagConcepto?></td>
                      <td><?php echo $DatPagoOrdenVentaVehiculo->PagNumeroTransaccion?></td>
                      <td><?php echo $DatPagoOrdenVentaVehiculo->PagFechaTransaccion?></td>
                      <td><?php echo $DatPagoOrdenVentaVehiculo->BanNombre?> - <?php echo $DatPagoOrdenVentaVehiculo->CueNumero?></td>
                      <td align="right"><?php echo $DatPagoOrdenVentaVehiculo->MonSimbolo?></td>
                      <td align="right"><?php echo number_format($DatPagoOrdenVentaVehiculo->PagMonto,2);?></td>
                      <td align="right"><?php echo $DatPagoOrdenVentaVehiculo->PagObservacionCaja?></td>
                      <td align="right">-</td>
                    </tr>
                                          
                                            
                  <?php
                        $TotalPagoOrdenVentaVehiculos += $DatPagoOrdenVentaVehiculo->PagMonto;
                        $i++;
                    }
				?>
                
              
                
                <tr>
                      <td colspan="7" align="right">
                      
                      <span class="EstFormularioEtiqueta">
                      TOTAL ABONO VEHICULOS:
                      </span>
                      
                      </td>
                      <td align="right"><?php echo number_format($TotalPagoOrdenVentaVehiculos,2);?></td>
                      <td align="right">-</td>
                      <td align="right">&nbsp;</td>
                    </tr>
                          </tbody>
                        </table>  
                        
                          <hr />  
                  <?php
                }
                ?>
                
                
                        
                                
  <?php

?>
                                               
                        
  <?php


?>
                        
                     
  <?php

if(!empty($ArrIngresos)){
?>
<span class="EstFormularioSubTitulo">OTROS INGRESOS</span>Abonos Relacionados
   
                        <table width="100%" border="0" cellpadding="1" cellspacing="2" class="EstTablaListado">
                          <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="2%">#
                                
                              </th>
                              <th width="6%">F.P.</th>
                              <th width="6%">Ref.</th>
                              <th width="7%">Fecha</th>
                              <th width="21%">Ref.</th>
                              <th width="25%">Concepto</th>
                              <th width="5%">No. Transaccion</th>
                              <th width="5%">Fec. Transaccion</th>
                              <th width="6%">Det. Transaccion</th>
                              <th width="2%">Moneda</th>
                              <th width="5%">Monto</th>
                              <th width="9%">Obs.</th>
                              <th width="9%">-</th>
                            </tr>
                          </thead>
                          <tbody class="EstTablaListadoBody">


<?php
		$i=1;
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
                              <td>  <?php
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
                                
                                
                              
                                
                                
                                
                                
                              </td>
                              <td><?php echo $DatIngreso->PagNumeroTransaccion?></td>
                              <td><?php echo $DatIngreso->PagFechaTransaccion?></td>
                              <td><?php echo $DatIngreso->BanNombre?> - <?php echo $DatIngreso->CueNumero?></td>
                              <td align="right"><?php echo $DatIngreso->MonSimbolo?></td>
                              <td align="right"><?php echo number_format($DatIngreso->IngMonto,2)?></td>
                              <td align="right"><?php echo $DatIngreso->IngObservacionCaja;?></td>
                              <td align="right">-</td>
                            </tr>
                            
                            
                            
  <?php	
		$TotalOtrosIngresos += $DatIngreso->IngMonto;
		$i++;
		}
?>



 <tr>
                              <td colspan="7" align="right">TOTAL OTROS INGRESOS:</td>
                              <td align="right"><?php echo number_format($TotalOtrosIngresos,2);?></td>
                              <td align="right">-</td>
                              <td align="right">&nbsp;</td>
                            </tr>
                            
                            
                            
                          </tbody>
                        </table>     
                        
                        <hr /> 
                        
                        <?php
	}
?>
  <?php

?>
                        
                        
                        
                        
  <?php
//$TotalIngresos  = $TotalFacturas + $TotalBoletas + $TotalPagos;
$TotalIngresos  = $TotalOtrosIngresos + $TotalPagoBoletas + $TotalPagoFacturas + $TotalPagoVentaDirectas + $TotalPagoOrdenVentaVehiculos;
?>                  
                        
                        
                        
                        
                        
                        
                        
                      </td>
                    </tr>
                    <tr>
                      <td align="right">TOTAL INGRESOS: <?php echo number_format($TotalIngresos,2);?></td>
                    </tr>
        </table>



         

                             
  