// JavaScript Document

function FncVehiculoVersionFotoPosteriorNuevo(){
}

function FncVehiculoVersionFotoPosteriorGuardar(){
	
}


function FncVehiculoVersionFotoPosteriorListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoVersionFotoPosteriorsAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoVersion/FrmVehiculoVersionFotoPosteriorListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoVersionFotoPosteriorEditar+'&Eliminar='+VehiculoVersionFotoPosteriorEliminar,
		success: function(html){
			$('#CapVehiculoVersionFotoPosteriorsAccion').html('Listo');	
			$("#CapVehiculoVersionFotoPosteriors").html("");
			$("#CapVehiculoVersionFotoPosteriors").append(html);
		}
	});
	
	

}



function FncVehiculoVersionFotoPosteriorEscoger(oItem){
}

function FncVehiculoVersionFotoPosteriorEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoVersionFotoPosteriorsAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoVersion/acc/AccVehiculoVersionFotoPosteriorEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoVersionFotoPosteriorsAccion').html("Eliminado");	
				FncVehiculoVersionFotoPosteriorListar();
			}
		});

		FncVehiculoVersionFotoPosteriorNuevo();

	}
	
}

function FncVehiculoVersionFotoPosteriorEliminarTodo(){

	
}
