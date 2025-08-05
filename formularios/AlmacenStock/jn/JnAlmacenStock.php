<?php
//header('Content-type: text/json');
//header('Content-type: application/json');

session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
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

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

$POST_ProductoId = $_POST['ProductoId'];
$POST_AlmacenId = $_POST['AlmacenId'];
$POST_SucursalId = (empty($_POST['SucursalId'])?$_SESSION['SesionSucursal']:$_POST['SucursalId']);
//$POST_Ano = (empty($_POST['Ano'])?date("Y"):$_POST['Ano']);
$POST_Ano = 1900;


$FechaInicio = "01/01/".$POST_Ano;
$FechaFin = date("d/m/Y");

$InsAlmacenStock = new ClsAlmacenStock();

$InsAlmacen = new ClsAlmacen();
$InsAlmacen->AlmId = $POST_AlmacenId;
$InsAlmacen->MtdObtenerAlmacen();

$Sucursal = "";

//if(empty($InsAlmacen->SucId)){
//	$Sucursal = $_SESSION['SesionSucursal'];
//}else{
//	$Sucursal = $InsAlmacen->SucId;
//}

$Sucursal = $POST_SucursalId;


//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno)
$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,NULL,NULL,1,"1",NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,NULL,NULL,$POST_ProductoId,NULL,$POST_AlmacenId,false,$Sucursal,$POST_Ano);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];

$InsAlmacenStock->ProId = $ArrAlmacenStocks[0]->ProId;
$InsAlmacenStock->AstStockReal = (empty($ArrAlmacenStocks[0]->AstStockReal)?0:$ArrAlmacenStocks[0]->AstStockReal);
$InsAlmacenStock->InsMysql=NULL;

//$json = new Services_JSON();
//echo $json->encode($InsCuenta);


$json = new JSON;
//$var = $json->serialize( $ArrCuentas );
$var = $json->serialize( $InsAlmacenStock );
$json->unserialize( $var );
echo $var;
	
?>