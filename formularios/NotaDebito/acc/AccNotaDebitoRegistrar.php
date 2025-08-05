<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsNotaDebito->NdbId = $_POST['CmpId'];
	$InsNotaDebito->NdtId = $_POST['CmpTalonario'];
	$InsNotaDebito->CliId = $_POST['CmpClienteId'];

	$InsNotaDebito->UsuId = $_SESSION['SesionId'];
	$InsNotaDebito->SucId = $_SESSION['SesionSucursal'];
	
	$InsNotaDebito->DocId = $_POST['CmpDocumentoId'];
	$InsNotaDebito->DtaId = $_POST['CmpDocumentoTalonario'];
	$InsNotaDebito->DtaNumero = $_POST['CmpDocumentoTalonarioNumero'];
	$InsNotaDebito->NdbPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = $_POST['CmpPorcentajeImpuestoSelectivo'];
	
	$InsNotaDebito->NdbTipo = $_POST['CmpTipo'];
	///deb($InsNotaDebito->NdbTipo);
	
	$InsNotaDebito->NdbEstado = $_POST['CmpEstado'];
	$InsNotaDebito->NdbFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsNotaDebito->NdbObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	$InsNotaDebito->NdbMotivo = addslashes($_POST['CmpMotivo']);
	$InsNotaDebito->NdbMotivoCodigo = $_POST['CmpMotivoCodigo'];
	
	$InsNotaDebito->MonId = $_POST['CmpMonedaId'];
	$InsNotaDebito->NdbTipoCambio = $_POST['CmpTipoCambio'];
	$InsNotaDebito->NdbIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	
	$InsNotaDebito->NdbCierre = 1;
	$InsNotaDebito->NdbTiempoCreacion = date("Y-m-d H:i:s");
	$InsNotaDebito->NdbTiempoModificacion = date("Y-m-d H:i:s");
	$InsNotaDebito->NdbEliminado = 1;
	
	$InsNotaDebito->CliNombre = $_POST['CmpClienteNombre'];
	$InsNotaDebito->TdoId = $_POST['CmpTipoDocumento'];	
	$InsNotaDebito->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsNotaDebito->NdbDireccion = $_POST['CmpClienteDireccion'];
	$InsNotaDebito->CliTelefono = $_POST['CmpClienteTelefono'];
	$InsNotaDebito->CliEmail = $_POST['CmpClienteEmail'];
	$InsNotaDebito->CliCelular = $_POST['CmpClienteCelular'];
	$InsNotaDebito->CliFax = $_POST['CmpClienteFax'];

	$InsNotaDebito->NotaDebitoDetalle = array();	

	$InsNotaDebito->NdbProcesar = $_POST['CmpProcesar'];
	$InsNotaDebito->NdbEnviarSUNAT = $_POST['CmpEnviarSUNAT'];

	$InsNotaDebito->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	
	$InsNotaDebito->NdbDatoAdicional1 = $_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional2 = $_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional3 = $_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional4 = $_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional5 = $_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional6 = $_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional7 = $_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional8 = $_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional9 = $_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional10 = $_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional11 = $_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional12 = $_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional13 = $_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional14 = $_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional15 = $_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional16 = $_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional17 = $_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional18 = $_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional19 = $_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional20 = $_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional21 = $_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional22 = $_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional23 = $_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional24 = $_SESSION['InsNotaDebitoDatoAdicional24'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional25 = $_SESSION['InsNotaDebitoDatoAdicional25'.$Identificador];
	
deb($InsNotaDebito->NdbTipoCambio );
/*
SesionObjeto-NotaDebitoDetalleListado
Parametro1 = NddId
Parametro2 = NddDescripcion
Parametro3 = 
Parametro4 = NddPrecio
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaId;
Parametro12 = NddTipo

Parametro13 = NddUnidadMedida
Parametro14 = AmdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = NddCodigo
Parametro19 = NddValorVenta
Parametro20 = NddImpuesto
Parametro21 = NddDescuentom
Parametro22 = NddGratuito
Parametro23 = NddExonerado	

Parametro24 = NddIncluyeSelectivo	
*/

$InsNotaDebito->NdbTotalBruto = 0;
$InsNotaDebito->NdbTotalGravado = 0;
$InsNotaDebito->NdbTotalExonerado = 0;
$InsNotaDebito->NdbTotalDescuento = 0;
$InsNotaDebito->NdbTotalGratuito = 0;
$InsNotaDebito->NdbTotalDescuentoNoExonerado = 0;
$InsNotaDebito->NdbTotalValorBruto = 0;
$InsNotaDebito->NdbTotalPagar= 0;
$InsNotaDebito->NdbTotalImpuestoSelectivo = 0;

$InsNotaDebito->NdbSubTotal = 0;
$InsNotaDebito->NdbImpuesto = 0;
$InsNotaDebito->NdbTotal = 0;

$ResNotaDebitoDetalle = $_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO

	if(is_array($ResNotaDebitoDetalle['Datos'])){
		foreach($ResNotaDebitoDetalle['Datos'] as $DatSesionObjeto){
			
			if($InsNotaDebito->MonId<>$EmpresaMonedaId){
			
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsNotaDebito->NdbTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsNotaDebito->NdbTipoCambio;
				
				$DatSesionObjeto->Parametro19 = $DatSesionObjeto->Parametro19 * $InsNotaDebito->NdbTipoCambio;
				$DatSesionObjeto->Parametro20 = $DatSesionObjeto->Parametro20 * $InsNotaDebito->NdbTipoCambio;
				$DatSesionObjeto->Parametro21 = $DatSesionObjeto->Parametro21 * $InsNotaDebito->NdbTipoCambio;
				$DatSesionObjeto->Parametro25 = $DatSesionObjeto->Parametro25 * $InsNotaDebito->NdbTipoCambio;
			}
			
			
			$InsNotaDebitoDetalle1 = new ClsNotaDebitoDetalle();
			$InsNotaDebitoDetalle1->NddId = $DatSesionObjeto->Parametro1;					
			$InsNotaDebitoDetalle1->OdeId = $DatSesionObjeto->Parametro9;			
			$InsNotaDebitoDetalle1->NddTipo = $DatSesionObjeto->Parametro12;			

			if($InsNotaDebitoDetalle1->NddTipo<>"T"){
				$InsNotaDebitoDetalle1->NddDescripcion = utf8_encode(htmlentities($DatSesionObjeto->Parametro2));	
			}else{
				$InsNotaDebitoDetalle1->NddDescripcion = addslashes(utf8_encode(($DatSesionObjeto->Parametro2)));
			}

			$InsNotaDebitoDetalle1->NddPrecio = $DatSesionObjeto->Parametro4;
			$InsNotaDebitoDetalle1->NddCantidad = $DatSesionObjeto->Parametro5;
			$InsNotaDebitoDetalle1->NddImporte = $DatSesionObjeto->Parametro6;

			$InsNotaDebitoDetalle1->NddValorVenta = $DatSesionObjeto->Parametro19;
			$InsNotaDebitoDetalle1->NddImpuesto = $DatSesionObjeto->Parametro20;
			$InsNotaDebitoDetalle1->NddDescuento = $DatSesionObjeto->Parametro21;
			$InsNotaDebitoDetalle1->NddImpuestoSelectivo = $DatSesionObjeto->Parametro25;

			$InsNotaDebitoDetalle1->NddGratuito = 2;
			$InsNotaDebitoDetalle1->NddExonerado = (empty($DatSesionObjeto->Parametro23)?2:$DatSesionObjeto->Parametro23);				
			$InsNotaDebitoDetalle1->NddIncluyeSelectivo = $DatSesionObjeto->Parametro24;
//deb($DatSesionObjeto->Parametro24);
			$InsNotaDebitoDetalle1->NddCodigo = $DatSesionObjeto->Parametro18;
			$InsNotaDebitoDetalle1->NddUnidadMedida = $DatSesionObjeto->Parametro13;
			
			$InsNotaDebitoDetalle1->NddTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsNotaDebitoDetalle1->NddTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsNotaDebitoDetalle1->NddEliminado = $DatSesionObjeto->Eliminado;				
			$InsNotaDebitoDetalle1->InsMysql = NULL;
			
			
			if($InsNotaDebitoDetalle1->NddEliminado==1){		
				
				$InsNotaDebito->NdbTotalBruto += $InsNotaDebitoDetalle1->NddImporte;	
									
				//EXONERADO
				if($InsNotaDebitoDetalle1->NddExonerado == 1){						
					$InsNotaDebito->NdbTotalExonerado += $InsNotaDebitoDetalle1->NddValorVenta;
				}
				
				//GRAVADO
				if($InsNotaDebitoDetalle1->NddExonerado == 2 and $InsNotaDebitoDetalle1->NddGratuito == 2){			
					$InsNotaDebito->NdbTotalGravado += $InsNotaDebitoDetalle1->NddValorVenta;
				}
				
				//VALOR BRUTO
				if($InsNotaDebitoDetalle1->NddGratuito == 2){		
					$InsNotaDebito->NdbTotalValorBruto += $InsNotaDebitoDetalle1->NddValorVenta;
				}
				
				//GRATUITO
				if($InsNotaDebitoDetalle1->NddGratuito == 1){			
					$InsNotaDebito->NdbTotalGratuito += $InsNotaDebitoDetalle1->NddValorVenta;			
				}
				
				//INCLUYE SELECTIVO
				if($InsNotaDebitoDetalle1->FdeIncluyeSelectivo == 1){			
					$InsNotaDebito->NdbTotalImpuestoSelectivo += ($InsFacturaDetalle1->NddImpuestoSelectivo);
				}	
				
				//TOTAL PAGAR								
				if($InsNotaDebitoDetalle1->NddGratuito == 2){	
					if($InsNotaDebitoDetalle1->NddExonerado == 2){
						$InsNotaDebito->NdbTotalPagar += 	( ($InsNotaDebitoDetalle1->NddValorVenta  ) * ( ($InsNotaDebito->NdbPorcentajeImpuestoVenta/100)+1) ) * ( (100 - $InsNotaDebito->NdbPorcentajeDescuento)/100 ) ;
					}else{
						$InsNotaDebito->NdbTotalPagar += 	($InsNotaDebitoDetalle1->NddValorVenta ) * ( (100 - $InsNotaDebito->NdbPorcentajeDescuento)/100 );	
					}
				}
				
				$InsNotaDebito->NdbTotalDescuento += $InsNotaDebitoDetalle1->NddDescuento;
				
				$InsNotaDebito->NotaDebitoDetalle[] = $InsNotaDebitoDetalle1;	
				
			}
						
		}	
			
	}
	


	$InsNotaDebito->NdbSubTotal = ($InsNotaDebito->NdbTotalGravado);
	$InsNotaDebito->NdbImpuesto = (($InsNotaDebito->NdbSubTotal + $InsNotaDebito->NdbTotalImpuestoSelectivo ) * ($InsNotaDebito->NdbPorcentajeImpuestoVenta/100));
	$InsNotaDebito->NdbTotal = ($InsNotaDebito->NdbSubTotal+ $InsNotaDebito->NdbTotalImpuestoSelectivo +  $InsNotaDebito->NdbTotalExonerado + $InsNotaDebito->NdbImpuesto);
	
	if($InsNotaDebito->MtdRegistrarNotaDebito()){
		//
//		if($InsNotaDebito->NdbNotificar=="1"){
//			$InsNotaDebito->MtdNotificarNotaDebitoRegistro($InsNotaDebito->NdbId,$InsNotaDebito->NdtId,"jblanco@cyc.com.pe,epilco@cyc.com.pe,gparedes@cyc.com.pe,scanepam@cyc.com.pe,pzapana@cyc.com.pe,pcondori@cyc.com.pe");
//		}
		
		
		$InsNotaDebitoTalonario = new ClsNotaDebitoTalonario();
		$InsNotaDebitoTalonario->NdtId = $InsNotaDebito->NdtId;
		$InsNotaDebitoTalonario->MtdObtenerNotaDebitoTalonario();		
		
		if(substr($InsNotaDebitoTalonario->NdtNumero,0,1)=="F" || substr($InsNotaDebitoTalonario->NdtNumero,0,1)=="B"){
		?>
		<script type="text/javascript">
			$().ready(function() {
			/*
			Configuracion carga de datos y animacion
			*/			
			//FncPopUp('formularios/NotaDebito/FrmNotaDebitoGenerarXML.php?Id=<?php echo $InsNotaDebito->NdbId;?>&Ta=<?php echo $InsNotaDebito->NdtId;?>&Procesar=<?php echo $InsNotaDebito->NdbProcesar;?>&EnviarSUNAT=<?php echo $InsNotaDebito->NdbEnviarSUNAT;?>&P=1',0,0,1,0,0,1,0,350,150);
			});
		</script>
		<?php			
		}
			
		$Registro = true;	
		$Resultado.='#SAS_NDB_101';
	} else{
		$Resultado.='#ERR_NDB_101';
	}
	
	$InsNotaDebito->NdbFechaEmision = FncCambiaFechaANormal($InsNotaDebito->NdbFechaEmision);
	list($InsNotaDebito->NdbObservacion,$InsNotaDebito->NdbObservacionImpresa) = explode("###",$InsNotaDebito->NdbObservacion);
	
	
	
}else{

	unset($_SESSION['InsNotaDebitoDetalle'.$Identificador]);	

	$_SESSION['InsNotaDebitoDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsNotaDebito->NdbFechaEmision = date("d/m/Y");	
	$InsNotaDebito->NdbTipo = 2;
	
	$InsNotaDebito->NdbNotificar = 1;
	$InsNotaDebito->NdbProcesar = 1;
	$InsNotaDebito->NdbEnviarSUNAT = 1;
$InsNotaDebito->SucId = $_SESSION['SesionSucursal'];

	switch($GET_ori){
				
		//Factura
		case "Factura":
	
		if(!empty($GET_id) and !empty($GET_ta)){
			
			$InsFactura = new ClsFactura();
			$InsFactura->FacId = $GET_id;
			$InsFactura->FtaId = $GET_ta;
			$InsFactura->MtdObtenerFactura();

			$InsNotaDebito->CliId = $InsFactura->CliId;		
			$InsNotaDebito->CliNombre = $InsFactura->CliNombre;
			$InsNotaDebito->CliApellidoPaterno = $InsFactura->CliApellidoPaterno;
			$InsNotaDebito->CliApellidoMaterno = $InsFactura->CliApellidoMaterno;
			
			$InsNotaDebito->TdoId = $InsFactura->TdoId;
			$InsNotaDebito->CliNumeroDocumento = $InsFactura->CliNumeroDocumento;
			$InsNotaDebito->NdbDireccion = $InsFactura->FacDireccion;
			$InsNotaDebito->NdbTelefono = $InsFactura->FacTelefono;
			$InsNotaDebito->NdbObservacion = $InsFactura->FacObservacion;		
			$InsNotaDebito->MonId = $InsFactura->MonId;	
			$InsNotaDebito->NdbTipoCambio = $InsFactura->FacTipoCambio;		
			$InsNotaDebito->NdbIncluyeImpuesto = $InsFactura->FacIncluyeImpuesto;		
			$InsNotaDebito->NdbPorcentajeImpuestoVenta = $InsFactura->FacPorcentajeImpuestoVenta;
			//$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = $InsFactura->FacPorcentajeImpuestoSelectivo;		
			$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = (empty($InsFactura->FacPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsFactura->FacPorcentajeImpuestoSelectivo);		
			
			$InsNotaDebito->NdbEstado = 5;			
			$InsNotaDebito->NdbTipo = 2;
			$InsNotaDebito->DocId = $InsFactura->FacId;
			$InsNotaDebito->DtaId = $InsFactura->FtaId;
			$InsNotaDebito->DtaNumero = $InsFactura->FtaNumero;
			
			$InsNotaDebito->OvvId = $InsFactura->OvvId;
			
			$_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador] = $InsFactura->FacDatoAdicional1;
			$_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador] = $InsFactura->FacDatoAdicional2;
			$_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador] = $InsFactura->FacDatoAdicional3;
			$_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador] = $InsFactura->FacDatoAdicional4;
			$_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador] = $InsFactura->FacDatoAdicional5;
			$_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador] = $InsFactura->FacDatoAdicional6;
			$_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador] = $InsFactura->FacDatoAdicional7;
			$_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador] = $InsFactura->FacDatoAdicional8;
			$_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador] = $InsFactura->FacDatoAdicional9;
			$_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador] = $InsFactura->FacDatoAdicional10;
			
			$_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador] = $InsFactura->FacDatoAdicional11;
			$_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador] = $InsFactura->FacDatoAdicional12;
			$_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador] = $InsFactura->FacDatoAdicional13;
			$_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador] = $InsFactura->FacDatoAdicional14;
			$_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador] = $InsFactura->FacDatoAdicional15;
			$_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador] = $InsFactura->FacDatoAdicional16;
			$_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador] = $InsFactura->FacDatoAdicional17;
			$_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador] = $InsFactura->FacDatoAdicional18;
			$_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador] = $InsFactura->FacDatoAdicional19;
			$_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador] = $InsFactura->FacDatoAdicional20;
			
			$_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador] = $InsFactura->FacDatoAdicional21;
			$_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador] = $InsFactura->FacDatoAdicional22;
			$_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador] = $InsFactura->FacDatoAdicional23;
			$_SESSION['InsNotaDebitoDatoAdicional24'.$Identificador] = $InsFactura->FacDatoAdicional24;
			$_SESSION['InsNotaDebitoDatoAdicional25'.$Identificador] = $InsFactura->FacDatoAdicional25;
			
			
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
				SesionObjeto-NotaDebitoDetalleListado
				Parametro1 = NddId
				Parametro2 = NddDescripcion
				Parametro3 = 
				Parametro4 = NddPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NddTipo
				
				Parametro13 = NddUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NddCodigo
				Parametro19 = NddValorVenta
				Parametro20 = NddImpuesto
				Parametro21 = NddDescuento
				
				Parametro22 = NddGratuito
				Parametro23 = NddExonerado	
				*/
					$_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
					$DatFacturaDetalle->FdeExonerado	,
					
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

				$InsNotaDebito->CliId = $InsFactura->CliId;		
				$InsNotaDebito->CliNombre = $InsFactura->CliNombre;
				$InsNotaDebito->CliApellidoPaterno = $InsFactura->CliApellidoPaterno;
				$InsNotaDebito->CliApellidoMaterno = $InsFactura->CliApellidoMaterno;
				$InsNotaDebito->TdoId = $InsFactura->TdoId;
				$InsNotaDebito->CliNumeroDocumento = $InsFactura->CliNumeroDocumento;
				$InsNotaDebito->NdbDireccion = $InsFactura->FacDireccion;
				$InsNotaDebito->NdbTelefono = $InsFactura->FacTelefono;
				$InsNotaDebito->NdbObservacion = $InsFactura->FacObservacion;	
				$InsNotaDebito->MonId = $InsFactura->MonId;	
				$InsNotaDebito->NdbTipoCambio = $InsFactura->FacTipoCambio;		
				$InsNotaDebito->NdbIncluyeImpuesto = $InsFactura->FacIncluyeImpuesto;	
				$InsNotaDebito->NdbPorcentajeImpuestoVenta = $InsFactura->FacPorcentajeImpuestoVenta;	
				//$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = $InsFactura->FacPorcentajeImpuestoSelectivo;	
				$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = (empty($InsFactura->FacPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsFactura->FacPorcentajeImpuestoSelectivo);		
			
			
				$InsNotaDebito->NdbEstado = 5;
				
				$InsNotaDebito->NdbTipo = 2;
				$InsNotaDebito->DocId = $InsFactura->FacId;
				$InsNotaDebito->DtaId = $InsFactura->FtaId;
				$InsNotaDebito->DtaNumero = $InsFactura->FtaNumero;
	
				$InsNotaDebito->OvvId = $InsFactura->OvvId;
				
				$_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador] = $InsFactura->FacDatoAdicional1;
				$_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador] = $InsFactura->FacDatoAdicional2;
				$_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador] = $InsFactura->FacDatoAdicional3;
				$_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador] = $InsFactura->FacDatoAdicional4;
				$_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador] = $InsFactura->FacDatoAdicional5;
				$_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador] = $InsFactura->FacDatoAdicional6;
				$_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador] = $InsFactura->FacDatoAdicional7;
				$_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador] = $InsFactura->FacDatoAdicional8;
				$_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador] = $InsFactura->FacDatoAdicional9;
				$_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador] = $InsFactura->FacDatoAdicional10;
				
				$_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador] = $InsFactura->FacDatoAdicional11;
				$_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador] = $InsFactura->FacDatoAdicional12;
				$_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador] = $InsFactura->FacDatoAdicional13;
				$_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador] = $InsFactura->FacDatoAdicional14;
				$_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador] = $InsFactura->FacDatoAdicional15;
				$_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador] = $InsFactura->FacDatoAdicional16;
				$_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador] = $InsFactura->FacDatoAdicional17;
				$_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador] = $InsFactura->FacDatoAdicional18;
				$_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador] = $InsFactura->FacDatoAdicional19;
				$_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador] = $InsFactura->FacDatoAdicional20;
				
				$_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador] = $InsFactura->FacDatoAdicional21;
				$_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador] = $InsFactura->FacDatoAdicional22;
				$_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador] = $InsFactura->FacDatoAdicional23;
				$_SESSION['InsNotaDebitoDatoAdicional24'.$Identificador] = $InsFactura->FacDatoAdicional24;
				$_SESSION['InsNotaDebitoDatoAdicional25'.$Identificador] = $InsFactura->FacDatoAdicional25;
				
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
								
								
//								deb($DatFacturaDetalle->FdeValorVenta);
						
						/*
				SesionObjeto-NotaDebitoDetalleListado
				Parametro1 = NddId
				Parametro2 = NddDescripcion
				Parametro3 = 
				Parametro4 = NddPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NddTipo
				
				Parametro13 = NddUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NddCodigo
				Parametro19 = NddValorVenta
				Parametro20 = NddImpuesto
				Parametro21 = NddDescuentom
				Parametro22 = NddGratuito
				Parametro23 = NddExonerado	
				*/
						
						$_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
					$DatFacturaDetalle->FdeExonerado	,
					
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

			$InsNotaDebito->CliId = $InsBoleta->CliId;		
			$InsNotaDebito->CliNombre = $InsBoleta->CliNombre;
			$InsNotaDebito->CliApellidoPaterno = $InsBoleta->CliApellidoPaterno;
			$InsNotaDebito->CliApellidoMaterno = $InsBoleta->CliApellidoMaterno;
			
			$InsNotaDebito->TdoId = $InsBoleta->TdoId;
			$InsNotaDebito->CliNumeroDocumento = $InsBoleta->CliNumeroDocumento;
			$InsNotaDebito->NdbDireccion = $InsBoleta->BolDireccion;
			$InsNotaDebito->NdbTelefono = $InsBoleta->BolTelefono;
			$InsNotaDebito->NdbObservacion = $InsBoleta->BolObservacion;		

			$InsNotaDebito->MonId = $InsBoleta->MonId;	
			$InsNotaDebito->NdbTipoCambio = $InsBoleta->BolTipoCambio;		

			$InsNotaDebito->NdbIncluyeImpuesto = $InsBoleta->BolIncluyeImpuesto;	
			$InsNotaDebito->NdbPorcentajeImpuestoVenta = $InsBoleta->BolPorcentajeImpuestoVenta;		
			//$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = $InsBoleta->BolPorcentajeImpuestoSelectivo;		
			$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = (empty($InsBoleta->BolPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsBoleta->BolPorcentajeImpuestoSelectivo);		
			
			$InsNotaDebito->NdbEstado = 5;			
			$InsNotaDebito->NdbTipo = 3;
			$InsNotaDebito->DocId = $InsBoleta->BolId;
			$InsNotaDebito->DtaId = $InsBoleta->BtaId;
			$InsNotaDebito->DtaNumero = $InsBoleta->BtaNumero;
			
			$InsNotaDebito->OvvId = $InsBoleta->OvvId;
			
			$_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador] = $InsBoleta->BolDatoAdicional1;
			$_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador] = $InsBoleta->BolDatoAdicional2;
			$_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador] = $InsBoleta->BolDatoAdicional3;
			$_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador] = $InsBoleta->BolDatoAdicional4;
			$_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador] = $InsBoleta->BolDatoAdicional5;
			$_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador] = $InsBoleta->BolDatoAdicional6;
			$_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador] = $InsBoleta->BolDatoAdicional7;
			$_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador] = $InsBoleta->BolDatoAdicional8;
			$_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador] = $InsBoleta->BolDatoAdicional9;
			$_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador] = $InsBoleta->BolDatoAdicional10;
			
			$_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador] = $InsBoleta->BolDatoAdicional11;
			$_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador] = $InsBoleta->BolDatoAdicional12;
			$_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador] = $InsBoleta->BolDatoAdicional13;
			$_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador] = $InsBoleta->BolDatoAdicional14;
			$_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador] = $InsBoleta->BolDatoAdicional15;
			$_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador] = $InsBoleta->BolDatoAdicional16;
			$_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador] = $InsBoleta->BolDatoAdicional17;
			$_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador] = $InsBoleta->BolDatoAdicional18;
			$_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador] = $InsBoleta->BolDatoAdicional19;
			$_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador] = $InsBoleta->BolDatoAdicional20;
			
			$_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador] = $InsBoleta->BolDatoAdicional21;
			$_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador] = $InsBoleta->BolDatoAdicional22;
			$_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador] = $InsBoleta->BolDatoAdicional23;
			$_SESSION['InsNotaDebitoDatoAdicional24'.$Identificador] = $InsBoleta->BolDatoAdicional24;
			$_SESSION['InsNotaDebitoDatoAdicional25'.$Identificador] = $InsBoleta->BolDatoAdicional25;
			
	
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
				SesionObjeto-NotaDebitoDetalleListado
				Parametro1 = NddId
				Parametro2 = NddDescripcion
				Parametro3 = 
				Parametro4 = NddPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NddTipo
				
				Parametro13 = NddUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NddCodigo
				Parametro19 = NddValorVenta
				Parametro20 = NddImpuesto
				Parametro21 = NddDescuentom
				Parametro22 = NddGratuito
				Parametro23 = NddExonerado	
				*/
				
					
					
					$_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
					$DatBoletaDetalle->BdeExonerado		,
					
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

				$InsNotaDebito->CliId = $InsBoleta->CliId;		
				$InsNotaDebito->CliNombre = $InsBoleta->CliNombre;
				$InsNotaDebito->CliApellidoPaterno = $InsBoleta->CliApellidoPaterno;
				$InsNotaDebito->CliApellidoMaterno = $InsBoleta->CliApellidoMaterno;
				$InsNotaDebito->TdoId = $InsBoleta->TdoId;
				$InsNotaDebito->CliNumeroDocumento = $InsBoleta->CliNumeroDocumento;

				$InsNotaDebito->NdbDireccion = $InsBoleta->BolDireccion;
				$InsNotaDebito->NdbTelefono = $InsBoleta->BolTelefono;
				$InsNotaDebito->NdbObservacion = $InsBoleta->BolObservacion;	

				$InsNotaDebito->MonId = $InsBoleta->MonId;	
				$InsNotaDebito->NdbTipoCambio = $InsBoleta->BolTipoCambio;		

				$InsNotaDebito->NdbIncluyeImpuesto = $InsBoleta->BolIncluyeImpuesto;
				$InsNotaDebito->NdbPorcentajeImpuestoVenta = $InsBoleta->BolPorcentajeImpuestoVenta;
				//$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = $InsBoleta->BolPorcentajeImpuestoSelectivo;								
				$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = (empty($InsBoleta->BolPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsBoleta->BolPorcentajeImpuestoSelectivo);		
			
				$InsNotaDebito->NdbEstado = 5;				
				$InsNotaDebito->NdbTipo = 3;
				$InsNotaDebito->DocId = $InsBoleta->BolId;
				$InsNotaDebito->DtaId = $InsBoleta->BtaId;
				$InsNotaDebito->DtaNumero = $InsBoleta->BtaNumero;
				
				$InsNotaDebito->OvvId = $InsBoleta->OvvId;

				$_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador] = $InsBoleta->BolDatoAdicional1;
				$_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador] = $InsBoleta->BolDatoAdicional2;
				$_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador] = $InsBoleta->BolDatoAdicional3;
				$_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador] = $InsBoleta->BolDatoAdicional4;
				$_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador] = $InsBoleta->BolDatoAdicional5;
				$_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador] = $InsBoleta->BolDatoAdicional6;
				$_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador] = $InsBoleta->BolDatoAdicional7;
				$_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador] = $InsBoleta->BolDatoAdicional8;
				$_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador] = $InsBoleta->BolDatoAdicional9;
				$_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador] = $InsBoleta->BolDatoAdicional10;
				
				$_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador] = $InsBoleta->BolDatoAdicional11;
				$_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador] = $InsBoleta->BolDatoAdicional12;
				$_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador] = $InsBoleta->BolDatoAdicional13;
				$_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador] = $InsBoleta->BolDatoAdicional14;
				$_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador] = $InsBoleta->BolDatoAdicional15;
				$_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador] = $InsBoleta->BolDatoAdicional16;
				$_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador] = $InsBoleta->BolDatoAdicional17;
				$_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador] = $InsBoleta->BolDatoAdicional18;
				$_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador] = $InsBoleta->BolDatoAdicional19;
				$_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador] = $InsBoleta->BolDatoAdicional20;
				
				$_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador] = $InsBoleta->BolDatoAdicional21;
				$_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador] = $InsBoleta->BolDatoAdicional22;
				$_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador] = $InsBoleta->BolDatoAdicional23;
				$_SESSION['InsNotaDebitoDatoAdicional24'.$Identificador] = $InsBoleta->BolDatoAdicional24;
				$_SESSION['InsNotaDebitoDatoAdicional25'.$Identificador] = $InsBoleta->BolDatoAdicional25;
				
			
//deb($InsNotaDebito->MonId );
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
				SesionObjeto-NotaDebitoDetalleListado
				Parametro1 = NddId
				Parametro2 = NddDescripcion
				Parametro3 = 
				Parametro4 = NddPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NddTipo
				
				Parametro13 = NddUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NddCodigo
				Parametro19 = NddValorVenta
				Parametro20 = NddImpuesto
				Parametro21 = NddDescuentom
				Parametro22 = NddGratuito
				Parametro23 = NddExonerado	
				*/
					
						
						
						$_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
						
						$DatBoletaDetalle->BdeIncluyeSelectivo	,
						$DatBoletaDetalle->BdeImpuestoSelectivo							
						);	
						
//						deb($DatBoletaDetalle->BdeIncluyeSelectivo);
//						deb($DatBoletaDetalle->BdeExonerado	." - ".$DatBoletaDetalle->BdeGratuito);	
	
					}		
				}

						
			}
					
		}
		
		break;
		
		
		
		case "NotaCredito":
	
		if(!empty($GET_id) and !empty($GET_ta)){
			
			$InsNotaCredito = new ClsNotaCredito();
			$InsNotaCredito->NcrId = $GET_id;
			$InsNotaCredito->NctId = $GET_ta;
			$InsNotaCredito->MtdObtenerNotaCredito();

			$InsNotaDebito->CliId = $InsNotaCredito->CliId;		
			$InsNotaDebito->CliNombre = $InsNotaCredito->CliNombre;
			$InsNotaDebito->CliApellidoPaterno = $InsNotaCredito->CliApellidoPaterno;
			$InsNotaDebito->CliApellidoMaterno = $InsNotaCredito->CliApellidoMaterno;
			
			$InsNotaDebito->TdoId = $InsNotaCredito->TdoId;
			$InsNotaDebito->CliNumeroDocumento = $InsNotaCredito->CliNumeroDocumento;
			$InsNotaDebito->NdbDireccion = $InsNotaCredito->NcrDireccion;
			$InsNotaDebito->NdbTelefono = $InsNotaCredito->NcrTelefono;
			$InsNotaDebito->NdbObservacion = $InsNotaCredito->NcrObservacion;		

			$InsNotaDebito->MonId = $InsNotaCredito->MonId;	
			$InsNotaDebito->NdbTipoCambio = $InsNotaCredito->NcrTipoCambio;		

			$InsNotaDebito->NdbIncluyeImpuesto = $InsNotaCredito->NcrIncluyeImpuesto;	
			$InsNotaDebito->NdbPorcentajeImpuestoVenta = $InsNotaCredito->NcrPorcentajeImpuestoVenta;		
			//$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = $InsNotaCredito->NcrPorcentajeImpuestoSelectivo;		
			$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = (empty($InsNotaCredito->NcrPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsNotaCredito->NcrPorcentajeImpuestoSelectivo);		
			
			$InsNotaDebito->NdbEstado = 5;			
			$InsNotaDebito->NdbTipo = 4;
			$InsNotaDebito->DocId = $InsNotaCredito->NcrId;
			$InsNotaDebito->DtaId = $InsNotaCredito->NctId;
			$InsNotaDebito->DtaNumero = $InsNotaCredito->NctNumero;
			
			$InsNotaDebito->OvvId = $InsNotaCredito->OvvId;
			
			$_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador] = $InsNotaCredito->NcrDatoAdicional1;
			$_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador] = $InsNotaCredito->NcrDatoAdicional2;
			$_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador] = $InsNotaCredito->NcrDatoAdicional3;
			$_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador] = $InsNotaCredito->NcrDatoAdicional4;
			$_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador] = $InsNotaCredito->NcrDatoAdicional5;
			$_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador] = $InsNotaCredito->NcrDatoAdicional6;
			$_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador] = $InsNotaCredito->NcrDatoAdicional7;
			$_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador] = $InsNotaCredito->NcrDatoAdicional8;
			$_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador] = $InsNotaCredito->NcrDatoAdicional9;
			$_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador] = $InsNotaCredito->NcrDatoAdicional10;
			
			$_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador] = $InsNotaCredito->NcrDatoAdicional11;
			$_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador] = $InsNotaCredito->NcrDatoAdicional12;
			$_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador] = $InsNotaCredito->NcrDatoAdicional13;
			$_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador] = $InsNotaCredito->NcrDatoAdicional14;
			$_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador] = $InsNotaCredito->NcrDatoAdicional15;
			$_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador] = $InsNotaCredito->NcrDatoAdicional16;
			$_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador] = $InsNotaCredito->NcrDatoAdicional17;
			$_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador] = $InsNotaCredito->NcrDatoAdicional18;
			$_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador] = $InsNotaCredito->NcrDatoAdicional19;
			$_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador] = $InsNotaCredito->NcrDatoAdicional20;
			
			$_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador] = $InsNotaCredito->NcrDatoAdicional21;
			$_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador] = $InsNotaCredito->NcrDatoAdicional22;
			$_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador] = $InsNotaCredito->NcrDatoAdicional23;
			$_SESSION['InsNotaDebitoDatoAdicional24'.$Identificador] = $InsNotaCredito->NcrDatoAdicional24;
			$_SESSION['InsNotaDebitoDatoAdicional25'.$Identificador] = $InsNotaCredito->NcrDatoAdicional25;
			
	
			if(is_array($InsNotaCredito->NotaCreditoDetalle)){			
				foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){
					
					
						$DatNotaCreditoDetalle->NcdIncluyeSelectivo = 2;
						$DatNotaCreditoDetalle->NcdImpuestoSelectivo = 0;
					
					if($InsNotaCredito->MonId<>$EmpresaMonedaId ){
						
						$DatNotaCreditoDetalle->NcdImporte = ($DatNotaCreditoDetalle->NcdImporte / $InsNotaCredito->NcrTipoCambio);
						$DatNotaCreditoDetalle->NcdPrecio = ($DatNotaCreditoDetalle->NcdPrecio  / $InsNotaCredito->NcrTipoCambio);
						
						$DatNotaCreditoDetalle->NcdValorVenta = ($DatNotaCreditoDetalle->NcdValorVenta  / $InsNotaCredito->NcrTipoCambio);
						$DatNotaCreditoDetalle->NcdImpuesto = ($DatNotaCreditoDetalle->NcdImpuesto  / $InsNotaCredito->NcrTipoCambio);
						$DatNotaCreditoDetalle->NcdImpuestoSelectivo = ($DatNotaCreditoDetalle->NcdImpuestoSelectivo  / $InsNotaCredito->NcrTipoCambio);
						$DatNotaCreditoDetalle->NcdDescuento = ($DatNotaCreditoDetalle->NcdDescuento  / $InsNotaCredito->NcrTipoCambio);							
							
					}
					
					
				/*
				SesionObjeto-NotaDebitoDetalleListado
				Parametro1 = NddId
				Parametro2 = NddDescripcion
				Parametro3 = 
				Parametro4 = NddPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NddTipo
				
				Parametro13 = NddUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NddCodigo
				Parametro19 = NddValorVenta
				Parametro20 = NddImpuesto
				Parametro21 = NddDescuentom
				Parametro22 = NddGratuito
				Parametro23 = NddExonerado	
				*/
				
					
					
					$_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatNotaCreditoDetalle->NcdDescripcion,
					NULL,
					$DatNotaCreditoDetalle->NcdPrecio,
					$DatNotaCreditoDetalle->NcdCantidad,
					$DatNotaCreditoDetalle->NcdImporte,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					NULL,
					NULL,
					NULL,
					NULL,

					$DatNotaCreditoDetalle->NcdUnidadMedida,
					2,

					NULL,
					NULL,
					NULL,
					
					$DatNotaCreditoDetalle->NcdCodigo,
					$DatNotaCreditoDetalle->NcdValorVenta,
					$DatNotaCreditoDetalle->NcdImpuesto,
					$DatNotaCreditoDetalle->NcdDescuento,
					$DatNotaCreditoDetalle->NcdGratuito,
					$DatNotaCreditoDetalle->NcdExonerado		,
					
					$DatNotaCreditoDetalle->NcdIncluyeSelectivo,
					$DatNotaCreditoDetalle->NcdImpuestoSelectivo						
					);		
					
					

				}		
			}
			
		}else{
			
			
			$ArrNotaCreditos = array();
			$NotaCredito = array();
					
			$ArrNotaCreditos = explode("#",$_POST['cmp_seleccionados']);
			$ArrNotaCreditos = array_filter($ArrNotaCreditos);
					
			foreach($ArrNotaCreditos as $DatNotaCredito){
				
				$NotaCredito = explode("%",$DatNotaCredito);
				
				$InsNotaCredito = new ClsNotaCredito();
				$InsNotaCredito->NcrId = $NotaCredito[0];	
				$InsNotaCredito->NctId = $NotaCredito[1];	
				$InsNotaCredito->MtdObtenerNotaCredito();
				
//				deb($InsNotaCredito);

				$InsNotaDebito->CliId = $InsNotaCredito->CliId;		
				$InsNotaDebito->CliNombre = $InsNotaCredito->CliNombre;
				$InsNotaDebito->CliApellidoPaterno = $InsNotaCredito->CliApellidoPaterno;
				$InsNotaDebito->CliApellidoMaterno = $InsNotaCredito->CliApellidoMaterno;
				$InsNotaDebito->TdoId = $InsNotaCredito->TdoId;
				$InsNotaDebito->CliNumeroDocumento = $InsNotaCredito->CliNumeroDocumento;

				$InsNotaDebito->NdbDireccion = $InsNotaCredito->NcrDireccion;
				$InsNotaDebito->NdbTelefono = $InsNotaCredito->NcrTelefono;
				$InsNotaDebito->NdbObservacion = $InsNotaCredito->NcrObservacion;	

				$InsNotaDebito->MonId = $InsNotaCredito->MonId;	
				$InsNotaDebito->NdbTipoCambio = $InsNotaCredito->NcrTipoCambio;		

				$InsNotaDebito->NdbIncluyeImpuesto = $InsNotaCredito->NcrIncluyeImpuesto;
				$InsNotaDebito->NdbPorcentajeImpuestoVenta = $InsNotaCredito->NcrPorcentajeImpuestoVenta;
				//$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = $InsNotaCredito->NcrPorcentajeImpuestoSelectivo;								
				$InsNotaDebito->NdbPorcentajeImpuestoSelectivo = (empty($InsNotaCredito->NcrPorcentajeImpuestoSelectivo)?$EmpresaImpuestoSelectivo:$InsNotaCredito->NcrPorcentajeImpuestoSelectivo);		
			
				$InsNotaDebito->NdbEstado = 5;				
				$InsNotaDebito->NdbTipo = 4;
				$InsNotaDebito->DocId = $InsNotaCredito->NcrId;
				$InsNotaDebito->DtaId = $InsNotaCredito->NctId;
				$InsNotaDebito->DtaNumero = $InsNotaCredito->NctNumero;
				
				$InsNotaDebito->OvvId = $InsNotaCredito->OvvId;

				$_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador] = $InsNotaCredito->NcrDatoAdicional1;
				$_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador] = $InsNotaCredito->NcrDatoAdicional2;
				$_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador] = $InsNotaCredito->NcrDatoAdicional3;
				$_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador] = $InsNotaCredito->NcrDatoAdicional4;
				$_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador] = $InsNotaCredito->NcrDatoAdicional5;
				$_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador] = $InsNotaCredito->NcrDatoAdicional6;
				$_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador] = $InsNotaCredito->NcrDatoAdicional7;
				$_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador] = $InsNotaCredito->NcrDatoAdicional8;
				$_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador] = $InsNotaCredito->NcrDatoAdicional9;
				$_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador] = $InsNotaCredito->NcrDatoAdicional10;
				
				$_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador] = $InsNotaCredito->NcrDatoAdicional11;
				$_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador] = $InsNotaCredito->NcrDatoAdicional12;
				$_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador] = $InsNotaCredito->NcrDatoAdicional13;
				$_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador] = $InsNotaCredito->NcrDatoAdicional14;
				$_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador] = $InsNotaCredito->NcrDatoAdicional15;
				$_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador] = $InsNotaCredito->NcrDatoAdicional16;
				$_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador] = $InsNotaCredito->NcrDatoAdicional17;
				$_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador] = $InsNotaCredito->NcrDatoAdicional18;
				$_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador] = $InsNotaCredito->NcrDatoAdicional19;
				$_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador] = $InsNotaCredito->NcrDatoAdicional20;
				
				$_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador] = $InsNotaCredito->NcrDatoAdicional21;
				$_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador] = $InsNotaCredito->NcrDatoAdicional22;
				$_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador] = $InsNotaCredito->NcrDatoAdicional23;
				$_SESSION['InsNotaDebitoDatoAdicional24'.$Identificador] = $InsNotaCredito->NcrDatoAdicional24;
				$_SESSION['InsNotaDebitoDatoAdicional25'.$Identificador] = $InsNotaCredito->NcrDatoAdicional25;
				
			
//deb($InsNotaDebito->MonId );
				if(is_array($InsNotaCredito->NotaCreditoDetalle)){
					foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){
						
						$DatNotaCreditoDetalle->NcdIncluyeSelectivo = 2;
						$DatNotaCreditoDetalle->NcdImpuestoSelectivo = 0;	
						
						if($InsNotaCredito->MonId<>$EmpresaMonedaId ){
							
							$DatNotaCreditoDetalle->NcdImporte = ($DatNotaCreditoDetalle->NcdImporte / $InsNotaCredito->NcrTipoCambio);
							$DatNotaCreditoDetalle->NcdPrecio = ($DatNotaCreditoDetalle->NcdPrecio  / $InsNotaCredito->NcrTipoCambio);
							
							$DatNotaCreditoDetalle->NcdValorVenta = ($DatNotaCreditoDetalle->NcdValorVenta  / $InsNotaCredito->NcrTipoCambio);
							$DatNotaCreditoDetalle->NcdImpuesto = ($DatNotaCreditoDetalle->NcdImpuesto  / $InsNotaCredito->NcrTipoCambio);
							$DatNotaCreditoDetalle->NcdImpuestoSelectivo = ($DatNotaCreditoDetalle->NcdImpuestoSelectivo  / $InsNotaCredito->NcrTipoCambio);
							
							$DatNotaCreditoDetalle->NcdDescuento = ($DatNotaCreditoDetalle->NcdDescuento  / $InsNotaCredito->NcrTipoCambio);	
						
						}
						
					//	deb($DatNotaCreditoDetalle->NcdValorVenta);
						
				/*
				SesionObjeto-NotaDebitoDetalleListado
				Parametro1 = NddId
				Parametro2 = NddDescripcion
				Parametro3 = 
				Parametro4 = NddPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NddTipo
				
				Parametro13 = NddUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NddCodigo
				Parametro19 = NddValorVenta
				Parametro20 = NddImpuesto
				Parametro21 = NddDescuentom
				Parametro22 = NddGratuito
				Parametro23 = NddExonerado	
				*/
					
						
						
						$_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						$DatNotaCreditoDetalle->NcdDescripcion,
						NULL,
						$DatNotaCreditoDetalle->NcdPrecio,
						$DatNotaCreditoDetalle->NcdCantidad,
						$DatNotaCreditoDetalle->NcdImporte,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						NULL,
						NULL,
						NULL,
						NULL,
	
						$DatNotaCreditoDetalle->NcdUnidadMedida,
						2,
	
						NULL,
						NULL,
						NULL,
						
						$DatNotaCreditoDetalle->NcdCodigo,
						$DatNotaCreditoDetalle->NcdValorVenta,
						$DatNotaCreditoDetalle->NcdImpuesto,
						$DatNotaCreditoDetalle->NcdDescuento,
						$DatNotaCreditoDetalle->NcdGratuito,
						$DatNotaCreditoDetalle->NcdExonerado	,
						
						$DatNotaCreditoDetalle->NcdIncluyeSelectivo	,
						$DatNotaCreditoDetalle->NcdImpuestoSelectivo							
						);	
						
//						deb($DatNotaCreditoDetalle->NcdIncluyeSelectivo);
//						deb($DatNotaCreditoDetalle->NcdExonerado	." - ".$DatNotaCreditoDetalle->NcdGratuito);	
	
					}		
				}

						
			}
					
		}
		
		break;
		
		
		
		
	}
	
	
	
	
	
}

?>
