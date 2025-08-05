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
	header("Content-Disposition:  filename=\"REPORTE_SEGUIMIENTO_REPARACION_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="js/JsReporteOrdenCompraLlegada.js"></script>
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

$POST_Asesor = $_POST['CmpAsesor'];
$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FllFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"ASC";

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');

$InsPersonal = new ClsPersonal();
$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngresoLlamada = new ClsFichaIngresoLlamada();

//MtdObtenerFichaIngresoLlamadas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FllId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAsesor=NULL) {

//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,1);
//$ArrAsesores = $ResPersonal['Datos'];

$ResFichaIngresoLlamada = $InsFichaIngresoLlamada->MtdObtenerFichaIngresoLlamadas(NULL,NULL,$POST_ord,$POST_sen,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_Asesor);
$ArrFichaIngresoLlamadas = $ResFichaIngresoLlamada['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_reporte.png" width="150"  />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE RESUMEN SEGUIMIENTO DE LLAMADAS</span></td>
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
          <th width="5%">O.T.</th>
          <th width="5%">FECHA</th>
          <th width="14%">ASESOR</th>
          <th width="14%" align="center">CLIENTE</th>
          <th width="17%" align="center">NOTA</th>
          <th width="10%">VIN</th>
          <th width="10%">PLACA</th>
          <th width="11%">MARCA</th>
          <th width="12%">MODELO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		
		$c=1;
        foreach($ArrFichaIngresoLlamadas as $DatFichaIngresoLlamada){
		
        ?>
        
       
        
                  <tr id="Fila_<?php echo $c;?>" >
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="middle"   ><?php echo $c;?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><a target="_blank" href="../../principal.php?Mod=TrabajoTerminado&Form=Ver&Id=<?php echo ($DatFichaIngresoLlamada->FinId);?>"><?php echo ($DatFichaIngresoLlamada->FinId);?></a></td>
                <td  align="right" valign="top" bgcolor="<?php echo $fondo;?>"   ><?php echo ($DatFichaIngresoLlamada->FllFecha);?></td>
                <td bgcolor="<?php echo $fondo;?>"  align="right" valign="top"   ><?php echo ($DatFichaIngresoLlamada->PerNombre);?><?php echo ($DatFichaIngresoLlamada->PerApellidoPaterno);?><?php echo ($DatFichaIngresoLlamada->PerApellidoMaterno);?></td>
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="top"  ><?php echo ($DatFichaIngresoLlamada->CliNombre);?><?php echo ($DatFichaIngresoLlamada->CliApellidoPaterno);?><?php echo ($DatFichaIngresoLlamada->CliApellidoMaterno);?></td>
                <td bgcolor="<?php echo $fondo;?>" align="right" valign="top"  ><?php echo ($DatFichaIngresoLlamada->FllObservacion);?></td>
                <td  align="right" valign="top" bgcolor="<?php echo $fondo;?>"   ><?php echo ($DatFichaIngresoLlamada->EinVIN);?></td>
                <td  align="right" valign="top" bgcolor="<?php echo $fondo;?>"   ><?php echo ($DatFichaIngresoLlamada->EinPlaca);?></td>
                <td  align="right" valign="top" bgcolor="<?php echo $fondo;?>"   ><?php echo ($DatFichaIngresoLlamada->VmaNombre);?></td>
                <td  align="right" valign="top" bgcolor="<?php echo $fondo;?>"   ><?php echo ($DatFichaIngresoLlamada->VmoNombre);?></td>
          </tr>
		<?php	
			
		?>
  
      
              
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
          </tr>
          
          
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>



<p class="EstTablaReporteNota">

</p>

</body>
</html>