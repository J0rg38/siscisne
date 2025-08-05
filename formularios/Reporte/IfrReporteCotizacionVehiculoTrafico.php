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
	header("Content-Disposition:  filename=\"REPORTE_COTIZACION_VEHICULO_TRAFICO_".date('d-m-Y').".xls\";");
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

$POST_mes = isset($_POST['CmpMes'])?$_POST['CmpMes']:date("m");
$POST_ano = isset($_POST['CmpAno'])?$_POST['CmpAno']:date("Y");
$POST_Personal = ($_POST['CmpPersonal']);

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsPersonal = new ClsPersonal();

$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmaId,VmoOrden","ASC",NULL,$GET_Marca,1);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

$PersonalNombre = "";

if(!empty($POST_Personal)){
	$InsPersonal->PerId = $POST_Personal;
	$InsPersonal->MtdObtenerPersonal();
	
	$PersonalNombre = $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno;
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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE TRAFICO/COTIZACION VEHICULO
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

<?php

$CantidadDias = FncCantidadDiaMes($POST_ano,$POST_mes);

?>
        
<table width="100%">
<tr>
  <td>
  <?php echo $PersonalNombre;?>
  </td>
</tr>
<tr>
<td>

<table class="EstTablaReporte" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th>&nbsp;</th>
          <th colspan="<?php echo ($CantidadDias+1);?>">
          
          MES DE <?php echo strtoupper(FncConvertirMes($POST_mes));?> - <?php echo $POST_ano;?>
          
          
          </th>
         
        </tr>
        <tr>
        
     
          <th width="200">MARCA/MODELO</th>
         
         
         <?php
		 for($dia=1; $dia<=$CantidadDias; $dia++){
		 ?>
          <th width="50"><?php echo $dia;?></th>
          <?php
		 }
		  ?>
          
          <th>TOTAL</th>
          </tr>
         
          
        </thead>
        <tbody class="EstTablaReporteBody">
        
           <?php
		foreach($ArrVehiculoModelos as $DatVehiculoModelo){
		?>
	
        <tr   >

          <td width="200" align="right" valign="middle" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>"   >
          
          
		  <?php echo $DatVehiculoModelo->VmaNombre;?>/
		  <?php echo $DatVehiculoModelo->VmoNombre;?>
          </td>

<?php
$TotalModelo = 0;
for($dia=1; $dia<=$CantidadDias; $dia++){
?>
<td width="50" align="right" class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" >


<?php
//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL,$oVehiculoModelo=NULL) {
//MtdObtenerCotizacionVehiculosValor($oFuncion="SUM",$oParametro="CveId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oNivelInteres=NULL) {
$TotalDia[$dia] = $InsCotizacionVehiculo->MtdObtenerCotizacionVehiculosValor("COUNT","CveId",$POST_mes,$POST_ano,NULL,NULL,NULL,NULL,NULL,NULL,$POST_ano."-".$POST_mes."-".$dia,$POST_ano."-".$POST_mes."-".$dia,$oEstado=NULL,NULL,$POST_Personal,NULL,$DatVehiculoModelo->VmoId);
?>

<?php echo number_format($TotalDia[$dia],0);?>

<?php
$TotalModelo += $TotalDia[$dia];
?>

</td>
<?php
}
?>
<td align="right">

<?php echo number_format($TotalModelo,2);
?></td>
          
          </tr>
       <?php
		}
		  ?>
        </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        
        
</td>
</tr>
</table>
        





</body>
</html>