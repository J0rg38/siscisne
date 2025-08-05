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
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_TRABAJO_SIN_FACTURAR_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_GET['CmpFechaInicio'])?$_GET['CmpFechaInicio']:"01/".date("m")."/".date("Y");
$POST_ffin = isset($_GET['CmpFechaFin'])?$_GET['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['CmpOrden'])?$_GET['CmpOrden']:"FinFecha";
$POST_sen = isset($_GET['CmpSentido'])?$_GET['CmpSentido']:"DESC";

$POST_Sucursal = ($_GET['CmpSucursal']);


require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteVenta.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


$InsFichaAccion = new ClsFichaAccion();
$InsComprobanteVenta = new ClsComprobanteVenta();
$InsSucursal = new ClsSucursal();
$InsMoneda = new ClsMoneda();

$ResComprobanteVenta = $InsComprobanteVenta->MtdObtenerFichaIngresoxFacturar(NULL,NULL,NULL,$POST_ord,$POST_sen,$POST_pag,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,"75,8,9",false,false,"MIN-10016,MIN-10016,MIN-10001,MIN-10002,MIN-10003,MIN-10004,MIN-10005,MIN-10007,MIN-10009,MIN-10015,MIN-10013,MIN-10006,MIN-10017,MIN-10018,MIN-10028,MIN-10024,MIN-10019,MIN-10020,MIN-10021,MIN-10023,MIN-10026,MIN-10029",true,$POST_Facturable,true,"fcc.FccFecha",$POST_Sucursal,$POST_Moneda);//73,74,75,8,9
$ArrComprobanteVentas = $ResComprobanteVenta['Datos'];

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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE ORDENES DE TRABAJO SIN FACTURAR DEL
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE ORDENES DE TRABAJO SIN FACTURAR DEL
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
          <th width="2%">#</th>
          <th width="9%">SUCURSAL</th>
          <th width="6%">O.T.</th>
          <th width="5%">FICHA SALIDA</th>
          <th width="5%">FECHA</th>
          <th width="11%">CLIENTE</th>
          <th width="7%">VIN</th>
          <th width="7%">PLACA</th>
          <th width="7%">MARCA</th>
          <th width="7%">MODELO</th>
          <th width="14%">ASESOR DE SERVICIO</th>
          <th width="8%">OBS</th>
          <th width="12%">TOTAL</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$c=1;
		$FacturaTotal = 0;
		$FacturaAmortizadoTotal = 0;
		$FacturaSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalFacturaNoCancelada = 0;
		
        foreach($ArrComprobanteVentas as $DatComprobanteVenta){
			
			
		 
			
        ?>
        
        
        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatComprobanteVenta->SucNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          <?php echo ($DatComprobanteVenta->FinId);?>



</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatComprobanteVenta->AmoId);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatComprobanteVenta->FinTiempoCreacion);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatComprobanteVenta->CliNombre);?> <?php echo ($DatComprobanteVenta->CliApellidoPaterno);?> <?php echo ($DatComprobanteVenta->CliApellidoMaterno);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatComprobanteVenta->EinVIN);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatComprobanteVenta->EinPlaca);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatComprobanteVenta->VmaNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatComprobanteVenta->VmoNombre);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
		  
		  <?php echo ($DatComprobanteVenta->PerNombreAsesor);?>
          <?php echo ($DatComprobanteVenta->PerApellidoPaternoAsesor);?>
          <?php echo ($DatComprobanteVenta->PerApellidoMaternoAsesor);?>
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >&nbsp;</td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php $DatComprobanteVenta->AmoTotal = (($DatComprobanteVenta->AmoTotal/(empty($DatComprobanteVenta->AmoTipoCambio)?1:$DatComprobanteVenta->AmoTipoCambio)));?>
          <?php echo number_format($DatComprobanteVenta->AmoTotal,2);?></td>
          </tr>
        <?php	
		
			$FacturaTotal += $DatComprobanteVenta->FacTotal;
			$FacturaAmortizadoTotal += $ClientePagoMontoTotal;
			$FacturaSaldoTotal += $FacturaSaldo;
			
		$c++;
        }
        ?>
        
        
        
         
       
          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>