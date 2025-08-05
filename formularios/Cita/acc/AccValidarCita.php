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

$POST_FechaProgramada = $_POST['FechaProgramada'];
$POST_HoraProgramada = $_POST['HoraProgramada'];
$POST_PersonalMecanico = $_POST['PersonalMecanico'];
$POST_Sucursal = $_POST['Sucursal'];


require_once($InsPoo->MtdPaqActividad().'ClsCita.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

//$InsSucursal = new ClsSucursal();
//$InsSucursal->SucId = $POST_Sucursal;
//$InsSucursal->MtdObtenerSucursal();
$SucursalId = $POST_Sucursal;

require_once($InsPoo->MtdPaqActividadConf().'CnfCita.php');

$InsCita = new ClsCita();
$RespuestaValidacion = $InsCita->MtdValidarCita(FncCambiaFechaAMysql($POST_FechaProgramada),$POST_HoraProgramada.":00",$POST_Sucursal);

if($RespuestaValidacion['respuesta']){
	$RespuestaValidacion['respuesta'] = 1;
}else{
	$RespuestaValidacion['respuesta'] = 2;	
}

//MtdObtenerCitas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oPersonalMecanico=NULL,$oHora=NULL) {
//$ResCita = $InsCita->MtdObtenerCitas($POST_cam,"contiene",$POST_fil,"CitTiempoCreacion","DESC","1",NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaProgramada),(FncCambiaFechaAMysql($POST_FechaProgramada)),"CitFecha",false,NULL,$POST_PersonalMecanico,$POST_HoraProgramada);
//$ArrCitas = $ResCita['Datos'];
//
//$InsCita->CitId = $ArrCitas[0]->CitId;
//unset($ArrFichaIngresos);
//
//$InsCita->MtdObtenerCita(false);
//$InsCita->InsMysql=NULL;

//$var = json_encode ($InsFichaIngreso);
//$json = new JSON;
//$var = $json->serialize( $InsFichaIngreso );
//$json->unserialize( $var );

//$json = new Services_JSON();
//$var = $json->encode($InsCita);
//
//echo $var;
$json = new Services_JSON();
$var = $json->encode($RespuestaValidacion);

echo $var;
?>