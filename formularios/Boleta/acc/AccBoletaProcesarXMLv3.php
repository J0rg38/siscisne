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


if(count($InsBoleta->OrdenVentaVehiculoPropietario)>1){

				$Propietarios = " / ";
		
				foreach($InsBoleta->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($InsBoleta->CliId<> $DatOrdenVentaVehiculoPropietario->CliId){
		
						$Propietarios .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno."";		
						
						//if(count($InsBoleta->OrdenVentaVehiculoPropietario)-1!=$i){
//							$Propietarios .= " * ";
//						}
						
						$i++;
		
					}			
				}		
				
		
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
//$Comprobante['user'] = "zbwduser";
//$Comprobante['password'] = "njuzqgc";

$MiComprobante = array();

$Comprobante['tipoOperacion'] = "0101";
$Comprobante['serie'] = ($InsBoleta->BtaNumero);
$Comprobante['numero'] = (int) ($InsBoleta->BolId);

$Comprobante['importeTotal'] = (float)round($InsBoleta->BolTotal,2);

$Comprobante['totalVentaGravada'] = (float)round($InsBoleta->BolSubTotal,2);
$Comprobante['totalDescuento'] = (float)round($InsBoleta->BolTotalDescuento,2);
$Comprobante['totalVentaGratuita'] = (float)round($InsBoleta->BolTotalGratuito,2);

$Comprobante['montoTotalImpuestos'] = (float)round($InsBoleta->BolImpuesto,2);
$Comprobante['sumatoriaIgv'] = (float)round($InsBoleta->BolImpuesto,2);
$Comprobante['sumatoriaIsc'] = (float)round($InsBoleta->BolTotalImpuestoSelectivo,2);



  
  
$Comprobante['adicional']	= array();

$Adicional['fechaVencimiento'] = FncCambiaFechaAMysql((empty($InsBoleta->BolFechaVencimiento)?$InsBoleta->BolFechaEmision:$InsBoleta->BolFechaVencimiento),true);
$Adicional['condPago'] = ($InsBoleta->NpaNombre);
$Adicional['OrderReference'] = ($InsBoleta->FinId."".$InsBoleta->OvvId);
//$Adicional['codigoSunatEstablecimiento'] = "0000";

$Comprobante['adicional'] = $Adicional;

$Comprobante['fechaEmision'] = FncCambiaFechaAMysql($InsBoleta->BolFechaEmision);
$Comprobante['horaEmision'] = ($InsBoleta->BolHoraEmision);
$Comprobante['tipoMoneda'] = ($InsBoleta->MonSigla);


//$Receptor['tipo'] = round($InsBoleta->TdoCodigo,0);
//$Receptor['nro'] = $InsBoleta->CliNumeroDocumento;
//$Receptor['razonSocial'] =  $InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno ." ".$Propietarios;

$Receptor['tipo'] = 0;
$Receptor['nro'] = 0;
$Receptor['razonSocial'] =  "";

$Comprobante['receptor'] = $Receptor;

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
		
		$Item['unidadMedidaCantidad']	= $DatBoletaDetalle->BdeUnidadMedidaCodigo;
		
		$Item['cantidad']	= round($DatBoletaDetalle->BdeCantidad,2);
		$Item['descripcion']	= (string) trim($DatBoletaDetalle->BdeDescripcion);
		
		$Item['valorUnitario']	= round($DatBoletaDetalle->BdeValorVentaUnitario,2);
		$Item['precioVentaUnitario']	= round($DatBoletaDetalle->BdePrecio,2);
	
		if($DatBoletaDetalle->BdeGratuito == "1"){//20
			$tipoPrecioVentaUnitario = "02";
		}else{
			$tipoPrecioVentaUnitario = "01";
		}
		
		$Item['tipoPrecioVentaUnitario'] = $tipoPrecioVentaUnitario;
		
		$Item['montoTotalImpuestosItem']	=  round($DatBoletaDetalle->BdeImpuesto,2);
		
		$Item['baseAfectacionIgv']	= round($DatBoletaDetalle->BdeValorVenta,2);
		$Item['montoAfectacionIgv']	=  round($DatBoletaDetalle->BdeImpuesto,2);
		
		$Item['porcentajeImpuesto']	=  round($InsBoleta->BolPorcentajeImpuestoVenta,2);
	
		$codigoTributo = "0000";
		
		if($DatBoletaDetalle->BdeExonerado == "1"){//20						  
			
			if($DatBoletaDetalle->BdeGratuito == "1"){//20						  								
				
				$codigoTributo = "9996";
				$afectacionIgv = "21";	
			
			}else{							  
				
				$codigoTributo = "9997";
				$afectacionIgv = "20";
			
			}	
				
		}else if($DatBoletaDetalle->BdeExonerado == "2"){//10
			
			if($DatBoletaDetalle->BdeGratuito == "1"){//20	
			
				$codigoTributo = "9996";	  	
				$afectacionIgv = "11";						  	

			}else{	
			
				$codigoTributo = "1000";					  
				$afectacionIgv = "10";							  
				
			}
			
		}else{
			
			$codigoTributo = "0000";
			$afectacionIgv = "00";	
			
		}
					  
		$Item['tipoAfectacionIgv']	= $afectacionIgv;
		
		$Item['codigoTributo']	= $codigoTributo;
		$Item['valorVenta']	= round($DatBoletaDetalle->BdeValorVenta,2);
		
		$Item['codigoProducto']	= $DatBoletaDetalle->BdeCodigo;
		
		$Item['adicional']	= array();
		
		$Comprobante['items'][] = $Item;
		
		//$BdeImpuesto += ($DatBoletaDetalle->BdeImpuesto);
	}
}


//$MiComprobante['Boleta'] = $Comprobante;


//$JnComprobante = json_encode($MiComprobante);
//$JnComprobante = json_encode($Comprobante);

//
//$json = '{"tipoOperacion":"0101","fechaEmision":"2019-07-05","serie":"B001","numero":4,"totalVentaGravada":0.00,"totalVentaInafecta":0.00,"totalVentaExportacion":0.00,"totalVentaExonerada":30.00,"sumatoriaIgv":0.00,"sumatoriaIsc":0.00,"importeTotal":30.00,"tipoMoneda":"PEN","descuentoGlobal":0.00,"totalDescuento":0.00,"porcentajeDescuentoGlobal":0.00,"totalVentaGratuita":0.00,"sumatoriaOtrosCargos":0.00,"horaEmision":"14:17:04","tipoOperacion":"0101","montoTotalImpuestos":0.00,"adicional": {"fechaVencimiento":"2019-06-01","condPago":"CREDITO","OrderReference":"","extras": [{"key":"Observaciones","value":""}]},"receptor": {"tipo":"0","nro":"0","razonSocial":"CLIENTES VARIOS"},"items": [{"precioUnitario":30.00,"cantidad":1.000,"descripcion":"SERV. DE TELECABLE TV1","valorVenta":30.00,"valorUnitario":30.00,"precioVentaUnitario":30.00,"montoAfectacionIgv":0.00,"tipoAfectacionIgv":"20","codigoProducto":"003","unidadMedidaCantidad":"NIU","descuento":0.00,"porcentajeDescuento":0.00,"tipoPrecioVentaUnitario":"01","montoTotalImpuestosItem":0.00,"baseAfectacionIgv":30.00,"porcentajeImpuesto":18.00000,"codigoTributo":"9997"}]}';
//
//$json = str_replace(" ","",$json);
//$json = str_replace("\n","",$json);
//$json = utf8_encode($json);

//$JnComprobante = ($json);
//$JnComprobante = ($JnComprobante);


//$JnComprobante = utf8_encode($JnComprobante );
//$JnComprobante = ($Comprobante );

//if(round($InsBoleta->BolImpuesto,2) == round($BdeImpuesto,2)){
//	
//}else{
//	echo "BolImpuesto: ".round($InsBoleta->BolImpuesto,2);
//	echo "<br>";
//	echo "BdeImpuesto: ".round($BdeImpuesto,2);
//	echo "<br>";
//	echo "error";
//	exit();
//}

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


//Ak: bdbb0520341d9703e8a2b5a8246e481277fa7b7912783a341eb6943a3970c912
//Sk: 1590de846f634d54b1f664bcb077dbf1d7311c757e751bcbec15f20a2729551b

//$ACCESSKEY = "bdbb0520341d9703e8a2b5a8246e481277fa7b7912783a341eb6943a3970c912";
//$SECRETKEY = "1590de846f634d54b1f664bcb077dbf1d7311c757e751bcbec15f20a2729551b";
//$TIMESTAMP = time();
//$SIGNATURE = hash_hmac('sha256', $ACCESSKEY."|".$TIMESTAMP, $SECRETKEY);
$ACCESSKEY = "5c20fd93432359010c7154bb073fc4896d30373d8683d1c4a02bf8df3bac6b9d";
$SECRETKEY = "6c53dc60031a84539b09aa5b89485fe481f58742ac15a3ec8cb2a84f7f9cd830";
$TIMESTAMP = time();
$SIGNATURE = hash_hmac('sha256', $ACCESSKEY."|".$TIMESTAMP, $SECRETKEY);

$POST_URL = "https://demoapi2.facturaonline.pe/boleta?accessKey=".$ACCESSKEY."&signature=".$SIGNATURE."&timestamp=".$TIMESTAMP;

//echo "I CURL";
//echo 'Authorization: Fo '.$ACCESSKEY.':'.$SIGNATURE.':'.$TIMESTAMP   ;

// abrimos la sesión cURL
$ch = curl_init($POST_URL);

$data = array("Boleta" => $Comprobante);                                                                    
$data_string = json_encode($data);                                                                                   

//$data_string2 = base64_encode($JnComprobante);
//Authorization:Fo acessKey:signature:timestamp
// definimos la URL a la que hacemos la petición
//curl -k https://demoapi2.facturaonline.pe/usuario?accessKey=ACCESS_KEY&signature=SIGNATURE&secretKey=SECRET_KEY
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
//curl_setopt($ch, CURLOPT_URL,$POST_URL);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);   
//curl_setopt($ch, CURLOPT_URL,"https://demoapi2.facturaonline.pe/usuario?accessKey=".$ACCESSKEY."&signature=".$SIGNATURE."&secretKey=".$SECRETKEY);

// indicamos el tipo de petición: POST
//curl_setopt($ch, CURLOPT_POST, TRUE);
/*
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	//    'Authorization: Fo '.$ACCESSKEY.':'.$SIGNATURE.':'.$TIMESTAMP  
	//'Content-type: application/json', 
	//'Authorization: Fo 924ee4b:4926c116310de755dc:1520444337'
	'Authorization: Fo '.$ACCESSKEY.':'.$SIGNATURE.':'.$TIMESTAMP  
	));
*/
// definimos cada uno de los parámetros
//curl_setopt($ch, CURLOPT_POSTFIELDS, "Boleta=".$JnComprobante);
//curl_setopt($ch, CURLOPT_POSTFIELDS, "Boleta=".$JnComprobante);

//$field = array('Boleta' => $JnComprobante);

//curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
//curl_setopt($ch, CURLOPT_POSTFIELDS, "Boleta=".$JnComprobante);
//echo $JnComprobante;


 
// recibimos la respuesta y la guardamos en una variable

/*curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
   // 'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($JnComprobante))                                                                       
);  */  
$remote_server_output = curl_exec ($ch);
 
// cerramos la sesión cURL
curl_close ($ch);
 
// hacemos lo que queramos con los datos recibidos
// por ejemplo, los mostramos
//print_r($remote_server_output);
echo ($remote_server_output);

//echo "F CURL";

//
//$Resultado["MensajeRespuesta"] = ($MensajeRespuesta);
//$Resultado["CodigoRespuesta"] = ($CodigoRespuesta);
//
//echo json_encode($Resultado);
//if(json_last_error()
?>