<?php
//header('Content-type: text/json');
//header('Content-type: application/json');

session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');

$GET_ProductoId = $_GET['ProductoId'];
$GET_ClienteTipoId = $_GET['ClienteTipoId'];
$GET_UnidadMedidaId = $_GET['UnidadMedidaId'];
$GET_PorcentajeAdicional = (empty($_GET['PorcentajeAdicional'])?0:$_GET['PorcentajeAdicional']);
$GET_ProductoTipoId = $_GET['ProductoTipoId'];


$InsListaPrecio = new ClsListaPrecio();

//MtdObtenerListaPrecios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL)
$RepListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId","ASC","1",$GET_ProductoId,$GET_ClienteTipoId,$GET_UnidadMedidaId);
$ArrListaPrecios = $RepListaPrecio['Datos'];

$InsListaPrecio->LprId = $ArrListaPrecios[0]->LprId;
unset($ArrListaPrecios);
$InsListaPrecio->MtdObtenerListaPrecio();

//deb($InsListaPrecio);

$InsListaPrecio->LprPorcentajeAdicional = ($InsListaPrecio->LprPorcentajeAdicional + $GET_PorcentajeAdicional);

$V_Costo = $InsListaPrecio->LprCosto;

$V_OtroCosto = ($V_Costo  * ($InsListaPrecio->LprPorcentajeOtroCosto/100));		
$V_Utilidad = ( ($V_Costo + $V_OtroCosto) * ($InsListaPrecio->LprPorcentajeUtilidad/100));
$V_ManoObra = ( ($V_Costo + $V_OtroCosto + $V_Utilidad) * ($InsListaPrecio->LprPorcentajeManoObra/100));

$V_ValorVenta = $V_Costo + $V_OtroCosto + $V_Utilidad + $V_ManoObra;
$V_Impuesto = ($V_ValorVenta * ($EmpresaImpuestoVenta/100));		
$V_ValorVentaImpuesto = ($V_ValorVenta + $V_Impuesto);

$V_Adicional = ( $V_ValorVentaImpuesto * ($InsListaPrecio->LprPorcentajeAdicional/100));
$V_Descuento = ( ($V_ValorVentaImpuesto + $V_Adicional) * ($InsListaPrecio->LprPorcentajeDescuento/100));								
$V_Precio = ($V_ValorVentaImpuesto + $V_Adicional - $V_Descuento);
	
//SET V_OtroCosto = (V_Costo * (oLtiPorcentajeOtroCosto/100));								
//SET V_Utilidad = ( (V_Costo + V_OtroCosto) * (oLtiPorcentajeMargenUtilidad/100));
//SET V_ManoObra = ( (V_Costo + V_OtroCosto + V_Utilidad) * (oProPorcentajeManoObra/100));
//
//SET V_ValorVenta = V_Costo + V_OtroCosto + V_Utilidad + V_ManoObra;
//SET V_Impuesto = (V_ValorVenta * 0.18);		
//SET V_ValorVentaImpuesto = (V_ValorVenta + V_Impuesto);
//
//SET V_Adicional = ( V_ValorVentaImpuesto * (oProPorcentajeAdicional/100));
//SET V_Descuento = ( (V_ValorVentaImpuesto + V_Adicional) * (oProPorcentajeDescuento/100));								
//SET V_Precio = (V_ValorVentaImpuesto + V_Adicional - V_Descuento);

$InsListaPrecio->V_Costo = ($V_Costo);

$InsListaPrecio->V_OtroCosto = ($V_OtroCosto);
$InsListaPrecio->V_Utilidad = ($V_Utilidad);
$InsListaPrecio->V_ManoObra = ($V_ManoObra);

$InsListaPrecio->V_ValorVenta = ($V_ValorVenta);
$InsListaPrecio->V_Impuesto = ($V_Impuesto);		
$InsListaPrecio->V_ValorVentaImpuesto = ($V_ValorVentaImpuesto);

$InsListaPrecio->V_Adicional = ($V_Adicional);	
$InsListaPrecio->V_Descuento = ($V_Descuento);	
$InsListaPrecio->V_Precio = ($V_Precio);
//$InsListaPrecio->LprPrecio = FncRedondearCYC($V_Precio);
$InsListaPrecio->V_Precio = FncRedondearCYC($V_Precio);

$InsListaPrecio->InsMysql = NULL;
//$json = new Services_JSON();
//echo $json->encode($InsListaPrecio);


$json = new JSON;
//$var = $json->serialize( $ArrListaPrecios );
$var = $json->serialize( $InsListaPrecio );
$json->unserialize( $var );
echo $var;
	
?>