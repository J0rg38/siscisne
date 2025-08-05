<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

	$InsFichaIngreso->FinId = $_POST['CmpId'];
	$InsFichaIngreso->CliId = $_POST['CmpClienteId'];
	$InsFichaIngreso->PerId = $_POST['CmpPersonal'];

	$InsFichaIngreso->CamId = $_POST['CmpCampanaId'];
	$InsFichaIngreso->CamNombre = $_POST['CmpCampanaNombre'];
	$InsFichaIngreso->CamCodigo = $_POST['CmpCampanaCodigo'];
	
	$InsFichaIngreso->EinId = $_POST['CmpVehiculoIngresoId'];	
	$InsFichaIngreso->EinVIN = $_POST['CmpVehiculoIngresoVIN'];

	$InsFichaIngreso->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsFichaIngreso->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsFichaIngreso->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsFichaIngreso->VmaId = $_POST['CmpVehiculoIngresoMarcaId'];
	$InsFichaIngreso->VmoId = $_POST['CmpVehiculoIngresoModeloId'];
	$InsFichaIngreso->VveId = $_POST['CmpVehiculoIngresoVersionId'];

	$InsFichaIngreso->EinColor = $_POST['CmpVehiculoIngresoColor'];
	$InsFichaIngreso->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsFichaIngreso->EinAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	
	$InsFichaIngreso->PmaId = $_POST['CmpPlanMantenimiento'];

	$InsFichaIngreso->FinConductor =($_POST['CmpConductor']);
	$InsFichaIngreso->FinTelefono = $_POST['CmpClienteCelular'];
	$InsFichaIngreso->FinDireccion = $_POST['CmpClienteDireccion'];
	$InsFichaIngreso->FinContacto = $_POST['CmpClienteContacto'];
	
	$InsFichaIngreso->FinFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsFichaIngreso->FinFechaEntrega = FncCambiaFechaAMysql($_POST['CmpFechaEntrega'],true);
	$InsFichaIngreso->FinFechaCita = FncCambiaFechaAMysql($_POST['CmpFechaCita'],true);
	
	$InsFichaIngreso->FinHora = ($_POST['CmpHora']);
	$InsFichaIngreso->FinObservacion = addslashes($_POST['CmpObservacion']);
	$InsFichaIngreso->MinId = $_POST['CmpModalidad'];

	$InsFichaIngreso->FinExteriorDelantero1 = $_POST['CmpExteriorDelantero1'];
	$InsFichaIngreso->FinExteriorDelantero2 = $_POST['CmpExteriorDelantero2'];
	$InsFichaIngreso->FinExteriorDelantero3 = $_POST['CmpExteriorDelantero3'];
	$InsFichaIngreso->FinExteriorDelantero4 = $_POST['CmpExteriorDelantero4'];
	$InsFichaIngreso->FinExteriorDelantero5 = $_POST['CmpExteriorDelantero5'];
	$InsFichaIngreso->FinExteriorDelantero6 = $_POST['CmpExteriorDelantero6'];
	$InsFichaIngreso->FinExteriorDelantero7 = $_POST['CmpExteriorDelantero7'];
	
	$InsFichaIngreso->FinExteriorPosterior1 = $_POST['CmpExteriorPosterior1'];
	$InsFichaIngreso->FinExteriorPosterior2 = $_POST['CmpExteriorPosterior2'];
	$InsFichaIngreso->FinExteriorPosterior3 = $_POST['CmpExteriorPosterior3'];
	$InsFichaIngreso->FinExteriorPosterior4 = $_POST['CmpExteriorPosterior4'];
	$InsFichaIngreso->FinExteriorPosterior5 = $_POST['CmpExteriorPosterior5'];
	$InsFichaIngreso->FinExteriorPosterior6 = $_POST['CmpExteriorPosterior6'];
	
	$InsFichaIngreso->FinExteriorDerecho1 = $_POST['CmpExteriorDerecho1'];
	$InsFichaIngreso->FinExteriorDerecho2 = $_POST['CmpExteriorDerecho2'];
	$InsFichaIngreso->FinExteriorDerecho3 = $_POST['CmpExteriorDerecho3'];
	$InsFichaIngreso->FinExteriorDerecho4 = $_POST['CmpExteriorDerecho4'];
	$InsFichaIngreso->FinExteriorDerecho5 = $_POST['CmpExteriorDerecho5'];
	$InsFichaIngreso->FinExteriorDerecho6 = $_POST['CmpExteriorDerecho6'];
	$InsFichaIngreso->FinExteriorDerecho7 = $_POST['CmpExteriorDerecho7'];
	$InsFichaIngreso->FinExteriorDerecho8 = $_POST['CmpExteriorDerecho8'];
	
	$InsFichaIngreso->FinExteriorIzquierdo1 = $_POST['CmpExteriorIzquierdo1'];
	$InsFichaIngreso->FinExteriorIzquierdo2 = $_POST['CmpExteriorIzquierdo2'];
	$InsFichaIngreso->FinExteriorIzquierdo3 = $_POST['CmpExteriorIzquierdo3'];
	$InsFichaIngreso->FinExteriorIzquierdo4 = $_POST['CmpExteriorIzquierdo4'];
	$InsFichaIngreso->FinExteriorIzquierdo5 = $_POST['CmpExteriorIzquierdo5'];
	$InsFichaIngreso->FinExteriorIzquierdo6 = $_POST['CmpExteriorIzquierdo6'];
	$InsFichaIngreso->FinExteriorIzquierdo7 = $_POST['CmpExteriorIzquierdo7'];
	
	
	$InsFichaIngreso->FinInterior1 = $_POST['CmpInterior1'];
	$InsFichaIngreso->FinInterior2 = $_POST['CmpInterior2'];
	$InsFichaIngreso->FinInterior3 = $_POST['CmpInterior3'];
	$InsFichaIngreso->FinInterior4 = $_POST['CmpInterior4'];
	$InsFichaIngreso->FinInterior5 = $_POST['CmpInterior5'];
	$InsFichaIngreso->FinInterior6 = $_POST['CmpInterior6'];
	$InsFichaIngreso->FinInterior7 = $_POST['CmpInterior7'];
	$InsFichaIngreso->FinInterior8 = $_POST['CmpInterior8'];
	$InsFichaIngreso->FinInterior9 = $_POST['CmpInterior9'];
	$InsFichaIngreso->FinInterior10 = $_POST['CmpInterior10'];
	$InsFichaIngreso->FinInterior11 = $_POST['CmpInterior11'];
	$InsFichaIngreso->FinInterior12 = $_POST['CmpInterior12'];
	$InsFichaIngreso->FinInterior13 = $_POST['CmpInterior13'];
	$InsFichaIngreso->FinInterior14 = $_POST['CmpInterior14'];
	$InsFichaIngreso->FinInterior15 = $_POST['CmpInterior15'];
	$InsFichaIngreso->FinInterior16 = $_POST['CmpInterior16'];
	$InsFichaIngreso->FinInterior17 = $_POST['CmpInterior17'];
	$InsFichaIngreso->FinInterior18 = $_POST['CmpInterior18'];
	$InsFichaIngreso->FinInterior19 = $_POST['CmpInterior19'];
	$InsFichaIngreso->FinInterior20 = $_POST['CmpInterior20'];
	$InsFichaIngreso->FinInterior21 = $_POST['CmpInterior21'];
	$InsFichaIngreso->FinInterior22 = $_POST['CmpInterior22'];
	$InsFichaIngreso->FinInterior23 = $_POST['CmpInterior23'];
	$InsFichaIngreso->FinInterior24 = $_POST['CmpInterior24'];
	$InsFichaIngreso->FinInterior25 = $_POST['CmpInterior25'];
	$InsFichaIngreso->FinInterior26 = $_POST['CmpInterior26'];
	$InsFichaIngreso->FinInterior27 = $_POST['CmpInterior27'];	
	
	$InsFichaIngreso->FinInformeTecnicoMantenimiento = $_POST['CmpMantenimiento'];	
	$InsFichaIngreso->FinInformeTecnicoRevision = $_POST['CmpRevision'];	
	$InsFichaIngreso->FinInformeTecnicoDiagnostico = $_POST['CmpDiagnostico'];	
	
	$InsFichaIngreso->FinSalidaFecha = FncCambiaFechaAMysql($_POST['CmpSalidaFecha'],true);
	$InsFichaIngreso->FinSalidaHora = $_POST['CmpSalidaHora'];	
	$InsFichaIngreso->FinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsFichaIngreso->FinSalidaObservacion = $_POST['CmpSalidaObservacion'];	
	
	$InsFichaIngreso->FinVehiculoKilometraje = $_POST['CmpVehiculoKilometraje'];
	$InsFichaIngreso->FinMantenimientoKilometraje = (empty($_POST['CmpMantenimientoKilometraje'])?0:$_POST['CmpMantenimientoKilometraje']);	

	$InsFichaIngreso->FinPrecioEstimado = 0;

	$InsFichaIngreso->FinPrioridad = $_POST['CmpPrioridad'];
	$InsFichaIngreso->FinEstado = $_POST['CmpEstado'];
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinEliminado = 1;

	$InsFichaIngreso->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsFichaIngreso->CliNombre = $_POST['CmpClienteNombre'];
	$InsFichaIngreso->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];

	if($Guardar){
		if($InsFichaIngreso->MtdCorregirFichaIngreso()){		
			$Resultado.='#SAS_FIN_106';
			$Edito = true;
	
			FncCargarDatos();
		} else{
			$Resultado.='#ERR_FIN_106';
			$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
			
		}
	}else{

		$Resultado.='#ERR_FIN_106';
		$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
		
			
	}

}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsFichaIngreso;
	global $EmpresaMonedaId;
	global $ArrModalidadIngresos;

	$InsFichaIngreso = new ClsFichaIngreso();

	$InsFichaIngreso->FinId = $GET_id;
	$InsFichaIngreso->MtdObtenerFichaIngreso();	
	
}
?>