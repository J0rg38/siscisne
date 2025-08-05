// JavaScript Document

function FncProveedorComunicadoFotoNuevo(oTipo){
}

function FncProveedorComunicadoFotoGuardar(oTipo){
	
}


function FncProveedorComunicadoFotoListar(oTipo){

	var Identificador = $('#Identificador').val();

	$('#CapProveedorComunicadoFotosAccion'+oTipo).html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/ProveedorComunicado/FrmProveedorComunicadoFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+ProveedorComunicadoFotoEditar+'&Eliminar='+ProveedorComunicadoFotoEliminar+'&Tipo='+oTipo,
		success: function(html){
			$('#CapProveedorComunicadoFotosAccion'+oTipo).html('Listo');	
			$("#CapProveedorComunicadoFotos"+oTipo).html("");
			$("#CapProveedorComunicadoFotos"+oTipo).append(html);
		}
	});
	
	

}



function FncProveedorComunicadoFotoEscoger(oItem){
}

function FncProveedorComunicadoFotoEliminar(oItem,oTipo){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProveedorComunicadoFotosAccion'+oTipo).html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/ProveedorComunicado/acc/AccProveedorComunicadoFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProveedorComunicadoFotosAccion'+oTipo).html("Eliminado");	
				FncProveedorComunicadoFotoListar(oTipo);
			}
		});

		FncProveedorComunicadoFotoNuevo();

	}
	
}



function FncProveedorComunicadoFotoEliminarTodo(oTipo){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapProveedorComunicadoFotosAccion'+oTipo).html('Eliminando...');
	
		$.ajax({
			type: 'POST',
			url: 'formularios/ProveedorComunicado/acc/AccProveedorComunicadoFotoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProveedorComunicadoFotosAccion'+oTipo).html('Eliminado');	
				FncProveedorComunicadoFotoListar(oTipo);
			}
		});	
			
		FncProveedorComunicadoFotoNuevo(oTipo);
	}
	
}
