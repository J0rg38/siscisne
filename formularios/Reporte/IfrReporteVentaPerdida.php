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
	header("Content-Disposition:  filename=\"REPORTE_VENTAS_PERDIDAS_REPUESTOS_".date('d-m-Y').".xls\";");
}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        


$POST_FechaInicio = isset($_GET['CmpFechaInicio'])?$_GET['CmpFechaInicio']:"01/01/".date("Y");
$POST_FechaFin = isset($_GET['CmpFechaFin'])?$_GET['CmpFechaFin']:date("d/m/Y");
//$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_VehiculoMarca = $_GET['CmpVehiculoMarca'];
$POST_Sucursal = ($_GET['CmpSucursal']);
$POST_Vista = ($_GET['CmpVista']);
$POST_Personal = ($_GET['CmpPersonal']);

  

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
 require_once($InsPoo->MtdPaqReporte().'ClsReporteVentaPerdidaProducto.php');
 require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
 require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
 
 
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsReporteProducto = new ClsReporteProducto();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
 
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];



$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoNombre','ASC',NULL,$POST_VehiculoMarca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];



$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];
//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 

$PersonalNombre = "";

if(!empty($POST_Personal)){
	
	$InsPersonal = new ClsPersonal();
	$InsPersonal->PerId = $POST_Personal;
	$InsPersonal->MtdObtenerPersonal();
	
	$PersonalNombre = $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno;
	

}


//MtdObtenerVentaPerdidaProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CrdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacion=NULL,$oEstado=NULL,$oProducto=NULL,$oSucursal=NULL)
//$InsReporteVentaPerdidaProducto = new ClsReporteVentaPerdidaProducto();
//$ResCotizacionProductoDetalle =  $InsReporteVentaPerdidaProducto->MtdObtenerVentaPerdidaProductos(NULL,NULL,"CrdId","ASC",NULL,NULL,NULL,NULL,$POST_Sucursal);
//$ArrVentaPerdidaProductos  = 	$ResCotizacionProductoDetalle['Datos'];	
				
//MtdObtenerReporteProductoVentasPerdidas($oProductoId,$oFechaInicio=NULL,$oFechaFin=NULL,$oAno=NULL,$oMes=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
$ResReporteProductoVentasPerdida = $InsReporteProducto->MtdObtenerReporteProductoVentasPerdidas(NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,"cpr.CprFecha","DESC","",$POST_VehiculoMarca,$POST_Sucursal);
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
          <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
        </tr>
        <tr>
          <td width="23%" align="left" valign="top">
		  
		  
		  
            <img src="../../imagenes/logos/logo_reporte.png" width="150"  />
          </td>
          <td width="54%" align="center" valign="top">REPORTE DE VENTAS PERDIDAS DE REPUESTOS</td>
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
          <th width="6%">COT.</th>
          <th width="6%">O.T.</th>
          <th width="6%">CODIGO</th>
          <th width="8%">NOMBRE DEL REPUESTO</th>
          <th width="6%">MARCA</th>
          <th width="6%" align="center">MODELO</th>
          <th width="6%" align="center">VIN</th>
          <th width="5%" align="center">FECHA</th>
          <th width="7%" align="center">MONEDA</th>
          <th width="5%" align="center">PRECIO</th>
          <th width="6%" align="center">CANT.</th>
          <th width="7%" align="center">IMPORTE</th>
          <th width="5%" align="center">COSTO</th>
          <th width="6%" align="center">TIPO DE CAMBIO</th>
          <th width="15%" align="center">MOTIVO POR EL CUAL NO SE VENDIO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$SumaTotalCostoTotal = 0;
		$SumaTotalImporte = 0;
		
		$c=1;
        foreach($ArrReporteProductoVentasPerdidas as $DatVentaPerdidaProducto){

        ?>
           
       
                  <tr id="Fila_<?php echo $c;?>">
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  align="right" valign="middle"   ><?php echo $c;?></td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  align="right" valign="top"   ><?php echo ($DatVentaPerdidaProducto->SucNombre);?></td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  align="right" valign="top"   ><?php echo ($DatVentaPerdidaProducto->CprId);?></td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  align="right" valign="top"   ><?php echo ($DatVentaPerdidaProducto->FinId);?></td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  align="right" valign="top"   >
				
				<?php echo ($DatVentaPerdidaProducto->ProCodigoOriginal);?>
               
                </td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  align="right" valign="top"   >
                
                

	<?php echo ($DatVentaPerdidaProducto->ProNombre);?>

                
           
                </td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  align="right" valign="top"   >
                
				
				
                 
                
                    
                
                 <?php
				if(!empty($DatVentaPerdidaProducto->VmaNombre)){
				?>
              <?php echo ($DatVentaPerdidaProducto->VmaNombre);?>
                <?php	
				}else{
				?>
				 <?php echo ($DatVentaPerdidaProducto->CprMarca);?>
				<?php	
				}
				?>
                
                
                
                </td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"  >
				
				
				
             
                
                
                 <?php
				if(!empty($DatVentaPerdidaProducto->VmoNombre)){
				?>
                <?php echo ($DatVentaPerdidaProducto->VmoNombre);?>
                <?php	
				}else{
				?>
				   <?php echo ($DatVentaPerdidaProducto->CprModelo);?>
				<?php	
				}
				?>
                
                
                </td>
                <td  class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"  >
                
                <?php
				if(!empty($DatVentaPerdidaProducto->EinVIN)){
				?>
                   <?php echo ($DatVentaPerdidaProducto->EinVIN);?>
                <?php	
				}else{
				?>
				 <?php echo ($DatVentaPerdidaProducto->CprVIN);?>
				<?php	
				}
				?>
             
                
               
                
                </td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"  ><?php echo ($DatVentaPerdidaProducto->CprFecha);?>
                </td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"  ><?php echo ($DatVentaPerdidaProducto->MonSimbolo);?></td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"  ><?php echo number_format($DatVentaPerdidaProducto->RprPrecio,2);?></td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"  ><?php echo number_format($DatVentaPerdidaProducto->RprCantidad,2);?></td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"  align="right" valign="top"  ><?php echo number_format($DatVentaPerdidaProducto->RprImporte,2);?></td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"  >
                
                
                <?php

$ProductoListaPrecioCosto = 0;
$ProductoListaPrecioMoneda = "";
?>
                  <?php

	$InsProductoListaPrecio = new ClsProductoListaPrecio();
	$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatVentaPerdidaProducto->ProCodigoOriginal,'PlpTiempoCreacion','DESC',"1",1);
	$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
					
    
    if(!empty($ArrProductoListaPrecios)){
		foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
			$ProductoListaPrecioMoneda = $DatProductoListaPrecio->MonSimbolo;
			$ProductoListaPrecioCosto = $DatProductoListaPrecio->PlpPrecioReal;
		
		}
    }
    ?>
                 <?php echo $ProductoListaPrecioMoneda;?> <?php

echo number_format($ProductoListaPrecioCosto,2);

?>     



</td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"  ><?php echo ($DatVentaPerdidaProducto->CprTipoCambio);?></td>
                <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="top"  >
				
				
				
				<?php echo ($DatVentaPerdidaProducto->CrdObservacion);?>
				<?php echo ($DatVentaPerdidaProducto->CprVentaPerdidaMotivo);?>
                  
                  
                  </td>
                
                    
          </tr>
	
  		
   
      
              
        <?php
		
			$SumaTotalCostoTotal +=$ProductoListaPrecioCosto ;
		$SumaTotalImporte += $DatVentaPerdidaProducto->CrdImporte;
		 $c++;
        }
        ?>
        
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">:</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">TOTALES.</td>
            <td align="right"><?php echo number_format($SumaTotalImporte,2);?></td>
            <td align="right"> <?php echo number_format($SumaTotalCostoTotal,2);?></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
                    
          
       
     

