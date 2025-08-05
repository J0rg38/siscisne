<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

$Identificador = $_POST['Identificador'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

session_start();
if (!isset($_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador])){
	$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();	
}

//SesionObjeto-FacturaExportacionAlmacenMovimiento
//Parametro1 = FeaId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = FeaEstado
//Parametro6 = FeaTiempoCreacion
//Parametro7 = FeaTiempoModificacion

$RepSesionObjetos = $_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


?>



<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>

<?php
$c = 1;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

  - <?php echo utf8_encode($DatSesionObjeto->Parametro2);?>
  
    <?php
if($POST_Eliminar==1){
?>
  
  <a href="javascript:FncFacturaExportacionAlmacenMovimientoEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
  <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  
  <?php
}
?>


<?php

$c++;
}

?>







<?php
}
?>
