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
	header("Content-Disposition:  filename=\"REPORTE_VENTA_VEHICULOS_INICIAL_".date('d-m-Y').".xls\";");
}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m")."/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Personal = ($_GET['Personal']);
$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"OvvFecha";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"ASC";
$POST_Moneda = isset($_GET['Moneda'])?$_GET['Moneda']:"MON-10001";


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

require_once($InsPoo->MtdPaqLogistica().'ClsAsignacionVentaVehiculo.php');


require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();
 


$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();


//
//$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,$POST_Moneda,$POST_Personal,$POST_ClienteId,$POST_ConCotizacion);
//$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];

//MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oConFechaEntrega=false,$oTipoFecha="avv.AvvFecha",$oSucursal=NULL)
$ResAsignacionVentaVehiculo = $InsAsignacionVentaVehiculo->MtdObtenerAsignacionVentaVehiculos(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_estado,NULL,false,"ovv.OvvTiempoSolicitudEnvio",$POST_Sucursal);
$ArrOrdenVentaVehiculos = $ResAsignacionVentaVehiculo['Datos'];
//OvvTiempoSolicitudEnvio

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
          <td width="23%" align="left" valign="top">
		  
		  
		  
            <img src="../../imagenes/logos/logo_reporte.png" width="150"  />
          </td>
          <td width="54%" align="center" valign="top">REPORTE DE VEHICULOS CON INICIAL</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		<?php
		
		?>
                     
                    <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="10%">SUCURSAL</th>
          <th width="10%">ORD. VEN.</th>
          <th width="25%">FECHA ENVIO</th>
          <th width="25%">CLIENTE</th>
          <th width="11%" align="center">MARCA</th>
          <th width="11%" align="center">MODELO</th>
          <th width="11%" align="center">VERSION</th>
          <th width="11%" align="center">ANO FAB.</th>
          <th width="11%" align="center">ANO MOD.</th>
          <th width="11%" align="center">VIN</th>
          <th width="6%" align="center">ASESOR DE VENTAS</th>
          <th width="3%" align="center">MONEDA</th>
          <th width="3%" align="center">T.C.</th>
          <th width="3%" align="center">TOTAL ORDEN</th>
          <th width="6%" align="center">INICIAL FECHA</th>
          <th width="3%" align="center">INICIAL MONTO</th>
          <th width="3%" align="center">OTROS ABONOS</th>
          <th width="3%" align="center">SALDO PENDIENTE</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$SumaTotalOrdenVentaVehiculo = 0;
		$SumaTotalOrdenVentaVehiculoInicial = 0;
		$SumaTotalOrdenVentaVehiculoOtroAbono = 0;
		$SumaTotalOrdenVentaVehiculoPendiente = 0;
		
		$c=1;
        foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){

			if(empty($DatOrdenVentaVehiculo->FacId) and empty( $DatOrdenVentaVehiculo->BolId)){
				
		
				
			$TotalOrdenVentaVehiculoPendiente = 0;
			$TotalOrdenVentaVehiculoInicial = 0;
			$TotalOrdenVentaVehiculoOtroAbono = 0;
			
			$MontoOrdenVentaVehiculoLocal = $DatOrdenVentaVehiculo->OvvTotal;
			
			$TipoCambioOVV = 1;
			
			if ($POST_Moneda<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $POST_Moneda;
				$InsTipoCambio->TcaFecha = $DatOrdenVentaVehiculo->OvvFecha;
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				if(empty($InsTipoCambio->TcaId)){
				
					$InsTipoCambio->MtdObtenerTipoCambioUltimo();
				
				}
				
				$TipoCambioOVV = $InsTipoCambio->TcaMontoVenta;
				
			}
			
        ?>
       
       <?php $DatOrdenVentaVehiculo->OvvTotal = (($DatOrdenVentaVehiculo->OvvTotal/(empty($DatOrdenVentaVehiculo->OvvTipoCambio)?1:$DatOrdenVentaVehiculo->OvvTipoCambio)));?>
                          
		<?php
        if($DatOrdenVentaVehiculo->MonId == $POST_Moneda){
        ?>            
            <?php $SumaTotalOrdenVentaVehiculo += $DatOrdenVentaVehiculo->OvvTotal;?> 
        <?php
        }else{            
            $DatOrdenVentaVehiculo->OvvTotal = $MontoOrdenVentaVehiculoLocal/$TipoCambioOVV;            
        ?>            
            <?php $SumaTotalOrdenVentaVehiculo += $DatOrdenVentaVehiculo->OvvTotal;?>  
        <?php	
        }
        ?>
                    
                           
          
                    <?php
                    //$TotalAbono = 0;
                    $FechaUltimoAbono = "";
					$MonedaUltimoAbono = "";
					//$MontoUltimoAbono = 0;
					$TipoCambioUltimoAbono = 1;
					?>
                     
                    
                    <?php
                    $InsPago = new ClsPago();

//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL)
                    $ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,'PagFecha','ASC',NULL,NULL,NULL,$DatOrdenVentaVehiculo->OvvId,NULL,NULL,NULL,NULL,NULL,NULL);
                    $ArrPagos = $ResPago['Datos'];
                    ?>
                    
                    
                        <?php
						$p=1;
                        foreach($ArrPagos as $DatPago){
							
							$MontoUltimoAbonoLocal = $DatPago->PagMonto;
								
							$TipoCambioPag = 1;
							
							if ($POST_Moneda<>$EmpresaMonedaId){
								
								$InsTipoCambio = new ClsTipoCambio();
								$InsTipoCambio->MonId = $POST_Moneda;
								$InsTipoCambio->TcaFecha = $DatPago->PagFecha;
								$InsTipoCambio->MtdObtenerTipoCambioFecha();
								
								if(empty($InsTipoCambio->TcaId)){
								
									$InsTipoCambio->MtdObtenerTipoCambioUltimo();
								
								}
								
								$TipoCambioPag = $InsTipoCambio->TcaMontoVenta;
								
							}
							
                        ?>
                        	
							<?php $DatPago->PagMonto = (($DatPago->PagMonto/(empty($DatPago->PagTipoCambio)?1:$DatPago->PagTipoCambio)));?>
                          
                          	<?php
							if($DatPago->MonId == $POST_Moneda){
							?>	      
                            	<?php
								if($p>1){
								?>                      
								
								<?php $TotalOrdenVentaVehiculoOtroAbono += $DatPago->PagMonto;?>   
                                
								<?php
								}
								?>
                            <?php
							}else{								
								$DatPago->PagMonto = $MontoUltimoAbonoLocal/$TipoCambioPag;								
							?>   
                              	<?php
								if($p>1){
								?>                      
             
									<?php $TotalOrdenVentaVehiculoOtroAbono += $DatPago->PagMonto;?> 
                                
                                <?php
								}								
								?>
                                
                            <?php	
							}
							?>

                            
                            <?php
							if($p==1){
								
								$TotalOrdenVentaVehiculoInicial = $DatPago->PagMonto;
								$FechaUltimoAbono = $DatPago->PagFecha;
								$MonedaUltimoAbono = $DatPago->MonSimbolo;
								$TipoCambioUltimoAbono = $TipoCambioPag;
								
								
							}
							
                            
							//
                            ?>
                            
                            
                        <?php
							$p++;	
                        }
                        ?>
                    
                     
                    <?php
					$TotalOrdenVentaVehiculoPendiente = $DatOrdenVentaVehiculo->OvvTotal - $TotalOrdenVentaVehiculoInicial - $TotalOrdenVentaVehiculoOtroAbono;
					?>
                    
                    
                    <?php
                    //$TotalAbonado += $TotalAbono;
					$SumaTotalOrdenVentaVehiculoInicial += $TotalOrdenVentaVehiculoInicial;
					$SumaTotalOrdenVentaVehiculoOtroAbono += $TotalOrdenVentaVehiculoOtroAbono;
					$SumaTotalOrdenVentaVehiculoPendiente += $TotalOrdenVentaVehiculoPendiente;
                    ?>
                    
                   
                    
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   ><!--<a target="_blank" href="../../principal.php?Mod=OrdenVentaVehiculo&Form=VerEstado&Id=<?php echo ($DatOrdenVentaVehiculo->OvvId);?>">-->
                  <?php echo ($DatOrdenVentaVehiculo->SucNombre);?>
                  <!--</a>--></td>
                <td  align="right" valign="top"   >
				<!--<a target="_blank" href="../../principal.php?Mod=OrdenVentaVehiculo&Form=VerEstado&Id=<?php echo ($DatOrdenVentaVehiculo->OvvId);?>">-->
				<?php echo ($DatOrdenVentaVehiculo->OvvId);?>
                <!--</a>-->
                </td>
                <td  align="right" valign="top"   ><?php echo ($DatOrdenVentaVehiculo->OvvTiempoSolicitudEnvio);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatOrdenVentaVehiculo->CliNombre);?> <?php echo ($DatOrdenVentaVehiculo->CliApellidoPaterno);?> <?php echo ($DatOrdenVentaVehiculo->CliApellidoMaterno);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->VmaNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->VmoNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->VveNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->EinAnoFabricacion);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->EinAnoModelo);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->EinVIN);?></td>
                <td align="right" valign="top"  >
					
				
				<?php echo ($DatOrdenVentaVehiculo->PerNombreVendedor);?> <?php echo ($DatOrdenVentaVehiculo->PerApellidoPaternoVendedor);?> <?php echo ($DatOrdenVentaVehiculo->PerApellidoMaternoVendedor);?></td>
                <td align="right" valign="top"  ><?php //echo ($DatOrdenVentaVehiculo->MonSimbolo);?></td>
                <td align="right" valign="top"  >
                
                   <?php
				
				if($TipoCambioOVV<>1){
				?>
                <?php echo ($TipoCambioOVV);?>
                <?php
				}
				?>
               
                </td>
                <td align="right" valign="top"  ><?php echo number_format($DatOrdenVentaVehiculo->OvvTotal,2);?></td>
                <td align="right" valign="top"  ><?php echo ($FechaUltimoAbono);?></td>
                <td align="right" valign="top"  ><?php echo number_format($TotalOrdenVentaVehiculoInicial,2);?></td>
                <td align="right" valign="top"  ><?php echo number_format($TotalOrdenVentaVehiculoOtroAbono,2);?></td>
                <td align="right" valign="top"  >
				
				<?php echo number_format($TotalOrdenVentaVehiculoPendiente,2);?></td>
          </tr>
		<?php	
		//	$OrdenVentaVehiculoSumaTotal += $DatOrdenVentaVehiculo->OvvTotal;
		?>
  		
      
      
              
        <?php
		 $c++;
		 	}
        }
        ?>
        
          </tbody>
		<tfoot class="EstTablaReporteFoot">
        
        
                  <tr>
                      <td  align="right" valign="middle"   >&nbsp;</td>
                      <td  align="right" valign="top"   >&nbsp;</td>
                      <td  align="right" valign="top"   >&nbsp;</td>
                      <td  align="right" valign="top"   >&nbsp;</td>
                      <td  align="right" valign="top"   >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  ><?php echo number_format($SumaTotalOrdenVentaVehiculo,2);?></td>
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  ><?php echo number_format($SumaTotalOrdenVentaVehiculoInicial,2);?></td>
                      <td align="right" valign="top"  ><?php echo number_format($SumaTotalOrdenVentaVehiculoOtroAbono,2);?></td>
                      <td align="right" valign="top"  ><?php echo number_format($SumaTotalOrdenVentaVehiculoPendiente,2);?></td>
          </tr>
          
		</tfoot>
		</table>
                    
          
       
     

