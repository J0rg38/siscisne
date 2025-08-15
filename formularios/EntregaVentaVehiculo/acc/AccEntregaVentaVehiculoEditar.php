<?php
//Si se hizo click en guardar	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsEntregaVentaVehiculo->EvvId = $_POST['CmpId'];
	$InsEntregaVentaVehiculo->PerId = $_POST['CmpPersonal'];		
	$InsEntregaVentaVehiculo->EvvFechaProgramada = FncCambiaFechaAMysql($_POST['CmpFechaProgramada']);
	$InsEntregaVentaVehiculo->EvvHoraProgramada = ($_POST['CmpHoraProgramada']);
	$InsEntregaVentaVehiculo->EvvFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	list($InsEntregaVentaVehiculo->EvvAno,$InsEntregaVentaVehiculo->EvvMes,$aux) = explode("-",$InsEntregaVentaVehiculo->EvvFecha);
	$InsEntregaVentaVehiculo->EvvDuracion = $_POST['CmpDuracion'];		
	
	$InsEntregaVentaVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsEntregaVentaVehiculo->EinIdAnterior = $_POST['CmpVehiculoIngresoIdAnterior'];
	$InsEntregaVentaVehiculo->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	
	$InsEntregaVentaVehiculo->EvvVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsEntregaVentaVehiculo->EvvNumeroMotor = $_POST['CmpVehiculoIngresoNumeroMotor'];
	$InsEntregaVentaVehiculo->EvvAnoModelo = $_POST['CmpOrdenVentaVehiculoAnoModelo'];
	$InsEntregaVentaVehiculo->EvvAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	$InsEntregaVentaVehiculo->EvvColor = $_POST['VehiculoIngresoColor'];
	
	$InsEntregaVentaVehiculo->VmaId = $_POST['CmpVehiculoMarca'];
	$InsEntregaVentaVehiculo->VmoId = $_POST['CmpVehiculoModelo'];
	$InsEntregaVentaVehiculo->VveId = $_POST['CmpVehiculoVersion'];	
	
	$InsEntregaVentaVehiculo->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsEntregaVentaVehiculo->EinNumeroMotor = $_POST['CmpVehiculoIngresoNumeroMotor'];
	$InsEntregaVentaVehiculo->EinAnoModelo = $_POST['CmpOrdenVentaVehiculoAnoModelo'];
	$InsEntregaVentaVehiculo->EinAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	$InsEntregaVentaVehiculo->EinColor = $_POST['VehiculoIngresoColor'];
	
	$InsEntregaVentaVehiculo->EvvObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsEntregaVentaVehiculo->EvvEstado = $_POST['CmpEstado'];
	$InsEntregaVentaVehiculo->EvvTiempoModificacion = date("Y-m-d H:i:s");

	$InsEntregaVentaVehiculo->PerIdVendedor = $_POST['CmpPersonalVendedor'];




	$InsEntregaVentaVehiculo->OvvPrecio = (empty($_POST['CmpPrecio'])?0:preg_replace("/,/", "", $_POST['CmpPrecio']));
	$InsEntregaVentaVehiculo->OvvDescuento = (empty($_POST['CmpOrdenVentaVehiculoDescuento'])?0:preg_replace("/,/", "", $_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsEntregaVentaVehiculo->OvvDescuentoGerencia = (empty($_POST['CmpOrdenVentaVehiculoDescuentoGerencia'])?0:preg_replace("/,/", "", $_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsEntregaVentaVehiculo->OvvTotal = (empty($_POST['CmpOrdenVentaVehiculoTotal'])?0:preg_replace("/,/", "", $_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	
	
	$InsEntregaVentaVehiculo->OvvTotal = round($InsEntregaVentaVehiculo->OvvTotal,6);
	$InsEntregaVentaVehiculo->OvvSubTotal = round( ($InsEntregaVentaVehiculo->OvvTotal /( ($InsEntregaVentaVehiculo->EvvPorcentajeImpuestoVenta/100)+1 ) ) ,6);
	$InsEntregaVentaVehiculo->OvvImpuesto = $InsEntregaVentaVehiculo->OvvTotal - $InsEntregaVentaVehiculo->OvvSubTotal;

	$InsEntregaVentaVehiculo->EvvNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	
	if( $InsEntregaVentaVehiculo->MonId<>$EmpresaMonedaId ){
		
		$InsEntregaVentaVehiculo->OvvPrecio = round($InsEntregaVentaVehiculo->OvvPrecio * $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		$InsEntregaVentaVehiculo->OvvDescuento = round($InsEntregaVentaVehiculo->OvvDescuento * $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		$InsEntregaVentaVehiculo->OvvDescuentoGerencia = round($InsEntregaVentaVehiculo->OvvDescuentoGerencia * $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		
		$InsEntregaVentaVehiculo->OvvTotal = round($InsEntregaVentaVehiculo->OvvTotal * $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		$InsEntregaVentaVehiculo->OvvImpuesto = round($InsEntregaVentaVehiculo->OvvImpuesto * $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		$InsEntregaVentaVehiculo->OvvSubTotal = round($InsEntregaVentaVehiculo->OvvSubTotal * $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		
		
	}	
	
	if(empty($InsEntregaVentaVehiculo->EinId)){
			$Guardar = false;
			$Resultado.='#ERR_EVV_112';
	}
	
	if($Guardar){
		
		if($InsEntregaVentaVehiculo->MtdEditarEntregaVentaVehiculo()){			
			
			if(!empty($InsEntregaVentaVehiculo->EinId)){
				
				if($InsEntregaVentaVehiculo->EvvEstado == 3){
					
					if($InsEntregaVentaVehiculo->EinIdAnterior<>$InsEntregaVentaVehiculo->EinId){
						
						$InsVehiculoIngreso = new ClsVehiculoIngreso();
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","ENTREGADO",$InsEntregaVentaVehiculo->EinId);
						
					}

					
				}
				
			}
			
			
			//if($InsEntregaVentaVehiculo->EvvNotificar == 1){
//				
//				$InsPersonal = new ClsPersonal();
//				$InsPersonal->PerId = $InsEntregaVentaVehiculo->PerId;
//				$InsPersonal->MtdObtenerPersonal();
//				
//				if(!empty($InsPersonal->PerEmail)){
//					
//					$InsPersonal->PerEmail = trim($InsPersonal->PerEmail);
//					
//					$InsEntregaVentaVehiculo->MtdNotificarEntregaVentaVehiculoRegistro($InsEntregaVentaVehiculo->EvvId,$InsPersonal->PerEmail.",jblanco@cyc.com.pe,aliendo@cyc.com.pe,jmaquera@cyc.com.pe,dvercelone@cyc.com.pe,avillanueva@cyc.com.pe");
//				}
//				
//			}


			if($InsEntregaVentaVehiculo->EvvNotificar == 1){
				
				$InsPersonal = new ClsPersonal();
				$InsPersonal->PerId = $InsEntregaVentaVehiculo->PerIdVendedor;
				$InsPersonal->MtdObtenerPersonal();
				
				$PersonalEmail = "";
				
				if(!empty($InsPersonal->PerEmail)){

					$PersonalEmail  = trim($InsPersonal->PerEmail);

				}
				
				$InsEntregaVentaVehiculo->MtdNotificarEntregaVentaVehiculoRegistro($InsEntregaVentaVehiculo->EvvId,$PersonalEmail .",".$CorreosNotificacionOrdenVentaVehiculoProgramacionEntregaVehiculo);
				
			}
		
			$Edito = true;		
			FncCargarDatos();
			$Resultado.='#SAS_EVV_102';

		} else{
	
			$InsEntregaVentaVehiculo->EvvFecha = FncCambiaFechaANormal($InsEntregaVentaVehiculo->EvvFecha);
		
			
			if($InsEntregaVentaVehiculo->MonId<>$EmpresaMonedaId){
				
				$InsEntregaVentaVehiculo->OvvPrecio = round($InsEntregaVentaVehiculo->OvvPrecio / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
				$InsEntregaVentaVehiculo->OvvDescuento = round($InsEntregaVentaVehiculo->OvvDescuento / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
				$InsEntregaVentaVehiculo->OvvDescuentoGerencia = round($InsEntregaVentaVehiculo->OvvDescuentoGerencia / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
					
				
				$InsEntregaVentaVehiculo->OvvTotal = round($InsEntregaVentaVehiculo->OvvTotal / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
				$InsEntregaVentaVehiculo->OvvImpuesto = round($InsEntregaVentaVehiculo->OvvImpuesto / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
				$InsEntregaVentaVehiculo->OvvSubTotal = round($InsEntregaVentaVehiculo->OvvSubTotal / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
				
			}	

			$Resultado.='#ERR_EVV_102';		
		}			
	}else{

		$InsEntregaVentaVehiculo->EvvFecha = FncCambiaFechaANormal($InsEntregaVentaVehiculo->EvvFecha);
	
		if($InsEntregaVentaVehiculo->MonId<>$EmpresaMonedaId){
			
			$InsEntregaVentaVehiculo->OvvPrecio = round($InsEntregaVentaVehiculo->OvvPrecio / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
			$InsEntregaVentaVehiculo->OvvDescuento = round($InsEntregaVentaVehiculo->OvvDescuento / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
			$InsEntregaVentaVehiculo->OvvDescuentoGerencia = round($InsEntregaVentaVehiculo->OvvDescuentoGerencia / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
				
					
			$InsEntregaVentaVehiculo->OvvTotal = round($InsEntregaVentaVehiculo->OvvTotal / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
			$InsEntregaVentaVehiculo->OvvImpuesto = round($InsEntregaVentaVehiculo->OvvImpuesto / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
			$InsEntregaVentaVehiculo->OvvSubTotal = round($InsEntregaVentaVehiculo->OvvSubTotal / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		
		}	
		
	}

	

}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsEntregaVentaVehiculo;
	global $EmpresaMonedaId;


	unset($_SESSION['InsEntregaVentaVehiculoPropietario'.$Identificador]);
	
	$_SESSION['InsEntregaVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();

	$InsEntregaVentaVehiculo->EvvId = $GET_id;
	$InsEntregaVentaVehiculo->MtdObtenerEntregaVentaVehiculo();		

	$InsEntregaVentaVehiculo->EinIdAnterior = $InsEntregaVentaVehiculo->EinId;
	

	if($InsEntregaVentaVehiculo->MonId<>$EmpresaMonedaId){

		$InsEntregaVentaVehiculo->OvvPrecio = round($InsEntregaVentaVehiculo->OvvPrecio / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		$InsEntregaVentaVehiculo->OvvDescuento = round($InsEntregaVentaVehiculo->OvvDescuento / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		$InsEntregaVentaVehiculo->OvvDescuentoGerencia = round($InsEntregaVentaVehiculo->OvvDescuentoGerencia / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		
		$InsEntregaVentaVehiculo->OvvTotal = round($InsEntregaVentaVehiculo->OvvTotal / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		$InsEntregaVentaVehiculo->OvvImpuesto = round($InsEntregaVentaVehiculo->OvvImpuesto / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		$InsEntregaVentaVehiculo->OvvSubTotal = round($InsEntregaVentaVehiculo->OvvSubTotal / $InsEntregaVentaVehiculo->OvvTipoCambio,3);
		
			
	}	
	
	
	if(!empty($InsEntregaVentaVehiculo->EntregaVentaVehiculoPropietario)){
		foreach($InsEntregaVentaVehiculo->EntregaVentaVehiculoPropietario as $DatEntregaVentaVehiculoPropietario){

//SesionObjeto-EntregaVentaVehiculoPropietario
//Parametro1 = CviId
//Parametro2 = 
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = CviTiempoCreacion
//Parametro8 = CviTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = CliTelefono
//Parametro11 = CliCelular
//Parametro12 = CliEmail

//Parametro13 = CliNombre
//Parametro14 = CliApellidoPaterno
//Parametro15 = CliApellidoMaterno
//Parametro16 = OvpFirmaDJ

			$_SESSION['InsEntregaVentaVehiculoPropietario'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatEntregaVentaVehiculoPropietario->OvpId,
			NULL,
			$DatEntregaVentaVehiculoPropietario->CliNombre." ".$DatEntregaVentaVehiculoPropietario->CliApellidoPaterno." ".$DatEntregaVentaVehiculoPropietario->CliApellidoMaterno,
			$DatEntregaVentaVehiculoPropietario->CliNumeroDocumento,
			$DatEntregaVentaVehiculoPropietario->TdoId,
			$DatEntregaVentaVehiculoPropietario->CliId,
			($DatEntregaVentaVehiculoPropietario->OvpTiempoCreacion),
			($DatEntregaVentaVehiculoPropietario->OvpTiempoModificacion),
			$DatEntregaVentaVehiculoPropietario->TdoNombre,
			
			$DatEntregaVentaVehiculoPropietario->CliTelefono,
			$DatEntregaVentaVehiculoPropietario->CliCelular,
			$DatEntregaVentaVehiculoPropietario->CliEmail,
			
			$DatEntregaVentaVehiculoPropietario->CliNombre,
			$DatEntregaVentaVehiculoPropietario->CliApellidoPaterno,
			$DatEntregaVentaVehiculoPropietario->CliApellidoMaterno,
			$DatEntregaVentaVehiculoPropietario->OvpFirmaDJ
			);
		
		}
	}
		
	

	
}
?>