<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$POST_ClienteTipoId = $_POST['ClienteTipoId'];
$POST_CotizacionProductoId = $_POST['CotizacionProductoId'];

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');

$InsListaPrecio = new ClsListaPrecio();

/*
SesionObjeto-CotizacionProductoDetalle
Parametro1 = CrdId
Parametro2 = ProId
Parametro3 = ProNombre/
Parametro4 = CrdCosto
Parametro5 = CrdCantidad
Parametro6 = CrdImporte
Parametro7 = CrdTiempoCreacion
Parametro8 = CrdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = CrdCantidadReal
Parametro13 = ProCodigoOriginal
Parametro14 = ProCodigoAlternativo
Parametro15 = CrdPrecio
Parametro16 = CrdDescripcion
Parametro17 = CrdCodigo
*/

if(!empty($POST_ClienteTipoId)){


	$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();
	$ResCotizacionProductoDetalle =  $InsCotizacionProductoDetalle->MtdObtenerCotizacionProductoDetalles(NULL,NULL,NULL,NULL,NULL,$POST_CotizacionProductoId);
	$ArrCotizacionProductoDetalles = $ResCotizacionProductoDetalle['Datos'];
	
	if(!empty($ArrCotizacionProductoDetalles)){
		foreach($ArrCotizacionProductoDetalles as $DatCotizacioProductoDetalle){
	
			
			if(!empty($DatCotizacioProductoDetalle->ProId) and !empty($DatCotizacioProductoDetalle->UmeId)){
	
				$Precio = 0;
	
				$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'Desc','1',$DatCotizacioProductoDetalle->ProId,$POST_ClienteTipoId,$DatCotizacioProductoDetalle->UmeId);
				$ArrListaPrecios = $ResListaPrecio['Datos'];
				
				if(!empty($ArrListaPrecios)){
					foreach($ArrListaPrecios as $DatListaPrecio){
						$Precio = round($DatListaPrecio->LprPrecio,3);	
					}
				}
	
				$Importe = round(($DatCotizacioProductoDetalle->CrdCantidad * $Precio),3);
			
				$InsCotizacionProductoDetalle = new ClsCotizacionProductoDetalle();
				$InsCotizacionProductoDetalle->CrdId = $DatCotizacioProductoDetalle->CrdId;
				$InsCotizacionProductoDetalle->MtdObtenerCotizacionProductoDetalle();
			
				$InsCotizacionProductoDetalle->CrdPrecio = $Precio;
				$InsCotizacionProductoDetalle->CrdImporte = $Importe;
				$InsCotizacionProductoDetalle->CrdTiempoModificacion = date("Y-m-d H:i:s");
			
				if($InsCotizacionProductoDetalle->MtdEditarCotizacionProductoDetalle()){
					
				}
				
			}
		
	
	
		}
	}

}
?>