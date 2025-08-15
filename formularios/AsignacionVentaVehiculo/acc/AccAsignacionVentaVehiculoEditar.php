<?php
//Si se hizo click en guardar	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsAsignacionVentaVehiculo->AvvId = $_POST['CmpId'];
	$InsAsignacionVentaVehiculo->PerId = $_POST['CmpPersonal'];		
	$InsAsignacionVentaVehiculo->AvvFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsAsignacionVentaVehiculo->AvvHora = ($_POST['CmpHora']);
	list($InsAsignacionVentaVehiculo->AvvAno,$InsAsignacionVentaVehiculo->AvvMes,$aux) = explode("-",$InsAsignacionVentaVehiculo->AvvFecha);
	
	$InsAsignacionVentaVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsAsignacionVentaVehiculo->EinIdAnterior = $_POST['CmpVehiculoIngresoIdAnterior'];
	$InsAsignacionVentaVehiculo->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	
	$InsAsignacionVentaVehiculo->AvvVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsAsignacionVentaVehiculo->AvvNumeroMotor = $_POST['CmpVehiculoIngresoNumeroMotor'];
	$InsAsignacionVentaVehiculo->AvvAnoModelo = $_POST['CmpOrdenVentaVehiculoAnoModelo'];
	$InsAsignacionVentaVehiculo->AvvAnoFabricacion = $_POST['CmpOrdenVentaVehiculoAnoFabricacion'];
	$InsAsignacionVentaVehiculo->AvvColor = $_POST['VehiculoIngresoColor'];
	
	$InsAsignacionVentaVehiculo->VmaId = $_POST['CmpVehiculoMarca'];
	$InsAsignacionVentaVehiculo->VmoId = $_POST['CmpVehiculoModelo'];
	$InsAsignacionVentaVehiculo->VveId = $_POST['CmpVehiculoVersion'];	
	
	$InsAsignacionVentaVehiculo->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsAsignacionVentaVehiculo->EinNumeroMotor = $_POST['CmpVehiculoIngresoNumeroMotor'];
	$InsAsignacionVentaVehiculo->EinAnoModelo = $_POST['CmpOrdenVentaVehiculoAnoModelo'];
	$InsAsignacionVentaVehiculo->EinAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	$InsAsignacionVentaVehiculo->EinColor = $_POST['VehiculoIngresoColor'];
	
	$InsAsignacionVentaVehiculo->AvvObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsAsignacionVentaVehiculo->AvvEstado = $_POST['CmpEstado'];
	$InsAsignacionVentaVehiculo->AvvTiempoModificacion = date("Y-m-d H:i:s");

	
//	$InsAsignacionVentaVehiculo->OvvAprobacion1 = $_POST['CmpAprobacion'];	
	$InsAsignacionVentaVehiculo->AvvAprobacion = $_POST['CmpAprobacion'];	
	
	
	
	$InsAsignacionVentaVehiculo->OvvPrecio = (empty($_POST['CmpPrecio'])?0:preg_replace("/,/", "", $_POST['CmpPrecio']));
	$InsAsignacionVentaVehiculo->OvvDescuento = (empty($_POST['CmpOrdenVentaVehiculoDescuento'])?0:preg_replace("/,/", "", $_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsAsignacionVentaVehiculo->OvvDescuentoGerencia = (empty($_POST['CmpOrdenVentaVehiculoDescuentoGerencia'])?0:preg_replace("/,/", "", $_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsAsignacionVentaVehiculo->OvvTotal = (empty($_POST['CmpOrdenVentaVehiculoTotal'])?0:preg_replace("/,/", "", $_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	
	
	$InsAsignacionVentaVehiculo->OvvTotal = round($InsAsignacionVentaVehiculo->OvvTotal,6);
	$InsAsignacionVentaVehiculo->OvvSubTotal = round( ($InsAsignacionVentaVehiculo->OvvTotal /( ($InsAsignacionVentaVehiculo->AvvPorcentajeImpuestoVenta/100)+1 ) ) ,6);
	$InsAsignacionVentaVehiculo->OvvImpuesto = $InsAsignacionVentaVehiculo->OvvTotal - $InsAsignacionVentaVehiculo->OvvSubTotal;

	$InsAsignacionVentaVehiculo->AvvNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	
	if( $InsAsignacionVentaVehiculo->MonId<>$EmpresaMonedaId ){
		
		$InsAsignacionVentaVehiculo->OvvPrecio = round($InsAsignacionVentaVehiculo->OvvPrecio * $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		$InsAsignacionVentaVehiculo->OvvDescuento = round($InsAsignacionVentaVehiculo->OvvDescuento * $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		$InsAsignacionVentaVehiculo->OvvDescuentoGerencia = round($InsAsignacionVentaVehiculo->OvvDescuentoGerencia * $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		
		$InsAsignacionVentaVehiculo->OvvTotal = round($InsAsignacionVentaVehiculo->OvvTotal * $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		$InsAsignacionVentaVehiculo->OvvImpuesto = round($InsAsignacionVentaVehiculo->OvvImpuesto * $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		$InsAsignacionVentaVehiculo->OvvSubTotal = round($InsAsignacionVentaVehiculo->OvvSubTotal * $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		
		
	}	
	
	if(empty($InsAsignacionVentaVehiculo->EinId)){
			$Guardar = false;
			$Resultado.='#ERR_AVV_112';
	}
	
	if($Guardar){
		
		if($InsAsignacionVentaVehiculo->MtdEditarAsignacionVentaVehiculo()){			
			
			if(!empty($InsAsignacionVentaVehiculo->EinId)){
				
				if($InsAsignacionVentaVehiculo->AvvEstado == 3){
					
					$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
					$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion1",$InsAsignacionVentaVehiculo->AvvAprobacion,$InsAsignacionVentaVehiculo->OvvId);
					
					if($InsAsignacionVentaVehiculo->AvvAprobacion == 1){
						
						if($InsAsignacionVentaVehiculo->EinIdAnterior<>$InsAsignacionVentaVehiculo->EinId){
							
							$InsVehiculoIngreso = new ClsVehiculoIngreso();
							$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","STOCK",$InsAsignacionVentaVehiculo->EinIdAnterior);
							$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","RESERVADO",$InsAsignacionVentaVehiculo->EinId);
							
							$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
							$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("EinId",$InsAsignacionVentaVehiculo->EinId,$InsAsignacionVentaVehiculo->OvvId);
							
						}	

					}
					
					//if(!empty($Propietario)){
//						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("CliId",$Propietario,$InsAsignacionVentaVehiculo->EinId);	
//					}
					
				}
				
			}
			
			
			//if($InsAsignacionVentaVehiculo->AvvNotificar == 1){
//				
//				$InsPersonal = new ClsPersonal();
//				$InsPersonal->PerId = $InsAsignacionVentaVehiculo->PerId;
//				$InsPersonal->MtdObtenerPersonal();
//				
//				if(!empty($InsPersonal->PerEmail)){
//					
//					$InsPersonal->PerEmail = trim($InsPersonal->PerEmail);
//					
//					$InsAsignacionVentaVehiculo->MtdNotificarAsignacionVentaVehiculoRegistro($InsAsignacionVentaVehiculo->AvvId,$InsPersonal->PerEmail.",jblanco@cyc.com.pe,aliendo@cyc.com.pe,jmaquera@cyc.com.pe,dvercelone@cyc.com.pe,avillanueva@cyc.com.pe");
//				}
//				
//			}
		
			$Edito = true;		
			FncCargarDatos();
			$Resultado.='#SAS_AVV_102';

		} else{
	
			$InsAsignacionVentaVehiculo->AvvFecha = FncCambiaFechaANormal($InsAsignacionVentaVehiculo->AvvFecha);
		
			
			if($InsAsignacionVentaVehiculo->MonId<>$EmpresaMonedaId){
				
				$InsAsignacionVentaVehiculo->OvvPrecio = round($InsAsignacionVentaVehiculo->OvvPrecio / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvDescuento = round($InsAsignacionVentaVehiculo->OvvDescuento / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvDescuentoGerencia = round($InsAsignacionVentaVehiculo->OvvDescuentoGerencia / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
					
				
				$InsAsignacionVentaVehiculo->OvvTotal = round($InsAsignacionVentaVehiculo->OvvTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvImpuesto = round($InsAsignacionVentaVehiculo->OvvImpuesto / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvSubTotal = round($InsAsignacionVentaVehiculo->OvvSubTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				
			}	

			$Resultado.='#ERR_AVV_102';		
		}			
	}else{

		$InsAsignacionVentaVehiculo->AvvFecha = FncCambiaFechaANormal($InsAsignacionVentaVehiculo->AvvFecha);
	
		if($InsAsignacionVentaVehiculo->MonId<>$EmpresaMonedaId){
			
			$InsAsignacionVentaVehiculo->OvvPrecio = round($InsAsignacionVentaVehiculo->OvvPrecio / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
			$InsAsignacionVentaVehiculo->OvvDescuento = round($InsAsignacionVentaVehiculo->OvvDescuento / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
			$InsAsignacionVentaVehiculo->OvvDescuentoGerencia = round($InsAsignacionVentaVehiculo->OvvDescuentoGerencia / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				
					
			$InsAsignacionVentaVehiculo->OvvTotal = round($InsAsignacionVentaVehiculo->OvvTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
			$InsAsignacionVentaVehiculo->OvvImpuesto = round($InsAsignacionVentaVehiculo->OvvImpuesto / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
			$InsAsignacionVentaVehiculo->OvvSubTotal = round($InsAsignacionVentaVehiculo->OvvSubTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		
		}	
		
	}

	

}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsAsignacionVentaVehiculo;
	global $EmpresaMonedaId;


	unset($_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador]);
	
	$_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();

	$InsAsignacionVentaVehiculo->AvvId = $GET_id;
	$InsAsignacionVentaVehiculo->MtdObtenerAsignacionVentaVehiculo();		

	$InsAsignacionVentaVehiculo->EinIdAnterior = $InsAsignacionVentaVehiculo->EinId;
	

	if($InsAsignacionVentaVehiculo->MonId<>$EmpresaMonedaId){

		$InsAsignacionVentaVehiculo->OvvPrecio = round($InsAsignacionVentaVehiculo->OvvPrecio / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		$InsAsignacionVentaVehiculo->OvvDescuento = round($InsAsignacionVentaVehiculo->OvvDescuento / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		$InsAsignacionVentaVehiculo->OvvDescuentoGerencia = round($InsAsignacionVentaVehiculo->OvvDescuentoGerencia / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		
		$InsAsignacionVentaVehiculo->OvvTotal = round($InsAsignacionVentaVehiculo->OvvTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		$InsAsignacionVentaVehiculo->OvvImpuesto = round($InsAsignacionVentaVehiculo->OvvImpuesto / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		$InsAsignacionVentaVehiculo->OvvSubTotal = round($InsAsignacionVentaVehiculo->OvvSubTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
		
			
	}	
	
	
	if(!empty($InsAsignacionVentaVehiculo->AsignacionVentaVehiculoPropietario)){
		foreach($InsAsignacionVentaVehiculo->AsignacionVentaVehiculoPropietario as $DatAsignacionVentaVehiculoPropietario){

//SesionObjeto-AsignacionVentaVehiculoPropietario
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

			$_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatAsignacionVentaVehiculoPropietario->OvpId,
			NULL,
			$DatAsignacionVentaVehiculoPropietario->CliNombre." ".$DatAsignacionVentaVehiculoPropietario->CliApellidoPaterno." ".$DatAsignacionVentaVehiculoPropietario->CliApellidoMaterno,
			$DatAsignacionVentaVehiculoPropietario->CliNumeroDocumento,
			$DatAsignacionVentaVehiculoPropietario->TdoId,
			$DatAsignacionVentaVehiculoPropietario->CliId,
			($DatAsignacionVentaVehiculoPropietario->OvpTiempoCreacion),
			($DatAsignacionVentaVehiculoPropietario->OvpTiempoModificacion),
			$DatAsignacionVentaVehiculoPropietario->TdoNombre,
			
			$DatAsignacionVentaVehiculoPropietario->CliTelefono,
			$DatAsignacionVentaVehiculoPropietario->CliCelular,
			$DatAsignacionVentaVehiculoPropietario->CliEmail,
			
			$DatAsignacionVentaVehiculoPropietario->CliNombre,
			$DatAsignacionVentaVehiculoPropietario->CliApellidoPaterno,
			$DatAsignacionVentaVehiculoPropietario->CliApellidoMaterno,
			$DatAsignacionVentaVehiculoPropietario->OvpFirmaDJ
			);
		
		}
	}
		
	

	
}
?>