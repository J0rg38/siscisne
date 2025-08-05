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

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


$POST_FichaIngresoId = $_POST['FichaIngresoId'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngreso->FinId = $POST_FichaIngresoId;
$InsFichaIngreso->MtdObtenerFichaIngreso(false);

?>


            <?php            
if(!empty($InsFichaIngreso->PerFoto)){
	
	$extension = strtolower(pathinfo($InsFichaIngreso->PerFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($InsFichaIngreso->PerFoto, '.'.$extension);  
?>


	<a target="_blank" href="subidos/personal_fotos/<?php echo $InsFichaIngreso->PerFoto;?>" class="thickbox" title=""><img  src="subidos/personal_fotos/<?php echo $nombre_base."_thumb2.".$extension;?>" width="25" height="25" border="0" class="tooltip"  /></a>

  
<?php	
}else{
?>
<img  src="subidos/personal_fotos/default_thumb.jpg" width="25" height="25" border="0" class="tooltip"  />
<?php	
}
?>
     
     


<a id="BtnFichaIngresoPersonalEditar_<?php echo $POST_FichaIngresoId;?>" href="#">
<?php echo $InsFichaIngreso->PerNombre;?>
 <?php echo $InsFichaIngreso->PerApellidoPaterno;?>
  <?php echo $InsFichaIngreso->PerApellidoMaterno;?>
</a>