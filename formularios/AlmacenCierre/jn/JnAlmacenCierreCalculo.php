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




$GET_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenCierre.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenSalida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
$InsAlmacenCierre = new ClsAlmacenCierre();
$InsTrasladoAlmacenSalida = new ClsTrasladoAlmacenSalida();
$InsTrasladoAlmacenEntrada = new ClsTrasladoAlmacenEntrada();
$InsVentaConcretada = new ClsVentaConcretada();
$InsTallerPedido = new ClsTallerPedido();

//ENTRADAS


//COMPRAS
//MtdObtenerAlmacenMovimientoEntradasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$GET_FechaInicio=NULL,$GET_FechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL)
$EntradasCompras = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradasValor("COUNT","amo.AmoId",NULL,NULL,NULL,"contiene",NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),"3",NULL,NULL,NULL,NULL,NULL,NULL,"AmoFecha",0,0,NULL,NULL,NULL,"1",NULL);

$InsAlmacenCierre->AciEntradasTotalCompras = (empty($EntradasCompras)?0:$EntradasCompras);

//OTRAS FICHAS
$EntradasOtrasFichas = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradasValor("COUNT","amo.AmoId",NULL,NULL,NULL,"contiene",NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),"3",NULL,NULL,NULL,NULL,NULL,NULL,"AmoFecha",0,0,NULL,NULL,NULL,"2",NULL);

$InsAlmacenCierre->AciEntradasTotalOtrasFichas = (empty($EntradasOtrasFichas)?0:$EntradasOtrasFichas);


//TRASLADOS Y TRANSFERENCIAS
//MtdObtenerTrasladoAlmacenEntradasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$GET_FechaInicio=NULL,$GET_FechaFin=NULL,$oEstado=NULL,$oFecha="AmoFecha",$oProveedor=NULL,$oAlmacen=NULL,$oSubTipo=NULL) {
$EntradasTraslados = $InsTrasladoAlmacenEntrada->MtdObtenerTrasladoAlmacenEntradasValor("COUNT","amo.AmoId",NULL,NULL,NULL,NULL,NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),"3","AmoFecha",NULL,NULL,"8");

$EntradasTransferencias = $InsTrasladoAlmacenEntrada->MtdObtenerTrasladoAlmacenEntradasValor("COUNT","amo.AmoId",NULL,NULL,NULL,NULL,NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),"3","AmoFecha",NULL,NULL,"6");

$InsAlmacenCierre->AciEntradasTotalTransferencias = (empty($EntradasTrasladoAlmacen)?0:$EntradasTrasladoAlmacen) + (empty($EntradasTransferenciaAlmacen)?0:$EntradasTransferenciaAlmacen);


//SALIDAS

// TRASLADOS Y TRANSFERENCIAS
////MtdObtenerTrasladoAlmacenSalidasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$GET_FechaInicio=NULL,$GET_FechaFin=NULL,$oEstado=NULL,$oSubTipo=NULL)
$SalidasTraslados = $InsTrasladoAlmacenSalida->MtdObtenerTrasladoAlmacenSalidasValor("COUNT","amo.AmoId",NULL,NULL,NULL,NULL,NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),"3","8");

$SalidasTransferenciaAlmacen = $InsTrasladoAlmacenSalida->MtdObtenerTrasladoAlmacenSalidasValor("COUNT","amo.AmoId",NULL,NULL,NULL,NULL,NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),"3","6");

$InsAlmacenCierre->AciSalidasTotalTransferencias = (empty($SalidasTrasladoAlmacen)?0:$SalidasTrasladoAlmacen) + (empty($SalidasTransferenciaAlmacen)?0:$SalidasTransferenciaAlmacen);


// VENTAS CONCRETADAS
////MtdObtenerVentaConcretadasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$GET_FechaInicio=NULL,$GET_FechaFin=NULL,$oEstado=NULL,$oConFactura=0,$oConBoleta=0,$oConGuiaRemision=0,$oVentaDirectaId=NULL,$oMoneda=NULL)
$SalidasVentaConcretadas = $InsVentaConcretada->MtdObtenerVentaConcretadasValor("COUNT","amo.AmoId",NULL,NULL,NULL,NULL,NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),'3',0,0,0,NULL,NULL);

$InsAlmacenCierre->AciSalidasTotalVentaConcretadas = (empty($SalidasVentaConcretadas)?0:$SalidasVentaConcretadas);


//TALLER PEDIDOS
//MtdObtenerTallerPedidosValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$GET_FechaInicio=NULL,$GET_FechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL)
$SalidasTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidosValor("COUNT","amo.AmoId",NULL,NULL,NULL,NULL,NULL,NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),'3',NULL,NULL,0,0,NULL,NULL,false,NULL);

$InsAlmacenCierre->AciSalidasTotalFichaIngresos = (empty($SalidasTallerPedido)?0:$SalidasTallerPedido);


//OTRAS SALIDAS
//MtdObtenerAlmacenMovimientoSalidasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$GET_FechaInicio=NULL,$GET_FechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL,$oSubTipo=NULL)
$SalidasTotalOtrasFichas = $InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalidasValor("COUNT","amo.AmoId",NULL,NULL,NULL,NULL,NULL,'AmoId','Desc','1',FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),'3',NULL,NULL,0,0,NULL,NULL,false,NULL,'1');

$InsAlmacenCierre->AciSalidasTotalOtrasFichas = (empty($SalidasTotalOtrasFichas)?0:$SalidasTotalOtrasFichas);


$InsAlmacenCierre->InsMysql = NULL;
echo json_encode($InsAlmacenCierre);
/*
$json = new JSON;
$var = $json->serialize( $ArrVehiculoMarcas );
$json->unserialize( $var );

echo $var;
*/
?>