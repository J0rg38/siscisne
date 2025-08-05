// JavaScript Document

function FncVehiculoIngresoArchivoDAM3Nuevo(){
}

function FncVehiculoIngresoArchivoDAM3Guardar(){
}


function FncVehiculoIngresoArchivoDAM3Listar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoIngresoArchivoDAM3sAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/FrmVehiculoIngresoArchivoDAM3Listado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoIngresoArchivoDAM3Editar+'&Eliminar='+VehiculoIngresoArchivoDAM3Eliminar,
		success: function(html){
			$('#CapVehiculoIngresoArchivoDAM3sAccion').html('Listo');	
			$("#CapVehiculoIngresoArchivoDAM3s").html("");
			$("#CapVehiculoIngresoArchivoDAM3s").append(html);
		}
	});
	
	

}



function FncVehiculoIngresoArchivoDAM3Escoger(oItem){
}

function FncVehiculoIngresoArchivoDAM3Eliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoIngresoArchivoDAM3sAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoArchivoDAM3Eliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVehiculoIngresoArchivoDAM3sAccion').html("Eliminado");	
				FncVehiculoIngresoArchivoDAM3Listar();
			}
		});

		FncVehiculoIngresoArchivoDAM3Nuevo();

	}
	
}
