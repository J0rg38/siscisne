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




require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

$InsReporteProducto = new ClsReporteProducto();
$InsReporteAlmacenMovimientoEntrada = new ClsReporteAlmacenMovimientoEntrada();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProducto = new ClsProducto();

//MtdObtenerReporteAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmoFecha',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oConStock=NULL,$oClienteClasificacion=NULL) 
//$ResReporteAlmacenMovimientoEntrada = $InsReporteAlmacenMovimientoEntrada->MtdObtenerReporteAlmacenMovimientoEntradas(NULL,NULL,NULL ,"pro.ProCodigoOriginal","ASC",NULL,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,NULL);
//$ArrReporteAlmacenMovimientoEntradas = $ResReporteAlmacenMovimientoEntrada['Datos'];

//MtdObtenerReporteProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL) {
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductos(NULL,NULL,NULL,'ProId','Desc',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL);
$ArrReporteProductos = $ResReporteProducto['Datos'];

if(!empty($ArrReporteProductos)){
	foreach($ArrReporteProductos as $DatReporteProducto){
		
		echo "ProCodigoOriginal: ";
		echo $DatReporteProducto->ProCodigoOriginal;
		echo "<br>";
		
		echo "ProNombre: ";
		echo $DatReporteProducto->ProNombre;
		echo "<br>";
		
		echo "RprFechaUltimaSalida: ";
		echo $DatReporteProducto->RprFechaUltimaSalida;
		echo "<br>";
		
			echo "RprUltimaSalidaDiaTranscurridos: ";
		echo $DatReporteProducto->RprUltimaSalidaDiaTranscurridos;
		echo "<br>";
		
		
		
		
//		if($InsProducto->MtdEditarProductoDato("ProDiasInmovilizado",$DatReporteProducto->RprUltimaSalidaDiaTranscurridos,$DatReporteProducto->ProId)){
//			echo " Se actualizo dias inmovilizadoss correctamente.";
//			echo "<br>";
//		}else{
//			echo " No se pudieron actualizar los dias inmovilizadoss. PROCESO CANCELADO";
//			echo "<br>";
//		}
		
		if($InsProducto->MtdEditarProductoDato("ProFechaUltimaSalida",FncCambiaFechaAMysql($DatReporteProducto->RprFechaUltimaSalida,true),$DatReporteProducto->ProId)){
			echo " Se actualizo fecha ultimo movimiento correctamente.";
			echo "<br>";
		}else{
			echo " No se pudieron actualizar fecha de ultimo movimiento. PROCESO CANCELADO";
			echo "<br>";
		}
		
		echo "<br>";
		
	}
}

echo "<hr>";

echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");
?>
