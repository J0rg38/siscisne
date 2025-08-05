    // JavaScript Document




function FncFichaIngresoHistorialListar(){

	var Identificador = $('#Identificador').val();

	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();	

	$('#CapFichaIngresoHistorialAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/FrmFichaIngresoHistorial.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(html){
			$('#CapFichaIngresoHistorialAccion').html('Listo');	
			$("#CapFichaIngresoHistoriales").html("");
			$("#CapFichaIngresoHistoriales").append(html);
		}
	});
	
	


}


