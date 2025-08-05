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
	
	$InsFactura->FacTotalGravado = (string)round($InsFactura->FacTotalGravado/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalExonerado = (string)round($InsFactura->FacTotalExonerado/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalGratuito = (string)round($InsFactura->FacTotalGratuito/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalDescuento = (string)round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalImpuestoSelectivo = (string)round($InsFactura->FacTotalImpuestoSelectivo/$InsFactura->FacTipoCambio,2);
	
	$InsFactura->FacTotalPagar = (string)round($InsFactura->FacTotalPagar/$InsFactura->FacTipoCambio,2);
//	$InsFactura->FacTotalDescuento = (string)round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);
	
	$InsFactura->FacSubTotal = (string)round($InsFactura->FacSubTotal/$InsFactura->FacTipoCambio,2);	
	$InsFactura->FacImpuesto = (string)round($InsFactura->FacImpuesto/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotal = (string)round($InsFactura->FacTotal/$InsFactura->FacTipoCambio,2);	
	
}


//$l_oClient = new nusoap_client('http://127.0.0.1:8083/webservice1.asmx?wsdl','wsdl');
////http://179.43.96.147:8083
//
//$l_oProxy = $l_oClient->getProxy();
//
//$err = $l_oClient->getError();
//	
//if ($err) {
//	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
//}

//$json = new Services_JSON();

//echo "<br>";
//echo "Procesando...";
//echo "<br>";


$Total = (string)round($InsFactura->FacTotal,2);
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
$Comprobante['totalValorGravada'] = (string)round($InsFactura->FacSubTotal,2);
$Comprobante['totalValorInafecta'] = 0;
$Comprobante['totalVentaExonerada'] = (string)round($InsFactura->FacTotalExonerado,2);
$Comprobante['igv'] = (string)round($InsFactura->FacImpuesto,2);
$Comprobante['otrosCargos'] = 0;
$Comprobante['total'] = (string)round($InsFactura->FacTotal,2);
$Comprobante['montoLetras'] = trim($numalet->letra()." CON ".$parte_decimal."/100"." ".$InsFactura->MonNombre);
$Comprobante['tipoMoneda'] = ($InsFactura->MonSigla);
$Comprobante['idPedido'] = 0;

$Comprobante['tienda'] = $_SESSION['SesionSucursalNombre'];
$Comprobante['vendedor'] = "";
$Comprobante['ref'] = "";//Numero serie de item
$Comprobante['otros'] = "";//Datos adicionales
$Comprobante['descuentoGlobal'] =0;
$Comprobante['totalDescuento'] = (string)round($InsFactura->FacTotalDescuento,2);
$Comprobante['porcentajeDescuentoGlobal'] = 0;
$Comprobante['totalVentaGratuita'] = (string)round($InsFactura->FacTotalGratuito,2);
$Comprobante['fechaVencimiento'] = FncCambiaFechaAMysql((empty($InsFactura->FacFechaVencimiento)?$InsFactura->FacFechaEmision:$InsFactura->FacFechaVencimiento),true);
$Comprobante['tipoPago'] = ($InsFactura->NpaNombre);
$Comprobante['observaciones'] = "";

$Comprobante['items'] = array();


$FdeImpuesto = 0;

if(!empty($InsFactura->FacturaDetalle)){
	foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){
		
		
			
				$DatFacturaDetalle->FdeDescripcion;		
	$DatFacturaDetalle->FdeDescripcion .= "|";	
	
  if(!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)){
	
	$DatFacturaDetalle->FdeDescripcion .= "( ";

  }

  if(!empty($InsFactura->FacDatoAdicional13)){
	
	$DatFacturaDetalle->FdeDescripcion .= "Nro. VIN o CHASIS: ".$InsFactura->FacDatoAdicional13.", ";
	
  }

  
  

  if(!empty($InsFactura->FacDatoAdicional7)){
 
		$DatFacturaDetalle->FdeDescripcion .= "Nro. Motor: ".$InsFactura->FacDatoAdicional7.", ";
	
  }
  
  

  if(!empty($InsFactura->FacDatoAdicional1)){
 
		$DatFacturaDetalle->FdeDescripcion .= "Marca: ".$InsFactura->FacDatoAdicional1.", ";
 
  }

  if(!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)){
	
   $DatFacturaDetalle->FdeDescripcion .= " )";
   
  }
  
  
  
  
		if($InsFactura->MonId<>$EmpresaMonedaId and (!empty($InsFactura->FacTipoCambio) )){
		
			$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdePrecio = ($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdeDescuento = ($DatFacturaDetalle->FdeDescuento  / $InsFactura->FacTipoCambio);
			
			$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdeValorVentaUnitario = ($DatFacturaDetalle->FdeValorVentaUnitario  / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdeImpuesto = ($DatFacturaDetalle->FdeImpuesto  / $InsFactura->FacTipoCambio);
			
			
		}
		
		
		$Item['idArticulo']	= $DatFacturaDetalle->FdeCodigo;
		$Item['unidadMedida']	= $DatFacturaDetalle->FdeUnidadMedidaCodigo;
		$Item['cantidad']	= (string)round($DatFacturaDetalle->FdeCantidad,2);
		$Item['articulo']	= trim($DatFacturaDetalle->FdeDescripcion);
		$Item['precioVentaUnitario']	= (string)round($DatFacturaDetalle->FdePrecio,2);
		
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
		$Item['igv']	= (string)round($DatFacturaDetalle->FdeImpuesto,2);
		$Item['valorUnitario']	= (string)round($DatFacturaDetalle->FdeValorVentaUnitario,2);
		$Item['valorTotal']	= (string)round($DatFacturaDetalle->FdeValorVenta,2);
		$Item['descuento']	= (string)round($DatFacturaDetalle->FdeDescuento,2);
		$Item['porcentajeDescuento']	= (string)round($DatFacturaDetalle->FdePorcentajeDescuento,2);
		
		if($DatFacturaDetalle->FdeGratuito == "1"){//20
			$tipoPrecioVentaUnitario = "02";
		}else{
			$tipoPrecioVentaUnitario = "01";
		}
		
		$Item['tipoPrecioVentaUnitario'] = $tipoPrecioVentaUnitario;
		
		$Comprobante['items'][] = $Item;
		
		$FdeImpuesto += ($DatFacturaDetalle->FdeImpuesto);
	
	}
}

 
//echo $JnComprobante = json_encode($Comprobante);


$JnComprobante = json_encode($Comprobante);

if(round($InsFactura->FacImpuesto,2) == round($FdeImpuesto,2)){
	
}else{
	echo "FacImpuesto: ".round($InsFactura->FacImpuesto,2);
	echo "<br>";
	echo "FdeImpuesto: ".round($FdeImpuesto,2);
	echo "<br>";
	echo "error";
	exit();
}



/*
* CREANDO ARCHIVO
*/



if(file_exists("../../../creativa/".$EmpresaCodigo."-01-".$InsFactura->FtaNumero."-".$InsFactura->FacId.".json")){
	unlink("../../../creativa/".$EmpresaCodigo."-01-".$InsFactura->FtaNumero."-".$InsFactura->FacId.".json");
}

jbalog("../../../creativa/",$EmpresaCodigo."-01-".$InsFactura->FtaNumero."-".$InsFactura->FacId.".json",$JnComprobante);



/*
* LLAMANDO WS
*/

$client = new nusoap_client('http://179.43.96.147:8083/webservice1.asmx?wsdl','wsdl');
 $err = $client->getError();
if ($err) {	echo 'Error en Constructor' . $err ; }

$param = array('json' => utf8_encode($JnComprobante));
$result = $client->call('guardaFacturaElectronica', $param);
 
if ($client->fault) {
	//echo 'Fallo';
	
} else {	// Chequea errores
	$err = $client->getError();
	if ($err) {		// Muestra el error
		//echo 'Error' . $err ;
	} else {		// Muestra el resultado
		//echo 'Resultado';
		//print_r ($result);
	}
}
//print_r($result);
//echo str_replace("\n","",$result['faultstring']);

//if(guardaFacturaElectronicaResult['dt'])


//deb($result['guardaFacturaElectronicaResult']);
//deb($result['guardaFacturaElectronicaResult']['dt']);

if($result['guardaFacturaElectronicaResult']['dt']=="ok"){
	
	$CodigoRespuesta = "P101";
	$MensajeRespuesta = ("Comprobante procesado correctamente ".date("d/m/Y H:i:s"));;
	
}else{
	
	$Respuesta =  str_replace("\n","",$result['faultstring']);
	$Respuesta =  str_replace("---","",$Respuesta);
	$Respuesta =  str_replace("-->","",$Respuesta);
	$Respuesta =  str_replace(">","",$Respuesta);
	$Respuesta =  str_replace("<","",$Respuesta);
	
	$MensajeRespuesta = utf8_encode($Respuesta);;
	$CodigoRespuesta = "";
	
}


$Resultado["CodigoRespuesta"] = ($CodigoRespuesta);
$Resultado["MensajeRespuesta"] = ($MensajeRespuesta);

//ACCIONES
$InsFactura->MtdEditarFacturaDato("FacSunatUltimaAccion","ALTA",$InsFactura->FacId,$InsFactura->FtaId);
$InsFactura->MtdEditarFacturaDato("FacSunatUltimaRespuesta",($MensajeRespuesta),$InsFactura->FacId,$InsFactura->FtaId);

echo json_encode($Resultado);
//if(json_last_error()

?>