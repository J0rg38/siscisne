// JavaScript Document

function FncCotizacionVehiculoFotoSoloNuevo(){
}

function FncCotizacionVehiculoFotoSoloGuardar(){
	
}


function FncCotizacionVehiculoFotoSoloListar(){

	var Identificador = $('#Identificador').val();

	$('#CapCotizacionVehiculoFotoSolosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionVehiculo/FrmCotizacionVehiculoFotoSoloListado.php',
		data: 'Identificador='+Identificador+'&Editar='+CotizacionVehiculoFotoSoloEditar+'&Eliminar='+CotizacionVehiculoFotoSoloEliminar,
		success: function(html){
			$('#CapCotizacionVehiculoFotoSolosAccion').html('Listo');	
			$("#CapCotizacionVehiculoFotoSolos").html("");
			$("#CapCotizacionVehiculoFotoSolos").append(html);
		}
	});
	
	

}



function FncCotizacionVehiculoFotoSoloEscoger(oItem){
}

function FncCotizacionVehiculoFotoSoloEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapCotizacionVehiculoFotoSolosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoFotoSoloEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapCotizacionVehiculoFotoSolosAccion').html("Eliminado");	
				FncCotizacionVehiculoFotoSoloListar();
			}
		});

		FncCotizacionVehiculoFotoSoloNuevo();

	}
	
}

function FncCotizacionVehiculoFotoSoloEliminarTodo(){

	
}
