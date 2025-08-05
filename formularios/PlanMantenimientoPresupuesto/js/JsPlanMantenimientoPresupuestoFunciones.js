// JavaScript Document

/*
*** EVENTOS
*/

$().ready(function() {

/*
* EVENTOS - INICIALES
*/
	$("select#CmpVehiculoMarca").change(function(){
		
		FncVehiculoModelosCargar();
		
		FncFichaIngresoMantenimientoKilometrajeEstablecer();
	});


});














function FncFichaIngresoMantenimientoKilometrajeEstablecer(){
	
	var VehiculoMarcaId = $('#CmpVehiculoMarca').val();

	$.getJSON("comunes/Vehiculo/JnPlanMantenimientoKilometraje.php?VehiculoMarcaId="+VehiculoMarcaId,{}, function(j){

		var options = '';
		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {

			options += '<option value="' + j[i].PmkEquivalente + '" >' + j[i].PmkEtiqueta+ ' km</option>';				

		}

		$('select#CmpMantenimientoKilometraje').html(options);
		
	})
	
}