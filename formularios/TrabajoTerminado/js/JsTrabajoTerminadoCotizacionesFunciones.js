// JavaScript Document

function FncTrabajoTerminadoCotizacionesListar(){

	var Identificador = $('#Identificador').val();

	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();	

	$('#CapTrabajoTerminadoCotizacionesAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoCotizaciones.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(html){
			$('#CapTrabajoTerminadoCotizacionesAccion').html('Listo');	
			$("#CapTrabajoTerminadoCotizacioneses").html("");
			$("#CapTrabajoTerminadoCotizacioneses").append(html);
		}
	});
	

}

