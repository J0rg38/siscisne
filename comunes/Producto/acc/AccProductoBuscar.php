<?php
//session_start();
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


$POST_ClienteTipo = $_POST['ClienteTipo'];

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


$InsProducto = new ClsProducto();
$InsListaPrecio = new ClsListaPrecio();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPromocion = new ClsProductoListaPromocion();
$InsProductoListaPrecio = new ClsProductoListaPrecio();

$ResProducto = $InsProducto->MtdObtenerProductos("Pro".$_POST['Campo'],"contiene",$_POST['Dato'],"Pro".$_POST['Campo'],"ASC",NULL,1,NULL,NULL);
$ArrProductos = $ResProducto['Datos'];



$InsProducto->ProId = $ArrProductos[0]->ProId;
unset($ArrProductos);
$InsProducto->MtdObtenerProducto(false);

//deb($InsProducto->ProId);
if(!empty($POST_ClienteTipo )){
		
	//MtdObtenerListaPrecios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL)
	$RepListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId","ASC","1",$InsProducto->ProId,$POST_ClienteTipo,$InsProducto->UmeIdSalida);
	$ArrListaPrecios = $RepListaPrecio['Datos'];
//	deb($ArrListaPrecios[0]->LprId);
	$InsListaPrecio->LprId = $ArrListaPrecios[0]->LprId;
	unset($ArrListaPrecios);
	$InsListaPrecio->MtdObtenerListaPrecio();
	
	$InsProducto->LprCosto = $InsListaPrecio->LprCosto;
	$InsProducto->LprPrecio = $InsListaPrecio->LprPrecio;
	$InsProducto->LprValorVenta = $InsListaPrecio->LprValorVenta;

}else{
	
	$InsProducto->LprCosto = 0;
	$InsProducto->LprPrecio = 0;
	$InsProducto->LprValorVenta = 0;
	
}

if(!empty($InsProducto->ProCodigoOriginal)){
		
	$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$InsProducto->ProCodigoOriginal, 'PdiId','ASC',"1",1);
	$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
					  
	$InsProductoDisponibilidad->PdiId = $ArrProductoDisponibilidades[0]->PdiId;
	unset($ArrProductoDisponibilidades);
	$InsProductoDisponibilidad->MtdObtenerProductoDisponibilidad();
	
	if($InsProductoDisponibilidad->PdiDisponible == 1){
		$InsProducto->ProTieneDisponibilidadGM = "SI";	
	}else{
		$InsProducto->ProTieneDisponibilidadGM =  "NO";	
	}
	
}else{
	$InsProducto->ProTieneDisponibilidadGM =  "NO";
}

if(!empty($InsProducto->ProCodigoOriginal)){
		
	$ResProductoListaPromocion = $InsProductoListaPromocion->MtdObtenerProductoListaPromociones("PloCodigo","esigual",$InsProducto->ProCodigoOriginal, 'PloId','ASC',"1",1);
	$ArrProductoListaPromocions = $ResProductoListaPromocion['Datos'];
					  
	$InsProductoListaPromocion->PloId = $ArrProductoListaPromocions[0]->PloId;
	unset($ArrProductoListaPromocions);
	$InsProductoListaPromocion->MtdObtenerProductoListaPromocion();

	$InsProducto->MonIdListaPromocion = $InsProductoListaPromocion->MonId;
	$InsProducto->ProListaPromocionCostoReal = $InsProductoListaPromocion->PloPrecioReal;
	$InsProducto->ProListaPromocionCosto = $InsProductoListaPromocion->PloPrecio;
		
}else{

	$InsProducto->MonIdListaPromocion = "";
	$InsProducto->ProListaPromocionCostoReal = 0;
	$InsProducto->ProListaPromocionCosto = 0;

}

if(!empty($InsProducto->ProCodigoOriginal)){
	
	$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$InsProducto->ProCodigoOriginal, 'PlpId','ASC',"1",1);
	$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
					  
	$ProductoListaPrecioMonedaId = "";
	$ProductoListaPrecioReal = 0;
	$ProductoListaPrecio = 0;
	
	if(!empty($ArrProductoListaPrecios)){
		foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
			
			$ProductoListaPrecioMonedaId = $DatProductoListaPrecio->MonId;
			$ProductoListaPrecioReal =  $DatProductoListaPrecio->PlpPrecioReal;
			$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
			
		}
	}
	
	if(empty($ProductoListaPrecioReal) and empty($ProductoListaPrecio)){
		
		$InsProductoListaPrecioCotizado = new ClsProductoListaPrecioCotizado();
		//MtdObtenerProductoListaPrecioCotizado($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProductoId=NULL) {
		$ResProductoListaPrecioCotizado = $InsProductoListaPrecioCotizado->MtdObtenerProductoListaPrecioCotizado("pro.ProCodigoOriginal",$InsProducto->ProCodigoOriginal,"OodTiempoCreacion","DESC",NULL,NULL);
		$ArrProductoListaPrecioCotizados = $ResProductoListaPrecioCotizado['Datos'];
		
		$ProductoListaPrecioMonedaId = "";
		$ProductoListaPrecioReal = 0;
		$ProductoListaPrecio = 0;
		
		if(!empty($ArrProductoListaPrecioCotizados)){
			foreach($ArrProductoListaPrecioCotizados as $DatProductoListaPrecioCotizado){
				
				$PrecioBruto = $DatProductoListaPrecioCotizado->OodPrecio;
				
				if($DatProductoListaPrecioCotizado->MonId<>$EmpresaMonedaId){
					$PrecioConvertido = $DatProductoListaPrecioCotizado->OodPrecio / $DatProductoListaPrecioCotizado->OotTipoCambio;
				}
				
				$ProductoListaPrecioMonedaId = $DatProductoListaPrecioCotizado->MonId;
				$ProductoListaPrecioReal =  $PrecioConvertido;
				$ProductoListaPrecio = $PrecioBruto;
				
			}
		}
		
	}

	$InsProducto->MonIdListaPrecio = $ProductoListaPrecioMonedaId;
	$InsProducto->ProListaPrecioCostoReal = $ProductoListaPrecioReal;
	$InsProducto->ProListaPrecioCosto = $ProductoListaPrecio;
	
}else{
	
	$InsProducto->MonIdListaPrecio  = "";
	$InsProducto->ProListaPrecioCostoReal = 0;
	$InsProducto->ProListaPrecioCosto = 0;
	
}


//deb($InsProducto->ProductoPrecio);
//if(!empty($InsProducto->ProductoPrecio)){
//	foreach($InsProducto->ProductoPrecio as $DatProductoPrecio){
//		
//		if($DatProductoPrecio->LtiId == $_POST['ClienteTipo']){
//			$InsProducto->ProPrecio = round($DatProductoPrecio->PprPrecio,3);	
//			$InsProducto->ProValorVenta = round($DatProductoPrecio->PprValorVenta,3);	
//			break;
//		}else{
//			$InsProducto->ProPrecio = 000;	
//			$InsProducto->ProValorVenta = 000;	
//		}
//		
//	}
//}else{
//	$InsProducto->ProPrecio = 000;
//	$InsProducto->ProValorVenta = 000;	
//}

//$InsProducto->ProCosto = round($InsProducto->ProCosto,3);

									  
$InsProducto->ProCostoIngreso = round($InsProducto->ProCostoIngreso,3);
$InsProducto->ProCostoIngresoNeto = round($InsProducto->ProCostoIngresoNeto,3);

$InsProducto->InsMysql=NULL;
//$json = new JSON;
//$var = $json->serialize( $InsProducto );
//$json->unserialize( $var );
//$json = new Services_JSON();
//echo $json->encode($InsProducto);

echo json_encode($InsProducto);
?>