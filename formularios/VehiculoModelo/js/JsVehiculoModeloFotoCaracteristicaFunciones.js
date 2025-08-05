// JavaScript Document

function FncVehiculoModeloFotoCaracteristicaNuevo(){
}

function FncVehiculoModeloFotoCaracteristicaGuardar(){
	
}


function FncVehiculoModeloFotoCaracteristicaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoModeloFotoCaracteristicasAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoModelo/FrmVehiculoModeloFotoCaracteristicaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoModeloFotoCaracteristicaEditar+'&Eliminar='+VehiculoModeloFotoCaracteristicaEliminar,
		success: function(html){
			$('#CapVehiculoModeloFotoCaracteristicasAccion').html('Listo');	
			$("#CapVehiculoModeloFotoCaracteristicas").html("");
			$("#CapVehiculoModeloFotoCaracteristicas").append(html);
		}
	});
	
	

}



function FncVehiculoModeloFotoCaracteristicaEscoger(oItem){
}

function FncVehiculoModeloFotoCaracteristicaEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoModeloFotoCaracteristicasAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoModelo/acc/AccVehiculoModeloFotoCaracteristicaEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoModeloFotoCaracteristicasAccion').html("Eliminado");	
				FncVehiculoModeloFotoCaracteristicaListar();
			}
		});

		FncVehiculoModeloFotoCaracteristicaNuevo();

	}
	
}

function FncVehiculoModeloFotoCaracteristicaEliminarTodo(){

	
}
