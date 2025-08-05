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


$GET_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];

require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

$InsReporteProducto = new ClsReporteProducto();
$InsProducto = new ClsProducto();

//MtdObtenerReporteProductoVentasPromedio($oProductoId,$oFecha=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oVehiculoMarca=NULL,$oDiasAtras=365)
//$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoVentasPromedio(NULL,NULL,"RprPromedioMensual","ASC",NULL,NULL,365);
//$ArrReporteProductos = $ResReporteProducto['Datos'];


//MtdObtenerReporteProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL) {
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductos("ProCodigoOriginal","esigual",$GET_ProductoCodigoOriginal,"ProNombre","ASC",NULL,NULL,NULL);
$ArrReporteProductos = $ResReporteProducto['Datos'];

$TotalVentas = 0;

if(!empty($ArrReporteProductos)){
	foreach($ArrReporteProductos as $DatReporteProducto){
		
		$TotalVentas += $DatReporteProducto->ProSalidaTotalAnualMonto;

	}
}



if(!empty($ArrReporteProductos)){
	foreach($ArrReporteProductos as $DatReporteProducto){
		
		echo "ProCodigoOriginal: ".$DatReporteProducto->ProCodigoOriginal;
		echo "<br>";
		
		echo "RprPromedioSemestral: ".$DatReporteProducto->RprPromedioSemestral;
		echo "<br>";
		
		echo "RprPromedioTrimestral: ".$DatReporteProducto->RprPromedioTrimestral;
		echo "<br>";
		
		echo "RprPromedioAnual: ".$DatReporteProducto->RprPromedioAnual;
		echo "<br>";
		
		
		echo "ProSalidaTotalAnual: ".$DatReporteProducto->ProSalidaTotalAnual;
		echo "<br>";
			
		echo "ProSalidaTotalSemestral: ".$DatReporteProducto->ProSalidaTotalSemestral;
		echo "<br>";
		
		echo "ProSalidaTotalTrimestral: ".$DatReporteProducto->ProSalidaTotalTrimestral;
		echo "<br>";
		
		echo "ProSalidaTotalMensual: ".$DatReporteProducto->ProSalidaTotalMensual;
		echo "<br>";
		
		echo "ProSalidaTotalAnualMonto: ".$DatReporteProducto->ProSalidaTotalAnualMonto;
		echo "<br>";
		echo "<br>";
		
	
		if($InsProducto->MtdEditarProductoDato("ProPromedioSemestral",$DatReporteProducto->RprPromedioSemestral,$DatReporteProducto->ProId)){
			echo " Se actualizo promedio semestral correctamente.";
			echo "<br>";
		}else{
			echo " No se pudieron actualizar el promedio semestral. PROCESO CANCELADO";
			echo "<br>";
		}
		
		
		if($InsProducto->MtdEditarProductoDato("ProPromedioTrimestral",$DatReporteProducto->RprPromedioTrimestral,$DatReporteProducto->ProId)){
			echo " Se actualizo promedio trimestral correctamente.";
			echo "<br>";
		}else{
			echo " No se pudieron actualizar el promedio trimestral. PROCESO CANCELADO";
			echo "<br>";
		}
		
		if($InsProducto->MtdEditarProductoDato("ProPromedioMensual",$DatReporteProducto->RprPromedioMensual,$DatReporteProducto->ProId)){
			echo " Se actualizo promedio mrnsual correctamente.";
			echo "<br>";
		}else{
			echo " No se pudieron actualizar el promedio mensual. PROCESO CANCELADO";
			echo "<br>";
		}	
		
		if($InsProducto->MtdEditarProductoDato("ProPromedioDiario",$DatReporteProducto->RprPromedioDiario,$DatReporteProducto->ProId)){
			echo " Se actualizo promedio diario correctamente.";
			echo "<br>";
		}else{
			echo " No se pudieron actualizar el promedio diario. PROCESO CANCELADO";
			echo "<br>";
		}	
		
		
		
		$InsProducto->MtdEditarProductoDato("ProSalidaTotalAnual",$DatReporteProducto->ProSalidaTotalAnual,$DatReporteProducto->ProId);
		$InsProducto->MtdEditarProductoDato("ProSalidaTotalSemestral",$DatReporteProducto->ProSalidaTotalSemestral,$DatReporteProducto->ProId);
		$InsProducto->MtdEditarProductoDato("ProSalidaTotalTrimestral",$DatReporteProducto->ProSalidaTotalTrimestral,$DatReporteProducto->ProId);
		$InsProducto->MtdEditarProductoDato("ProSalidaTotalMensual",$DatReporteProducto->ProSalidaTotalMensual,$DatReporteProducto->ProId);
		
//		if($InsProducto->MtdEditarProductoDato("ProPromedioMensual",$DatReporteProducto->RprPromedioMensual,$DatReporteProducto->ProId)){
//			echo " Se actualizo promedio mensuak correctamente.";
//			echo "<br>";
//		}else{
//			echo " No se pudieron actualizar el promedio mensual. PROCESO CANCELADO";
//			echo "<br>";
//		}
//		
//		if($InsProducto->MtdEditarProductoDato("ProPromedioDiario",$DatReporteProducto->RprPromedioDiario,$DatReporteProducto->ProId)){
//			echo " Se actualizo promedio diario correctamente.";
//			echo "<br>";
//		}else{
//			echo " No se pudieron actualizar el promedio diario. PROCESO CANCELADO";
//			echo "<br>";
//		}
		
		echo "<br>";
		
	}
}

echo "<hr>";

echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");
?>