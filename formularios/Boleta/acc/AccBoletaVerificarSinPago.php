<?php
header("Content-Type: application/json;charset=utf-8");
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
////require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

$POST_Sucursal = $_POST['Sucursal'];


require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');

$InsBoleta = new ClsBoleta();

$FechaInicio = "01/".date("m")."/".date("Y");
$FechaFin = date("d/m/Y");



$FechaInicio = date("d/m/Y");
$FechaFin = date("d/m/Y");



//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL)
$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,"BolTiempoCreacion","DESC","5","5",FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),$POST_tal,NULL,"NPA-10000",$POST_Moneda,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,$MostrarNoProcesados,$POST_Cancelado,true);
$ArrBoletas = $ResBoleta['Datos'];

$Mensaje = "";
$Total = count($ArrBoletas);

//$Mensaje .= "Tienes ".$Total." comprobantes sin abono completo: ";
//$Mensaje .= "<br>";
//$Mensaje .= "<br>";
//if(!empty($ArrBoletas)){
//	foreach($ArrBoletas as $DatBoleta){
//		
//		$DatBoleta->BolTotal = (($DatBoleta->BolTotal/(empty($DatBoleta->BolTipoCambio)?1:$DatBoleta->BolTipoCambio)));
//		
//		//$Mensaje .= "* ".$DatBoleta->BtaNumero." - ".$DatBoleta->BolId." ".$DatBoleta->CliNombre." ".$DatBoleta->CliApellidoPaterno." ".$DatBoleta->CliApellidoMaterno;
//		$Mensaje .= "* ".$DatBoleta->BtaNumero."-".$DatBoleta->BolId." del ".$DatBoleta->BolFechaEmision." = ".$DatBoleta->MonSimbolo." ".number_format($DatBoleta->BolTotal,2);
//		
//		$Mensaje .= "<br>";
//		
//	}	
//}

$Mensaje = "Tienes (".$Total.") boletas sin cancelar el dia de hoy.";


$Resultado['Mensaje'] = "";
$Resultado['Total'] = ($Total);
//$Resultado['Total'] = 0;
echo json_encode($Resultado);

?>