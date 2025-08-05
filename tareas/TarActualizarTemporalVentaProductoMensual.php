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

require_once($InsPoo->MtdPaqContabilidad().'ClsVentaProductoMensual.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteProductoVenta.php');

$GET_Ano = (empty($_GET['Ano'])?date("Y"):$_GET['Ano']);
$GET_Mes = (empty($_GET['Mes'])?date("Y"):$_GET['Mes']);
$GET_Sucursal = (empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal']);
$GET_Limite = (empty($_GET['Limite'])?"1,1000":$_GET['Limite']);


$InsVentaProductoMensual = new ClsVentaProductoMensual();
$InsProducto = new ClsProducto();

//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProNombre","ASC",$GET_Limite,1,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL,false,NULL,NULL);
$ArrProductos = $ResProducto['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$GET_Sucursal,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

		
	$c=1;
	if(!empty($ArrProductos)){
		foreach($ArrProductos as $DatProducto){
			
			if(!empty($ArrSucursales)){
				foreach($ArrSucursales as $DatSucursal){
					
					
					$InsReporteProductoVenta = new ClsReporteProductoVenta();//MtdObtenerReporteProductoVentaValor($oFuncion="SUM",$oParametro="AmdId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
					$TotalProductoVentaMensual = $InsReporteProductoVenta->MtdObtenerReporteProductoVentaValor("SUM","AmdCantidad",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'AmdId','Desc','1',$DatSucursal->SucId,NULL,NULL);
				
					
					$InsVentaProductoMensual = new ClsVentaProductoMensual();
					//MtdObtenerVentaProductoMensuales($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VpmId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oSucursal=NULL)
					$ResVentaProductoMensual = $InsVentaProductoMensual->MtdObtenerVentaProductoMensuales(NULL,NULL,'VpmId','Desc','1',$GET_Ano,$GET_Mes,$DatSucursal->SucId);
					$ArrVentaProductoMensual = $ResVentaProductoMensual['Datos'];
					
					$VentaProductoMensualId = "";
					
					if(!empty($ArrVentaProductoMensual)){
						foreach($ArrVentaProductoMensual as $DatVentaProductoMensual){
							
							$VentaProductoMensualId = $DatVentaProductoMensual->VpmId;		
							
						}
					}
					
					if(empty($VentaProductoMensualId)){
						
						$InsVentaProductoMensual = new ClsVentaProductoMensual();
						$InsVentaProductoMensual->SucId = $DatSucursal->SucId;
						$InsVentaProductoMensual->ProId = $DatProducto->ProId;
						$InsVentaProductoMensual->VpmAno = $GET_Ano;
						$InsVentaProductoMensual->VpmMes = $GET_Mes;
						$InsVentaProductoMensual->VpmCantidad = $TotalProductoVentaMensual;	
						$InsVentaProductoMensual->VpmTiempoCreacion = date("Y-m-d H:i:s");
						$InsVentaProductoMensual->VpmTiempoModificacion = date("Y-m-d H:i:s");
					
						$InsVentaProductoMensual->MtdRegistrarVentaProductoMensual();
						
					}else{
						
						$InsVentaProductoMensual = new ClsVentaProductoMensual();
						$InsVentaProductoMensual->VpmId = $VentaProductoMensualId;
						$InsVentaProductoMensual->SucId = $DatSucursal->SucId;
						$InsVentaProductoMensual->ProId = $DatProducto->ProId;
						$InsVentaProductoMensual->VpmAno = $GET_Ano;
						$InsVentaProductoMensual->VpmMes = $GET_Mes;
						$InsVentaProductoMensual->VpmCantidad = $TotalProductoVentaMensual;	
						$InsVentaProductoMensual->VpmTiempoCreacion = date("Y-m-d H:i:s");
						$InsVentaProductoMensual->VpmTiempoModificacion = date("Y-m-d H:i:s");
					
						$InsVentaProductoMensual->MtdEditarVentaProductoMensual();
						
					}
					
					
				}
			}
			
			
			
	
	
		}
	}
				



?>