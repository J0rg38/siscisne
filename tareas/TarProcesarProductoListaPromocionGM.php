<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

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

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPromocion.php');

$InsProducto = new ClsProducto();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPromocion = new ClsProductoListaPromocion();


$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProCodigoOriginal","ASC",NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL);
$ArrProductos = $ResProducto['Datos'];

if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
		
		echo "COD. ORIGINAL: ";
		echo $DatProducto->ProCodigoOriginal;
		echo "<br>";
		
		
		$Precio = 0;
		$PrecioReal = 0;
		$MonIdListaPromocion = NULL;
		$CalcularPrecio = 1;
		
		if(!empty($DatProducto->ProCodigoOriginal)){	
			
			$ResProductoListaPromocion = $InsProductoListaPromocion->MtdObtenerProductoListaPromociones("PloCodigo","esigual",$DatProducto->ProCodigoOriginal,'PloId','ASC',"1",1);
			$ArrProductoListaPromociones = $ResProductoListaPromocion['Datos'];
							
			if(!empty($ArrProductoListaPromociones)){
				foreach($ArrProductoListaPromociones as $DatProductoListaPromocion){
				
					$Precio = $DatProductoListaPromocion->PloPrecio;
					$PrecioReal = $DatProductoListaPromocion->PloPrecioReal;
					$MonIdListaPromocion = $DatProductoListaPromocion->MonId;
					$CalcularPrecio = 2;
						
				}
			}
		  
		  $InsProducto->MtdEditarProductoDato("ProListaPromocionCosto",$Precio,$DatProducto->ProId);							
		  $InsProducto->MtdEditarProductoDato("ProListaPromocionCostoReal",$PrecioReal,$DatProducto->ProId);							
		  $InsProducto->MtdEditarProductoDato("MonIdListaPromocion",$MonIdListaPromocion,$DatProducto->ProId);
		  //$InsProducto->MtdEditarProductoDato("ProCalcularPrecio",$CalcularPrecio,$DatProducto->ProId);
	
			echo "Precios procesados...";					
			echo "<br>";
		}
								
			
	
	}
}

echo "<hr>";
echo "PROCESO TERMINADO";
echo date("d/m/Y H:i:s");;

?>