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

//if(empty($POST_Personal)){
//	$PersonalNombre = "Todos";
//}else{
//	$InsPersonal->PerId = $POST_Personal;
//	$InsPersonal->MtdObtenerPersonal(false);	
//	$PersonalNombre = $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno;
//}


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
                      <td width="3456" colspan="4" align="center">
                        
                        
                        



<?php


//MtdObtenerCotizacionVehiculoPersonales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oVehiculoMarca=NULL) 
$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculoPersonales(NULL,NULL,NULL,'PerNombre','ASC','',FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_Sucursal,$POST_VehiculoMarca);
$ArrCotizacionVehiculoPersonales = $ResCotizacionVehiculo['Datos'];
?>

Indice de Ventas x Asesor de Ventas


		   <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
			
		    <thead class="EstTablaReporteHead">
			
<tr>
<th class='EstCabecera' width='250'> Asesores de Ventas
</th>
<th class='EstCabecera' width='150'>Cotizaciones  <?php echo $FechaFinComparativoInicio;?> - <?php echo $FechaFinComparativo?></th>
<th class='EstCabecera' width='150'>Ventas <?php echo $FechaFinComparativoInicio;?> - <?php echo $FechaFinComparativo?></th>

			
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
 <tbody class="EstTablaReporteBody">			
<?php	
			//$TotalActual = 0;

			$SumaTotalCotizaciones = 0;
			$SumaTotalVentas = 0;
			
			$SumaTotalCotizacionesAnterior = 0;
			$SumaTotalVentasAnterior = 0;
?>

<?php		
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
//					
						}
					}
					  
?>

<?php
//if(	$CotizacionVehiculoTotal>0 or $OrdenVentaVehiculoTotal>0){
?>



<tr>
			
<td align="right">
						<?php echo $DatCotizacionVehiculoPersonal->PerNombre." ".$DatCotizacionVehiculoPersonal->PerApellidoPaterno." ".$DatCotizacionVehiculoPersonal->PerApellidoMaterno;?>
		  </td>
<td align='right'><?php echo ($CotizacionVehiculoAnteriorTotal);?></td>
<td align='right'><?php echo ($OrdenVentaVehiculoAnteriorTotal);?></td>
						
					
						
						
						 <?php //$TotalActual += $CotizacionVehiculoTotal;?>
						 
						<td align='right'>
						<?php echo ($CotizacionVehiculoTotal);?>
                        
						</td>
                        
                        <td align='right'>
                        
                        
                        <?php echo ($OrdenVentaVehiculoTotal);?>
                        
                        </td> 
                        <td align='right'>
                        
                        <?php
						
						$Indice = 0;
						
						if($CotizacionVehiculoTotal>0){
							
							$Indice = $OrdenVentaVehiculoTotal/$CotizacionVehiculoTotal;
							
						}else{						
							
							$Indice = 0;
						
						}
						
						$Indice = $Indice * 100;
						
						?>
                        
						<?php echo round($Indice,2);?> %
                        
                        </td>
						  
</tr>
<?php	

						$SumaTotalCotizaciones += $CotizacionVehiculoTotal;
						$SumaTotalVentas +=$OrdenVentaVehiculoTotal ;
						
						$SumaTotalCotizacionesAnterior += $CotizacionVehiculoAnteriorTotal;
						$SumaTotalVentasAnterior +=$OrdenVentaVehiculoAnteriorTotal ;
						 
//}
?>
<?php										
				
				}
			}
?>
	
		  
<tr>
<td align="right">
			
<!--<b>
TOTAL:
</b>
		-->
        <span class="EstTablaReporteEtiquetaTotal">
        Total:
        
        </span>
        </td>
<td align='right'><span class="EstTablaReporteContenidoTotal">
  <?php
echo $SumaTotalCotizacionesAnterior;
?>
</span></td>
<td align='right'><span class="EstTablaReporteContenidoTotal">
  <?php
echo $SumaTotalVentasAnterior;
?>
</span></td>
			
<td align='right'>


   <span class="EstTablaReporteContenidoTotal">
       <?php
echo $SumaTotalCotizaciones;
?>
        
        </span>
        

</td>
			
<td align='right'>

   <span class="EstTablaReporteContenidoTotal">
<?php
echo $SumaTotalVentas;
?></span>

</td>
	<td align='right'>
    
     					 <?php
						
						$SumaTotalIndice = 0;
						if($SumaTotalCotizaciones>0){
							
							$SumaTotalIndice = $SumaTotalVentas/$SumaTotalCotizaciones;
							
						}else{						
							
							$SumaTotalIndice = 0;
						
						}
						
						?>
                        
			<?php //echo round($SumaTotalIndice,2);?></td>
  
</tr>
							 
		</tbody>	
</table>
			
		

                      </td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">
                        

Indice de Ventas x Modelos


		   <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
			
		    <thead class="EstTablaReporteHead">
			
<tr>
<th class='EstCabecera' width='250'> Modelos
</th>
<th class='EstCabecera' width='150'>Cotizaciones <?php echo $FechaFinComparativoInicio;?> - <?php echo $FechaFinComparativo?></th>
<th class='EstCabecera' width='150'>Ventas <?php echo $FechaFinComparativoInicio;?> - <?php echo $FechaFinComparativo?></th>

			
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
 <tbody class="EstTablaReporteBody">			
<?php	
			//$TotalActual = 0;
			$SumaTotalCotizaciones = 0;
			$SumaTotalCotizacionesAnterior = 0;
			
			$SumaTotalVentas = 0;
			$SumaTotalVentasAnterior = 0;
?>

<?php		
			if(!empty($ArrVehiculoModelos)){
				foreach($ArrVehiculoModelos as $DatVehiculoModelo){
						
					$CotizacionVehiculoTotal = 0;
					$CotizacionVehiculoAnteriorTotal = 0;
					
					$OrdenVentaVehiculoTotal = 0;
					$OrdenVentaVehiculoAnteriorTotal = 0;
					
					if(!empty($ArrSucursales)){
						foreach($ArrSucursales as $DatSucursal){
//		
									
									//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL,$oTipoReferido=NULL)
									$CotizacionVehiculoTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
									
									$CotizacionVehiculoAnteriorTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
								
								
									//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL) {
									$OrdenVentaVehiculoTotal += $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(3,4,5),NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
									
									$OrdenVentaVehiculoAnteriorTotal += $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(3,4,5),NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
											 
											 
						}
					}
					  
?>


<?php
				if(	$CotizacionVehiculoTotal>0 or $OrdenVentaVehiculoTotal>0){
?>

				

<tr>
			
<td align="right">
						<span title="<?php echo $DatVehiculoModelo->VmoId;?>"><?php echo $DatVehiculoModelo->VmoNombre;?></span>
		  </td>
<td align='right'><?php echo ($CotizacionVehiculoAnteriorTotal);?></td>
<td align='right'><?php echo ($OrdenVentaVehiculoAnteriorTotal);?></td>
						
					
						
						
						 <?php //$TotalActual += $CotizacionVehiculoTotal;?>
						 
						<td align='right'>
						<?php echo ($CotizacionVehiculoTotal);?>
                        
						</td>
                        
                        <td align='right'>
                        
                        
                        <?php echo ($OrdenVentaVehiculoTotal);?>
                        
                        </td> 
                        <td align='right'>
                        
                        <?php
						
						$Indice = 0;
						
						if($CotizacionVehiculoTotal>0){
							
							$Indice = $OrdenVentaVehiculoTotal/$CotizacionVehiculoTotal;
							
						}else{						
							
							$Indice = 0;
						
						}
						
						$Indice = $Indice * 100;
						
						?>
                        
						<?php echo round($Indice,2);?> %
                        
                        </td>
						  
</tr>

<?php						

						$SumaTotalCotizaciones += $CotizacionVehiculoTotal;
						$SumaTotalVentas += $OrdenVentaVehiculoTotal;
						
						$SumaTotalCotizacionesAnterior += $CotizacionVehiculoAnteriorTotal;
						$SumaTotalVentasAnterior +=$OrdenVentaVehiculoAnteriorTotal ;
						
				
				
				}
			
?>

<?php										
				
				}
			}
?>
	
		  
<tr>
<td align="right">
			
 
        
        
         <span class="EstTablaReporteEtiquetaTotal">
        Total:
        
        </span>
          
</td>
<td align='right'><span class="EstTablaReporteContenidoTotal">
  <?php
echo $SumaTotalCotizacionesAnterior;
?>
</span></td>
<td align='right'><span class="EstTablaReporteContenidoTotal">
  <?php
echo $SumaTotalVentasAnterior;
?>
</span></td>
			
<td align='right'>


   <span class="EstTablaReporteContenidoTotal"><?php
echo $SumaTotalCotizaciones;
?></span></td>
			
<td align='right'>

   <span class="EstTablaReporteContenidoTotal"><?php
echo $SumaTotalVentas;
?></span></td>
	<td align='right'>-
    </td>
  
</tr>
							 
		</tbody>	
</table>




</td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">
                        
                        
                        Indice de Ventas x Sucursal
                        
                        
                        <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
			
		    <thead class="EstTablaReporteHead">
			
<tr>
<th class='EstCabecera' width='250'> Sucursal</th>
<th class='EstCabecera' width='150'>Cotizaciones <?php echo $FechaFinComparativoInicio;?> - <?php echo $FechaFinComparativo?></th>
<th class='EstCabecera' width='150'>Ventas <?php echo $FechaFinComparativoInicio;?> - <?php echo $FechaFinComparativo?></th>

			
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
 <tbody class="EstTablaReporteBody">			
<?php	
			//$TotalActual = 0;
			
			$SumaTotalCotizaciones = 0;
			$SumaTotalCotizacionesAnterior = 0;
			
			$SumaTotalVentas = 0;
			$SumaTotalVentasAnterior = 0;
			 
						
?>

<?php		
			if(!empty($ArrSucursales)){
				foreach($ArrSucursales as $DatSucursal){
						
					$CotizacionVehiculoTotal = 0;
					$CotizacionVehiculoAnteriorTotal = 0;
					
					$OrdenVentaVehiculoTotal = 0;
					$OrdenVentaVehiculoAnteriorTotal = 0;
					
					if(!empty($ArrVehiculoModelos)){
								foreach($ArrVehiculoModelos as $DatVehiculoModelo){
							
						
									//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL,$oTipoReferido=NULL)
									$CotizacionVehiculoTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
									
									$CotizacionVehiculoAnteriorTotal += $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
								
								
									//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL) {
									$OrdenVentaVehiculoTotal += $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(3,4,5),NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
									
									$OrdenVentaVehiculoAnteriorTotal += $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(3,4,5),NULL,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
									
						}
					}
				
?>


<?php
if(	$CotizacionVehiculoTotal>0 or $OrdenVentaVehiculoTotal>0){
?>

<tr>
			
<td align="right">
						<span title="<?php echo $DatSucursal->SucId;?>"><?php echo $DatSucursal->SucNombre;?></span>
		  </td>
<td align='right'><?php echo ($CotizacionVehiculoAnteriorTotal);?></td>
<td align='right'><?php echo ($OrdenVentaVehiculoAnteriorTotal);?></td>
						
					
						
						
						 <?php //$TotalActual += $CotizacionVehiculoTotal;?>
						 
						<td align='right'>
						<?php echo ($CotizacionVehiculoTotal);?>
                        
						</td>
                        
                        <td align='right'>
                        
                        
                        <?php echo ($OrdenVentaVehiculoTotal);?>
                        
                        </td> 
                        <td align='right'>
                        
                        <?php
						
						$Indice = 0;
						
						if($CotizacionVehiculoTotal>0){
							
							$Indice = $OrdenVentaVehiculoTotal/$CotizacionVehiculoTotal;
							
						}else{						
							
							$Indice = 0;
						
						}
						
						
						$Indice = $Indice * 100;
						
						
						?>
                        
						<?php echo round($Indice,2);?> %
                        
                        </td>
						  
</tr>
<?php										
				
				}
			
?>

<?php					
						$SumaTotalCotizaciones += $CotizacionVehiculoTotal;
						$SumaTotalVentas += $OrdenVentaVehiculoTotal;	
						
					
						$SumaTotalCotizacionesAnterior += $CotizacionVehiculoAnteriorTotal;
						$SumaTotalVentasAnterior +=$OrdenVentaVehiculoAnteriorTotal ;
						
						
						
				
				}
			}
?>
	
		  
<tr>
<td align="right">
   
         <span class="EstTablaReporteEtiquetaTotal">
        Total:
        
        </span>
        
          
</td>
<td align='right'><span class="EstTablaReporteContenidoTotal">
  <?php
echo $SumaTotalCotizacionesAnterior;
?>
</span></td>
<td align='right'><span class="EstTablaReporteContenidoTotal">
  <?php
echo $SumaTotalVentasAnterior;
?>
</span></td>
<td align='right'>


   <span class="EstTablaReporteContenidoTotal">
   <?php
echo $SumaTotalCotizaciones;
?></span></td>
<td align='right'>

   <span class="EstTablaReporteContenidoTotal">
   <?php
echo $SumaTotalVentas;
?></span></td>
			
<td align='right'>-
</td>
  
</tr>
							 
		</tbody>	
</table>


</td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">
                        

<?php
if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
?>


<?php
//MtdObtenerCotizacionVehiculoPersonales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oVehiculoMarca=NULL) 
$ResCotizacionVehiculo = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculoPersonales(NULL,NULL,NULL,'PerNombre','ASC','',FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($POST_FechaFin),$DatSucursal->SucId,$POST_VehiculoMarca);
$ArrCotizacionVehiculoPersonales = $ResCotizacionVehiculo['Datos'];
?> 
    




		   <table class="EstTablaReporte" cellpadding="2" cellspacing="2">
			
		    <thead class="EstTablaReporteHead">
			
<tr>
  <th colspan="6" class='EstCabecera'>
  
  <?php echo $DatSucursal->SucNombre;?>
  </th>
  </tr>
<tr>
<th class='EstCabecera' width='250'> Asesores de Ventas / Modelo
</th>
<th class='EstCabecera' width='150'>Cotizaciones <?php echo $FechaFinComparativoInicio;?> - <?php echo $FechaFinComparativo?></th>
<th class='EstCabecera' width='150'>Ventas <?php echo $FechaFinComparativoInicio;?> - <?php echo $FechaFinComparativo?></th>

			
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
 <tbody class="EstTablaReporteBody">			


<?php		
			if(!empty($ArrCotizacionVehiculoPersonales)){
				foreach($ArrCotizacionVehiculoPersonales as $DatCotizacionVehiculoPersonal){
?>

<?php	
			//$TotalActual = 0;

			$SumaTotalCotizaciones = 0;
			$SumaTotalCotizacionesAnterior = 0;
			
			$SumaTotalVentas = 0;
			$SumaTotalVentasAnterior = 0;
?>




<tr>

<td align="right">
<span class="EstTablaReporteEtiqueta">
<?php echo strtoupper($DatCotizacionVehiculoPersonal->PerNombre." ".$DatCotizacionVehiculoPersonal->PerApellidoPaterno." ".$DatCotizacionVehiculoPersonal->PerApellidoMaterno);?>
</span>

</td>
<td align='center'>&nbsp;</td>
<td align='center'>&nbsp;</td>

<td align='center'>&nbsp;</td>
<td align='center'>&nbsp;</td> 
<td align='center'>&nbsp;</td>

</tr>

<?php		
	
		$CotizacionVehiculoTotal = 0;
		$CotizacionVehiculoAnteriorTotal = 0;
		
		$OrdenVentaVehiculoTotal = 0;
		$OrdenVentaVehiculoAnteriorTotal = 0;
		
		if(!empty($ArrVehiculoModelos)){
			foreach($ArrVehiculoModelos as $DatVehiculoModelo){
		
				
				//if(!empty($ArrSucursales)){
				//	foreach($ArrSucursales as $DatSucursal){
	
						//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVehiculoVersion=NULL,$oTipoReferido=NULL)
						$CotizacionVehiculoTotal = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
						
						$CotizacionVehiculoAnteriorTotal = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(1,3),NULL,$DatCotizacionVehiculoPersonal->PerId,NULL,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
								
								
						//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL,$oVersion=NULL,$oAnoFabricacion=NULL) {
						$OrdenVentaVehiculoTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaActualInicio),FncCambiaFechaAMysql($POST_FechaFin),array(3,4,5),NULL,$DatCotizacionVehiculoPersonal->PerId,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL);
						
						$OrdenVentaVehiculoAnteriorTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','ASC',NULL,FncCambiaFechaAMysql($FechaFinComparativoInicio),FncCambiaFechaAMysql($FechaFinComparativo),array(3,4,5),NULL,$DatCotizacionVehiculoPersonal->PerId,$DatVehiculoModelo->VmoId,NULL,$DatSucursal->SucId,NULL,NULL);
									
				//	}
				//}
					  
?>



		<?php
        if($CotizacionVehiculoTotal>0 or $OrdenVentaVehiculoTotal>0){
        ?>
        
        <tr>
                    
                <td align="right">
                <?php echo $DatVehiculoModelo->VmoNombre;?>
                </td>
                <td align='right'><?php echo ($CotizacionVehiculoTotalAnterior);?></td>
                <td align='right'><?php echo ($OrdenVentaVehiculoTotalAnterior);?></td>
                
                <td align='right'>
                <?php echo ($CotizacionVehiculoTotal);?>
                
                </td>
                <td align='right'>
                
                
                <?php echo ($OrdenVentaVehiculoTotal);?>
                
                </td> 
                <td align='right'>
                
                <?php
                
                $Indice = 0;
                
                if($CotizacionVehiculoTotal>0){
                
                $Indice = $OrdenVentaVehiculoTotal/$CotizacionVehiculoTotal;
                
                }else{						
                
                $Indice = 0;
                
                }
                
                $Indice = $Indice * 100;
                
                ?>
                
                <?php echo round($Indice,2);?> %
                
                </td>
                                  
        </tr>
        
        <?php
        }
        ?>

		  
<?php


?>
<?php	

		$SumaTotalCotizaciones += $CotizacionVehiculoTotal;
		$SumaTotalVentas +=$OrdenVentaVehiculoTotal ;

		$SumaTotalCotizacionesAnterior += $CotizacionVehiculoTotalAnterior;
		$SumaTotalVentasAnterior +=$OrdenVentaVehiculoTotalAnterior ;


?>


            <?php
                }
            }
            ?>

	<tr>
<td align="right">
	<span class="EstTablaReporteEtiquetaTotal">
        Total:
        
        </span>
</td>
<td align='right'><span class="EstTablaReporteContenidoTotal"><?php echo round($SumaTotalCotizacionesAnterior,2);?></span></td>
<td align='right'><span class="EstTablaReporteContenidoTotal"><?php echo round($SumaTotalVentasAnterior,2);?></span></td>
			
<td align='right'> 

   <span class="EstTablaReporteContenidoTotal">
   <?php echo round($SumaTotalCotizaciones,2);?> </span>
        </td>
			
<td align='right'>

   <span class="EstTablaReporteContenidoTotal">
   <?php echo round($SumaTotalVentas,2);?> 
   </span>
   
   </td>
	<td align='right'>&nbsp;</td>
  
</tr>


<?php										
				
		}
	}
?>
	



	  
<tr>
<td>
	 -  
</td>
<td align='center'>&nbsp;</td>
<td align='center'>&nbsp;</td>
			
<td align='center'>-</td>
			
<td align='center'>-</td>
	<td align='center'>-</td>
  
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
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                    </table>
                    
          
       
     

