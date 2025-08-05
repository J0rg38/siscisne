// JavaScript Document

function FncVehiculoVersionArchivoNuevo(){
}

function FncVehiculoVersionArchivoGuardar(){
	
}


function FncVehiculoVersionArchivoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoVersionArchivosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoVersion/FrmVehiculoVersionArchivoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoVersionArchivoEditar+'&Eliminar='+VehiculoVersionArchivoEliminar,
		success: function(html){
			$('#CapVehiculoVersionArchivosAccion').html('Listo');	
			$("#CapVehiculoVersionArchivos").html("");
			$("#CapVehiculoVersionArchivos").append(html);
		}
	});
	
	

}



function FncVehiculoVersionArchivoEscoger(oItem){
}

function FncVehiculoVersionArchivoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoVersionArchivosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoVersion/acc/AccVehiculoVersionArchivoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoVersionArchivosAccion').html("Eliminado");	
				FncVehiculoVersionArchivoListar();
			}
		});

		FncVehiculoVersionArchivoNuevo();

	}
	
}

function FncVehiculoVersionArchivoEliminarTodo(){

	
}
