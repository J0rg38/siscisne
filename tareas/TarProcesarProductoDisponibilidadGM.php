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
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');

$InsProducto = new ClsProducto();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();


$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProCodigoOriginal","ASC",NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL);
$ArrProductos = $ResProducto['Datos'];

if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
		
		echo "COD. ORIGINAL: ";
		echo $DatProducto->ProCodigoOriginal;
		echo "<br>";
		
		
		
		
		
		$Disponibilidad = "";	
		
		if(!empty($DatProducto->ProCodigoOriginal)){
		
			$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatProducto->ProCodigoOriginal ,"PdiId","ASC","1",1);
			$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
			
			//$Disponibilidad = "";
			$Disponibilidad = "NO";
			$Cantidad = 0;
			
			if(!empty($ArrProductoDisponibilidades)){
				foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					
					$Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
					$Cantidad =  (empty($DatProductoDisponibilidad->PdiCantidad))?0:$DatProductoDisponibilidad->PdiCantidad;
					
				}
			}
			
			$InsProducto->MtdEditarProductoDato("ProTieneDisponibilidadGM",$Disponibilidad,$DatProducto->ProId);
			$InsProducto->MtdEditarProductoDato("ProDisponibilidadCantidadGM",$Cantidad,$DatProducto->ProId);
				
			echo "Disponibilidad procesada...";					
			echo "<br>";
			
									
		}
		
	
	}
}

echo "<hr>";
echo "PROCESO TERMINADO";
echo date("d/m/Y H:i:s");;

?>