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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_RESUMEN_ORDEN_TRABAJO_MODALIDAD_MODELO_".date('d-m-Y').".xls\";");
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

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"RfcTotal";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_VehiculoMarca = $_POST['CmpVehiculoMarca'];
$POST_VehiculoModelo = $_POST['CmpVehiculoModelo'];
$POST_ModalidadIngreso = $_POST['CmpModalidadIngreso'];

$POST_Sucursal = $_POST['CmpSucursal'] ?? '';
$POST_FichaIngresoTipo = $_POST['CmpFichaIngresoTipo'];

if(!empty($POST_VehiculoMarca)){
	//$Agrupar = "vmo.VmaId";	
}else{
	
}
$Agrupar = "vve.VmoId";
require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngresoConsolidado.php');

$InsReporteFichaIngresoConsolidado = new ClsReporteFichaIngresoConsolidado();


//MtdObtenerReporteFichaIngresoConsolidados($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden="Total",$oSentido="ASC",$oFechaInicio=NULL,$oFechaFin=NULL,$oAgrupar=NULL,$oModalidadIngreso=NULL,$oMarca=NULL,$oModelo=NULL,$oFichaIngresoTipo=NULL,$oSucursal=NULL) { 

$ResReporteFichaIngresoConsolidado = $InsReporteFichaIngresoConsolidado->MtdObtenerReporteFichaIngresoConsolidados(NULL,NULL,NULL,$POST_ord,$POST_sen,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$Agrupar,$POST_ModalidadIngreso,$POST_VehiculoMarca,$POST_VehiculoModelo,$POST_FichaIngresoTipo,$POST_Sucursal);
$ArrReporteFichaIngresoConsolidados = $ResReporteFichaIngresoConsolidado['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE RESUMEN DE ORDEN DE TRABAJO X MODALIDAD X MODELO 
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
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="3%">#</th>
          <th width="18%">MARCA</th>
          <th width="48%">MODELO</th>
          <th width="17%">TOTAL</th>
          <th width="14%">PROMEDIO DIARIO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
		<?php
        $c=1;
		
		$TotalFichaIngresoConsolidado = 0;
		$SumaPromedios = 0;
		$SumaTotal = 0;
		
        foreach($ArrReporteFichaIngresoConsolidados as $DatReporteFichaIngresoConsolidado){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		<?php echo $DatReporteFichaIngresoConsolidado->VmaNombre;?>
             </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteFichaIngresoConsolidado->VmoNombre;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteFichaIngresoConsolidado->RfcTotal;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php
		 $Promedio = 0;
		 ?>
            <?php
		 if($DatReporteFichaIngresoConsolidado->RfcDiferenciaDia >0){
			 
			 $Promedio = $DatReporteFichaIngresoConsolidado->RfcTotal / $DatReporteFichaIngresoConsolidado->RfcDiferenciaDia;
			
		?>
            <?php echo number_format($Promedio,2);?>
            <?php
		 }else{
		?>
-
<?php		 
		 }
			 
		 ?></td>
          </tr>
        <?php	
		$SumaTotal += $DatReporteFichaIngresoConsolidado->RfcTotal;
		 $SumaPromedios += $Promedio;
		 
		$TotalFichaIngresoConsolidado += $DatReporteFichaIngresoConsolidado->RfcTotal;

		
		
		$c++;
        }
        ?>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">SUMAS:</td>
            <td align="right"><?php echo number_format($SumaTotal,2);?></td>
            <td align="right"><?php echo number_format($SumaPromedios,2);?></td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>


<p class="EstTablaReporteNota">
Del
<?php
  if($POST_finicio == $POST_ffin){
?>
      <?php echo $POST_finicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_finicio; ?> al <?php echo $POST_ffin; ?>
      <?php  
  }
?>
</p>



</body>
</html>