// JavaScript Document




function FncFichaIngresoMantenimientoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	var VehiculoModelo = $("#CmpVehiculoIngresoModeloId").val();
	var VehiculoVersion = $("#CmpVehiculoIngresoVersionId").val();	

	var VehiculoKilometraje = $("#CmpVehiculoKilometraje").val();
	var MantenimientoKilometraje = $("#CmpMantenimientoKilometraje").val();
	var PlanMantenimientoId = $("#CmpPlanMantenimientoId").val();
	
	$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/FrmFichaIngresoMantenimientoListado.php',
//		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaIngresoMantenimientoEditar+'&Eliminar='+FichaIngresoMantenimientoEliminar,
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&VehiculoKilometraje='+VehiculoKilometraje+'&MantenimientoKilometraje='+MantenimientoKilometraje+'&PlanMantenimientoId='+PlanMantenimientoId+'&Editar='+FichaIngresoMantenimientoEditar+'&Eliminar='+FichaIngresoMantenimientoEliminar,
		success: function(html){
			
			$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Listo');	
			$("#CapFichaIngreso"+oModalidadIngreso+"Mantenimientos").html("");
			$("#CapFichaIngreso"+oModalidadIngreso+"Mantenimientos").append(html);
			
		}
	});
	
	


}


