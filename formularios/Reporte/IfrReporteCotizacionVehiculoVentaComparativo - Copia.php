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
        


//$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/01/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Personal = ($_GET['Personal']);
$POST_Vista = ($_GET['Vista']);

$ArrFechaFin = explode("/",$POST_FechaFin);

list($DiaActual,$MesActual,$AnoActual) = explode("/",$POST_FechaFin);


if($ArrFechaFin[1]=="01"){
	$NuevoMes = 12;
	$NuevoAno = $AnoActual - 1;		
}else{
	$NuevoMes = $MesActual - 1;		
	$NuevoAno = $AnoActual;
	$NuevoMes  = str_pad($NuevoMes,2,0,STR_PAD_LEFT);
}

//$MesActual = $ArrFechaFin[1];
//$AnoActual = $ArrFechaFin[2];

$AnoAnterior = $AnoActual-1;
$AnoTrasAnterior = $AnoActual-2;

$FechaActualInicio = "01/".$MesActual."/".$AnoActual;

$FechaFinComparativoInicio = "01/".$NuevoMes."/".$NuevoAno;
$FechaFinComparativo =$DiaActual."/".$NuevoMes."/".$NuevoAno;

//$FechaFinComparativoAnterior = $DiaActual."/".$NuevoMes."/".$AnoAnterior;

$FechaFinComparativoAnoAnteriorInicio = "01/".$MesActual."/".$AnoAnterior;
$FechaFinComparativoAnoAnteriorFin = $DiaActual."/".$MesActual."/".$AnoAnterior;

$FechaFinComparativoTrasAnoTrasAnteriorInicio = "01/".$MesActual."/".$AnoTrasAnterior;
$FechaFinComparativoTrasAnoTrasAnteriorFin = $DiaActual."/".$MesActual."/".$AnoTrasAnterior;


//deb($POST_Mes);
if(empty($POST_VehiculoMarca)){
die("No ha escogido una marca de vehiculo");
} 

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
 require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
 
 
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
 
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];


$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoNombre','ASC',NULL,$POST_VehiculoMarca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];


$PersonalNombre = "";

if(empty($POST_Personal)){
	$PersonalNombre = "Todos";
}else{
	$InsPersonal->PerId = $POST_Personal;
	$InsPersonal->MtdObtenerPersonal(false);	
	$PersonalNombre = $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno;
}


$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 
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
          <td width="54%" align="center" valign="top">REPORTE DE COMPARATIVO COTIZACIONES DE VEHICULOS VS VENTAS</td>
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
                      <td width="864" colspan="4">
                  
                  
                    
                    
                    
                    
                      </td>
                    </tr>
                    
                      <tr>
                      <td colspan="4" align="center">
                      
                       <?php
					   switch($POST_Vista){
						   case "xVersion":
						?>
                        
                        
                    <?php
					//$CotizacionTotalSucursalActual = 0;
					//$CotizacionTotalSucursalAnterior = 0;
					$CotizacionTotalSucursalActual = array();
					$CotizacionTotalSucursalAnterior = array();
					$CotizacionVehiculoSumaTotal = array();
					
					
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
					
							if(!empty($ArrSucursales)){
								foreach($ArrSucursales as $DatSucursal){
									
									//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,'PerNombre','ASC',NULL,NULL,1,NULL,NULL,NULL,1,NULL,$DatSucursal->SucId);
									//$ArrPersonales = $ResPersonal['Datos'];
						
									//if(!empty($ArrPersonales )){
									//	foreach($ArrPersonales  as $DatPersonal){
									
											//COTIZACIONES						//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL)
											$CotizacionVehiculoTotal = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,$POST_Personal,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
											
											$CotizacionVehiculoAnteriorTotal = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,$POST_Personal,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
											 
											 
											 $CotizacionTotalSucursalActual[$DatSucursal->SucId] += $CotizacionVehiculoTotal;
											 $CotizacionTotalSucursalAnterior[$DatSucursal->SucId] += $CotizacionVehiculoAnteriorTotal;
											 
											 $CotizacionVehiculoSumaTotal[$DatSucursal->SucId] += $CotizacionVehiculoTotal;
											 
											$CotizacionVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId] += $CotizacionVehiculoTotal;
											$CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId] += $CotizacionVehiculoAnteriorTotal;
											
											//ORDENES DE VENTA
											//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL)
											$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,$POST_Personal,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
											
											$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(2,3,4,5),NULL,$POST_Personal,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
											 
											  
											 $OrdenVentaVehiculoTotalSucursalActual[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotal;
											 $OrdenVentaVehiculoTotalSucursalAnterior[$DatSucursal->SucId] += $OrdeneVentaVehiculoAnteriorTotal;
											 
											 $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotal;
											 
											$OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoTotal;
											$OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoAnteriorTotal;
											 
										
									//	}
										
									//}
							
								}
							}
						
						}
					}
					?>
                        
                        
                        
                      
                    
                    
                            <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                   <tr>
                     <th>ASESOR</th>
                     <th colspan="4"><?php echo $PersonalNombre;?></th>
                     </tr>
                   <tr>
                     <th>FECHA</th>
                     <th colspan="2"><?php echo $FechaFinComparativo?></th>
                     <th colspan="2"><?php echo $POST_FechaFin?></th>
                   </tr>
                   <tr>
                     <th>MODELO</th>
                     <th width="80">Cotizaciones</th>
                     <th width="80">Ventas</th>
                     <th width="80">Cotizaciones</th>
                     <th width="80">Ventas</th>
                     </tr>
                    </thead>
                      <tbody class="EstTablaReporteBody">
                        <?php
						$CotizacionTotalActual = 0;
						$CotizacionTotalAnterior = 0;
						
						$OrdenVentaVehiculoTotalActual = 0;
						$OrdenVentaVehiculoTotalAnterior = 0;
						
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
					?>
                    
					
						<?php
                        if($CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]>0 || $CotizacionVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId]>0 || $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]>0 || $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId]>0){
                        ?>
                            
                           <tr>
                             <td><?php echo $DatVehiculoVersion->VmoNombre;?> <?php echo $DatVehiculoVersion->VveNombre;?></td>
                             <td width="80" align="right">
                             
                              <?php
                             $CotizacionTotalAnterior += $CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId];
                             ?>
                            
                           <?php echo ($CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]);?>
                           
                             
                             </td>
                             <td width="80" align="right">
                             
							<?php
                            $OrdenVentaVehiculoTotalAnterior += $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId];
                            ?>
							<?php echo ($OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]);?>
                        
                        </td>
                             <td width="80" align="right"> 
                             
                             <?php
                             $CotizacionTotalActual += $CotizacionVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId];
                             ?>
                              <?php echo ($CotizacionVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId]);?>
                              
                              </td>
                             <td width="80" align="right">
                             
                             <?php
							 $OrdenVentaVehiculoTotalActual += $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId];
							 ?>
							  <?php echo ($OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId]);?>
							  
                      </td>
                             </tr>
                   
							<?php		
							}
							?>
                            
                   <?php
						}
					}
				   ?>
                   
                   
                   <tr>
                     <td class="EstTablaReporteColumnaEspecial4">TOTAL:</td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $CotizacionTotalAnterior;?></td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalAnterior;?></td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $CotizacionTotalActual;?></td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalActual;?></td>
                     </tr>
                   <tr>
                     <td></td> <td width="80" colspan="2" align="right">&nbsp;</td> <td width="80" colspan="2" align="right">&nbsp;</td> 
                   </tr>
                    </tbody>
                    </table>
                   
                        <?php   
						   break;
						   
						   case "xModelo":
						  ?>
                          
                          
                    <?php
					//$CotizacionTotalSucursalActual = 0;
					//$CotizacionTotalSucursalAnterior = 0;
					$CotizacionTotalSucursalActual = array();
					$CotizacionTotalSucursalAnterior = array();
					$CotizacionVehiculoSumaTotal = array();
					
					
					if(!empty($ArrVehiculoModelos)){
						foreach($ArrVehiculoModelos as $DatVehiculoModelo){
					
							if(!empty($ArrSucursales)){
								foreach($ArrSucursales as $DatSucursal){
									
									//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,'PerNombre','ASC',NULL,NULL,1,NULL,NULL,NULL,1,NULL,$DatSucursal->SucId);
									//$ArrPersonales = $ResPersonal['Datos'];
						
									//if(!empty($ArrPersonales )){
									//	foreach($ArrPersonales  as $DatPersonal){
									
											//COTIZACIONES						//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL)
											$CotizacionVehiculoTotal = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,$POST_Personal,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
											
											$CotizacionVehiculoAnteriorTotal = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,$POST_Personal,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
											 
											 
											 $CotizacionTotalSucursalActual[$DatSucursal->SucId] += $CotizacionVehiculoTotal;
											 $CotizacionTotalSucursalAnterior[$DatSucursal->SucId] += $CotizacionVehiculoAnteriorTotal;
											 
											 $CotizacionVehiculoSumaTotal[$DatSucursal->SucId] += $CotizacionVehiculoTotal;
											 
											$CotizacionVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId] += $CotizacionVehiculoTotal;
											$CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId] += $CotizacionVehiculoAnteriorTotal;
											
											//ORDENES DE VENTA
											//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL)
											$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,$POST_Personal,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
											
											$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(2,3,4,5),NULL,$POST_Personal,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
											 
											  
											 $OrdenVentaVehiculoTotalSucursalActual[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotal;
											 $OrdenVentaVehiculoTotalSucursalAnterior[$DatSucursal->SucId] += $OrdeneVentaVehiculoAnteriorTotal;
											 
											 $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotal;
											 
											$OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId] += $OrdeneVentaVehiculoTotal;
											$OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId] += $OrdeneVentaVehiculoAnteriorTotal;
											 
										
									//	}
										
									//}
							
								}
							}
						
						}
					}
					?>
                        
                        
                        
                      
                    
                    
                    
                    
						      <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                   <tr>
                     <th>ASESOR</th>
                     <th colspan="4"><?php echo $PersonalNombre;?></th>
                     </tr>
                   <tr>
                     <th>FECHA</th>
                     <th colspan="2"><?php echo $FechaFinComparativo?></th>
                     <th colspan="2"><?php echo $POST_FechaFin?></th>
                   </tr>
                   <tr>
                     <th>MODELO</th>
                     <th width="80">Cotizaciones</th>
                     <th width="80">Ventas</th>
                     <th width="80">Cotizaciones</th>
                     <th width="80">Ventas</th>
                     </tr>
                    </thead>
                      <tbody class="EstTablaReporteBody">
                        <?php
						$CotizacionTotalActual = 0;
						$CotizacionTotalAnterior = 0;
						
						$OrdenVentaVehiculoTotalActual = 0;
						$OrdenVentaVehiculoTotalAnterior = 0;
						
					if(!empty($ArrVehiculoModelos)){
						foreach($ArrVehiculoModelos as $DatVehiculoModelo){
					?>
                    
						<?php
                        if($CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]>0 || $CotizacionVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId]>0 || $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]>0 || $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId]>0){
                        ?>
                            
                           <tr>
                             <td><?php echo $DatVehiculoModelo->VmoNombre;?></td>
                             <td width="80" align="right">
                             
                              <?php
                             $CotizacionTotalAnterior += $CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId];
                             ?>
                            
                           <?php echo ($CotizacionVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]);?>
                           
                             
                             </td>
                             <td width="80" align="right">
                             
							<?php
                            $OrdenVentaVehiculoTotalAnterior += $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId];
                            ?>
							<?php echo ($OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]);?>
                        
                        </td>
                             <td width="80" align="right"> 
                             
                             <?php
                             $CotizacionTotalActual += $CotizacionVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId];
                             ?>
                              <?php echo ($CotizacionVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId]);?>
                              
                              </td>
                             <td width="80" align="right">
                             
                             <?php
							 $OrdenVentaVehiculoTotalActual += $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId];
							 ?>
							  <?php echo ($OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId]);?>
							  
                      </td>
                             </tr>
                   
							<?php		
							}
							?>
                            
                   <?php
						}
					}
				   ?>
                   
                   
                   <tr>
                     <td class="EstTablaReporteColumnaEspecial4">TOTAL:</td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $CotizacionTotalAnterior;?></td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalAnterior;?></td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $CotizacionTotalActual;?></td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalActual;?></td>
                     </tr>
                   <tr>
                     <td></td> <td width="80" colspan="2" align="right">&nbsp;</td> <td width="80" colspan="2" align="right">&nbsp;</td> 
                   </tr>
                    </tbody>
                    </table>
                   
						  <?php 
						   break;
						   
						   default:
						  ?>
                          No ha escogido una vista
                          <?php
						   break;
					   }
					  
					   ?>  
                 
                    
                    
                    </td>
                    </tr>
                    
                      <tr>
                        <td colspan="4" align="center">
                        
                        
                        
---


<?php



$mensaje .= "<br>";
//MtdObtenerCotizacionVehiculoPersonales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oVehiculoMarca=NULL) 
$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculoPersonales(NULL,NULL,NULL,'PerNombre','ASC','',FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_Sucursal,$POST_VehiculoMarca);
$ArrCotizacionVehiculoPersonales = $ResCotizacionVehiculo['Datos'];
?>


		<table border='1' cellspacing='0' cellpadding='5'>
			
		<thead>
			
<tr>
<th class='EstCabecera' width='250'>
ASESOR DE VENTAS
</th>

			
<th class='EstCabecera' width='150'>
Cotizaciones

<?php echo $FechaActualInicio;?> - 
<?php echo $POST_FechaFin;?>
</th>

<th class='EstCabecera' width='150'>
Ventas
<?php echo $FechaActualInicio;?> - 
<?php echo $POST_FechaFin;?>
</th>

	<th class='EstCabecera' width='150'>
Indice (%)
</th>
		
</tr>
			
</thead>
			
<?php	
			$TotalActual = 0;
			
?>

<?php		
			if(!empty($ArrCotizacionVehiculoPersonales)){
				foreach($ArrCotizacionVehiculoPersonales as $DatCotizacionVehiculoPersonal){
						
					$CotizacionVehiculoTotal = 0;
					$OrdenVentaVehiculoTotal = 0;
					
					if(!empty($ArrSucursales)){
						foreach($ArrSucursales as $DatSucursal){
//		
							//if(!empty($ArrVehiculoModelos)){
							//	foreach($ArrVehiculoModelos as $DatVehiculoModelo){
									
									//Valor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL)
									$CotizacionVehiculoTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,NULL,NULL,$POST_Sucursal,NULL);
									
									//$CotizacionVehiculoAnteriorTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
									
									$OrdenVentaVehiculoTotal += $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,NULL,$POST_Sucursal,NULL);
								
									
							//	}
						//	}
//						
						}
					}
					  
?>


<tr>
			
<td>
						<?php echo $DatCotizacionVehiculoPersonal->PerNombre." ".$DatCotizacionVehiculoPersonal->PerApellidoPaterno." ".$DatCotizacionVehiculoPersonal->PerApellidoMaterno;?>
		  </td>
						
					
						
						
						 <?php //$TotalActual += $CotizacionVehiculoTotal;?>
						 
						<td align='center'>
						<?php echo ($CotizacionVehiculoTotal);?>
                        
						</td>
                        
                        <td align='center'>
                        
                        
                        <?php echo ($OrdenVentaVehiculoTotal);?>
                        
                        </td> 
                        <td align='center'>
                        
                        <?php
						
						$Indice = 0;
						
						if($OrdenVentaVehiculoTotal>0){
							
							$Indice = $CotizacionVehiculoTotal/$OrdenVentaVehiculoTotal;
							
						}else{						
							
							$Indice = 0;
						
						}
						
						?>
                        
						<?php echo round($Indice,2);?> %
                        
                        </td>
						  
</tr>

<?php										
				
				}
			}
?>
	
		  
<tr>
<td>
			
<!--<b>
TOTAL:
</b>
		-->	  
</td>
			
<td align='center'></td>
			
<td align='center'>
<b>
<?php // echo $TotalActual; ?>
</b>
</td>
	<td align='center'>
    </td>
  
</tr>
							 
			
</table>
			
		

                        </td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                    </table>
                    
          
       
     

