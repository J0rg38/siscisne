<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsAprobacionVentaVehiculo->UsuId = $_SESSION['SesionId'];	
	
	$InsAprobacionVentaVehiculo->AovId = $_POST['CmpId'];	
	$InsAprobacionVentaVehiculo->PerId = $_POST['CmpPersonal'];		
	$InsAprobacionVentaVehiculo->AovFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsAprobacionVentaVehiculo->AovHora = ($_POST['CmpHora']);
		
	list($InsAprobacionVentaVehiculo->AovAno,$InsAprobacionVentaVehiculo->AovMes,$aux) = explode("-",$InsAprobacionVentaVehiculo->AovFecha);
	
	$InsAprobacionVentaVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
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
	$InsAprobacionVentaVehiculo->AovTiempoCreacion = date("Y-m-d H:i:s");
	$InsAprobacionVentaVehiculo->AovTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsAprobacionVentaVehiculo->AovAprobacion = $_POST['CmpAprobacion'];
	
	$InsAprobacionVentaVehiculo->OvvPrecio = (empty($_POST['CmpPrecio'])?0:preg_replace("/,/", "", $_POST['CmpPrecio']));
	$InsAprobacionVentaVehiculo->OvvDescuento = (empty($_POST['CmpOrdenVentaVehiculoDescuento'])?0:preg_replace("/,/", "", $_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsAprobacionVentaVehiculo->OvvDescuentoGerencia = (empty($_POST['CmpOrdenVentaVehiculoDescuentoGerencia'])?0:preg_replace("/,/", "", $_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsAprobacionVentaVehiculo->OvvTotal = (empty($_POST['CmpOrdenVentaVehiculoTotal'])?0:preg_replace("/,/", "", $_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	
	
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

	$InsAprobacionVentaVehiculo->AprobacionVentaVehiculoObsequio = array();
	$InsAprobacionVentaVehiculo->AprobacionVentaVehiculoCondicionVenta = array();

	if(empty($InsAprobacionVentaVehiculo->EinId)){
			$Guardar = false;
			$Resultado.='#ERR_AOV_112';
	}
	
	if($Guardar){
		
		if($InsAprobacionVentaVehiculo->MtdRegistrarAprobacionVentaVehiculo()){

			if($InsAprobacionVentaVehiculo->AovEstado == 3){
				
				$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
				$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",$InsAprobacionVentaVehiculo->AovAprobacion,$InsAprobacionVentaVehiculo->OvvId);
					
				//if($InsAprobacionVentaVehiculo->AovAprobacion == 1){
//					
//					$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//					$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",1,$InsAprobacionVentaVehiculo->OvvId);
//					
//				}
				
			}
			
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "jba80@hotmail.com";
		
			if($InsAprobacionVentaVehiculo->AovNotificar == 1){
				
					$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
					$InsOrdenVentaVehiculo->OvvId = $InsAprobacionVentaVehiculo->OvvId ;
					$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
						
						
					if(!empty($InsOrdenVentaVehiculo->PerId)){
						
						$InsPersonal = new ClsPersonal();
						$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
						$InsPersonal->MtdObtenerPersonal();
					
					}
					
					$EmailPersonal = "";
					
					if(!empty($InsPersonal->PerEmail)){
						
						$EmailPersonal .= trim($InsPersonal->PerEmail).",";
						
					}	
					
					if(!empty($InsPersonal->PerEmailVendedor)){
						
						$EmailPersonal .= trim($InsPersonal->PerEmailVendedor).",";
						
					}	
			
					if($InsAprobacionVentaVehiculo->AovAprobacion==1){
						
						$InsAprobacionVentaVehiculo->MtdNotificarAprobacionVentaVehiculoAprobado($InsAprobacionVentaVehiculo->AovId,$EmailPersonal.",".$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta);
						
					}else{
						
						$InsAprobacionVentaVehiculo->MtdNotificarAprobacionVentaVehiculoDesaprobado($InsAprobacionVentaVehiculo->AovId,$EmailPersonal.",".$CorreosNotificacionOrdenVentaVehiculoAprobacionVenta);
					}
					
				
			}
			
		
			$Registro = true;

			unset($InsAprobacionVentaVehiculo);
			$InsAprobacionVentaVehiculo = new ClsAprobacionVentaVehiculo();
			FncNuevo();
			$Resultado.='#SAS_AOV_101';

		} else{
			
			if($InsAprobacionVentaVehiculo->MonId<>$EmpresaMonedaId){
				
				$InsAprobacionVentaVehiculo->OvvPrecio = round($InsAprobacionVentaVehiculo->OvvPrecio / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvDescuento = round($InsAprobacionVentaVehiculo->OvvDescuento / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);		
				
				
				
				$InsAprobacionVentaVehiculo->OvvTotal = round($InsAprobacionVentaVehiculo->OvvTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvImpuesto = round($InsAprobacionVentaVehiculo->OvvImpuesto / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvSubTotal = round($InsAprobacionVentaVehiculo->OvvSubTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				
				$InsAprobacionVentaVehiculo->CveTotal = round($InsAprobacionVentaVehiculo->CveTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
				
			}	
					
			$InsAprobacionVentaVehiculo->AovFecha = FncCambiaFechaANormal($InsAprobacionVentaVehiculo->AovFecha);
			
			$Resultado.='#ERR_AOV_101';
		}
	
	}else{

	
		if($InsAprobacionVentaVehiculo->MonId<>$EmpresaMonedaId){

			$InsAprobacionVentaVehiculo->OvvPrecio = round($InsAprobacionVentaVehiculo->OvvPrecio / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
			$InsAprobacionVentaVehiculo->OvvDescuento = round($InsAprobacionVentaVehiculo->OvvDescuento / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
			$InsAprobacionVentaVehiculo->OvvDescuentoGerencia = round($InsAprobacionVentaVehiculo->OvvDescuentoGerencia / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);			

			$InsAprobacionVentaVehiculo->OvvTotal = round($InsAprobacionVentaVehiculo->OvvTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
			$InsAprobacionVentaVehiculo->OvvImpuesto = round($InsAprobacionVentaVehiculo->OvvImpuesto / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
			$InsAprobacionVentaVehiculo->OvvSubTotal = round($InsAprobacionVentaVehiculo->OvvSubTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);
			$InsAprobacionVentaVehiculo->CveTotal = round($InsAprobacionVentaVehiculo->CveTotal / $InsAprobacionVentaVehiculo->OvvTipoCambio,3);

		}	

		$InsAprobacionVentaVehiculo->AovFecha = FncCambiaFechaANormal($InsAprobacionVentaVehiculo->AovFecha);
		
	}


}else{

	FncNuevo();

	switch($GET_Origen){

	
		case "OrdenVentaVehiculo":
			
			$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
			$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;
			$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
			
			$InsAprobacionVentaVehiculo->PerIdVendedor = $InsOrdenVentaVehiculo->PerId;
			$InsAprobacionVentaVehiculo->OvvId = $InsOrdenVentaVehiculo->OvvId;
			
			$InsAprobacionVentaVehiculo->CliId = $InsOrdenVentaVehiculo->CliId;
			$InsAprobacionVentaVehiculo->TdoId = $InsOrdenVentaVehiculo->TdoId;
			$InsAprobacionVentaVehiculo->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
			$InsAprobacionVentaVehiculo->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
			$InsAprobacionVentaVehiculo->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;
			$InsAprobacionVentaVehiculo->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
						
			$InsAprobacionVentaVehiculo->CliTelefono = $InsOrdenVentaVehiculo->CliTelefono;
			$InsAprobacionVentaVehiculo->CliCelular = $InsOrdenVentaVehiculo->CliCelular;
			$InsAprobacionVentaVehiculo->CliEmail = $InsOrdenVentaVehiculo->CliEmail;

			$InsAprobacionVentaVehiculo->TdoNombre = $InsOrdenVentaVehiculo->TdoNombre;


			$InsAprobacionVentaVehiculo->MonId = $InsOrdenVentaVehiculo->MonId;
			$InsAprobacionVentaVehiculo->OvvTipoCambio = $InsOrdenVentaVehiculo->OvvTipoCambio;
			
			$InsAprobacionVentaVehiculo->OvvPorcentajeImpuestoVenta = $InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta;
			
			$InsAprobacionVentaVehiculo->OvvFecha = $InsOrdenVentaVehiculo->OvvFecha;
			$InsAprobacionVentaVehiculo->OvvFechaEntrega = $InsOrdenVentaVehiculo->OvvFechaEntrega;

			$InsAprobacionVentaVehiculo->AovEstado = 3;	
			$InsAprobacionVentaVehiculo->AovTiempoCreacion = date("Y-m-d H:i:s");
			$InsAprobacionVentaVehiculo->AovTiempoModificacion = date("Y-m-d H:i:s");
	
			
		
			
			$InsAprobacionVentaVehiculo->VmaId = $InsOrdenVentaVehiculo->VmaId;
			$InsAprobacionVentaVehiculo->VmoId = $InsOrdenVentaVehiculo->VmoId;
			$InsAprobacionVentaVehiculo->VveId = $InsOrdenVentaVehiculo->VveId;

			$InsAprobacionVentaVehiculo->EinId = $InsOrdenVentaVehiculo->EinId;
			
			$InsAprobacionVentaVehiculo->EinVIN = $InsOrdenVentaVehiculo->EinVIN;
			$InsAprobacionVentaVehiculo->EinNumeroMotor = $InsOrdenVentaVehiculo->EinNumeroMotor;
			$InsAprobacionVentaVehiculo->EinAnoModelo = $InsOrdenVentaVehiculo->EinAnoModelo;
			$InsAprobacionVentaVehiculo->EinAnoFabricacion = $InsOrdenVentaVehiculo->EinAnoFabricacion;
			$InsAprobacionVentaVehiculo->EinColor = $InsOrdenVentaVehiculo->EinColor;

			$InsAprobacionVentaVehiculo->OvvPrecio = $InsOrdenVentaVehiculo->OvvPrecio;
			$InsAprobacionVentaVehiculo->OvvDescuento = $InsOrdenVentaVehiculo->OvvDescuento;
			$InsAprobacionVentaVehiculo->OvvDescuentoGerencia = $InsOrdenVentaVehiculo->OvvDescuentoGerencia;
			$InsAprobacionVentaVehiculo->OvvSubTotal = $InsOrdenVentaVehiculo->OvvSubTotal;
			$InsAprobacionVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvImpuesto;
			$InsAprobacionVentaVehiculo->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal;

			
			if($InsAprobacionVentaVehiculo->MonId<>$EmpresaMonedaId ){
				
				$InsAprobacionVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				$InsAprobacionVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsAprobacionVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
			}	


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


if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){

//SesionObjeto-OrdenVentaVehiculoPropietario
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
			$DatOrdenVentaVehiculoPropietario->OvpId,
			NULL,
			$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno,
			$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento,
			$DatOrdenVentaVehiculoPropietario->TdoId,
			$DatOrdenVentaVehiculoPropietario->CliId,
			($DatOrdenVentaVehiculoPropietario->OvpTiempoCreacion),
			($DatOrdenVentaVehiculoPropietario->OvpTiempoModificacion),
			$DatOrdenVentaVehiculoPropietario->TdoNombre,
			
			$DatOrdenVentaVehiculoPropietario->CliTelefono,
			$DatOrdenVentaVehiculoPropietario->CliCelular,
			$DatOrdenVentaVehiculoPropietario->CliEmail,
			
			$DatOrdenVentaVehiculoPropietario->CliNombre,
			$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno,
			$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno,
			$DatOrdenVentaVehiculoPropietario->OvpFirmaDJ
			);
		
		}
	}



			/*$_SESSION['InsAprobacionVentaVehiculoPropietario'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			NULL,
			$InsAprobacionVentaVehiculo->CliNombre." ".$InsOrdenVentaVehiculo->CliApellidoPaterno." ".$InsOrdenVentaVehiculo->CliApellidoMaterno,
			$InsOrdenVentaVehiculo->CliNumeroDocumento,
			$InsOrdenVentaVehiculo->TdoId,
			$InsOrdenVentaVehiculo->CliId,
			(date("d/m/Y H:i:s")),
			(date("d/m/Y H:i:s")),
			$InsOrdenVentaVehiculo->TdoNombre,
			
			$InsOrdenVentaVehiculo->CliTelefono,
			$InsOrdenVentaVehiculo->CliCelular,
			$InsOrdenVentaVehiculo->CliEmail,
			
			$InsOrdenVentaVehiculo->CliNombre,
			$InsOrdenVentaVehiculo->CliApellidoPaterno,
			$InsOrdenVentaVehiculo->CliApellidoMaterno,
			"1"
			);*/
			
		break;
		
			
	}
	
}

function FncNuevo(){

	global $InsAprobacionVentaVehiculo;
	global $Identificador;
	
	unset($_SESSION['InsAprobacionVentaVehiculoPropietario'.$Identificador]);
		
	$_SESSION['InsAprobacionVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();	
	
	
	$InsAprobacionVentaVehiculo->AovEstado = 3;
	$InsAprobacionVentaVehiculo->MonId = "MON-10001";

	$InsAprobacionVentaVehiculo->AovNotificar = 1;
	$InsAprobacionVentaVehiculo->AovEntregarNotificar = 1;
	$InsAprobacionVentaVehiculo->PerId = $_SESSION['SesionPersonal'];
	$InsAprobacionVentaVehiculo->AovAprobacion = 1;
}

/* <li>01 Juego de Pisos</li> */
?>