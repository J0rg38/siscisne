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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoColor.php');

$InsVehiculoColor = new ClsVehiculoColor();

$GET_Marca = $_GET['Marca'];
$GET_Modelo = $_GET['Modelo'];
$GET_Version = $_GET['Version'];

//    public function MtdObtenerVehiculoColores($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoTipo=NULL) {
$RepVehiculoColor = $InsVehiculoColor->MtdObtenerVehiculoColores(NULL,NULL,"VcoNombre","ASC",NULL,$GET_Marca,$GET_Modelo,$GET_Version,NULL);
$ArrVehiculoColores = $RepVehiculoColor['Datos'];

$json = new JSON;
$var = $json->serialize( $ArrVehiculoColores );
$json->unserialize( $var );

echo $var;	
?>