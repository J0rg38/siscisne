<?php
//header('Content-type: text/json');
//header('Content-type: application/json');

session_start();
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

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');

$GET_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();

//MtdObtenerProductoDisponibilidades($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oDisponible=NULL)
$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$GET_ProductoCodigoOriginal, 'PdiId','ASC',"1",1);
$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
				  
$InsProductoDisponibilidad->PdiId = $ArrProductoDisponibilidades[0]->PdiId;
unset($ArrProductoDisponibilidades);
$InsProductoDisponibilidad->MtdObtenerProductoDisponibilidad();

$InsProductoDisponibilidad->InsMysql = NULL;
//$json = new Services_JSON();
//echo $json->encode($InsProductoDisponibilidad);

$json = new JSON;
//$var = $json->serialize( $ArrProductoDisponibilidades );
$var = $json->serialize( $InsProductoDisponibilidad );
$json->unserialize( $var );
echo $var;
	
?>