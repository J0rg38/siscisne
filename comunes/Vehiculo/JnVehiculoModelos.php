<?php
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

$GET_VehiculoMarcaId = $_GET['VehiculoMarcaId'];
$GET_VehiculoModeloVigencia = $_GET['VehiculoModeloVigencia'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');

$InsVehiculoModelo = new ClsVehiculoModelo();
//MtdObtenerVehiculoModelos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVigenciaVenta=NULL)
$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoOrden,VmoNombre","ASC",NULL,$GET_VehiculoMarcaId,$GET_VehiculoModeloVigencia);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

$json = new JSON;
$var = $json->serialize( $ArrVehiculoModelos );
$json->unserialize( $var );

echo $var;
?>