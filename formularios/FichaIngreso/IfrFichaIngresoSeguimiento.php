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
	header("Content-Disposition:  filename=\"SEGUIMIENTO_ORDEN_TRABAJO_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link rel="stylesheet" type="text/css" href="css/CssFichaIngreso.css">
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

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");

$POST_ClienteNombre = $_POST['CmpClienteNombre'];
$POST_ClienteId = $_POST['CmpClienteId'];
$POST_VehiculoIngresoVIN = $_POST['CmpVehiculoIngresoVIN'];
$POST_FichaIngresoId = $_POST['CmpFichaIngresoId'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"FinFecha";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngreso->Ruta = '../../';

//MtdObtenerFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL) {
$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.FinId","contiene",$POST_FichaIngresoId,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,NULL,$POST_VehiculoIngresoVIN,$POST_ClienteId);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];

?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">SEGUIMIENTO DE ORDENES DE TRABAJO
  
  DEL
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
          <th width="1%">#</th>
          <th width="6%">COD. ORD. TRABAJO</th>
          <th width="0%">PROGRESO</th>
          <th width="0%">MODALIDADES</th>
          <th width="4%">FECHA</th>
          <th width="5%">NUM. DOC.</th>
          <th width="22%">CLIENTE.</th>
          <th width="8%">VIN</th>
          <th width="5%">MARCA.</th>
          <th width="5%">MODELO</th>
          <th width="6%">VERSION</th>
          <th width="7%">AÑO FABRIC.</th>
          <th width="6%">VEH. KILOM.</th>
          <th width="6%">PLAN MANT.</th>
          <th width="9%">PRIORIDAD</th>
          <th width="10%">ESTADO</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$c=1;
        foreach($ArrFichaIngresos as $DatFichaIngreso){
        ?>
        <tr class="EstTablaListado"  >
          <td align="right" valign="middle"   ><?php echo $c;?></td>
          <td align="right" valign="middle"   >
		  
          <a href="../../principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatFichaIngreso->FinId;?>" target="_parent">
			 <?php echo $DatFichaIngreso->FinId;  ?></a>          
             
			</td>
          <td align="right" ><?php
$porcentaje = 0;
	switch($DatFichaIngreso->FinEstado){
		
		case 1:
			$porcentaje = 3.75;

		break;
		
		case 11:
			$porcentaje = 3.75 + 3.75;
		break;
		
		case 2:
			$porcentaje = 3.75 + 3.75 + 12;
		break;
		
		case 3:
			$porcentaje = 3.75 + 3.75 + 12 + 12;
		break;
		
		case 4:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12;
		break;
		
		case 5:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667;
		break;
		
		case 6:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667;
		break;
		
		case 7:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667;
		break;
		
		case 71:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12;
		break;
		
		case 72:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12;
		break;
		
		case 73:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12;
		break;
		
		case 74:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12 + 3.75;
		break;
		
		case 75:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12 + 3.75 + 3.75;
		break;
		
		case 9:
			$porcentaje = 3.75 + 3.75 + 12 + 12 + 12 + 6.666666666666667 + 6.666666666666667 + 6.666666666666667 + 12 +12 + 3.75 + 3.75 +5;
		break;
	}

?>
            <?php
				$clase = "";
				if($porcentaje >= 0 and $porcentaje < 11){
					$clase = "EstFichaIngresoNivel1";
				}else if($porcentaje >= 11 and $porcentaje < 21){
					$clase = "EstFichaIngresoNivel2";
				}else if($porcentaje >= 21 and $porcentaje < 31){
					$clase = "EstFichaIngresoNivel3";
				}else if($porcentaje >= 31 and $porcentaje < 41){
					$clase = "EstFichaIngresoNivel4";
				}else if($porcentaje >= 41 and $porcentaje < 51){
					$clase = "EstFichaIngresoNivel5";
				}else if($porcentaje >= 51 and $porcentaje < 61){
					$clase = "EstFichaIngresoNivel6";
				}else if($porcentaje >= 61 and $porcentaje < 71){
					$clase = "EstFichaIngresoNivel7";
				}else if($porcentaje >= 71 and $porcentaje < 81){
					$clase = "EstFichaIngresoNivel8";
				}else if($porcentaje >= 81 and $porcentaje < 91){
					$clase = "EstFichaIngresoNivel9";
				}else if($porcentaje >= 91 and $porcentaje < 101){
					$clase = "EstFichaIngresoNivel10";
				}
				?>
            <div class="<?php echo $clase ?>" > <?php echo number_format($porcentaje,2); ?> % </div></td>
          <td align="right" ><?php
		  $InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
		  
		  //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
		  $ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatFichaIngreso->FinId,NULL);
		  $ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
		  ?>
            <?php
		foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
		?>
            <?php echo $DatFichaIngresoModalidad->MinNombre?><br>
            <?php
		}
		?></td>
          <td align="right" ><?php echo ($DatFichaIngreso->FinFecha);?></td>
          <td align="right" ><?php echo ($DatFichaIngreso->CliNumeroDocumento);?></td>
          <td align="right" ><?php echo $DatFichaIngreso->CliNombre;  ?> <?php echo $DatFichaIngreso->CliApellidoPaterno;  ?> <?php echo $DatFichaIngreso->CliApellidoMaterno;  ?></td>
          <td align="right" >
          <?php echo $DatFichaIngreso->EinVIN;  ?></td>
          <td align="right" ><?php echo $DatFichaIngreso->VmaNombre;  ?></td>
          <td align="right" ><?php echo $DatFichaIngreso->VmoNombre;  ?></td>
          <td align="right" ><?php echo $DatFichaIngreso->VveNombre;  ?></td>
          <td align="right" ><?php echo $DatFichaIngreso->EinAnoFabricacion;  ?></td>
          <td align="right" ><?php echo $DatFichaIngreso->FinVehiculoKilometraje;  ?></td>
          <td align="right" ><?php echo $DatFichaIngreso->FinMantenimientoKilometraje;  ?></td>
          <td align="right" ><?php
				switch($DatFichaIngreso->FinPrioridad){
					case 1:
				?>
Urgente
  <?php	
					break;
					
					case 2:
				?>
Normal
<?php	
					break;
				}
				?></td>
          <td align="right" ><?php echo ($DatFichaIngreso->FinEstadoDescripcion);?></td>
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
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>