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

$POST_Campo = $_POST['Campo'];
$POST_Dato = $_POST['Dato'];

$Campo = "";

if($POST_Campo=="Version"){
	$Campo = "veh.VveId";	
}else{
	$Campo = "Veh".$POST_Campo;	
}

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');

$InsVehiculo = new ClsVehiculo();

$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos($Campo,"comienza",$POST_Dato,$Campo,"ASC",NULL,NULL,NULL);
$ArrVehiculos = $ResVehiculo['Datos'];

$InsVehiculo->VehId = $ArrVehiculos[0]->VehId;
unset($ArrVehiculos);

$InsVehiculo->MtdObtenerVehiculo();
$InsVehiculo->InsMysql=NULL;

//$var = json_encode ($InsVehiculo);


//$json = new JSON;
//$var = $json->serialize( $InsVehiculo );
//$json->unserialize( $var );


$json = new Services_JSON();
$var = $json->encode($InsVehiculo);

echo $var;

?>