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
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];

$InsFichaIngreso = new ClsFichaIngreso();

//2,3,4,5,6,7,71,72,73,8,9
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:	$Estado = "TALLER [Trabajo Terminado]";
case 74:	$Estado = "RECEPCION [Revisando]";

case 75:	$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:		$Estado = "TALLER [Por Facturar]";
case 9:		$Estado = "CONTABILIDAD [Facturado]";	
case 10:	$Estado = "RECEPCION [No Facturable]";	
*/	

//MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oCliente=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL,$oConConcluido=0)
$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","ASC","1",NULL,NULL,"1,11,2,3,4,5,5,6,7,71,72,7",NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,0,NULL,$POST_VehiculoIngresoId,0);
$ArrFichaIngresos = $ResFichaIngreso['Datos'];

$InsFichaIngreso->FinId = $ArrFichaIngresos[0]->FinId;
unset($ArrFichaIngresos);

$InsFichaIngreso->MtdObtenerFichaIngreso(false);
$InsFichaIngreso->InsMysql=NULL;

//$var = json_encode ($InsFichaIngreso);
//$json = new JSON;
//$var = $json->serialize( $InsFichaIngreso );
//$json->unserialize( $var );

$json = new Services_JSON();
$var = $json->encode($InsFichaIngreso);

echo $var;
?>