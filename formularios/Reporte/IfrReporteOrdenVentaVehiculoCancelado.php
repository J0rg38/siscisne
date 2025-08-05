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
	header("Content-Disposition:  filename=\"REPORTE_VENTA_VEHICULOS_CANCELADOS_".date('d-m-Y').".xls\";");
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
require_once($InsPoo->MtdPaqReporte().'ClsReporteComprobanteVenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsAsignacionVentaVehiculo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();
 $InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
$InsReporteComprobanteVenta = new ClsReporteComprobanteVenta();

//$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,$POST_Moneda,$POST_Personal,$POST_ClienteId,$POST_ConCotizacion);
//$ArrAsignacionVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];


//MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oConFechaEntrega=false,$oTipoFecha="avv.AvvFecha")
//$ResAsignacionVentaVehiculo = $InsAsignacionVentaVehiculo->MtdObtenerAsignacionVentaVehiculos(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_estado,NULL,true,"ovv.OvvActaEntregaFecha");
//$ArrAsignacionVentaVehiculos = $ResAsignacionVentaVehiculo['Datos'];


//MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oConFechaEntrega=false,$oSucursal=NULL) 
$ResAsignacionVentaVehiculo = $InsReporteComprobanteVenta->MtdObtenerAsignacionVentaVehiculos(NULL,NULL,NULL,"RcvSerie ASC, RcvFecha ASC","",NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,NULL,false,$POST_Sucursal);
$ArrAsignacionVentaVehiculos = $ResAsignacionVentaVehiculo['Datos'];

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
          <td width="54%" align="center" valign="top">REPORTE DE VEHICULOS CANCELADOS</td>
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
          <th width="7%">SUCURSAL</th>
          <th width="8%">ORD. VEN.</th>
          <th width="14%">FECHA ASIGNACION</th>
          <th width="14%">CLIENTE</th>
          <th width="5%" align="center">MARCA</th>
          <th width="6%" align="center">MODELO</th>
          <th width="6%" align="center">VERSION</th>
          <th width="4%" align="center">ANO FAB.</th>
          <th width="4%" align="center">ANO MOD.</th>
          <th width="5%" align="center">COLOR</th>
          <th width="3%" align="center">VIN</th>
          <th width="10%" align="center">NUM. COMPROB.</th>
          <th width="10%" align="center">FEC. COMPROB.</th>
          <th width="10%" align="center">MONEDA COMPROB.</th>
          <th width="10%" align="center">TOTAL COMPROB</th>
          <th width="10%" align="center">TOTAL COMPROB. MONEDA LOCAL</th>
          <th width="10%" align="center">ASESOR DE VENTAS</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		
		$SumaComprobanteTotalMonedaLocal = 0;
		
		$c=1;
        foreach($ArrAsignacionVentaVehiculos as $DatAsignacionVentaVehiculo){
			
			if($DatAsignacionVentaVehiculo->AvvCancelado == "Si" ){
				
				
			
			$ComprobanteFecha = "";
			$ComprobanteNumero = "";
			$ComprobanteTotalMonedaLocal = 0;
			$ComprobanteTotal = 0;
			$ComprobanteMonedaSimbolo = "";
			
			if(!empty($DatAsignacionVentaVehiculo->BolId) and !empty($DatAsignacionVentaVehiculo->BtaId)){
		
				$InsBoleta = new ClsBoleta();
				$InsBoleta->BolId = $DatAsignacionVentaVehiculo->BolId;
				$InsBoleta->BtaId = $DatAsignacionVentaVehiculo->BtaId;
				$InsBoleta = $InsBoleta->MtdObtenerBoleta();
				
				$ComprobanteFecha = $InsBoleta->BolFechaEmision;
				$ComprobanteNumero = $InsBoleta->BtaNumero."-".$InsBoleta->BolId;
				$ComprobanteTotalMonedaLocal = $InsBoleta->BolTotal;
				$ComprobanteMonedaSimbolo = $InsBoleta->MonSimbolo;
				
				$ComprobanteTotal = (($InsBoleta->BolTotal/(empty($InsBoleta->BolTipoCambio)?1:$InsBoleta->BolTipoCambio)));
			}else{
				
				if(!empty($DatAsignacionVentaVehiculo->FacId) and !empty($DatAsignacionVentaVehiculo->FtaId)){
			
					$InsFactura = new ClsFactura();
					$InsFactura->FacId = $DatAsignacionVentaVehiculo->FacId;
					$InsFactura->FtaId = $DatAsignacionVentaVehiculo->FtaId;
					$InsFactura = $InsFactura->MtdObtenerFactura();
					
					$ComprobanteFecha = $InsFactura->FacFechaEmision;
					$ComprobanteNumero = $InsFactura->FtaNumero."-".$InsFactura->FacId;
					$ComprobanteTotalMonedaLocal = $InsFactura->FacTotal;
					$ComprobanteMonedaSimbolo = $InsFactura->MonSimbolo;
					
					$ComprobanteTotal = (($InsFactura->FacTotal/(empty($InsFactura->FacTipoCambio)?1:$InsFactura->FacTipoCambio)));
					
				}
			
			}
			
			
			$SumaComprobanteTotalMonedaLocal += $ComprobanteTotalMonedaLocal;
			
        ?>
        
          
                    <?php
                    $TotalAbono = 0;
                    $FechaUltimoAbono = "";
					$MonedaUltimoAbono = "";
					$MontoUltimoAbono = 0;
					?>
                     
                    
                    <?php
                    $InsPago = new ClsPago();

//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL)
                    $ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,'PagId','DESC',NULL,NULL,NULL,$DatAsignacionVentaVehiculo->OvvId,NULL,NULL,NULL,NULL,NULL,NULL);
                    $ArrPagos = $ResPago['Datos'];
                    ?>
                    
                    
                        <?php
                        foreach($ArrPagos as $DatPago){
                        ?>
                        
                          <?php $DatPago->PagMonto = (($DatPago->PagMonto/(empty($DatPago->PagTipoCambio)?1:$DatPago->PagTipoCambio)));?>
                          
                        <?php //$DatPago->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));?>
                        
                            <?php $TotalAbono += $DatPago->PagMonto;?>
                            
                            <?php
							$MontoUltimoAbono = $DatPago->PagMonto;
                            $FechaUltimoAbono = $DatPago->PagFecha;
							$MonedaUltimoAbono = $DatPago->MonSimbolo;
                            ?>
                        <?php	
                        }
                        ?>
                    
                    <?php
                    $TotalAbonado += $TotalAbono;
                    ?>
        
                  
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   ><!--<a target="_blank" href="../../principal.php?Mod=OrdenVentaVehiculo&Form=VerEstado&Id=<?php echo ($DatAsignacionVentaVehiculo->OvvId);?>">-->
                  <?php echo ($DatAsignacionVentaVehiculo->SucNombre);?>
                  <!--</a>--></td>
                <td  align="right" valign="top"   >
				<!--<a target="_blank" href="../../principal.php?Mod=OrdenVentaVehiculo&Form=VerEstado&Id=<?php echo ($DatAsignacionVentaVehiculo->OvvId);?>">-->
				<?php echo ($DatAsignacionVentaVehiculo->OvvId);?>
                <!--</a>-->
                </td>
                <td  align="right" valign="top"   ><?php echo ($DatAsignacionVentaVehiculo->AvvFecha);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatAsignacionVentaVehiculo->CliNombre);?> <?php echo ($DatAsignacionVentaVehiculo->CliApellidoPaterno);?> <?php echo ($DatAsignacionVentaVehiculo->CliApellidoMaterno);?></td>
                <td align="right" valign="top"  ><?php echo ($DatAsignacionVentaVehiculo->VmaNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatAsignacionVentaVehiculo->VmoNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatAsignacionVentaVehiculo->VveNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatAsignacionVentaVehiculo->EinAnoFabricacion);?></td>
                <td align="right" valign="top"  ><?php echo ($DatAsignacionVentaVehiculo->EinAnoModelo);?></td>
                <td align="right" valign="top"  ><?php echo ($DatAsignacionVentaVehiculo->EinColor);?></td>
                <td align="right" valign="top"  ><?php echo ($DatAsignacionVentaVehiculo->EinVIN);?></td>
                <td align="right" valign="top"  ><?php echo ($ComprobanteNumero);?>
                
                
                </td>
                <td align="right" valign="top"  ><?php echo ($ComprobanteFecha);?></td>
                <td align="right" valign="top"  ><?php echo ($ComprobanteMonedaSimbolo);?></td>
                <td align="right" valign="top"  ><?php echo number_format($ComprobanteTotal,2);?></td>
                <td align="right" valign="top"  ><?php echo number_format($ComprobanteTotalMonedaLocal,2);?></td>
                <td align="right" valign="top"  ><?php echo $DatAsignacionVentaVehiculo->PerNombreVendedor;?> <?php echo $DatAsignacionVentaVehiculo->PerApellidoPaternoVendedor;?> <?php echo $DatAsignacionVentaVehiculo->PerApellidoMaternoVendedor;?></td>
          </tr>
		<?php	
		
			$SumaComprobanteTotalMonedaLocal += $ComprobanteTotalMonedaLocal;
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
                      <td align="right" valign="top"  >&nbsp;</td>
                      <td align="right" valign="top"  >TOTAL VEHICULOS CANCELADOS MONEDA LOCAL:</td>
                      <td align="right" valign="top"  ><?php echo number_format($SumaComprobanteTotalMonedaLocal,2);?></td>
                      <td align="right" valign="top"  >&nbsp;</td>
          </tr>
		</tfoot>
		</table>
                    
          
       
     

