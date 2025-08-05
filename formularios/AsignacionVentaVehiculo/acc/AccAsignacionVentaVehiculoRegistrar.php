<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsAsignacionVentaVehiculo->UsuId = $_SESSION['SesionId'];	
	
	$InsAsignacionVentaVehiculo->AvvId = $_POST['CmpId'];	
	$InsAsignacionVentaVehiculo->PerId = $_POST['CmpPersonal'];		
	$InsAsignacionVentaVehiculo->AvvFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsAsignacionVentaVehiculo->AvvHora = ($_POST['CmpHora']);
		
	list($InsAsignacionVentaVehiculo->AvvAno,$InsAsignacionVentaVehiculo->AvvMes,$aux) = explode("-",$InsAsignacionVentaVehiculo->AvvFecha);
	
	$InsAsignacionVentaVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
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
	$InsAsignacionVentaVehiculo->AvvTiempoCreacion = date("Y-m-d H:i:s");
	$InsAsignacionVentaVehiculo->AvvTiempoModificacion = date("Y-m-d H:i:s");

	$InsAsignacionVentaVehiculo->AvvEstado = $_POST['CmpEstado'];	
	
	//$InsAsignacionVentaVehiculo->OvvAprobacion1 = $_POST['CmpAprobacion'];	
	$InsAsignacionVentaVehiculo->AvvAprobacion = $_POST['CmpAprobacion'];	
	
	
	$InsAsignacionVentaVehiculo->OvvPrecio = (empty($_POST['CmpPrecio'])?0:eregi_replace(",","",$_POST['CmpPrecio']));
	$InsAsignacionVentaVehiculo->OvvDescuento = (empty($_POST['CmpOrdenVentaVehiculoDescuento'])?0:eregi_replace(",","",$_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsAsignacionVentaVehiculo->OvvDescuentoGerencia = (empty($_POST['CmpOrdenVentaVehiculoDescuentoGerencia'])?0:eregi_replace(",","",$_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	$InsAsignacionVentaVehiculo->OvvTotal = (empty($_POST['CmpOrdenVentaVehiculoTotal'])?0:eregi_replace(",","",$_POST['CmpOrdenVentaVehiculoDescuentoGerencia']));
	
	
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

	$InsAsignacionVentaVehiculo->AsignacionVentaVehiculoObsequio = array();
	$InsAsignacionVentaVehiculo->AsignacionVentaVehiculoCondicionVenta = array();

	if(empty($InsAsignacionVentaVehiculo->EinId)){
			$Guardar = false;
			$Resultado.='#ERR_AVV_112';
	}
	
	if($Guardar){
		
		if($InsAsignacionVentaVehiculo->MtdRegistrarAsignacionVentaVehiculo()){

			if(!empty($InsAsignacionVentaVehiculo->EinId)){
				
				if($InsAsignacionVentaVehiculo->AvvEstado == 3){
					
					//$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//					$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion1",$InsAsignacionVentaVehiculo->AvvAprobacion,$InsAsignacionVentaVehiculo->OvvId);
					
					if($InsAsignacionVentaVehiculo->AvvAprobacion == 1){
						
						//$InsVehiculoIngreso = new ClsVehiculoIngreso();
//						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","RESERVADO",$InsAsignacionVentaVehiculo->EinId);
//						
//						$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//						$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("EinId",$InsAsignacionVentaVehiculo->EinId,$InsAsignacionVentaVehiculo->OvvId);
						
					}	
					
					
					
				}
				
			}
		
		//$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN = "jba80@hotmail.com";
		
			if($InsAsignacionVentaVehiculo->AvvNotificar == 1){
				
					$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
					$InsOrdenVentaVehiculo->OvvId = $InsAsignacionVentaVehiculo->OvvId ;
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
					
					
				//$InsPersonal = new ClsPersonal();
//				$InsPersonal->PerId = $InsAsignacionVentaVehiculo->PerId;
//				$InsPersonal->MtdObtenerPersonal();
//				
//				$EmailPersonal = "";
//				
//				if(!empty($InsPersonal->PerEmail)){
//					
//					$EmailPersonal .= trim($InsPersonal->PerEmail).",";
//					
//				}	
//				
//				if(!empty($InsPersonal->PerEmailVendedor)){
//					
//					$EmailPersonal .= trim($InsPersonal->PerEmailVendedor).",";
//					
//				}	
					
				$InsAsignacionVentaVehiculo->MtdNotificarAsignacionVentaVehiculoRegistro($InsAsignacionVentaVehiculo->AvvId,$EmailPersonal.",".$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN);
				
			}
			
		
			$Registro = true;

			unset($InsAsignacionVentaVehiculo);
			$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
			FncNuevo();
			$Resultado.='#SAS_AVV_101';

		} else{
			
			if($InsAsignacionVentaVehiculo->MonId<>$EmpresaMonedaId){
				
				$InsAsignacionVentaVehiculo->OvvPrecio = round($InsAsignacionVentaVehiculo->OvvPrecio / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvDescuento = round($InsAsignacionVentaVehiculo->OvvDescuento / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);		
				
				
				
				$InsAsignacionVentaVehiculo->OvvTotal = round($InsAsignacionVentaVehiculo->OvvTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvImpuesto = round($InsAsignacionVentaVehiculo->OvvImpuesto / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvSubTotal = round($InsAsignacionVentaVehiculo->OvvSubTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				
				$InsAsignacionVentaVehiculo->CveTotal = round($InsAsignacionVentaVehiculo->CveTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
				
			}	
					
			$InsAsignacionVentaVehiculo->AvvFecha = FncCambiaFechaANormal($InsAsignacionVentaVehiculo->AvvFecha);
			
			$Resultado.='#ERR_AVV_101';
		}
	
	}else{

	
		if($InsAsignacionVentaVehiculo->MonId<>$EmpresaMonedaId){

			$InsAsignacionVentaVehiculo->OvvPrecio = round($InsAsignacionVentaVehiculo->OvvPrecio / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
			$InsAsignacionVentaVehiculo->OvvDescuento = round($InsAsignacionVentaVehiculo->OvvDescuento / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
			$InsAsignacionVentaVehiculo->OvvDescuentoGerencia = round($InsAsignacionVentaVehiculo->OvvDescuentoGerencia / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);			

			$InsAsignacionVentaVehiculo->OvvTotal = round($InsAsignacionVentaVehiculo->OvvTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
			$InsAsignacionVentaVehiculo->OvvImpuesto = round($InsAsignacionVentaVehiculo->OvvImpuesto / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
			$InsAsignacionVentaVehiculo->OvvSubTotal = round($InsAsignacionVentaVehiculo->OvvSubTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);
			$InsAsignacionVentaVehiculo->CveTotal = round($InsAsignacionVentaVehiculo->CveTotal / $InsAsignacionVentaVehiculo->OvvTipoCambio,3);

		}	

		$InsAsignacionVentaVehiculo->AvvFecha = FncCambiaFechaANormal($InsAsignacionVentaVehiculo->AvvFecha);
		
	}


}else{

	FncNuevo();

	switch($GET_Origen){

	
		case "OrdenVentaVehiculo":
			
			$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
			$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;
			$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
			
			$InsAsignacionVentaVehiculo->PerIdVendedor = $InsOrdenVentaVehiculo->PerId;
			$InsAsignacionVentaVehiculo->OvvId = $InsOrdenVentaVehiculo->OvvId;
			
			$InsAsignacionVentaVehiculo->CliId = $InsOrdenVentaVehiculo->CliId;
			$InsAsignacionVentaVehiculo->TdoId = $InsOrdenVentaVehiculo->TdoId;
			$InsAsignacionVentaVehiculo->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
			$InsAsignacionVentaVehiculo->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
			$InsAsignacionVentaVehiculo->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;
			$InsAsignacionVentaVehiculo->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
						
			$InsAsignacionVentaVehiculo->CliTelefono = $InsOrdenVentaVehiculo->CliTelefono;
			$InsAsignacionVentaVehiculo->CliCelular = $InsOrdenVentaVehiculo->CliCelular;
			$InsAsignacionVentaVehiculo->CliEmail = $InsOrdenVentaVehiculo->CliEmail;

			$InsAsignacionVentaVehiculo->TdoNombre = $InsOrdenVentaVehiculo->TdoNombre;


			$InsAsignacionVentaVehiculo->MonId = $InsOrdenVentaVehiculo->MonId;
			$InsAsignacionVentaVehiculo->OvvTipoCambio = $InsOrdenVentaVehiculo->OvvTipoCambio;
			
			$InsAsignacionVentaVehiculo->OvvPorcentajeImpuestoVenta = $InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta;
			
			$InsAsignacionVentaVehiculo->OvvFecha = $InsOrdenVentaVehiculo->OvvFecha;
			$InsAsignacionVentaVehiculo->OvvFechaEntrega = $InsOrdenVentaVehiculo->OvvFechaEntrega;

			$InsAsignacionVentaVehiculo->AvvEstado = 3;	
			$InsAsignacionVentaVehiculo->AvvTiempoCreacion = date("Y-m-d H:i:s");
			$InsAsignacionVentaVehiculo->AvvTiempoModificacion = date("Y-m-d H:i:s");
	
			
		
			
			$InsAsignacionVentaVehiculo->VmaId = $InsOrdenVentaVehiculo->VmaId;
			$InsAsignacionVentaVehiculo->VmoId = $InsOrdenVentaVehiculo->VmoId;
			$InsAsignacionVentaVehiculo->VveId = $InsOrdenVentaVehiculo->VveId;

			$InsAsignacionVentaVehiculo->EinId = $InsOrdenVentaVehiculo->EinId;
			
			$InsAsignacionVentaVehiculo->EinVIN = $InsOrdenVentaVehiculo->EinVIN;
			$InsAsignacionVentaVehiculo->EinNumeroMotor = $InsOrdenVentaVehiculo->EinNumeroMotor;
			$InsAsignacionVentaVehiculo->EinAnoModelo = (empty($InsOrdenVentaVehiculo->EinAnoModelo)?$InsOrdenVentaVehiculo->OvvAnoModelo:$InsOrdenVentaVehiculo->EinAnoModelo);
			$InsAsignacionVentaVehiculo->EinAnoFabricacion = (empty($InsOrdenVentaVehiculo->EinAnoFabricacion)?$InsOrdenVentaVehiculo->OvvAnoFabricacion:$InsOrdenVentaVehiculo->EinAnoFabricacion);
			$InsAsignacionVentaVehiculo->EinColor =(empty($InsOrdenVentaVehiculo->EinColor)?$InsOrdenVentaVehiculo->OvvColor:$InsOrdenVentaVehiculo->EinColor);
		
			$InsAsignacionVentaVehiculo->OvvPrecio = $InsOrdenVentaVehiculo->OvvPrecio;
			$InsAsignacionVentaVehiculo->OvvDescuento = $InsOrdenVentaVehiculo->OvvDescuento;
			$InsAsignacionVentaVehiculo->OvvDescuentoGerencia = $InsOrdenVentaVehiculo->OvvDescuentoGerencia;
			$InsAsignacionVentaVehiculo->OvvSubTotal = $InsOrdenVentaVehiculo->OvvSubTotal;
			$InsAsignacionVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvImpuesto;
			$InsAsignacionVentaVehiculo->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal;

			
			if($InsAsignacionVentaVehiculo->MonId<>$EmpresaMonedaId ){
				
				$InsAsignacionVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				$InsAsignacionVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsAsignacionVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
			}	


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

			$_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador]->MtdAgregarSesionObjeto(1,
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
	
	
	
			/*$_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			NULL,
			$InsAsignacionVentaVehiculo->CliNombre." ".$InsOrdenVentaVehiculo->CliApellidoPaterno." ".$InsOrdenVentaVehiculo->CliApellidoMaterno,
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

	global $InsAsignacionVentaVehiculo;
	global $Identificador;
	
	unset($_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador]);
		
	$_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();	
	
	
	$InsAsignacionVentaVehiculo->AvvEstado = 3;
	$InsAsignacionVentaVehiculo->MonId = "MON-10001";

	$InsAsignacionVentaVehiculo->AvvNotificar = 1;
	$InsAsignacionVentaVehiculo->AvvEntregarNotificar = 1;
	$InsAsignacionVentaVehiculo->PerId = $_SESSION['SesionPersonal'];
	$InsAsignacionVentaVehiculo->AvvAprobacion = 1;

}

/* <li>01 Juego de Pisos</li> */
?>