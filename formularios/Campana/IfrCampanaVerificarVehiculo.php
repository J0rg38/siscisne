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
	header("Content-Disposition:  filename=\"VERIFICAR_VEHICULO_".date('d-m-Y').".xls\";");
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

$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

$POST_VehiculoIngresoVIN = $_POST['CmpVehiculoIngresoVIN'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"CamFechaInicio";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

if(empty($POST_VehiculoIngresoVIN)){
	die("Ingrese un numero de VIN");
}
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsCampana.php');
require_once($InsPoo->MtdPaqActividad().'ClsCampanaVehiculo.php');

$InsCampana = new ClsCampana();
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsCampanaVehiculo = new ClsCampanaVehiculo();
$InsFichaIngreso = new ClsFichaIngreso();

$ResCampana = $InsCampana->MtdObtenerCampanas($POST_cam,"contiene",$POST_fil,$POST_ord,$POST_sen,NULL,NULL,NULL,NULL);
$ArrCampanas = $ResCampana['Datos'];

$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"EinVIN","ASC","1",NULL,NULL,NULL);
$ArrVehiculosIngresos = $ResVehiculoIngreso['Datos'];

$InsVehiculoIngreso->EinId = $ArrVehiculosIngresos[0]->EinId;
unset($ArrVehiculosIngresos);

$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);
$InsVehiculoIngreso->InsMysql=NULL;
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
          <th width="2%">#</th>
          <th width="7%">COD. INTERNO</th>
          <th width="6%">CODIGO</th>
          <th width="23%">CAMPAÑA</th>
          <th width="8%">FECHA INICIO</th>
          <th width="8%">FECHA FIN</th>
          <th width="8%">¿EXISTE EN SISTEMA?</th>
          <th width="8%">¿TIENE CAMPAÑA?</th>
          <th width="8%">¿FUE REALIZADO?</th>
          <th width="12%">ORD. TRABAJO.</th>
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php

		$c=1;
        foreach($ArrCampanas as $DatCampana){
			

$TieneCampana = false;
$RealizoCampana = false;


$ResCampanaVehiculo = $InsCampanaVehiculo->MtdObtenerCampanaVehiculos("AveVIN","esigual",$InsVehiculoIngreso->EinVIN,'CamFechaInicio','ASC',"1",$DatCampana->CamId,NULL,NULL,NULL);
$ArrCampanaVehiculos = $ResCampanaVehiculo['Datos'];



if(!empty($ArrCampanaVehiculos)){

	$TieneCampana = true;

}


if($TieneCampana){

	if(!empty($InsVehiculoIngreso->EinVIN)){

		foreach($ArrCampanaVehiculos as $DatCampanaVehiculo){
			
			$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,'CamId','ASC','1',NULL,NULL,NULL,NULL,NULL,$InsVehiculoIngreso->EinVIN,NULL,NULL,0,$DatCampana->CamId);
			$ArrFichaIngresos = $ResFichaIngreso['Datos'];
	
			if(!empty($ArrFichaIngresos)){
				
				foreach($ArrFichaIngresos as $DatFichaIngreso){
	
					$RealizoCampana = true;
	
				}
				
			}
			
						
		}
				
	}else{
//		$RealizoCampana = false;
	}


}



        ?>
        <tr class="EstTablaListado"  >
          <td align="right" valign="middle"   ><?php echo $c;?></td>
          <td align="right" valign="middle"   >
		  
          <a href="../../principal.php?Mod=Campana&Form=Ver&Id=<?php echo $DatCampana->CamId;?>" target="_parent">
			 <?php echo $DatCampana->CamId;  ?></a>          
             
		  </td>
          <td align="right" ><?php echo ($DatCampana->CamCodigo);?></td>
          <td align="right" ><?php echo ($DatCampana->CamNombre);?></td>
          <td align="right" ><?php echo ($DatCampana->CamFechaInicio);?></td>
          <td align="right" ><?php echo $DatCampana->CamFechaFin;  ?>&nbsp;</td>
          <td align="right" ><?php
		  if(!empty($InsVehiculoIngreso->EinId)){
			?>
SI
  <?php  
		  }else{
		?>
NO
<?php  
		  }
		  ?></td>
          <td align="right" >
          
          <?php
		  if($TieneCampana){
			?>
            SI
            <?php
		  }else{
			?>
            NO
            <?php  
		  }
		  ?>
          
          
          </td>
          <td align="right" ><?php
		  if($RealizoCampana){
			?>
            SI
            <?php
		  }else{
			?>
            NO
  <?php  
		  }
		  ?></td>
          <td align="center" >
            
  <?php

if($TieneCampana){


	if($RealizoCampana){
		
		$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,'CamId','ASC','1',NULL,NULL,NULL,NULL,NULL,$InsVehiculoIngreso->EinVIN,NULL,NULL,0,$DatCampana->CamId);
		$ArrFichaIngresos = $ResFichaIngreso['Datos'];

		if(!empty($ArrFichaIngresos)){
			
			foreach($ArrFichaIngresos as $DatFichaIngreso){
?>
            <a target="_parent" href="principal.php?Mod=FichaIngreso&Form=Ver&Id=<?php echo $DatFichaIngreso->FinId;?>"><?php echo $DatFichaIngreso->FinId?></a>
  <?php
			}
			
		}
		
	}
}



?>
            &nbsp;
          </td>
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
          </tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>