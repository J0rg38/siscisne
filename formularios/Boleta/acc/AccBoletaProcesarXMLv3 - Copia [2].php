<?php
//session_start();
header('Content-Type: application/json');

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
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');


$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;
$InsBoleta->MtdObtenerBoleta();

//deb($InsBoleta->BolTipoCambio);
if($InsBoleta->MonId<>$EmpresaMonedaId){
	
	$InsBoleta->BolTotalGravado = round($InsBoleta->BolTotalGravado/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalExonerado = round($InsBoleta->BolTotalExonerado/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalGratuito = round($InsBoleta->BolTotalGratuito/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalDescuento = round($InsBoleta->BolTotalDescuento/$InsBoleta->BolTipoCambio,2);

	
	$InsBoleta->BolTotalPagar = round($InsBoleta->BolTotalPagar/$InsBoleta->BolTipoCambio,2);
	//$InsBoleta->BolTotalDescuento = round($InsBoleta->BolTotalDescuento/$InsBoleta->BolTipoCambio,2);
	
	$InsBoleta->BolSubTotal = round($InsBoleta->BolSubTotal/$InsBoleta->BolTipoCambio,2);	
	$InsBoleta->BolImpuesto = round($InsBoleta->BolImpuesto/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotal = round($InsBoleta->BolTotal/$InsBoleta->BolTipoCambio,2);	
	$InsBoleta->BolTotalImpuestoSelectivo = round($InsBoleta->BolTotalImpuestoSelectivo/$InsBoleta->BolTipoCambio,2);
	
}

//$json = new Services_JSON();

//echo "<br>";
//echo "Procesando...";
//echo "<br>";


$Total = (string)round($InsBoleta->BolTotal,2);
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

$Comprobante['fechaEmision'] = FncCambiaFechaAMysql($InsBoleta->BolFechaEmision);
$Comprobante['razonSocial'] = trim($EmpresaNombre);
$Comprobante['ruc'] = trim($EmpresaCodigo);
$Comprobante['tipoDocumento'] = ("03");
$Comprobante['serie'] = ($InsBoleta->BtaNumero);
$Comprobante['correlativo'] = ($InsBoleta->BolId);
$Comprobante['tipoDocumentoAdquiriente'] = ($InsBoleta->TdoCodigo)+1-1;
$Comprobante['documentoAdquiriente'] = trim(str_replace("-","",$InsBoleta->CliNumeroDocumento));
$Comprobante['razonSocialAdquiriente'] = ($InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno);
$Comprobante['totalValorGravada'] = (string)round($InsBoleta->BolSubTotal,2);
$Comprobante['totalValorInafecta'] = 0;
$Comprobante['totalVentaExonerada'] = (string)round($InsBoleta->BolTotalExonerado,2);
$Comprobante['igv'] = (string)round($InsBoleta->BolImpuesto,2);
$Comprobante['otrosCargos'] = 0;
$Comprobante['total'] = (string)round($InsBoleta->BolTotal,2);
$Comprobante['montoLetras'] = "".$numalet->letra()." CON ".$parte_decimal."/100"." ".$InsBoleta->MonNombre;
$Comprobante['tipoMoneda'] = ($InsBoleta->MonSigla);
$Comprobante['idPedido'] = 0;

$Comprobante['tienda'] = $_SESSION['SesionSucursalNombre'];
$Comprobante['vendedor'] = "";
$Comprobante['ref'] = "";//Numero serie de item
$Comprobante['otros'] = "";//Datos adicionales
$Comprobante['descuentoGlobal'] =0;
$Comprobante['totalDescuento'] = (string)round($InsBoleta->BolTotalDescuento,2);
$Comprobante['porcentajeDescuentoGlobal'] = 0;
$Comprobante['totalVentaGratuita'] = (string)round($InsBoleta->BolTotalGratuito,2);
$Comprobante['fechaVencimiento'] = FncCambiaFechaAMysql((empty($InsBoleta->BolFechaVencimiento)?$InsBoleta->BolFechaEmision:$InsBoleta->BolFechaVencimiento),true);
$Comprobante['tipoPago'] = ($InsBoleta->NpaNombre);
$Comprobante['observaciones'] = "";

$Comprobante['items'] = array();

$BdeImpuesto = 0;

if(!empty($InsBoleta->BoletaDetalle)){
	foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){

		
	$DatBoletaDetalle->BdeDescripcion;		
	$DatBoletaDetalle->BdeDescripcion .= "|";	
	
  if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
	
	$DatBoletaDetalle->BdeDescripcion .= "( ";

  }

  if(!empty($InsBoleta->BolDatoAdicional13)){
	
	$DatBoletaDetalle->BdeDescripcion .= "Nro. VIN o CHASIS: ".$InsBoleta->BolDatoAdicional13.", ";
	
  }

  if(!empty($InsBoleta->BolDatoAdicional7)){
 
		$DatBoletaDetalle->BdeDescripcion .= "Nro. Motor: ".$InsBoleta->BolDatoAdicional7.", ";
	
  }
  
  if(!empty($InsBoleta->BolDatoAdicional1)){
 
		$DatBoletaDetalle->BdeDescripcion .= "Marca: ".$InsBoleta->BolDatoAdicional1." ";
 
  }

  if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
	
   $DatBoletaDetalle->BdeDescripcion .= " )";
   
  }
  
  
		if($InsBoleta->MonId<>$EmpresaMonedaId and (!empty($InsBoleta->BolTipoCambio) )){
		
			$DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte / $InsBoleta->BolTipoCambio);
			$DatBoletaDetalle->BdePrecio = ($DatBoletaDetalle->BdePrecio  / $InsBoleta->BolTipoCambio);
			$DatBoletaDetalle->BdeDescuento = ($DatBoletaDetalle->BdeDescuento  / $InsBoleta->BolTipoCambio);
			
			$DatBoletaDetalle->BdeValorVenta = ($DatBoletaDetalle->BdeValorVenta / $InsBoleta->BolTipoCambio);
			$DatBoletaDetalle->BdeValorVentaUnitario = ($DatBoletaDetalle->BdeValorVentaUnitario  / $InsBoleta->BolTipoCambio);
			$DatBoletaDetalle->BdeImpuesto = ($DatBoletaDetalle->BdeImpuesto  / $InsBoleta->BolTipoCambio);
			
		}
		
	
		$Item['idArticulo']	= $DatBoletaDetalle->BdeCodigo;
		$Item['unidadMedida']	= $DatBoletaDetalle->BdeUnidadMedidaCodigo;
		$Item['cantidad']	= (string)round($DatBoletaDetalle->BdeCantidad,2);
		$Item['articulo']	= trim($DatBoletaDetalle->BdeDescripcion);
		$Item['precioVentaUnitario']	= (string)round($DatBoletaDetalle->BdePrecio,2);
		
		if($DatBoletaDetalle->BdeExonerado == "1"){//20						  
			if($DatBoletaDetalle->BdeGratuito == "1"){//20						  								
				$afectacionIgv = "21";	
			}else{							  
				$afectacionIgv = "20";
			}		
		}else if($DatBoletaDetalle->BdeExonerado == "2"){//10
			
			if($DatBoletaDetalle->BdeGratuito == "1"){//20						  	
			  $afectacionIgv = "11";						  	
			}else{							  
			   $afectacionIgv = "10";							  
			}
			
		}else{
		   $afectacionIgv = "00";	
		}
					  
		$Item['afectacionIgv']	= $afectacionIgv;
		$Item['igv']	=  (string)round($DatBoletaDetalle->BdeImpuesto,2);
		$Item['valorUnitario']	= (string)round($DatBoletaDetalle->BdeValorVentaUnitario,2);
		$Item['valorTotal']	= (string)round($DatBoletaDetalle->BdeValorVenta,2);
		$Item['descuento']	= (string)round($DatBoletaDetalle->BdeDescuento,2);
		$Item['porcentajeDescuento']	= (string)round($DatBoletaDetalle->BdePorcentajeDescuento,2);
		
		if($DatBoletaDetalle->BdeGratuito == "1"){//20
			$tipoPrecioVentaUnitario = "02";
		}else{
			$tipoPrecioVentaUnitario = "01";
		}
		
		$Item['tipoPrecioVentaUnitario'] = $tipoPrecioVentaUnitario;
		
		$Comprobante['items'][] = $Item;
		
		$BdeImpuesto += ($DatBoletaDetalle->BdeImpuesto);
	}
}

$JnComprobante = json_encode($Comprobante);

if(round($InsBoleta->BolImpuesto,2) == round($BdeImpuesto,2)){
	
}else{
	echo "BolImpuesto: ".round($InsBoleta->BolImpuesto,2);
	echo "<br>";
	echo "BdeImpuesto: ".round($BdeImpuesto,2);
	echo "<br>";
	echo "error";
	exit();
}

//echo "BolImpuesto: ".round($InsBoleta->BolImpuesto,2);
//	echo "<br>";
//	echo "BdeImpuesto: ".round($BdeImpuesto,2);
//	echo "<br>";
//	echo "error";
/*
* CREANDO ARCHIVO
*/

if(file_exists("../../../creativa/".$EmpresaCodigo."-03-".$InsBoleta->BtaNumero."-".$InsBoleta->BolId.".json")){
	unlink("../../../creativa/".$EmpresaCodigo."-03-".$InsBoleta->BtaNumero."-".$InsBoleta->BolId.".json");
}

jbalog("../../../creativa/",$EmpresaCodigo."-03-".$InsBoleta->BtaNumero."-".$InsBoleta->BolId.".json",$JnComprobante);

//exit();

//
/*
* LLAMANDO WS
*/

//$client = new nusoap_client('http://179.43.96.147:8083/webservice1.asmx?wsdl','wsdl');
$client = new nusoap_client('http://179.43.96.147:8083/webservice1.asmx?wsdl','wsdl');



 $err = $client->getError();
if ($err) {	echo 'Error en Constructor' . $err ; }

$param = array('json' => utf8_encode($JnComprobante));
$result = $client->call('guardaBoletaElectronica', $param);
 
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

//if(guardaBoletaElectronicaResult['dt'])


//deb($result['guardaBoletaElectronicaResult']);
//deb($result['guardaBoletaElectronicaResult']['dt']);

if($result['guardaBoletaElectronicaResult']['dt']=="ok"){
	
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
$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaAccion","ALTA",$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaRespuesta",($MensajeRespuesta),$InsBoleta->BolId,$InsBoleta->BtaId);

echo json_encode($Resultado);
//if(json_last_error()
?>