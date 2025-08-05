// JavaScript Document


function FncGuardar(){

//HACK
	
		$('#CmpMantenimientoKilometraje').removeAttr('disabled');				
}


$().ready(function() {
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			FncFichaIngresoModalidadesEstablecer($(this).attr('sigla'));
		}			 
	});
	
	FncFichaIngresoMantenimientoKilometrajeEstablecer();
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			$("#CmpModalidadIngresoId_"+$(this).attr('sigla')).change(function(){
				if($(this).attr('sigla')=="MA"){
					

					FncFichaIngresoMantenimientoKilometrajeEstablecer();
					FncFichaIngresoModalidadesEstablecer($(this).attr('sigla'));
										
				}
			});
		}			 
	});

});

function FncFichaIngresoModalidadesEstablecer(oModalidadIngresoSigla){
	
//	alert(oModalidadIngresoSigla);
	if($("#CmpModalidadIngresoId_"+oModalidadIngresoSigla).is(':checked')){

		if(oModalidadIngresoSigla=="MA"){
			$('#CmpMantenimientoKilometraje').removeAttr('disabled');				
		}

	}else{
		
		if(oModalidadIngresoSigla=="MA"){
			$('#CmpMantenimientoKilometraje').attr('disabled', true);			
			$('#CmpMantenimientoKilometraje').val("");
		}

	}

}
	
function FncFichaIngresoMantenimientoKilometrajeEstablecer(){
	
	var VehiculoMarcaId = $('#CmpVehiculoIngresoMarcaId').val();
	var PlanMantenimientoKilometraje = $('#CmpMantenimientoKilometrajeAux').val();

	$.getJSON("comunes/Vehiculo/JnPlanMantenimientoKilometraje.php?VehiculoMarcaId="+VehiculoMarcaId,{}, function(j){

		var options = '';
		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {

			if(PlanMantenimientoKilometraje == j[i].PmkKilometraje){
				options += '<option value="' + j[i].PmkKilometraje + '" selected="selected">' + j[i].PmkEtiqueta+ ' km</option>';				
			}else{
				options += '<option value="' + j[i].PmkKilometraje + '" >' + j[i].PmkEtiqueta+ ' km</option>';				
			}

		}

		$('select#CmpMantenimientoKilometraje').html(options);
		
	})
	
}