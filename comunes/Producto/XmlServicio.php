<?php
session_start();
//header("Content-type: text/plain");
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');


$InsProducto = new ClsProducto();
$InsAlmacenStock = new ClsAlmacenStock();
$InsAlmacen = new ClsAlmacen();

$GET_Cbu = FncLimpiarVariable($_GET['Cbu']);
$GET_MarcaId = FncLimpiarVariable($_GET['MarcaId']);
$GET_ModeloId = FncLimpiarVariable($_GET['ModeloId']);
$GET_VersionId = FncLimpiarVariable($_GET['VersionId']);
$GET_AnoFabricacion = FncLimpiarVariable($_GET['AnoFabricacion']);
$GET_ProductoTipoId = FncLimpiarVariable($_GET['ProductoTipoId']);
$GET_Estricto = ($_GET['Estricto']);

$q = strtolower($_GET["q"]);
$t = empty($_GET['t'])?1:$_GET['t'];
if (!$q) return;

$Estricto = false;

if($GET_Estricto =="1"){
	$Estricto = true;
}

//public function MtdObtenerProductos($oCampo=NULL,$MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false) {
$ResProducto = $InsProducto->MtdObtenerProductos($GET_Cbu,"contiene",($q),$GET_Cbu,"ASC","15",1,$GET_ProductoTipoId,NULL,$GET_MarcaId,$GET_ModeloId,$GET_VersionId,$GET_AnoFabricacion,false,NULL,NULL,0,NULL,$Estricto);
$ArrProductos = $ResProducto['Datos'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];
	

	if(empty($ArrProductos)){
		
	}else{
		
		if($t==1){
			echo "<b><center>CODIGO</center></b>|".
			"<b><center>NOMBRE</center></b>|".
			"<b><center>U.M.</center></b>|".
			"<b><center>PRECIO</center></b>|".
			"<b><center>STOCK</center></b>|".
			"-|".
			"-|".
			
			"<b><center>COD. ALT.</center></b>|".
			"<b><center>COD. ORIG.</center></b>|".
			
			"<b><center>POR LLEGAR</center></b>|".
			"<b><center>ULTIMO PEDIDO</center></b>|".
			"<b><center>LLEGADA ESTIM.</center></b>|".
			"<b><center>TIPO PED.</center></b>|".
			"<b><center>ULTIMA SALIDA</center></b>|".
			"<b><center>INMOVILIZADO</center></b>|".
			"<b><center>INMOVILIZADO</center></b>|".
			"<b><center>REF</center></b>\n";	
		}

//ABRAZ-8 

//$DatProducto->UmeNombre." [".$DatProducto->UmeAbreviacion."]|".

		foreach($ArrProductos as $DatProducto){			
			
					
			 $Stock = 0;
			if(!empty($ArrAlmacenes)){
				foreach($ArrAlmacenes as $DatAlmacen){
		
				 $InsAlmacenStock = new ClsAlmacenStock();
				//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false)
				 $ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,"ProId","ASC",NULL,"1",NULL,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,NULL,$DatProducto->ProId,NULL,$DatAlmacen->AlmId,false);
				$ArrAlmacenStocks = $ResAlmacenStock['Datos'];
		
					 if(!empty($ArrAlmacenStocks)){
						 foreach($ArrAlmacenStocks as $DatAlmacenStock){
							 $Stock += $DatAlmacenStock->AstStockReal;
						 }
					 }
				 
				}				
			}
			
			//function MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL) 
			$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,"ProId","DESC",1,"1",NULL,date("Y-m-d"),NULL,NULL,NULL,NULL,$DatProducto->ProId);
			$ArrAlmacenStocks = $ResAlmacenStock['Datos'];
			
			$AstPedidoPorLLegar = "";
			$AstPedidoUltimaFecha = "";
			$AstPedidoLlegadaEstimada = "";
			$AstPedidoTipo = "";
			//$AstStockReal = 0;
			
			if(!empty($ArrAlmacenStocks)){
				foreach($ArrAlmacenStocks as $DatAlmacenStock){
					
					$AstPedidoPorLLegar = $DatAlmacenStock->AstPedidoPorLLegar;
					$AstPedidoUltimaFecha = $DatAlmacenStock->AstPedidoUltimaFecha;
					$AstPedidoLlegadaEstimada = $DatAlmacenStock->AstPedidoLlegadaEstimada;
					$AstPedidoTipo = $DatAlmacenStock->AstPedidoTipo;
					//$AstStockReal = $DatAlmacenStock->AstStockReal;
					
				}
			}
			
			$referencia = substr($DatProducto->ProReferencia,0,25)."...";
	
			echo $DatProducto->ProId."|".
			$DatProducto->ProNombre."|".
			$DatProducto->UmeAbreviacion."|".
			$DatProducto->ProPrecio."|".
			number_format($Stock ,2)."|".
			$DatProducto->UmeId."|".
			$DatProducto->RtiId."|".
			
			$DatProducto->ProCodigoAlternativo."|".
			$DatProducto->ProCodigoOriginal."|".
			
			number_format($AstPedidoPorLLegar,2)."|".
			$AstPedidoUltimaFecha."|".
			$AstPedidoLlegadaEstimada."|".
			
			$AstPedidoTipo."|".
			$DatProducto->ProFechaUltimaSalida."|".
			$DatProducto->ProDiasInmovilizado."|".
			$DatProducto->ProPromedioMensual."|".
			$referencia."\n"	;				
			
		}
		
	}
	

?>