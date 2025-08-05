<?php
session_start();
	
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

////ARCHIVOS PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

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





$POST_FichaIngresoId = $_GET['FichaIngresoId'];
$POST_FechaInicio = $_GET['FechaInicio'];
$POST_FechaFin = $_GET['FechaFin'];

require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');

require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');


//		  
//$InsEncuesta = new ClsEncuesta();
////MtdObtenerEncuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EncId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTipo=NULL,$oSucursal=NULL,$oFichaIngreso=NULL,$oOrdenVentaVehiculo=NULL,$oTipoFecha="EncFecha") 
//$ResEncuesta = $InsEncuesta->MtdObtenerEncuestas(NULL,NULL,NULL,"EncFecha","DESC","1",NULL,($POST_FechaInicio),NULL,"POSTVENTA",NULL,$POST_FichaIngresoId,NULL,"EncFecha");
//$ArrEncuestas = $ResEncuesta['Datos'];


$InsEncuesta = new ClsEncuesta();
////MtdObtenerEncuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EncId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTipo=NULL,$oSucursal=NULL,$oFichaIngreso=NULL)
$ResEncuesta = $InsEncuesta->MtdObtenerEncuestas(NULL,NULL,NULL,"EncFecha","DESC","1",NULL,($POST_FechaInicio),NULL,"POSTVENTA",NULL,$POST_FichaIngresoId,NULL,"EncFecha");
$ArrEncuestas = $ResEncuesta['Datos'];

echo count($ArrEncuestas);
?>