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


require_once($InsProyecto->MtdRutLibrerias().'libchart/classes/libchart.php');

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_PRODUCTO_VENTA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01".date("/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"PerNombre";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";
$POST_Marca = isset($_POST['CmpVehiculoMarca'])?$_POST['CmpVehiculoMarca']:"";

//deb($POST_Marca);

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');

$InsPersonal = new ClsPersonal();

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
 <img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE RECORD DE VENTAS DE VEHICULOS
      <?php
  if($POST_finicio == $POST_ffin){
?>
      <?php echo $POST_finicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_finicio; ?> AL <?php echo $POST_ffin; ?>
      <?php  
  }
?>



 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>



<table width="100%">
<tr>
  <td colspan="2">
  
  
<table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%" rowspan="2">#</th>
          <th width="8%" rowspan="2">COD. PERSONAL</th>
          <th width="18%" rowspan="2">ASESOR COMERCIAL</th>
          <th colspan="4">CIERRE DE VENTAS</th>
          <th colspan="3">CUMPLIMIENTO DE METAS</th>
          </tr>
        <tr>
          <th width="11%">UNIDADES COTIZADAS</th>
          <th width="9%">VENTAS CERRADAS</th>
          <th width="9%">VENTAS NO CERRADAS</th>
          <th width="9%">INDICADOR PRODUCT.</th>
          <th width="8%">META ESTABLEC.</th>
          <th width="13%">CUMPLIMIENTO  META  UNID.</th>
          <th width="13%">CUMPLIMIENTO DE META EN %</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
		<?php
        $c=1;

        foreach($ArrPersonales as $DatPersonal){
			
			$VentasNoCerradas =  0;
			$IndicadorProductividad[$DatPersonal->PerId] = 0;
			
			$CumplimientoMeta[$DatPersonal->PerId] = 0;
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		<?php echo $DatPersonal->PerId;?>
             </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatPersonal->PerNombre;?> <?php echo $DatPersonal->PerApellidoPaterno;?> <?php echo $DatPersonal->PerApellidoMaterno;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
            
  
<?php
$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL,$oMarca=NULL) {
$CotizacionVehiculoPersonalTotal = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",NULL,NULL,NULL,NULL,NULL,'CveId','Desc',NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),3,NULL,$DatPersonal->PerId,NULL,NULL,$POST_Marca);
?>
            
<?php
echo number_format($CotizacionVehiculoPersonalTotal);
?>      
            
            
            
            &nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          

<?php
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL) {
$OrdenVentaVehiculoPersonalTotal = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculosValor("COUNT","OvvId",NULL,NULL,NULL,NULL,NULL,'OvvId','Desc',NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,$DatPersonal->PerId,NULL,$POST_Marca)    
?>
      
<?php
echo number_format($OrdenVentaVehiculoPersonalTotal);
?>      
              
</td>
<td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >

<?php
$VentasNoCerradas = $CotizacionVehiculoPersonalTotal - $OrdenVentaVehiculoPersonalTotal;
?>

<?php
echo number_format($VentasNoCerradas);
?>
          
</td>
<td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >

<?php
if(!empty($OrdenVentaVehiculoPersonalTotal)){
	$IndicadorProductividad[$DatPersonal->PerId] = (($OrdenVentaVehiculoPersonalTotal * 100)/(empty($CotizacionVehiculoPersonalTotal)?$OrdenVentaVehiculoPersonalTotal:$CotizacionVehiculoPersonalTotal));
}

?>

<?php
echo number_format($IndicadorProductividad[$DatPersonal->PerId],2);

?>
</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >15</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          
 <?php
echo number_format($OrdenVentaVehiculoPersonalTotal);
?>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
<?php
$CumplimientoMeta[$DatPersonal->PerId] = (($OrdenVentaVehiculoPersonalTotal*100)/15)
?>
  <?php
echo number_format($CumplimientoMeta[$DatPersonal->PerId],2);
?>          %
          </td>
          </tr>
        <?php	
		$c++;
        }
        ?>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
  
  </td>
  </tr>
<tr>
  <td width="50%" align="center">
<?php
$chart = new VerticalBarChart(400, 370);
	$dataSet = new XYDataSet();
	
	foreach($ArrPersonales as $DatPersonal){
		
		$dataSet->addPoint(new Point($DatPersonal->PerNombre, round($IndicadorProductividad[$DatPersonal->PerId]),2));
		
	}
	
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphPadding(new Padding(10, 35, 90, 35));

	$chart->setTitle("EFICIENCIA DE VENTAS/COTIZACIONES");
	$chart->render("Graficos/EficienciaVentas.png");
    
?>

<img alt="EFICIENCIA DE VENTAS/COTIZACIONES"  src="Graficos/EficienciaVentas.png" style="border: 1px solid gray;"/>
    
  </td>
<td width="50%" align="center">



<?php
$chart = new VerticalBarChart(400, 370);
	$dataSet = new XYDataSet();
	
	foreach($ArrPersonales as $DatPersonal){
		
		$dataSet->addPoint(new Point($DatPersonal->PerNombre, round($CumplimientoMeta[$DatPersonal->PerId]),2));
		
	}
	
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphPadding(new Padding(10, 35, 90, 35));

	$chart->setTitle("CUMPLIMIENTO DE METAS");
	$chart->render("Graficos/CumplimientoMetas.png");
    
?>

<img alt="CUMPLIMIENTO DE METAS"  src="Graficos/CumplimientoMetas.png" style="border: 1px solid gray;"/>
  
  
  
  
  
  
</td>
</tr>
</table>
        





</body>
</html>