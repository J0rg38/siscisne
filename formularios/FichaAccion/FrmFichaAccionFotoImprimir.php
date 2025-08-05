<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');


$InsFichaAccion = new ClsFichaAccion();

$InsFichaAccion->FccId = $GET_id;
$InsFichaAccion->MtdObtenerFichaAccion();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Trabajo No. <?php echo $InsFichaAccion->FccId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssFichaAccion.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsFichaAccionImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsFichaAccion->FccId)){?> 
FncFichaAccionImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>


<?php
if(!empty($InsFichaAccion->FinFotoVIN)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsFichaAccion->FinFotoVIN;?>" width="261" height="159"   />

<?php
}
?>

<?php
if(!empty($InsFichaAccion->FinFotoFrontal)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsFichaAccion->FinFotoFrontal;?>" width="261" height="159"   />

<?php
}
?>


<?php
if(!empty($InsFichaAccion->FinFotoCupon)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsFichaAccion->FinFotoCupon;?>" width="261" height="159"   />

<?php
}
?>


<?php
if(!empty($InsFichaAccion->FinFotoMantenimiento)){
?>
<img src="../../subidos/ficha_ingreso_fotos/<?php echo $InsFichaAccion->FinFotoMantenimiento;?>" width="261" height="159"   />

<?php
}
?>

    

<?php
$i = 1;
if(!empty($InsFichaAccion->FichaAccionFoto)){
	foreach($InsFichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
?>
	
	<img src="../../subidos/ficha_accion_fotos/<?php echo $DatFichaAccionFoto->FafArchivo;?>" width="261" height="159"  align="<?php echo $DatFichaAccionFoto->FafArchivo;?>" />
    
    <?php
	if($i%2==0){
	?>
    <br />
    <?php
	}
	?>
    
<?php
	$i++;
	}
}
?>

</body>
</html>
