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
	header("Content-Disposition:  filename=\"REPORTE_VENTA_VEHICULOS_ENTREGA_".date('d-m-Y').".xls\";");
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

$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"OvvFechaEntrega";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";

$POST_Personal = "";

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
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();
 $InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();

$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();
////MtdObtenerReporteOrdenVentaVehiculoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor",$oDiasTranscurridos=0,$oFecha="IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)") 
$ResReporteOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerReporteOrdenVentaVehiculoEntregas(NULL,NULL,NULL,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_VehiculoMarca,$POST_Sucursal,$POST_IncluirCSI,"Igual",$POST_DiasTranscurridos,"IFNULL(ovv.OvvActaEntregaFecha,ovv.OvvActaEntregaFechaPDS)");
$ArrReporteOrdenVentaVehiculos = $ResReporteOrdenVentaVehiculo['Datos'];


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
          <td width="54%" align="center" valign="top">REPORTE DE ENTREGA DE VEHICULOS</td>
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
          <th width="7%">NUM. COMPROB.</th>
          <th width="7%">FECHA ENTREGA (POST VENTA)</th>
          <th width="14%">FECHA ENTREGA (VENTAS)</th>
          <th width="14%">CLIENTE</th>
          <th width="7%" align="center">TELEFONO</th>
          <th width="7%" align="center">CELULAR</th>
          <th width="5%" align="center">EMAIL</th>
          <th width="5%" align="center">MARCA</th>
          <th width="6%" align="center">MODELO</th>
          <th width="6%" align="center">VERSION</th>
          <th width="5%" align="center">COLOR</th>
          <th width="3%" align="center">VIN</th>
          <th width="10%" align="center">ASESOR DE VENTAS</th>
          <th width="10%" align="center">1ERA O.T.</th>
          <th width="10%" align="center">FECHA OT</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$OrdenVentaVehiculoSumaTotal = 0;
		$TotalFacturado = 0;
		$TotalAbonado = 0;
		
		$c=1;
        foreach($ArrReporteOrdenVentaVehiculos as $DatOrdenVentaVehiculo){



			
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
                <td  align="right" valign="top"   >
                
                   <?php
				switch($DatOrdenVentaVehiculo->OvvComprobanteVenta){
					case "F":
				?>
				<?php echo $DatOrdenVentaVehiculo->OvvFacturaNumero?></a>
 
				  <?php	
					break;
					
					case "B":
				?>
               <?php echo $DatOrdenVentaVehiculo->OvvBoletaNumero?>
                  <?php	
					break;
					
					default:
				?>-
                  <?php	
					break;
				}
				?>
                  
                  
                  </td>
                <td  align="right" valign="top"   >
			
            	
					<?php echo $DatOrdenVentaVehiculo->OvvActaEntregaFechaPDS;  ?>
            
                
                </td>
                <td  align="right" valign="top"   ><?php echo $DatOrdenVentaVehiculo->OvvActaEntregaFecha;  ?></td>
                <td  align="right" valign="top"   ><?php echo ($DatOrdenVentaVehiculo->CliNombre);?> <?php echo ($DatOrdenVentaVehiculo->CliApellidoPaterno);?> <?php echo ($DatOrdenVentaVehiculo->CliApellidoMaterno);?></td>
                <td align="right" valign="top"  ><?php echo $DatOrdenVentaVehiculo->CliTelefono;  ?></td>
                <td align="right" valign="top"  ><?php echo $DatOrdenVentaVehiculo->CliCelular;  ?></td>
                <td align="right" valign="top"  ><?php echo $DatOrdenVentaVehiculo->CliEmail;  ?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->VmaNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->VmoNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->VveNombre);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->EinColor);?></td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->EinVIN);?></td>
                <td align="right" valign="top"  ><?php echo $DatOrdenVentaVehiculo->PerNombre;?> <?php echo $DatOrdenVentaVehiculo->PerApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculo->PerApellidoMaterno;?></td>
                <td align="right" valign="top"  >
                
                <?php echo ($DatOrdenVentaVehiculo->FinIdPrimera);?>
                
               
                
                </td>
                <td align="right" valign="top"  ><?php echo ($DatOrdenVentaVehiculo->FinFechaPrimera);?></td>
          </tr>
		
      
      
              
        <?php
		 $c++;
        }
        ?>
        
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
                    
          
       
     

