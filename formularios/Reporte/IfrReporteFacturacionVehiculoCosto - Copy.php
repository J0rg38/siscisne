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
	header("Content-Disposition:  filename=\"REPORTE_FACTURACION_VEHICULO_".date('d-m-Y').".xls\";");
}


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

require_once($InsPoo->MtdPaqReporte().'ClsReporteVehiculoMovimientoEntrada.php');
 require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');


$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();

$InsReporteVehiculoMovimientoEntrada = new ClsReporteVehiculoMovimientoEntrada();
 
//MtdObtenerReporteVehiculoMovimientoEntradas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL,$oTipo=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="VmvComprobanteFecha")
$ResReporteVehiculoMovimientoEntrada = $InsReporteVehiculoMovimientoEntrada->MtdObtenerReporteVehiculoMovimientoEntradas(NULL,NULL,NULL,'VmvComprobanteFecha','ASC','',NULL,3,NULL,NULL,$POST_Sucursal,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"VmvComprobanteFecha");
$ArrReporteVehiculoMovimientoEntradas = $ResReporteVehiculoMovimientoEntrada['Datos'];
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
          <td width="54%" align="center" valign="top">REPORTE DE COMPROBANTES DE COMPRA DE VEHICULOS</td>
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
          <th width="8%">FECHA</th>
          <th width="8%">FACTURA</th>
          <th width="5%" align="center">VIN</th>
          <th width="7%" align="center">MARCA</th>
          <th width="8%" align="center">MODELO</th>
          <th width="8%" align="center">VERSION</th>
          <th width="7%" align="center">COLOR </th>
          <th width="4%" align="center">AÑO FAB.</th>
          <th width="5%" align="center">AÑO MOD.</th>
          <th width="10%" align="center">MON.</th>
          <th width="10%" align="center">CANCELADO</th>
          <th width="7%" align="center">COSTO</th>
          <th width="11%" align="center">COSTO C/ IGV</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$ReporteVehiculoMovimientoEntradaSumaTotal = 0;
		$ReporteVehiculoMovimientoEntradaSumaTotalImpuesto = 0;

		
		$c=1;
        foreach($ArrReporteVehiculoMovimientoEntradas as $DatReporteVehiculoMovimientoEntrada){



			
        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteVehiculoMovimientoEntrada->VmvComprobanteFecha);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatReporteVehiculoMovimientoEntrada->VmvComprobanteNumero);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteVehiculoMovimientoEntrada->EinVIN);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteVehiculoMovimientoEntrada->VmaNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteVehiculoMovimientoEntrada->VmoNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteVehiculoMovimientoEntrada->VveNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteVehiculoMovimientoEntrada->EinColor);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteVehiculoMovimientoEntrada->EinAnoFabricacion);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteVehiculoMovimientoEntrada->EinAnoModelo);?></td>
                <td align="right" valign="top"  ><?php echo ($DatReporteVehiculoMovimientoEntrada->MonSimbolo);?></td>
                <td align="right" valign="top"  ><?php
				switch($DatReporteVehiculoMovimientoEntrada->EinCancelado){
					case 1:
				?>
                  Si
                  <?php	
					break;
					
					case 2:
				?>
                  No
  <?php	
					break;
					
					default:
				?>
                  -
  <?php	
					break;
				}
			
				?></td>
                <td align="right" valign="top"  ><?php echo number_format($DatReporteVehiculoMovimientoEntrada->EinCostoIngresoReal,2);?></td>
                <td align="right" valign="top"  ><?php echo number_format($DatReporteVehiculoMovimientoEntrada->EinCostoIngresoImpuestoReal,2);?></td>
          </tr>
		<?php	
			$ReporteVehiculoMovimientoEntradaSumaTotal += $DatReporteVehiculoMovimientoEntrada->EinCostoIngresoReal;
			$ReporteVehiculoMovimientoEntradaSumaTotalImpuesto += $DatReporteVehiculoMovimientoEntrada->EinCostoIngresoImpuestoReal;
		?>
  		
      
      
              
        <?php
		 $c++;
        }
        ?>
        
          
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot"><tr>
            <td colspan="12" align="right">
            
          
            TOTALES:
            
            </td>
            <td align="right">
			<?php echo number_format($ReporteVehiculoMovimientoEntradaSumaTotal,2);?>
            </td>
            <td align="right">
			
			
			<?php echo number_format($ReporteVehiculoMovimientoEntradaSumaTotalImpuesto,2);?>
          
            </td>
          </tr>
		</tfoot>
		</table>
                    
          
       
     

