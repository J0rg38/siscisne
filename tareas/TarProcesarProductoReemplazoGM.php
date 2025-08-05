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
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');

$InsProducto = new ClsProducto();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();


$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProCodigoOriginal","ASC",NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL);
$ArrProductos = $ResProducto['Datos'];

if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
		
		echo "COD. ORIGINAL: ";
		echo $DatProducto->ProCodigoOriginal;
		echo "<br>";
		

		$Reemplazo = "";
		
		if(!empty($DatProducto->ProCodigoOriginal)){
		
			$Reemplazo = "NO";
			$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1","esigual",$DatProducto->ProCodigoOriginal ,"PreId","ASC",NULL,1);
			$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
			
			if(!empty($ArrProductoReemplazos)){
				$Reemplazo= "SI";
			}
			
			//$InsProducto->MtdEditarProductoDato("ProTieneReemplazoGM",$Reemplazo,$DatProducto->ProId);
			
			
			if(!empty($ArrProductoReemplazos)){
				foreach($ArrProductoReemplazos as $DatProductoReemplazo){
					
					if(!empty($DatProductoReemplazo->PreCodigo1)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo1;
						$InsProductoCodigoReemplazo->PcrOrden = 1;
						$InsProductoCodigoReemplazo->PcrBase = 1;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","B",$DatProducto->ProId);
						
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo2)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo2;
						$InsProductoCodigoReemplazo->PcrOrden = 2;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
					}
					
						if(!empty($DatProductoReemplazo->PreCodigo3)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo3;
						$InsProductoCodigoReemplazo->PcrOrden = 3;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
					}
					
					
						if(!empty($DatProductoReemplazo->PreCodigo4)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo4;
							$InsProductoCodigoReemplazo->PcrOrden = 4;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
						
					}
					
					
					
					if(!empty($DatProductoReemplazo->PreCodigo5)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo5;
						$InsProductoCodigoReemplazo->PcrOrden = 5;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
						
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo6)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo6;
						$InsProductoCodigoReemplazo->PcrOrden = 6;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
						
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo7)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo7;
						$InsProductoCodigoReemplazo->PcrOrden = 7;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
						
					}
					
						
					if(!empty($DatProductoReemplazo->PreCodigo8)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo8;
						$InsProductoCodigoReemplazo->PcrOrden = 8;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
						
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo9)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo9;
						$InsProductoCodigoReemplazo->PcrOrden = 9;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
						
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo10)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo10;
						$InsProductoCodigoReemplazo->PcrOrden = 10;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo11)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo11;
						$InsProductoCodigoReemplazo->PcrOrden = 11;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
						
					}
					
					
					if(!empty($DatProductoReemplazo->PreCodigo12)){
						
							
						$InsProductoCodigoReemplazo = new ClsProductoCodigoReemplazo();
						$InsProductoCodigoReemplazo->PcrId = NULL;
						$InsProductoCodigoReemplazo->ProId = $DatProducto->ProId;
						$InsProductoCodigoReemplazo->PcrNumero = $DatProductoReemplazo->PreCodigo12;
						$InsProductoCodigoReemplazo->PcrOrden = 12;
						$InsProductoCodigoReemplazo->PcrBase = 2;
						
						$InsProductoCodigoReemplazo->PcrTiempoCreacion = date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrTiempoModificacion =  date("Y-m-d H:i:s");
						$InsProductoCodigoReemplazo->PcrEliminado = 1;
						
						$InsProductoCodigoReemplazo->MtdRegistrarProductoCodigoReemplazo();
						
						$InsProducto->MtdEditarProductoDato("ProReemplazo","R",$DatProducto->ProId);
						
						
					}
					
					
					

				}
			}
			
			
			echo "Reemplazos procesados...";					
			echo "<br>";
		
		}
								
			
	
	}
}

echo "<hr>";
echo "PROCESO TERMINADO";
echo date("d/m/Y H:i:s");;

?>