<?php
session_start();

//session_destroy();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}


require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

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

//$FechaHoy = date("d/m/Y");
//$FechaHoy = $FechaHoy."";
//// $FechaVencimiento = date("d/m/Y",strtotime($_POST['CmpFechaEmision']." + ".$InsFactura->FacCantidadDia." days"));
//$FechaInicio = strtotime('- 2 day', strtotime($FechaHoy));;
//$FechaInicio = date('d/m/Y', $FechaInicio);
//


$FechaHoy = date("d-m-Y");

$FechaInicio  = date("d/m/Y",strtotime($FechaHoy."- 3 days")); 

$POST_Enviar = $_GET['Enviar'];
//$POST_FechaInicio = (empty($_GET['FechaInicio'])?"01/".date("m")."/".date("Y"):$_GET['FechaInicio']);
$POST_FechaInicio = (empty($_GET['FechaInicio'])?$FechaInicio:$_GET['FechaInicio']);
$POST_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

//$POST_Fecha = (empty($_GET['Fecha'])?date("d/m/Y"):$_GET['Fecha']);

$POST_Sucursal = $_GET['Sucursal'];

 

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqReporte().'ClsReportePago.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteComprobanteVenta.php');

$InsFactura = new ClsFactura();
$InsPago = new ClsPago();
$InsBoleta = new ClsBoleta();
$InsSucursal = new ClsSucursal();
$InsReportePago = new ClsReportePago();
$InsReporteComprobanteVenta = new ClsReporteComprobanteVenta();


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];





$mensaje .= "<b>PROCESANDO COMPROBANTES CANCELADOS</b>";	
$mensaje .= "<br>";	
 
$i = 1;		
		
$mensaje .= "<table cellpadding='4' cellspacing='0' width='100%' border='1'>";

$mensaje .= "<tr>";

	$mensaje .= "<td width='2%'>";
	$mensaje .= "<b>#</b>";
	$mensaje .= "</td>";

	$mensaje .= "<td width='8%'>";
	$mensaje .= "<b>Sucursal</b>";
	$mensaje .= "</td>";

	$mensaje .= "<td width='8%'>";
	$mensaje .= "<b>Comprobante</b>";
	$mensaje .= "</td>";

	$mensaje .= "<td width='5%'>";
	$mensaje .= "<b>Fecha</b>";
	$mensaje .= "</td>";
	
	$mensaje .= "<td>";
	$mensaje .= "<b>Cliente</b>";
	$mensaje .= "</td>";

	$mensaje .= "<td width='5%'>";
	$mensaje .= "<b>Moneda</b>";
	$mensaje .= "</td>";
	
	$mensaje .= "<td width='5%'>";
	$mensaje .= "<b>Total</b>";
	$mensaje .= "</td>";
	
	$mensaje .= "<td width='5%'>";
	$mensaje .= "<b>N. Cred.</b>";
	$mensaje .= "</td>";
	
	$mensaje .= "<td width='5%'>";
	$mensaje .= "<b>Amortizado</b>";
	$mensaje .= "</td>";
	
	$mensaje .= "<td width='5%'>";
	$mensaje .= "<b>Otros</b>";
	$mensaje .= "</td>";
	
	$mensaje .= "<td width='5%'>";
	$mensaje .= "<b>Fecha Vencimiento</b>";
	$mensaje .= "</td>";

	$mensaje .= "<td width='5%'>";
	$mensaje .= "<b>Dias/Cred.</b>";
	$mensaje .= "</td>";

	//$mensaje .= "<td width='5%'>";
	//$mensaje .= "<b>Dias/Transc.</b>";
	//$mensaje .= "</td>";
	
	$mensaje .= "<td width='10%'>";
	$mensaje .= "<b>Estado</b>";
	$mensaje .= "</td>";
	
	$mensaje .= "<td width='10%'>";
	$mensaje .= "<b>Vencimiento</b>";
	$mensaje .= "</td>";
	
	
		$mensaje .= "<td width='10%'>";
	$mensaje .= "<b>Formula</b>";
	$mensaje .= "</td>";

$mensaje .= "</tr>";


if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){

		//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL,$oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL)
		$ResFactura = $InsReporteComprobanteVenta->MtdObtenerFacturas(NULL,NULL,NULL,"FacTiempoCreacion","DESC","100",NULL,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatSucursal->SucId,$MostrarNoProcesados,$POST_Cancelado);
		$ArrFacturas = $ResFactura['Datos'];
		
		//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL)
		$ResBoleta = $InsReporteComprobanteVenta->MtdObtenerBoletas( NULL,NULL,NULL,"BolTiempoCreacion","DESC","100","5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,$POST_npago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,$DatSucursal->SucId,$MostrarNoProcesados,$POST_Cancelado);
		$ArrBoletas = $ResBoleta['Datos'];


		if(!empty($ArrFacturas)){
			foreach($ArrFacturas as $DatFactura){
			
				 					
				if($DatFactura->MonId<>$EmpresaMonedaId){
					$DatFactura->FacTotal = round($DatFactura->FacTotal / $DatFactura->FacTipoCambio,2);
				}
				
				//OTROS PAGOS
				$ClientePagoMontoTotalOtro = 0;
				
				if(!empty($DatFactura->OvvId)){
					
					$InsPago = new ClsPago();
					$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","10",3,NULL,$DatFactura->OvvId,$POST_CondicionPago,$DatFactura->MonId);
					$ArrPagos = $ResPago['Datos'];
					
					if(!empty($ArrPagos)){
						foreach($ArrPagos as $DatPago){
							
							if($DatPago->MonId<>$EmpresaMonedaId){
								$DatPago->PagMonto = round($DatPago->PagMonto / $DatPago->PagTipoCambio,2);
							}
							
							$ClientePagoMontoTotalOtro += $DatPago->PagMonto;
							
						}
					}
					
				}else if($DatFactura->VdiId){
					
										
					$InsPago = new ClsPago();
					//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
					$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","10","1,3",$DatFactura->VdiId,NULL,$POST_CondicionPago,$DatFactura->MonId);
					$ArrPagos = $ResPago['Datos'];
					
					if(!empty($ArrPagos)){
						foreach($ArrPagos as $DatPago){
							
							if($DatPago->MonId<>$EmpresaMonedaId){
								$DatPago->PagMonto = round($DatPago->PagMonto / $DatPago->PagTipoCambio,2);
							}
							
							$ClientePagoMontoTotalOtro += $DatPago->PagMonto;
							
						}
					}
					
				}
				
				//PAGOS COMPROBANTES
				
				//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0,$oNoTieneComprobante=false,$oNoTieneComprobanteEstricto=false) 
				$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","10",3,NULL,NULL,NULL,$DatFactura->MonId,$DatFactura->FacId,$DatFactura->FtaId,NULL,NULL,NULL,NULL,NULL,"PagFecha",NULL);
				$ArrPagos = $ResPago['Datos'];
	
				
				$ClientePagoMontoTotal = 0;
				
				if(!empty($ArrPagos)){
					foreach($ArrPagos as $DatPago){
							
						if($DatPago->MonId<>$EmpresaMonedaId){
							$DatPago->PagMonto = round($DatPago->PagMonto / $DatPago->PagTipoCambio,2);
						}
						
						$ClientePagoMontoTotal += $DatPago->PagMonto;
								
					}
				}
			
				//NOTAS DE CREDITO
				
				$TotalNotaCredito = 0;
				$InsNotaCredito = new ClsNotaCredito();
				//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL) {
					
				$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrId","ASC",1,"10",NULL,5,NULL,NULL,NULL,$DatFactura->MonId,$DatFactura->FacId,$DatFactura->FtaId);
				$ArrNotaCreditos = $ResNotaCredito['Datos'];
				
				if(!empty($ArrNotaCreditos)){
					foreach($ArrNotaCreditos as $DatNotaCredito){
				 			
						if($DatNotaCredito->MonId<>$EmpresaMonedaId){
							$DatNotaCredito->NcrTotal = round($DatNotaCredito->NcrTotal / $DatNotaCredito->NcrTipoCambio,2);
						}
						
						
						$TotalNotaCredito += $DatNotaCredito->NcrTotal;
						
					}
				}
		
		
				$Dias = $DatFactura->FacCantidadDia - $DatFactura->FacDiaTranscurrido;
				
				//if($Dias<=$oCantidadDia){
					
											
				settype($DatFactura->FacTotal ,"float");
				settype($ClientePagoMontoTotal ,"float");
				settype($TotalNotaCredito ,"float");
				
				$DatFactura->FacTotal = round($DatFactura->FacTotal,2);
				$ClientePagoMontoTotal = round($ClientePagoMontoTotal,2);
				$TotalNotaCredito = round($TotalNotaCredito,2);
				
				$SeCancelo = "";
				
				//if( (($ClientePagoMontoTotal+500) + ($TotalNotaCredito+500) )>= ($DatFactura->FacTotal+1000)){
				if( (($ClientePagoMontoTotal) + ($TotalNotaCredito) + ($ClientePagoMontoTotalOtro) )>= ($DatFactura->FacTotal)){
					$SeCancelo = "CANCELADO";
				}else{
					$SeCancelo = "SIN CANCELAR";
				}
							
				$Formula = "ClientePagoMontoTotal: ".$ClientePagoMontoTotal." + TotalNotaCredito: ".$TotalNotaCredito." + ClientePagoMontoTotalOtro: ".$ClientePagoMontoTotalOtro." MAYOR IGUAL FacTotal: ".$DatFactura->FacTotal;
				
				if($SeCancelo=="CANCELADO"){
					//MtdEditarFacturaCancelado($oId,$oTalonario,$oCancelado) 
					$InsFactura->MtdEditarFacturaCancelado($DatFactura->FacId,$DatFactura->FtaId,1);
				}else{
					//MtdEditarFacturaCancelado($oId,$oTalonario,$oCancelado) 
					$InsFactura->MtdEditarFacturaCancelado($DatFactura->FacId,$DatFactura->FtaId,2);
				}
			 
			 
						$mensaje .= "<tr>";
									
							$mensaje .= "<td>";
							$mensaje .= $i;
							$mensaje .= "</td>";
										
							$mensaje .= "<td>";
							$mensaje .= $DatFactura->PagId."/".$DatFactura->SucNombre;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatFactura->FtaNumero."-".$DatFactura->FacId;
							$mensaje .= "</td>";
										
			
							$mensaje .= "<td>";
							$mensaje .= $DatFactura->FacFechaEmision;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatFactura->CliNombre." ".$DatFactura->CliApellidoPaterno." ".$DatFactura->CliApellidoMaterno;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatFactura->MonSimbolo;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= number_format($DatFactura->FacTotal,2);
							$mensaje .= "</td>";
						
						
							$mensaje .= "<td>";
							$mensaje .= number_format($TotalNotaCredito	,2);
							$mensaje .= "</td>";
							
							
							$mensaje .= "<td>";
							$mensaje .= number_format($ClientePagoMontoTotal,2);
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= number_format($ClientePagoMontoTotalOtro,2);
							$mensaje .= "</td>";
							
							
							$mensaje .= "<td>";
							$mensaje .= $DatFactura->FacFechaVencimiento;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatFactura->FacCantidadDia;
							$mensaje .= "</td>";
			
							//$mensaje .= "<td>";
							//$mensaje .= $DatFactura->FacDiaTranscurrido;
							//$mensaje .= "</td>";
						
							$mensaje .= "<td>";
							$mensaje .= $SeCancelo;
							$mensaje .= "</td>";
							
							
							
							$Estado = "";
							
							if($SeCancelo<>"CANCELADO"){
								
								if($DatFactura->FacDiaTranscurrido < $DatFactura->FacCantidadDia){
								
									$Estado = "VIGENTE";
									
								}else if($DatFactura->FacDiaTranscurrido > $DatFactura->FacCantidadDia){
									
									$Vencido = $DatFactura->FacDiaTranscurrido - $DatFactura->FacCantidadDia;
									$Estado = "VENCIDO ".$Vencido." DIAS";
			
								}else if($DatFactura->FacDiaTranscurrido == $DatFactura->FacCantidadDia){
									
									$Estado = "VENCE HOY";
									
								}
								
							}
		//					
							
							//$Estado = "VENCIDO ".$DatFactura->FacDiaVencido." DIAS";
						
							
							$mensaje .= "<td>";
							$mensaje .= $Estado." / ".$DatFactura->VdiId;
							$mensaje .= "</td>";
							
							
							$mensaje .= "<td>";
							$mensaje .= $Formula;
							$mensaje .= "</td>";
							
						$mensaje .= "</tr>";
						
						$i++;
			 
				
				
			
			}
		}
		
		
		if(!empty($ArrBoletas)){
			foreach($ArrBoletas as $DatBoleta){
				
				
				
						if($DatBoleta->MonId<>$EmpresaMonedaId){
							$DatBoleta->BolTotal = round($DatBoleta->BolTotal / $DatBoleta->BolTipoCambio,2);
					//			$DatBoleta->BolMontoAmortizado = ($DatBoleta->BolMontoAmortizado / $DatBoleta->BolTipoCambio);
						}
						
						$ClientePagoMontoTotalOtro = 0;
						
						if(!empty($DatBoleta->OvvId)){
							
							$InsPago = new ClsPago();
							$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","10",3,NULL,$DatBoleta->OvvId,$POST_CondicionPago,$DatBoleta->MonId);
							$ArrPagos = $ResPago['Datos'];
							
							if(!empty($ArrPagos)){
								foreach($ArrPagos as $DatPago){
									
									if($DatPago->MonId<>$EmpresaMonedaId){
										$DatPago->PagMonto = round($DatPago->PagMonto / $DatPago->PagTipoCambio,2);
									}
									
									$ClientePagoMontoTotalOtro += $DatPago->PagMonto;
									
								}
							}
							
						}else if($DatBoleta->VdiId){
														
														
							$InsPago = new ClsPago();
							//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
							$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","10","1,3",$DatBoleta->VdiId,NULL,$POST_CondicionPago,$DatBoleta->MonId);
							$ArrPagos = $ResPago['Datos'];
							
							if(!empty($ArrPagos)){
								foreach($ArrPagos as $DatPago){
									
									if($DatPago->MonId<>$EmpresaMonedaId){
										$DatPago->PagMonto = round($DatPago->PagMonto / $DatPago->PagTipoCambio,2);
									}
									
									$ClientePagoMontoTotalOtro += $DatPago->PagMonto;
									
								}
							}

						}
						
						
						//PAGOS COMPROBANTE
						
						//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0,$oNoTieneComprobante=false,$oNoTieneComprobanteEstricto=false) 
						$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","10",3,NULL,NULL,NULL,$DatBoleta->MonId,NULL,NULL,$DatBoleta->BolId,$DatBoleta->BtaId,NULL,NULL,NULL,"PagFecha",NULL);
						$ArrPagos = $ResPago['Datos'];
					
						
						$ClientePagoMontoTotal = 0;
						
						if(!empty($ArrPagos)){
							foreach($ArrPagos as $DatPago){
									
								if($DatPago->MonId<>$EmpresaMonedaId){
									$DatPago->PagMonto = round($DatPago->PagMonto / $DatPago->PagTipoCambio,2);
								}
								
								$ClientePagoMontoTotal += $DatPago->PagMonto;
										
							}
						}
					
						//NOTAS DE CREDITO
						
						$TotalNotaCredito = 0;
						$InsNotaCredito = new ClsNotaCredito();
						//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL) {
							
						$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrId","ASC",1,"10",NULL,5,NULL,NULL,NULL,$DatBoleta->MonId,$DatBoleta->BolId,$DatBoleta->BtaId);
						$ArrNotaCreditos = $ResNotaCredito['Datos'];
						
						if(!empty($ArrNotaCreditos)){
							foreach($ArrNotaCreditos as $DatNotaCredito){
								
							 	
									
								if($DatNotaCredito->MonId<>$EmpresaMonedaId){
									$DatNotaCredito->NcrTotal = round($DatNotaCredito->NcrTotal / $DatNotaCredito->NcrTipoCambio,2);
								}
								
								
								$TotalNotaCredito += $DatNotaCredito->NcrTotal;
								
							}
						}
					
					
						$Dias = $DatBoleta->BolCantidadDia - $DatBoleta->BolDiaTranscurrido;
						
					 	
													
						settype($DatBoleta->BolTotal ,"float");
						settype($ClientePagoMontoTotal ,"float");
						settype($TotalNotaCredito ,"float");
						
						$DatBoleta->BolTotal = round($DatBoleta->BolTotal,2);
						$ClientePagoMontoTotal = round($ClientePagoMontoTotal,2);
						$TotalNotaCredito = round($TotalNotaCredito,2);
						
						$SeCancelo = "";
						
						//if( (($ClientePagoMontoTotal+500) + ($TotalNotaCredito+500) )>= ($DatBoleta->BolTotal+1000)){
						if( (($ClientePagoMontoTotal) + ($TotalNotaCredito) + ($ClientePagoMontoTotalOtro) )>= ($DatBoleta->BolTotal)){
							$SeCancelo = "CANCELADO";
						}else{
							$SeCancelo = "SIN CANCELAR";
						}
									
						$Formula = "ClientePagoMontoTotal: ".$ClientePagoMontoTotal." + TotalNotaCredito: ".$TotalNotaCredito." + ClientePagoMontoTotalOtro: ".$ClientePagoMontoTotalOtro." MAYOR IGUAL FacTotal: ".$DatBoleta->BolTotal;
							
									
						if($SeCancelo=="CANCELADO"){
							//MtdEditarFacturaCancelado($oId,$oTalonario,$oCancelado) 
							$InsBoleta->MtdEditarBoletaCancelado($DatBoleta->BolId,$DatBoleta->BtaId,1);
						}else{
							//MtdEditarFacturaCancelado($oId,$oTalonario,$oCancelado) 
							$InsBoleta->MtdEditarBoletaCancelado($DatBoleta->BolId,$DatBoleta->BtaId,2);
						}			
						 
							//if($SeCancelo == "SIN CANCELAR" ){
								
								
								
								$mensaje .= "<tr>";
											
									$mensaje .= "<td>";
									$mensaje .= $i;
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= $DatBoleta->PagId."/".$DatBoleta->SucNombre;
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= $DatBoleta->BtaNumero."-".$DatBoleta->BolId;
									$mensaje .= "</td>";
					
									$mensaje .= "<td>";
									$mensaje .= $DatBoleta->BolFechaEmision;
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= $DatBoleta->CliNombre." ".$DatBoleta->CliApellidoPaterno." ".$DatBoleta->CliApellidoMaterno;
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= $DatBoleta->MonSimbolo;
									$mensaje .= "</td>";
										
									$mensaje .= "<td>";
									$mensaje .= number_format($DatBoleta->BolTotal,2);
									$mensaje .= "</td>";
								
								
									$mensaje .= "<td>";
									$mensaje .= number_format($TotalNotaCredito	,2);
									$mensaje .= "</td>";
									
									
									$mensaje .= "<td>";
									$mensaje .= number_format($ClientePagoMontoTotal,2);
									$mensaje .= "</td>";
									
										$mensaje .= "<td>";
							$mensaje .= number_format($ClientePagoMontoTotalOtro,2);
							$mensaje .= "</td>";
							
							
								
									$mensaje .= "<td>";
									$mensaje .= $DatBoleta->BolFechaVencimiento;
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= $DatBoleta->BolCantidadDia;
									$mensaje .= "</td>";
					
									//$mensaje .= "<td>";
									//$mensaje .= $DatBoleta->BolDiaTranscurrido;
									//$mensaje .= "</td>";
									
								
									$mensaje .= "<td>";
									$mensaje .= $SeCancelo;
									$mensaje .= "</td>";
									
									
									
									$Estado = "";
									//
									if($SeCancelo<>"CANCELADO"){
										
										if($DatBoleta->BolDiaTranscurrido < $DatBoleta->BolCantidadDia){
										
											$Estado = "VIGENTE";
											
										}else if($DatBoleta->BolDiaTranscurrido > $DatBoleta->BolCantidadDia){
											
											$Vencido = $DatBoleta->BolDiaTranscurrido - $DatBoleta->BolCantidadDia;
											$Estado = "VENCIDO ".$Vencido." DIAS";
					
										}else if($DatBoleta->BolDiaTranscurrido == $DatBoleta->BolCantidadDia){
											
											$Estado = "VENCE HOY";
											
										}
										
									}
									
									//$Estado = "VENCIDO ".$DatBoleta->BolDiaVencido." DIAS";
									
									
									$mensaje .= "<td>";
									$mensaje .= $Estado." / ".$DatBoleta->VdiId;
									$mensaje .= "</td>";
									
										
									$mensaje .= "<td>";
									$mensaje .= $Formula;
									$mensaje .= "</td>";
					
								$mensaje .= "</tr>";
								
								
								$i++;
								
							//}
	 
				
			}
		}
		 

	}
}
		

$mensaje .= "</table>";

echo $mensaje;

 echo "-----------------------------------------------";
echo "<br>";
echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");			
				
				
?>