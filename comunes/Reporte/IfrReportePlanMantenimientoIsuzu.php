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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_STOCK_".date('d-m-Y').".xls\";");
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
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');

$InsVehiculoModelo = new ClsVehiculoModelo();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
//MtdObtenerVehiculoModelos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVigenciaVenta=NULL,$oEstado=NULL)
$ResVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,'VmoId','Desc',NULL,"VMA-10018",1,NULL);
$ArrVehiculoModelos = $ResVehiculoModelo['Datos'];



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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE PLANES DE MANTENIMIENTO ISUZU
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
foreach($ArrVehiculoModelos as $DatVehiculoModelo){
?>

<?php
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$DatVehiculoModelo->VmoId) ;
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
?>    


        
        
  <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="1%">&nbsp;</th>
          <th width="98%"><?php echo $DatVehiculoModelo->VmoNombre;?></th>
          <th width="1%">&nbsp;</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">      
        
<tr>
  <td align="right">&nbsp;</td>
  <td align="center">
    
    
    
    
  <table class="EstTablaReporte">
  <thead class="EstTablaReporteHead">
  <tr>
  <th width="200">Tareas
    
  </th>
    
    <?php
    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
    ?>
    
    <th width="150" align="center" >
      
      <?php echo $DatKilometroEtiqueta;?> km 
      
      </th>
    
    <?php	
    }
    ?>
    
  </tr>
  </thead>
     <tbody class="EstTablaReporteBody">
    
    
  <?php
$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,NULL);
$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];

?>
    
  <?php
foreach($ArrPlanMantenimientoTareas  as $DatPlanMantenimientoTarea){
	
	$MostrarTarea = false;
?>
    
    
    <?php
    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
    ?>
    
    
  <?php
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],NULL,$DatPlanMantenimientoTarea->PmtId);	
?>  
    
  <?php
if($PlanMantenimientoDetalleAccion == "C"){
$MostrarTarea = true;	
break;
}
?>
    
    <?php	
    }
    ?>
    
    
    
  <?php
if($MostrarTarea){
?>
  <tr>
  <td width="200">
  <?php echo $DatPlanMantenimientoTarea->PmtNombre;?>
  </td>
    
    <?php
    foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
    ?>
    <td width="150" align="center" >
      
      
  <?php

//MtdObtenerTareaProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oTarea=NULL


	$InsTareaProducto = new ClsTareaProducto();
	$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoTarea->PmtId);
	$ArrTareaProductos = $ResTareaProducto['Datos'];
	
	$ProductoCodigoOriginal = "";
	
	foreach($ArrTareaProductos as $DatTareaProducto){
		
		$ProductoCodigoOriginal = $DatTareaProducto->ProCodigoOriginal;

	}
?>        
      
  <?php
	echo $ProductoCodigoOriginal;
?>&nbsp;
      
      
      
      
      </td>
    <?php	
    }
    ?>
    
  </tr>
  <?php
}
?>
    
  <?php	
}
?>
    
    
    
  </tbody>
  </table>
    
    
    
    
    
    
    
    
  </td>
  <td align="right">&nbsp;</td>
</tr>


<tr>
<td align="right">&nbsp;</td>
<td align="center">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>


	</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>

<?php
}
?>    






</body>
</html>