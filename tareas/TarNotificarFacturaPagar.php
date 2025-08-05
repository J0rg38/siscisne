<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

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


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
//MtdNotificarFacturaPorVencer($oDestinatario,$oCantidadDia=5,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL){
	
$InsAlmacenMovimientoEntrada->MtdNotificarAlmacenMovimientoEntradaVencimiento("jblanco@cyc.com.pe","01/01/".date("Y"),date("d/m/Y"),"NPA-10001","");	

//$InsFactura->MtdNotificarFacturaPorVencer("jblanco@cyc.com.pe,cchoque@cyc.com.pe,pbustamante@cyc.com.pe",10,"01/01/".date("Y"),date("d/m/Y"),"NPA-10001");
?>