<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsEntregaVentaVehiculo->UsuId = $_SESSION['SesionId'];	
	
	$InsEntregaVentaVehiculo->EvvId = $_POST['CmpId'];	
	$InsEntregaVentaVehiculo->PerId = $_POST['CmpPersonal'];		
	$InsEntregaVentaVehiculo->EvvFechaProgramada = FncCambiaFechaAMysql($_POST['CmpFechaProgramada']);
	$InsEntregaVentaVehiculo->EvvHoraProgramada = ($_POST['CmpHoraProgramada']);
	$InsEntregaVentaVehiculo->EvvFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsEntregaVentaVehiculo->EvvDuracion = $_POST['CmpDuracion'];		
		
	list($InsEntregaVentaVehiculo->EvvAno,$InsEntregaVentaVehiculo->EvvMes,$aux) = explode("-",$InsEntregaVentaVehiculo->EvvFecha);
	
	$InsEntregaVentaVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
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
	$InsEntregaVentaVehiculo->EinColor = $_POST['CmpVehiculoIngresoColor'];
	
	$InsEntregaVentaVehiculo->EvvObservacion = addslashes($_POST['CmpObservacion']);

	$InsEntregaVentaVehiculo->EvvAprobacion = 3;	
	$InsEntregaVentaVehiculo->EvvInmediata =  $_POST['CmpInmediata'];
	
	$InsEntregaVentaVehiculo->EvvEstado = $_POST['CmpEstado'];	
	$InsEntregaVentaVehiculo->EvvTiempoCreacion = date("Y-m-d H:i:s");
	$InsEntregaVentaVehiculo->EvvTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsEntregaVentaVehiculo->PerIdVendedor = $_POST['CmpPersonalVendedor'];	
	
	$InsEntregaVentaVehiculo->EvvNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	
	
	
	$InsEntregaVentaVehiculo->EntregaVentaVehiculoObsequio = array();
	$InsEntregaVentaVehiculo->EntregaVentaVehiculoCondicionVenta = array();

	if(empty($InsEntregaVentaVehiculo->EinId)){
			$Guardar = false;
			$Resultado.='#ERR_EVV_201';
	}
	
	if(FncRestarFechas(date("Y-m-d"),($InsEntregaVentaVehiculo->EvvFechaProgramada))<2 and ($InsEntregaVentaVehiculo->EvvInmediata == 2 or $InsEntregaVentaVehiculo->EvvInmediata == "")){
		$Guardar = false;
		$Resultado.='#ERR_EVV_202';
	}
	
	if($Guardar){
		
		if($InsEntregaVentaVehiculo->MtdRegistrarEntregaVentaVehiculo()){

			//if(!empty($InsEntregaVentaVehiculo->EinId)){
//				
//				if($InsEntregaVentaVehiculo->EvvEstado == 3){
//					
//					$InsVehiculoIngreso = new ClsVehiculoIngreso();
//					$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","ENTREGADO",$InsEntregaVentaVehiculo->EinId);
//					
//				
//				}
//				
//			}
//		

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
			
			if(!empty($GET_dia)){
			?>
	<script type="text/javascript">
		
			self.parent.tb_remove();
			
	
	</script>
	<?php
			}
	
			$Registro = true;

			unset($InsEntregaVentaVehiculo);
			$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();
			FncNuevo();
			$Resultado.='#SAS_EVV_101';

		} else{
			
			$InsEntregaVentaVehiculo->EvvFecha = FncCambiaFechaANormal($InsEntregaVentaVehiculo->EvvFecha);
			
			$Resultado.='#ERR_EVV_101';
		}
	
	}else{


		$InsEntregaVentaVehiculo->EvvFecha = FncCambiaFechaANormal($InsEntregaVentaVehiculo->EvvFecha);
		
	}


}else{

	FncNuevo();

	switch($GET_Origen){

	
		case "OrdenVentaVehiculo":
			
			$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
			$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;
			$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
			
			$InsEntregaVentaVehiculo->PerIdVendedor = $InsOrdenVentaVehiculo->PerId;
			$InsEntregaVentaVehiculo->OvvId = $InsOrdenVentaVehiculo->OvvId;
			
			$InsEntregaVentaVehiculo->CliId = $InsOrdenVentaVehiculo->CliId;
			$InsEntregaVentaVehiculo->TdoId = $InsOrdenVentaVehiculo->TdoId;
			$InsEntregaVentaVehiculo->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
			$InsEntregaVentaVehiculo->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
			$InsEntregaVentaVehiculo->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;
			$InsEntregaVentaVehiculo->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
						
			$InsEntregaVentaVehiculo->CliTelefono = $InsOrdenVentaVehiculo->CliTelefono;
			$InsEntregaVentaVehiculo->CliCelular = $InsOrdenVentaVehiculo->CliCelular;
			$InsEntregaVentaVehiculo->CliEmail = $InsOrdenVentaVehiculo->CliEmail;

			$InsEntregaVentaVehiculo->TdoNombre = $InsOrdenVentaVehiculo->TdoNombre;


			$InsEntregaVentaVehiculo->MonId = $InsOrdenVentaVehiculo->MonId;
			$InsEntregaVentaVehiculo->OvvTipoCambio = $InsOrdenVentaVehiculo->OvvTipoCambio;
			
			$InsEntregaVentaVehiculo->OvvPorcentajeImpuestoVenta = $InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta;
			
			$InsEntregaVentaVehiculo->OvvFecha = $InsOrdenVentaVehiculo->OvvFecha;
			$InsEntregaVentaVehiculo->OvvFechaEntrega = $InsOrdenVentaVehiculo->OvvFechaEntrega;

			$InsEntregaVentaVehiculo->EvvInmediata = (empty($InsOrdenVentaVehiculo->OvvInmediata)?2:$InsOrdenVentaVehiculo->OvvInmediata);
			$InsEntregaVentaVehiculo->EvvEstado = 1;	
			$InsEntregaVentaVehiculo->EvvTiempoCreacion = date("Y-m-d H:i:s");
			$InsEntregaVentaVehiculo->EvvTiempoModificacion = date("Y-m-d H:i:s");
	
			
		
			
			$InsEntregaVentaVehiculo->VmaId = $InsOrdenVentaVehiculo->VmaId;
			$InsEntregaVentaVehiculo->VmoId = $InsOrdenVentaVehiculo->VmoId;
			$InsEntregaVentaVehiculo->VveId = $InsOrdenVentaVehiculo->VveId;

			$InsEntregaVentaVehiculo->EinId = $InsOrdenVentaVehiculo->EinId;
			
			$InsEntregaVentaVehiculo->EinVIN = $InsOrdenVentaVehiculo->EinVIN;
			$InsEntregaVentaVehiculo->EinNumeroMotor = $InsOrdenVentaVehiculo->EinNumeroMotor;
			$InsEntregaVentaVehiculo->EinAnoModelo = $InsOrdenVentaVehiculo->EinAnoModelo;
			$InsEntregaVentaVehiculo->EinAnoFabricacion = $InsOrdenVentaVehiculo->EinAnoFabricacion;
			$InsEntregaVentaVehiculo->EinColor = $InsOrdenVentaVehiculo->EinColor;

			$InsEntregaVentaVehiculo->OvvPrecio = $InsOrdenVentaVehiculo->OvvPrecio;
			$InsEntregaVentaVehiculo->OvvDescuento = $InsOrdenVentaVehiculo->OvvDescuento;
			$InsEntregaVentaVehiculo->OvvDescuentoGerencia = $InsOrdenVentaVehiculo->OvvDescuentoGerencia;
			$InsEntregaVentaVehiculo->OvvSubTotal = $InsOrdenVentaVehiculo->OvvSubTotal;
			$InsEntregaVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvImpuesto;
			$InsEntregaVentaVehiculo->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal;

			
			if($InsEntregaVentaVehiculo->MonId<>$EmpresaMonedaId ){
				
				$InsEntregaVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsEntregaVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsEntregaVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				$InsEntregaVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsEntregaVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsEntregaVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
			}	

			
			
			$Obsequios = "";
			
			
			if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){	
				foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio ){
					 
					$Obsequios .= "- ". $DatOrdenVentaVehiculoObsequio->ObsNombre." ";		
					  			
				}
			}
			
			if($InsOrdenVentaVehiculo->OvvGLP=="Si"){
				$Obsequios .= "Instalacion de GLP /Modelo de Tanque: ".$InsOrdenVentaVehiculo->OvvGLPModeloTanque;		
			}
			
			
			$InsEntregaVentaVehiculo->EvvObservacion = $Obsequios;
			
						
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
			NULL,
			NULL,
			$InsEntregaVentaVehiculo->CliNombre." ".$InsOrdenVentaVehiculo->CliApellidoPaterno." ".$InsOrdenVentaVehiculo->CliApellidoMaterno,
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
			);
			
		break;
		
			
	}
	
}

function FncNuevo(){

	global $InsEntregaVentaVehiculo;
	global $Identificador;
	
	unset($_SESSION['InsEntregaVentaVehiculoPropietario'.$Identificador]);
		
	$_SESSION['InsEntregaVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();	
	
	
	$InsEntregaVentaVehiculo->EvvEstado = 1;
	$InsEntregaVentaVehiculo->MonId = "MON-10001";

	$InsEntregaVentaVehiculo->EvvNotificar = 1;
	$InsEntregaVentaVehiculo->EvvEntregarNotificar = 1;
	$InsEntregaVentaVehiculo->PerId = $_SESSION['SesionPersonal'];
	

	$fecha = date('Y-m-j');
	$nuevafecha = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'd/m/Y' , $nuevafecha );
	
	$InsEntregaVentaVehiculo->EvvFechaProgramada = $nuevafecha;
	$InsEntregaVentaVehiculo->EvvInmediata = 2;
}

/* <li>01 Juego de Pisos</li> */
?>