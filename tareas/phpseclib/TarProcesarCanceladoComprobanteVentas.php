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

$FechaInicio  = date("d/m/Y",strtotime($FechaHoy."- 30 days")); 

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

$InsFactura = new ClsFactura();
$InsPago = new ClsPago();
$InsBoleta = new ClsBoleta();
$InsSucursal = new ClsSucursal();
 $InsReportePago = new ClsReportePago();
 

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

$mensaje .= "</tr>";


if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
	
		//MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPago=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0,$oNoTieneComprobante=false,$oNoTieneComprobanteEstricto=false) {
		
		$ResReportePago = $InsReportePago->MtdObtenerPagoComprobantes(NULL,NULL,'PacId','Desc','10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",NULL,NULL,$DatSucursal->SucId,NULL,NULL,NULL,0,false,false);
		$ArrReportePagos = $ResReportePago['Datos'];
		
		if(!empty($ArrReportePagos)){
			foreach($ArrReportePagos as $DatReportePago){
			
				if(!empty($DatReportePago->FacId) and !empty($DatReportePago->FtaId)){
					
					
					
				if($DatReportePago->MonIdFactura<>$EmpresaMonedaId){
					$DatReportePago->FacTotal = round($DatReportePago->FacTotal / $DatReportePago->FacTipoCambio,2);
		//			$DatReportePago->FacMontoAmortizado = ($DatReportePago->FacMontoAmortizado / $DatReportePago->FacTipoCambio);
				}
				
				//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL) {
				$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","10",3,NULL,NULL,NULL,$DatReportePago->MonIdFactura,$DatReportePago->FacId,$DatReportePago->FtaId,NULL,NULL,NULL,NULL,NULL,"PagFecha",NULL);
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
					
				$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrId","ASC",1,"10",NULL,5,NULL,NULL,NULL,$DatReportePago->MonId,$DatReportePago->FacId,$DatReportePago->FtaId);
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
		
		
				$Dias = $DatReportePago->FacCantidadDia - $DatReportePago->FacDiaTranscurrido;
				
				//if($Dias<=$oCantidadDia){
					
											
				settype($DatReportePago->FacTotal ,"float");
				settype($ClientePagoMontoTotal ,"float");
				settype($TotalNotaCredito ,"float");
				
				$DatReportePago->FacTotal = round($DatReportePago->FacTotal,2);
				$ClientePagoMontoTotal = round($ClientePagoMontoTotal,2);
				$TotalNotaCredito = round($TotalNotaCredito,2);
				
				$SeCancelo = "";
				
				//if( (($ClientePagoMontoTotal+500) + ($TotalNotaCredito+500) )>= ($DatReportePago->FacTotal+1000)){
				if( (($ClientePagoMontoTotal) + ($TotalNotaCredito) )>= ($DatReportePago->FacTotal)){
					$SeCancelo = "CANCELADO";
				}else{
					$SeCancelo = "SIN CANCELAR";
				}
							
							
			 
				if($SeCancelo == "SIN CANCELAR"){
						
						$mensaje .= "<tr>";
									
							$mensaje .= "<td>";
							$mensaje .= $i;
							$mensaje .= "</td>";
										
							$mensaje .= "<td>";
							$mensaje .= $DatReportePago->SucNombre;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatReportePago->FtaNumero."-".$DatReportePago->FacId;
							$mensaje .= "</td>";
										
			
							$mensaje .= "<td>";
							$mensaje .= $DatReportePago->FacFechaEmision;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatReportePago->CliNombre." ".$DatReportePago->CliApellidoPaterno." ".$DatReportePago->CliApellidoMaterno;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatReportePago->MonSimbolo;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= number_format($DatReportePago->FacTotal,2);
							$mensaje .= "</td>";
						
						
							$mensaje .= "<td>";
							$mensaje .= number_format($TotalNotaCredito	,2);
							$mensaje .= "</td>";
							
							
							$mensaje .= "<td>";
							$mensaje .= number_format($ClientePagoMontoTotal,2);
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatReportePago->FacFechaVencimiento;
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= $DatReportePago->FacCantidadDia;
							$mensaje .= "</td>";
			
							//$mensaje .= "<td>";
							//$mensaje .= $DatReportePago->FacDiaTranscurrido;
							//$mensaje .= "</td>";
						
							$mensaje .= "<td>";
							$mensaje .= $SeCancelo;
							$mensaje .= "</td>";
							
							
							
							$Estado = "";
							
							if($SeCancelo<>"CANCELADO"){
								
								if($DatReportePago->FacDiaTranscurrido < $DatReportePago->FacCantidadDia){
								
									$Estado = "VIGENTE";
									
								}else if($DatReportePago->FacDiaTranscurrido > $DatReportePago->FacCantidadDia){
									
									$Vencido = $DatReportePago->FacDiaTranscurrido - $DatReportePago->FacCantidadDia;
									$Estado = "VENCIDO ".$Vencido." DIAS";
			
								}else if($DatReportePago->FacDiaTranscurrido == $DatReportePago->FacCantidadDia){
									
									$Estado = "VENCE HOY";
									
								}
								
							}
		//					
							
							//$Estado = "VENCIDO ".$DatReportePago->FacDiaVencido." DIAS";
						
							
							$mensaje .= "<td>";
							$mensaje .= $Estado;
							$mensaje .= "</td>";
							
							
		
						$mensaje .= "</tr>";
						
						$i++;
									
				}
					
					
				 
				 
				 
				}
				
				if(!empty($DatReportePago->BolId) and !empty($DatReportePago->BtaId)){
					
		 
				
						if($DatReportePago->MonIdBoleta<>$EmpresaMonedaId){
							$DatReportePago->BolTotal = round($DatReportePago->BolTotal / $DatReportePago->BolTipoCambio,2);
					//			$DatReportePago->BolMontoAmortizado = ($DatReportePago->BolMontoAmortizado / $DatReportePago->BolTipoCambio);
						}
						
						
					
						//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL) {
						$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC","10",3,NULL,NULL,NULL,$DatReportePago->MonIdBoleta,NULL,NULL,NULL,$DatReportePago->BolId,$DatReportePago->BtaId,NULL,NULL,NULL,"PagFecha",NULL);
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
							
						$ResNotaCredito = $InsNotaCredito->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrId","ASC",1,"10",NULL,5,NULL,NULL,NULL,$DatReportePago->MonIdBoleta,$DatReportePago->BolId,$DatReportePago->BtaId);
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
					
					
						$Dias = $DatReportePago->BolCantidadDia - $DatReportePago->BolDiaTranscurrido;
						
						//if($Dias<=$oCantidadDia){
							
													
						settype($DatReportePago->BolTotal ,"float");
						settype($ClientePagoMontoTotal ,"float");
						settype($TotalNotaCredito ,"float");
						
						$DatReportePago->BolTotal = round($DatReportePago->BolTotal,2);
						$ClientePagoMontoTotal = round($ClientePagoMontoTotal,2);
						$TotalNotaCredito = round($TotalNotaCredito,2);
						
						$SeCancelo = "";
						
						//if( (($ClientePagoMontoTotal+500) + ($TotalNotaCredito+500) )>= ($DatReportePago->BolTotal+1000)){
						if( (($ClientePagoMontoTotal) + ($TotalNotaCredito) )>= ($DatReportePago->BolTotal)){
							$SeCancelo = "CANCELADO";
						}else{
							$SeCancelo = "SIN CANCELAR";
						}
									
									
									
						//	if($DatReportePago->BolTotal > $Amortizado){
							//if($SeCancelo == "SIN CANCELAR" or 1 == 1){
							if($SeCancelo == "SIN CANCELAR" ){
								
								
								
								$mensaje .= "<tr>";
											
									$mensaje .= "<td>";
									$mensaje .= $i;
									$mensaje .= "</td>";
					
									$mensaje .= "<td>";
									$mensaje .= $DatReportePago->BtaNumero."-".$DatReportePago->BolId;
									$mensaje .= "</td>";
					
									$mensaje .= "<td>";
									$mensaje .= $DatReportePago->BolFechaEmision;
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= $DatReportePago->CliNombre." ".$DatReportePago->CliApellidoPaterno." ".$DatReportePago->CliApellidoMaterno;
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= $DatReportePago->MonSimbolo;
									$mensaje .= "</td>";
										
									$mensaje .= "<td>";
									$mensaje .= number_format($DatReportePago->BolTotal,2);
									$mensaje .= "</td>";
								
								
									$mensaje .= "<td>";
									$mensaje .= number_format($TotalNotaCredito	,2);
									$mensaje .= "</td>";
									
									
									$mensaje .= "<td>";
									$mensaje .= number_format($ClientePagoMontoTotal,2);
									$mensaje .= "</td>";
									
								
									$mensaje .= "<td>";
									$mensaje .= $DatReportePago->BolFechaVencimiento;
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= $DatReportePago->BolCantidadDia;
									$mensaje .= "</td>";
					
									//$mensaje .= "<td>";
									//$mensaje .= $DatReportePago->BolDiaTranscurrido;
									//$mensaje .= "</td>";
									
								
									$mensaje .= "<td>";
									$mensaje .= $SeCancelo;
									$mensaje .= "</td>";
									
									
									
									$Estado = "";
									//
									if($SeCancelo<>"CANCELADO"){
										
										if($DatReportePago->BolDiaTranscurrido < $DatReportePago->BolCantidadDia){
										
											$Estado = "VIGENTE";
											
										}else if($DatReportePago->BolDiaTranscurrido > $DatReportePago->BolCantidadDia){
											
											$Vencido = $DatReportePago->BolDiaTranscurrido - $DatReportePago->BolCantidadDia;
											$Estado = "VENCIDO ".$Vencido." DIAS";
					
										}else if($DatReportePago->BolDiaTranscurrido == $DatReportePago->BolCantidadDia){
											
											$Estado = "VENCE HOY";
											
										}
										
									}
									
									//$Estado = "VENCIDO ".$DatReportePago->BolDiaVencido." DIAS";
									
									
									$mensaje .= "<td>";
									$mensaje .= $Estado;
									$mensaje .= "</td>";
									
									
					
								$mensaje .= "</tr>";
								
								
								$i++;
								
							}
	 
					
				}
				
				
			
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