// JavaScript Document

function FncVehiculoIngresoArchivoDAMNuevo(){
}

function FncVehiculoIngresoArchivoDAMGuardar(){
}


function FncVehiculoIngresoArchivoDAMListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoIngresoArchivoDAMsAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/FrmVehiculoIngresoArchivoDAMListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoIngresoArchivoDAMEditar+'&Eliminar='+VehiculoIngresoArchivoDAMEliminar,
		success: function(html){
			$('#CapVehiculoIngresoArchivoDAMsAccion').html('Listo');	
			$("#CapVehiculoIngresoArchivoDAMs").html("");
			$("#CapVehiculoIngresoArchivoDAMs").append(html);
		}
	});
	
	

}



function FncVehiculoIngresoArchivoDAMEscoger(oItem){
}

function FncVehiculoIngresoArchivoDAMEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoIngresoArchivoDAMsAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoArchivoDAMEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVehiculoIngresoArchivoDAMsAccion').html("Eliminado");	
				FncVehiculoIngresoArchivoDAMListar();
			}
		});

		FncVehiculoIngresoArchivoDAMNuevo();

	}
	
}
