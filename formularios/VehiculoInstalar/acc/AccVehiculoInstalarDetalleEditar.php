<?php
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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsVehiculoInstalarDetalle'.$Identificador])){
	$_SESSION['InsVehiculoInstalarDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsProducto->ProId = $_POST['ProductoId'];
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;
}else{

	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
	
	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}

}


if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){

	//SesionObjeto-AlmacenMovimientoEntradaSimpleDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = AmdEstado

	
	$InsVehiculoInstalarDetalle1 = array();
	$InsVehiculoInstalarDetalle1 = $_SESSION['InsVehiculoInstalarDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	$Cantidad = round($_POST['ProductoCantidad'],3);
	$Importe = round($_POST['ProductoImporte'],3);
	$Costo = round(($Importe/$Cantidad),3);		
	$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,3);
	$Utilidad = round($_POST['ProductoUtilidad'],3);
	$UtilidadPorcentaje = round($_POST['ProductoUtilidadPorcentaje'],3);

//	$InsVehiculoInstalarDetalle1->Parametro2,
//	$InsVehiculoInstalarDetalle1->Parametro3,

	$_SESSION['InsVehiculoInstalarDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsVehiculoInstalarDetalle1->Parametro1,
	$InsProducto->ProId,
	$InsProducto->ProNombre,
	$Costo,
	$Cantidad,
	$Importe,
	$InsVehiculoInstalarDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	$InsUnidadMedida->UmeNombre,
	$InsUnidadMedida->UmeId,
	$InsVehiculoInstalarDetalle1->Parametro11,
	$CantidadReal,
	$Utilidad,
	$UtilidadPorcentaje,
	$InsVehiculoInstalarDetalle1->Parametro15,
	NULL,
	$InsProducto->ProCodigoOriginal,
	$InsProducto->ProCodigoAlternativo,
	$InsVehiculoInstalarDetalle1->Parametro19,
	$InsVehiculoInstalarDetalle1->Parametro20,
	$InsVehiculoInstalarDetalle1->Parametro21,
	$InsVehiculoInstalarDetalle1->Parametro22,
	$InsVehiculoInstalarDetalle1->Parametro23,
	$InsVehiculoInstalarDetalle1->Parametro24,
	$_POST['VehiculoInstalarDetalleEstado']
	);
	
}
?>