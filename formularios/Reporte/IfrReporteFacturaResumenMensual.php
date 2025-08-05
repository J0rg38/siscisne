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




require_once($InsProyecto->MtdRutLibrerias().'libchart/classes/libchart.php');



if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_VENTA_DIRECTA_MENSUAL_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<script type="text/javascript" src="js/JsReporteVentaDirectaResumen.js"></script>

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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ClienteId = $_POST['CmpClienteId'];
$POST_ClienteNombre = $_POST['CmpClienteNombre'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"VdiId";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Moneda = ($_POST['CmpMoneda']);

$POST_ConOrdenCompra = ($_POST['CmpConOrdenCompra']);
$POST_Clasificacion = $_POST['CmpClasificacion'];
$POST_Ano = $_POST['CmpAno'];

$POST_Origen = $_POST['CmpOrigen'];
$POST_Personal = $_POST['CmpPersonal'];

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsCliente = new ClsCliente();
$InsMoneda = new ClsMoneda();
$InsPago = new ClsPago();

if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_ClienteNombre,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}

if(empty($POST_ClienteId) and !empty($POST_ClienteNumeroDocumento)){
	
	$ResCliente = $InsCliente->MtdObtenerClientes("CliNumeroDocumento","contiene",$POST_ClienteNumeroDocumento,"CliId","ASC",1,"1",NULL,NULL);
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
			$POST_ClienteId = $DatCliente->CliId;
		}
	}

}



//$POST_Moneda = (empty($POST_Moneda)?$EmpresaMonedaId:$POST_Moneda);

//deb($POST_Moneda);

if(empty($POST_Moneda)){
	
	
$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $EmpresaMonedaId;
$InsMoneda->MtdObtenerMoneda();

}else{
	
	
$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();

}



?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE FACTURACION ANUAL DEL
  
      <?php echo $POST_Ano ?>




 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
    
    


<table width="100%">
<tr>
  <td align="center" valign="middle">RESUMEN MENSUAL DE VENTAS</td>
  <td colspan="2" align="center" valign="middle">GRAFICO</td>
</tr>
<tr>
  <td align="center" valign="top"><table width="365" border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
    <thead class="EstTablaReporteHead">
      <tr>
        <th colspan="2">Año <?php echo $POST_Ano;?></th>
        </tr>
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
	
<?php

//
//MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL)
 
$InsFactura = new ClsFactura();
//$FacturaTotal[$i] = $InsFactura->MtdObtenerFacturasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$POST_Moneda."' AND '".$POST_Moneda."' <> '' , (fac.FacTotal/IFNULL(fac.FacTipoCambio,fac.FacTotal)) , fac.FacTotal  )",$i,$POST_Ano,NULL,NULL,NULL,'FacId','Desc',1,NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Moneda,$POST_ClienteId,NULL,$POST_Clasificacion);


//$VentaDirectaTotal[$i] = $InsVentaDirecta->MtdObtenerVentaDirectasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$POST_Moneda."' AND '".$POST_Moneda."' <> '' , (vdi.VdiTotal/IFNULL(vdi.VdiTipoCambio,vdi.VdiTotal)) , vdi.VdiTotal  )",$i,$POST_Ano,NULL,NULL,NULL,'VdiId','Desc',NULL,NULL,NULL,NULL,0,NULL,NULL,$POST_Moneda,$POST_ClienteId,$POST_ConOrdenCompra,NULL,NULL,$POST_Clasificacion,"CLI-1000,CLI-13729",$POST_Personal);


//MtdObtenerVentaDirectasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$POST_Moneda."' AND '".$POST_Moneda."' <> '' , (vdi.VdiTotal/IFNULL(vdi.VdiTipoCambio,vdi.VdiTotal)) , vdi.VdiTotal  )",

//MtdObtenerFacturasValor($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL)
$FacturaTotal[$i] = $InsFactura->MtdObtenerFacturasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$POST_Moneda."' AND '".$POST_Moneda."' <> '' , (fac.FacTotal/IFNULL(fac.FacTipoCambio,fac.FacTotal)) , fac.FacTotal  )",$i,$POST_Ano,NULL,NULL,NULL,'FacId','Desc',1,NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Moneda,$POST_ClienteId,NULL,$POST_Clasificacion,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Origen,$POST_Personal);

$InsBoleta = new ClsBoleta();
//$BoletaTotal[$i] = $InsBoleta->MtdObtenerBoletasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$POST_Moneda."' AND '".$POST_Moneda."' <> '' , (bol.BolTotal/IFNULL(bol.BolTipoCambio,bol.BolTotal)) , bol.BolTotal  )",$i,$POST_Ano,NULL,NULL,NULL,'BolId','Desc',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,$POST_Moneda,NULL,$POST_ClienteId,$POST_Clasificacion);

//  public function MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL) {
$BoletaTotal[$i] = $InsBoleta->MtdObtenerBoletasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$POST_Moneda."' AND '".$POST_Moneda."' <> '' , (bol.BolTotal/IFNULL(bol.BolTipoCambio,bol.BolTotal)) , bol.BolTotal  )",$i,$POST_Ano,NULL,NULL,NULL,'BolId','Desc',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,$POST_Moneda,NULL,$POST_ClienteId,$POST_Clasificacion,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Origen,$POST_Personal);

$ComprobanteTotal[$i] = $FacturaTotal[$i] + $BoletaTotal[$i];

//
//
////MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL)
//
// 
//$FacturaTotal[$i] = $InsVentaDirecta->MtdObtenerVentaDirectasValor("SUM","IF( '".$EmpresaMonedaId."'<>'".$POST_Moneda."' AND '".$POST_Moneda."' <> '' , (vdi.VdiTotal/IFNULL(vdi.VdiTipoCambio,vdi.VdiTotal)) , vdi.VdiTotal  )",$i,$POST_Ano,NULL,NULL,NULL,'VdiId','Desc',NULL,NULL,NULL,NULL,0,NULL,NULL,$POST_Moneda,$POST_ClienteId,$POST_ConOrdenCompra,NULL,NULL,$POST_Clasificacion);
?>

          <?php
echo number_format($ComprobanteTotal[$i],2);
?></td>
        </tr>
      <?php
		 $TotalAnual+=$ComprobanteTotal[$i];
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
  <td colspan="2" align="center" valign="top"><?php
	$chart = new VerticalBarChart(670, 370);
	$dataSet = new XYDataSet();
	$Identificador = rand();
	
	for($i=1;$i<=12;$i++){
		$dataSet->addPoint(new Point(FncConvertirMes($i), round($ComprobanteTotal[$i]),2));
	}
	
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphPadding(new Padding(10, 35, 90, 35));

	$chart->setTitle("RESUMEN FACTURACION MENSUAL DE VENTAS - AÑO ".$POST_Ano." EN ".$InsMoneda->MonNombre." ");
	$chart->render("Graficos/ResumenFacturaMensualVentas_".$POST_Ano."_".$InsMoneda->MonId."_".$Identificador.".png");
    
?>
    <img alt="RESUMEN FACTURACION MENSUAL DE VENTAS"  src="Graficos/ResumenFacturaMensualVentas_<?php echo $POST_Ano;?>_<?php echo $InsMoneda->MonId?>_<?php echo $Identificador;?>.png" style="border: 1px solid gray;"/></td>
</tr>
</table>    
      
        





</body>
</html>