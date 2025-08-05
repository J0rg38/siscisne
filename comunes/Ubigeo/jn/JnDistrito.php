<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';


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

//$GET_UbigeoId = $_GET['UbigeoId'];
$GET_Distrito = $_GET['Distrito'];

require_once($InsPoo->MtdPaqLogistica().'ClsUbigeo.php');

$InsUbigeo = new ClsUbigeo();
//MtdObtenerUbigeoDepartamentos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'UbiId',$oSentido = 'Desc',$oPaginacion = '0,10') {
$RepUbigeo = $InsUbigeo->MtdObtenerUbigeoDistritos("UbiDistrito",$GET_Distrito,"UbiDistrito","ASC",'1',NULL);
$ArrUbigeos = $RepUbigeo['Datos'];

//deb($ArrUbigeos);
if(!empty($ArrUbigeos)){
	foreach($ArrUbigeos as $DatUbigeo){

		$InsUbigeo = new ClsUbigeo();
		$InsUbigeo->UbiId = $DatUbigeo->UbiId;
		$InsUbigeo->UbiDepartamento = $DatUbigeo->UbiDepartamento;
		$InsUbigeo->UbiProvincia = $DatUbigeo->UbiProvincia;
		$InsUbigeo->UbiDistrito = $DatUbigeo->UbiProvincia;
		$InsUbigeo->UbiCodigo = $DatUbigeo->UbiCodigo;

	}
}

$InsUbigeo->InsMysql = NULL;

echo json_encode($InsUbigeo);

exit();
$json = new JSON;
$var = $json->serialize( $InsUbigeo );
$json->unserialize( $var );

echo $var;
?>