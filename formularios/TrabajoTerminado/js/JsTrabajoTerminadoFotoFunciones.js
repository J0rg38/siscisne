// JavaScript Document

function FncTrabajoTerminadoFotoNuevo(oModalidadIngreso){
	

}

function FncTrabajoTerminadoFotoGuardar(oModalidadIngreso){

	
}


function FncTrabajoTerminadoFotoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'FotoAccion').html('Cargando...');
	var ModalidadIngresoId = $('#CmpModalidadIngresoId_'+oModalidadIngreso).val();
	
	
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoFotoListado.php',
		data: 'ModalidadIngresoId='+ModalidadIngresoId+'&Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TrabajoTerminadoFotoEditar+'&Eliminar='+TrabajoTerminadoFotoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'FotoAccion').html('Listo');	
//			alert("#CapTrabajoTerminado"+oModalidadIngreso+"Fotos");
			
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Fotos").html("");
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Fotos").append(html);
		}
	});
	
	


}



function FncTrabajoTerminadoFotoEscoger(oItem,oModalidadIngreso){
		
	
	
	
}

function FncTrabajoTerminadoFotoEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'FotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'FotoAccion').html("Eliminado");	
				FncTrabajoTerminadoFotoListar(oModalidadIngreso);
			}
		});

		FncTrabajoTerminadoFotoNuevo(oModalidadIngreso);

	}
	
}



function FncTrabajoTerminadoFotoEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'FotoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoFotoEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'FotoAccion').html('Eliminado');	
				FncTrabajoTerminadoFotoListar(oModalidadIngreso);
			}
		});	
			
		FncTrabajoTerminadoFotoNuevo(oModalidadIngreso);
	}
	
}
