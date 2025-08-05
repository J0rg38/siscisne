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
	header("Content-Disposition:  filename=\"REPORTE_GARANTIA_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"GarFechaEmision";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

require_once($InsPoo->MtdPaqActividad().'ClsGarantia.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaOperacion.php');
require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteGarantia.php');

$InsReporteGarantia = new ClsReporteGarantia();

$ResReporteGarantia = $InsReporteGarantia->MtdObtenerReporteGarantias(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
$ArrReporteGarantias = $ResReporteGarantia['Datos'];



?>

<?php
if($_GET['P']==2){
?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">&nbsp;</td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE GARANTIAS DEL
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
  <td width="23%" align="right" valign="top">&nbsp;</td>
</tr>
</table>
<?php	
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE GARANTIAS DEL
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
          <th width="5%">N. OT</th>
          <th width="12%">FECHA OT</th>
          <th width="9%">FECHA CIERRE</th>
          <th width="37%">MODELO</th>
          <th width="37%">VIN</th>
          <th width="37%">CONCESIONARIO</th>
          <th width="37%">KMTJE</th>
          <th width="37%">FALLA DESCRITA</th>
          <th width="37%">MANO DE OBRA EN HORAS</th>
          <th width="37%">MANO DE OBRA EN DOLARES</th>
          <th width="37%">CODIGO DE MANO DE OBRA </th>
          <th width="37%">CODIGO  REPUESTOS</th>
          <th width="37%">DESCRIPCION REPUESTOS</th>
          <th width="37%">COSTO REPUESTOS</th>
          <th width="37%">DESCRIPCION OTROS</th>
          <th width="6%">COSTO OTROS</th>
          <th width="6%">SUB-TOTAL</th>
          <th width="6%">IGV</th>
          <th width="6%">TOTAL</th>
          <th width="6%">N. TRANSACCION</th>
          <th width="6%">FECHA DE TRANSACCION</th>
          <th width="6%">OBSERVACION GM</th>
        </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
        foreach($ArrReporteGarantias as $DatReporteGarantia){
        ?>
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
          <a target="_blank" href="../../principal.php?Mod=Garantia&Form=Ver&Id=<?php echo $DatReporteGarantia->GarId;?>">
		  <?php echo $DatReporteGarantia->GarId;  ?>
          </a>
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->GarFechaEmision;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->FinTiempoTrabajoTerminado;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->VmoNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->EinVIN;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->OncNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->FinVehiculoKilometraje;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->GarCausa;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >

<?php
$InsGarantiaOperacion = new ClsGarantiaOperacion();
$ResGarantiaOperacion =  $InsGarantiaOperacion->MtdObtenerGarantiaOperaciones(NULL,NULL,"GopCosto","DESC","1",$DatReporteGarantia->GarId,NULL);
$ArrGarantiaOperaciones = $ResGarantiaOperacion['Datos'];
?>
<?php
//deb($ArrGarantiaOperaciones);
?>
<?php
$GarantiaOperacionTiempo = 0;
$GarantiaOperacionCosto = 0;
$GarantiaOperacionCodigo = "";
foreach($ArrGarantiaOperaciones as $DatGarantiaOperacion){
?>

<?php
	
	$GarantiaOperacionCodigo = $DatGarantiaOperacion->GopNumero;
	
	$GarantiaOperacionTiempo = $DatGarantiaOperacion->GopTiempo;

	if($DatReporteGarantia->MonId<>$EmpresaMonedaId  ){
		$GarantiaOperacionCosto = round($DatGarantiaOperacion->GopCosto / $DatReporteGarantia->GarTipoCambio,2);
	}else{
		$GarantiaOperacionCosto = $DatGarantiaOperacion->GopCosto;		
	}

?>
	
<?php
}
?>
  
  <?php
	echo number_format($GarantiaOperacionTiempo,2);
  ?>          hrs
            
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
<?php
echo number_format($GarantiaOperacionCosto,2);
?>

</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
<?php
echo $GarantiaOperacionCodigo;
?>

          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          
          
          
          
<?php
$InsGarantiaDetalle = new ClsGarantiaDetalle();
$ResGarantiaDetalle =  $InsGarantiaDetalle->MtdObtenerGarantiaDetalles(NULL,NULL,"GdeId","ASC",NULL,$DatReporteGarantia->GarId,NULL,NULL);
$ArrGarantiaDetalles = 	$ResGarantiaDetalle['Datos'];	
?>
<?php
//deb($ArrGarantiaDetalles);
?>
<?php
if(!empty($ArrGarantiaDetalles)){
	foreach($ArrGarantiaDetalles as $DatGarantiaDetalle){
?>
<?php echo $DatGarantiaDetalle->GdeCodigo?> / 
<?php	
	}
}
?>      
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php
$InsGarantiaDetalle = new ClsGarantiaDetalle();
$ResGarantiaDetalle =  $InsGarantiaDetalle->MtdObtenerGarantiaDetalles(NULL,NULL,"GdeId","ASC",NULL,$DatReporteGarantia->GarId,NULL,NULL);


$ArrGarantiaDetalles = 	$ResGarantiaDetalle['Datos'];	
?>

<?php
if(!empty($ArrGarantiaDetalles)){
	foreach($ArrGarantiaDetalles as $DatGarantiaDetalle){
?>
		<?php echo $DatGarantiaDetalle->GdeDescripcion;?> / 
<?php	
	}
}
?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          
                    <?php
$InsGarantiaDetalle = new ClsGarantiaDetalle();
$ResGarantiaDetalle =  $InsGarantiaDetalle->MtdObtenerGarantiaDetalles(NULL,NULL,"GdeId","ASC",NULL,$DatReporteGarantia->GarId,NULL,NULL);
$ArrGarantiaDetalles = 	$ResGarantiaDetalle['Datos'];	
?>

<?php
$GarantiaDetalleCosto = 0;
$GarantiaDetalleCostoTotal = 0;
if(!empty($ArrGarantiaDetalles)){
	foreach($ArrGarantiaDetalles as $DatGarantiaDetalle){
?>

<?php
	if($DatReporteGarantia->MonId<>$EmpresaMonedaId  ){
		$GarantiaDetalleCosto = round($DatGarantiaDetalle->GdeCostoMargen / $DatReporteGarantia->GarTipoCambio,2);
	}else{
		$GarantiaDetalleCosto = $DatGarantiaOperacion->GdeCostoMargen;		
	}
?>

<?php	
	$GarantiaDetalleCostoTotal += $GarantiaDetalleCosto;
	}
}
?>      
<?php echo number_format($GarantiaDetalleCostoTotal,2);?>
</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		
          -</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >-</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >


<?php
	if($DatReporteGarantia->MonId<>$EmpresaMonedaId  ){
		$GarantiaSubTotal = round($DatReporteGarantia->GarSubTotal / $DatReporteGarantia->GarTipoCambio,2);
		$GarantiaImpuesto = round($DatReporteGarantia->GarImpuesto / $DatReporteGarantia->GarTipoCambio,2);
		$GarantiaTotal = round($DatReporteGarantia->GarTotal / $DatReporteGarantia->GarTipoCambio,2);
	}else{
		$GarantiaSubTotal = $DatReporteGarantia->GarSubTotal;
		$GarantiaImpuesto = $DatReporteGarantia->GarImpuesto;
		$GarantiaTotal = $DatReporteGarantia->GarTotal;
				
	}
	
?>
		  <?php echo number_format($GarantiaSubTotal,2);  ?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php echo number_format($GarantiaImpuesto,2);  ?></td>
          
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		   <?php echo number_format($GarantiaTotal,2);  ?>          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->GarTransaccionNumero;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->GarTransaccionFecha;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteGarantia->GarObservacionFinal;  ?></td>
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
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>