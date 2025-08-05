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
        require_once($InsProyecto->MtdRutLibrerias().'libchart/classes/libchart.php');
require_once($InsProyecto->MtdRutLibrerias().'phplot-6.2.0/phplot.php');


//deb($_GET);
$POST_FechaInicio = isset($_GET['CmpFechaInicio'])?$_GET['CmpFechaInicio']:"01/01/".date("Y");
$POST_FechaFin = isset($_GET['CmpFechaFin'])?$_GET['CmpFechaFin']:date("d/m/Y");
$POST_VehiculoMarca = empty($_GET['CmpVehiculoMarca'])?"VMA-10017":$_GET['CmpVehiculoMarca'];
$POST_Sucursal = ($_GET['CmpSucursal']);
//$POST_Vista = ($_GET['Vista']);

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
require_once($InsPoo->MtdPaqLogistica().'ClsTipoReferido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
 
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();
$InsPersonal = new ClsPersonal();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsTipoReferido = new ClsTipoReferido();

$InsVehiculoMarca->VmaId = $POST_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();

$VehiculoMarca = $InsVehiculoMarca->VmaNombre;

//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL) 
$ResVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,$POST_VehiculoMarca,NULL,1,1);
$ArrVehiculoVersiones = $ResVehiculoVersion['Datos'];

//MtdObtenerVehiculoModelos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoNombre','ASC',NULL,$POST_VehiculoMarca,1,1);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];





  
$ResTipoReferido = $InsTipoReferido->MtdObtenerTipoReferidos("TrfNombre",$POST_fil,$POST_ord,$POST_sen,"",$POST_Tipo,$POST_Estado);
$ArrTipoReferidos = $ResTipoReferido['Datos'];
 


//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL) 
?>


<?php
if($_GET['P']<>2){
?>
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">-->
<link rel="stylesheet" type="text/css" href="../../estilos/CssReporte.css">
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
          <td width="54%" align="center" valign="top">DASHBOARD MARKETING</td>
          <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
        
            <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
        </tr>
        </table>
        
        <hr class="EstReporteLinea">
        
        <?php }?>
                
		<?php
		
		?>
                     
                    <table class="EstTablaReporte" width="100%">
                  <tbody class="EstTablaReporteBody">
                    <tr>
                      <td   colspan="4">
                  
                  
                        
                        
                        
                      
                    
                    
                    
                    
                    
                      </td>
                    </tr>
                    
                      <tr>
                      <td width="38%" align="center">
                      </td>
                      <td width="38%" align="center">&nbsp;</td>
                      <td width="23%" align="center">&nbsp;</td>
                      <td width="1%" align="center">&nbsp;</td>
                      </tr>
                    
                      <tr>
                        <td colspan="2" align="center" valign="top">
                        
                        
                      
                        
                        <div class="EstReporteCapa">
                          <span class="EstReporteTitulo">COMPARATIVO DE CANALES DE VENTA</span><br />
                          
                          
                          
<?php


	$chart = new VerticalBarChart(800);


	$serie1 = new XYDataSet();
	$serie2 = new XYDataSet();
	$serie3 = new XYDataSet();
	
	$TotalModeloTipoReferido = 0;
	$TotalModeloTipoReferidoMesAnterior = 0;
	$TotalModeloTipoReferidoAnoAnterior = 0;
	
	foreach($ArrTipoReferidos as $DatTipoReferido){
		
		$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
		//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL,$oTipoReferido=NULL) {
		$TotalModeloTipoReferido = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','Desc','1',FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"1,3",NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,NULL,$DatTipoReferido->TrfId);
		$TotalModeloTipoReferidoMesAnterior = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','Desc','1',FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),"1,3",NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,NULL,$DatTipoReferido->TrfId);
		$TotalModeloTipoReferidoAnoAnterior = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','Desc','1',FncCambiaFechaAMysql($FechaFinComparativoAnoAnteriorInicio),FncCambiaFechaAMysql($FechaFinComparativoAnoAnteriorFin),"1,3",NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,NULL,$DatTipoReferido->TrfId);
		
		$serie1->addPoint(new Point($DatTipoReferido->TrfNombre, $TotalModeloTipoReferido));
		$serie2->addPoint(new Point($DatTipoReferido->TrfNombre, $TotalModeloTipoReferidoMesAnterior));
		$serie3->addPoint(new Point($DatTipoReferido->TrfNombre, $TotalModeloTipoReferidoAnoAnterior));
		
	}

	$dataSet = new XYSeriesDataSet();
	$dataSet->addSerie("Canales de Venta al ".$POST_FechaFin, $serie1);
	$dataSet->addSerie("Canales de Venta al ".$FechaFinComparativo, $serie2);
	$dataSet->addSerie("Canales de Venta al ".$FechaFinComparativoAnoAnteriorFin, $serie3);
	
	
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphCaptionRatio(0.8);
 
	//$chart->getPlot()->setGraphPadding(new Padding(0, 0, 0, 0));
	
	$chart->getPlot()->getPalette()->setBarColor(array( 
		new Color(251, 48, 52),//ROJO
		new Color(50, 183, 67),//VERDE
		new Color(33, 158, 180),//AZUL,
		new Color(219, 213, 179),//CREMA
		new Color(0, 134, 153)//AZUL OSCURO
	));
	
	
	$chart->setTitle("");
	$chart->render("../../generados/reportes/MarketingCanalesVentaComparativo".$Identificador.".png");
    
?>

<img alt="CANALES DE VENTA / COMPARATIVO"  src="../../generados/reportes/MarketingCanalesVentaComparativo<?php echo $Identificador;?>.png" /></p>
    
    
    
    
                            
                        </div>
                        
                        
                        
                        </td>
                        <td rowspan="5" align="center" valign="top">
                          
                        <div class="EstReporteCapa">
                       
                     <span class="EstReporteTitulo">CANALES DE VENTA
                      </span><br />
                      
                        <table width="200"  cellpadding="2" cellspacing="2" class="EstTablaReporte">
                          <thead class="EstTablaReporteHead">
                          </thead>
                          <tbody class="EstTablaReporteBody">
                            <?php
                    foreach($ArrTipoReferidos as $DatTipoReferido){
						
					 	 
                    ?>
                            <tr>
                              <td align="left"><?php
					echo $DatTipoReferido->TrfNombre;
					?></td>
                              <td align="right"><?php

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL,$oTipoReferido=NULL) {
$TotalModeloTipoReferido = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','Desc','1',FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"1,3",NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,NULL,$DatTipoReferido->TrfId);

?>
                                <?php
echo  $TotalModeloTipoReferido;
?></td>
                            </tr>
                            <?php
					}
					?>
                          </tbody>
                        </table>
                        
                        
                        </div>
                        
                        </td>
                        <td align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center" valign="top">
                        
                          
                       
                         
                         
                         
                         <div class="EstReporteCapa">
                        
                         <span class="EstReporteTitulo">COTIZACIONES X MODELO</span><br />
                         
                        
<?php
	
	$chart = new PieChart();
	
	$chart->getPlot()->getPalette()->setPieColor(array(
		new Color(251, 48, 52),//ROJO
		new Color(50, 183, 67),//VERDE
		new Color(33, 158, 180),//AZUL,
		new Color(219, 213, 179),//CREMA
		new Color(0, 134, 153)//AZUL OSCURO
	));
	
	$dataSet = new XYDataSet();
	
	
	$CotizacionVehiculoTotal = 0;
	 
  	if(!empty($ArrVehiculoModelos)){
		foreach($ArrVehiculoModelos as $DatVehiculoModelo){
		
			if(!empty($ArrSucursales)){
				foreach($ArrSucursales as $DatSucursal){
						
					//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL,$oTipoReferido=NULL)
					$CotizacionVehiculoTotal  = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
						 
					$dataSet->addPoint(new Point($DatVehiculoModelo->VmoNombre, $CotizacionVehiculoTotal));
					
				}
			}
 					
		}
	}
					
					
?>                       
 

                          
<?php

	$chart->setDataSet($dataSet);
	//$chart->getPlot()->setGraphPadding(new Padding(0, 0, 0, 0));

	$chart->setTitle("");
	$chart->render("../../generados/reportes/MarketingCotizacionesxModeo".$Identificador.".png");
    
?>

<img alt="COTIZACIONES X MODELO"  src="../../generados/reportes/MarketingCotizacionesxModeo<?php echo $Identificador;?>.png" /></p>
    
    
    
    
                        
                        
                        
                        </div>
                        
                        </td>
                        <td align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center" valign="top">
                          
                          
                          
  <div class="EstReporteCapa">
    
    <span class="EstReporteTitulo">VENTAS X ASESOR</span><br />
    
    <?php


//MtdObtenerCotizacionVehiculoPersonales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oVehiculoMarca=NULL) 
$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculoPersonales(NULL,NULL,NULL,'PerNombre','ASC','',FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_Sucursal,$POST_VehiculoMarca);
$ArrCotizacionVehiculoPersonales = $ResCotizacionVehiculo['Datos'];
?>
    
    
    <?php
	 
 
//INICIO CHART


	
	
	

$chart = new HorizontalBarChart();
$dataSet = new XYDataSet();
$Identificador = rand();

//VARIABLES
if(!empty($ArrCotizacionVehiculoPersonales)){
	foreach($ArrCotizacionVehiculoPersonales as $DatCotizacionVehiculoPersonal){
		
		
		
					$CotizacionVehiculoTotal = 0;
					$CotizacionVehiculoAnteriorTotal = 0;
					
					$OrdenVentaVehiculoTotal = 0;
					$OrdenVentaVehiculoAnteriorTotal = 0;
					
					if(!empty($ArrSucursales)){
						foreach($ArrSucursales as $DatSucursal){
//		
							if(!empty($ArrVehiculoModelos)){
								foreach($ArrVehiculoModelos as $DatVehiculoModelo){
									
									//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL,$oTipoReferido=NULL)
									$CotizacionVehiculoTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
									
									$CotizacionVehiculoAnteriorTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
											 
								 	
									$OrdenVentaVehiculoTotal += $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(3,4,5),NULL,$DatCotizacionVehiculoPersonal->PerId,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
								
									$OrdenVentaVehiculoAnteriorTotal += $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(3,4,5),NULL,$DatCotizacionVehiculoPersonal->PerId,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
											 
											 
									
								}
							}
 					
						}
					}
	 				
 	 	if($OrdenVentaVehiculoTotal>0){
			$dataSet->addPoint(new Point($DatCotizacionVehiculoPersonal->PerNombre, round($OrdenVentaVehiculoTotal,2)));
		}
	 	
	}
				
}
  
?>
    
  <?php

	$chart->setDataSet($dataSet);
	$chart->getPlot()->getPalette()->setBarColor(array( 
		new Color(251, 48, 52),//ROJO
		new Color(50, 183, 67),//VERDE
		new Color(33, 158, 180),//AZUL,
		new Color(219, 213, 179),//CREMA
		new Color(0, 134, 153)//AZUL OSCURO
	));


 

//$chart->getPlot()->setGraphPadding(new Padding(90, 0, 0, 0));
 
		$chart->setTitle("");
	$chart->render("../../generados/reportes/MarketingVentasxAsesor".$Identificador.".png");
    
?>
    
  <img alt="VENTAS X ASESOR"  src="../../generados/reportes/MarketingVentasxAsesor<?php echo $Identificador;?>.png" /> 
    
    
    
    </div>
                          
                          
                        </td>
                        <td align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center" valign="top">
                        
                        <div class="EstReporteCapa">
                        <span class="EstReporteTitulo">VENTAS X MODELOS</span><br />
                        
                            <?php
  
 $chart = new HorizontalBarChart(670, 370);
$dataSet = new XYDataSet();
$Identificador = rand();

	 
	if(!empty($ArrVehiculoModelos)){
		foreach($ArrVehiculoModelos as $DatVehiculoModelo){
				
			$CotizacionVehiculoTotal = 0;
			$CotizacionVehiculoAnteriorTotal = 0;
			
			$OrdenVentaVehiculoTotal = 0;
			$OrdenVentaVehiculoAnteriorTotal = 0;
			
			if(!empty($ArrSucursales)){
				foreach($ArrSucursales as $DatSucursal){
	//		
						 
						
							//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL) {
							$OrdenVentaVehiculoTotal += $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(3,4,5),NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
							 		 
									 
				}
			}
			
			if($OrdenVentaVehiculoTotal>0){
			$dataSet->addPoint(new Point($DatVehiculoModelo->VmoNombre, round($OrdenVentaVehiculoTotal,2)));
			}
//		
			}
		}
		
		
  ?>                    
                            
                            
                            <?php
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphPadding(new Padding(90, 0, 0, 0));
	$chart->getPlot()->getPalette()->setBarColor(array( 
		new Color(251, 48, 52),//ROJO
		new Color(50, 183, 67),//VERDE
		new Color(33, 158, 180),//AZUL,
		new Color(219, 213, 179),//CREMA
		new Color(0, 134, 153)//AZUL OSCURO
	));
	

		$chart->setTitle("");
	$chart->render("../../generados/reportes/MarketingVentasxModelo".$Identificador.".png");
    
?>
                            <img alt="VENTAS X MODELO"  src="../../generados/reportes/MarketingVentasxModelo<?php echo $Identificador;?>.png" /> 
    
    
    
    </div>
    
    
                        </td>
                        <td align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="center" valign="top">
                        
                        
                      
                          <div class="EstReporteCapa">
                          <span class="EstReporteTitulo">TOTAL VENTAS</span><br />
                          
                          
                          
                          
                          <?php
  
 $chart = new HorizontalBarChart(350, 650);
$dataSet = new XYDataSet();
$Identificador = rand();


	for($i=1;$i<=12;$i++){
		
		$OrdenVentaVehiculoTotal = 0;
			 
		if(!empty($ArrVehiculoModelos)){
			foreach($ArrVehiculoModelos as $DatVehiculoModelo){
			 
				if(!empty($ArrSucursales)){
					foreach($ArrSucursales as $DatSucursal){
						
						
						//$DiaActual,$MesActual,$AnoActual
						$CantidadDias = FncCantidadDiaMes($AnoActual,$i);
						
				//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL) {
						$OrdenVentaVehiculoTotal += $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql("01"."/".$i."/".$AnoActual),FncCambiaFechaAMysql($CantidadDias."/".$i."/".$AnoActual),array(3,4,5),NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
										 
										 
					}
				}
	
			}
		}
		
		
			if($OrdenVentaVehiculoTotal>0){
				$dataSet->addPoint(new Point(FncConvertirMes($i), round($OrdenVentaVehiculoTotal,2)));
			}
		
	}
	 
	
		
		
  ?>                    
                            
                            
                            <?php
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphPadding(new Padding(90, 0, 0, 0));
	$chart->getPlot()->getPalette()->setBarColor(array( 
		new Color(251, 48, 52),//ROJO
		new Color(50, 183, 67),//VERDE
		new Color(33, 158, 180),//AZUL,
		new Color(219, 213, 179),//CREMA
		new Color(0, 134, 153)//AZUL OSCURO
	));
	

		$chart->setTitle("");
	$chart->render("../../generados/reportes/MarketingTotalVentas".$Identificador.".png");
    
?>


<img alt="TOTAL DE VENTAS"  src="../../generados/reportes/MarketingTotalVentas<?php echo $Identificador;?>.png" /> 
    
    
    
    
    
                           
                        
                        </div>
                        
                        </td>
                      <td align="center" valign="top"><!--<img src="../../imagenes/grafico2.png" alt="" width="300" height="300" />-->
                       
                    
                    
                     <div class="EstReporteCapa">
                     <span class="EstReporteTitulo">ROI</span>
                      <img src="../../imagenes/grafico3.png" width="214" height="201" /> 
                        
                        </div>
                        
                        
                        </td>
                      <td align="center">&nbsp;</td>
                      </tr>
                    </table>
                    
          
       
     

