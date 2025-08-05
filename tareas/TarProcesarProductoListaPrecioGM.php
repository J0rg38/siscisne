<?php
session_start();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

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

$GET_LimiteInicio = $_GET['LimiteInicio'];
$GET_LimiteFin = $_GET['LimiteFin'];
$Limite = "";

if(!empty($GET_LimiteInicio) and !empty($GET_LimiteFin)){

	$Limite = $GET_LimiteInicio.",".$GET_LimiteFin;
	
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');

$InsProducto = new ClsProducto();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();


//public function MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false)
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProCodigoOriginal","ASC",$Limite,"1",NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL,false,NULL,NULL,true);
$ArrProductos = $ResProducto['Datos'];

if(!empty($ArrProductos)){
	foreach($ArrProductos as $DatProducto){
		
		echo "<b>ProId:</b> ".$DatProducto->ProId;
		echo "<br>";
		echo "<b>ProCodigoOriginal:</b> ".$DatProducto->ProCodigoOriginal;
		echo "<br>";
		echo "<b>ProNombre:</b> ".$DatProducto->ProNombre;
		echo "<br>";
		
		$Precio = 0;
		$PrecioReal = 0;
		$MonIdListaPrecio = "";
		
		if(!empty($DatProducto->ProCodigoOriginal)){	
			
			if($DatProducto->ProCalcularPrecio==1){
				
				$Codigo = $DatProducto->ProCodigoOriginal;
				$Codigo = str_replace("R","",$Codigo);
				$Codigo = str_replace("A","",$Codigo);
				$Codigo = str_replace("-","",$Codigo);
				$Codigo = str_replace(" ","",$Codigo);
				
				$InsProductoListaPrecio = new ClsProductoListaPrecio();
				$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$Codigo,'PlpTiempoCreacion','DESC',"1",1);
				$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
								
				if(!empty($ArrProductoListaPrecios)){
					foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
					
						$Precio = $DatProductoListaPrecio->PlpPrecio;
						$PrecioReal = $DatProductoListaPrecio->PlpPrecioReal;
						$MonIdListaPrecio = $DatProductoListaPrecio->MonId;
					
					}
				}
				
				if( $PrecioReal>0 ){

					$InsProducto->MtdEditarProductoDato("ProCosto",$Precio,$DatProducto->ProId);	
					$InsProducto->MtdEditarProductoDato("ProListaPrecioCosto",$Precio,$DatProducto->ProId);							
					$InsProducto->MtdEditarProductoDato("ProListaPrecioCostoReal",$PrecioReal,$DatProducto->ProId);							
					$InsProducto->MtdEditarProductoDato("MonIdListaPrecio",$MonIdListaPrecio,$DatProducto->ProId);

					echo "Producto procesado correctamente";
					echo "<br>";
	
				}else{
					
					echo "No se encontro precio en lista";
					echo "<br>";
	
					
				}
			  
			
			}else{
				
				echo "El producto no permite calcular el precio automaticamente";	
				echo "<br>";
				
			}
			
		}else{
			echo "No se encontro codigo original.";					
			echo "<br>";
		}	
		
		echo "<b>Precio:</b> ".$Precio;
		echo "<br>";
		
		echo "<b>PrecioReal:</b> ".$PrecioReal;
		echo "<br>";
		
		echo "<b>MonIdListaPrecio:</b> ".$MonIdListaPrecio;
		echo "<br>";
		
		echo "<br>";
		
	}
}else{
	echo "No se encontraron productos a procesar.";					
	echo "<br>";
}

echo "<hr>";
echo "PROCESO TERMINADO";
echo date("d/m/Y H:i:s");;

?>