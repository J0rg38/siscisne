// JavaScript Document

function FncVehiculoIngresoFotoNuevo(){
}

function FncVehiculoIngresoFotoGuardar(){
}


function FncVehiculoIngresoFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoIngresoFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/FrmVehiculoIngresoFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoIngresoFotoEditar+'&Eliminar='+VehiculoIngresoFotoEliminar,
		success: function(html){
			$('#CapVehiculoIngresoFotosAccion').html('Listo');	
			$("#CapVehiculoIngresoFotos").html("");
			$("#CapVehiculoIngresoFotos").append(html);
		}
	});
	
	

}



function FncVehiculoIngresoFotoEscoger(oItem){
}

function FncVehiculoIngresoFotoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoIngresoFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoSimpleFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVehiculoIngresoFotosAccion').html("Eliminado");	
				FncVehiculoIngresoFotoListar();
			}
		});

		FncVehiculoIngresoFotoNuevo();

	}
	
}



function FncVehiculoIngresoFotoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapVehiculoIngresoFotosAccion').html('Eliminando...');
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoSimpleFotoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoIngresoFotosAccion').html('Eliminado');	
				FncVehiculoIngresoFotoListar();
			}
		});	
			
		FncVehiculoIngresoFotoNuevo();
	}
	
}
