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



$POST_Enviar = $_GET['Enviar'];
//$POST_FechaInicio = (empty($_GET['FechaInicio'])?"01/".date("m")."/".date("Y"):$_GET['FechaInicio']);
$POST_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$POST_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

//$POST_Fecha = (empty($_GET['Fecha'])?date("d/m/Y"):$_GET['Fecha']);
$POST_Sucursal = $_GET['Sucursal'];

if(!empty($POST_Sucursal)){

	$Destinatarios = $CorreosNotificacionComprobantesSinPagoSucursal;

}else{

	$Destinatarios = $CorreosNotificacionComprobantesSinPagoGeneral;

}

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsFactura = new ClsFactura();
$InsPago = new ClsPago();
$InsBoleta = new ClsBoleta();
$InsSucursal = new ClsSucursal();
 


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];



//$FechaFin = date("d/m/Y");
$Titulo  = "";

if($POST_FechaFin == $POST_FechaInicio){
	$Titulo = " ".$POST_FechaInicio;
}else{
	$Titulo = " ".$POST_FechaInicio." al ".$POST_FechaFin;	
}



$mensaje .= "<b><u>COMPROBANTES SIN PAGO REGISTRADO</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";
$mensaje .= "<b>Rango de Fechas:</b> ".$POST_FechaInicio." al ".$POST_FechaFin;	
//$mensaje .= "<b>Rango de Fechas:</b> ".$POST_Fecha;	
$mensaje .= "<br>";

$mensaje .= "<b>Descripcion:</b> Comprobantes de pago que no tienen pago (abono) registrado.";
$mensaje .= "<br>";	

$mensaje .= "<hr>";
$mensaje .= "<br>";
  
$mensaje .= "<br>";
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
	
	$mensaje .= "<td width='10%'>";
	$mensaje .= "<b>Estado</b>";
	$mensaje .= "</td>";
	
	$mensaje .= "<td>";
	$mensaje .= "<b>Obs.</b>";
	$mensaje .= "</td>";


$mensaje .= "</tr>";

	
if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
				
		//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL,$oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
		$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacTiempoCreacion","DESC","500",NULL,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,NULL,"NPA-10000",NULL,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatSucursal->SucId,$MostrarNoProcesados,$POST_Cancelado,true,NULL,false,2);
		$ArrFacturas = $ResFactura['Datos'];
		
		
		//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
		$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,"BolTiempoCreacion","DESC","500","5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,"NPA-10000",$POST_Moneda,NULL,NULL,NULL,NULL,NULL,$DatSucursal->SucId,$MostrarNoProcesados,$POST_Cancelado,true,NULL,false,2);
		$ArrBoletas = $ResBoleta['Datos'];


			if(!empty($ArrFacturas)){
			
				foreach($ArrFacturas as $DatFactura){
			 
					$DatFactura->FacTotal = (($DatFactura->FacTotal/(empty($DatFactura->FacTipoCambio)?1:$DatFactura->FacTipoCambio)));
							
						
						
							
							//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL) {
					$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,3,NULL,NULL,NULL,$DatFactura->MonId,$DatFactura->FacId,$DatFactura->FtaId,NULL,NULL,NULL,NULL,NULL,"PagFecha",NULL);
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
				
					
					$TotalNotaCredito = 0;
					$InsNotaCredito = new ClsNotaCredito();
					//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL) {
						
					$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrId","ASC",1,NULL,$_SESSION['SisSucId'],5,NULL,NULL,NULL,$DatFactura->MonId,$DatFactura->FacId,$DatFactura->FtaId);
					$ArrNotaCreditos = $ResNotaCredito['Datos'];
					
					if(!empty($ArrNotaCreditos)){
						foreach($ArrNotaCreditos as $DatNotaCredito){
							
							//deb($DatNotaCredito->NcrTipoCambio);
							//$DatNotaCredito->NcrTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaCredito->NcrTotal:($DatNotaCredito->NcrTotal/$DatNotaCredito->NcrTipoCambio));
							
								
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
					if( (($ClientePagoMontoTotal) + ($TotalNotaCredito) )>= ($DatFactura->FacTotal)){
						$SeCancelo = "CANCELADO";
					}else{
						$SeCancelo = "SIN CANCELAR";
					}
								
					if($SeCancelo == "SIN CANCELAR" ){
							
							$mensaje .= "<tr>";
										
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";
				
					$mensaje .= "<td>";
								$mensaje .= $DatFactura->SucNombre;
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
							
							
							$Estado = "";
							
							if($SeCancelo<>"CANCELADO"){
								
								//if($DatFactura->FacDiaTranscurrido < $DatFactura->FacCantidadDia){
//								
//									$Estado = "VIGENTE";
//									
//								}else if($DatFactura->FacDiaTranscurrido > $DatFactura->FacCantidadDia){
//									
//									$Vencido = $DatFactura->FacDiaTranscurrido - $DatFactura->FacCantidadDia;
//									$Estado = "VENCIDO ".$Vencido." DIAS";
//			
//								}else if($DatFactura->FacDiaTranscurrido == $DatFactura->FacCantidadDia){
//									
//									$Estado = "VENCE HOY";
//									
//								}
								
							}
		//					
							$Estado = $SeCancelo;
							
							//$Estado = "VENCIDO ".$DatFactura->FacDiaVencido." DIAS";
						
							
							$mensaje .= "<td>";
							$mensaje .= $Estado;
							$mensaje .= "</td>";
							
							
							
							$mensaje .= "<td>";
									$mensaje .= $DatFactura->OvvId;
									$mensaje .= "</td>";
								
			
							$mensaje .= "</tr>";
							
							
						$i++;	
					}
					
				}	
				
				
			}
					
			if(!empty($ArrBoletas)){
					
					
					foreach($ArrBoletas as $DatBoleta){
				
					  $DatBoleta->BolTotal = (($DatBoleta->BolTotal/(empty($DatBoleta->BolTipoCambio)?1:$DatBoleta->BolTipoCambio)));
						 
						
				
					
						//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL) {
						$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,3,NULL,NULL,NULL,$DatBoleta->MonIdNULL,NULL,NULL,$DatBoleta->BolId,$DatBoleta->BtaId,NULL,NULL,NULL,"PagFecha",NULL);
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
					
						
						$TotalNotaCredito = 0;
						$InsNotaCredito = new ClsNotaCredito();
						//MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL) {
							
						$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrId","ASC",1,NULL,$_SESSION['SisSucId'],5,NULL,NULL,NULL,$DatBoleta->MonId,$DatBoleta->BolId,$DatBoleta->BtaId);
						$ArrNotaCreditos = $ResNotaCredito['Datos'];
						
						if(!empty($ArrNotaCreditos)){
							foreach($ArrNotaCreditos as $DatNotaCredito){
								
								//deb($DatNotaCredito->NcrTipoCambio);
								//$DatNotaCredito->NcrTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatNotaCredito->NcrTotal:($DatNotaCredito->NcrTotal/$DatNotaCredito->NcrTipoCambio));
								
									
								if($DatNotaCredito->MonId<>$EmpresaMonedaId){
									$DatNotaCredito->NcrTotal = round($DatNotaCredito->NcrTotal / $DatNotaCredito->NcrTipoCambio,2);
								}
								
								
								$TotalNotaCredito += $DatNotaCredito->NcrTotal;
								
							}
						}
					
					
						$Dias = $DatBoleta->BolCantidadDia - $DatBoleta->BolDiaTranscurrido;
						
						//if($Dias<=$oCantidadDia){
							
													
						settype($DatBoleta->BolTotal ,"float");
						settype($ClientePagoMontoTotal ,"float");
						settype($TotalNotaCredito ,"float");
						
						$DatBoleta->BolTotal = round($DatBoleta->BolTotal,2);
						$ClientePagoMontoTotal = round($ClientePagoMontoTotal,2);
						$TotalNotaCredito = round($TotalNotaCredito,2);
						
						$SeCancelo = "";
						
						//if( (($ClientePagoMontoTotal+500) + ($TotalNotaCredito+500) )>= ($DatBoleta->BolTotal+1000)){
						if( (($ClientePagoMontoTotal) + ($TotalNotaCredito) )>= ($DatBoleta->BolTotal)){
							$SeCancelo = "CANCELADO";
						}else{
							$SeCancelo = "SIN CANCELAR";
						}
				 
					 
						if($SeCancelo == "SIN CANCELAR" ){
								
								$mensaje .= "<tr>";
											
									$mensaje .= "<td>";
									$mensaje .= $i;
									$mensaje .= "</td>";
					
									$mensaje .= "<td>";
									$mensaje .= $DatBoleta->SucNombre;
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
							
							$Estado = "";
							
							if($SeCancelo<>"CANCELADO"){
								
								//if($DatBoleta->BolDiaTranscurrido < $DatBoleta->BolCantidadDia){
//								
//									$Estado = "VIGENTE";
//									
//								}else if($DatBoleta->BolDiaTranscurrido > $DatBoleta->BolCantidadDia){
//									
//									$Vencido = $DatBoleta->BolDiaTranscurrido - $DatBoleta->BolCantidadDia;
//									$Estado = "VENCIDO ".$Vencido." DIAS";
//			
//								}else if($DatBoleta->BolDiaTranscurrido == $DatBoleta->BolCantidadDia){
//									
//									$Estado = "VENCE HOY";
//									
//								}
								
							}
							
							$Estado = $SeCancelo;
							
							
		//					
							
							//$Estado = "VENCIDO ".$DatFactura->FacDiaVencido." DIAS";
						
							
							$mensaje .= "<td>";
							$mensaje .= $Estado;
							$mensaje .= "</td>";
								 
									
									$mensaje .= "<td>";
									$mensaje .= $DatBoleta->OvvId;
									$mensaje .= "</td>";
									
									
				
								$mensaje .= "</tr>";
									
							
						
						$i++;		
											
						}
			 
					}
				
				$Enviar = true;	
						
			}

	}
}
			
$mensaje .= "</table>";
		
		
 
	 
 




$mensaje .= "<br>";
$mensaje .= "<br>";
$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');


//$Enviar = false;

echo $mensaje;

if($Enviar){
	
	//if($POST_Enviar<>"2"){
		$InsCorreo = new ClsCorreo();	
		$InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: COMPROBANTES SIN PAGO ".$Titulo,$mensaje);
	//}
	
}
				
				
				
?>