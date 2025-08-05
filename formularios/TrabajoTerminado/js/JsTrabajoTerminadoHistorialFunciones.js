// JavaScript Document

function FncTrabajoTerminadoHistorialListar(){

	var Identificador = $('#Identificador').val();

	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();	

	$('#CapFTrabajoTerminadoHistorialAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoHistorial.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(html){
			$('#CapTrabajoTerminadoHistorialAccion').html('Listo');	
			$("#CapTrabajoTerminadoHistoriales").html("");
			$("#CapTrabajoTerminadoHistoriales").append(html);
		}
	});
	

}

