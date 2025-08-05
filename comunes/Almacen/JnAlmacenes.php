<?php
session_start();
header("Content-type: application/json; charset=utf-8");
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

$GET_SucursalId = $_GET['SucursalId'];



require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

$InsAlmacen = new ClsAlmacen();

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$GET_SucursalId);
$ArrAlmacenes = $RepAlmacen['Datos'];
//deb($ArrAlmacenes);

$ArrAlmacenes2 = array();

if(!empty($ArrAlmacenes)){
	foreach($ArrAlmacenes as $DatAlmacen){
		
		$InsAlmacen1 = new ClsAlmacen();
		$InsAlmacen1->AlmNombre = $DatAlmacen->AlmNombre;
		$InsAlmacen1->AlmId = $DatAlmacen->AlmId;
		
		$InsAlmacen1->InsMysql = NULL;
		
		$ArrAlmacenes2[] = $InsAlmacen1;
	
	}
}

//echo json_encode($ArrAlmacenes);
//
//$error = json_last_error();
//
//deb($error);

$json = new JSON;
$var = $json->serialize( $ArrAlmacenes2 );
$json->unserialize( $var );

echo $var;
?>