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

$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];
$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];
$POST_Fecha = $_POST['Fecha'];

require_once($InsPoo->MtdPaqLogistica().'ClsVehiculoPromocion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqVentas().'ClsVehiculoPromocion20k.php');
require_once($InsPoo->MtdPaqVentas().'ClsVehiculoPromocion30k.php');

$InsVehiculoPromocion = new ClsVehiculoPromocion();
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"EinVIN","ASC","1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

$VehiculoIngresoId = "";
$VehiculoIngresoKilometraje = "";

if(!empty($ArrVehiculoIngresos)){
	foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
		$VehiculoIngresoId = $DatVehiculoIngreso->EinId;
		$VehiculoIngresoKilometraje = $DatVehiculoIngreso->EinKilometraje;
				
	}
}


$ResVehiculoPromocion = $InsVehiculoPromocion->MtdObtenerVehiculoPromociones("EinVIN","esigual",$POST_VehiculoIngresoVIN,"EinVIN","ASC","1",NULL);
$ArrVehiculosPromociones = $ResVehiculoPromocion['Datos'];
$InsVehiculoPromocion->OvvId = $ArrVehiculosPromociones[0]->OvvId;


$InsVehiculoPromocion->MtdObtenerVehiculoPromocion(false);

//deb($InsVehiculoPromocion->VroKilometrajeLimite." > ".$VehiculoIngresoKilometraje);

if($InsVehiculoPromocion->VroKilometrajeLimite>$VehiculoIngresoKilometraje){
	
	if(!empty($InsVehiculoPromocion->OvvId)){

	}else{
		$InsVehiculoPromocion->OvvId = NULL;
	}
		
}else{
	$InsVehiculoPromocion->OvvId = NULL;
}

unset($ArrVehiculosPromociones);

//MtdObtenerVehiculoPromocion

$InsVehiculoPromocion->InsMysql=NULL;

$json = new Services_JSON();
$var = $json->encode($InsVehiculoPromocion);

echo $var;

?>