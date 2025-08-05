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
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_MSI_".date('d-m-Y').".xls\";");
//}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_Mes = empty($_GET['Mes'])?date("m"):$_GET['Mes'];
$POST_Ano = empty($_GET['Ano'])?date("Y"):$_GET['Ano'];
$POST_VehiculoMarca = empty($_GET['CmpVehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_Sucursal = empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal'];


//deb($POST_Mes);
if(empty($POST_VehiculoMarca)){
die("No ha escogido una marca de vehiculo");
}

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqReporte().'ClsResumenVenta.php');
require_once($InsPoo->MtdPaqReporte().'ClsResumenStock.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteCOR.php');

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaAccion = new ClsFichaAccion();
$InsFichaAccionProducto = new ClsFichaAccionProducto();
$InsPersonal = new ClsPersonal();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsProveedor = new ClsProveedor();
$InsOrdenCompra = new ClsOrdenCompra();
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
$InsProducto = new ClsProducto();
$InsReporteProducto = new ClsReporteProducto();
$InsResumenVenta = new ClsResumenVenta();
$InsResumenStock = new ClsResumenStock();

$InsPersonal->PerId = "PER-10016";
$InsPersonal->MtdObtenerPersonal();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
		
		
$InsProveedor->PrvId = "PRV-10548";
$InsProveedor->MtdObtenerProveedor();

//MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL)

//$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProNombre","ASC","10",NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL);
//$ArrProductos = $ResProducto['Datos'];

$CantidadDias = cal_days_in_month(CAL_GREGORIAN, $POST_Mes, $POST_Ano);

$FechaInicio = $POST_Ano."-01-01";
$FechaFin = $POST_Ano."-".$POST_Mes."-".$CantidadDias;

//deb($FechaInicio);
//deb($FechaFin);

//MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL) {
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentas(NULL,$FechaInicio,$FechaFin,NULL,NULL,"RprCantidad","DESC",NULL,$POST_VehiculoMarca);
$ArrReporteProductos = $ResReporteProducto['Datos'];

//MtdObtenerReporteProductoVentasPerdidas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL)
$ResReporteProductoVentasPerdida = $InsReporteProducto->MtdObtenerReporteProductoVentasPerdidas(NULL,$FechaInicio,$FechaFin,NULL,NULL,"cpr.CprFecha","DESC","25",$POST_VehiculoMarca);
$ArrReporteProductoVentasPerdidas = $ResReporteProductoVentasPerdida['Datos'];

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
          <td colspan="4" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
        </tr>
        <tr>
          <td width="23%" rowspan="2" align="left" valign="top"><?php
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
          <td width="54%" rowspan="2" align="center" valign="top">CONTROL DE OPERACIONES DE REPUESTOS  - COR
      </td>
          <td width="23%" rowspan="2" align="right" valign="top">&nbsp;</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        <tr>
          <td align="right" valign="top">Mes y a&ntilde;o: <?php echo FncConvertirMes($POST_Mes);?> <?php echo $POST_Ano;?></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		<?php
		
		?>
                     
                    <table class="EstTablaReporte" width="100%">
                    <tr>
                      <td colspan="4" align="center" valign="top">BASE</td>
                      </tr>
                    <tr>
                      <td width="27%" align="center" valign="top">
                        
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">1. Datos del concesionario</span></td>
                              </tr>
                            <tr>
                              <td width="95">Nombre:</td>
                              <td width="140">&nbsp;<?php echo $EmpresaNombre;?></td>
                              </tr>
                            <tr>
                              <td>Ubicación:</td>
                              <td>&nbsp;<?php echo $EmpresaDireccion;?></td>
                              </tr>
                            <tr>
                              <td>Distrito:</td>
                              <td>&nbsp;<?php echo $EmpresaDistrito;?></td>
                              </tr>
                            <tr>
                              <td>Responsable:</td>
                              <td>&nbsp;<?php echo $InsPersonal->PerNombre ?> <?php echo $InsPersonal->PerApellidoPaterno ?> <?php echo $InsPersonal->PerApellidoMaterno ?></td>
                              </tr>
                            <tr>
                              <td>Cargo:</td>
                              <td>&nbsp;<?php echo $InsPersonal->PtiNombre ?></td>
                              </tr>
                            <tr>
                              <td>Firma:</td>
                              <td>&nbsp;
                                
                                <?php
                        if(!empty($InsPersonal->PerFirma)){
                        ?>
                                <img src="../../subidos/personal_firmas/<?php echo $InsPersonal->PerFirma;?>" alt="[-]" />    
                                <?php	
                        }	
                        ?>
                                
                                
                                
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        
                        </td>
                      <td width="27%" align="center" valign="top">
                        
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">2. Datos de la instalación</span></td>
                              </tr>
                            <tr>
                              <td width="176">Tipo de    local (2S/3S):</td>
                              <td width="112">&nbsp;</td>
                              </tr>
                            <tr>
                              <td>Inicio de    operación:</td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td>Area total de    servicio (m2):</td>
                              <td>&nbsp;</td>
                              </tr>
                            <tr>
                              <td>Sistema de repuestos:</td>
                              <td>&nbsp;</td>
                              </tr>
                            </tbody>
                        </table></td>
                      <td colspan="2" align="center" valign="top">
                        
                        
                        <table width="280" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <tbody class="EstTablaReporteBody">
                            <tr>
                              <td colspan="2"><span class="EstTablaReporteSubtitulo">3. Datos del personal</span></td>
                              </tr>
                            <tr>
                              <td colspan="2"> <span class="EstTablaReporteSubtitulo2">Personal de operaciones</span></td>
                              </tr>
                            <tr>
                              <td width="167">Asesores de    repuestos:</td>
                              <td width="41">&nbsp;</td>
                              </tr>
                            <tr>
                              <td>Asistentes    de almacen:</td>
                              <td>&nbsp;</td>
                              </tr>
                            </tbody>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="4" align="center">REPORTE</td>
                    </tr>
                    <tr>
                      <td colspan="4">
                  
                  
                      <?php
					for($mes=1;$mes<=$POST_Mes;$mes++){
					?>
						
						<?php
                        $InsReporteCOR = new ClsReporteCOR();
                        //MtdObtenerReporteCORs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL) {
                        $ResReporteCOR = $InsReporteCOR->MtdObtenerReporteCORs(NULL,NULL,NULL,'RcrId','Desc','1',$POST_Ano,str_pad($mes,2,"0",STR_PAD_LEFT),$POST_VehiculoMarca);
                        $ArrReporteCORs = $ResReporteCOR['Datos'];
                        
						
						$RcrVentaTallerMarca[$mes] = 0;
						$RcrVentaPPMarca[$mes] = 0;
						$RcrVentaMesonMarca[$mes] = 0;
						$RcrVentaRatailMarca[$mes] = 0;
						$RcrVentaRetailLubricantes[$mes] = 0;
                        $RcrTotalVentasRetail[$mes] = 0;
                        $RcrMargenAporte[$mes] = 0;
                        $RcrStockMarca[$mes] = 0;
                        $RcrStockLubricantes[$mes] = 0;
                        $RcrTotalStock[$mes] = 0;
						$RcrValorRepuestosA[$mes] = 0;
                        $RcrValorRepuestosB[$mes] = 0;
                        $RcrValorRepuestosC[$mes] = 0;
                        $RcrValorRepuestosD[$mes] = 0;
                        $RcrRotationMarca[$mes] = 0;
                        $RcrValorPreObsoletos[$mes] = 0;
						$RcrValorObsoletos[$mes] = 0;
						$RcrPedidosYSTK[$mes] = 0;
						$RcrPedidosYRUSH[$mes] = 0;
						$RcrPedidosZVOR[$mes] = 0;
						$RcrPedidosZGAR[$mes] = 0;
						$RcrTasaServicioTaller[$mes] = 0;
						$RcrMontoVentaPedidas[$mes] = 0;
						$RcrPersonalAsesorRepuestos[$mes] = 0;
						$RcrPersonalAsistenteAlmacen[$mes] = 0;
						$RcrDiasLaborados[$mes] = 0;
						$RcrHorasDisponibles[$mes] = 0;
						  
                        if(!empty($ArrReporteCORs)){
                            foreach($ArrReporteCORs as $DatReporteCOR){
                                
								$RcrVentaTallerMarca[$mes] = $DatReporteCOR->RcrVentaTallerMarca;
								$RcrVentaPPMarca[$mes] = $DatReporteCOR->RcrVentaPPMarca;
								$RcrVentaMesonMarca[$mes] = $DatReporteCOR->RcrVentaMesonMarca;
								$RcrVentaRatailMarca[$mes] = $DatReporteCOR->RcrVentaRatailMarca;
								$RcrVentaRetailLubricantes[$mes] = $DatReporteCOR->RcrVentaRetailLubricantes;
								
                                $RcrTotalVentasRetail[$mes] = $DatReporteCOR->RcrTotalVentasRetail;
                                $RcrMargenAporte[$mes] = $DatReporteCOR->RcrMargenAporte;
                                $RcrStockMarca[$mes] =$DatReporteCOR->RcrStockMarca;
                                $RcrStockLubricantes[$mes] = $DatReporteCOR->RcrStockLubricantes;
                                $RcrTotalStock[$mes] = $DatReporteCOR->RcrTotalStock;
								$RcrValorRepuestosA[$mes] = $DatReporteCOR->RcrValorRepuestosA;
								$RcrValorRepuestosB[$mes] = $DatReporteCOR->RcrValorRepuestosB;
                                $RcrValorRepuestosC[$mes] = $DatReporteCOR->RcrValorRepuestosC;
                                $RcrValorRepuestosD[$mes] = $DatReporteCOR->RcrValorRepuestosD;
                                $RcrRotationMarca[$mes] = $DatReporteCOR->RcrRotationMarca;
                                $RcrValorPreObsoletos[$mes] =$DatReporteCOR->RcrValorPreObsoletos;
                                $RcrValorObsoletos[$mes] =$DatReporteCOR->RcrValorObsoletos;
								
								$RcrPedidosYSTK[$mes] =$DatReporteCOR->RcrPedidosYSTK;
								$RcrPedidosYRUSH[$mes] =$DatReporteCOR->RcrPedidosYRUSH;
								$RcrPedidosZVOR[$mes] =$DatReporteCOR->RcrPedidosZVOR;
								$RcrPedidosZGAR[$mes] =$DatReporteCOR->RcrPedidosZGAR;
								$RcrTasaServicioTaller[$mes] =$DatReporteCOR->RcrTasaServicioTaller;
								$RcrMontoVentaPedidas[$mes] =$DatReporteCOR->RcrMontoVentaPedidas;
								$RcrPersonalAsesorRepuestos[$mes] =$DatReporteCOR->RcrPersonalAsesorRepuestos;
								$RcrPersonalAsistenteAlmacen[$mes] =$DatReporteCOR->RcrPersonalAsistenteAlmacen;
								$RcrDiasLaborados[$mes] =$DatReporteCOR->RcrDiasLaborados;
								$RcrHorasDisponibles[$mes] =$DatReporteCOR->RcrHorasDisponibles;
										 
                            }
                        }
                        ?>
                        
                    <?php
					}
                    ?>
                    
                      
                   1. Control de ventas
                    
                    <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th>
                    Ventas por categoria</th>
                    <?php for($mes=1;$mes<=12;$mes++){
                    ?>
                    <th width="80" align="center"><?php echo FncConvertirMes($mes);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                        <tr>
                            <td >
                                Venta Taller Chevrolet
                            </td>
                            <?php 
								for($mes=1;$mes<=$POST_Mes;$mes++){
									
									
									
                            ?>
                                <td width="80" align="center">
                                                     
<?php
if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
?>

<?php echo $RcrVentaTallerMarca[$mes];  ?>
 

<?php
}
?>

                                
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                       
                       
                       
                        <tr>
                            <td >
                            Venta P&amp;P Chevrolet</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                                
<?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
?>  
                                   
						<?php echo $RcrVentaPPMarca[$mes];  ?>
<?php
							}
?>
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                        
                            <tr>
                            <td >
                              Venta Meson Chevrolet</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                    
						<?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
						?>
                                
						<?php echo $RcrVentaMesonMarca[$mes];  ?>

						<?php
							}
							?>


                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                              <tr>
                                <td >Venta Retail Chevrolet</td>
                               <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center">
                    
                    		<?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>
                            		<?php echo $RcrVentaRatailMarca[$mes];  ?>
                            <?php	
							}
							?>
                    		</td>
                            <?php	
                            }
                            ?>
                              </tr>
                              <tr>
                                <td>Venta Retail Lubricantes</td>
                                <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                    
                   

						<?php
                        if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
                        ?>             
                        
                        <?php echo $RcrVentaRetailLubricantes[$mes];  ?>
                        
                        <?php
                        }
                        ?>                      
                      
                      
                      
                      </td>
                            <?php	
                            }
                            ?>
                              </tr>
                              <tr>
                                <td class="EstTablaReporteColumnaEspecial4">Total Ventas Retail</td>
                                <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" class="EstTablaReporteColumnaEspecial4">

									<?php
                                    if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
                                    ?>
                                    
                                  	 <?php echo $RcrTotalVentasRetail[$mes];  ?>
                                                             
                                    <?php
                                    }
                                    ?>
                                                             
                         
                                </td>
                            <?php	
                            }
                            ?>
                              </tr>
                              <tr>
                            <td class="EstTablaReporteColumnaEspecial4">
                               Margen de aporte (%)</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" class="EstTablaReporteColumnaEspecial4">
                                
									<?php
                                    if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
                                    ?>
                                      	<?php echo $RcrMargenAporte[$mes];  ?>
                                    <?php	
                                    }
                                    ?>
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                       
                    
                    </tbody>
                    </table>
                    
                    
                    
                    
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" align="left" valign="top">2. Control de inventario y rotación
                      
                      <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th>&nbsp;</th>
                    <?php for($mes=1;$mes<=12;$mes++){
                    ?>
                    <th width="80" align="center"><?php echo FncConvertirMes($mes);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                        <tr>
                            <td class="EstTablaReporteColumnaEspecial2">
                                Stock Chevrolet</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" class="EstTablaReporteColumnaEspecial2">

								
                                <?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
									<?php echo $RcrStockMarca[$mes];  ?>

								<?php
								}
								?>
                                                      
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                       
                       
                       
                        <tr>
                            <td >
                            Stock Lubricantes</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >

								<?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
									
									<?php echo $RcrStockLubricantes[$mes];  ?>
                                    
                                 <?php
								}
								 ?>
                                    
                            
                                
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                        
                            <tr>
                            <td >
                              Total de Stock</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                    
                    			<?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
                    			
                               <?php echo $RcrTotalStock[$mes];  ?>
                                    
                                    
                                    <?php
								}
									?>
                    
                                
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                              <tr>
                                <td >Valor en repuestos A (%)</td>
                                <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                                
                                	<?php
									if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
									?>
                                	 <?php echo $RcrValorRepuestosA[$mes];  ?>
                                    <?php
									}
									?>
                                    
                                </td>
                            <?php	
                            }
                            ?>
                              </tr>
                              <tr>
                                <td >Valor en repuestos B (%)</td>
 <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                                
                                <?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
                              		 <?php echo $RcrValorRepuestosB[$mes];  ?>
                                    <?php
								}
									?>
                                    
                                </td>
                            <?php	
                            }
                            ?>                              </tr>
                              <tr>
                                <td >Valor en repuestos C (%)</td>
                                 <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                               
                               	<?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
                                	<?php echo $RcrValorRepuestosC[$mes];  ?>
                                    
                                    <?php
								}
									?>
                                    
                                    </td>
                            <?php	
                            }
                            ?>
                              </tr>
                              <tr>
                                <td >Valor en repuestos D (%)</td>
                               <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                    
                                <?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
                                	<?php echo $RcrValorRepuestosD[$mes];  ?>
                                <?php	
								}
								?>
                                </td>
                            <?php	
                            }
                            ?>
                              </tr>
                              <tr>
                                <td >Rotación Chevrolet</td>
                                 <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                    
                                	<?php
									if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
									?>
                                    
									<?php echo $RcrRotationMarca[$mes];  ?>
                                    <?php
									}
									?>
                                </td>
                            <?php	
                            }
                            ?>
                              </tr>
                              <tr>
                                <td>Valor pre-obsoletos (%)</td>
                                <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                    
                                <?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
                                	<?php echo $RcrValorPreObsoletos[$mes];  ?>
                                <?php									
								}
								?>
                                </td>
                            <?php	
                            }
                            ?>
                              </tr>
                              <tr>
                                <td >Valor obsoletos (%)</td>
                                <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                    
                                <?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
                                	<?php echo $RcrValorObsoletos[$mes];  ?>
                                <?php	
								}
								?>
                                </td>
                            <?php	
                            }
                            ?>
                              </tr>
                        </tbody>
                    </table>
                    
                    </td>
                      </tr>
                    <tr>
                      <td colspan="4">
                      3. Control de atención de repuestos
                      
                      <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th>&nbsp;</th>
                    <?php for($mes=1;$mes<=12;$mes++){
                    ?>
                    <th width="80" align="center"><?php echo FncConvertirMes($mes);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                        <tr>
                            <td >
                                Pedidos YSTK</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                                
<?php
if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
?>
<?php echo $RcrPedidosYSTK[$mes];  ?>

<?php
}
?>
                                
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                       
                        <tr>
                            <td >
                            Pediros YRSH</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                                
									<?php
                                    if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
                                    ?>
                                    <?php echo $RcrPedidosYRUSH[$mes];  ?>
                                    <?php
                                    }
                                    ?>
                                
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                        
                            <tr>
                            <td >
                              Pedidos ZVOR</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center">
                    
<?php
if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
?>
<?php echo $RcrPedidosZVOR[$mes];  ?>
<?php
}
?>

                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                              <tr>
                                <td >Pedidos ZGAR</td>
                                <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                                

<?php
if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
?>   

<?php echo $RcrPedidosZGAR[$mes];  ?>

<?php
}
?>

</td>
                            <?php	
                            }
                            ?>
                              </tr>
                              <tr>
                                <td class="EstTablaReporteColumnaEspecial5">Tasa de servido a taller</td>
 <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" class="EstTablaReporteColumnaEspecial5">
                                
<?php
if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
?>
<?php echo $RcrTasaServicioTaller[$mes];  ?>
<?php	
}
?>
                                </td>
                            <?php	
                            }
                            ?>                              </tr>
                              <tr>
                                <td class="EstTablaReporteColumnaEspecial5">Monto ventas perdidas</td>
                                 <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" class="EstTablaReporteColumnaEspecial5">
                                
<?php
if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
?>
	<?php echo $RcrMontoVentaPedidas[$mes];  ?>
<?php	
}
?>
                                </td>
                            <?php	
                            }
                            ?>
                              </tr>
                        </tbody>
                    </table>
                      </td>
                      </tr>
                    <tr>
                      <td colspan="4">4. Utilización del recurso humano
                      
                      
                      <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                    <th> Datos de mano de obra</th>
                    <?php for($mes=1;$mes<=12;$mes++){
                    ?>
                    <th width="80" align="center"><?php echo FncConvertirMes($mes);?></th>
                    <?php	
                    }
                    ?>
                    </tr>
                    </thead>
                   
                 
                 
                    <tbody class="EstTablaReporteBody">
                        <tr>
                            <td>
                                Asesores de repuestos</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center">
                                
                                <?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
                              <?php echo $RcrPersonalAsesorRepuestos[$mes];  ?>
                                <?php
								}
								?>
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                       
                       
                       
                        <tr>
                            <td >
                            Asistentes de almacén</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                                
                                <?php
								if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
								?>
                               <?php echo $RcrPersonalAsistenteAlmacen[$mes];  ?>
                                <?php
								}
								?>
                                
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                        
                            <tr>
                            <td >
                              Días laborados</td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                    
                    
                    		<?php
							if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							?>
                                
                                  <?php echo $RcrDiasLaborados[$mes];  ?>
                            
                            <?php
							}
							?>
                                </td>
                            <?php	
                            }
                            ?>
                            
                        </tr>
                        
                        
                              <tr>
                                <td >Horas disponibles asesor</td>
                                <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center" >
                              
                              <?php
							  if( ($mes<=date("m") and date("Y")== $POST_Ano) or  $POST_Ano!=date("Y")){
							  ?>
                              <?php echo $RcrHorasDisponibles[$mes];  ?>
                            
                            <?php
							  }
							?>
                            
                            </td>
                            <?php	
                            }
                            ?>
                              </tr>
                        </tbody>
                    </table>
                    
                    </td>
                      </tr>
                    <tr>
                      <td colspan="4" align="center">MOVIMIENTO E INVENTARIO</td>
                      </tr>
                    <tr>
                      <td colspan="4">Venta retail por unidades
                      
                      
                      <table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                      <th width="122" align="center">Código P/N</th>
                    <th width="521" align="center"> Descripción</th>
                    <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                    ?>
                    <th width="80" align="center"><?php echo FncConvertirMes($mes);?></th>
                    
                    <?php	
                    }
                    ?>
                    <td width="80" align="center">Inventario</td>
                    <td width="80" align="center">
                    ABC</td>
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                    
<?php
if(!empty($ArrReporteProductos)){
	foreach($ArrReporteProductos as $DatProducto){
?>


                        <tr>
                          <td ><?php echo $DatProducto->ProCodigoOriginal?></td>
                            <td ><?php echo $DatProducto->ProNombre;?></td>
                            <?php for($mes=1;$mes<=$POST_Mes;$mes++){
                            ?>
                                <td width="80" align="center">
                                
                                
                                <?php
								
								//MtdObtenerReporteProductoVentasMensual($oProductoId,$oAno,$oMes,$oVehiculoMarca)
								$TotalMensual[$mes] = $InsReporteProducto->MtdObtenerReporteProductoVentasMensual($DatProducto->ProId,$POST_Ano,$mes,$POST_VehiculoMarca);
								?>
                                
                              <?php
							  echo number_format($TotalMensual[$mes]);
							  ?>
                                
                              
                                </td>
                               
                            <?php	
                            }
                            ?>
                             <td width="80" align="center">0</td>
                            <td width="80" align="center"><?php echo $DatProducto->ProABCInterno;?></td>
                            
                        </tr>
                        

<?php
	}
}
?>


                        </tbody>
                    </table>
                    
                    
                    </td>
                      </tr>
                    <tr>
                      <td colspan="4" align="center">VENTAS PERDIDAS</td>
                      </tr>
                    <tr>
                      <td colspan="4"><table width="100%" class="EstTablaReporte" cellpadding="2" cellspacing="2">
                        <thead class="EstTablaReporteHead">
                          <tr>
                            <th width="15%">Código P/N</th>
                            <th width="46%"> Descripción</th>
                            <th width="13%" align="center">Cantidad</th>
                            <th width="12%" align="center">Precio</th>
                            <th width="14%" align="center">Mes</th>
                          </tr>
                        </thead>
                        <tbody class="EstTablaReporteBody">
                        <?php
						if(!empty($ArrReporteProductoVentasPerdidas)){
							foreach($ArrReporteProductoVentasPerdidas as $DatReporteProductoVentaPerdida){
						?>
                            <tr>
                                <td ><?php echo $DatReporteProductoVentaPerdida->ProCodigoOriginal;?></td>
                                <td ><?php echo $DatReporteProductoVentaPerdida->ProNombre;?></td>
                                <td align="center" ><?php echo number_format($DatReporteProductoVentaPerdida->RprCantidad,2);?></td>
                                <td align="center" ><?php echo $EmpresaMoneda;?> <?php echo number_format($DatReporteProductoVentaPerdida->RprPrecio,2);?></td>
                                <td align="center" ><?php echo FncConvertirMes($DatReporteProductoVentaPerdida->RprMes);?></td>
                              </tr>
                              
                        <?php		
							}
						}
						?>
                          
                          
                          <tr>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                            <td >&nbsp;</td>
                          </tr>
                        </tbody>
                      </table></td>
                      </tr>
                    <tr>
                    <td>
                    
                    
                    </td>
                    <td></td>
                    <td colspan="2"></td>
                    </tr>
                    </table>
                    
          
       
     

