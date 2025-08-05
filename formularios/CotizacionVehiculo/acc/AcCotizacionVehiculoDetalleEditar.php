<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsCotizacionVehiculoDetalle'.$Identificador])){
	$_SESSION['InsCotizacionVehiculoDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

if($InsUnidadMedida->UmeId == $InsCotizacionVehiculo->UmeId){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;
}else{
	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsCotizacionVehiculo->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
	
	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}
}

/*
SesionObjeto-CotizacionVehiculoDetalle
Parametro1 = CvdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = CvdCosto
Parametro5 = CvdCantidad
Parametro6 = CvdImporte
Parametro7 = CvdTiempoCreacion
Parametro8 = CvdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = CvdCantidadReal
Parametro13 = ProCodigoOriginal
Parametro14 = ProCodigoAlternativo
*/
	
$InsCotizacionVehiculoDetalle1 = array();
$InsCotizacionVehiculoDetalle1 = $_SESSION['InsCotizacionVehiculoDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$Cantidad = round($_POST['ProductoCantidad'],3);
$Importe = round($_POST['ProductoImporte'],3);
$Costo = round(($Importe/$Cantidad),3);		
$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,3);

$_SESSION['InsCotizacionVehiculoDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsCotizacionVehiculoDetalle1->Parametro1,
$InsCotizacionVehiculoDetalle1->Parametro2,
$InsCotizacionVehiculoDetalle1->Parametro3,
$Costo,
$Cantidad,
$Importe,
$InsCotizacionVehiculoDetalle1->Parametro7,
date("d/m/Y H:i:s"),
$InsCotizacionVehiculoDetalle1->Parametro9,
$InsUnidadMedida->UmeNombre,
$InsUnidadMedida->UmeId,
$InsAlmacenMovimientoEntradaDetalle1->Parametro11,
$CantidadReal,
$InsCotizacionVehiculoDetalle1->Parametro13,
$InsCotizacionVehiculoDetalle1->Parametro14
);
?>