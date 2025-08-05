<?php
header("Content-Type: application/json;charset=utf-8");
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
////require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

$GET_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];

require_once($InsPoo->MtdPaqLogistica().'ClsAsignacionVentaVehiculo.php');



$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
//MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL)
$ResAsignacionVentaVehiculo = $InsAsignacionVentaVehiculo->MtdObtenerAsignacionVentaVehiculos("EinVIN","esigual",$GET_VehiculoIngresoVIN,"AvvFecha","DESC",NULL,(NULL),(NULL),$POST_estado,NULL);
$ArrAsignacionVentaVehiculos = $ResAsignacionVentaVehiculo['Datos'];

$AsignacionVentaVehiculoId = "";

if(!empty($ArrAsignacionVentaVehiculos)){
	foreach($ArrAsignacionVentaVehiculos as $DatAsignacionVentaVehiculo){
		
		if($DatAsignacionVentaVehiculo->AvvEstado!=6){
	
			$AsignacionVentaVehiculoId = $DatAsignacionVentaVehiculo->AvvId;				

		}
			
	}
}

if(!empty($AsignacionVentaVehiculoId)){
	
	$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
	$InsAsignacionVentaVehiculo->AvvId = $AsignacionVentaVehiculoId;
	$InsAsignacionVentaVehiculo->MtdObtenerAsignacionVentaVehiculo(false);
	
}

$InsAsignacionVentaVehiculo->InsMysql = NULL;

echo json_encode($InsAsignacionVentaVehiculo);

?>