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

$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];



require_once($InsPoo->MtdPaqActividad().'ClsOrdenVentaVehiculo.php');

require_once($InsPoo->MtdPaqActividad().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqActividad().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqActividad().'ClsOrdenVentaVehiculoPropietario.php');

$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"OvvFecha","ASC","1",NULL,NULL,NULL,NULL,NULL,NULL,0);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];


$InsOrdenVentaVehiculo->OvvId = $ArrOrdenVentaVehiculos[0]->OvvId;
unset($ArrOrdenVentaVehiculos);

//$InsOrdenVentaVehiculo->MtdOrdenVentaVehiculo(true);
//$InsOrdenVentaVehiculo->InsMysql=NULL;

$ResOrdenVentaVehiculoObsequio = $InsOrdenVentaVehiculoObsequio->MtdObtenerOrdenVentaVehiculoObsequios(NULL,NULL,'OvoId','Desc',"1",$InsOrdenVentaVehiculo->OvvId,1);
$ArrOrdenVentaVehiculoObsequios = $ResOrdenVentaVehiculoObsequio[];

//$InsOrdenVen
//if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){
//	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
//		
//		if($DatOrdenVentaVehiculoObsequio->OvoEstado == 1){
//		}
//		
//	}
//}

$json = new Services_JSON();
$var = $json->encode($ArrOrdenVentaVehiculoObsequios);

echo $var;

?>