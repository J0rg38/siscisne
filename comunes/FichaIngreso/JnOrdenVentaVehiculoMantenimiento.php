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

//$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];
$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

//$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"OvvFecha","ASC","1",NULL,NULL,NULL,NULL,NULL,NULL,0);
//$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];

// MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL) 
$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"OvvFecha","ASC","1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$POST_VehiculoIngresoId);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];

$InsOrdenVentaVehiculo->OvvId = $ArrOrdenVentaVehiculos[0]->OvvId;
unset($ArrOrdenVentaVehiculos);

//deb($InsOrdenVentaVehiculo->OvvId);
//$InsOrdenVentaVehiculo->MtdOrdenVentaVehiculo(true);
//$InsOrdenVentaVehiculo->InsMysql=NULL;

//MtdObtenerOrdenVentaVehiculoMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OvmId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenVentaVehiculo=NULL,$oEstado=NULL) {
	$ArrOrdenVentaVehiculoMantenimientos = array();
	
	if(!empty($InsOrdenVentaVehiculo->OvvId)){
		
		$InsOrdenVentaVehiculoMantenimiento = new ClsOrdenVentaVehiculoMantenimiento();
	$ResOrdenVentaVehiculoMantenimiento = $InsOrdenVentaVehiculoMantenimiento->MtdObtenerOrdenVentaVehiculoMantenimientos(NULL,NULL,'OvmKilometraje','DESC',NULL,$InsOrdenVentaVehiculo->OvvId,1);
		$ArrOrdenVentaVehiculoMantenimientos = $ResOrdenVentaVehiculoMantenimiento['Datos'];	
		
		if(!empty($ArrOrdenVentaVehiculoMantenimientos)){
			
			$InsOrdenVentaVehiculoMantenimiento = new ClsOrdenVentaVehiculoMantenimiento();
			$InsOrdenVentaVehiculoMantenimiento->OvmId = $ArrOrdenVentaVehiculoMantenimientos[0]->OvmId;
			$InsOrdenVentaVehiculoMantenimiento->MtdObtenerOrdenVentaVehiculoMantenimiento();
			$InsOrdenVentaVehiculoMantenimiento->InsMysql = NULL;
			unset($ArrOrdenVentaVehiculoMantenimientos);
			
			
		}
		
		
	}else{
		
	}


//$InsOrdenVen
//if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){
//	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
//		
//		if($DatOrdenVentaVehiculoObsequio->OvoEstado == 1){
//		}
//		
//	}
//}

//$json = new Services_JSON();
//$var = $json->encode($InsOrdenVentaVehiculoMantenimiento);
//
//echo $var;


$json = new JSON;
$var = $json->serialize( $InsOrdenVentaVehiculoMantenimiento );
$json->unserialize( $var );

echo $var;
?>