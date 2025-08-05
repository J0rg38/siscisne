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
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_COMPRA_ANUAL_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="js/JsReporteOrdenCompraResumen.js"></script>

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

$POST_ProveedorId = $_POST['CmpProveedorId'];
$POST_ProveedorNombre = $_POST['CmpProveedorNombre'];

$POST_Moneda = ($_POST['CmpMoneda']);
$POST_Ano = ($_POST['CmpAno']);

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');


require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


$InsOrdenCompra = new ClsOrdenCompra();
$InsProveedor = new ClsProveedor();
$InsMoneda = new ClsMoneda();


if(empty($POST_ProveedorId) and !empty($POST_ProveedorNombre)){

	$ResProveedor = $InsProveedor->MtdObtenerProveedores("PrvNombre,PrvApellidoPaterno,PrvApellidoMaterno","contiene",$POST_ProveedorNombre,"PrvId","ASC",1,"1",NULL,NULL);
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->PrvId;
		}
	}

}

if(empty($POST_ProveedorId) and !empty($POST_ProveedorNumeroDocumento)){
	
	$ResProveedor = $InsProveedor->MtdObtenerProveedores("PrvNumeroDocumento","contiene",$POST_ProveedorNumeroDocumento,"PrvId","ASC",1,"1",NULL,NULL);
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
			$POST_ProveedorId = $DatProveedor->PrvId;
		}
	}

}


if(empty($POST_Moneda)){
	
	$InsMoneda = new ClsMoneda();
	$InsMoneda->MonId = $EmpresaMonedaId;
	$InsMoneda->MtdObtenerMoneda();

}else{

	$InsMoneda = new ClsMoneda();
	$InsMoneda->MonId = $POST_Moneda;
	$InsMoneda->MtdObtenerMoneda();

}

$InsProveedor = new ClsProveedor();
$InsProveedor->PrvId = $POST_ProveedorId ;
$InsProveedor->MtdObtenerProveedor();

//deb($POST_ProveedorId );
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="243" height="59" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE ORDENES DE COMPRA/PROVEEDOR ANUAL



 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        
      
        
        
        <table width="100%">
<tr>
  <td align="center" valign="middle">  RESUMEN ORDENES DE COMPRA/PROVEEDOR ANUAL - A&Ntilde;O <?php echo $POST_Ano;?><br>
  
  <?php echo $InsProveedor->PrvNombre;?>
    <?php echo $InsProveedor->PrvApellidoPaterno;?>
    <?php echo $InsProveedor->PrvApellidoMaterno;?></td>
  <td colspan="2" align="center" valign="middle">GRAFICO</td>
</tr>
<tr>
  <td align="center" valign="top">MONEDA: <?php echo $InsMoneda->MonNombre;?></td>
  <td colspan="2" align="center" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="center" valign="top"><table width="365" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
    <thead class="EstTablaReporteHead">
      <tr>
        <th width="58%">Mes</th>
        <th width="36%" align="center">Total </th>
        </tr>
      </thead>
    <tbody class="EstTablaReporteBody">
      <?php
	  $TotalAnual = 0;
			for($i=1;$i<=12;$i++){
			?>
      <tr >
        <td  align="left" valign="top"   ><?php echo FncConvertirMes($i);?></td>
        <td align="right" valign="top"  >

<?php																															//MtdObtenerOrdenComprasValor($oFuncion="SUM",$oParametro="OcoId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oTipo=NULL,$oConSaldo=0,$oProveedor=NULL,$oMoneda=NULL) {
$OrdenCompraTotal[$i] = $InsOrdenCompra->MtdObtenerOrdenComprasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$POST_Moneda."' AND '".$POST_Moneda."' <> '' , (oco.OcoTotal/IFNULL(oco.OcoTipoCambio,oco.OcoTotal)) , oco.OcoTotal  )",$i,$POST_Ano,NULL,NULL,NULL,'OcoId','Desc',NULL,NULL,NULL,NULL,NULL,0,$POST_ProveedorId,$POST_Moneda);
?>

<?php echo number_format($OrdenCompraTotal[$i],2);?>

</td>
        </tr>
      <?php
		 $TotalAnual+=$OrdenCompraTotal[$i];
			}
			?>
      <tr>
        <td align="right">TOTAL ANUAL:</td>
        <td align="right">
        
        <?php
		echo $InsMoneda->MonSimbolo;
		?>
        <?php
        echo number_format($TotalAnual,2);
		?></td>
        </tr>
      </tbody>
    <tfoot class="EstTablaReporteFoot">
      </tfoot>
    </table></td>
  <td colspan="2" align="center" valign="top">
  
	<?php
	$chart = new VerticalBarChart(670, 370);
	$dataSet = new XYDataSet();
	$Identificador = rand();
	
	for($i=1;$i<=12;$i++){
		$dataSet->addPoint(new Point(FncConvertirMes($i), round($OrdenCompraTotal[$i],2),2));
	}
	
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphPadding(new Padding(10, 35, 90, 35));

	$chart->setTitle("RESUMEN ORDENES DE COMPRA/PROVEEDOR - AÑO ".$POST_Ano." EN ".$InsMoneda->MonNombre." ");
	$chart->render("Graficos/ResumenOrdenCompraAnual_".$POST_Ano."_".$InsMoneda->MonId."_".$Identificador.".png");
    
	?>
    
    <img alt="RESUMEN ANUAL"  src="Graficos/ResumenOrdenCompraAnual_<?php echo $POST_Ano;?>_<?php echo $InsMoneda->MonId?>_<?php echo $Identificador?>.png" style="border: 1px solid gray;"/></td>
</tr>
</table>





</body>
</html>