<?php
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

?>
<?php
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
?>
<?php
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');

$InsRegimen = new ClsRegimen();

$ResRegimen = $InsRegimen->MtdObtenerRegimenes("Reg".$_POST['Campo'],"contiene",$_POST['Dato'],"Reg".$_POST['Campo'],"ASC",1,NULL);

$ArrRegimenes = $ResRegimen['Datos'];

$InsRegimen->RegId = $ArrRegimenes[0]->RegId;
unset($ArrRegimenes);

$InsRegimen->MtdObtenerRegimen();
$InsRegimen->InsMysql=NULL;

$json = new JSON;
$var = $json->serialize( $InsRegimen );

$json->unserialize( $var );

echo $var;

?>