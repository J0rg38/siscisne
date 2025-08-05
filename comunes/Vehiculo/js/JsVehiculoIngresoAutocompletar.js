// JavaScript Document

/*
Configuracion Autocompletar
*/
$().ready(function() {

	function VehiculoIngresoFormatoVIN(row) {
		return row[0];
	}
	
	function VehiculoIngresoFormatoPlaca(row) {
		return row[2];
	}
		
	$("#CmpVehiculoIngresoVIN").autocomplete("comunes/Vehiculo/XmlVehiculoIngreso.php?Campo=EinVIN", {
		width: 150,
		max:20,
		selectFirst: true,
		formatItem: VehiculoIngresoFormatoVIN
	});	
	
	$("#CmpVehiculoIngresoVIN").result(function(event, data, formatted) {
		if (data){
			
			$("#CmpVehiculoIngresoId").val(data[1]);
			FncVehiculoIngresoBuscar("Id");

		}		
	});
	
	
	
	
	$("#CmpVehiculoIngresoPlaca").autocomplete("comunes/Vehiculo/XmlVehiculoIngreso.php?Campo=EinPlaca", {
		width: 150,
		max:20,
		selectFirst: true,
		formatItem: VehiculoIngresoFormatoPlaca
	});	
	
	$("#CmpVehiculoIngresoPlaca").result(function(event, data, formatted) {
		if (data){

			$("#CmpVehiculoIngresoId").val(data[1]);
			FncVehiculoIngresoBuscar("Id");

		}		
	});
		
});