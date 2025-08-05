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
        


///$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/01/".date("Y");
//$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
$POST_VehiculoMarca = empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca'];
$POST_Sucursal = ($_GET['Sucursal']);
$POST_Vista = ($_GET['Vista']);
$POST_Personal = ($_GET['Personal']);


$POST_Ano = isset($_GET['Ano'])?$_GET['Ano']:date("Y");
$POST_Mes = isset($_GET['Mes'])?$_GET['Mes']:date("m");

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
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
 
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


$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];



$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoNombre','ASC',NULL,$POST_VehiculoMarca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];


//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 


$PersonalNombre = "";

if(!empty($POST_Personal)){
	
	$InsPersonal = new ClsPersonal();
	$InsPersonal->PerId = $POST_Personal;
	$InsPersonal->MtdObtenerPersonal();
	
	$PersonalNombre = $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno;
	
}
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
          <td width="54%" align="center" valign="top">REPORTE DE COTIZACIONES DE VEHICULOS MENSUAL</td>
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
                      
                      <?php echo $PersonalNombre;?>
                        
                       <?php
					   switch($POST_Vista){
						   
						   case "xVersion":
						  ?>
                              <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
                    
                    <thead class="EstTablaReporteHead">
                   <tr>
                     <th>SUCURSAL</th>
                     <th>MODELO</th>
                    
                     
                     <?php
					 for($i=1;$i<=12;$i++){
					 ?>
                     <th width="25">
                     
                     <?php echo FncConvertirMes($i,true);?>
                     
                     </th>
                      <?php
						
						/*?>
                        <th width="40">&nbsp;</th>
                        <?php
						*/
						?>
                        
					<?php
					 }
					?>                     
                     <th width="50">Total</th>
                     </tr>
                    </thead>
                      <tbody class="EstTablaReporteBody">
                        <?php
						$TotalActual = 0;
						$TotalAnterior = 0;
						$TotalModelo = 0;
						$SumaTotalMensual = array();
					?>
                    
                    <?php	
					if($ArrSucursales){
						foreach($ArrSucursales as $DatSucursal){
							
						if(!empty($ArrVehiculoVersiones)){
							foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
								
							$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
						
						$TotalCotizaciones = 0;
						 for($mes=1;$mes<=12;$mes++){
							 
							 //MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL)
							 $TotalCotizaciones += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",$mes,$POST_Ano,NULL,NULL,NULL,'CveId','ASC','1',NULL,NULL,array(1,3),NULL,$POST_Personal,NULL,NULL,NULL,$POST_Sucursal,$DatVehiculoVersion->VveId);
						 }
						 
						 
					
					?>
                    		<?php
							if($TotalCotizaciones>0){
								$TotalCotizaciones = array();
						$TotalModelo=0;		
					?>
                    
                  
                   <tr>
                     <td><?php echo $DatSucursal->SucNombre;?></td>
                     <td><?php echo $DatVehiculoVersion->VmoNombre;?> <?php echo $DatVehiculoVersion->VveNombre;?></td>
                  
                    
                     
                      <?php
					
					 for($mes=1;$mes<=12;$mes++){
					 ?>
                  
                  
                   <td width="25" align="right">
                     
                     <?php
//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL) {
					$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
					 $TotalCotizaciones[$mes] = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",$mes,$POST_Ano,NULL,NULL,NULL,'CveId','ASC','1',NULL,NULL,array(1,3),NULL,$POST_Personal,NULL,NULL,NULL,$POST_Sucursal,$DatVehiculoVersion->VveId);
						
					$DiferenciaMensual = 0;
					$PorcentajeVariacionMensual = 0;
					
					if( ($mes-1) >= 0){
						
						if($TotalCotizaciones[$mes-1]>0){
							
							$DiferenciaMensual = (($TotalCotizaciones[$mes] - $TotalCotizaciones[$mes-1])/$TotalCotizaciones[$mes-1]);
							$PorcentajeVariacionMensual = $DiferenciaMensual * 100;
							$PorcentajeVariacionMensual = round($PorcentajeVariacionMensual,2);
							
						}
						
						
						 
					}
					
					$SumaTotalMensual[$mes] +=   $TotalCotizaciones[$mes];
					 ?>
                 <!--  (  <?php echo ($mes-1);?>)-->
                     <?php echo $TotalCotizaciones[$mes];?>
                     
                     </td>
                        
                        
                        <?php
						/*
						?>
                        
                        <td width="40" align="right">
                        
                       
                            <?php
					 if($DiferenciaMensual>0){
						?>
                      
                   <img src="imagenes/flecha_arriba.png" width="15" height="15" />  <?php echo $PorcentajeVariacionMensual;?>%
                        <?php 
					 }elseif($DiferenciaMensual<0){
						?> <img src="imagenes/flecha_abajo.png" width="15" height="15" />  <?php echo $PorcentajeVariacionMensual;?>%
                        <?php 
					 }
					
					 ?>
                        
                        </td>
                        <?php
						*/
						?>
                        
					<?php
						$TotalModelo += $TotalCotizaciones[$mes];
					 }
					?>             
                    
                    <td width="50" align="right"><?php echo $TotalModelo;?></td> 
                   
                     <?php		
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
                     <td class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                     <td class="EstTablaReporteColumnaEspecial4">TOTALES:</td>
                    
                       <?php
					   $SumaTotalCotizacionesAnual = 0;
					 for($mes=1;$mes<=12;$mes++){
					 ?>
                    
                     <td width="25" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $SumaTotalMensual[$mes];?></td>
                       <?php
						/*
						?>
                        
                      <td width="40" align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                      
                       <?php
						*/
						?>
                      
                      <?php
					  $SumaTotalCotizacionesAnual += $SumaTotalMensual[$mes];;;
					}
				   ?>
                     
                     <td width="50" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo  $SumaTotalCotizacionesAnual;?></td>
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
                     <th>SUCURSAL</th>
                     <th>MODELO</th>
                    
                     
                     <?php
					 for($i=1;$i<=12;$i++){
					 ?>
                     <th width="25">
                     
                     <?php echo FncConvertirMes($i,true);?>
                     
                     </th>
                      <?php
						
						/*?>
                        <th width="40">&nbsp;</th>
                        <?php
						*/
						?>
                        
					<?php
					 }
					?>                     
                     <th width="50">Total</th>
                     </tr>
                    </thead>
                      <tbody class="EstTablaReporteBody">
                        <?php
						$TotalActual = 0;
						$TotalAnterior = 0;
						$TotalModelo = 0;
						$SumaTotalMensual = array();
					?>
                    
                    <?php	
					if($ArrSucursales){
						foreach($ArrSucursales as $DatSucursal){
							
						if(!empty($ArrVehiculoModelos)){
							foreach($ArrVehiculoModelos as $DatVehiculoModelo){
								
							$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
						
						$TotalCotizaciones = 0;
						 for($mes=1;$mes<=12;$mes++){
							 
							 //MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL)
							 $TotalCotizaciones += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",$mes,$POST_Ano,NULL,NULL,NULL,'CveId','ASC','1',NULL,NULL,array(1,3),NULL,$POST_Personal,NULL,$DatVehiculoModelo->VmoId,NULL,$POST_Sucursal,NULL);
						 }
						 
						 
					
					?>
                    		<?php
							if($TotalCotizaciones>0){
								$TotalCotizaciones = array();
						$TotalModelo=0;		
					?>
                    
                  
                   <tr>
                     <td><?php echo $DatSucursal->SucNombre;?></td>
                     <td><?php echo $DatVehiculoModelo->VmoNombre;?></td>
                  
                    
                     
                      <?php
					
					 for($mes=1;$mes<=12;$mes++){
					 ?>
                  
                  
                   <td width="25" align="right">
                     
                     <?php
////MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL)
					$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
					 $TotalCotizaciones[$mes] = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",$mes,$POST_Ano,NULL,NULL,NULL,'CveId','ASC','1',NULL,NULL,array(1,3),NULL,$POST_Personal,NULL,$DatVehiculoModelo->VmoId,NULL,$POST_Sucursal,NULL);
						
					$DiferenciaMensual = 0;
					$PorcentajeVariacionMensual = 0;
					
					if( ($mes-1) >= 0){
						
						if($TotalCotizaciones[$mes-1]>0){
							
							$DiferenciaMensual = (($TotalCotizaciones[$mes] - $TotalCotizaciones[$mes-1])/$TotalCotizaciones[$mes-1]);
							$PorcentajeVariacionMensual = $DiferenciaMensual * 100;
							$PorcentajeVariacionMensual = round($PorcentajeVariacionMensual,2);
							
						}
						
						
						 
					}
					
					$SumaTotalMensual[$mes] +=   $TotalCotizaciones[$mes];
					 ?>
                 <!--  (  <?php echo ($mes-1);?>)-->
                     <?php echo $TotalCotizaciones[$mes];?>
                     
                     </td>
                        
                        
                        <?php
						/*
						?>
                        
                        <td width="40" align="right">
                        
                       
                            <?php
					 if($DiferenciaMensual>0){
						?>
                      
                   <img src="imagenes/flecha_arriba.png" width="15" height="15" />  <?php echo $PorcentajeVariacionMensual;?>%
                        <?php 
					 }elseif($DiferenciaMensual<0){
						?> <img src="imagenes/flecha_abajo.png" width="15" height="15" />  <?php echo $PorcentajeVariacionMensual;?>%
                        <?php 
					 }
					
					 ?>
                        
                        </td>
                        <?php
						*/
						?>
                        
					<?php
						$TotalModelo += $TotalCotizaciones[$mes];
					 }
					?>             
                    
                    <td width="50" align="right"><?php echo $TotalModelo;?></td> 
                   
                     <?php		
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
                     <td class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                     <td class="EstTablaReporteColumnaEspecial4">TOTALES:</td>
                    
                       <?php
					   $SumaTotalCotizacionesAnual = 0;
					 for($mes=1;$mes<=12;$mes++){
					 ?>
                    
                     <td width="25" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo $SumaTotalMensual[$mes];?></td>
                       <?php
						/*
						?>
                        
                      <td width="40" align="right" class="EstTablaReporteColumnaEspecial4">&nbsp;</td>
                      
                       <?php
						*/
						?>
                      
                      <?php
					  $SumaTotalCotizacionesAnual += $SumaTotalMensual[$mes];;;
					}
				   ?>
                     
                     <td width="50" align="right" class="EstTablaReporteColumnaEspecial4"><?php echo  $SumaTotalCotizacionesAnual;?></td>
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
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                      <tr>
                      <td colspan="4">&nbsp;</td>
                    </tr>
                    </table>
                    
          
       
     

