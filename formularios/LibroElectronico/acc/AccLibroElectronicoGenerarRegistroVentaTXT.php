<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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

//if($_GET['P']==2){
//	header("Content-Type: text/html");
//	header("Content-Disposition:  filename=\"LE".$EmpresaCodigo.date('d-m-Y').".txt\";");
//}

$POST_Sucursal = ($_GET['Sucursal']);
$POST_Sucursal = "";

$POST_Ano = ($_GET['Ano']);
$POST_Mes = ($_GET['Mes']);


$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"FechaEmision";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";

$POST_Moneda = ($_GET['Moneda']);


require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsPago = new ClsPago();
$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsCliente = new ClsCliente();
$InsNotaCredito = new ClsNotaCredito();
$InsBoleta = new ClsBoleta();
$InsNotaDebito = new ClsNotaDebito();

$FechaInicio = "01/".$POST_Mes."/".$POST_Ano;
$FechaFin = FncCantidadDiaMes($POST_Ano,$POST_Mes)."/".$POST_Mes."/".$POST_Ano;



//$CantidadDias = FncCantidadDiaMes($POST_Ano,$POST_Mes);

//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL) 
$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"Fac".$POST_ord,$POST_sen,NULL,NULL,NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,NULL,NULL,NULL,NULL,$POST_Moneda,$POST_ClienteId,NULL,NULL,NULL,NULL,NULL,$POST_Personal);
$ArrFacturas = $ResFactura['Datos'];

//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL) {
$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,"Bol".$POST_ord,$POST_sen,NULL,NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,NULL,NULL,$POST_Moneda,NULL,$POST_ClienteId);
$ArrBoletas = $ResBoleta['Datos'];


//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL,$oClienteId=NULL)
$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"Ncr".$POST_ord,$POST_sen,1,NULL,NULL,NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,$POST_Moneda,NULL,NULL,NULL,$POST_ClienteId);
$ArrNotaCreditos = $ResNotaCredito['Datos'];


//MtdObtenerNotaDebitos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NdbId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL)
$ResNotaDebito = $InsNotaDebito->MtdObtenerNotaDebitos(NULL,NULL,NULL,"Ndb".$POST_ord,$POST_sen,1,NULL,NULL,NULL,FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,$POST_Moneda,NULL,NULL,NULL);
$ArrNotaDebitos = $ResNotaDebito['Datos'];



$NoTieneTipoCambio = false;

		$libro = "";

		$c=1;
		
		$FacturaSubTotal = 0;
		$FacturaImpuesto = 0;
		$FacturaTotal = 0;
		
		$FacturaAmortizadoTotal = 0;
		$FacturaSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalFacturaNoCancelada = 0;
		
        foreach($ArrFacturas as $DatFactura){
			
			$DatFactura->FacSubTotal = ($DatFactura->FacSubTotal/(empty($DatFactura->FacTipoCambio)?1:$DatFactura->FacTipoCambio));
			$DatFactura->FacImpuesto = ($DatFactura->FacImpuesto/(empty($DatFactura->FacTipoCambio)?1:$DatFactura->FacTipoCambio));
			$DatFactura->FacTotal = ($DatFactura->FacTotal/(empty($DatFactura->FacTipoCambio)?1:$DatFactura->FacTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatFactura->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatFactura->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatFactura->FacFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			if(!empty($DatFactura->FacTipoCambioAux)){
				$TipoCambio = $DatFactura->FacTipoCambioAux;
			}
			
			
			$DatFactura->FacSubTotal =  ($DatFactura->FacSubTotal*$TipoCambio);
			$DatFactura->FacImpuesto =  ($DatFactura->FacImpuesto*$TipoCambio);
			$DatFactura->FacTotal =  ($DatFactura->FacTotal*$TipoCambio);
			
			$DatFactura->FacTipoCambio = $TipoCambio;
			
			if($DatFactura->MonId<>$EmpresaMonedaId){
				if(empty($TipoCambio)){
					
					$NoTieneTipoCambio = true;
				}
			}
			
			if(empty($DatFactura->FacTipoCambio)){
				
				$DatFactura->FacTipoCambio = "1.000";
				
			}
			
			if(empty($DatFactura->FacFechaVencimiento)){
				
				$DatFactura->FacFechaVencimiento = "01/01/0001";
				
			}
	
			$DatFactura->FacSubTotal = number_format($DatFactura->FacSubTotal, 2, '.', '');
			$DatFactura->FacImpuesto = number_format($DatFactura->FacImpuesto, 2, '.', '');
			$DatFactura->FacTotal = number_format($DatFactura->FacTotal, 2, '.', '');
			
			$DatFactura->FacTotalDescuento = number_format($DatFactura->FacTotalDescuento, 2, '.', '');
			$DatFactura->FacTotalPagar = number_format($DatFactura->FacTotalPagar, 2, '.', '');
			$DatFactura->FacTotalExonerado = number_format($DatFactura->FacTotalExonerado, 2, '.', '');
			
				
			$Cliente = $DatFactura->CliApellidoPaterno." ".$DatFactura->CliApellidoMaterno." ".$DatFactura->CliNombre;
			$Cliente = trim($Cliente);
			$Cliente = substr($Cliente,0,100);
			
		
			
			$DatFactura->FacId = $DatFactura->FacId + 1 - 1;
			$DatFactura->TdoCodigo = $DatFactura->TdoCodigo + 1 - 1;
			
			
					
			$libro .= $POST_Ano.$POST_Mes."00"."|02|M".$c."|".$DatFactura->FacFechaEmision."|".(($DatFactura->FacFechaVencimiento))."|01|".$DatFactura->FtaNumero."|".$DatFactura->FacId."|"."|".$DatFactura->TdoCodigo."|".$DatFactura->CliNumeroDocumento."|".$Cliente."|0.00|".($DatFactura->FacSubTotal)."|".($DatFactura->FacTotalDescuento)."|".($DatFactura->FacImpuesto)."|0.00|".($DatFactura->FacTotalExonerado)."|0.00|0.00|0.00|0.00|0.00|".$DatFactura->FacTotalPagar."|".$DatFactura->MonSigla."|".$TipoCambio."|01/01/0001|00|-|-|||1|1|\n";
     
			$FacturaSubTotal += $DatFactura->FacSubTotal;
			$FacturaImpuesto += $DatFactura->FacImpuesto;
			$FacturaTotal += $DatFactura->FacTotal;
			
			
			$FacturaAmortizadoTotal += $ClientePagoMontoTotal;
			$FacturaSaldoTotal += $FacturaSaldo;
			
		$c++;
        }
      
	 
	  
		//$c=1;
		$BoletaSubTotal = 0;
		$BoletaImpuesto= 0;
		$BoletaTotal = 0;
		
		$BoletaAmortizadoTotal = 0;
		$BoletaSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalBoletaNoCancelada = 0;
		
        foreach($ArrBoletas as $DatBoleta){
			
			$DatBoleta->BolSubTotal = ($DatBoleta->BolSubTotal/(empty($DatBoleta->BolTipoCambio)?1:$DatBoleta->BolTipoCambio));
			$DatBoleta->BolImpuesto = ($DatBoleta->BolImpuesto/(empty($DatBoleta->BolTipoCambio)?1:$DatBoleta->BolTipoCambio));
			$DatBoleta->BolTotal = ($DatBoleta->BolTotal/(empty($DatBoleta->BolTipoCambio)?1:$DatBoleta->BolTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatBoleta->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatBoleta->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatBoleta->BolFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			
			if(!empty($DatBoleta->BolTipoCambioAux)){
				$TipoCambio = $DatBoleta->BolTipoCambioAux;
			}
			
			$DatBoleta->BolTipoCambio = $TipoCambio;
			
			if($DatBoleta->MonId<>$EmpresaMonedaId){
				if(empty($TipoCambio)){
					
					$NoTieneTipoCambio = true;
				}
			}
			
			
			
			if(empty($DatBoleta->BolTipoCambio)){
				
				$DatBoleta->BolTipoCambio = "1.000";
				
			}
			
			if(empty($DatBoleta->BolFechaVencimiento)){
				
				$DatBoleta->BolFechaVencimiento = "01/01/0001";
				
			}
			
			$DatBoleta->BolSubTotal = number_format($DatBoleta->BolSubTotal, 2, '.', '');
			$DatBoleta->BolImpuesto = number_format($DatBoleta->BolImpuesto, 2, '.', '');
			$DatBoleta->BolTotal = number_format($DatBoleta->BolTotal, 2, '.', '');
			
			$DatBoleta->BolTotalDescuento = number_format($DatBoleta->BolTotalDescuento, 2, '.', '');
			$DatBoleta->BolTotalPagar = number_format($DatBoleta->BolTotalPagar, 2, '.', '');
			$DatBoleta->BolTotalExonerado = number_format($DatBoleta->BolTotalExonerado, 2, '.', '');
			
			$Cliente = $DatBoleta->CliApellidoPaterno." ".$DatBoleta->CliApellidoMaterno." ".$DatBoleta->CliNombre;
			$Cliente = trim($Cliente);
			$Cliente = substr($Cliente,0,100);
			
			$DatBoleta->BolId = $DatBoleta->BolId + 1 - 1;
			$DatBoleta->TdoCodigo = $DatBoleta->TdoCodigo + 1 - 1;
			
			$libro .= $POST_Ano.$POST_Mes."00"."|02|M".$c."|".$DatBoleta->BolFechaEmision."|".(($DatBoleta->BolFechaVencimiento))."|03|".$DatBoleta->BtaNumero."|".$DatBoleta->BolId."|"."|".$DatBoleta->TdoCodigo."|".$DatBoleta->CliNumeroDocumento."|".$Cliente."|0.00|".($DatBoleta->BolSubTotal)."|".($DatBoleta->BolTotalDescuento)."|".($DatBoleta->BolImpuesto)."|0.00|".($DatBoleta->BolTotalExonerado)."|0.00|0.00|0.00|0.00|0.00|".$DatBoleta->BolTotalPagar."|".$DatBoleta->MonSigla."|".$DatBoleta->BolTipoCambio."|01/01/0001|00|-|-|||1|1|\n";
			 
			 
			$BoletaSubTotal += $DatBoleta->BolSubTotal;
			$BoletaImpuesto += $DatBoleta->BolImpuesto;
			$BoletaTotal += $DatBoleta->BolTotal;
			
			$BoletaAmortizadoTotal += $ClientePagoMontoTotal;
			$BoletaSaldoTotal += $BoletaSaldo;
			
		$c++;
        }
		
		
       
		//$c=1;
		$NotaCreditoSubTotal = 0;
		$NotaCreditoImpuesto = 0;
		$NotaCreditoTotal = 0;
		
		$NotaCreditoAmortizadoTotal = 0;
		$NotaCreditoSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalNotaCreditoNoCancelada = 0;
		
        foreach($ArrNotaCreditos as $DatNotaCredito){
			
			$DatNotaCredito->NcrSubTotal = ($DatNotaCredito->NcrSubTotal/(empty($DatNotaCredito->NcrTipoCambio)?1:$DatNotaCredito->NcrTipoCambio));
			$DatNotaCredito->NcrImpuesto = ($DatNotaCredito->NcrImpuesto/(empty($DatNotaCredito->NcrTipoCambio)?1:$DatNotaCredito->NcrTipoCambio));
			$DatNotaCredito->NcrTotal = ($DatNotaCredito->NcrTotal/(empty($DatNotaCredito->NcrTipoCambio)?1:$DatNotaCredito->NcrTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatNotaCredito->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatNotaCredito->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaCredito->NcrFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
			
			
			if(!empty($DatNotaCredito->NcrTipoCambioAux)){
				$TipoCambio = $DatNotaCredito->NcrTipoCambioAux;
			}
			
			$DatNotaCredito->NcrTipoCambio = $TipoCambio;
			
			if($DatNotaCredito->MonId<>$EmpresaMonedaId){
				if(empty($TipoCambio)){
					
					$NoTieneTipoCambio = true;
				}
			}
						
			if(empty($DatNotaCredito->NcrTipoCambio)){
				
				$DatNotaCredito->NcrTipoCambio = "1.000";
				
			}
			
			if(empty($DatNotaCredito->NcrFechaVencimiento)){
				
				$DatNotaCredito->NcrFechaVencimiento = "01/01/0001";
				
			}
			
			
			
			$DatNotaCredito->NcrTotal = ($DatNotaCredito->NcrTotal*-1);
			$DatNotaCredito->NcrSubTotal = ($DatNotaCredito->NcrSubTotal*-1);
			$DatNotaCredito->NcrImpuesto = ($DatNotaCredito->NcrImpuesto*-1);
			
			$DatNotaCredito->NcrTotalDescuento = ($DatNotaCredito->NcrTotalDescuento*-1);
			$DatNotaCredito->NcrTotalPagar = ($DatNotaCredito->NcrTotalPagar*-1);
			$DatNotaCredito->NcrTotalExonerado = ($DatNotaCredito->NcrTotalExonerado*-1);
			
			
			$DatNotaCredito->NcrTotal = number_format($DatNotaCredito->NcrTotal, 2, '.', '');
			$DatNotaCredito->NcrSubTotal = number_format($DatNotaCredito->NcrSubTotal, 2, '.', '');
			$DatNotaCredito->NcrImpuesto = number_format($DatNotaCredito->NcrImpuesto, 2, '.', '');
			
			$DatNotaCredito->NcrTotalDescuento = number_format($DatNotaCredito->NcrTotalDescuento, 2, '.', '');
			$DatNotaCredito->NcrTotalPagar = number_format($DatNotaCredito->NcrTotalPagar, 2, '.', '');
			$DatNotaCredito->NcrTotalExonerado = number_format($DatNotaCredito->NcrTotalExonerado, 2, '.', '');
			
			
			$Cliente = $DatNotaCredito->CliApellidoPaterno." ".$DatNotaCredito->CliApellidoMaterno." ".$DatNotaCredito->CliNombre;
			$Cliente = trim($Cliente);
			$Cliente = substr($Cliente,0,100);
			
			$DatNotaCredito->NcrId = $DatNotaCredito->NcrId + 1 - 1;
			$DatNotaCredito->TdoCodigo = $DatNotaCredito->TdoCodigo + 1 - 1;
			

			$libro .= $POST_Ano.$POST_Mes."00"."|02|M".$c."|".$DatNotaCredito->NcrFechaEmision."|".$DatNotaCredito->NcrFechaVencimiento."|07|".$DatNotaCredito->NctNumero."|".$DatNotaCredito->NcrId."|"."|".$DatNotaCredito->TdoCodigo."|".$DatNotaCredito->CliNumeroDocumento."|".$Cliente."|0.00|".($DatNotaCredito->NcrSubTotal)."|".($DatNotaCredito->NcrTotalDescuento)."|".($DatNotaCredito->NcrImpuesto)."|0.00|".($DatNotaCredito->NcrTotalExonerado)."|0.00|0.00|0.00|0.00|0.00|".$DatNotaCredito->NcrTotalPagar."|".$DatNotaCredito->MonSigla."|".$DatNotaCredito->NcrTipoCambio."|".$DatNotaCredito->DocFechaEmision."|".$DatNotaCredito->DocTipoDocumentoCodigo."|".$DatNotaCredito->DtaNumero."|".$DatNotaCredito->DocId."|||1|1|\n";
     		
			$NotaCreditoSubTotal += $DatNotaCredito->NcrSubTotal;
			$NotaCreditoImpuesto += $DatNotaCredito->NcrImpuesto;
			$NotaCreditoTotal += $DatNotaCredito->NcrTotal;
			
			$NotaCreditoAmortizadoTotal += $ClientePagoMontoTotal;
			$NotaCreditoSaldoTotal += $NotaCreditoSaldo;
			
		$c++;
        }




			
						//$c=1;
		$NotaDebitoSubTotal = 0;
		$NotaDebitoImpuesto = 0;
		$NotaDebitoTotal = 0;
		
		$NotaDebitoAmortizadoTotal = 0;
		$NotaDebitoSaldoTotal = 0;
		
		$TotalCredito30 = 0;
		$TotalCredito30Mas = 0;
		$TotalContado = 0;
		$TotalNotaDebitoNoCancelada = 0;
		
        foreach($ArrNotaDebitos as $DatNotaDebito){
			
			
				
			$DatNotaDebito->NdbSubTotal = ($DatNotaDebito->NdbSubTotal/(empty($DatNotaDebito->NdbTipoCambio)?1:$DatNotaDebito->NdbTipoCambio));
			$DatNotaDebito->NdbImpuesto = ($DatNotaDebito->NdbImpuesto/(empty($DatNotaDebito->NdbTipoCambio)?1:$DatNotaDebito->NdbTipoCambio));
			$DatNotaDebito->NdbTotal = ($DatNotaDebito->NdbTotal/(empty($DatNotaDebito->NdbTipoCambio)?1:$DatNotaDebito->NdbTipoCambio));
			
			$TipoCambio = NULL;
			
			if($DatNotaDebito->MonId<>$EmpresaMonedaId){
				
				$InsTipoCambio = new ClsTipoCambio();
				$InsTipoCambio->MonId = $DatNotaDebito->MonId;
				$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($DatNotaDebito->NdbFechaEmision);
				$InsTipoCambio->MtdObtenerTipoCambioFecha();
				
				$TipoCambio = $InsTipoCambio->TcaMontoVenta;
				
			}
		
			if(!empty($DatNotaDebito->NdbTipoCambioAux)){
				$TipoCambio = $DatNotaDebito->NdbTipoCambioAux;
			}

			$DatNotaDebito->NdbTipoCambio = $TipoCambio;
			
	if($DatNotaDebito->MonId<>$EmpresaMonedaId){
				if(empty($TipoCambio)){
					
					$NoTieneTipoCambio = true;
				}
			}

		

			
			if(empty($DatNotaDebito->NdbTipoCambio)){
				
				$DatNotaDebito->NdbTipoCambio = "1.000";
				
			}
			
			if(empty($DatNotaDebito->NdbFechaVencimiento)){
				
				$DatNotaDebito->NdbFechaVencimiento = "01/01/0001";
				
			}
			
			$DatNotaDebito->NdbTotal = number_format($DatNotaDebito->NdbTotal, 2, '.', '');
			$DatNotaDebito->NdbSubTotal = number_format($DatNotaDebito->NdbSubTotal, 2, '.', '');
			$DatNotaDebito->NdbImpuesto = number_format($DatNotaDebito->NdbImpuesto, 2, '.', '');
			
			$DatNotaDebito->NdbTotalDescuento = number_format($DatNotaDebito->NdbTotalDescuento, 2, '.', '');
			$DatNotaDebito->NdbTotalPagar = number_format($DatNotaDebito->NdbTotalPagar, 2, '.', '');
			$DatNotaDebito->NdbTotalExonerado = number_format($DatNotaDebito->NdbTotalExonerado, 2, '.', '');
			
			
			$Cliente = $DatNotaDebito->CliApellidoPaterno." ".$DatNotaDebito->CliApellidoMaterno." ".$DatNotaDebito->CliNombre;
			$Cliente = trim($Cliente);
			$Cliente = substr($Cliente,0,100);
			
			$DatNotaDebito->NdbId = $DatNotaDebito->NdbId + 1 - 1;
			$DatNotaDebito->TdoCodigo = $DatNotaDebito->TdoCodigo + 1 - 1;
			
			
			
			
			
			$libro .= $POST_Ano.$POST_Mes."00"."|02|M".$c."|".$DatNotaDebito->NdbFechaEmision."|".$DatNotaDebito->NdbFechaVencimiento."|08|".$DatNotaDebito->NctNumero."|".$DatNotaDebito->NdbId."|"."|".$DatNotaDebito->TdoCodigo."|".$DatNotaDebito->CliNumeroDocumento."|".$Cliente."|0.00|".($DatNotaDebito->NdbSubTotal)."|".($DatNotaDebito->NdbTotalDescuento)."|".($DatNotaDebito->NdbImpuesto)."|0.00|".($DatNotaDebito->NdbTotalExonerado)."|0.00|0.00|0.00|0.00|0.00|".$DatNotaDebito->NdbTotalPagar."|".$DatNotaDebito->MonSigla."|".$DatNotaDebito->NdbTipoCambio."|".$DatNotaDebito->DocFechaEmision."|".$DatNotaDebito->DocTipoDocumentoCodigo."|".$DatNotaDebito->DtaNumero."|".$DatNotaDebito->DocId."|||1|1|\n";
     	
			
			$NotaDebitoSubTotal += $DatNotaDebito->NdbSubTotal;
			$NotaDebitoImpuesto += $DatNotaDebito->NdbImpuesto;
			$NotaDebitoTotal += $DatNotaDebito->NdbTotal;
			
			$NotaDebitoAmortizadoTotal += $ClientePagoMontoTotal;
			$NotaDebitoSaldoTotal += $NotaDebitoSaldo;
			
		$c++;
        }
		
		

if($NoTieneTipoCambio){
	$libro = "Una de las filas no tiene tipo de cambio";
}


$NombreArchivo = "LE".$EmpresaCodigo.$POST_Ano.$POST_Mes."00"."140100"."00"."1"."1"."1"."1".".txt";
$Ruta = '../../../generados/libros_electronicos/';

if(file_exists($Ruta.''.$NombreArchivo)){
	unlink($Ruta.''.$NombreArchivo);
}

$ddf = fopen($Ruta.''.$NombreArchivo,'a');
fwrite($ddf,$libro);
fclose($ddf);
//	
$nombre_archivo = basename($Ruta.''.$NombreArchivo);
header("Content-disposition: attachment; filename=".$NombreArchivo);
header("Content-type: application/octet-stream");
readfile($Ruta.''.$NombreArchivo);	

?>