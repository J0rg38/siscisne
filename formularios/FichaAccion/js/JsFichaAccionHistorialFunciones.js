// JavaScript Document




function FncFichaAccionHistorialListar(){

	var VehiculoIngresoVIN = $("#CmpFichaIngresoVIN").val();
	var VehiculoIngresoId = $("#CmpFichaIngresoId").val();	

	$('#CapFichaAccionHistorialAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionHistorial.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(html){
			$('#CapFichaAccionHistorialAccion').html('Listo');	
			$("#CapFichaAccionHistoriales").html("");
			$("#CapFichaAccionHistoriales").append(html);
		}
	});
	
	


}


