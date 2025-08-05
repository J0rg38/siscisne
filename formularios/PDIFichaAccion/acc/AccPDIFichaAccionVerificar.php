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

//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsFichaIngreso = new ClsFichaIngreso();

$InsACL = new ClsACL();
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
case 721:	$Estado = "TALLER [Extorno Recibido]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";
case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";

case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/


$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"General","AccesoTotal"))?true:false;

if($PrivilegioAccesoTotal){

	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","ASC",NULL,NULL,NULL,"11",NULL,NULL,NULL,NULL,NULL);
	$ArrFichaIngresos = $ResFichaIngreso['Datos'];
	$FichaIngresosTotal = $ResFichaIngreso['Total'];
	
}else{

	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","ASC",NULL,NULL,NULL,"11",NULL,NULL,NULL,NULL,$_SESSION['SesionPersonal']);
	$ArrFichaIngresos = $ResFichaIngreso['Datos'];
	$FichaIngresosTotal = $ResFichaIngreso['Total'];

}


if($FichaIngresosTotal>0){
	
	echo "Hay (".$FichaIngresosTotal.") Orden(es) de Trabajo pendiente(s) por atender: <br><br>";
	
	foreach($ArrFichaIngresos as $DatFichaIngreso){
		echo "- OT: ".$DatFichaIngreso->FinId."<br>";	
	}



}else{
	echo "";	
}


echo "<br>";	
echo "<hr>";	
echo "<br>";	

if($PrivilegioAccesoTotal){

	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","ASC",NULL,NULL,NULL,"7",NULL,NULL,NULL,NULL,NULL);
	$ArrFichaIngresos = $ResFichaIngreso['Datos'];
	$FichaIngresosTotal = $ResFichaIngreso['Total'];
	
}else{

	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","ASC",NULL,NULL,NULL,"7",NULL,NULL,NULL,NULL,$_SESSION['SesionPersonal']);
	$ArrFichaIngresos = $ResFichaIngreso['Datos'];
	$FichaIngresosTotal = $ResFichaIngreso['Total'];

}





if($FichaIngresosTotal>0){
	
	echo "Hay (".$FichaIngresosTotal.") Orden(es) de Trabajo(Pedido(s)) pendiente(s) por recibir: <br><br>";
	
	foreach($ArrFichaIngresos as $DatFichaIngreso){
		echo "- OT: ".$DatFichaIngreso->FinId." <br>";	
	}



}else{
	echo "";	
}


?>