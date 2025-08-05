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


require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoProveedor.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenCompra.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$GET_ProveedorId = "PRV-10548";
$GET_MonedaId = "MON-10001";
$GET_FechaInicio = "01/01/".date("Y");
$GET_FechaFin =  date("d/m/Y");
$Destinatarios = "pcondori@cyc.com.pe,scanepam@cyc.com.pe,aliendo@cyc.com.pe,jblanco@cyc.com.pe,iquezada@cyc.com.pe";

$ProveedorNombre = "";
$ProveedorNumeroDocumento = "";
$ProveedorTipoDocumento = "";
$ProveedorId = "";


$InsProveedor = new ClsProveedor();
$InsMoneda = new ClsMoneda();
$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsOrdenCompra = new ClsOrdenCompra();
$InsPagoProveedor = new ClsPagoProveedor();
$InsReporteOrdenCompra = new ClsReporteOrdenCompra();
$InsReporteAlmacenMovimientoEntrada = new ClsReporteAlmacenMovimientoEntrada();


$InsProveedor = new ClsProveedor();
$InsProveedor->PrvId = $GET_ProveedorId;
$InsProveedor->MtdObtenerProveedor();

$ProveedorId = $InsProveedor->PrvId;
$ProveedorNombre = $InsProveedor->PrvNombre." ".$InsProveedor->PrvApellidoPaterno." ".$InsProveedor->PrvApellidoMaterno;
$ProveedorNumeroDocumento = $InsProveedor->PrvNumeroDocumento;
$ProveedorTipoDocumento = $InsProveedor->TdoNombre;



//$InsMoneda->MonId = empty($GET_MonedaId)?$EmpresaMonedaId:$GET_MonedaId;
$InsMoneda->MonId = $GET_MonedaId;
$InsMoneda->MtdObtenerMoneda();


//MtdObtenerPagoProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PovId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oCuenta=NULL,$oProveedor=NULL)
$ResPagoProveedor = $InsPagoProveedor->MtdObtenerPagoProveedores(NULL,NULL,NULL,"PovFecha","DESC","1",3,FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),$GET_MonedaId,NULL,$GET_ProveedorId);
$ArrPagoProveedors = $ResPagoProveedor['Datos'];


$TotalPagoProveedor = 0;
$UltimoPagoProveedorFecha = "";

if(!empty($ArrPagoProveedors)){
	foreach($ArrPagoProveedors as $DatPagoProveedor){
		
		if($DatPagoProveedor->MonId<>$EmpresaMonedaId ){
			$DatPagoProveedor->PovMonto = round($DatPagoProveedor->PovMonto / $DatPagoProveedor->PovTipoCambio,2);
		}
	
		$TotalPagoProveedor = $DatPagoProveedor->PovMonto;
		$UltimoPagoProveedorFecha = $DatPagoProveedor->PovFecha;
		
	}
}


//$ResReporteOrdenCompraResumen = $InsReporteOrdenCompra->MtdObtenerReporteOrdenCompra(NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,NULL,$POST_Moneda,NULL,NULL,$POST_ProveedorId);
//$ArrReporteOrdenCompraResumenes = $ResReporteOrdenCompraResumen['Datos'];

//MtdObtenerReporteOrdenCompra($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oMoneda=NULL,$oOrdenCompraTipo=NULL,$oProveedor=NULL) {
$ResReporteOrdenCompraResumen = $InsReporteOrdenCompra->MtdObtenerReporteOrdenCompra(NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($UltimoPagoProveedorFecha),NULL,NULL,NULL,$GET_MonedaId,NULL,NULL,$GET_ProveedorId);
$ArrReporteOrdenCompraResumenes = $ResReporteOrdenCompraResumen['Datos'];

$TotalOrdenCompra = 0;

if(!empty($ArrReporteOrdenCompraResumenes)){
	foreach($ArrReporteOrdenCompraResumenes as $DatReporteOrdenCompraResumen){

		if($DatReporteOrdenCompraResumen->MonId<>$EmpresaMonedaId ){
			$DatReporteOrdenCompraResumen->PcoTotal = round($DatReporteOrdenCompraResumen->PcoTotal / $DatReporteOrdenCompraResumen->PcoTipoCambio,2);
		}
		
		$TotalOrdenCompra += $DatReporteOrdenCompraResumen->PcoTotal;
		
	}
}


$TotalAlmacenMovimientoEntrada = 0;


//$ResAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradas(NULL,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($UltimoPagoProveedorFecha),NULL,3,NULL,$GET_MonedaId,NULL,NULL,NULL,NULL,"AmoComprobanteNumero",0,0,$GET_ProveedorId,NULL,NULL,1,NULL);
//$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];

//MtdObtenerAlmacenMovimientoEntradaEspeciales($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="AmoFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oSubTipo=NULL,$oAlmacen=NULL,$oFechaInicioOrdenCompra=NULL,$oFechaFinOrdenCompra=NULL) {
$ResAlmacenMovimientoEntrada = $InsReporteAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntradaEspeciales(NULL,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($UltimoPagoProveedorFecha),NULL,3,NULL,$GET_MonedaId,NULL,NULL,NULL,NULL,"AmoComprobanteFecha",0,0,$GET_ProveedorId,NULL,NULL,1,NULL,NULL,FncCambiaFechaAMysql($UltimoPagoProveedorFecha));
$ArrAlmacenMovimientoEntradas = $ResAlmacenMovimientoEntrada['Datos'];


if(!empty($ArrAlmacenMovimientoEntradas)){
	foreach($ArrAlmacenMovimientoEntradas as $DatAlmacenMovimientoEntrada){
		
		if($DatAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
			$DatAlmacenMovimientoEntrada->AmoTotal = round($DatAlmacenMovimientoEntrada->AmoTotal / $DatAlmacenMovimientoEntrada->AmoTipoCambio,2);
		}
		
		$TotalAlmacenMovimientoEntrada += $DatAlmacenMovimientoEntrada->AmoTotal;
		
	}
}

			$TotalDisponible = $TotalPagoProveedor - $TotalOrdenCompra - $TotalAlmacenMovimientoEntrada;
				
			$Enviar = true;
			
			
			
			
			$mensaje .= "NOTIFICACION DE LINEA DE CREDITO DE PROVEEDOR";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Proveedor:</b> ".$ProveedorNombre."";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>Fecha de Notificacion:</b> ".date("d/m/Y")."";	
			$mensaje .= "<br>";	
			
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			$mensaje .= "<br>";

				
					
					$mensaje .= "<table cellpadding='2' cellspacing='0' width='350px' border='1'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<th align='center'>";
						$mensaje .= "";
						$mensaje .= "</th>";

						$mensaje .= "<th align='center'>";
						$mensaje .= "TOTALES";
						$mensaje .= "</th>";

					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td align='left'>";
						$mensaje .= "(A) Total Pagado (".$UltimoPagoProveedorFecha."):";
						$mensaje .= "</td>";

						$mensaje .= "<td align='right'>";
						$mensaje .= number_format($TotalPagoProveedor,2);
						$mensaje .= "</td>";

					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td align='left'>";
						$mensaje .= "(B) Total de Ordenes de Compra:";
						$mensaje .= "</td>";

						$mensaje .= "<td align='right'>";
						$mensaje .= number_format($TotalOrdenCompra,2);
						$mensaje .= "</td>";

					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td align='left'>";
						$mensaje .= "(C) Total Facturado:";
						$mensaje .= "</td>";

						$mensaje .= "<td align='right'>";
						$mensaje .= number_format($TotalAlmacenMovimientoEntrada,2);
						$mensaje .= "</td>";

					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td align='left'>";
						$mensaje .= "Linea Disponible Real (A-B-C):";
						$mensaje .= "</td>";

						$mensaje .= "<td align='right'>";
						$mensaje .= number_format($TotalDisponible,2);
						$mensaje .= "</td>";
						

					$mensaje .= "</tr>";
					
					
					$mensaje .= "</table>";
				
				
				
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por SISTEMA CYC a las ".date('d/m/Y H:i:s');
			
			if($TotalPagoProveedor<=0){
				$Enviar = false;
			}

			echo $mensaje;

	//	//deb($Enviar);
		if($Enviar){
			
			//$InsProveedor = new ClsProveedor();
//			
//			if($TotalDisponible>0){
//				$InsProveedor->MtdEditarProveedorDato("PrvLineaCreditoActiva",1,$GET_ProveedorId);
//			}else{
//				$InsProveedor->MtdEditarProveedorDato("PrvLineaCreditoActiva",2,$GET_ProveedorId);
//			}
//			
//			$InsCorreo = new ClsCorreo();	
//			$InsCorreo->MtdEnviarCorreo($Destinatarios,"sistema@cyc.com.pe","C&C S.A.C.","NOTIFICACION: LINEA DE CREDITO DE PROVEEDOR - ".$ProveedorNombre,$mensaje);
//			
		}
//			
			
				
//		}
