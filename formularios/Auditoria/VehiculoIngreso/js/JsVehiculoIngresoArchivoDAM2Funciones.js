// JavaScript Document

function FncVehiculoIngresoArchivoDAM2Nuevo(){
}

function FncVehiculoIngresoArchivoDAM2Guardar(){
}

function FncVehiculoIngresoArchivoDAM2Listar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoIngresoArchivoDAM2sAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/FrmVehiculoIngresoArchivoDAM2Listado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoIngresoArchivoDAM2Editar+'&Eliminar='+VehiculoIngresoArchivoDAM2Eliminar,
		success: function(html){
			$('#CapVehiculoIngresoArchivoDAM2sAccion').html('Listo');	
			$("#CapVehiculoIngresoArchivoDAM2s").html("");
			$("#CapVehiculoIngresoArchivoDAM2s").append(html);
		}
	});

}



function FncVehiculoIngresoArchivoDAM2Escoger(oItem){
}

function FncVehiculoIngresoArchivoDAM2Eliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){

		$('#CapVehiculoIngresoArchivoDAM2sAccion').html('Eliminando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoArchivoDAM2Eliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVehiculoIngresoArchivoDAM2sAccion').html("Eliminado");	
				FncVehiculoIngresoArchivoDAM2Listar();
			}
		});

		FncVehiculoIngresoArchivoDAM2Nuevo();

	}
	
}
