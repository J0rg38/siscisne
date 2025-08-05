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



$GET_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];
//$POST_FechaInicio = $_GET['FechaInicio'];
$POST_FechaFin= (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

$POST_Sucursal = $_GET['Sucursal'];
$POST_ProductoId = $_GET['ProductoId'];

require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimientoEntrada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsKardex = new ClsKardex();
$InsProducto = new ClsProducto();
$InsSucursal = new ClsSucursal();
$InsReporteAlmacenMovimientoEntrada = new ClsReporteAlmacenmovimientoEntrada();

//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false,$oReemplazo=NULL) {
$ResProducto = $InsProducto->MtdObtenerProductos("ProId","esigual",$POST_ProductoId,"ProNombre","ASC","500",1,$POST_ProductoTipo,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL,false,NULL,NULL,false);
$ArrProductos = $ResProducto['Datos'];

//$aux = explode("/",$POST_FechaInicio);
//$KardexFechaInicio = "01/01/".$aux[2];

$InsSucursal->SucId = $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();

$InventarioFechaInicio = (empty($InsSucursal->SucInventarioFechaInicio)?$SistemaInventarioFecha:$InsSucursal->SucInventarioFechaInicio);



if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){

		echo "ProId: ".$DatProducto->ProId;
		echo "<br>";
				
		echo "ProCodigoOriginal: ".$DatProducto->ProCodigoOriginal;
		echo "<br>";
		
		echo "ProNombre: ".$DatProducto->ProNombre;
		echo "<br>";


		$ResReporteAlmacenMovimientoEntrada = $InsReporteAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',1,'500',NULL,3,$DatProducto->ProId,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,0,NULL,NULL,NULL,NULL);
		$ArrReporteAlmacenMovimientoEntradas = $ResReporteAlmacenMovimientoEntrada['Datos'];
		
		$CostoPromedio = 0;
		$CostoTotal = 0;
		$Registros = 0;
		$HistorialCostos = "";
		
		if(!empty($ArrReporteAlmacenMovimientoEntradas)){
			foreach($ArrReporteAlmacenMovimientoEntradas as $DatReporteAlmacenMovimientoEntrada){
				
				$CostoTotal += $DatReporteAlmacenMovimientoEntrada->AmdCosto;
				$HistorialCostos .= " - (".$DatReporteAlmacenMovimientoEntrada->AmoFecha.") ".number_format($DatReporteAlmacenMovimientoEntrada->AmdCosto,2);
						
				$Registros++;
			}
		}
		
		if($Registros>0){
			$CostoPromedio = $CostoTotal / $Registros;
		}else{
			$CostoPromedio = 0;
		}
		
		echo "Historial de Costos: ".$HistorialCostos;
		echo "<br>";
		
		echo "CostoPromedio: ".$CostoPromedio;
		echo "<br>";
		echo "<br>";
		
	}

		
}


echo "<hr>";

echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");
?>