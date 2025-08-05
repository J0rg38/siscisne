// JavaScript Document

var VehiculoIngresoColorCampo = "CmpVehiculoColor";
/*
Configuracion Autocompletar
*/
$().ready(function() {

	
		
});

function FncVehiculoColorAutocompletarCargar(){
	
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var VehiculoModelo = $("#CmpVehiculoModelo").val();
	var VehiculoVersion = $("#CmpVehiculoVersion").val();
	
	function VehiculoColorFormato(row) {
		return row[0];
	}
	
	$("#"+VehiculoIngresoColorCampo).unautocomplete();
	$("#"+VehiculoIngresoColorCampo).autocomplete("comunes/Vehiculo/XmlVehiculoColor.php?Campo=EinColor&VehiculoMarca="+VehiculoMarca+"&VehiculoModelo="+VehiculoModelo+"&VehiculoVersion="+VehiculoVersion, {
		width: 150,
		//max:20,
		selectFirst: true,
		scroll: true,
		formatItem: VehiculoColorFormato
	});	
	
	$("#"+VehiculoIngresoColorCampo).result(function(event, data, formatted) {
		if (data){
			

		}		
	});
	
}

$(function(){
	FncVehiculoColorAutocompletarCargar();
});