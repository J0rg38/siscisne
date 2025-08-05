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

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');

$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];

$InsCliente = new ClsCliente();
$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();

$ResCliente = $InsCliente->MtdObtenerClientes("Cli".$_POST['Campo'],"comienza",$_POST['Dato'],"Cli".$_POST['Campo'],"ASC",1,NULL,NULL,NULL);
$ArrClientes = $ResCliente['Datos'];


$InsCliente->CliId = $ArrClientes[0]->CliId;
unset($ArrClientes);

$InsCliente->MtdObtenerCliente();


$VehiculoIngresoId = "";


if(empty($POST_VehiculoIngresoId)){
	
	$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','Desc',NULL,NULL,$InsCliente->CliId);
	$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
	
	if(!empty($ArrVehiculoIngresoClientes)){
		foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){
			$VehiculoIngresoId = $DatVehiculoIngresoCliente->EinId;
		}
	}

}else{
	$VehiculoIngresoId = $POST_VehiculoIngresoId;
}



$InsCliente->CliNombre = (empty($InsCliente->CliNombre)?'':$InsCliente->CliNombre);
$InsCliente->CliApellidoPaterno = (empty($InsCliente->CliApellidoPaterno)?'':$InsCliente->CliApellidoPaterno);
$InsCliente->CliApellidoMaterno = (empty($InsCliente->CliApellidoMaterno)?'':$InsCliente->CliApellidoMaterno);

$InsCliente->CliDireccion = (empty($InsCliente->CliDireccion)?'':$InsCliente->CliDireccion);
$InsCliente->CliDistrito = (empty($InsCliente->CliDistrito)?'':$InsCliente->CliDistrito);
$InsCliente->CliProvincia = (empty($InsCliente->CliProvincia)?'':$InsCliente->CliProvincia);
$InsCliente->CliDepartamento = (empty($InsCliente->CliDepartamento)?'':$InsCliente->CliDepartamento);

$InsCliente->EinId = $VehiculoIngresoId;

$InsCliente->InsMysql = NULL;

//$var = json_encode ($InsCliente);
//$json = new JSON;
//$var = $json->serialize( $InsCliente );
//$json->unserialize( $var );

//$_SESSION['SesClienteId'] = $InsCliente->CliId; 

$json = new Services_JSON();
$var = $json->encode($InsCliente);

echo $var;
?>