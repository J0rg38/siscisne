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

//$FechaFinComparativoAnterior = $ArrFechaFin[0]."/".$NuevoMes."/".$AnoTrasAnterior;
//$FechaFinComparativoTrasanterior = $ArrFechaFin[0]."/".$NuevoMes."/".$AnoTrasAnterior;
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
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
 
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


$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoNombre','ASC',NULL,$POST_VehiculoMarca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

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
          <td width="54%" align="center" valign="top">REPORTE DE COMPARATIVO VENTA DE VEHICULOS</td>
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
					//$OrdenVentaVehiculoTotalSucursalActual = 0;
					//$OrdenVentaVehiculoTotalSucursalAnterior = 0;
					
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
					
							if(!empty($ArrSucursales)){
								foreach($ArrSucursales as $DatSucursal){
									
									//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,'PerNombre','ASC',NULL,NULL,1,NULL,NULL,NULL,1,NULL,$DatSucursal->SucId);
									//$ArrPersonales = $ResPersonal['Datos'];
						
									//if(!empty($ArrPersonales )){
									//	foreach($ArrPersonales  as $DatPersonal){
									
					//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL)
											$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
											
											$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(2,3,4,5),NULL,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
											 
											 
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
                     <th>MODELO</th>
                    <th width="80">
					 
					 <span title="<?php echo $FechaFinComparativoInicio;?> al <?php echo $FechaFinComparativo;?>"><?php echo $FechaFinComparativo?></span></th>
                     <th width="80"><span title="<?php echo $FechaActualInicio;?> al <?php echo $POST_FechaFin;?>"><?php echo $POST_FechaFin?></span></th>
                     <th width="80">VAR Q</th>
                    <th width="80">VAR %
                    
                    </th>
                    </tr>
                    </thead>
                      <tbody class="EstTablaReporteBody">
                        <?php
						$OrdenVentaVehiculoTotalActual = 0;
						$OrdenVentaVehiculoTotalAnterior = 0;
						
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
					?>
                    		<?php
							if($OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]>0 || $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId]>0){
					?>
                    
                  
                   <tr>
                     <td><?php echo $DatVehiculoVersion->VmoNombre;?> <?php echo $DatVehiculoVersion->VveNombre;?></td>
                     <td width="80" align="right">
					
					<?php
					$OrdenVentaVehiculoTotalAnterior += $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId];
					?>
					
					<?php echo ($OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]);?>
                     
                     </td>
                     <td width="80" align="right"> 
                     <?php
					 $OrdenVentaVehiculoTotalActual += $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId];
					 ?>
                      <?php echo ($OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId]);?></td>
                     <td width="80" align="right">
                     
                     <?php 
					 
					 $Diferencia = $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId] - $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId];
					 
					 if($OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]>0){
						 
						 $PorcentajeVariacion = (($OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId] - $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]) / $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId]);
						$PorcentajeVariacion = $PorcentajeVariacion * 100;
						 $PorcentajeVariacion = round($PorcentajeVariacion,2);
						 
					 }else{
						  $PorcentajeVariacion = 0;
					 }
					 
					 ?>
                     
                    
                     
                     <?php
					 if($Diferencia>0){
						?>
                      
                          <img src="imagenes/flecha_arriba.png" width="15" height="15" />
                        <?php 
					 }elseif($Diferencia<0){
						?> <img src="imagenes/flecha_abajo.png" width="15" height="15" />
                        <?php 
					 }
					
					 ?>
                     
                      <?php
					 echo $Diferencia;
					 ?>
                     
                     </td>
                   <td width="80" align="right">
                   
                   
                   
                   
                     <?php
					 if($PorcentajeVariacion>0){
						?>
                    <img src="imagenes/flecha_arriba.png" width="15" height="15" /> <?php echo $PorcentajeVariacion;?> % 
                        <?php 
					 }elseif($PorcentajeVariacion<0){
						?>
                           <img src="imagenes/flecha_abajo.png" width="15" height="15" />  <?php echo $PorcentajeVariacion;?> %
                        <?php 
					 }else{
						?>
                        
                        <?php 
					 }
					 ?>
                   
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
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalAnterior;?></td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalActual;?></td>
                     <td width="80" align="right" >
                     
                       <?php 
					 
					 $Diferencia = $OrdenVentaVehiculoTotalActual - $OrdenVentaVehiculoTotalAnterior;
					 
					 if($OrdenVentaVehiculoTotalAnterior>0){
						 
						 $PorcentajeVariacion = (($OrdenVentaVehiculoTotalActual - $OrdenVentaVehiculoTotalAnterior) / $OrdenVentaVehiculoTotalAnterior);
						$PorcentajeVariacion = $PorcentajeVariacion * 100;
						 $PorcentajeVariacion = round($PorcentajeVariacion,2);
						 
					 }else{
						  $PorcentajeVariacion = 0;
					 }
					 
					 ?>
                     
                    
                     <?php
					 if($Diferencia>0){
						?>
                      
                          <img src="imagenes/flecha_arriba.png" width="15" height="15" />
                        <?php 
					 }elseif($Diferencia<0){
						?> <img src="imagenes/flecha_abajo.png" width="15" height="15" />
                        <?php 
					 }
					
					 ?> <?php
					 echo $Diferencia;
					 ?>
                     
                     
                     </td>
                     <td width="80" align="right" >
                     
                     <?php
					 if($PorcentajeVariacion>0){
						?>
                    <img src="imagenes/flecha_arriba.png" width="15" height="15" />   <?php echo $PorcentajeVariacion;?> %
                        <?php 
					 }elseif($PorcentajeVariacion<0){
						?>
                          <img src="imagenes/flecha_abajo.png" width="15" height="15" />  <?php echo $PorcentajeVariacion;?> %  
                        <?php 
					 }else{
						?>
                        
                        <?php 
					 }
					 ?>
                     
                     </td>
                   </tr>
                   <tr>
                     <td></td> <td width="80" align="right">&nbsp;</td> <td width="80" align="right">&nbsp;</td> 
                   <td width="80" align="right">&nbsp;</td> 
                   <td width="80" align="right"></td>
                   </tr>
                    </tbody>
                    </table>
                    
                          <?php
						  
						  break;
						  
						  case "xModelo":
						  
						 ?>
                         
                         
                    
                    <?php
					//$OrdenVentaVehiculoTotalSucursalActual = 0;
					//$OrdenVentaVehiculoTotalSucursalAnterior = 0;
					
					if(!empty($ArrVehiculoModelos)){
						foreach($ArrVehiculoModelos as $DatVehiculoModelo){
					
							if(!empty($ArrSucursales)){
								foreach($ArrSucursales as $DatSucursal){
									
									//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,'PerNombre','ASC',NULL,NULL,1,NULL,NULL,NULL,1,NULL,$DatSucursal->SucId);
									//$ArrPersonales = $ResPersonal['Datos'];
						
									//if(!empty($ArrPersonales )){
									//	foreach($ArrPersonales  as $DatPersonal){
									
					//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL)
											$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
											
											$OrdeneVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(2,3,4,5),NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
											 
											 
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
                     <th>MODELO</th>
                    <th width="80">
					 
					 <span title="<?php echo $FechaFinComparativoInicio;?> al <?php echo $FechaFinComparativo;?>"><?php echo $FechaFinComparativo?></span></th>
                     <th width="80"><span title="<?php echo $FechaActualInicio;?> al <?php echo $POST_FechaFin;?>"><?php echo $POST_FechaFin?></span></th>
                     <th width="80">VAR Q</th>
                    <th width="80">VAR %
                    
                    </th>
                    </tr>
                    </thead>
                      <tbody class="EstTablaReporteBody">
                        <?php
						$OrdenVentaVehiculoTotalActual = 0;
						$OrdenVentaVehiculoTotalAnterior = 0;
						
					if(!empty($ArrVehiculoModelos)){
						foreach($ArrVehiculoModelos as $DatVehiculoModelo){
					?>
                    		<?php
							if($OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]>0 || $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId]>0){
					?>
                    
                  
                   <tr>
                     <td><?php echo $DatVehiculoModelo->VmoNombre;?></td>
                     <td width="80" align="right">
					
					<?php
					$OrdenVentaVehiculoTotalAnterior += $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId];
					?>
					
					<?php echo ($OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]);?>
                     
                     </td>
                     <td width="80" align="right"> 
                     <?php
					 $OrdenVentaVehiculoTotalActual += $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId];
					 ?>
                      <?php echo ($OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId]);?></td>
                     <td width="80" align="right">
                     
                     <?php 
					 
					 $Diferencia = $OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId] - $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId];
					 
					 if($OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]>0){
						 
						 $PorcentajeVariacion = (($OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoModelo->VmoId] - $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]) / $OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoModelo->VmoId]);
						$PorcentajeVariacion = $PorcentajeVariacion * 100;
						 $PorcentajeVariacion = round($PorcentajeVariacion,2);
						 
					 }else{
						  $PorcentajeVariacion = 0;
					 }
					 
					 ?>
                     
                    
                     
                     <?php
					 if($Diferencia>0){
						?>
                      
                          <img src="imagenes/flecha_arriba.png" width="15" height="15" />
                        <?php 
					 }elseif($Diferencia<0){
						?> <img src="imagenes/flecha_abajo.png" width="15" height="15" />
                        <?php 
					 }
					
					 ?>
                     
                      <?php
					 echo $Diferencia;
					 ?>
                     
                     </td>
                   <td width="80" align="right">
                   
                   
                   
                   
                     <?php
					 if($PorcentajeVariacion>0){
						?>
                    <img src="imagenes/flecha_arriba.png" width="15" height="15" /> <?php echo $PorcentajeVariacion;?> % 
                        <?php 
					 }elseif($PorcentajeVariacion<0){
						?>
                           <img src="imagenes/flecha_abajo.png" width="15" height="15" />  <?php echo $PorcentajeVariacion;?> %
                        <?php 
					 }else{
						?>
                        
                        <?php 
					 }
					 ?>
                   
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
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalAnterior;?></td>
                     <td width="80" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalActual;?></td>
                     <td width="80" align="right" >
                     
                       <?php 
					 
					 $Diferencia = $OrdenVentaVehiculoTotalActual - $OrdenVentaVehiculoTotalAnterior;
					 
					 if($OrdenVentaVehiculoTotalAnterior>0){
						 
						 $PorcentajeVariacion = (($OrdenVentaVehiculoTotalActual - $OrdenVentaVehiculoTotalAnterior) / $OrdenVentaVehiculoTotalAnterior);
						$PorcentajeVariacion = $PorcentajeVariacion * 100;
						 $PorcentajeVariacion = round($PorcentajeVariacion,2);
						 
					 }else{
						  $PorcentajeVariacion = 0;
					 }
					 
					 ?>
                     
                    
                     <?php
					 if($Diferencia>0){
						?>
                      
                          <img src="imagenes/flecha_arriba.png" width="15" height="15" />
                        <?php 
					 }elseif($Diferencia<0){
						?> <img src="imagenes/flecha_abajo.png" width="15" height="15" />
                        <?php 
					 }
					
					 ?> <?php
					 echo $Diferencia;
					 ?>
                     
                     
                     </td>
                     <td width="80" align="right" >
                     
                     <?php
					 if($PorcentajeVariacion>0){
						?>
                    <img src="imagenes/flecha_arriba.png" width="15" height="15" />   <?php echo $PorcentajeVariacion;?> %
                        <?php 
					 }elseif($PorcentajeVariacion<0){
						?>
                          <img src="imagenes/flecha_abajo.png" width="15" height="15" />  <?php echo $PorcentajeVariacion;?> %  
                        <?php 
					 }else{
						?>
                        
                        <?php 
					 }
					 ?>
                     
                     </td>
                   </tr>
                   <tr>
                     <td></td> <td width="80" align="right">&nbsp;</td> <td width="80" align="right">&nbsp;</td> 
                   <td width="80" align="right">&nbsp;</td> 
                   <td width="80" align="right"></td>
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
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">
                        
<?php

//$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
//$ArrSucursales = $RepSucursal['Datos'];
?>              



 
                    <?php
					//$OrdenVentaVehiculoTotalSucursalActual = 0;
					//$OrdenVentaVehiculoTotalSucursalAnterior = 0;
					$OrdenVentaVehiculoTotalSucursalActual = array();
					$OrdenVentaVehiculoTotalSucursalAnterior = array();
				
					$OrdeneVentaVehiculoSumaTotal = array();
					$OrdeneVentaVehiculoVersionSumaTotal = array();
					$OrdeneVentaVehiculoVersionAnteriorSumaTotal = array();
				 	
					$TotalAnualAnoActual = 0;
					$TotalAnualAnoAnterior = 0;
					$TotalAnualAnoTrasAnterior = 0;
					
					if(!empty($ArrVehiculoVersiones)){
						foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
							//$OrdeneVentaVehiculoTotal = array();
							
							if(!empty($ArrSucursales)){
								foreach($ArrSucursales as $DatSucursal){
									
								
									//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,'PerNombre','ASC',NULL,NULL,1,NULL,NULL,NULL,1,NULL,$DatSucursal->SucId);
									//$ArrPersonales = $ResPersonal['Datos'];
						
									//if(!empty($ArrPersonales )){
									//	foreach($ArrPersonales  as $DatPersonal){
									
					//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL) {
											$OrdeneVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(2,3,4,5),NULL,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
											
											$OrdeneVentaVehiculoMesAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(2,3,4,5),NULL,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
											//$OrdeneVentaVehiculoTrasAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($FechaFinComparativoAnterior),array(2,3,4,5),NULL,NULL,NULL,NULL,$DatSucursal->SucId,NULL);
											 
											 $OrdeneVentaVehiculoTotalAnoAnterior = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoAnoAnteriorInicio),FncCambiaFechaAMysql($FechaFinComparativoAnoAnteriorFin),array(2,3,4,5),NULL,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);
											 
											 $OrdeneVentaVehiculoTotalAnoTrasAnterior = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoTrasAnoTrasAnteriorInicio),FncCambiaFechaAMysql($FechaFinComparativoTrasAnoTrasAnteriorFin),array(2,3,4,5),NULL,NULL,NULL,NULL,$DatSucursal->SucId,$DatVehiculoVersion->VveId);	
											 
											 //TOTAL X SUCURSAL MES ANTERIOR
											 $TotalSucursalMesAnterior[$DatSucursal->SucId] += $OrdeneVentaVehiculoMesAnteriorTotal;
											 										 
											  //TOTAL X SUCURSAL
											 $OrdenVentaVehiculoTotalSucursalActual[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotal;
											 $OrdenVentaVehiculoTotalSucursalAnterior[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotalAnoAnterior;
											 $TotalSucursalTrasAnterior[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotalAnoTrasAnterior;
											 
											  //TOTAL GENERAL
											 $OrdeneVentaVehiculoSumaTotal[$DatSucursal->SucId] += $OrdeneVentaVehiculoTotal;
											 //TOTALES VERSIONES
											$OrdeneVentaVehiculoVersionSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoTotal;
											$OrdeneVentaVehiculoVersionAnteriorSumaTotal[$DatVehiculoVersion->VveId] += $OrdeneVentaVehiculoAnteriorTotal;
											 
											 //TOTALES SIMPLES
											 $TotalAnualAnoActual  +=  $OrdeneVentaVehiculoTotal;
											 
											 $TotalAnualAnoAnterior  +=  $OrdeneVentaVehiculoTotalAnoAnterior;
											 $TotalAnualAnoTrasAnterior  +=  $OrdeneVentaVehiculoTotalAnoTrasAnterior;
											 
										

										
										//}
										
									//}
							
								}
							}
						
						}
					}
					?>
                        
                        
                                  
                        
                        <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                  <tr>
                     <th width="150">COMPARATIVO LOCAL</th>
                     <th width="80"><span title="<?php echo $FechaFinComparativoInicio;?> al <?php echo $FechaFinComparativo?>"><?php echo $FechaFinComparativo?></span></th>
                    <th width="80"><span title="<?php echo $FechaActualInicio;?> al <?php echo $POST_FechaFin?>"><?php echo $POST_FechaFin?></span></th>
                    </tr>
                    </thead>
                      <tbody class="EstTablaReporteBody">
                        <?php
						$OrdenVentaVehiculoTotalActual = 0;
						$OrdenVentaVehiculoTotalAnterior = 0;
						
					if(!empty($ArrSucursales)){
						foreach($ArrSucursales as $DatSucursal){
					?>
                    
                      <?php $OrdenVentaVehiculoTotalAnterior +=$TotalSucursalMesAnterior[$DatSucursal->SucId];  ?>
                     <?php $OrdenVentaVehiculoTotalActual +=$OrdenVentaVehiculoTotalSucursalActual[$DatSucursal->SucId];  ?>
                    
                      
                      
                    		<?php
					?>
                    
                  
                   <tr>
                     <td width="150" align="left">
                       <?php echo $DatSucursal->SucNombre;?>
                     </td>
                     <td width="80" align="right">
                       
                      
                          <?php echo $TotalSucursalMesAnterior[$DatSucursal->SucId];?>
                   
                       
                     </td>
                   <td width="80" align="right">
                   
                   
                 <?php echo $OrdenVentaVehiculoTotalSucursalActual[$DatSucursal->SucId];?>
                   
                   </td>
                   </tr>
                   
                   
                            
                   <?php
						}
					}
				   ?>
                   
                   <tr>
                     <td width="150" align="left" class="EstTablaReporteColumnaEspecial4">TOTAL GENERAL:</td>
                     <td align="right"  class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalAnterior;?></td>
                     <td align="right"  class="EstTablaReporteColumnaEspecial4"><?php echo $OrdenVentaVehiculoTotalActual;?></td>
                   </tr>
                   <tr>
                     <td width="150" align="left">&nbsp;</td> 
                   <td width="80" align="right">&nbsp;</td> 
                   <td width="80" align="right"></td>
                   </tr>
                    </tbody>
                    </table>
                    
                    
                    </td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center"><table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                          <thead class="EstTablaReporteHead">
                            <tr>
                              <th>&nbsp;</th>
                              <th colspan="4">COMPARATIVO AL <?php echo $POST_FechaFin?></th>
                            </tr>
                          </thead>
                          <tbody class="EstTablaReporteBody">
                            
					
                        
                            <tr>
                              <td>&nbsp;</td>
                              <td align="left">MES/AÑO</td>
                              <td align="right"><?php echo $AnoTrasAnterior;?></td>
                              <td align="right"><?php echo $AnoAnterior;?></td>
                              <td align="right"><?php echo $AnoActual;?></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td width="150" align="left"><?php echo FncConvertirMes($MesActual)?></td>
                              <td width="80" align="right">
                              <?php echo $TotalAnualAnoTrasAnterior;?>
                              </td>
                              <td width="80" align="right"><?php echo $TotalAnualAnoAnterior;?></td>
                              <td width="80" align="right"><?php echo $TotalAnualAnoActual;?></td>
                            </tr>
                 
                            <tr>
                              <td></td>
                              <td width="150" align="left">&nbsp;</td>
                              <td width="80" align="right">&nbsp;</td>
                              <td width="80" align="right">&nbsp;</td>
                              <td width="80" align="right"></td>
                            </tr>
                          </tbody>
                        </table></td>
                      </tr>
                      <tr>
                      <td colspan="4">&nbsp;</td>
                    </tr>
                    </table>
                    
          
       
     

