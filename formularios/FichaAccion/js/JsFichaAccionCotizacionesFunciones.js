// JavaScript Document

function FncFichaAccionCotizacionesListar(){

	var VehiculoIngresoVIN = $("#CmpFichaIngresoVIN").val();
	var VehiculoIngresoId = $("#CmpFichaIngresoId").val();	

	$('#CapFichaAccionCotizacionesAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionCotizaciones.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(html){
			$('#CapFichaAccionCotizacionesAccion').html('Listo');	
			$("#CapFichaAccionCotizaciones").html("");
			$("#CapFichaAccionCotizaciones").append(html);
		}
	});
	
}