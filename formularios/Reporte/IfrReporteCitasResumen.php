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
require_once($InsProyecto->MtdRutLibrerias().'phplot-6.2.0/phplot.php');

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"ENCUESTA_VENTA_".date('d-m-Y').".xls\";");
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

$POST_finicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m")."/".date("Y");
$POST_ffin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");

$POST_Sucursal = ($_GET['Sucursal']);

//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPregunta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPreguntaRespuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPreguntaSeccion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqActividad().'ClsCita.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsEncuesta = new ClsEncuesta();
$InsSucursal = new ClsSucursal();
$InsCita = new ClsCita();
 
$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$POST_Sucursal,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];



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
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE CITAS   DEL
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
  <td width="23%" align="left" valign="top">

    <img src="../../imagenes/logos/logo_reporte.png" width="243" height="59" />

  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESUMEN DE CITAS   DEL
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


     
          <table border="0" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="281" align="center">Sucursal:</th>
           
            		<th width="80" align="center" valign="middle">Citas</th>
            		<th width="97" align="center">Realizadas</th>
             
          <th width="97" align="center">% Efectividad</th>
          </tr>
        </thead>
        
        
        <tbody class="EstTablaReporteBody">
          
          
<?php

$SumaTotalCitas = 0;
$SumaTotalFichaIngresos = 0;

if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
		
		$InsCita = new ClsCita();
		//MtdObtenerCitasValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oHoraInicio=NULL,$oHoraFin=NULL,$oSucursal=NULL,$oDia=NULL) 
		$TotalCitas = $InsCita->MtdObtenerCitasValor("COUNT","cit.CitId",NULL,NULL,NULL,NULL,NULL,'cit.CitId','Desc','1',NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),(FncCambiaFechaAMysql($POST_ffin)),"CitFechaProgramada",false,NULL,NULL,NULL,NULL,$DatSucursal->SucId,NULL);
		
		
		//MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oIgnorarPrimerMantenimiento=false,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL) {

		$InsFichaIngreso = new ClsFichaIngreso();
		//MtdObtenerFichaIngresosValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL, $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oFinMantenimientoKilometraje=NULL,$oTipoReparacion=NULL,$oPersonalIdAsesor=NULL,$oIgnorarPrimerMantenimiento=false,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oCita=NULL)
		$TotalFichaIngresos = $InsFichaIngreso->MtdObtenerFichaIngresosValor("COUNT","fin.FinId",NULL,NULL, NULL,NULL,NULL,'fin.FinId','Desc','1',FncCambiaFechaAMysql($POST_finicio),(FncCambiaFechaAMysql($POST_ffin)),9,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1,0,NULL,NULL,0,$oVehiculoMarca=NULL,NULL,NULL,NULL,NULL,false,false,$DatSucursal->SucId,"1,2");
		
	
		
		$PorcentajeEfectividad = 0;
		
		if($TotalCitas>0){
			$PorcentajeEfectividad = (($TotalFichaIngresos*100)/$TotalCitas);
		}
		
		
		
$SumaTotalCitas += $TotalCitas;;
$SumaTotalFichaIngresos += $TotalFichaIngresos;;

?>

			
			 <tr>
            <td align="left">
            
            <?php  echo $DatSucursal->SucNombre;?>
            
             </td>
            
          
				
				 

           		 <td width="80" align="center">
                 
             <?php echo number_format($TotalCitas,2);?>
             
                 
                 </td>
           		 <td align="center"><?php echo number_format($TotalFichaIngresos,2);?></td>
            
         
            
            <td align="center">
            
           <?php echo number_format($PorcentajeEfectividad,2);?> %
                  
          
            
            </td>
          </tr>
          
<?php	
	}
}
	
	
	$SumaPorcentajeEfectividad = 0;
		
		if($SumaTotalCitas>0){
			$SumaPorcentajeEfectividad = (($SumaTotalFichaIngresos*100)/$SumaTotalCitas);
		}
		
?>
          <tr>
			   <td align="right">TOTALES</td>
			   <td align="center"><?php echo number_format($SumaTotalCitas,2);?></td>
			   <td align="center"><?php echo number_format($SumaTotalFichaIngresos,2);?></td>
			   <td align="center"><?php echo number_format($SumaPorcentajeEfectividad,2);?> % </td>
	      </tr>
          
              </tbody>
              
              
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
        

      
        
       
         
      
     <br><br>

<hr>

    
</body>
</html>