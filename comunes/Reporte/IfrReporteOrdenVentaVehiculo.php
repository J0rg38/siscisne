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
        


$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");
$POST_VehiculoMarca = empty($_GET['CmpVehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];


$ArrFechaFin = explode("/",$POST_ffin);

if($ArrFechaFin[1]=="01"){
	$NuevoMes = 12;
	$NuevoAno = $ArrFechaFin[2] - 1;		
}else{
	$NuevoMes = $ArrFechaFin[1] - 1;		
	$NuevoAno = $ArrFechaFin[2];	
	
	$NuevoMes  = str_pad($NuevoMes,2,0,STR_PAD_LEFT);
}



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
 
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();
 
//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucId","ASC",NULL);
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
          <td colspan="4" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
        </tr>
        <tr>
          <td width="23%" align="left" valign="top">
		  
		  
		  
            <img src="../../imagenes/logos/logo_reporte.png" width="150"  />
            </td>
          <td width="54%" align="center" valign="top">REPORTE DE VENTA DE VEHICULOS</td>
          <td width="23%" align="right" valign="top">&nbsp;</td>
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
                  
                  
                      
                    
                    <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                    
                    <tr>
                      <th>RETAIL POR ASESOR</th>
                      
					<?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
								//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 
								$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,'PerNombre','ASC',NULL,NULL,1,NULL,NULL,NULL,1,NULL,$DatSucursal->SucId);
								$ArrPersonales = $ResPersonal['Datos'];
								$Colspan = count($ArrPersonales);
							
					?>
                    		 <th colspan="<?php echo $Colspan;?>" align="center"><?php echo $DatSucursal->SucNombre?></th>
                    <?php		  
							}
					}
					?>
                    
                     
                      
                    </tr>
                    <tr>
                    
                    
                    <th>
                    MODELO/ASESOR</th>
                   
                   <?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
								$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,'PerNombre','ASC',NULL,NULL,1,NULL,NULL,NULL,1,NULL,$DatSucursal->SucId);
								$ArrPersonales = $ResPersonal['Datos'];
								
						
					?>
                  		<?php
						if(!empty($ArrPersonales )){
							foreach($ArrPersonales  as $DatPersonal){
						?>
                         <th align="center"><?php echo $DatPersonal->UsuUsuario;?></th>
                        <?php		
							}
							
						}
						?>
                   
                    
                    <?php
							}
						}
					?>
                    
                    
                    </tr>
                    </thead>
                   
                    
                    <tbody class="EstTablaReporteBody">
                    
                    <?php
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
					?>
                    <tr>
                            <td >
                               
                               <?php echo $DatVehiculoVersion->VmoNombre;?>
                               
                               <?php echo $DatVehiculoVersion->VveNombre;?>
                            </td>
                             
                             
                             
                               <?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
								$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,'PerNombre','ASC',NULL,NULL,1,NULL,NULL,NULL,1,NULL,$DatSucursal->SucId);
								$ArrPersonales = $ResPersonal['Datos'];
								
						
					?>
                  		<?php
						if(!empty($ArrPersonales )){
							foreach($ArrPersonales  as $DatPersonal){
						?>
                         <td align="center" >
                         
                         <?php
//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL)
						 $OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),5,NULL,$DatPersonal->PerId,$DatVehiculoVersion->VmoId,NULL,$DatSucursal->SucId);
						 
						  $OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($FechaFinComparativo),5,NULL,$DatPersonal->PerId,$DatVehiculoVersion->VmoId,NULL,$DatSucursal->SucId);
						 
						 $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId][$DatPersonal->PerId] += $OrdeneVentaVehiculoTotal;
						 
						 $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoTotal;
						  $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoAnteriorTotal;
						 
						 ?>
                         
                         <?php
						 if(!empty($OrdeneVentaVehiculoTotal)){
							?>
                             <?php echo ($OrdeneVentaVehiculoTotal);?>
                            <?php 
						 }
						 
						 ?>
                        
                         
                         </td>
                        <?php		
							}
							
						}
						?>
                   
                    
                    <?php
							}
						}
					?>
                           
                            
                        </tr>
                        
                    
                    <?php		
						}
					}
					?>
                        
                        
                        
                       
                        <tr>
                          <td class="EstTablaReporteColumnaEspecial4">Total General</td>
                         
                            
                               <?php
						if(!empty($ArrSucursales)){
							foreach($ArrSucursales as $DatSucursal){
								
								$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,'PerNombre','ASC',NULL,NULL,1,NULL,NULL,NULL,1,NULL,$DatSucursal->SucId);
								$ArrPersonales = $ResPersonal['Datos'];
								
						
					?>
							<?php
                            if(!empty($ArrPersonales )){
                                foreach($ArrPersonales  as $DatPersonal){
                            ?>
                    
                          <td   align="center" class="EstTablaReporteColumnaEspecial4">
                                
                                <?php echo number_format($OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId][$DatPersonal->PerId],2);?>
							  
                          </td>
                           
							   <?php		
                                }
                                
                            }
                            ?>
                   
                    
                    <?php
							}
						}
					?>
                            
                        </tr>
                       
                    
                    </tbody>
                    </table>
                    
                    
                    
                    
                      </td>
                    </tr>
                    
                      <tr>
                      <td colspan="4">
                      
                         
                    <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                   <tr>
                     <th>MODELO</th>
                     <th><?php echo $FechaFinComparativo?></th>
                     <th><?php echo $POST_ffin?></th>
                     <th>VAR Q</th>
                    <th>VAR %
                    
                    </th>
                    </tr>
                    </thead>
                      <tbody class="EstTablaReporteBody">
                        <?php
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
					?>
                   <tr>
                     <td><?php echo $DatVehiculoVersion->VmoNombre;?> <?php echo $DatVehiculoVersion->VveNombre;?></td>
                     <td>
                     
                   <?php echo ($OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]);?>
                     
                     </td>
                     <td>  <?php echo ($OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId]);?></td>
                     <td>
                     
                     <?php 
					 
					 $Diferencia = $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId] - $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId];
					 
					 ?>
                     
                     <?php
					 echo $Diferencia;
					 ?>
                     
                     <?php
					 if($Diferencia>0){
						?>
                        <img src="imagenes/flecha_arriba.png" width="15" height="15" />
                        <?php 
					 }elseif($Diferencia<0){
						?>
                         <img src="imagenes/flecha_abajo.png" width="15" height="15" />
                        <?php 
					 }
					
					 ?>
                     </td>
                   <td>
                   
                   </td>
                   </tr>
                   <?php
						}
					}
				   ?>
                    </tbody>
                    </table>
                    
                    
                    
                    </td>
                    </tr>
                    
                      <tr>
                      <td colspan="4">&nbsp;</td>
                    </tr>
                    </table>
                    
          
       
     

