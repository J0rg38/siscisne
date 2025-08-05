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

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');


$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();

$FechaInicio = "01/".date("m")."/".date("Y");
$FechaFin = date("d/m/Y");

$POST_PersonalId = $_POST['Personal'];

////MtdObtenerOrdenVentaVehiculoSinEntregas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0,$oTieneComprobante=false,$oFechaTipo="OvvFecha",$oTiempoTranscurrido=NULL)
$ResOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculoSinEntregas(NULL,NULL,NULL,"OvvFecha","ASC",NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,$POST_Moneda,$POST_PersonalId,NULL,0,NULL,NULL,NULL,$POST_Sucursal,1,NULL,NULL,2,true,NULL,20);
$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];

$Mensaje = "";
$Total = count($ArrOrdenVentaVehiculos);

$Mensaje .= "Tienes ".$Total." ordenes pendientes sin confirmar entrega: ";
$Mensaje .= "<br>";
$Mensaje .= "<br>";
if(!empty($ArrOrdenVentaVehiculos)){
	foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){
		

		$Mensaje .= "* ".$DatOrdenVentaVehiculo->OvvId." - ".$DatOrdenVentaVehiculo->CliNombre." ".$DatOrdenVentaVehiculo->CliApellidoPaterno." ".$DatOrdenVentaVehiculo->CliApellidoMaterno;
		$Mensaje .= "<br>";
		
	}	
}


$Resultado['Mensaje'] = $Mensaje;
$Resultado['Total'] = ($Total);

echo json_encode($Resultado);

?>