    // JavaScript Document




function FncFichaIngresoCotizacionesListar(){

	var Identificador = $('#Identificador').val();

	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();	

	$('#CapFichaIngresoCotizacionesAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/FrmFichaIngresoCotizaciones.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(html){
			$('#CapFichaIngresoCotizacionesAccion').html('Listo');	
			$("#CapFichaIngresoCotizaciones").html("");
			$("#CapFichaIngresoCotizaciones").append(html);
		}
	});
	
	


}


