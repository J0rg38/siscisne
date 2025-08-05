// JavaScript Document

$().ready(function() {	

});	
	
function FncPreEntregaNuevo(){
	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
}

function FncPreEntregaNuevoFuncion(){
	
}

function FncPreEntregaVerificar(){

	var VehiculoIngresoVIN = $('#CmpVehiculoIngresoVIN').val();
	
	if(VehiculoIngresoVIN!=""){
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/FichaIngreso/acc/AccPreEntregaVerificar.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN,
		success: function(InsPreEntrega){
				if(InsPreEntrega.FinId!=null){					

					FncPreEntregaEscoger(InsPreEntrega.FinId);

				}
			}
		});	

	}


}


function FncPreEntregaEscoger(oFichaIngresoId){

	$('#CmpPreEntregaId').val(oFichaIngresoId);

	FncPreEntregaFuncion();

}

function FncPreEntregaFuncion(){
	
}

/*
* Funciones PopUp Formulario
*/

/*
* Funciones PopUp Listado
*/
