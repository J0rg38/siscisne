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

require_once($InsProyecto->MtdRutClases().'ClsVehiculo.php');

$POST_Dato = $_POST['Dato'];
$POST_Campo = $_POST['Campo'];

//MtdObtenerVehiculos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VehId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oConductor=NULL,$oSocio=NULL,$oConductor2=NULL,$oConductor3=NULL)

$InsVehiculo = new ClsVehiculo();
$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos("Veh".$POST_Campo,$POST_Dato,'veh.VehId','ASC',NULL,NULL,NULL,NULL,NULL,NULL);
$ArrVehiculos = $ResVehiculo['Datos'];

$VehiculoId = "";

if(!empty($ArrVehiculos)){
	foreach($ArrVehiculos as $DatVehiculo){
		$VehiculoId  = $DatVehiculo->VehId;
	}
}

$InsVehiculo->VehId = $VehiculoId;
$InsVehiculo->MtdObtenerVehiculo();
$InsVehiculo->InsMysql = NULL;

$respuesta = json_encode($InsVehiculo);

echo $respuesta;
?>