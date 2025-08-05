<?php
//Si se hizo click en guardar	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsAprobacionVentaVehiculo->AovId = $_POST['CmpId'];
	$InsAprobacionVentaVehiculo->PerId = $_POST['CmpPersonal'];		
	$InsAprobacionVentaVehiculo->AovFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsAprobacionVentaVehiculo->AovHora = ($_POST['CmpHora']);
	list($InsAprobacionVentaVehiculo->AovAno,$InsAprobacionVentaVehiculo->AovMes,$aux) = explode("-",$InsAprobacionVentaVehiculo->AovFecha);
	
	$InsAprobacionVentaVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsAprobacionVentaVehiculo->EinIdAnterior = $_POST['CmpVehiculoIngresoIdAnterior'];
	$InsAprobacionVentaVehiculo->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	
	$InsAprobacionVentaVehiculo->AovVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsAprobacionVentaVehiculo->AovNumeroMotor = $_POST['CmpVehiculoIngresoNumeroMotor'];
	$InsAprobacionVentaVehiculo->AovAnoModelo = $_POST['CmpOrdenVentaVehiculoAnoModelo'];
	$InsAprobacionVentaVehiculo->AovAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	$InsAprobacionVentaVehiculo->AovColor = $_POST['VehiculoIngresoColor'];
	
	$InsAprobacionVentaVehiculo->VmaId = $_POST['CmpVehiculoMarca'];
	$InsAprobacionVentaVehiculo->VmoId = $_POST['CmpVehiculoModelo'];
	$InsAprobacionVentaVehiculo->VveId = $_POST['CmpVehiculoVersion'];	
	
	$InsAprobacionVentaVehiculo->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsAprobacionVentaVehiculo->EinNumeroMotor = $_POST['CmpVehiculoIngresoNumeroMotor'];
	$InsAprobacionVentaVehiculo->EinAnoModelo = $_POST['CmpOrdenVentaVehiculoAnoModelo'];
	$InsAprobacionVentaVehiculo->EinAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	$InsAprobacionVentaVehiculo->EinColor = $_POST['VehiculoIngresoColor'];
	
	$InsAprobacionVentaVehiculo->AovObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsAprobacionVentaVehiculo->AovEstado = $_POST['CmpEstado'];
	$InsAprobacionVentaVehiculo->AovTiempoModificacion = date("Y-m-d H:i:s");

	$InsAprobacionVentaVehiculo->AovAprobacion = $_POST['AovAprobacion'];

	$InsAprobacionVentaVehiculo->OvvPrecio = (empty($_POST['CmpPrecio'])?0:eregi_replace(",","",$_POST['CmpPrecio']));
	$InsAprobacionVentaVehiculo->OvvDescuento = (empty($_POST['CmpOrdenVentaVehiculoDescuento'])?0:eregi_replace(",","",$_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsAprobacionVentaVehiculo->OvvDescuentoGerencia = (empty($_POST['CmpOrdenVentaVehiculoDescuentoGerencia'])?0:eregi_replace(",","",$_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsAprobacionVentaVehiculo->OvvTotal = (empty($_POST['CmpOrdenVentaVehiculoTotal'])?0:eregi_replace(",","",$_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	
	
	$InsAprobacionVentaVehiculo->OvvTotal = round($InsAprobacionVentaVehiculo->OvvTotal,6);
	$InsAprobacionVentaVehiculo->OvvSubTotal = round( ($InsAprobacionVentaVehiculo->OvvTotal /( ($InsAprobacionVentaVehiculo->AovPorcentajeImpuestoVenta/100)+1 ) ) ,6);
	$InsAprobacionVentaVehiculo->OvvImpuesto = $InsAprobacionVentaVehiculo->OvvTotal - $InsAprobacionVentaVehiculo->OvvSubTotal;

	$InsAprobacionVentaVehiculo->AovNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	
	if( $InsAprobacionVentaVehiculo->MonId<>$EmpresaMonedaId ){
		
		$InsAprobacionVentaVehiculo->OvvPrecio = round($InsAprobacionVentaVehiculo->OvvPrecio * $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		$InsAprobacionVentaVehiculo->OvvDescuento = round($InsAprobacionVentaVehiculo->OvvDescuento * $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		$InsAprobacionVentaVehiculo->OvvDescuentoGerencia = round($InsAprobacionVentaVehiculo->OvvDescuentoGerencia * $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		
		$InsAprobacionVentaVehiculo->OvvTotal = round($InsAprobacionVentaVehiculo->OvvTotal * $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		$InsAprobacionVentaVehiculo->OvvImpuesto = round($InsAprobacionVentaVehiculo->OvvImpuesto * $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		$InsAprobacionVentaVehiculo->OvvSubTotal = round($InsAprobacionVentaVehiculo->OvvSubTotal * $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		
		
	}	
	
	if(empty($InsAprobacionVentaVehiculo->EinId)){
			$Guardar = false;
			$Resultado.='#ERR_AOV_112';
	}
	
	if($Guardar){
		
		if($InsAprobacionVentaVehiculo->MtdEditarAprobacionVentaVehiculo()){			
			
			if(!empty($InsAprobacionVentaVehiculo->EinId)){
				
				if($InsAprobacionVentaVehiculo->AovEstado == 3){
					
					$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
					$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",$InsAprobacionVentaVehiculo->AovAprobacion,$InsAprobacionVentaVehiculo->OvvId);
	
				}
				
			}
			
			
		
			$Edito = true;		
			FncCargarDatos();
			$Resultado.='#SAS_AOV_102';

		} else{
	
			$InsAprobacionVentaVehiculo->AovFecha = FncCambiaFechaANormal($InsAprobacionVentaVehiculo->AovFecha);
		
			
			if($InsAprobacionVentaVehiculo->MonId<>$EmpresaMonedaId){
				
				$InsAprobacionVentaVehiculo->OvvPrecio = round($InsAprobacionVentaVehiculo->OvvPrecio / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvDescuento = round($InsAprobacionVentaVehiculo->OvvDescuento / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvDescuentoGerencia = round($InsAprobacionVentaVehiculo->OvvDescuentoGerencia / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
					
				
				$InsAprobacionVentaVehiculo->OvvTotal = round($InsAprobacionVentaVehiculo->OvvTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvImpuesto = round($InsAprobacionVentaVehiculo->OvvImpuesto / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvSubTotal = round($InsAprobacionVentaVehiculo->OvvSubTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				
			}	

			$Resultado.='#ERR_AOV_102';		
		}			
	}else{

		$InsAprobacionVentaVehiculo->AovFecha = FncCambiaFechaANormal($InsAprobacionVentaVehiculo->AovFecha);
	
		if($InsAprobacionVentaVehiculo->MonId<>$EmpresaMonedaId){
			
			$InsAprobacionVentaVehiculo->OvvPrecio = round($InsAprobacionVentaVehiculo->OvvPrecio / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
			$InsAprobacionVentaVehiculo->OvvDescuento = round($InsAprobacionVentaVehiculo->OvvDescuento / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
			$InsAprobacionVentaVehiculo->OvvDescuentoGerencia = round($InsAprobacionVentaVehiculo->OvvDescuentoGerencia / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				
					
			$InsAprobacionVentaVehiculo->OvvTotal = round($InsAprobacionVentaVehiculo->OvvTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
			$InsAprobacionVentaVehiculo->OvvImpuesto = round($InsAprobacionVentaVehiculo->OvvImpuesto / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
			$InsAprobacionVentaVehiculo->OvvSubTotal = round($InsAprobacionVentaVehiculo->OvvSubTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		
		}	
		
	}

	

}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsAprobacionVentaVehiculo;
	global $EmpresaMonedaId;


	unset($_SESSION['InsAprobacionVentaVehiculoPropietario'.$Identificador]);
	
	$_SESSION['InsAprobacionVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();

	$InsAprobacionVentaVehiculo->AovId = $GET_id;
	$InsAprobacionVentaVehiculo->MtdObtenerAprobacionVentaVehiculo();		

	$InsAprobacionVentaVehiculo->EinIdAnterior = $InsAprobacionVentaVehiculo->EinId;
	

	if($InsAprobacionVentaVehiculo->MonId<>$EmpresaMonedaId){

		$InsAprobacionVentaVehiculo->OvvPrecio = round($InsAprobacionVentaVehiculo->OvvPrecio / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		$InsAprobacionVentaVehiculo->OvvDescuento = round($InsAprobacionVentaVehiculo->OvvDescuento / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		$InsAprobacionVentaVehiculo->OvvDescuentoGerencia = round($InsAprobacionVentaVehiculo->OvvDescuentoGerencia / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		
		$InsAprobacionVentaVehiculo->OvvTotal = round($InsAprobacionVentaVehiculo->OvvTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		$InsAprobacionVentaVehiculo->OvvImpuesto = round($InsAprobacionVentaVehiculo->OvvImpuesto / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		$InsAprobacionVentaVehiculo->OvvSubTotal = round($InsAprobacionVentaVehiculo->OvvSubTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
		
			
	}	
	
	
	if(!empty($InsAprobacionVentaVehiculo->AprobacionVentaVehiculoPropietario)){
		foreach($InsAprobacionVentaVehiculo->AprobacionVentaVehiculoPropietario as $DatAprobacionVentaVehiculoPropietario){

//SesionObjeto-AprobacionVentaVehiculoPropietario
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

			$_SESSION['InsAprobacionVentaVehiculoPropietario'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatAprobacionVentaVehiculoPropietario->OvpId,
			NULL,
			$DatAprobacionVentaVehiculoPropietario->CliNombre." ".$DatAprobacionVentaVehiculoPropietario->CliApellidoPaterno." ".$DatAprobacionVentaVehiculoPropietario->CliApellidoMaterno,
			$DatAprobacionVentaVehiculoPropietario->CliNumeroDocumento,
			$DatAprobacionVentaVehiculoPropietario->TdoId,
			$DatAprobacionVentaVehiculoPropietario->CliId,
			($DatAprobacionVentaVehiculoPropietario->OvpTiempoCreacion),
			($DatAprobacionVentaVehiculoPropietario->OvpTiempoModificacion),
			$DatAprobacionVentaVehiculoPropietario->TdoNombre,
			
			$DatAprobacionVentaVehiculoPropietario->CliTelefono,
			$DatAprobacionVentaVehiculoPropietario->CliCelular,
			$DatAprobacionVentaVehiculoPropietario->CliEmail,
			
			$DatAprobacionVentaVehiculoPropietario->CliNombre,
			$DatAprobacionVentaVehiculoPropietario->CliApellidoPaterno,
			$DatAprobacionVentaVehiculoPropietario->CliApellidoMaterno,
			$DatAprobacionVentaVehiculoPropietario->OvpFirmaDJ
			);
		
		}
	}
		
	

	
}
?>