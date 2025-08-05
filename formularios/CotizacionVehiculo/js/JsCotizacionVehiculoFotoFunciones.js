// JavaScript Document

function FncCotizacionVehiculoFotoNuevo(){
}

function FncCotizacionVehiculoFotoGuardar(){
	
}


function FncCotizacionVehiculoFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapCotizacionVehiculoFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionVehiculo/FrmCotizacionVehiculoFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+CotizacionVehiculoFotoEditar+'&Eliminar='+CotizacionVehiculoFotoEliminar+'&Tipo=',
		success: function(html){
			$('#CapCotizacionVehiculoFotosAccion').html('Listo');	
			$("#CapCotizacionVehiculoFotos").html("");
			$("#CapCotizacionVehiculoFotos").append(html);
		}
	});
	
	

}



function FncCotizacionVehiculoFotoEscoger(oItem){
}

function FncCotizacionVehiculoFotoEliminar(oItem,oTipo){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapCotizacionVehiculoFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapCotizacionVehiculoFotosAccion').html("Eliminado");	
				FncCotizacionVehiculoFotoListar();
			}
		});

		FncCotizacionVehiculoFotoNuevo();

	}
	
}



function FncCotizacionVehiculoFotoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapCotizacionVehiculoFotosAccion').html('Eliminando...');
	
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoFotoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapCotizacionVehiculoFotosAccion').html('Eliminado');	
				FncCotizacionVehiculoFotoListar();
			}
		});	
			
		FncCotizacionVehiculoFotoNuevo();
	}
	
}
