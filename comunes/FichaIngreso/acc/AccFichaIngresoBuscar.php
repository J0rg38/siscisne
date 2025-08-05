<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');
$InsFichaIngreso = new ClsFichaIngreso();


$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.Fin".$_POST['Campo'],"comienza",$_POST['Dato'],"Fin".$_POST['Campo'],"ASC",NULL,NULL,NULL);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];

$InsFichaIngreso->FinId = $ArrFichaIngresos[0]->FinId;
unset($ArrFichaIngresos);

$InsFichaIngreso->MtdObtenerFichaIngreso(false);
$InsFichaIngreso->InsMysql=NULL;

//$var = json_encode ($InsFichaIngreso);
//$json = new JSON;
//$var = $json->serialize( $InsFichaIngreso );
//$json->unserialize( $var );

$json = new Services_JSON();
$var = $json->encode($InsFichaIngreso);

echo $var;
?>