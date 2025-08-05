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
        


$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/01/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
//$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_VehiculoMarca = ($_GET['VehiculoMarca']);
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Personal = ($_GET['Personal']);

//if(empty($POST_VehiculoMarca)){
//	die("No ha escogido una marca de vehiculo");
//} 

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
 
 require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
 
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsPago = new ClsPago();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
 
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];
//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 

$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,$POST_Moneda,$POST_Personal,$POST_ClienteId,$POST_ConCotizacion);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];

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
          <td width="54%" align="center" valign="top">REPORTE DE PAGOS VENTA DE VEHICULOS</td>
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
                    
          
       
     

