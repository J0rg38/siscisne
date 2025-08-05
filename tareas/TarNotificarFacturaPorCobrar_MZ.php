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






require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

$InsFactura = new ClsFactura();
$InsPago = new ClsPago();
//MtdNotificarFacturaPorVencer($oDestinatario,$oCantidadDia=5,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL){
//$InsFactura->MtdNotificarFacturaPorVencer("jblanco@cyc.com.pe,iquezada@cyc.com.pe,pbustamante@cyc.com.pe,lmoreano@cyc.com.pe,cchoque@cyc.com.pe",10,"01/01/".date("Y"),date("d/m/Y"),"NPA-10001");	
//$InsFactura->MtdNotificarFacturaPorVencer("jblanco@cyc.com.pe,cchoque@cyc.com.pe,pbustamante@cyc.com.pe",10,"01/01/".date("Y"),date("d/m/Y"),"NPA-10001");

//public function MtdNotificarFacturaPorVencer($oDestinatario,$oCantidadDia=5,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL){		
//$Enviar = false;

//FncCambiaFechaAMysql($oFechaInicio)
//$FechaInicio = date("d/m/Y");
//$FechaInicio = "01/".date("m")."/".date("Y");
$FechaInicio = "01/01/".date("Y");
$FechaFin = date("d/m/Y");
$Destinatarios = "jblanco@cyc.com.pe,scanepam@cyc.com.pe,pcondori@cyc.com.pe,pzapana@cyc.com.pe,gparedes@cyc.com.pe";
$POST_PersonalId = "PER-10057";


$mensaje .= "<b>NOTIFICACION DE FACTURAS X COBRAR (CLIENTES LIMA)</b>";	
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de notificacion:</b> ".date("d/m/Y")."";	
//$mensaje .= "<br>";	
//$mensaje .= "<b>Mes:</b> ".FncConvertirMes(date("m"))."";	

$mensaje .= "<br>";	

$mensaje .= "<hr>";
$mensaje .= "<br>";


$InsMoneda = new ClsMoneda();
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

foreach($ArrMonedas as $DatMoneda){

	$mensaje .= "<br>";	
	//  MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL) {
	$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","DESC",NULL,NULL,"5",FncCambiaFechaAMysql($FechaInicio),FncCambiaFechaAMysql($FechaFin),NULL,NULL,NULL,"NPA-10001",NULL,$DatMoneda->MonId,NULL,NULL,1,2,NULL,NULL,$POST_PersonalId);
	$ArrFacturas = $ResFactura['Datos'];

	if(!empty($ArrFacturas)){
	
		$mensaje .= $DatMoneda->MonNombre." (".$DatMoneda->MonSimbolo.")" ;
		$mensaje .= "<br>";
		
		
		$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%' border='0'>";
		
		$mensaje .= "<tr>";
		
			$mensaje .= "<td width='2%'>";
			$mensaje .= "<b>#</b>";
			$mensaje .= "</td>";

			$mensaje .= "<td width='10%'>";
			$mensaje .= "<b>Factura</b>";
			$mensaje .= "</td>";

			$mensaje .= "<td width='10%'>";
			$mensaje .= "<b>Fecha</b>";
			$mensaje .= "</td>";
			
			$mensaje .= "<td>";
			$mensaje .= "<b>Cliente</b>";
			$mensaje .= "</td>";

			$mensaje .= "<td width='10%'>";
			$mensaje .= "<b>Total</b>";
			$mensaje .= "</td>";
			
			$mensaje .= "<td width='10%'>";
			$mensaje .= "<b>Amortizado</b>";
			$mensaje .= "</td>";


			$mensaje .= "<td width='5%'>";
			$mensaje .= "<b>Dias/Cred.</b>";
			$mensaje .= "</td>";

			$mensaje .= "<td width='5%'>";
			$mensaje .= "<b>Dias/Transc.</b>";
			$mensaje .= "</td>";
			
			$mensaje .= "<td width='15%'>";
			$mensaje .= "<b>Estado</b>";
			$mensaje .= "</td>";

		$mensaje .= "</tr>";
		
		
				
	$i = 1;	
	
	foreach($ArrFacturas as $DatFactura){

		//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL) {
		$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,3,NULL,NULL,NULL,$DatFactura->MonId,$DatFactura->FacId,$DatFactura->FtaId,NULL,NULL,NULL,NULL,NULL,"PagFecha",NULL);
		$ArrPagos = $ResPago['Datos'];

		if($DatFactura->MonId<>$EmpresaMonedaId){
			$DatFactura->FacTotal = round($DatFactura->FacTotal / $DatFactura->FacTipoCambio,2);
//			$DatFactura->FacMontoAmortizado = ($DatFactura->FacMontoAmortizado / $DatFactura->FacTipoCambio);
		}
		
		$Amortizado = 0;
		
		if(!empty($ArrPagos)){
			foreach($ArrPagos as $DatPago){
					
				if($DatPago->MonId<>$EmpresaMonedaId){
					$DatPago->PagMonto = round($DatPago->PagMonto / $DatPago->PagTipoCambio,2);
				}
				
				$Amortizado += $DatPago->PagMonto;
						
			}
		}
	
		$Dias = $DatFactura->FacCantidadDia - $DatFactura->FacDiaTranscurrido;
		
		//if($Dias<=$oCantidadDia){
			
			if($DatFactura->FacTotal > $Amortizado){
				
				$mensaje .= "<tr>";
							
					$mensaje .= "<td>";
					$mensaje .= $i;
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
					$mensaje .= number_format($DatFactura->FacTotal,2);
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= number_format($Amortizado,2);
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatFactura->FacCantidadDia;
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= $DatFactura->FacDiaTranscurrido;
					$mensaje .= "</td>";
					
					
					
					$Estado = "";
					
					if($DatFactura->FacDiaTranscurrido < $DatFactura->FacCantidadDia){
						
						$Estado = "VIGENTE";
						
					}else if($DatFactura->FacDiaTranscurrido > $DatFactura->FacCantidadDia){
						
						$Vencido = $DatFactura->FacDiaTranscurrido - $DatFactura->FacCantidadDia;
						$Estado = "VENCIDO ".$Vencido." DIAS";

					}else if($DatFactura->FacDiaTranscurrido == $DatFactura->FacCantidadDia){
						
						$Estado = "VENCE HOY";
						
					}
					
					$mensaje .= "<td>";
					$mensaje .= $Estado;
					$mensaje .= "</td>";


				$mensaje .= "</tr>";
					
			}
			
			
			$i++;				
			
		//}
			
			$Enviar = true;
		
							
	}
	

		
			
		$mensaje .= "</table>";
		
		
	}
	
}

$mensaje .= "<br>";
$mensaje .= "<br>";
$mensaje .= "Mensaje autogenerado por sistema SISCYC a las ".date('d/m/Y H:i:s');


echo $mensaje;

if($Enviar){
	
	$InsCorreo = new ClsCorreo();	
	$InsCorreo->MtdEnviarCorreo($Destinatarios,"sistema@cyc.com.pe","C&C S.A.C.","NOTIFICACION: FACTURAS X COBRAR (CLIENTES LIMA)",$mensaje);
	
}
				
				
				
?>