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

$GET_VehiculoMarca = $_POST['VehiculoMarca'];
$GET_VehiculoModelo = $_POST['VehiculoModelo'];
$GET_VehiculoVersion = $_POST['VehiculoVersion'];
$GET_AnoModelo = $_POST['AnoModelo'];
$GET_AnoFabricacion = $_POST['AnoFabricacion'];
$GET_Color = $_POST['Color'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();

//MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL) 
$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinDiasinmovilizados","DESC","1",NULL,NULL,NULL,"STOCK",$GET_VehiculoMarca,$GET_VehiculoModelo,$GET_VehiculoVersion,$GET_AnoModelo,NULL,$GET_Color,NULL);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

$VehiculoIngresoId = "";

if(!empty($ArrVehiculoIngresos)){
	foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){

		$VehiculoIngresoId = $DatVehiculoIngreso->EinId;
		
		break;		
	}
}

if(!empty($VehiculoIngresoId)){
	
	$InsVehiculoIngreso = new ClsVehiculoIngreso();
	$InsVehiculoIngreso->EinId = $VehiculoIngresoId;
	$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);
	
}

$InsVehiculoIngreso->InsMysql = NULL;

echo json_encode($InsVehiculoIngreso);

?>