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

require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');


$POST_ProductoId = $_POST['ProductoId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPromocion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProductoListaPrecioCotizado.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');


$InsProducto = new ClsProducto();
$InsListaPrecio = new ClsListaPrecio();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPromocion = new ClsProductoListaPromocion();
$InsProductoListaPrecio = new ClsProductoListaPrecio();


$InsProducto->ProId = $POST_ProductoId;
$InsProducto->MtdObtenerProducto(false);
//$InsProducto->InsMysql=NULL;

$Respuesta = 0;

$Precio = 0;
$PrecioReal = 0;
$MonIdListaPrecio = NULL;
	
if(!empty($InsProducto->ProCodigoOriginal)){	
	
	if($InsProducto->ProCalcularPrecio==1){
		
		$InsProductoListaPrecio = new ClsProductoListaPrecio();
		$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$InsProducto->ProCodigoOriginal,'PlpTiempoCreacion','DESC',"1",1);
		$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
						
		if(!empty($ArrProductoListaPrecios)){
			foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
			
				$Precio = $DatProductoListaPrecio->PlpPrecio;
				$PrecioReal = $DatProductoListaPrecio->PlpPrecioReal;
				$MonIdListaPrecio = $DatProductoListaPrecio->MonId;
				
			}
			
			$InsProducto->MtdEditarProductoDato("ProCosto",$Precio,$InsProducto->ProId);	
			$InsProducto->MtdEditarProductoDato("ProListaPrecioCosto",$Precio,$InsProducto->ProId);							
			$InsProducto->MtdEditarProductoDato("ProListaPrecioCostoReal",$PrecioReal,$InsProducto->ProId);							
			$InsProducto->MtdEditarProductoDato("MonIdListaPrecio",$MonIdListaPrecio,$InsProducto->ProId);
			
			$Respuesta = 1;
		
		}else{
			$Respuesta = 2;
		}
		
	}else{
		$Respuesta = 3;
	}

}else{
	$Respuesta = 4;
}
			
$respuesta['CodigoRespuesta'] = $Respuesta;

echo json_encode($respuesta);

?>