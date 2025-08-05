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
        


$POST_Ano = ($_GET['Ano'])?$_GET['Ano']:date("Y");
$POST_Mes = isset($_GET['Mes'])?$_GET['Mes']:date("m");
$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_Sucursal = ($_GET['Sucursal']);



require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsSucursalMeta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCierreInventario.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
 
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoCierreInventario = new ClsVehiculoCierreInventario();
$InsVehiculoIngreso = new ClsVehiculoIngreso();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
 
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];
//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 


//MtdObtenerVehiculoIngresoAnoFabricaciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10') {
$ResVehiculoIngresoAno = $InsVehiculoIngreso->MtdObtenerVehiculoIngresoAnoFabricaciones(NULL,NULL,NULL,'EinAnoFabricacion','ASC',NULL);
$ArrVehiculoIngresoAnos = $ResVehiculoIngresoAno['Datos'];
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
          <td width="54%" align="center" valign="top">REPORTE MOS</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		<?php
		
		?>
                     
                    <table class="EstTablaReporte" width="100%">
                  
                    <tr>
                      <td width="864" colspan="4" align="center">
                  
                  
<?php
if(!empty($ArrVehiculoIngresoAnos)){
	foreach($ArrVehiculoIngresoAnos as $DatVehiculoIngresoAno){
?>
  	<?php
echo 	$DatVehiculoIngresoAno->EinAnoFabricacion;
	?><br />
                    <table width="500" cellpadding="2" cellspacing="2" class="EstTablaReporte">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                      <th>MODELO</th>
                      <th align="center">STK. INIC.</th>
                      <th align="center">RT</th>
                      
					
                    		 <th align="center">WS</th>
                   
                     <th width="80"  align="center">STK. FINAL</th>
                     
                      
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                    
                    <?php
					$SumaTotalStockInicial = 0;
					$SumaTotalRT = 0;
					$SumaTotalWS = 0;
					$SumaTotalStockFinal = 0;
					
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
							
							$MostrarModelo = true;
							
							if($MostrarModelo){
							
					?>
                    
<?php
//MtdObtenerVehiculoCierreInventarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VciId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAno=NULL,$oMes=NULL,$oVehiculoVersionId=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL)
$ResVehiculoCierreInventario = $InsVehiculoCierreInventario->MtdObtenerVehiculoCierreInventarios(NULL,NULL,NULL,'VciMes','ASC',NULL,1,$POST_Ano,$POST_Mes,$DatVehiculoVersion->VveId,$DatVehiculoIngresoAno->EinAnoFabricacion,NULL);
$ArrVehiculoCierreInventarios = $ResVehiculoCierreInventario['Datos'];

$StockInicial[$DatVehiculoVersion->VveId] = 0;

if(!empty($ArrVehiculoCierreInventarios)){
	foreach($ArrVehiculoCierreInventarios as $DatVehiculoCierreInventario){
			$StockInicial[$DatVehiculoVersion->VveId] = $DatVehiculoCierreInventario->VciCantidad+1-1;
	}
}

?>
<?php

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL)
$OrdeneVentaVehiculoTotal[$DatVehiculoVersion->VveId] = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'OvvId','ASC',NULL,NULL,NULL,array(2,3,4,5),NULL,NULL,NULL,NULL,NULL,$DatVehiculoVersion->VveId,$DatVehiculoIngresoAno->EinAnoFabricacion);
?>


<?php
$InsVehiculoIngreso = new ClsVehiculoIngreso();
//MtdObtenerVehiculoIngresosValor($oFuncion="SUM",$oParametro="EinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oConcesionario=NULL) 
$TotalCompras[$DatVehiculoVersion->VveId] = $InsVehiculoIngreso->MtdObtenerVehiculoIngresosValor("COUNT","ein.EinId",$POST_Mes,$POST_Ano,NULL,NULL,NULL,'EinComprobanteCompraFecha','Desc','1',1,NULL,NULL,NULL,NULL,NULL,$DatVehiculoVersion->VveId,NULL,$DatVehiculoIngresoAno->EinAnoFabricacion,NULL,NULL,"EinComprobanteCompraFecha",NULL,NULL,NULL,NULL);
?>
						<?php
						if($StockInicial[$DatVehiculoVersion->VveId]>0 || $OrdeneVentaVehiculoTotal[$DatVehiculoVersion->VveId]>0 || $TotalCompras[$DatVehiculoVersion->VveId]>0 ){
						?>
                        
                       
							<tr>
                            
                            <td >
                               
                               <?php echo $DatVehiculoVersion->VmoNombre;?>
                               
                               <?php echo $DatVehiculoVersion->VveNombre;?>
                            </td>
                            <td width="50" align="right" >
<?php $SumaTotalStockInicial+= $StockInicial[$DatVehiculoVersion->VveId];?>


<?php echo $StockInicial[$DatVehiculoVersion->VveId];?>
                            </td>
                            <td width="50" align="right" >
                            

<?php $SumaTotalRT+= $OrdeneVentaVehiculoTotal[$DatVehiculoVersion->VveId];?>
 <?php echo $OrdeneVentaVehiculoTotal[$DatVehiculoVersion->VveId];?>                           
                            </td>
                             
                             
                      
                  		
                         <td width="50" align="right" >

<?php $SumaTotalWS+= $TotalCompras[$DatVehiculoVersion->VveId];?>
						<?php echo $TotalCompras[$DatVehiculoVersion->VveId];?>                         
                        
                         </td>
                        
                    
                        <?php		
							
						?>
                   		<td width="80" align="right">


						<?php
$StockFinal[$DatVehiculoVersion->VveId] = $StockInicial[$DatVehiculoVersion->VveId] - $OrdeneVentaVehiculoTotal[$DatVehiculoVersion->VveId] + $TotalCompras[$DatVehiculoVersion->VveId];
                        ?>  
                        
<?php $SumaTotalStockFinal+= $StockFinal[$DatVehiculoVersion->VveId];?>
						<?php echo $StockFinal[$DatVehiculoVersion->VveId];?>   

                      </td>
                    
							</tr>
                        
                    	 <?php
						}
						?>
                        
                    <?php
							}		
						}
					}
					?>
                        
                        
                        
                       
                        <tr>
                          <td class="EstTablaReporteColumnaEspecial4">Total General:</td>
                          <td width="50"   align="right" class="EstTablaReporteColumnaEspecial4">
                          
                          <?php echo $SumaTotalStockInicial;?>
                          
                          </td>
                          <td width="50"   align="right" class="EstTablaReporteColumnaEspecial4">
                          
                          <?php echo $SumaTotalRT;?>
                          
                          </td>
                          <td width="50"   align="right" class="EstTablaReporteColumnaEspecial4">
                          
                          <?php echo $SumaTotalWS;?>
                          
                          </td>
                          <td width="80" align="right"  class="EstTablaReporteColumnaEspecial4">
                          
                          <?php echo $SumaTotalStockFinal;?>
                          
                          </td>
                        </tr>
                       
                      </tbody>
                    </table>
<?php		
	}
}
?>  
                  
                    
                   </td>
                    </tr>
                    
                      <tr>
                        <td  align="center"></td>
                      </tr>
                      <tr>
                      <td >&nbsp;</td>
                    </tr>
                    </table>
                    
          
       
     

