<?php
session_start();
//session_destroy();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}
////ARCHIVOS PRINCIPALES
require_once('../sistema/proyecto/ClsProyecto.php');
require_once('../sistema/proyecto/ClsPoo.php');


$InsProyecto->Ruta = '../sistema/';
$InsPoo->Ruta = '../sistema/';

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

require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');



require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');


//$InsFichaIngreso = new ClsFichaIngreso();
	

	

	
//$miURL = 'http://190.117.244.150/webservice';


$server = new soap_server();
$server->configureWSDL('Servidor', 'urn:Servidor');

$server->register('MtdConsultarOrdenTrabajoEstado',           // method name
	array('oFichaIngresoId' => 'xsd:string'), // input parameters
	//array('oFichaIngresoId' => 'xsd:string'), // input parameters
    array('return' => 'xsd:string'),          // output parameters
    'urn:MtdConsultarOrdenTrabajoEstadowsdl',             // namespace
    'urn:MtdConsultarOrdenTrabajoEstadowsdl#MtdConsultarOrdenTrabajoEstado',         // soapaction
    'rpc',                 // style
    'encoded',                // use
    'Retorna el datos'              // documentation
);


$server->register('MetodoPrueba',           // method name
    array('tcParametroA' => 'xsd:string','tcParametroB' => 'xsd:string'), // input parameters
    array('return' => 'xsd:string'),          // output parameters
    'urn:MetodoPruebawsdl',             // namespace
    'urn:MetodoPruebawsdl#MetodoPrueba',         // soapaction
    'rpc',                 // style
    'encoded',                // use
    'Retorna el datos'              // documentation
);



function MtdConsultarOrdenTrabajoEstado($oFichaIngresoId) {

	
	global $InsFichaIngreso;
	
	$FichaIngresoEstado = "0";
	
	$InsFichaIngreso = new ClsFichaIngreso();
	
	
	//MtdObtenerFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL)
	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("fin.FinId","contiene",$oFichaIngresoId,"FinFecha","DESC","1",NULL,NULL,NULL,NULL,NULL);
	$ArrFichaIngresos = $ResFichaIngreso['Datos'];	
	
	if(!empty($ArrFichaIngresos)){
		foreach($ArrFichaIngresos as $DatFichaIngreso){
			
			$FichaIngresoEstado = $DatFichaIngreso->FinEstado;
			
		}
	}
	
	return $FichaIngresoEstado;

}

MtdConsultarOrdenTrabajoEstado("320");
function MetodoPrueba($tcParametroA,$tcParametroB) {
	return "SERVIDOR=".$_SERVER['PHP_SELF']."\n"."tcParametroA=".strtoupper($tcParametroA)."\n"."tcParametroB=".strtoupper($tcParametroB);
}


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>