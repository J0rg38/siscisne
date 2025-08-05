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
	header("Content-Disposition:  filename=\"REPORTE_CITA_ORDEN_TRABAJO_".date('d-m-Y').".xls\";");
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

$POST_FechaInicio = isset($_GET['CmpFechaInicio'])?$_GET['CmpFechaInicio']:"01/".date("m")."/".date("Y");
$POST_FechaFin = isset($_GET['CmpFechaFin'])?$_GET['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['CmpOrden'])?$_GET['CmpOrden']:"CitFechaProgramada";
$POST_sen = isset($_GET['CmpSentido'])?$_GET['CmpSentido']:"DESC";

$POST_Modalidad = $_GET['CmpModalidad'];
$POST_Sucursal = $_GET['CmpSucursal'];
$POST_VehiculoMarca = $_GET['CmpVehiculoMarca'];


if($_SESSION['MysqlDeb']){
	deb($_GET);
	
}
	
require_once($InsPoo->MtdPaqReporte().'ClsReporteCita.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');


$InsReporteCita = new ClsReporteCita();
$InsFichaIngreso = new ClsFichaIngreso();


//MtdObtenerReporteCitaFichaIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oPersonalMecanico=NULL,$oHora=NULL,$oSucursal=NULL)
$ResReporteCita = $InsReporteCita->MtdObtenerReporteCitaFichaIngresos(NULL,NULL,NULL,$POST_ord,$POST_sen,"",NULL,NULL,$POST_Personal,FncCambiaFechaAMysql($POST_FechaInicio),(FncCambiaFechaAMysql($POST_FechaFin)),"CitFechaProgramada",false,NULL,NULL,NULL,$POST_Sucursal);
$ArrReporteCitas = $ResReporteCita['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE LISTADO DE ORDENES DE TRABAJO X MODALIDAD 
  
  DEL
      <?php
  if($POST_FechaInicio == $POST_FechaFin){
?>
      <?php echo $POST_FechaInicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_FechaInicio; ?> AL <?php echo $POST_FechaFin; ?>
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
          <th width="8%">ID</th>
          <th width="8%">SUCURSAL</th>
          <th width="8%">FECHA REGISTRO</th>
          <th width="8%">APERTURA OT</th>
          <th width="8%">REGISTRADO POR</th>
          <th width="8%">FECHA PROGRAMADA</th>
          <th width="8%">HORA PROGRAMADA</th>
          <th width="5%">CLIENTE</th>
          <th width="10%">PLACA</th>
          <th width="8%">MARCA</th>
          <th width="8%">MODELO</th>
          <th width="10%">VERSION</th>
          <th width="10%">KM. MANT.</th>
          <th width="10%">OT.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
	
		$TotalCitasProgramadas = 0;
		$TotalCitasEfectuadas = 0;
		$TotalCitasNoRealizadas = 0;	 
		$c=1;
        foreach($ArrReporteCitas as $DatReporteCita){
        ?>
        
        
        <?php

//MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oVehiculoMarca=NULL,$oCodigoOriginal=NULL,$oSucursal=NULL,$oMigrado=true)
$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("ein.EinPlaca","esigual",$DatReporteCita->CitVehiculoPlaca,'FinId','Desc','',FncCambiaFechaAMysql($DatReporteCita->CitFechaProgramada),FncCambiaFechaAMysql($DatReporteCita->CitFechaProgramada),NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,true);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];

?>

<?php
$FichaIngresoId = "";
$FichaIngresoTiempoCreacion = "";

$TieneFichaIngreso = false;

if(!empty($ArrFichaIngresos)){
	foreach($ArrFichaIngresos as $DatFichaIngreso){
		
		if($DatFichaIngreso->FinEstado <> 777){
	
			$FichaIngresoId = $DatFichaIngreso->FinId;		
			$FichaIngresoTiempoCreacion = $DatFichaIngreso->FinTiempoCreacion;		
			
		}

		
	}
}


?>



        <tr   >
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $c;?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $DatReporteCita->CitId;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $DatReporteCita->SucNombre;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $DatReporteCita->CitTiempoCreacion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
          
          <?php echo $FichaIngresoTiempoCreacion;  ?>
         
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $DatReporteCita->PerNombreRegistro; ?> <?php echo $DatReporteCita->PerApellidoPaternoRegistro; ?> <?php echo $DatReporteCita->PerApellidoMaternoRegistro; ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   ><?php echo $DatReporteCita->CitFechaProgramada;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" valign="middle"   >
		  
          <?php echo $DatReporteCita->CitHoraProgramada;  ?>
         
             </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo ($DatReporteCita->CliNombre);?> <?php echo ($DatReporteCita->CliApellidoPaterno);?> <?php echo ($DatReporteCita->CliApellidoMaterno);?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteCita->CitVehiculoPlaca;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteCita->CitVehiculoMarca;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteCita->CitVehiculoModelo;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" ><?php echo $DatReporteCita->CitVehiculoVersion;  ?></td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
           <?php
		  if(!empty($DatReporteCita->CitKilometrajeMantenimiento)){
			  $DatReporteCita->CitKilometrajeMantenimiento = $DatReporteCita->CitKilometrajeMantenimiento*1;
			?>
          <?php echo ($DatReporteCita->CitKilometrajeMantenimiento);  ?> km
            <?php  
		  }
		  ?>
          
          
          </td>
          <td class="<?php echo ($c%2==0)?"EstTablaReporteActivo":"EstTablaReporteInactivo";?>" align="right" >
          
          


<?php
if(!empty($FichaIngresoId)){
?>
	<?php echo $FichaIngresoId;?> 
<?php	

	$TotalCitasEfectuadas++;
			
}else{
	
?>
Sin O.T.
<?php	
}
?>

          </td>
          </tr>
        <?php	
	
		$c++;
		
		
		$TotalCitasProgramadas++;
		
		
		
		
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
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>

<?php

$TotalCitasNoRealizadas = $TotalCitasProgramadas - $TotalCitasEfectuadas;

$PorcentajeEfectividad = (($TotalCitasEfectuadas * 100)/$TotalCitasProgramadas);

/*
100%	-	TotalCitasProgramadas
%		-	TotalCitasEfectuadas

*/
?>

<table width="100%">
<tr>
  <td align="right">Total Citas Programadas:</td>
  <td align="right"><?php echo number_format($TotalCitasProgramadas,2);  ?></td>
</tr>
<tr>
  <td align="right">Total Citas Efectuadas:</td>
  <td align="right"><?php echo number_format($TotalCitasEfectuadas,2);  ?></td>
</tr>
<tr>
  <td width="94%" align="right">Porcentaje de  Efectividad:</td>
  <td width="6%" align="right"><?php echo number_format($PorcentajeEfectividad,2);  ?> %</td>
</tr>
</table>


<p class="EstTablaReporteNota">
Del
<?php
  if($POST_FechaInicio == $POST_FechaFin){
?>
      <?php echo $POST_FechaInicio; ?>
      <?php
  }else{
?>
      <?php echo $POST_FechaInicio; ?> al <?php echo $POST_FechaFin; ?>
      <?php  
  }
?>
</p>


</body>
</html>