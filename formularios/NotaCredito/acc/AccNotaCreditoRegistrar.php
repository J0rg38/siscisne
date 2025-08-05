<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsNotaCredito->NcrId = $_POST['CmpId'];
	$InsNotaCredito->NctId = $_POST['CmpTalonario'];
	$InsNotaCredito->SucId = $_SESSION['SesionSucursal'];
	$InsNotaCredito->CliId = $_POST['CmpClienteId'];

	$InsNotaCredito->UsuId = $_SESSION['SesionId'];
	
	
	$InsNotaCredito->DocId = $_POST['CmpDocumentoId'];
	$InsNotaCredito->DtaId = $_POST['CmpDocumentoTalonario'];
	$InsNotaCredito->DtaNumero = $_POST['CmpDocumentoTalonarioNumero'];
	$InsNotaCredito->NcrPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsNotaCredito->NcrPorcentajeImpuestoSelectivo = $_POST['CmpPorcentajeImpuestoSelectivo'];
	$InsNotaCredito->NcrTipo = $_POST['CmpTipo'];
	
	$InsNotaCredito->NcrEstado = $_POST['CmpEstado'];
	$InsNotaCredito->NcrFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsNotaCredito->NcrObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	$InsNotaCredito->NcrMotivo = addslashes($_POST['CmpMotivo']);
	$InsNotaCredito->NcrMotivoCodigo = $_POST['CmpMotivoCodigo'];
	
	$InsNotaCredito->MonId = $_POST['CmpMonedaId'];
	$InsNotaCredito->NcrTipoCambio = $_POST['CmpTipoCambio'];
	$InsNotaCredito->NcrIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	
	$InsNotaCredito->NcrCierre = 1;
	$InsNotaCredito->NcrUsuario =  $_SESSION['SesionUsuario'];
	$InsNotaCredito->NcrTiempoCreacion = date("Y-m-d H:i:s");
	$InsNotaCredito->NcrTiempoModificacion = date("Y-m-d H:i:s");
	$InsNotaCredito->NcrEliminado = 1;
	
	$InsNotaCredito->CliNombre = $_POST['CmpClienteNombre'];
	$InsNotaCredito->TdoId = $_POST['CmpTipoDocumento'];	
	$InsNotaCredito->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsNotaCredito->NcrDireccion = $_POST['CmpClienteDireccion'];
	$InsNotaCredito->CliTelefono = $_POST['CmpClienteTelefono'];
	$InsNotaCredito->CliEmail = $_POST['CmpClienteEmail'];
	$InsNotaCredito->CliCelular = $_POST['CmpClienteCelular'];
	$InsNotaCredito->CliFax = $_POST['CmpClienteFax'];

	
		
	$InsNotaCredito->NcrUsuario = $_POST['CmpUsuario'];
	$InsNotaCredito->NcrVendedor = $_POST['CmpVendedor'];
	$InsNotaCredito->NcrNumeroPedido = $_POST['CmpNumeroPedido'];
	
	
	$InsNotaCredito->NotaCreditoDetalle = array();	


	$InsNotaCredito->NcrProcesar = $_POST['CmpProcesar'];
	$InsNotaCredito->NcrEnviarSUNAT = $_POST['CmpEnviarSUNAT'];
	
	$InsNotaCredito->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsNotaCredito->VdiId = $_POST['CmpVentaDirectaId'];

	$InsNotaCredito->VmvId = $_POST['CmpVehiculoMovimientoId'];
	$InsNotaCredito->AmoId = $_POST['CmpAlmacenMovimientoId'];
		
	$InsNotaCredito->NcrDatoAdicional1 = $_SESSION['InsNotaCreditoDatoAdicional1'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional2 = $_SESSION['InsNotaCreditoDatoAdicional2'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional3 = $_SESSION['InsNotaCreditoDatoAdicional3'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional4 = $_SESSION['InsNotaCreditoDatoAdicional4'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional5 = $_SESSION['InsNotaCreditoDatoAdicional5'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional6 = $_SESSION['InsNotaCreditoDatoAdicional6'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional7 = $_SESSION['InsNotaCreditoDatoAdicional7'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional8 = $_SESSION['InsNotaCreditoDatoAdicional8'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional9 = $_SESSION['InsNotaCreditoDatoAdicional9'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional10 = $_SESSION['InsNotaCreditoDatoAdicional10'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional11 = $_SESSION['InsNotaCreditoDatoAdicional11'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional12 = $_SESSION['InsNotaCreditoDatoAdicional12'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional13 = $_SESSION['InsNotaCreditoDatoAdicional13'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional14 = $_SESSION['InsNotaCreditoDatoAdicional14'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional15 = $_SESSION['InsNotaCreditoDatoAdicional15'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional16 = $_SESSION['InsNotaCreditoDatoAdicional16'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional17 = $_SESSION['InsNotaCreditoDatoAdicional17'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional18 = $_SESSION['InsNotaCreditoDatoAdicional18'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional19 = $_SESSION['InsNotaCreditoDatoAdicional19'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional20 = $_SESSION['InsNotaCreditoDatoAdicional20'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional21 = $_SESSION['InsNotaCreditoDatoAdicional21'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional22 = $_SESSION['InsNotaCreditoDatoAdicional22'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional23 = $_SESSION['InsNotaCreditoDatoAdicional23'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional24 = $_SESSION['InsNotaCreditoDatoAdicional24'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional25 = $_SESSION['InsNotaCreditoDatoAdicional25'.$Identificador];
	
	$InsNotaCredito->NcrDatoAdicional26 = $_SESSION['InsNotaCreditoDatoAdicional26'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional27 = $_SESSION['InsNotaCreditoDatoAdicional27'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional28 = $_SESSION['InsNotaCreditoDatoAdicional28'.$Identificador];
	
		
/*
SesionObjeto-NotaCreditoDetalleListado
Parametro1 = NcdId
Parametro2 = NcdDescripcion
Parametro3 = 
Parametro4 = NcdPrecio
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaId;
Parametro12 = NcdTipo

Parametro13 = NcdUnidadMedida
Parametro14 = AmdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = NcdCodigo
Parametro19 = NcdValorVenta
Parametro20 = NcdImpuesto
Parametro21 = NcdDescuentom
Parametro22 = NcdGratuito
Parametro23 = NcdExonerado	


Parametro25 = NcdIncluyeSelectivo	

*/

$InsNotaCredito->NcrTotalBruto = 0;
$InsNotaCredito->NcrTotalGravado = 0;
$InsNotaCredito->NcrTotalExonerado = 0;
$InsNotaCredito->NcrTotalGratuito = 0;
$InsNotaCredito->NcrTotalDescuentoNoExonerado = 0;
$InsNotaCredito->NcrTotalValorBruto = 0;
$InsNotaCredito->NcrTotalPagar= 0;
$InsNotaCredito->NcrTotalDescuento= 0;
$InsNotaCredito->NcrTotalImpuestoSelectivo= 0;
	
$InsNotaCredito->NcrSubTotal = 0;
$InsNotaCredito->NcrImpuesto = 0;
$InsNotaCredito->NcrTotal = 0;

$ResNotaCreditoDetalle = $_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO

	if(is_array($ResNotaCreditoDetalle['Datos'])){
		foreach($ResNotaCreditoDetalle['Datos'] as $DatSesionObjeto){
			
			if($InsNotaCredito->MonId<>$EmpresaMonedaId){
			
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsNotaCredito->NcrTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsNotaCredito->NcrTipoCambio;
				
				$DatSesionObjeto->Parametro19 = $DatSesionObjeto->Parametro19 * $InsNotaCredito->NcrTipoCambio;
				$DatSesionObjeto->Parametro20 = $DatSesionObjeto->Parametro20 * $InsNotaCredito->NcrTipoCambio;
				$DatSesionObjeto->Parametro21 = $DatSesionObjeto->Parametro21 * $InsNotaCredito->NcrTipoCambio;
				$DatSesionObjeto->Parametro25 = $DatSesionObjeto->Parametro25 * $InsNotaCredito->NcrTipoCambio;
				
			}
			
			$InsNotaCreditoDetalle1 = new ClsNotaCreditoDetalle();
			$InsNotaCreditoDetalle1->NcdId = $DatSesionObjeto->Parametro1;					
			$InsNotaCreditoDetalle1->OdeId = $DatSesionObjeto->Parametro9;			
			$InsNotaCreditoDetalle1->NcdTipo = $DatSesionObjeto->Parametro12;			
			
			if($InsNotaCreditoDetalle1->NcdTipo<>"T"){
				$InsNotaCreditoDetalle1->NcdDescripcion = utf8_encode(htmlentities($DatSesionObjeto->Parametro2));	
			}else{
				$InsNotaCreditoDetalle1->NcdDescripcion = addslashes(utf8_encode(($DatSesionObjeto->Parametro2)));
			}
			
			$InsNotaCreditoDetalle1->NcdPrecio = $DatSesionObjeto->Parametro4;
			$InsNotaCreditoDetalle1->NcdCantidad = $DatSesionObjeto->Parametro5;
			$InsNotaCreditoDetalle1->NcdImporte = $DatSesionObjeto->Parametro6;
			
			$InsNotaCreditoDetalle1->NcdValorVenta = $DatSesionObjeto->Parametro19;
			$InsNotaCreditoDetalle1->NcdImpuesto = $DatSesionObjeto->Parametro20;
			$InsNotaCreditoDetalle1->NcdDescuento = $DatSesionObjeto->Parametro21;
			$InsNotaCreditoDetalle1->NcdImpuestoSelectivo = $DatSesionObjeto->Parametro25;
			
			$InsNotaCreditoDetalle1->NcdGratuito = 2;
			$InsNotaCreditoDetalle1->NcdExonerado = (empty($DatSesionObjeto->Parametro23)?2:$DatSesionObjeto->Parametro23);				
			$InsNotaCreditoDetalle1->NcdIncluyeSelectivo = $DatSesionObjeto->Parametro24;
			
			$InsNotaCreditoDetalle1->NcdCodigo = $DatSesionObjeto->Parametro18;
			$InsNotaCreditoDetalle1->NcdUnidadMedida = $DatSesionObjeto->Parametro13;
			
			$InsNotaCreditoDetalle1->NcdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsNotaCreditoDetalle1->NcdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsNotaCreditoDetalle1->NcdEliminado = $DatSesionObjeto->Eliminado;				
			$InsNotaCreditoDetalle1->InsMysql = NULL;
			
			
			if($InsNotaCreditoDetalle1->NcdEliminado==1){		
				
				$InsNotaCredito->NcrTotalBruto += $InsNotaCreditoDetalle1->NcdImporte;	
									
				//EXONERADO
				if($InsNotaCreditoDetalle1->NcdExonerado == 1){						
					$InsNotaCredito->NcrTotalExonerado += $InsNotaCreditoDetalle1->NcdValorVenta;
				}
				
				//GRAVADO
				if($InsNotaCreditoDetalle1->NcdExonerado == 2 and $InsNotaCreditoDetalle1->NcdGratuito == 2){			
					$InsNotaCredito->NcrTotalGravado += $InsNotaCreditoDetalle1->NcdValorVenta;
				}
				
				//VALOR BRUTO
				if($InsNotaCreditoDetalle1->NcdGratuito == 2){		
					$InsNotaCredito->NcrTotalValorBruto += $InsNotaCreditoDetalle1->NcdValorVenta;
				}
				
				//GRATUITO
				if($InsNotaCreditoDetalle1->NcdGratuito == 1){			
					$InsNotaCredito->NcrTotalGratuito += $InsNotaCreditoDetalle1->NcdValorVenta;			
				}
				
				//INCLUYE SELECTIVO
				if($InsNotaCreditoDetalle1->FdeIncluyeSelectivo == 1){			
					$InsNotaCredito->NcrTotalImpuestoSelectivo += ($InsFacturaDetalle1->NcdImpuestoSelectivo);
				}	
				
				//TOTAL PAGAR								
				if($InsNotaCreditoDetalle1->NcdGratuito == 2){	
					if($InsNotaCreditoDetalle1->NcdExonerado == 2){
						$InsNotaCredito->NcrTotalPagar += 	( ($InsNotaCreditoDetalle1->NcdValorVenta  ) * ( ($InsNotaCredito->NcrPorcentajeImpuestoVenta/100)+1) ) * ( (100 - $InsNotaCredito->NcrPorcentajeDescuento)/100 ) ;
					}else{
						$InsNotaCredito->NcrTotalPagar += 	($InsNotaCreditoDetalle1->NcdValorVenta ) * ( (100 - $InsNotaCredito->NcrPorcentajeDescuento)/100 );	
					}
				}
				
				$InsNotaCredito->NcrTotalDescuento += $InsNotaCreditoDetalle1->NcdDescuento;
				
				$InsNotaCredito->NotaCreditoDetalle[] = $InsNotaCreditoDetalle1;	
				
			}
						
		}	
			
	}
	
	$InsNotaCredito->NcrSubTotal = ($InsNotaCredito->NcrTotalGravado);
	$InsNotaCredito->NcrImpuesto = (($InsNotaCredito->NcrSubTotal + $InsNotaCredito->NcrTotalImpuestoSelectivo ) * ($InsNotaCredito->NcrPorcentajeImpuestoVenta/100));
	$InsNotaCredito->NcrTotal = ($InsNotaCredito->NcrSubTotal+ $InsNotaCredito->NcrTotalImpuestoSelectivo +  $InsNotaCredito->NcrTotalExonerado + $InsNotaCredito->NcrImpuesto);

	if($InsNotaCredito->MtdRegistrarNotaCredito()){
		
		if(!empty($InsNotaCredito->OvvId)){
			
			//MtdObtenerVehiculoMovimientoSalidas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VmvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCliente=NULL,$oFecha="VmvFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oSubTipo=NULL,$oOrdenVentaVehiculoId=NULL)
			$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();	
					
			if($InsOrdenVentaVehiculo->MtdGenerarVehiculoMovimientoEntradaDevolucion($InsNotaCredito->OvvId)){
			
			}
	
		}
		
	//	if($InsNotaCredito->NcrNotificar=="1"){
//			$InsNotaCredito->MtdNotificarNotaCreditoRegistro($InsNotaCredito->NcrId,$InsNotaCredito->NctId,$CorreosNotificacionFacturaRegistro);
//		}
		
		$InsNotaCreditoTalonario = new ClsNotaCreditoTalonario();
		$InsNotaCreditoTalonario->NctId = $InsNotaCredito->NctId;
		$InsNotaCreditoTalonario->MtdObtenerNotaCreditoTalonario();		
		
		if(substr($InsNotaCreditoTalonario->NctNumero,0,1)=="F" || substr($InsNotaCreditoTalonario->NctNumero,0,1)=="B"){
		
				if($InsNotaCredito->NcrProcesar=="1"){
		?>
			  <script type="text/javascript">
                    $().ready(function() {
                    /*
                    Configuracion carga de datos y animacion
                    */			
                   		FncNotaCreditoGenerarXMLv2('<?php echo $InsNotaCredito->NcrId;?>','<?php echo $InsNotaCredito->NctId;?>','',1,1);		
                    });
                </script>
        <?php			
			}	
		}
			
		$Registro = true;	
		$Resultado.='#SAS_NCR_101';
	} else{
		$Resultado.='#ERR_NCR_101';
	}
	
	$InsNotaCredito->NcrFechaEmision = FncCambiaFechaANormal($InsNotaCredito->NcrFechaEmision);
	list($InsNotaCredito->NcrObservacion,$InsNotaCredito->NcrObservacionImpresa) = explode("###",$InsNotaCredito->NcrObservacion);
	
	
	
}else{

	unset($_SESSION['InsNotaCreditoDetalle'.$Identificador]);	

	$_SESSION['InsNotaCreditoDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsNotaCredito->NcrFechaEmision = date("d/m/Y");	
	$InsNotaCredito->NcrTipo = 2;
	
	$InsNotaCredito->NcrNotificar = 0;
	$InsNotaCredito->NcrProcesar = 1;
	$InsNotaCredito->NcrEnviarSUNAT = 1;
	$InsNotaCredito->SucId = $_SESSION['SesionSucursal'];

	switch($GET_ori){
				
		//Factura
		case "Factura":
	
		if(!empty($GET_id) and !empty($GET_ta)){
			
			$InsFactura = new ClsFactura();
			$InsFactura->FacId = $GET_id;
			$InsFactura->FtaId = $GET_ta;
			$InsFactura->MtdObtenerFactura();

			$InsNotaCredito->CliId = $InsFactura->CliId;		
			$InsNotaCredito->CliNombre = $InsFactura->CliNombre;
			$InsNotaCredito->CliApellidoPaterno = $InsFactura->CliApellidoPaterno;
			$InsNotaCredito->CliApellidoMaterno = $InsFactura->CliApellidoMaterno;
			
			$InsNotaCredito->TdoId = $InsFactura->TdoId;
			$InsNotaCredito->CliNumeroDocumento = $InsFactura->CliNumeroDocumento;
			$InsNotaCredito->NcrDireccion = $InsFactura->FacDireccion;
			$InsNotaCredito->NcrTelefono = $InsFactura->FacTelefono;
			$InsNotaCredito->NcrObservacion = $InsFactura->FacObservacion;		
			$InsNotaCredito->MonId = $InsFactura->MonId;	
			$InsNotaCredito->NcrTipoCambio = $InsFactura->FacTipoCambio;	
				
			$InsNotaCredito->NcrIncluyeImpuesto = $InsFactura->FacIncluyeImpuesto;			
			$InsNotaCredito->NcrPorcentajeImpuestoVenta = $InsFactura->FacPorcentajeImpuestoVenta;
			$InsNotaCredito->NcrPorcentajeImpuestoSelectivo = (empty($InsFactura->FacPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsFactura->FacPorcentajeImpuestoSelectivo);		
				
			$InsNotaCredito->NcrEstado = 5;			
			$InsNotaCredito->NcrTipo = 2;
			$InsNotaCredito->DocId = $InsFactura->FacId;
			$InsNotaCredito->DtaId = $InsFactura->FtaId;
			$InsNotaCredito->DtaNumero = $InsFactura->FtaNumero;
			
			$InsNotaCredito->OvvId = $InsFactura->OvvId;
			
			$_SESSION['InsNotaCreditoDatoAdicional1'.$Identificador] = $InsFactura->FacDatoAdicional1;
			$_SESSION['InsNotaCreditoDatoAdicional2'.$Identificador] = $InsFactura->FacDatoAdicional2;
			$_SESSION['InsNotaCreditoDatoAdicional3'.$Identificador] = $InsFactura->FacDatoAdicional3;
			$_SESSION['InsNotaCreditoDatoAdicional4'.$Identificador] = $InsFactura->FacDatoAdicional4;
			$_SESSION['InsNotaCreditoDatoAdicional5'.$Identificador] = $InsFactura->FacDatoAdicional5;
			$_SESSION['InsNotaCreditoDatoAdicional6'.$Identificador] = $InsFactura->FacDatoAdicional6;
			$_SESSION['InsNotaCreditoDatoAdicional7'.$Identificador] = $InsFactura->FacDatoAdicional7;
			$_SESSION['InsNotaCreditoDatoAdicional8'.$Identificador] = $InsFactura->FacDatoAdicional8;
			$_SESSION['InsNotaCreditoDatoAdicional9'.$Identificador] = $InsFactura->FacDatoAdicional9;
			$_SESSION['InsNotaCreditoDatoAdicional10'.$Identificador] = $InsFactura->FacDatoAdicional10;
			
			$_SESSION['InsNotaCreditoDatoAdicional11'.$Identificador] = $InsFactura->FacDatoAdicional11;
			$_SESSION['InsNotaCreditoDatoAdicional12'.$Identificador] = $InsFactura->FacDatoAdicional12;
			$_SESSION['InsNotaCreditoDatoAdicional13'.$Identificador] = $InsFactura->FacDatoAdicional13;
			$_SESSION['InsNotaCreditoDatoAdicional14'.$Identificador] = $InsFactura->FacDatoAdicional14;
			$_SESSION['InsNotaCreditoDatoAdicional15'.$Identificador] = $InsFactura->FacDatoAdicional15;
			$_SESSION['InsNotaCreditoDatoAdicional16'.$Identificador] = $InsFactura->FacDatoAdicional16;
			$_SESSION['InsNotaCreditoDatoAdicional17'.$Identificador] = $InsFactura->FacDatoAdicional17;
			$_SESSION['InsNotaCreditoDatoAdicional18'.$Identificador] = $InsFactura->FacDatoAdicional18;
			$_SESSION['InsNotaCreditoDatoAdicional19'.$Identificador] = $InsFactura->FacDatoAdicional19;
			$_SESSION['InsNotaCreditoDatoAdicional20'.$Identificador] = $InsFactura->FacDatoAdicional20;

			$_SESSION['InsNotaCreditoDatoAdicional21'.$Identificador] = $InsFactura->FacDatoAdicional21;
			$_SESSION['InsNotaCreditoDatoAdicional22'.$Identificador] = $InsFactura->FacDatoAdicional22;
			$_SESSION['InsNotaCreditoDatoAdicional23'.$Identificador] = $InsFactura->FacDatoAdicional23;
			$_SESSION['InsNotaCreditoDatoAdicional24'.$Identificador] = $InsFactura->FacDatoAdicional24;
			$_SESSION['InsNotaCreditoDatoAdicional25'.$Identificador] = $InsFactura->FacDatoAdicional25;
			
			$_SESSION['InsNotaCreditoDatoAdicional26'.$Identificador] = $InsFactura->FacDatoAdicional26;
			$_SESSION['InsNotaCreditoDatoAdicional27'.$Identificador] = $InsFactura->FacDatoAdicional27;
			$_SESSION['InsNotaCreditoDatoAdicional28'.$Identificador] = $InsFactura->FacDatoAdicional28;

			if(is_array($InsFactura->FacturaDetalle)){			
				foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){

				if($InsFactura->MonId<>$EmpresaMonedaId ){

					$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio);
					$DatFacturaDetalle->FdePrecio = ($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio);
					$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta  / $InsFactura->FacTipoCambio);
					$DatFacturaDetalle->FdeImpuesto = ($DatFacturaDetalle->FdeImpuesto  / $InsFactura->FacTipoCambio);
					$DatFacturaDetalle->FdeImpuestoSelectivo = ($DatFacturaDetalle->FdeImpuestoSelectivo  / $InsFactura->FacTipoCambio);
					$DatFacturaDetalle->FdeDescuento = ($DatFacturaDetalle->FdeDescuento  / $InsFactura->FacTipoCambio);

				}
						
				/*
				SesionObjeto-NotaCreditoDetalleListado
				Parametro1 = NcdId
				Parametro2 = NcdDescripcion
				Parametro3 = 
				Parametro4 = NcdPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NcdTipo
				
				Parametro13 = NcdUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NcdCodigo
				Parametro19 = NcdValorVenta
				Parametro20 = NcdImpuesto
				Parametro21 = NcdDescuentom
				Parametro22 = NcdGratuito
				Parametro23 = NcdExonerado	
				
				Parametro24 = NcdIncluyeSelectivo
				Parametro25 = NcdImpuestoSelectivo
				*/
					$_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatFacturaDetalle->FdeDescripcion,
					NULL,
					$DatFacturaDetalle->FdePrecio,
					$DatFacturaDetalle->FdeCantidad,
					$DatFacturaDetalle->FdeImporte,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					NULL,
					NULL,
					NULL,
					NULL,
					
					$DatFacturaDetalle->FdeUnidadMedida,
					2,
										
					NULL,
					NULL,
					NULL,
					
					$DatFacturaDetalle->FdeCodigo,
					$DatFacturaDetalle->FdeValorVenta,
					$DatFacturaDetalle->FdeImpuesto,
					$DatFacturaDetalle->FdeDescuento,
					$DatFacturaDetalle->FdeGratuito,
					$DatFacturaDetalle->FdeExonerado,
					
					$DatFacturaDetalle->FdeIncluyeSelectivo,
					$DatFacturaDetalle->FdeImpuestoSelectivo				
					);	

				}		
			}
			
		}else{
			
			
			$ArrFacturas = array();
			$Factura = array();
					
			$ArrFacturas = explode("#",$_POST['cmp_seleccionados']);
			$ArrFacturas = array_filter($ArrFacturas);
					
			foreach($ArrFacturas as $DatFactura){
				
				$Factura = explode("%",$DatFactura);
				
				$InsFactura = new ClsFactura();
				$InsFactura->FacId = $Factura[0];	
				$InsFactura->FtaId = $Factura[1];	
				$InsFactura->MtdObtenerFactura();

				$InsNotaCredito->CliId = $InsFactura->CliId;		
				$InsNotaCredito->CliNombre = $InsFactura->CliNombre;
				$InsNotaCredito->CliApellidoPaterno = $InsFactura->CliApellidoPaterno;
				$InsNotaCredito->CliApellidoMaterno = $InsFactura->CliApellidoMaterno;
				$InsNotaCredito->TdoId = $InsFactura->TdoId;
				$InsNotaCredito->CliNumeroDocumento = $InsFactura->CliNumeroDocumento;
				$InsNotaCredito->NcrDireccion = $InsFactura->FacDireccion;
				$InsNotaCredito->NcrTelefono = $InsFactura->FacTelefono;
				$InsNotaCredito->NcrObservacion = $InsFactura->FacObservacion;	
				$InsNotaCredito->MonId = $InsFactura->MonId;	
				$InsNotaCredito->NcrTipoCambio = $InsFactura->FacTipoCambio;		
				
				$InsNotaCredito->NcrIncluyeImpuesto = $InsFactura->FacIncluyeImpuesto;	
				$InsNotaCredito->NcrPorcentajeImpuestoVenta = $InsFactura->FacPorcentajeImpuestoVenta;	
//				$InsNotaCredito->NcrPorcentajeImpuestoSelectivo = $InsFactura->FacPorcentajeImpuestoSelectivo;	
				$InsNotaCredito->NcrPorcentajeImpuestoSelectivo = (empty($InsFactura->FacPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsFactura->FacPorcentajeImpuestoSelectivo);		
							
				$InsNotaCredito->NcrEstado = 5;
				
				$InsNotaCredito->NcrTipo = 2;
				$InsNotaCredito->DocId = $InsFactura->FacId;
				$InsNotaCredito->DtaId = $InsFactura->FtaId;
				$InsNotaCredito->DtaNumero = $InsFactura->FtaNumero;
	
				$InsNotaCredito->OvvId = $InsFactura->OvvId;
				
				$_SESSION['InsNotaCreditoDatoAdicional1'.$Identificador] = $InsFactura->FacDatoAdicional1;
				$_SESSION['InsNotaCreditoDatoAdicional2'.$Identificador] = $InsFactura->FacDatoAdicional2;
				$_SESSION['InsNotaCreditoDatoAdicional3'.$Identificador] = $InsFactura->FacDatoAdicional3;
				$_SESSION['InsNotaCreditoDatoAdicional4'.$Identificador] = $InsFactura->FacDatoAdicional4;
				$_SESSION['InsNotaCreditoDatoAdicional5'.$Identificador] = $InsFactura->FacDatoAdicional5;
				$_SESSION['InsNotaCreditoDatoAdicional6'.$Identificador] = $InsFactura->FacDatoAdicional6;
				$_SESSION['InsNotaCreditoDatoAdicional7'.$Identificador] = $InsFactura->FacDatoAdicional7;
				$_SESSION['InsNotaCreditoDatoAdicional8'.$Identificador] = $InsFactura->FacDatoAdicional8;
				$_SESSION['InsNotaCreditoDatoAdicional9'.$Identificador] = $InsFactura->FacDatoAdicional9;
				$_SESSION['InsNotaCreditoDatoAdicional10'.$Identificador] = $InsFactura->FacDatoAdicional10;
				
				$_SESSION['InsNotaCreditoDatoAdicional11'.$Identificador] = $InsFactura->FacDatoAdicional11;
				$_SESSION['InsNotaCreditoDatoAdicional12'.$Identificador] = $InsFactura->FacDatoAdicional12;
				$_SESSION['InsNotaCreditoDatoAdicional13'.$Identificador] = $InsFactura->FacDatoAdicional13;
				$_SESSION['InsNotaCreditoDatoAdicional14'.$Identificador] = $InsFactura->FacDatoAdicional14;
				$_SESSION['InsNotaCreditoDatoAdicional15'.$Identificador] = $InsFactura->FacDatoAdicional15;
				$_SESSION['InsNotaCreditoDatoAdicional16'.$Identificador] = $InsFactura->FacDatoAdicional16;
				$_SESSION['InsNotaCreditoDatoAdicional17'.$Identificador] = $InsFactura->FacDatoAdicional17;
				$_SESSION['InsNotaCreditoDatoAdicional18'.$Identificador] = $InsFactura->FacDatoAdicional18;
				$_SESSION['InsNotaCreditoDatoAdicional19'.$Identificador] = $InsFactura->FacDatoAdicional19;
				$_SESSION['InsNotaCreditoDatoAdicional20'.$Identificador] = $InsFactura->FacDatoAdicional20;
				
				$_SESSION['InsNotaCreditoDatoAdicional21'.$Identificador] = $InsFactura->FacDatoAdicional21;
				$_SESSION['InsNotaCreditoDatoAdicional22'.$Identificador] = $InsFactura->FacDatoAdicional22;
				$_SESSION['InsNotaCreditoDatoAdicional23'.$Identificador] = $InsFactura->FacDatoAdicional23;
				$_SESSION['InsNotaCreditoDatoAdicional24'.$Identificador] = $InsFactura->FacDatoAdicional24;
				$_SESSION['InsNotaCreditoDatoAdicional25'.$Identificador] = $InsFactura->FacDatoAdicional25;
				
				$_SESSION['InsNotaCreditoDatoAdicional26'.$Identificador] = $InsFactura->FacDatoAdicional26;
				$_SESSION['InsNotaCreditoDatoAdicional27'.$Identificador] = $InsFactura->FacDatoAdicional27;
				$_SESSION['InsNotaCreditoDatoAdicional28'.$Identificador] = $InsFactura->FacDatoAdicional28;
				
				if(is_array($InsFactura->FacturaDetalle)){
					foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){
						
						if($InsFactura->MonId<>$EmpresaMonedaId ){
							
							$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio);
							$DatFacturaDetalle->FdePrecio = ($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio);
							
							$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta  / $InsFactura->FacTipoCambio);
							$DatFacturaDetalle->FdeImpuesto = ($DatFacturaDetalle->FdeImpuesto  / $InsFactura->FacTipoCambio);
							$DatFacturaDetalle->FdeImpuestoSelectivo = ($DatFacturaDetalle->FdeImpuestoSelectivo  / $InsFactura->FacTipoCambio);
							$DatFacturaDetalle->FdeDescuento = ($DatFacturaDetalle->FdeDescuento  / $InsFactura->FacTipoCambio);
							
						}
								
				/*
				SesionObjeto-NotaCreditoDetalleListado
				Parametro1 = NcdId
				Parametro2 = NcdDescripcion
				Parametro3 = 
				Parametro4 = NcdPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NcdTipo
				
				Parametro13 = NcdUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NcdCodigo
				Parametro19 = NcdValorVenta
				Parametro20 = NcdImpuesto
				Parametro21 = NcdDescuentom
				Parametro22 = NcdGratuito
				Parametro23 = NcdExonerado	
				
				Parametro24 = NcdIncluyeSelectivo
				Parametro25 = NcdImpuestoSelectivo
				*/
						
					$_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatFacturaDetalle->FdeDescripcion,
					NULL,
					$DatFacturaDetalle->FdePrecio,
					$DatFacturaDetalle->FdeCantidad,
					$DatFacturaDetalle->FdeImporte,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					NULL,
					NULL,
					NULL,
					NULL,
					
					$DatFacturaDetalle->FdeUnidadMedida,
					2,
										
					NULL,
					NULL,
					NULL,
					
					$DatFacturaDetalle->FdeCodigo,
					$DatFacturaDetalle->FdeValorVenta,
					$DatFacturaDetalle->FdeImpuesto,
					$DatFacturaDetalle->FdeDescuento,
					$DatFacturaDetalle->FdeGratuito,
					$DatFacturaDetalle->FdeExonerado,
					
					$DatFacturaDetalle->FdeIncluyeSelectivo,
					$DatFacturaDetalle->FdeImpuestoSelectivo				
					);	
	
					}		
				}

						
			}
					
		}
		
		break;
		
		
		
		case "Boleta":
	
		if(!empty($GET_id) and !empty($GET_ta)){
			
			$InsBoleta = new ClsBoleta();
			$InsBoleta->BolId = $GET_id;
			$InsBoleta->BtaId = $GET_ta;
			$InsBoleta->MtdObtenerBoleta();

			$InsNotaCredito->CliId = $InsBoleta->CliId;		
			$InsNotaCredito->CliNombre = $InsBoleta->CliNombre;
			$InsNotaCredito->CliApellidoPaterno = $InsBoleta->CliApellidoPaterno;
			$InsNotaCredito->CliApellidoMaterno = $InsBoleta->CliApellidoMaterno;
			
			$InsNotaCredito->TdoId = $InsBoleta->TdoId;
			$InsNotaCredito->CliNumeroDocumento = $InsBoleta->CliNumeroDocumento;
			$InsNotaCredito->NcrDireccion = $InsBoleta->BolDireccion;
			$InsNotaCredito->NcrTelefono = $InsBoleta->BolTelefono;
			$InsNotaCredito->NcrObservacion = $InsBoleta->BolObservacion;		

			$InsNotaCredito->MonId = $InsBoleta->MonId;	
			$InsNotaCredito->NcrTipoCambio = $InsBoleta->BolTipoCambio;		

			$InsNotaCredito->NcrIncluyeImpuesto = $InsBoleta->BolIncluyeImpuesto;		
			$InsNotaCredito->NcrPorcentajeImpuestoVenta = $InsBoleta->BolPorcentajeImpuestoVenta;		
//			$InsNotaCredito->NcrPorcentajeImpuestoSelectivo = $InsBoleta->BolPorcentajeImpuestoSelectivo;		
			$InsNotaCredito->NcrPorcentajeImpuestoSelectivo = (empty($InsBoleta->BolPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsBoleta->BolPorcentajeImpuestoSelectivo);		
				
			$InsNotaCredito->NcrEstado = 5;			
			$InsNotaCredito->NcrTipo = 3;
			$InsNotaCredito->DocId = $InsBoleta->BolId;
			$InsNotaCredito->DtaId = $InsBoleta->BtaId;
			$InsNotaCredito->DtaNumero = $InsBoleta->BtaNumero;
			
			$InsNotaCredito->OvvId = $InsBoleta->OvvId;
			
			$_SESSION['InsNotaCreditoDatoAdicional1'.$Identificador] = $InsBoleta->BolDatoAdicional1;
			$_SESSION['InsNotaCreditoDatoAdicional2'.$Identificador] = $InsBoleta->BolDatoAdicional2;
			$_SESSION['InsNotaCreditoDatoAdicional3'.$Identificador] = $InsBoleta->BolDatoAdicional3;
			$_SESSION['InsNotaCreditoDatoAdicional4'.$Identificador] = $InsBoleta->BolDatoAdicional4;
			$_SESSION['InsNotaCreditoDatoAdicional5'.$Identificador] = $InsBoleta->BolDatoAdicional5;
			$_SESSION['InsNotaCreditoDatoAdicional6'.$Identificador] = $InsBoleta->BolDatoAdicional6;
			$_SESSION['InsNotaCreditoDatoAdicional7'.$Identificador] = $InsBoleta->BolDatoAdicional7;
			$_SESSION['InsNotaCreditoDatoAdicional8'.$Identificador] = $InsBoleta->BolDatoAdicional8;
			$_SESSION['InsNotaCreditoDatoAdicional9'.$Identificador] = $InsBoleta->BolDatoAdicional9;
			$_SESSION['InsNotaCreditoDatoAdicional10'.$Identificador] = $InsBoleta->BolDatoAdicional10;
			
			$_SESSION['InsNotaCreditoDatoAdicional11'.$Identificador] = $InsBoleta->BolDatoAdicional11;
			$_SESSION['InsNotaCreditoDatoAdicional12'.$Identificador] = $InsBoleta->BolDatoAdicional12;
			$_SESSION['InsNotaCreditoDatoAdicional13'.$Identificador] = $InsBoleta->BolDatoAdicional13;
			$_SESSION['InsNotaCreditoDatoAdicional14'.$Identificador] = $InsBoleta->BolDatoAdicional14;
			$_SESSION['InsNotaCreditoDatoAdicional15'.$Identificador] = $InsBoleta->BolDatoAdicional15;
			$_SESSION['InsNotaCreditoDatoAdicional16'.$Identificador] = $InsBoleta->BolDatoAdicional16;
			$_SESSION['InsNotaCreditoDatoAdicional17'.$Identificador] = $InsBoleta->BolDatoAdicional17;
			$_SESSION['InsNotaCreditoDatoAdicional18'.$Identificador] = $InsBoleta->BolDatoAdicional18;
			$_SESSION['InsNotaCreditoDatoAdicional19'.$Identificador] = $InsBoleta->BolDatoAdicional19;
			$_SESSION['InsNotaCreditoDatoAdicional20'.$Identificador] = $InsBoleta->BolDatoAdicional20;
			
			$_SESSION['InsNotaCreditoDatoAdicional21'.$Identificador] = $InsBoleta->BolDatoAdicional21;
			$_SESSION['InsNotaCreditoDatoAdicional22'.$Identificador] = $InsBoleta->BolDatoAdicional22;
			$_SESSION['InsNotaCreditoDatoAdicional23'.$Identificador] = $InsBoleta->BolDatoAdicional23;
			$_SESSION['InsNotaCreditoDatoAdicional24'.$Identificador] = $InsBoleta->BolDatoAdicional24;
			$_SESSION['InsNotaCreditoDatoAdicional25'.$Identificador] = $InsBoleta->BolDatoAdicional25;
			
			$_SESSION['InsNotaCreditoDatoAdicional26'.$Identificador] = $InsBoleta->BolDatoAdicional26;
			$_SESSION['InsNotaCreditoDatoAdicional27'.$Identificador] = $InsBoleta->BolDatoAdicional27;
			$_SESSION['InsNotaCreditoDatoAdicional28'.$Identificador] = $InsBoleta->BolDatoAdicional28;
			
			
			if(is_array($InsBoleta->BoletaDetalle)){			
				foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){
					
					if($InsBoleta->MonId<>$EmpresaMonedaId ){
						
						$DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte / $InsBoleta->BolTipoCambio);
						$DatBoletaDetalle->BdePrecio = ($DatBoletaDetalle->BdePrecio  / $InsBoleta->BolTipoCambio);
						
						$DatBoletaDetalle->BdeValorVenta = ($DatBoletaDetalle->BdeValorVenta  / $InsBoleta->BolTipoCambio);
						$DatBoletaDetalle->BdeImpuesto = ($DatBoletaDetalle->BdeImpuesto  / $InsBoleta->BolTipoCambio);
						$DatBoletaDetalle->BdeImpuestoSelectivo = ($DatBoletaDetalle->BdeImpuestoSelectivo  / $InsBoleta->BolTipoCambio);
						$DatBoletaDetalle->BdeDescuento = ($DatBoletaDetalle->BdeDescuento  / $InsBoleta->BolTipoCambio);							
							
					}
					
				/*
				SesionObjeto-NotaCreditoDetalleListado
				Parametro1 = NcdId
				Parametro2 = NcdDescripcion
				Parametro3 = 
				Parametro4 = NcdPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NcdTipo
				
				Parametro13 = NcdUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NcdCodigo
				Parametro19 = NcdValorVenta
				Parametro20 = NcdImpuesto
				Parametro21 = NcdDescuentom
				Parametro22 = NcdGratuito
				Parametro23 = NcdExonerado	
				
				Parametro24 = NcdIncluyeSelectivo
				Parametro25 = NcdImpuestoSelectivo
				*/
				
					
					
					$_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatBoletaDetalle->BdeDescripcion,
					NULL,
					$DatBoletaDetalle->BdePrecio,
					$DatBoletaDetalle->BdeCantidad,
					$DatBoletaDetalle->BdeImporte,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					NULL,
					NULL,
					NULL,
					NULL,

					$DatBoletaDetalle->BdeUnidadMedida,
					2,

					NULL,
					NULL,
					NULL,
					
					$DatBoletaDetalle->BdeCodigo,
					$DatBoletaDetalle->BdeValorVenta,
					$DatBoletaDetalle->BdeImpuesto,
					$DatBoletaDetalle->BdeDescuento,
					$DatBoletaDetalle->BdeGratuito,
					$DatBoletaDetalle->BdeExonerado	,
					
					$DatBoletaDetalle->BdeIncluyeSelectivo,
					$DatBoletaDetalle->BdeImpuestoSelectivo				
					);		

				}		
			}
			
		}else{
			
			
			$ArrBoletas = array();
			$Boleta = array();
					
			$ArrBoletas = explode("#",$_POST['cmp_seleccionados']);
			$ArrBoletas = array_filter($ArrBoletas);
					
			foreach($ArrBoletas as $DatBoleta){
				
				$Boleta = explode("%",$DatBoleta);
				
				$InsBoleta = new ClsBoleta();
				$InsBoleta->BolId = $Boleta[0];	
				$InsBoleta->BtaId = $Boleta[1];	
				$InsBoleta->MtdObtenerBoleta();
				
//				deb($InsBoleta);

				$InsNotaCredito->CliId = $InsBoleta->CliId;		
				$InsNotaCredito->CliNombre = $InsBoleta->CliNombre;
				$InsNotaCredito->CliApellidoPaterno = $InsBoleta->CliApellidoPaterno;
				$InsNotaCredito->CliApellidoMaterno = $InsBoleta->CliApellidoMaterno;
				$InsNotaCredito->TdoId = $InsBoleta->TdoId;
				$InsNotaCredito->CliNumeroDocumento = $InsBoleta->CliNumeroDocumento;

				$InsNotaCredito->NcrDireccion = $InsBoleta->BolDireccion;
				$InsNotaCredito->NcrTelefono = $InsBoleta->BolTelefono;
				$InsNotaCredito->NcrObservacion = $InsBoleta->BolObservacion;	

				$InsNotaCredito->MonId = $InsBoleta->MonId;	
				$InsNotaCredito->NcrTipoCambio = $InsBoleta->BolTipoCambio;		

				$InsNotaCredito->NcrIncluyeImpuesto = $InsBoleta->BolIncluyeImpuesto;
				$InsNotaCredito->NcrPorcentajeImpuestoVenta = $InsBoleta->BolPorcentajeImpuestoVenta;
				//$InsNotaCredito->NcrPorcentajeImpuestoSelectivo = $InsBoleta->BolPorcentajeImpuestoSelectivo;								
				$InsNotaCredito->NcrPorcentajeImpuestoSelectivo = (empty($InsBoleta->BolPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsBoleta->BolPorcentajeImpuestoSelectivo);		
				
				$InsNotaCredito->NcrEstado = 5;				
				$InsNotaCredito->NcrTipo = 3;
				$InsNotaCredito->DocId = $InsBoleta->BolId;
				$InsNotaCredito->DtaId = $InsBoleta->BtaId;
				$InsNotaCredito->DtaNumero = $InsBoleta->BtaNumero;

				$InsNotaCredito->OvvId = $InsBoleta->OvvId;

				$_SESSION['InsNotaCreditoDatoAdicional1'.$Identificador] = $InsBoleta->BolDatoAdicional1;
				$_SESSION['InsNotaCreditoDatoAdicional2'.$Identificador] = $InsBoleta->BolDatoAdicional2;
				$_SESSION['InsNotaCreditoDatoAdicional3'.$Identificador] = $InsBoleta->BolDatoAdicional3;
				$_SESSION['InsNotaCreditoDatoAdicional4'.$Identificador] = $InsBoleta->BolDatoAdicional4;
				$_SESSION['InsNotaCreditoDatoAdicional5'.$Identificador] = $InsBoleta->BolDatoAdicional5;
				$_SESSION['InsNotaCreditoDatoAdicional6'.$Identificador] = $InsBoleta->BolDatoAdicional6;
				$_SESSION['InsNotaCreditoDatoAdicional7'.$Identificador] = $InsBoleta->BolDatoAdicional7;
				$_SESSION['InsNotaCreditoDatoAdicional8'.$Identificador] = $InsBoleta->BolDatoAdicional8;
				$_SESSION['InsNotaCreditoDatoAdicional9'.$Identificador] = $InsBoleta->BolDatoAdicional9;
				$_SESSION['InsNotaCreditoDatoAdicional10'.$Identificador] = $InsBoleta->BolDatoAdicional10;
				
				$_SESSION['InsNotaCreditoDatoAdicional11'.$Identificador] = $InsBoleta->BolDatoAdicional11;
				$_SESSION['InsNotaCreditoDatoAdicional12'.$Identificador] = $InsBoleta->BolDatoAdicional12;
				$_SESSION['InsNotaCreditoDatoAdicional13'.$Identificador] = $InsBoleta->BolDatoAdicional13;
				$_SESSION['InsNotaCreditoDatoAdicional14'.$Identificador] = $InsBoleta->BolDatoAdicional14;
				$_SESSION['InsNotaCreditoDatoAdicional15'.$Identificador] = $InsBoleta->BolDatoAdicional15;
				$_SESSION['InsNotaCreditoDatoAdicional16'.$Identificador] = $InsBoleta->BolDatoAdicional16;
				$_SESSION['InsNotaCreditoDatoAdicional17'.$Identificador] = $InsBoleta->BolDatoAdicional17;
				$_SESSION['InsNotaCreditoDatoAdicional18'.$Identificador] = $InsBoleta->BolDatoAdicional18;
				$_SESSION['InsNotaCreditoDatoAdicional19'.$Identificador] = $InsBoleta->BolDatoAdicional19;
				$_SESSION['InsNotaCreditoDatoAdicional20'.$Identificador] = $InsBoleta->BolDatoAdicional20;
				
				$_SESSION['InsNotaCreditoDatoAdicional21'.$Identificador] = $InsBoleta->BolDatoAdicional21;
				$_SESSION['InsNotaCreditoDatoAdicional22'.$Identificador] = $InsBoleta->BolDatoAdicional22;
				$_SESSION['InsNotaCreditoDatoAdicional23'.$Identificador] = $InsBoleta->BolDatoAdicional23;
				$_SESSION['InsNotaCreditoDatoAdicional24'.$Identificador] = $InsBoleta->BolDatoAdicional24;
				$_SESSION['InsNotaCreditoDatoAdicional25'.$Identificador] = $InsBoleta->BolDatoAdicional25;
				
				$_SESSION['InsNotaCreditoDatoAdicional26'.$Identificador] = $InsBoleta->BolDatoAdicional26;
				$_SESSION['InsNotaCreditoDatoAdicional27'.$Identificador] = $InsBoleta->BolDatoAdicional27;
				$_SESSION['InsNotaCreditoDatoAdicional28'.$Identificador] = $InsBoleta->BolDatoAdicional28;
				
			
//deb($InsNotaCredito->MonId );
				if(is_array($InsBoleta->BoletaDetalle)){
					foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){
						
						if($InsBoleta->MonId<>$EmpresaMonedaId ){
							
							$DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte / $InsBoleta->BolTipoCambio);
							$DatBoletaDetalle->BdePrecio = ($DatBoletaDetalle->BdePrecio  / $InsBoleta->BolTipoCambio);
							
							$DatBoletaDetalle->BdeValorVenta = ($DatBoletaDetalle->BdeValorVenta  / $InsBoleta->BolTipoCambio);
							$DatBoletaDetalle->BdeImpuesto = ($DatBoletaDetalle->BdeImpuesto  / $InsBoleta->BolTipoCambio);
							$DatBoletaDetalle->BdeImpuestoSelectivo = ($DatBoletaDetalle->BdeImpuestoSelectivo  / $InsBoleta->BolTipoCambio);
							$DatBoletaDetalle->BdeDescuento = ($DatBoletaDetalle->BdeDescuento  / $InsBoleta->BolTipoCambio);	
						
						}
						
					//	deb($DatBoletaDetalle->BdeValorVenta);
						
				/*
				SesionObjeto-NotaCreditoDetalleListado
				Parametro1 = NcdId
				Parametro2 = NcdDescripcion
				Parametro3 = 
				Parametro4 = NcdPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NcdTipo
				
				Parametro13 = NcdUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NcdCodigo
				Parametro19 = NcdValorVenta
				Parametro20 = NcdImpuesto
				Parametro21 = NcdDescuentom
				Parametro22 = NcdGratuito
				Parametro23 = NcdExonerado	
				
				Parametro24 = NcdIncluyeSelectivo
				Parametro25 = NcdImpuestoSelectivo
				*/
					
						
						
						$_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						$DatBoletaDetalle->BdeDescripcion,
						NULL,
						$DatBoletaDetalle->BdePrecio,
						$DatBoletaDetalle->BdeCantidad,
						$DatBoletaDetalle->BdeImporte,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						NULL,
						NULL,
						NULL,
						NULL,
	
						$DatBoletaDetalle->BdeUnidadMedida,
						2,
	
						NULL,
						NULL,
						NULL,
						
						$DatBoletaDetalle->BdeCodigo,
						$DatBoletaDetalle->BdeValorVenta,
						$DatBoletaDetalle->BdeImpuesto,
						$DatBoletaDetalle->BdeDescuento,
						$DatBoletaDetalle->BdeGratuito,
						$DatBoletaDetalle->BdeExonerado,
						
						$DatBoletaDetalle->BdeIncluyeSelectivo	,
						$DatBoletaDetalle->BdeImpuestoSelectivo				
						);	
						
//						deb($DatBoletaDetalle->BdeExonerado	." - ".$DatBoletaDetalle->BdeGratuito);	
	
					}		
				}

						
			}
					
		}
		
		break;
		
	}
	
	
	
	
	
}

?>
