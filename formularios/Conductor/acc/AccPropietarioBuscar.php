<?php
session_start();	
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

require_once('../../../proyecto/ClsProyecto.php');

$InsProyecto->Ruta = "../../../";

/*
*Configuraciones
*/
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
/*
*Mensajes
*/
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
/*
*Clases Generales
*/
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
/*
*Clases de Conexion
*/
require_once($InsProyecto->MtdRutClases().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

require_once($InsProyecto->MtdRutClases().'ClsPropietario.php');

$POST_Dato = $_POST['Dato'];
$POST_Campo = $_POST['Campo'];

//MtdObtenerPropietarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {


$InsPropietario = new ClsPropietario();
$ResPropietario = $InsPropietario->MtdObtenerPropietarios("Pro".$POST_Campo,"contiene",$POST_Dato,'ProId',$oSentido = 'ASC',NULL,NULL);
$ArrPropietarios = $ResPropietario['Datos'];

$PropietarioId = "";

if(!empty($ArrPropietarios)){
	foreach($ArrPropietarios as $DatPropietario){
		$PropietarioId  = $DatPropietario->ProId;
	}
}

$InsPropietario->ProId = $PropietarioId;
$InsPropietario->MtdObtenerPropietario();
$InsPropietario->InsMysql = NULL;

$respuesta = json_encode($InsPropietario);

echo $respuesta;
?>