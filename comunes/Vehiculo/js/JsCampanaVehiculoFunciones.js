// JavaScript Document

$().ready(function() {	

});	
	
function FncCampanaVehiculoNuevo(){
	
	$('#CmpCampanaId').val("");
	$('#CmpCampanaNombre').val("");	
	$('#CmpCampanaCodigo').val("");	
	$("#CmpCampanaFecha").val("");
 
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
}

function FncCampanaVehiculoNuevoFuncion(){
	
}

function FncCampanaVehiculoVerificar(){

	var VehiculoIngresoVIN = $('#CmpVehiculoIngresoVIN').val();
	var Fecha = $('#CmpFecha').val();
	
	if(VehiculoIngresoVIN==""){
		
	}else{
		
		$('.error').text("Buscando campaña...").fadeIn(400).delay(2000).fadeOut(400);
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Vehiculo/acc/AccCampanaVehiculoVerificar.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&Fecha='+Fecha,
		success: function(InsCampana){
				if(InsCampana.CamId!=null){					

					FncCampanaVehiculoEscoger(InsCampana.CamId,InsCampana.CamNombre,InsCampana.CamFechaInicio,InsCampana.CamCodigo);

				}else{
					$('.error').text("No se encontraron campañas...").fadeIn(400).delay(2000).fadeOut(400);	
				}
			}
		});	
		
	}

}


function FncCampanaVehiculoEscoger(oCampanaId,oCampanaNombre,oCampanaFechaInicio,oCampanaCodigo){

	$('#CmpCampanaId').val(oCampanaId);
	$('#CmpCampanaNombre').val(oCampanaNombre);
	$("#CmpCampanaFecha").val(oCampanaFechaInicio);
	$("#CmpCampanaCodigo").val(oCampanaCodigo);

	FncCampanaVehiculoFuncion();

}

function FncCampanaVehiculoFuncion(){
	
}

/*
* Funciones PopUp Formulario
*/

/*
* Funciones PopUp Listado
*/
