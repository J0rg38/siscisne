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

$GET_ProId = $_GET['ProId'];


require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');


$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();

$InsProducto = new ClsProducto();
$InsProducto->ProId = $GET_ProId;
$InsProducto->MtdObtenerProducto(FALSE);


echo "<b>ProId:</b> ".$InsProducto->ProId;
echo "<br>";
echo "<b>ProCodigoOriginal:</b> ".$InsProducto->ProCodigoOriginal;
echo "<br>";
echo "<b>ProNombre:</b> ".$InsProducto->ProNombre;
echo "<br>";	
	
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
				
				echo "El producto fue procesado correctamente ";	
				echo "<br>";
			
			}else{
				echo "No se encuentra el producto en la lista de precios";	
				echo "<br>";
			}
			
		}else{
			echo "El producto no permite calcular el precio automaticamente";	
			echo "<br>";
		}
	
	}else{
		echo "No se encontro codigo original para calcular precio";	
		echo "<br>";
	}
								
			
	

echo "<hr>";
echo "PROCESO TERMINADO";
echo date("d/m/Y H:i:s");;

?>