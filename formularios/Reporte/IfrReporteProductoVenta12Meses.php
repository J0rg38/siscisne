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
	header("Content-Disposition:  filename=\"REPORTE_VENTA_REPUESTOS_12MESES_".date('d-m-Y').".xls\";");
}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_Ano = isset($_GET['Ano'])?$_GET['Ano']:date("Y");
$POST_Sucursal = ($_GET['Sucursal']);
$POST_VehiculoMarca = ($_GET['VehiculoMarca']);

$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"RprCantidad";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";


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
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProductoVenta.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();
 $InsReporteProducto = new ClsReporteProducto();


$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();

$InsProducto = new ClsProducto();

////MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL) {
//$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,1,$POST_ProductoTipo,1,NULL,NULL,NULL,NULL,false,$POST_Referencia,NULL,0,$POST_ProductoCategoria,false,NULL,NULL);
//$ArrProductos = $ResProducto['Datos'];

$FechaInicio = "01/01/".$POST_Ano;
$FechaFin = "31/12/".$POST_Ano;

//MtdObtenerReporteProductoVentas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentas(NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,NULL,$POST_ord,$POST_sen,NULL,$POST_VehiculoMarca,$POST_Sucursal);
$ArrProductos = $ResReporteProducto['Datos'];


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
          <td width="54%" align="center" valign="top">REPORTE DE VENTA DE REPUESTOS 12 MESES</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		<?php
		
		?>
                     
                    <table width="100%"  border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th >#</th>
          <th>ID</th>
          <th>CODIGO ORIGINAL</th>
          <th>NOMBRE</th>
          <th>U.M.</th>
          
          <?php
		  for($mes=1;$mes<=12;$mes++){
		  ?>
          <th  align="center"><?php echo FncConvertirMes($mes);?></th>
          
          <?php
		  }
		  ?>
          <th align="center">TOTAL ANUAL</th>
            <th align="center">PROM. MENSUAL</th>
            
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		
		
		$c=1;
        foreach($ArrProductos as $DatProducto){

		
			$TotalProductoAnual = 0;
			$PromedioMensual = 0;
        ?>
       
     
                         
                    
        
                  <tr id="Fila_<?php echo $c;?>">
                <td  align="right" valign="middle"   ><?php echo $c;?></td>
                <td  align="right" valign="top"   ><?php echo ($DatProducto->ProId);?></td>
                <td  align="right" valign="top"   >
                  <?php echo ($DatProducto->ProCodigoOriginal);?>
                </td>
                <td  align="right" valign="top"   ><?php echo ($DatProducto->ProNombre);?></td>
                <td  align="right" valign="top"   ><?php echo ($DatProducto->UmeAbreviacion);?></td>
                
                  <?php
		  for($mes=1;$mes<=12;$mes++){
		  ?>
                <td  align="right" valign="top"  >
				
				<?php
				//$InsReporteProductoVenta = new ClsReporteProductoVenta();
				//MtdObtenerReporteProductoVentaValor($oFuncion="SUM",$oParametro="AmdId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
				//$TotalProductoVentaMensual = $InsReporteProductoVenta->MtdObtenerReporteProductoVentaValor("SUM","AmdCantidad",$mes,$POST_Ano,NULL,NULL,NULL,'AmdId','Desc','1',$POST_Sucursal,NULL,NULL);
				
				$TotalMensual[$mes] = $InsReporteProducto->MtdObtenerReporteProductoVentasMensual($DatProducto->ProId,$POST_Ano,$mes,$POST_VehiculoMarca,$POST_Sucursal);
							
				?>
                
                <?php //echo number_format($TotalProductoVentaMensual,2);?>
                 <?php echo number_format($TotalMensual[$mes],2);?>
                
                </td>
               
                
                  <?php
				  
				  $TotalProductoAnual += $TotalMensual[$mes];
		  }

		   $PromedioMensual  = ($TotalProductoAnual/12);
		   
		  ?>
          
           <td align="right"><?php echo number_format($TotalProductoAnual,2);?></td>
           
          <?php
		 // $PromedioMensual  = ($TotalProductoAnual/12);
		  ?>
           <td align="right"><?php echo number_format($PromedioMensual,2);?></td>
          </tr>
		
  		
      
      
              
        <?php
		 $c++;
		 	
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
                    
                      
                          <?php
		  for($mes=1;$mes<=12;$mes++){
		  ?>
            <td align="right" valign="top"  >&nbsp;</td>
           
          <?php
		  }
		  ?>
                      <td align="right" valign="top"  >&nbsp;</td> 
                      
                  <td align="right" valign="top"  >&nbsp;</td>      
          </tr>
          
		</tfoot>
		</table>
                    
          
       
     

