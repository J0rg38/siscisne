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
////require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

$GET_Nombre = $_GET['Nombre'];
$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

//deb($GET_Nombre );
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');



$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsFactura->FacId = $GET_id;
$InsFactura->FtaId = $GET_ta;
$InsFactura->MtdObtenerFactura();


if($InsFactura->MonId<>$EmpresaMonedaId){
	
	$InsFactura->FacTotalGravado = round($InsFactura->FacTotalGravado/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalExonerado = round($InsFactura->FacTotalExonerado/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalGratuito = round($InsFactura->FacTotalGratuito/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalImpuestoSelectivo = round($InsFactura->FacTotalImpuestoSelectivo/$InsFactura->FacTipoCambio,2);
	
	$InsFactura->FacTotalPagar = round($InsFactura->FacTotalPagar/$InsFactura->FacTipoCambio,2);
//	$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);
	
	$InsFactura->FacSubTotal = round($InsFactura->FacSubTotal/$InsFactura->FacTipoCambio,2);	
	$InsFactura->FacImpuesto = round($InsFactura->FacImpuesto/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotal = round($InsFactura->FacTotal/$InsFactura->FacTipoCambio,2);	
	
}


$l_oClient = new nusoap_client('http://127.0.0.1:8083/webservice1.asmx?wsdl','wsdl');
//http://179.43.96.147:8083

$l_oProxy = $l_oClient->getProxy();

$err = $l_oClient->getError();
	
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//$json = new Services_JSON();

//echo "<br>";
//echo "Procesando...";
//echo "<br>";


$Total = round($InsFactura->FacTotal,2);
list($parte_entero,$parte_decimal) = explode(".",$Total);

if(empty($parte_decimal)){
	$parte_decimal = 0;
}

$parte_decimal = str_pad($parte_decimal, 2, "0", STR_PAD_RIGHT);

$numalet= new CNumeroaletra;
$numalet->setNumero($parte_entero);
$numalet->setMayusculas(1);
$numalet->setGenero(1);
$numalet->setMoneda("");
$numalet->setPrefijo("");
$numalet->setSufijo("");
 
//Dim json As String = "{""user"":""zbwduser""," + """password"":""njuzqgc""," + """json"":""" & str & """}"

//$param = array(	'oComprobante' => json_encode($Comprobante));
$Comprobante['user'] = "zbwduser";
$Comprobante['password'] = "njuzqgc";

$Comprobante['fechaEmision'] = FncCambiaFechaAMysql($InsFactura->FacFechaEmision);
$Comprobante['razonSocial'] = trim($EmpresaNombre);
$Comprobante['ruc'] = trim($EmpresaCodigo);
$Comprobante['tipoDocumento'] = ("01");
$Comprobante['serie'] = ($InsFactura->FtaNumero);
$Comprobante['correlativo'] = ($InsFactura->FacId);
$Comprobante['tipoDocumentoAdquiriente'] = ($InsFactura->TdoCodigo+1)-1;
$Comprobante['documentoAdquiriente'] = trim($InsFactura->CliNumeroDocumento);
$Comprobante['razonSocialAdquiriente'] = trim($InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno);
$Comprobante['totalValorGravada'] = round($InsFactura->FacSubTotal,2);
$Comprobante['totalValorInafecta'] = 0;
$Comprobante['totalVentaExonerada'] = round($InsFactura->FacTotalExonerado,2);
$Comprobante['igv'] = round($InsFactura->FacImpuesto,2);
$Comprobante['otrosCargos'] = 0;
$Comprobante['total'] = round($InsFactura->FacTotal,2);
$Comprobante['montoLetras'] = trim($numalet->letra()." CON ".$parte_decimal."/100"." ".$InsFactura->MonNombre);
$Comprobante['tipoMoneda'] = ($InsFactura->MonSigla);
$Comprobante['idPedido'] = 0;

$Comprobante['tienda'] = $_SESSION['SesionSucursalNombre'];
$Comprobante['vendedor'] = "";
$Comprobante['ref'] = "";//Numero serie de item
$Comprobante['otros'] = "";//Datos adicionales
$Comprobante['descuentoGlobal'] =0;
$Comprobante['totalDescuento'] = round($InsFactura->FacTotalDescuento,2);
$Comprobante['porcentajeDescuentoGlobal'] = 0;
$Comprobante['totalVentaGratuita'] = round($InsFactura->FacTotalGratuito,2);
$Comprobante['fechaVencimiento'] = FncCambiaFechaAMysql((empty($InsFactura->FacFechaVencimiento)?$InsFactura->FacFechaEmision:$InsFactura->FacFechaVencimiento),true);
$Comprobante['tipoPago'] = ($InsFactura->NpaNombre);
$Comprobante['observaciones'] = "";

$Comprobante['items'] = array();

if(!empty($InsFactura->FacturaDetalle)){
	foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){

		if($InsFactura->MonId<>$EmpresaMonedaId and (!empty($InsFactura->FacTipoCambio) )){
		
			$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdePrecio = ($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio);
			
			$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdeValorVentaUnitario = ($DatFacturaDetalle->FdeValorVentaUnitario  / $InsFactura->FacTipoCambio);
			
		}
		
		$Item['idArticulo']	= $DatFacturaDetalle->FdeCodigo;
		$Item['unidadMedida']	= $DatFacturaDetalle->FdeUnidadMedidaCodigo;
		$Item['cantidad']	= round($DatFacturaDetalle->FdeCantidad,2);
		$Item['articulo']	= trim($DatFacturaDetalle->FdeDescripcion);
		$Item['precioVentaUnitario']	= round($DatFacturaDetalle->FdePrecio,2);
		
		if($DatFacturaDetalle->FdeExonerado == "1"){//20						  
			if($DatFacturaDetalle->FdeGratuito == "1"){//20						  								
				$afectacionIgv = "21";	
			}else{							  
				$afectacionIgv = "20";
			}		
		}else if($DatFacturaDetalle->FdeExonerado == "2"){//10
			
			if($DatFacturaDetalle->FdeGratuito == "1"){//20						  	
			  $afectacionIgv = "11";						  	
			}else{							  
			   $afectacionIgv = "10";							  
			}
			
		}else{
		   $afectacionIgv = "00";	
		}
					  
		$Item['afectacionIgv']	= $afectacionIgv;
		$Item['igv']	= round($DatFacturaDetalle->FdeImpuesto,2);
		$Item['valorUnitario']	= round($DatFacturaDetalle->FdeValorVentaUnitario,2);
		$Item['valorTotal']	= round($DatFacturaDetalle->FdeValorVenta,2);
		$Item['descuento']	= round($DatFacturaDetalle->FdeDescuento,2);
		$Item['porcentajeDescuento']	= round($DatFacturaDetalle->FdePorcentajeDescuento,2);
		
		if($DatFacturaDetalle->FdeGratuito == "1"){//20
			$tipoPrecioVentaUnitario = "02";
		}else{
			$tipoPrecioVentaUnitario = "01";
		}
		
		$Item['tipoPrecioVentaUnitario'] = $tipoPrecioVentaUnitario;
		
		$Comprobante['items'][] = $Item;
	
	}
}

 
echo $JnComprobante = json_encode($Comprobante);

jbalog("../../../creativa/",$EmpresaCodigo."-01-".$InsFactura->FtaNumero."-".$InsFactura->FacId.".json",$JnComprobante);


exit();

$l_stResult = $l_oProxy->guardaFacturaElectronica(($JnComprobante));
$l_stResult = eregi_replace("'","\"",$l_stResult);


echo "Respuesta: ".$Respuesta;
echo "<br>";

?>