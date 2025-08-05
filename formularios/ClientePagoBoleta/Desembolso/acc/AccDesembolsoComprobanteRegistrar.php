<?php
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

$Identificador = $_POST['Identificador'];
$POST_ProveedorId = $_POST['ProveedorId'];
$POST_Moneda = $_POst['MonedaId'];

session_start();
if (!isset($_SESSION['InsDesembolsoComprobante'.$Identificador])){
	$_SESSION['InsDesembolsoComprobante'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();

//MtdObtenerAlmacenMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oProveedor=NULL) 
$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,"AmoComprobanteNumero","ASC",NULL,NULL,NULL,3,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,"AmoFecha",0,2,$POST_ProveedorId,NULL,NULL,NULL);
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];

/*
SesionObjeto-DesembolsoComprobanteListado
Parametro1 = DcoId
Parametro2 = 
Parametro3 = AmoId
Parametro4 = AmoComprobanteNumero
Parametro5 = AmoComprobanteFecha
Parametro6 = AmoTotal
Parametro7 = PrvId
Parametro8 = MonId
Parametro9 = AmoTipoCambio
Parametro10 = MonNombre
Parametro11 = MonSimbolo
Parametro12 = PrvNombre
Parametro13 = PrvNumeroDocumento
*/

if(!empty($ArrAlmacenMovimientoEntradas)){
	foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){

		$DatAlmacenMovimientoEntrada->AmoTotal = (($EmpresaMonedaId==$DatAlmacenMovimientoEntrada->MonId or empty($DatAlmacenMovimientoEntrada->MonId))?$DatAlmacenMovimientoEntrada->AmoTotal:($DatAlmacenMovimientoEntrada->AmoTotal/$DatAlmacenMovimientoEntrada->AmoTipoCambio));                    
                 
		$_SESSION['InsDesembolsoComprobante'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		NULL,
		($DatAlmacenMovimientoEntrada->AmoId),
		($DatAlmacenMovimientoEntrada->AmoComprobanteNumero),
		($DatAlmacenMovimientoEntrada->AmoComprobanteFecha),
		($DatAlmacenMovimientoEntrada->AmoTotal),
		($DatAlmacenMovimientoEntrada->PrvId),
		($DatAlmacenMovimientoEntrada->MonId),
		($DatAlmacenMovimientoEntrada->AmoTipoCambio),
		($DatAlmacenMovimientoEntrada->MonNombre),
		($DatAlmacenMovimientoEntrada->MonSimbolo),
		($DatAlmacenMovimientoEntrada->PrvNombre),
		($DatAlmacenMovimientoEntrada->PrvNumeroDocumento)
		);

	}
}


	



?>