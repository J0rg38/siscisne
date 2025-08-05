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
$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Vista = ($_GET['Vista']);


$ArrFechaFin = explode("/",$POST_FechaFin);

if($ArrFechaFin[1]=="01"){
	$NuevoMes = 12;
	$NuevoAno = $ArrFechaFin[2] - 1;		
}else{
	$NuevoMes = $ArrFechaFin[1] - 1;		
	$NuevoAno = $ArrFechaFin[2];	
	
	$NuevoMes  = str_pad($NuevoMes,2,0,STR_PAD_LEFT);
}

$MesActual = $ArrFechaFin[1];
$AnoActual = $ArrFechaFin[2];

$FechaFinComparativo = $ArrFechaFin[0]."/".$NuevoMes."/".$NuevoAno;

//deb($POST_Mes);
if(empty($POST_VehiculoMarca)){
die("No ha escogido una marca de vehiculo");
} 

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsSucursalMeta.php');
 
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
 
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];
//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 


$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoNombre','ASC',NULL,$POST_VehiculoMarca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];
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
          <td width="54%" align="center" valign="top">REPORTE DE METAS VS VENTA DE VEHICULOS</td>
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
switch($POST_Vista){
	case "xVersion":
?>


<table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                      <th>RETAIL POR LOCAL</th>
                      
					<?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
					?>
                    		 <th align="center"><?php echo $DatSucursal->SucNombre?></th>
                    <?php		  
							}
					}
					?>
                     <th width="80"  align="center">Total</th>
                     
                      
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                    
                    <?php
					$TotalModeloAsesor = 0;
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
							
							$MostrarModelo = false;
							
							$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
						
							if($OrdeneVentaVehiculoTotal>0){
								$MostrarModelo = true;
							}
							

							if($MostrarModelo){
							
					?>
                    <tr>
                            <td >
                               
                               <?php echo $DatVehiculoVersion->VmoNombre;?>
                               
                               <?php echo $DatVehiculoVersion->VveNombre;?>
                            </td>
                             
                             
                      
                  		<?php
						$TotalModelo = 0;
						
						?><?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
					?>
                         <td width="50" align="right" >
                         
                         <?php
//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL)
						//$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),5,NULL,$DatPersonal->PerId,$DatVehiculoVersion->VmoId,NULL,$DatSucursal->SucId);
						//$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($FechaFinComparativo),5,NULL,$DatPersonal->PerId,$DatVehiculoVersion->VmoId,NULL,$DatSucursal->SucId);

						$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,$DatPersonal->PerId,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
						$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(2,3,4,5),NULL,$DatPersonal->PerId,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
						
						 
						 $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotal;
						 
						 $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoTotal;
						  $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoAnteriorTotal;
						 
						 
						 if(!empty($OrdeneVentaVehiculoTotal)){
							?>
                             <?php echo ($OrdeneVentaVehiculoTotal);?>
                            <?php 
							
							$TotalModelo += $OrdeneVentaVehiculoTotal;
						
						 }
						 
						 ?>
                        
                         
                         </td>
                         <?php
								
						}
					}
					?>
                    
                        <?php		
							
						?>
                   		<td width="80" align="right">
<?php echo $TotalModelo;?>
                      </td>
                    
                  
                           
                            
                        </tr>
                        
                    
                    <?php
							}		
						}
					}
					?>
                        
                        
                        
                       
                        <tr>
                          <td class="EstTablaReporteColumnaEspecial4">Total General:</td>
                         
                            
                               <?php
							   
$TotalSucursales = 0;
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
							
					?>
							
                    
                          <td width="50"   align="right" class="EstTablaReporteColumnaEspecial4">
                                
                                <?php echo ($OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId]);?>
							  <?php 	 $TotalSucursales += $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId];?>
                             
                              <?php 	//$TotalModeloAsesor += $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId];?>
                          </td>
                           
							  
                   
                         <?php
							}
						}
					?>
                         	<td width="80" align="right"  class="EstTablaReporteColumnaEspecial4"><?php //echo $TotalModeloAsesor;?><?php echo $TotalSucursales;?></td>
                  
                        </tr>
                       
                    
                        
                          <tr>
                            <td class="EstTablaReporteColumnaEspecial4">META MES:</td>
                            
                     <?php
					 
					 $MetaCantidad = array();
					 $TotalMetas = 0;
					 
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
							
					?>
							               
                            <td   align="right">
                            

<?php
$InsSucursalMeta = new ClsSucursalMeta();
//MtdObtenerSucursalMetas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SmeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAno=NULL,$oMes=NULL,$oSucursal=NULL,$oActividad=NULL)
$ResSucursalMeta = $InsSucursalMeta->MtdObtenerSucursalMetas(NULL,NULL,NULL,'SmeId','ASC','1',1,$AnoActual+1-1,$MesActual+1-1,$DatSucursal->SucId,"VENTA_VEHICULO");
$ArrSucursalMetas = $ResSucursalMeta['Datos'];



if(!empty($ArrSucursalMetas)){
	foreach($ArrSucursalMetas as $DatSucursalMeta){
		$MetaCantidad[$DatSucursal->SucId] = round($DatSucursalMeta->SmeCantidad,2);
	}
}

$TotalMetas += $MetaCantidad[$DatSucursal->SucId]; 
?>

<?php echo $MetaCantidad[$DatSucursal->SucId];?>
                            
                            </td>
                            
                            
                             <?php
							}
						}
					?>
                            
                            <td align="right"  ><?php echo $TotalMetas;?></td>
                          </tr>
                          <tr>
                          <td class="EstTablaReporteColumnaEspecial4">% CUMP. DE META:</td>
                         
                            
                               <?php
						$PorcentajeCumplido = array();
						
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
								if($MetaCantidad[$DatSucursal->SucId]>0){
		
									$PorcentajeCumplido[$DatSucursal->SucId] = $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId]  / $MetaCantidad[$DatSucursal->SucId];									
									$PorcentajeCumplido[$DatSucursal->SucId] = $PorcentajeCumplido[$DatSucursal->SucId]*100;
									$PorcentajeCumplido[$DatSucursal->SucId] = round($PorcentajeCumplido[$DatSucursal->SucId],2);
								}else{
									$PorcentajeCumplido[$DatSucursal->SucId] = 0;
								}
								

					?>
							
                    
                          <td width="50"   align="right">
                                
                              <?php echo $PorcentajeCumplido[$DatSucursal->SucId];?> %
                          </td>
                           
							  
                   
                    
                    <?php
							}
						}
					?>
                            	<td width="80" align="right"  >
                                
<?php
								if($TotalMetas>0){
									$PorcentajeCumplidoTotal = $TotalSucursales  / $TotalMetas;									
									$PorcentajeCumplidoTotal = $PorcentajeCumplidoTotal*100;
									$PorcentajeCumplidoTotal = round($PorcentajeCumplidoTotal,2);
								}else{
									$PorcentajeCumplidoTotal = 0;
								}
?>
                                 <?php echo $PorcentajeCumplidoTotal;?> %
                                </td>
                        </tr>
                        
                         <tr>
                          <td class="EstTablaReporteColumnaEspecial4">DIFERENCIA:</td>
                         
                            
                               <?php
						$DiferenciaTotal = array();
						
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
							$Diferencia[$DatSucursal->SucId] = $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId]  - $MetaCantidad[$DatSucursal->SucId];	
							//$DiferenciaTotal[$DatSucursal->SucId] = round($DiferenciaTotal[$DatSucursal->SucId],2);								
							
					?>
							
                    
                          <td width="50"   align="right" class="EstTablaReporteColumnaEspecial4">
                              
                               <?php //echo $MetaCantidad[$DatSucursal->SucId];?>
                               
                              <?php echo $Diferencia[$DatSucursal->SucId];?>
                              
                          </td>
                           
							  
                    <?php
							}
						}
					?>	<td width="80" align="right"  >
                    
                    
                    <?php
					$DiferenciaTotal = $TotalSucursales - $TotalMetas;	
					?>
                     <?php echo $DiferenciaTotal;?>
                              
                    
                    </td>
                            
                        </tr>
                        
                    </tbody>
                    </table>
                    
<?php
	break;
	
	case "xModelo":
?>


<table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                      <th>RETAIL POR LOCAL</th>
                      
					<?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
					?>
                    		 <th align="center"><?php echo $DatSucursal->SucNombre?></th>
                    <?php		  
							}
					}
					?>
                     <th width="80"  align="center">Total</th>
                     
                      
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                    
                    <?php
					$TotalModeloAsesor = 0;
					if(!empty($ArrVehiculoModelos)){
						foreach($ArrVehiculoModelos as $DatVehiculoModelo){
							
							$MostrarModelo = false;
							
							////MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL)
							$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
						
							if($OrdeneVentaVehiculoTotal>0){
								$MostrarModelo = true;
							}
							

							if($MostrarModelo){
							
					?>
                    <tr>
                            <td >
                               
                               <?php echo $DatVehiculoModelo->VmoNombre;?>
                               
                              
                            </td>
                             
                             
                      
                  		<?php
						$TotalModelo = 0;
						
						?><?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
					?>
                         <td width="50" align="right" >
                         
                         <?php
//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL)
						//$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),5,NULL,$DatPersonal->PerId,$DatVehiculoVersion->VmoId,NULL,$DatSucursal->SucId);
						//$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($FechaFinComparativo),5,NULL,$DatPersonal->PerId,$DatVehiculoVersion->VmoId,NULL,$DatSucursal->SucId);
						
						////MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL)
						$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,$DatPersonal->PerId,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
						
						$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(2,3,4,5),NULL,$DatPersonal->PerId,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
						
						 
						 $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotal;
						 
						 $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId] += $OrdeneVentaVehiculoTotal;
						  $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId] += $OrdeneVentaVehiculoAnteriorTotal;
						 
						 
						 if(!empty($OrdeneVentaVehiculoTotal)){
							?>
                             <?php echo ($OrdeneVentaVehiculoTotal);?>
                            <?php 
							
							$TotalModelo += $OrdeneVentaVehiculoTotal;
						
						 }
						 
						 ?>
                        
                         
                         </td>
                         <?php
								
						}
					}
					?>
                    
                        <?php		
							
						?>
                   		<td width="80" align="right">
<?php echo $TotalModelo;?>
                      </td>
                    
                  
                           
                            
                        </tr>
                        
                    
                    <?php
							}		
						}
					}
					?>
                        
                        
                        
                       
                        <tr>
                          <td class="EstTablaReporteColumnaEspecial4">Total General:</td>
                         
                            
                               <?php
							   
$TotalSucursales = 0;
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
							
					?>
							
                    
                          <td width="50"   align="right" class="EstTablaReporteColumnaEspecial4">
                                
                                <?php echo ($OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId]);?>
							  <?php 	 $TotalSucursales += $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId];?>
                             
                              <?php 	//$TotalModeloAsesor += $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId];?>
                          </td>
                           
							  
                   
                         <?php
							}
						}
					?>
                         	<td width="80" align="right"  class="EstTablaReporteColumnaEspecial4"><?php //echo $TotalModeloAsesor;?><?php echo $TotalSucursales;?></td>
                  
                        </tr>
                       
                    
                        
                          <tr>
                            <td class="EstTablaReporteColumnaEspecial4">META MES:</td>
                            
                     <?php
					 
					 $MetaCantidad = array();
					 $TotalMetas = 0;
					 
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
							
					?>
							               
                            <td   align="right">
                            

<?php
$InsSucursalMeta = new ClsSucursalMeta();
//MtdObtenerSucursalMetas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SmeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAno=NULL,$oMes=NULL,$oSucursal=NULL,$oActividad=NULL)
$ResSucursalMeta = $InsSucursalMeta->MtdObtenerSucursalMetas(NULL,NULL,NULL,'SmeId','ASC','1',1,$AnoActual+1-1,$MesActual+1-1,$DatSucursal->SucId,"VENTA_VEHICULO");
$ArrSucursalMetas = $ResSucursalMeta['Datos'];



if(!empty($ArrSucursalMetas)){
	foreach($ArrSucursalMetas as $DatSucursalMeta){
		$MetaCantidad[$DatSucursal->SucId] = round($DatSucursalMeta->SmeCantidad,2);
	}
}

$TotalMetas += $MetaCantidad[$DatSucursal->SucId]; 
?>

<?php echo $MetaCantidad[$DatSucursal->SucId];?>
                            
                            </td>
                            
                            
                             <?php
							}
						}
					?>
                            
                            <td align="right"  ><?php echo $TotalMetas;?></td>
                          </tr>
                          <tr>
                          <td class="EstTablaReporteColumnaEspecial4">% CUMP. DE META:</td>
                         
                            
                               <?php
						$PorcentajeCumplido = array();
						
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
								if($MetaCantidad[$DatSucursal->SucId]>0){
		
									$PorcentajeCumplido[$DatSucursal->SucId] = $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId]  / $MetaCantidad[$DatSucursal->SucId];									
									$PorcentajeCumplido[$DatSucursal->SucId] = $PorcentajeCumplido[$DatSucursal->SucId]*100;
									$PorcentajeCumplido[$DatSucursal->SucId] = round($PorcentajeCumplido[$DatSucursal->SucId],2);
								}else{
									$PorcentajeCumplido[$DatSucursal->SucId] = 0;
								}
								

					?>
							
                    
                          <td width="50"   align="right">
                                
                              <?php echo $PorcentajeCumplido[$DatSucursal->SucId];?> %
                          </td>
                           
							  
                   
                    
                    <?php
							}
						}
					?>
                            	<td width="80" align="right"  >
                                
<?php
								if($TotalMetas>0){
									$PorcentajeCumplidoTotal = $TotalSucursales  / $TotalMetas;									
									$PorcentajeCumplidoTotal = $PorcentajeCumplidoTotal*100;
									$PorcentajeCumplidoTotal = round($PorcentajeCumplidoTotal,2);
								}else{
									$PorcentajeCumplidoTotal = 0;
								}
?>
                                 <?php echo $PorcentajeCumplidoTotal;?> %
                                </td>
                        </tr>
                        
                         <tr>
                          <td class="EstTablaReporteColumnaEspecial4">DIFERENCIA:</td>
                         
                            
                               <?php
						$DiferenciaTotal = array();
						
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
							$Diferencia[$DatSucursal->SucId] = $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId]  - $MetaCantidad[$DatSucursal->SucId];	
							//$DiferenciaTotal[$DatSucursal->SucId] = round($DiferenciaTotal[$DatSucursal->SucId],2);								
							
					?>
							
                    
                          <td width="50"   align="right" class="EstTablaReporteColumnaEspecial4">
                              
                               <?php //echo $MetaCantidad[$DatSucursal->SucId];?>
                               
                              <?php echo $Diferencia[$DatSucursal->SucId];?>
                              
                          </td>
                           
							  
                    <?php
							}
						}
					?>	<td width="80" align="right"  >
                    
                    
                    <?php
					$DiferenciaTotal = $TotalSucursales - $TotalMetas;	
					?>
                     <?php echo $DiferenciaTotal;?>
                              
                    
                    </td>
                            
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
                      
                    
                    <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                      <th>RETAIL POR LOCAL</th>
                      
					<?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
					?>
                    		 <th align="center"><?php echo $DatSucursal->SucNombre?></th>
                    <?php		  
							}
					}
					?>
                     <th width="80"  align="center">Total</th>
                     
                      
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                    
                    <?php
					$TotalModeloAsesor = 0;
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
							
							$MostrarModelo = false;
							
							$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
						
							if($OrdeneVentaVehiculoTotal>0){
								$MostrarModelo = true;
							}
							

							if($MostrarModelo){
							
					?>
                    <tr>
                            <td >
                               
                               <?php echo $DatVehiculoVersion->VmoNombre;?>
                               
                               <?php echo $DatVehiculoVersion->VveNombre;?>
                            </td>
                             
                             
                      
                  		<?php
						$TotalModelo = 0;
						
						?><?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
					?>
                         <td width="50" align="right" >
                         
                         <?php
//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL)
						//$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),5,NULL,$DatPersonal->PerId,$DatVehiculoVersion->VmoId,NULL,$DatSucursal->SucId);
						//$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($FechaFinComparativo),5,NULL,$DatPersonal->PerId,$DatVehiculoVersion->VmoId,NULL,$DatSucursal->SucId);

						$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,$DatPersonal->PerId,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
						$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(2,3,4,5),NULL,$DatPersonal->PerId,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
						
						 
						 $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotal;
						 
						 $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoTotal;
						  $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoAnteriorTotal;
						 
						 
						 if(!empty($OrdeneVentaVehiculoTotal)){
							?>
                             <?php echo ($OrdeneVentaVehiculoTotal);?>
                            <?php 
							
							$TotalModelo += $OrdeneVentaVehiculoTotal;
						
						 }
						 
						 ?>
                        
                         
                         </td>
                         <?php
								
						}
					}
					?>
                    
                        <?php		
							
						?>
                   		<td width="80" align="right">
<?php echo $TotalModelo;?>
                      </td>
                    
                  
                           
                            
                        </tr>
                        
                    
                    <?php
							}		
						}
					}
					?>
                        
                        
                        
                       
                        <tr>
                          <td class="EstTablaReporteColumnaEspecial4">Total General:</td>
                         
                            
                               <?php
							   
$TotalSucursales = 0;
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
							
					?>
							
                    
                          <td width="50"   align="right" class="EstTablaReporteColumnaEspecial4">
                                
                                <?php echo ($OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId]);?>
							  <?php 	 $TotalSucursales += $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId];?>
                             
                              <?php 	//$TotalModeloAsesor += $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId];?>
                          </td>
                           
							  
                   
                         <?php
							}
						}
					?>
                         	<td width="80" align="right"  class="EstTablaReporteColumnaEspecial4"><?php //echo $TotalModeloAsesor;?><?php echo $TotalSucursales;?></td>
                  
                        </tr>
                       
                    
                        
                          <tr>
                            <td class="EstTablaReporteColumnaEspecial4">META MES:</td>
                            
                     <?php
					 
					 $MetaCantidad = array();
					 $TotalMetas = 0;
					 
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
							
					?>
							               
                            <td   align="right">
                            

<?php
$InsSucursalMeta = new ClsSucursalMeta();
//MtdObtenerSucursalMetas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SmeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAno=NULL,$oMes=NULL,$oSucursal=NULL,$oActividad=NULL)
$ResSucursalMeta = $InsSucursalMeta->MtdObtenerSucursalMetas(NULL,NULL,NULL,'SmeId','ASC','1',1,$AnoActual+1-1,$MesActual+1-1,$DatSucursal->SucId,"VENTA_VEHICULO");
$ArrSucursalMetas = $ResSucursalMeta['Datos'];



if(!empty($ArrSucursalMetas)){
	foreach($ArrSucursalMetas as $DatSucursalMeta){
		$MetaCantidad[$DatSucursal->SucId] = round($DatSucursalMeta->SmeCantidad,2);
	}
}

$TotalMetas += $MetaCantidad[$DatSucursal->SucId]; 
?>

<?php echo $MetaCantidad[$DatSucursal->SucId];?>
                            
                            </td>
                            
                            
                             <?php
							}
						}
					?>
                            
                            <td align="right"  ><?php echo $TotalMetas;?></td>
                          </tr>
                          <tr>
                          <td class="EstTablaReporteColumnaEspecial4">% CUMP. DE META:</td>
                         
                            
                               <?php
						$PorcentajeCumplido = array();
						
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
								if($MetaCantidad[$DatSucursal->SucId]>0){
		
									$PorcentajeCumplido[$DatSucursal->SucId] = $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId]  / $MetaCantidad[$DatSucursal->SucId];									
									$PorcentajeCumplido[$DatSucursal->SucId] = $PorcentajeCumplido[$DatSucursal->SucId]*100;
									$PorcentajeCumplido[$DatSucursal->SucId] = round($PorcentajeCumplido[$DatSucursal->SucId],2);
								}else{
									$PorcentajeCumplido[$DatSucursal->SucId] = 0;
								}
								

					?>
							
                    
                          <td width="50"   align="right">
                                
                              <?php echo $PorcentajeCumplido[$DatSucursal->SucId];?> %
                          </td>
                           
							  
                   
                    
                    <?php
							}
						}
					?>
                            	<td width="80" align="right"  >
                                
<?php
								if($TotalMetas>0){
									$PorcentajeCumplidoTotal = $TotalSucursales  / $TotalMetas;									
									$PorcentajeCumplidoTotal = $PorcentajeCumplidoTotal*100;
									$PorcentajeCumplidoTotal = round($PorcentajeCumplidoTotal,2);
								}else{
									$PorcentajeCumplidoTotal = 0;
								}
?>
                                 <?php echo $PorcentajeCumplidoTotal;?> %
                                </td>
                        </tr>
                        
                         <tr>
                          <td class="EstTablaReporteColumnaEspecial4">DIFERENCIA:</td>
                         
                            
                               <?php
						$DiferenciaTotal = array();
						
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
							$Diferencia[$DatSucursal->SucId] = $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId]  - $MetaCantidad[$DatSucursal->SucId];	
							//$DiferenciaTotal[$DatSucursal->SucId] = round($DiferenciaTotal[$DatSucursal->SucId],2);								
							
					?>
							
                    
                          <td width="50"   align="right" class="EstTablaReporteColumnaEspecial4">
                              
                               <?php //echo $MetaCantidad[$DatSucursal->SucId];?>
                               
                              <?php echo $Diferencia[$DatSucursal->SucId];?>
                              
                          </td>
                           
							  
                    <?php
							}
						}
					?>	<td width="80" align="right"  >
                    
                    
                    <?php
					$DiferenciaTotal = $TotalSucursales - $TotalMetas;	
					?>
                     <?php echo $DiferenciaTotal;?>
                              
                    
                    </td>
                            
                        </tr>
                        
                    </tbody>
                    </table>
                    
                   </td>
                    </tr>
                    
                      <tr>
                        <td  align="center"></td>
                      </tr>
                      <tr>
                      <td >&nbsp;</td>
                    </tr>
                    </table>
                    
          
       
     

