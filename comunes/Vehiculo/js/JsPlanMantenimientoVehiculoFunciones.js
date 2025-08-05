// JavaScript Document

$().ready(function() {	

});	
	
function FncPlanMantenimientoVehiculoNuevo(){
	
	$('#CmpPlanMantenimientoId').val("");
	$('#CmpPlanMantenimientoNombre').val("");	

	/*
	* POPUP REGISTRAR/EDITAR
	*/	
}

function FncPlanMantenimientoVehiculoNuevoFuncion(){
	
}

function FncPlanMantenimientoVehiculoVerificar(){

	var VehiculoModeloId = $('#CmpVehiculoModeloId').val();

	if(VehiculoModeloId==""){

	}else{
	
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Vehiculo/acc/AccPlanMantenimientoVehiculoVerificar.php',
		data: 'VehiculoModeloId='+VehiculoModeloId,
		success: function(InsPlanMantenimiento){
			
				if(InsPlanMantenimiento.PmaId!=null){					

					FncPlanMantenimientoVehiculoEscoger(InsPlanMantenimiento.PmaId,InsPlanMantenimiento.PmaNombre);

				}else{
					
					FncPlanMantenimientoVehiculoFuncion();
					
				}

			}
		});	
	}

}


function FncPlanMantenimientoVehiculoEscoger(oPlanMantenimientoId,oPlanMantenimientoNombre){

	$('#CmpPlanMantenimientoId').val(oPlanMantenimientoId);
	$('#CmpPlanMantenimientoNombre').val(oPlanMantenimientoNombre);

	FncPlanMantenimientoVehiculoFuncion();

}

function FncPlanMantenimientoVehiculoFuncion(){
	
}

/*
* Funciones PopUp Formulario
*/

/*
* Funciones PopUp Listado
*/
