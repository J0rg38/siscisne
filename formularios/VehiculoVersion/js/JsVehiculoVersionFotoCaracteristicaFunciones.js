// JavaScript Document

function FncVehiculoVersionFotoCaracteristicaNuevo(){
}

function FncVehiculoVersionFotoCaracteristicaGuardar(){
	
}


function FncVehiculoVersionFotoCaracteristicaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoVersionFotoCaracteristicasAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoVersion/FrmVehiculoVersionFotoCaracteristicaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoVersionFotoCaracteristicaEditar+'&Eliminar='+VehiculoVersionFotoCaracteristicaEliminar,
		success: function(html){
			$('#CapVehiculoVersionFotoCaracteristicasAccion').html('Listo');	
			$("#CapVehiculoVersionFotoCaracteristicas").html("");
			$("#CapVehiculoVersionFotoCaracteristicas").append(html);
		}
	});
	
	

}



function FncVehiculoVersionFotoCaracteristicaEscoger(oItem){
}

function FncVehiculoVersionFotoCaracteristicaEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoVersionFotoCaracteristicasAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoVersion/acc/AccVehiculoVersionFotoCaracteristicaEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoVersionFotoCaracteristicasAccion').html("Eliminado");	
				FncVehiculoVersionFotoCaracteristicaListar();
			}
		});

		FncVehiculoVersionFotoCaracteristicaNuevo();

	}
	
}

function FncVehiculoVersionFotoCaracteristicaEliminarTodo(){

	
}
