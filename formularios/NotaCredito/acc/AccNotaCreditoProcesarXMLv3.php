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

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsNotaCredito = new ClsNotaCredito();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsNotaCredito->NcrId = $GET_id;
$InsNotaCredito->NctId = $GET_ta;
$InsNotaCredito->MtdObtenerNotaCredito();

//deb($InsNotaCredito->NcrTipoCambio);
if($InsNotaCredito->MonId<>$EmpresaMonedaId){
	
	$InsNotaCredito->NcrTotalGravado = (string)round($InsNotaCredito->NcrTotalGravado/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalExonerado = (string)round($InsNotaCredito->NcrTotalExonerado/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalGratuito = (string)round($InsNotaCredito->NcrTotalGratuito/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalDescuento = (string)round($InsNotaCredito->NcrTotalDescuento/$InsNotaCredito->NcrTipoCambio,2);

	
	$InsNotaCredito->NcrTotalPagar = (string)round($InsNotaCredito->NcrTotalPagar/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalDescuento = (string)round($InsNotaCredito->NcrTotalDescuento/$InsNotaCredito->NcrTipoCambio,2);
	
	$InsNotaCredito->NcrSubTotal = (string)round($InsNotaCredito->NcrSubTotal/$InsNotaCredito->NcrTipoCambio,2);	
	$InsNotaCredito->NcrImpuesto = (string)round($InsNotaCredito->NcrImpuesto/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotal = (string)round($InsNotaCredito->NcrTotal/$InsNotaCredito->NcrTipoCambio,2);	
	
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


$InsNotaCredito->NcrTotal = (string)round($InsNotaCredito->NcrTotal,2);
list($parte_entero,$parte_decimal) = explode(".",$InsNotaCredito->NcrTotal);

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

$NotaCreditoTotalLetras = "SON ".$numalet->letra()." CON ".$parte_decimal."/100 ".$InsNotaCredito->MonNombre;


//$param = array(	'oComprobante' => json_encode($Comprobante));
$Comprobante['user'] = "zbwduser";
$Comprobante['password'] = "njuzqgc";

$Comprobante['fechaEmision'] = FncCambiaFechaAMysql($InsNotaCredito->NcrFechaEmision);
$Comprobante['razonSocial'] = trim($EmpresaNombre);
$Comprobante['ruc'] = trim($EmpresaCodigo);
$Comprobante['tipoDocumento'] = ("07");
$Comprobante['serie'] = ($InsNotaCredito->NctNumero);
$Comprobante['correlativo'] = ($InsNotaCredito->NcrId);
$Comprobante['tipoDocumentoAdquiriente'] = ($InsNotaCredito->TdoCodigo+1)-1;
$Comprobante['documentoAdquiriente'] = trim($InsNotaCredito->CliNumeroDocumento);
$Comprobante['razonSocialAdquiriente'] = trim($InsNotaCredito->CliNombre." ".$InsNotaCredito->CliApellidoPaterno." ".$InsNotaCredito->CliApellidoMaterno);
$Comprobante['totalValorGravada'] = (string)round($InsNotaCredito->NcrSubTotal,2);
$Comprobante['totalValorInafecta'] = 0;
$Comprobante['totalVentaExonerada'] = (string)round($InsNotaCredito->NcrTotalExonerado,2);
$Comprobante['igv'] = (string)round($InsNotaCredito->NcrImpuesto,2);
$Comprobante['otrosCargos'] = 0;
$Comprobante['total'] = (string)round($InsNotaCredito->NcrTotal,2);
$Comprobante['montoLetras'] = trim($numalet->letra()." CON ".$parte_decimal."/100"." ".$InsNotaCredito->MonNombre);
$Comprobante['tipoMoneda'] = ($InsNotaCredito->MonSigla);
$Comprobante['serieModifica'] = $InsNotaCredito->DtaNumero;
$Comprobante['correlativoModifica'] = $InsNotaCredito->DocId;


		switch($InsNotaCredito->NcrTipo){
			
			case "2": //FACTURA
				$Comprobante['tipoDocumentoModifica'] = "01";
			break;
			
			case "3"://BOLETA
				$Comprobante['tipoDocumentoModifica'] = "03";
			break;
			
		}
		
$Comprobante['tipoNotaCreditoElectronica'] = $InsNotaCredito->NcrMotivoCodigo;
$Comprobante['motivo'] = $InsNotaCredito->NcrMotivo;
//$Comprobante['idPedido'] = 0;
$Comprobante['tienda'] = $_SESSION['SesionSucursalNombre'];
$Comprobante['vendedor'] = "";
//$Comprobante['ref'] = "";//Numero serie de item
//$Comprobante['otros'] = "";//Datos adicionales
$Comprobante['descuentoGlobal'] =0;
$Comprobante['porcentajeDescuentoGlobal'] = 0;
$Comprobante['totalDescuento'] = (string)round($InsNotaCredito->NcrTotalDescuento,2);
$Comprobante['totalVentaGratuita'] = (string)round($InsNotaCredito->NcrTotalGratuito,2);
//$Comprobante['fechaVencimiento'] = FncCambiaFechaAMysql((empty($InsNotaCredito->NcrFechaVencimiento)?$InsNotaCredito->NcrFechaEmision:$InsNotaCredito->NcrFechaVencimiento),true);
//$Comprobante['tipoPago'] = ($InsNotaCredito->NpaNombre);
$Comprobante['observaciones'] = "";

$Comprobante['items'] = array();

if(!empty($InsNotaCredito->NotaCreditoDetalle)){
	foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){



	
					$DatNotaCreditoDetalle->NcdDescripcion;		
	$DatNotaCreditoDetalle->NcdDescripcion .= "|";	
	
  if(!empty($InsNotaCredito->NcrDatoAdicional13) or !empty($InsNotaCredito->NcrDatoAdicional7) or !empty($InsNotaCredito->NcrDatoAdicional1)){
	
	$DatNotaCreditoDetalle->NcdDescripcion .= "( ";

  }

  if(!empty($InsNotaCredito->NcrDatoAdicional13)){
	
	$DatNotaCreditoDetalle->NcdDescripcion .= "Nro. VIN o CHASIS: ".$InsNotaCredito->NcrDatoAdicional13.", ";
	
  }

  
  

  if(!empty($InsNotaCredito->NcrDatoAdicional7)){
 
		$DatNotaCreditoDetalle->NcdDescripcion .= "Nro. Motor: ".$InsNotaCredito->NcrDatoAdicional7.", ";
	
  }
  
  

  if(!empty($InsNotaCredito->NcrDatoAdicional1)){
 
		$DatNotaCreditoDetalle->NcdDescripcion .= "Marca: ".$InsNotaCredito->NcrDatoAdicional1.", ";
 
  }

  if(!empty($InsNotaCredito->NcrDatoAdicional13) or !empty($InsNotaCredito->NcrDatoAdicional7) or !empty($InsNotaCredito->NcrDatoAdicional1)){
	
   $DatNotaCreditoDetalle->NcdDescripcion .= " )";
   
  }
  
  
  
		if($InsNotaCredito->MonId<>$EmpresaMonedaId and (!empty($InsNotaCredito->NcrTipoCambio) )){
		
			$DatNotaCreditoDetalle->NcdImporte = ($DatNotaCreditoDetalle->NcdImporte / $InsNotaCredito->NcrTipoCambio);
			$DatNotaCreditoDetalle->NcdPrecio = ($DatNotaCreditoDetalle->NcdPrecio  / $InsNotaCredito->NcrTipoCambio);
			
			$DatNotaCreditoDetalle->NcdValorVenta = ($DatNotaCreditoDetalle->NcdValorVenta / $InsNotaCredito->NcrTipoCambio);
			$DatNotaCreditoDetalle->NcdValorVentaUnitario = ($DatNotaCreditoDetalle->NcdValorVentaUnitario  / $InsNotaCredito->NcrTipoCambio);
			
		}
		
		$Item['idArticulo']	= $DatNotaCreditoDetalle->NcdCodigo;
		$Item['unidadMedida']	= $DatNotaCreditoDetalle->NcdUnidadMedidaCodigo;
		$Item['cantidad']	= (string)round($DatNotaCreditoDetalle->NcdCantidad,2);
		$Item['articulo']	= trim($DatNotaCreditoDetalle->NcdDescripcion);
		$Item['precioVentaUnitario']	= (string)round($DatNotaCreditoDetalle->NcdPrecio,2);
		
		if($DatNotaCreditoDetalle->NcdExonerado == "1"){//20						  
			if($DatNotaCreditoDetalle->NcdGratuito == "1"){//20						  								
				$afectacionIgv = "21";	
			}else{							  
				$afectacionIgv = "20";
			}		
		}else if($DatNotaCreditoDetalle->NcdExonerado == "2"){//10
			
			if($DatNotaCreditoDetalle->NcdGratuito == "1"){//20						  	
			  $afectacionIgv = "11";						  	
			}else{							  
			   $afectacionIgv = "10";							  
			}
			
		}else{
		   $afectacionIgv = "00";	
		}
					  
		$Item['afectacionIgv']	= $afectacionIgv;
		$Item['igv']	= (string)round($DatNotaCreditoDetalle->NcdImpuesto,2);
		$Item['valorUnitario']	= (string)round($DatNotaCreditoDetalle->NcdValorVentaUnitario,2);
		$Item['valorTotal']	= (string)round($DatNotaCreditoDetalle->NcdValorVenta,2);
		$Item['descuento']	= (string)round($DatNotaCreditoDetalle->NcdDescuento,2);
		$Item['porcentajeDescuento']	= (string)round($DatNotaCreditoDetalle->NcdPorcentajeDescuento,2);
		
		if($DatNotaCreditoDetalle->NcdGratuito == "1"){//20
			$tipoPrecioVentaUnitario = "02";
		}else{
			$tipoPrecioVentaUnitario = "01";
		}
		
		$Item['tipoPrecioVentaUnitario'] = $tipoPrecioVentaUnitario;
		
		$Comprobante['items'][] = $Item;
	
	}
}

 
//echo $JnComprobante = json_encode($Comprobante);

$JnComprobante = json_encode($Comprobante);

/*
* CREANDO ARCHIVO
*/


//jbalog("../../../creativa/",$EmpresaCodigo."-07-".$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId.".json",$JnComprobante);

if(file_exists("../../../creativa/".$EmpresaCodigo."-07-".$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId.".json")){
	unlink("../../../creativa/".$EmpresaCodigo."-07-".$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId.".json");
}

jbalog("../../../creativa/",$EmpresaCodigo."-07-".$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId.".json",$JnComprobante);

/*
* LLAMANDO WS
*/

//$client = new nusoap_client('http://127.0.0.1:8083/webservice1.asmx?wsdl','wsdl');
$client = new nusoap_client('http://179.43.96.147:8083/webservice1.asmx?wsdl','wsdl');
 $err = $client->getError();
if ($err) {	echo 'Error en Constructor' . $err ; }

$param = array('json' => utf8_encode($JnComprobante));
$result = $client->call('guardarNotaCreditoElectronica', $param);
 
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

//if(guardaNotaCreditoElectronicaResult['dt'])


//deb($result['guardaNotaCreditoElectronicaResult']);
//deb($result['guardaNotaCreditoElectronicaResult']['dt']);

if($result['guardarNotaCreditoElectronicaResult']['dt']=="ok"){
	
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
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaAccion","ALTA",$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaRespuesta",($MensajeRespuesta),$InsNotaCredito->NcrId,$InsNotaCredito->NctId);

echo json_encode($Resultado);
//if(json_last_error()

?>