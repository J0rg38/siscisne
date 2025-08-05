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
	header("Content-Disposition:  filename=\"REPORTE_ORDEN_TRABAJO_MODELO_ANUAL_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/CssReporte.css">

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

//$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/01/".date("Y");
//$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_Ano = isset($_POST['CmpAno'])?$_POST['CmpAno']:date("Y");

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m")."/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FinFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_Tipo = ($_POST['CmpTipo']);

//deb($POST_Tipo);

//if(empty($POST_VehiculoModelo)){
//	die("Escoja un moelo");
//}

require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPregunta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaPreguntaRespuesta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuestaDetalle.php');

$InsEncuesta = new ClsEncuesta();
$InsEncuestaPregunta = new ClsEncuestaPregunta();

//$ResEncuesta = $InsEncuesta->MtdObtenerEncuestas($POST_cam,"contiene",$POST_fil,$POST_ord,$POST_sen,$POST_pag,NULL);
//$ArrEncuestas = $ResEncuesta['Datos'];

//MtdObtenerEncuestaPreguntaRespuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuestaPregunta=NULL,$oEncuestaSeccionTipo=NULL) {
$ResEncuestaPregunta  = $InsEncuestaPregunta->MtdObtenerEncuestaPreguntas(NULL,NULL,NULL,'EprId','ASC',NULL,NULL,NULL,"1",NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Tipo);
$ArrEncuestaPreguntas = $ResEncuestaPregunta['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">RESULTADOS DE ENCUESTAS DEL
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


 
			
			
	

		<table border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaReporte">
        <thead class="EstTablaReporteHead">
       
        </thead>
        <tbody class="EstTablaReporteBody">
        <tr>
        <td>
        

<?php
$pregunta = 1;
if(!empty($ArrEncuestaPreguntas )){
	foreach($ArrEncuestaPreguntas  as $DatEncuestaPregunta){
?>

    <?php
    $InsEncuestaPreguntaRespuesta = new ClsEncuestaPreguntaRespuesta();
//MtdObtenerEncuestaPreguntaRespuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuestaPregunta=NULL,$oEncuestaSeccionTipo=NULL) {
    $ResEncuestaPreguntaRespuesta = $InsEncuestaPreguntaRespuesta->MtdObtenerEncuestaPreguntaRespuestas(NULL,NULL,NULL,'EpeId','ASC','',NULL,$DatEncuestaPregunta->EprId,$DatEncuestaPregunta->EpsTipo);
    $ArrEncuestaPreguntaRespuestas = $ResEncuestaPreguntaRespuesta['Datos'];
    ?>

<span class="EstTablaReporteSubtitulo"><?php echo $DatEncuestaPregunta->EprNombre?></span>

<table border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaReporte">
<thead class="EstTablaReporteHead">
	
		 <tr>
        <th width="100">RESPUESTA</th>
        <th width="100" align="center">Cantidad</th>
        <th width="100" align="center">Porcentaje</th>
    </tr>
</thead>
<tbody class="EstTablaReporteBody">

<?php
if(!empty($ArrEncuestaPreguntaRespuestas)){		
	
	$SumaTotalRespuestas = 0;
	foreach($ArrEncuestaPreguntaRespuestas as $DatEncuestaPreguntaRespuesta){
		
		$InsEncuestaDetalle = new ClsEncuestaDetalle();
        $TotalRespuesta = $InsEncuestaDetalle->MtdObtenerEncuestaDetallesValor("COUNT","EdeId",NULL,NULL,NULL,NULL,NULL,'EdeId','Desc','1',3,NULL,$DatEncuestaPregunta->EprId,$DatEncuestaPreguntaRespuesta->EpeValor);
		
		$SumaTotalRespuestas += $TotalRespuesta;
	}

	foreach($ArrEncuestaPreguntaRespuestas as $DatEncuestaPreguntaRespuesta){
		?>
        <tr>
            <td width="100"><?php echo $DatEncuestaPreguntaRespuesta->EpeNombre;?></td>
            <td width="100" align="center" >
                
                <?php

                $InsEncuestaDetalle = new ClsEncuestaDetalle();
				//MtdObtenerEncuestaDetallesValor($oFuncion="SUM",$oParametro="EprId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuesta=NULL,$oEncuestaPregunta=NULL,$oEncuestaRespuesta=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {
                $TotalRespuesta = $InsEncuestaDetalle->MtdObtenerEncuestaDetallesValor("COUNT","EdeId",NULL,NULL,NULL,NULL,NULL,'EdeId','Desc','1',3,NULL,$DatEncuestaPregunta->EprId,$DatEncuestaPreguntaRespuesta->EpeValor,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
                ?>
                <?php
                echo number_format($TotalRespuesta,2);
                ?>                        
                
            </td>
             <td width="100">
             
             <?php 
			 $porcentaje[$DatEncuestaPreguntaRespuesta->EpeId] = (($TotalRespuesta*100)/(empty($SumaTotalRespuestas)?1:$SumaTotalRespuestas));
			 
			 ?>
             <?php
			 echo number_format($porcentaje[$DatEncuestaPreguntaRespuesta->EpeId],2);
			 ?>
             %</td>
        </tr>
		<?php
	}
}
?>
<tr>
<td colspan="3" align="center">



<?php
	$chart = new PieChart();

	$dataSet = new XYDataSet();
	
	if(!empty($ArrEncuestaPreguntaRespuestas)){	
		foreach($ArrEncuestaPreguntaRespuestas as $DatEncuestaPreguntaRespuesta){
			$dataSet->addPoint(new Point($DatEncuestaPreguntaRespuesta->EpeNombre, $porcentaje[$DatEncuestaPreguntaRespuesta->EpeId]));
		}
	}
	
	$chart->setDataSet($dataSet);

	$chart->setTitle("Cuadro #".$pregunta);
	
	if(file_exists("../../generados/reportes/Encuesta".$DatEncuestaPregunta->EprId.FncCambiaFechaAMysql($POST_finicio).FncCambiaFechaAMysql($POST_ffin).".png")){
		unlink("../../generados/reportes/Encuesta".$DatEncuestaPregunta->EprId.FncCambiaFechaAMysql($POST_finicio).FncCambiaFechaAMysql($POST_ffin).".png");
	}
	
	$chart->render("../../generados/reportes/Encuesta".$DatEncuestaPregunta->EprId.FncCambiaFechaAMysql($POST_finicio).FncCambiaFechaAMysql($POST_ffin).".png");
?>
  
  <img align="absmiddle" alt="Pie Chart"  src="../../generados/reportes/Encuesta<?php echo $DatEncuestaPregunta->EprId.FncCambiaFechaAMysql($POST_finicio).FncCambiaFechaAMysql($POST_ffin);?>.png" style="border: 1px solid gray;"/></td>
</tr>
</tbody>
</table>


   
<?php
		$pregunta++;			
	}
}
?>   


        
        </td>
        </tr>
        
        
  
     <tr   >
       <td  align="right" valign="middle"   >-</td>
       </tr>

          </tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>
<br>

<?php
//MtdObtenerEncuestaPreguntas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL,$oTipo=NULL,$oSeccion=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {
$ResEncuestaPregunta  = $InsEncuestaPregunta->MtdObtenerEncuestaPreguntas(NULL,NULL,NULL,'EprId','ASC',NULL,NULL,NULL,"2",NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Tipo);
$ArrEncuestaPreguntas = $ResEncuestaPregunta['Datos'];

if(!empty($ArrEncuestaPreguntas )){
	foreach($ArrEncuestaPreguntas  as $DatEncuestaPregunta){
		
///MtdObtenerEncuestaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuesta=NULL,$oEncuestaPregunta=NULL) {

?>

<span class="EstTablaReporteSubtitulo"><?php echo $DatEncuestaPregunta->EprNombre?></span><br><br>
        
<?php
		$ResEncuestaDetalle = $InsEncuestaDetalle->MtdObtenerEncuestaDetalles(NULL,NULL,NULL,'EdeTiempoCreacion','ASC',NULL,3,NULL,$DatEncuestaPregunta->EprId);	
		$ArrEncuestaDetalles = $ResEncuestaDetalle['Datos'];
		
		if(!empty($ArrEncuestaDetalles)){
			foreach($ArrEncuestaDetalles as $DatEncuestaDetalle){
		?>
        		
                <?php echo $DatEncuestaDetalle->EncFecha;?> - <?php echo $DatEncuestaDetalle->EdeRespuesta;?><br>
                
        <?php	
			}
		}
		
?>
		
        
        <?php
		?>
        
<?php
	}
}
?>
       
        
        

	
 

</body>
</html>