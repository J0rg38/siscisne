<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';
	
	$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

	$InsFichaIngreso->FinId = $_POST['CmpFichaIngresoId'];
	$InsFichaIngreso->CliNombre = $_POST['CmpFichaIngresoCliente'];
	$InsFichaIngreso->EinVIN = $_POST['CmpFichaIngresoVIN'];
	$InsFichaIngreso->EinPlaca = $_POST['CmpFichaIngresoPlaca'];
	$InsFichaIngreso->FinFecha = $_POST['CmpFecha'];
	$InsFichaIngreso->VveId = $_POST['CmpFichaIngresoVehiculoVersion'];
	$InsFichaIngreso->FinMantenimientoKilometraje = $_POST['CmpFichaIngresoMantenimientoKilometraje'];
	$InsFichaIngreso->FinEstado = $_POST['CmpFichaIngresoEstado'];
	
	$InsFichaIngreso->VmaNomvre =($_POST['CmpFichaIngresoMarca']);
	$InsFichaIngreso->VmoNombre =($_POST['CmpFichaIngresoModelo']);
	$InsFichaIngreso->VveNombre =($_POST['CmpFichaIngresoVersion']);
	
	$InsFichaIngreso->FinSalidaObservacion = addslashes($_POST['CmpObservacionSalida']);
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");

	
	$InsFichaIngreso->PerId = $_POST['CmpPersonal'];
	$InsFichaIngreso->PerIdAnterior = $_POST['CmpPersonalAnterior'];
	
	if($InsFichaIngreso->FinEstado<>11 and $InsFichaIngreso->FinEstado<>2){
		$Guardar = false;
		$Resultado.='#ERR_FIN_608';
	}
	
	if($Guardar){
		if($InsFichaIngreso->MtdEditarFichaIngresoTecnico()){		
			$Resultado.='#SAS_FIN_103';
			$Edito = true;
			FncCargarDatos();
		} else{
			$Resultado.='#ERR_FIN_103';
			$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
		}
	}else{

		$Resultado.='#ERR_FIN_103';
		$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
	}

}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsFichaIngreso;

	$InsFichaIngreso = new ClsFichaIngreso();
		
	$InsFichaIngreso->FinId = $GET_id;
	$InsFichaIngreso->MtdObtenerFichaIngreso(false);	
	$InsFichaIngreso->PerIdAnterior = $InsFichaIngreso->PerId;
//	$InsFichaIngreso->PerId = $InsFichaIngreso->PerId;
}
?>