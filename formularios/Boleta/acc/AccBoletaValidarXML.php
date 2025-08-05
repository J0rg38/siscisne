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
		
	}
}

$JnComprobante = json_encode($Comprobante);

/*
* CREANDO ARCHIVO
*/

jbalog("../../../creativa/",$EmpresaCodigo."-03-".$InsBoleta->BtaNumero."-".$InsBoleta->BolId.".json",$JnComprobante);


/*
* LLAMANDO WS
*/
 
echo json_encode($Resultado);
 
?>
<script type="text/javascript">

$().ready(function() {

	$('#CapBoletaAccion').html('Generando archivo xml...');	
	
	$.ajax({
		type: 'POST',
		crossDomain: true,
		dataType: 'json',
			xhrFields: {
                withCredentials: true
            },
		url: 'https://api.facturaonline.pe/factura/test',
		data: 'Authorization=82f0f9cfffb10f57ad5b71505e53acffcc57936897528a5c39637c72907793db:e6539282bee939db6693921840c5872619b11d08a4371c63dbf4636465463ca2:<?php echo time();?>',
		
		success: function(respuesta){
		
									
		}
	});

});


</script>