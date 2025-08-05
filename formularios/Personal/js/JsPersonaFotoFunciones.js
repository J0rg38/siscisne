// JavaScript Document

function FncPersonalFotoNuevo(){
}

function FncPersonalFotoGuardar(){
	
}


function FncPersonalFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapPersonalFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Personal/FrmPersonalFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+PersonalFotoEditar+'&Eliminar='+PersonalFotoEliminar,
		success: function(html){
			$('#CapPersonalFotosAccion').html('Listo');	
			$("#CapPersonalFotos").html("");
			$("#CapPersonalFotos").append(html);
		}
	});
	
	

}



function FncPersonalFotoEscoger(oItem){
}

function FncPersonalFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapPersonalFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Personal/acc/AccPersonalFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapPersonalFotosAccion').html("Eliminado");	
				FncPersonalFotoListar();
			}
		});

		FncPersonalFotoNuevo();

	}
	
}

function FncPersonalFotoEliminarTodo(){

	
}
