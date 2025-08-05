<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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


$GET_c = $_GET['c'];
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

$InsPago = new ClsPago();
$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsCliente = new ClsCliente();


////REPUESPORT
//$InsCliente->CliId = "CLI-18856";
//$InsCliente->MtdObtenerCliente();
//
////SOMA AUTOS
//$InsCliente->CliId = "CLI-18948";
//$InsCliente->MtdObtenerCliente();
//
////AUTO CLASS
//$InsCliente->CliId = "CLI-18846";
//$InsCliente->MtdObtenerCliente();
//
////PACIFICO
//$InsCliente->CliId = "CLI-10038";
//$InsCliente->MtdObtenerCliente();

$ArrClientes = array("CLI-18856","CLI-18948","CLI-18846","CLI-10038","CLI-20039","CLI-17136","CLI-20198");
$POST_Moneda  = "MON-10001";


$InsMoneda->MonId = $POST_Moneda;
$InsMoneda->MtdObtenerMoneda();



			$Enviar = false;
			

			$mensaje .= "NOTIFICACION DE FACTURAS X COBRAR:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			foreach($ArrClientes as $DatCliente){
				
				
				//$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","ASC",NULL,NULL,5,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,NULL,"NPA-10001",NULL,$POST_Moneda,$DatCliente);
				$ResFactura = $InsFactura->MtdObtenerFacturas("vdi.VdiOrdenCompraNumero","contiene","MZA","FacFechaEmision","ASC",NULL,NULL,5,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,NULL,NULL,NULL,$POST_Moneda,$DatCliente);
				$ArrFacturas = $ResFactura['Datos'];

				$FacturaTotal = 0;
				$FacturaAmortizadoTotal = 0;
				$FacturaSaldoTotal = 0;
				
				foreach($ArrFacturas as $DatFactura){

					$DatFactura->FacTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFactura->FacTotal:($DatFactura->FacTotal/$DatFactura->FacTipoCambio));
						
					$DatFactura->FacTotal = round($DatFactura->FacTotal,2);
			
						
							$InsPago = new ClsPago();
							$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,'PagId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,$DatFactura->FacId,$DatFactura->FtaId,NULL,NULL);
							$ArrPagos = $ResPago['Datos'];
							
							$ClientePagoMontoTotal = 0;
							if(!empty($ArrPagos)){
								foreach($ArrPagos as $DatPago){
									
									$DatPago->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));
									$ClientePagoMontoTotal += $DatPago->PagMonto;
									
								}
							}
									
							settype($DatFactura->FacTotal ,"float");
							settype($ClientePagoMontoTotal ,"float");
							
							$FacturaSaldo = round($DatFactura->FacTotal,2) - round($ClientePagoMontoTotal,2);

							settype($DatFactura->FacTotal ,"float");
							settype($ClientePagoMontoTotal ,"float");
						
							settype($DatFactura->FacTotal ,"float");
							settype($ClientePagoMontoTotal ,"float");
					
					
					$FacturaTotal += $DatFactura->FacTotal;
					$FacturaAmortizadoTotal += $ClientePagoMontoTotal;
					$FacturaSaldoTotal += $FacturaSaldo;
					
					$c++;	
					
				}
			

				//deb($FacturaSaldoTotal);
///			if($FacturaSaldoTotal>0 or 1 == 1){
				if($FacturaSaldoTotal>0){
				
								
								$InsCliente = new ClsCliente();
								$InsCliente->CliId = $DatCliente;
								$InsCliente->MtdObtenerCliente();
								
								$mensaje .= "<b>Cliente:</b> ".$InsCliente->CliNombre." ".$InsCliente->CliApellidoPaterno." ".$InsCliente->CliApellidoMaterno."";	
								$mensaje .= "<br>";	
								$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
								$mensaje .= "<br>";	
								
								$mensaje .= "<hr>";
								$mensaje .= "<br>";
								$mensaje .= "<br>";
				
				
								if(!empty($ArrFacturas)){
								
									
									$mensaje .= "<table cellpadding='2' cellspacing='0' width='100%' border='1'>";
									
									$mensaje .= "<tr>";
									
										$mensaje .= "<td width='2%'  align='center'>";
										$mensaje .= "<b>#</b>";
										$mensaje .= "</td>";
				
										$mensaje .= "<td width='50px'  align='center'>";
										$mensaje .= "<b>FACTURA</b>";
										$mensaje .= "</td>";
									
										$mensaje .= "<td width='50px' align='center'>";
										$mensaje .= "<b>FECHA</b>";
										$mensaje .= "</td>";
										
										$mensaje .= "<td width='100px' align='center'>";
										$mensaje .= "<b>CLIENTE</b>";
										$mensaje .= "</td>";
				
										$mensaje .= "<td width='30px' align='center'>";
										$mensaje .= "<b>MONEDA</b>";
										$mensaje .= "</td>";
				
										$mensaje .= "<td width='20px' align='center'>";
										$mensaje .= "<b>T.C.</b>";
										$mensaje .= "</td>";
										
										$mensaje .= "<td width='90px' align='center'>";
										$mensaje .= "<b>REF.</b>";
										$mensaje .= "</td>";
										
										$mensaje .= "<td width='90px' align='center'>";
										$mensaje .= "<b>COND. PAGO</b>";
										$mensaje .= "</td>";
										
										$mensaje .= "<td width='50px' align='center'>";
										$mensaje .= "<b>DIAS CRED.</b>";
										$mensaje .= "</td>";
										
										$mensaje .= "<td width='60px' align='center'>";
										$mensaje .= "<b>FECHA VENC.</b>";
										$mensaje .= "</td>";
										
										$mensaje .= "<td width='50px' align='right'>";
										$mensaje .= "<b>TOTAL</b>";
										$mensaje .= "</td>";
				
										$mensaje .= "<td width='50px' align='right'>";
										$mensaje .= "<b>AMORT.</b>";
										$mensaje .= "</td>";
				
										$mensaje .= "<td width='50px' align='right'>";
										$mensaje .= "<b>SALDO</b>";
										$mensaje .= "</td>";
										
										$mensaje .= "<td  width='90px' align='center'>";
										$mensaje .= "<b>VENCIMIENTO</b>";
										$mensaje .= "</td>";
										
										$mensaje .= "<td   width='90px'  align='center'>";
										$mensaje .= "<b>ESTADO</b>";
										$mensaje .= "</td>";
										
									$mensaje .= "</tr>";
									
									
								
								
								
								$c=1;
								$FacturaTotal = 0;
								$FacturaAmortizadoTotal = 0;
								$FacturaSaldoTotal = 0;
								
								//$TotalCredito30 = 0;
//								$TotalCredito30Mas = 0;
								$TotalContado = 0;
								$TotalFacturaNoCancelada = 0;
								
								//$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","ASC",NULL,NULL,5,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,NULL,"NPA-10001",NULL,$POST_Moneda,$DatCliente);
								$ResFactura = $InsFactura->MtdObtenerFacturas("vdi.VdiOrdenCompraNumero","contiene","MZA","FacFechaEmision","ASC",NULL,NULL,5,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,NULL,NULL,NULL,$POST_Moneda,$DatCliente);
				$ArrFacturas = $ResFactura['Datos'];

	
	
								foreach($ArrFacturas as $DatFactura){
				
									$DatFactura->FacTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatFactura->FacTotal:($DatFactura->FacTotal/$DatFactura->FacTipoCambio));
										
									$DatFactura->FacTotal = round($DatFactura->FacTotal,2);
							
							
								
									$InsPago = new ClsPago();
									$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,'PagId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,$DatFactura->FacId,$DatFactura->FtaId,NULL,NULL);
									$ArrPagos = $ResPago['Datos'];
											
									$ClientePagoMontoTotal = 0;
									if(!empty($ArrPagos)){
										foreach($ArrPagos as $DatPago){
													
											$DatPago->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));
											$ClientePagoMontoTotal += $DatPago->PagMonto;
													
										}
									}
				
									if(($ClientePagoMontoTotal+1000) < ($DatFactura->FacTotal+1000)){

									//$resultado = strpos($DatFactura->VdiOrdenCompraNumero, "MZA");									 
									//if($resultado !== FALSE){									
									
										$mensaje .= "<tr>";
													
											$mensaje .= "<td>";
											$mensaje .= $c;
											$mensaje .= "</td>";
							
											$mensaje .= "<td><small>";
											$mensaje .= $DatFactura->FtaNumero."-".$DatFactura->FacId;
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .= $DatFactura->FacFechaEmision;
											$mensaje .= "</small></td>";
						
											$mensaje .= "<td><small>";
											$mensaje .= $DatFactura->CliApellidoPaterno." ".$DatFactura->CliApellidoMaterno." ".$DatFactura->CliNombre;
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .= $DatFactura->MonSimbolo;
											$mensaje .= "</small></td>";
						
											
											$mensaje .= "<td><small>";
											$mensaje .= $DatFactura->FacTipoCambio;
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .= $DatFactura->VdiOrdenCompraNumero;
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .=(($DatFactura->NpaNombre=="CREDITO")?"<b>":"");
											$mensaje .= $DatFactura->NpaNombre;
											$mensaje .=(($DatFactura->NpaNombre=="CREDITO")?"</b>":"");
											$mensaje .= "</small></td>";
											
											
												//if($DatFactura->FacCantidadDia <=30){
											////	  $TotalCredito30 += $DatFactura->FacTotal;
											//  }else{
											///	  $TotalCredito30Mas += $DatFactura->FacTotal;
											 // }
											$mensaje .= "<td><small>";
											$mensaje .= ($DatFactura->FacCantidadDia);
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .= ($DatFactura->FacFechaVencimiento);
											$mensaje .= "</small></td>";
											
				
											$mensaje .= "<td><small>";
											$mensaje .= number_format($DatFactura->FacTotal,2);
											$mensaje .= "</small></td>";
											
										
				
											$mensaje .= "<td><small>";
											$mensaje .= $ClientePagoMontoTotal;
											$mensaje .= "</small></td>";
													
											settype($DatFactura->FacTotal ,"float");
											settype($ClientePagoMontoTotal ,"float");
											
											$FacturaSaldo = round($DatFactura->FacTotal,2) - round($ClientePagoMontoTotal,2);
				
											$TotalFacturaNoCancelada += $FacturaSaldo;
											
											$mensaje .= "<td><small>";
											$mensaje .= number_format($FacturaSaldo,2);
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											settype($DatFactura->FacTotal ,"float");
											settype($ClientePagoMontoTotal ,"float");
											
											if(($ClientePagoMontoTotal+1000) < ($DatFactura->FacTotal+1000)){
									
												if($DatFactura->FacDiaVencido == -3){
													$mensaje .= "VENCE EN 3 DIAS";
												}else if($DatFactura->FacDiaVencido == -2){
													$mensaje .= "VENCE EN 2 DIAS";
												}else if($DatFactura->FacDiaVencido == -1){
													$mensaje .= "VENCE EN 1 DIA";
												}else if($DatFactura->FacDiaVencido == 0){

													if($DatFactura->NpaId == "NPA-10000"){
														$mensaje .= "AL CONTADO";
													}else{
														$mensaje .= "VENCIO HOY";	
													}
													
													
												}else if($DatFactura->FacDiaVencido > 0){
													$mensaje .= "VENCIDO ".$DatFactura->FacDiaVencido." DIAS";
												}else{
													$mensaje .= "VIGENTE";
												}
												
											}else{
												$mensaje .= "-";
											}
											
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											settype($DatFactura->FacTotal ,"float");
											settype($ClientePagoMontoTotal ,"float");
											
											if(($ClientePagoMontoTotal+1000) >= ($DatFactura->FacTotal+1000)){
												$mensaje .= "CANCELADO";
											}else{
												$mensaje .= "PENDIENTE";
											}
											$mensaje .= "</small></td>";
											
											
										$mensaje .= "</tr>";
										
										$Enviar = true;
										
										$FacturaTotal += $DatFactura->FacTotal;
										$FacturaAmortizadoTotal += $ClientePagoMontoTotal;
										$FacturaSaldoTotal += $FacturaSaldo;
										
										
										$c++;	
										
									}

								}
								
										
										$mensaje .= "<tr>";
													
											$mensaje .= "<td>";
											$mensaje .= "</td>";
							
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
						
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
						
											
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
						
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
								
							
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .= number_format($FacturaTotal ,2);
											$mensaje .= "</small></td>";
											
											
											$mensaje .= "<td><small>";
												$mensaje .= number_format($FacturaAmortizadoTotal ,2);
											$mensaje .= "</small></td>";
													
											$mensaje .= "<td><small>";
												$mensaje .= number_format($FacturaSaldoTotal ,2);
											$mensaje .= "</small></td>";
											
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
														
											$mensaje .= "<td><small>";
											$mensaje .= "</small></td>";
												
										$mensaje .= "</tr>";
										
									$mensaje .= "</table>";
									
								}
								
								
								$mensaje .= "<b>DEUDA A LA FECHA:</b> ".$InsMoneda->MonSimbolo." ".number_format($TotalFacturaNoCancelada,2)."";	
								
								//$mensaje .= "TOTAL CREDITO 30 DIAS: <b>".number_format($TotalCredito30,2)."</b>";	
				//				$mensaje .= "<br>";	
				//				$mensaje .= "TOTAL CREDITO MAS DE 30 DIAS: <b>".number_format($TotalCredito30Mas,2)."</b>";	
				//				$mensaje .= "<br>";	
				//				$mensaje .= "TOTAL FACTURAS NO CANCELADAS: <b>".number_format($TotalFacturaNoCancelada,2)."</b>";	
				//				$mensaje .= "<br>";	
								
								
								$mensaje .= "<br>";
								$mensaje .= "<br>";$mensaje .= "<br>";
								$mensaje .= "<br>";
					
					
				}

			
			}
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por SISTEMA CYC a las ".date('d/m/Y H:i:s');
			
			
			echo $mensaje;
			
			if($Enviar ){
				
				if($GET_c == "1"){
					
					$InsCorreo = new ClsCorreo();	
					$InsCorreo->MtdEnviarCorreo("mzamora@cyc.com.pe,scanepam@cyc.com.pe,pzapana@cyc.com.pe,gparedes@cyc.com.pe,epilco@cyc.com.pe,jblanco@cyc.com.pe,jba80@hotmail.com","sistema@cyc.com.pe","C&C S.A.C.","AVISO: FACTURAS X COBRAR - CLIENTES LIMA",$mensaje);
				
				}
				

				
			}
				
				
				
//		}
