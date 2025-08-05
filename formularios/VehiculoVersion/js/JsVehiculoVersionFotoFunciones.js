// JavaScript Document

function FncVehiculoVersionFotoNuevo(){
}

function FncVehiculoVersionFotoGuardar(){
	
}


function FncVehiculoVersionFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoVersionFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoVersion/FrmVehiculoVersionFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoVersionFotoEditar+'&Eliminar='+VehiculoVersionFotoEliminar,
		success: function(html){
			$('#CapVehiculoVersionFotosAccion').html('Listo');	
			$("#CapVehiculoVersionFotos").html("");
			$("#CapVehiculoVersionFotos").append(html);
		}
	});
	
	

}



function FncVehiculoVersionFotoEscoger(oItem){
}

function FncVehiculoVersionFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoVersionFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoVersion/acc/AccVehiculoVersionFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoVersionFotosAccion').html("Eliminado");	
				FncVehiculoVersionFotoListar();
			}
		});

		FncVehiculoVersionFotoNuevo();

	}
	
}

function FncVehiculoVersionFotoEliminarTodo(){

	
}
