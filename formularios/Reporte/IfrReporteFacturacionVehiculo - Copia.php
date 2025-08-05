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
        


$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m")."/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
//$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_VehiculoMarca = ($_GET['VehiculoMarca']);
$POST_Sucursal = ($_GET['Sucursal']);
$POST_CostoDetalle = ($_GET['CostoDetalle']);

//deb($POST_Mes);
//if(empty($POST_VehiculoMarca)){
//	die("No ha escogido una marca de vehiculo");
//} 

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqReporte().'ClsReporteFacturacion.php');
 require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');


$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();

$InsReporteFacturacion = new ClsReporteFacturacion();

//$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
//$InsVehiculoMarca->MtdObtenerVehiculoMarca();
// 
////MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
//$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
//$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];
//
//$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
//$ArrSucursales = $RepSucursal['Datos'];

//MtdObtenerFacturaVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RfaComprobanteFecha',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVehiculoMarca=NULL)
$ResReporteFacturacion = $InsReporteFacturacion->MtdObtenerFacturaVehiculos(NULL,NULL,NULL,'RfaComprobanteFecha','ASC','',$POST_Sucursal,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,NULL,NULL,$POST_VehiculoMarca);
$ArrReportesFacturas = $ResReporteFacturacion['Datos'];
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
          <td width="54%" align="center" valign="top">RESUMEN DE FACTURACION DE VEHICULOS</td>
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
          <th width="2%" rowspan="2">#</th>
          <th colspan="8">COMPROBANTE</th>
          
          <?php
		  if($POST_CostoDetalle == "Si"){
		?>
         <th colspan="4" align="center">COSTOS</th>
        <?php	  
		  }
		  ?>
         
          
          <th colspan="8" align="center">VEHICULO</th>
          <th colspan="3" align="center">NOTA DE CREDITO</th>
          </tr>
        <tr>
          <th width="8%">SERIE</th>
          <th width="8%">CORRELATIVO</th>
          <th width="11%" align="center">FECHA</th>
          <th width="11%" align="center">MON.</th>
          <th width="11%" align="center">TOTAL</th>
          <th width="8%">TIPO CLI.</th>
          <th width="8%">NUM. DOC.</th>
          <th width="25%">CLIENTE</th> <?php
		  if($POST_CostoDetalle == "Si"){
		?>
          <th width="2%" align="center">NUM. CP.</th>
          <th width="3%" align="center">FEC.</th>
          <th width="3%" align="center">MON.</th>
          <th width="3%" align="center">VALOR</th>
          <?php
		  }
		  ?>
          <th width="5%" align="center">MARCA</th>
          <th width="5%" align="center">MODELO</th>
          <th width="5%" align="center">VERSION</th>
          <th width="5%" align="center">VIN</th>
          <th width="5%" align="center">COLOR </th>
          <th width="5%" align="center">AÑO FAB.</th>
          <th width="5%" align="center">AÑO MOD.</th>
          <th width="5%" align="center">ASESOR VENTAS</th>
          <th width="5%" align="center">NC SERIE</th>
          <th width="5%" align="center">NC CORRELATIVO</th>
          <th width="5%" align="center">NC MOTIVO </th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$ReporteFacturacionSumaTotal = 0;
		$TotalFacturado = 0;
		$TotalAbonado = 0;
		
		$c=1;
        foreach($ArrReportesFacturas as $DatReporteFacturacion){



			
        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteFacturacion->RfaComprobanteSerie);?></td>
                <td  align="right" valign="top"   >&nbsp; <?php echo ($DatReporteFacturacion->RfaComprobanteId);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->RfaComprobanteFecha);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->MonSimbolo);?></td>
                <td align="right" valign="top"  ><?php echo round($DatReporteFacturacion->RfaComprobanteTotal,2);?></td>
                <td  align="right" valign="top"   >
				
				<?php echo (empty($DatReporteFacturacion->LtiAbreviatura)?$DatReporteFacturacion->LtiNombre:$DatReporteFacturacion->LtiAbreviatura)//FncCortarTexto($DatReporteFacturacion->LtiNombre,15);?>
				<?php //echo ($DatReporteFacturacion->LtiNombre);;?></td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteFacturacion->CliNumeroDocumento);?></td>
                <td  align="right" valign="top"   >
                
               
               
                <?php echo ($DatReporteFacturacion->CliNombre);?>
                <?php echo ($DatReporteFacturacion->CliApellidoPaterno);?>
                <?php echo ($DatReporteFacturacion->CliApellidoMaterno);?>
               
                </td>
                
                 <?php
		  if($POST_CostoDetalle == "Si"){
		?>
                <td align="right" valign="top"  >
                
                <?php echo ($DatReporteFacturacion->EinComprobanteCompraNumero);?>
                
                
                </td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->EinComprobanteCompraFecha);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->MonSimboloIngreso);?></td>
                <td align="right" valign="top"  ><?php echo round($DatReporteFacturacion->EinCostoIngresoReal,2);?></td>
                
                <?php
		  }
				?>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->VmaNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->VmoNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->VveNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->EinVIN);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->EinColor);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->EinAnoFabricacion);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->EinAnoModelo);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->PerNombre);?> <?php echo ($DatReporteFacturacion->PerApellidoPaterno);?> <?php echo ($DatReporteFacturacion->PerApellidoMaterno);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->RfaNotaCreditoSerie);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->RfaNotaCreditoId);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteFacturacion->RfaNotaCreditoMotivo);?></td>
                    <?php
                    $TotalAbono = 0;
                    $FechaUltimoAbono = "";
					?>
                     
                    
                    <?php
                    $InsPago = new ClsPago();

//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oReporteFacturacion=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL)
                    $ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,'PagId','Desc',NULL,NULL,NULL,$DatReporteFacturacion->OvvId,NULL,NULL,NULL,NULL,NULL,NULL);
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
          </tr>
		<?php	
			$ReporteFacturacionSumaTotal += $DatReporteFacturacion->OvvTotal;
		?>
  		
      
      
              
        <?php
		 $c++;
        }
        ?>
        
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            
                 <?php
		  if($POST_CostoDetalle == "Si"){
		?>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <?php
		  }
			?>
            
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
                    
          
       
     

