// JavaScript Document

function FncProveedorComunicadoFotoSoloNuevo(){
}

function FncProveedorComunicadoFotoSoloGuardar(){
	
}


function FncProveedorComunicadoFotoSoloListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProveedorComunicadoFotoSolosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/ProveedorComunicado/FrmProveedorComunicadoFotoSoloListado.php',
		data: 'Identificador='+Identificador+'&Editar='+ProveedorComunicadoFotoSoloEditar+'&Eliminar='+ProveedorComunicadoFotoSoloEliminar,
		success: function(html){
			$('#CapProveedorComunicadoFotoSolosAccion').html('Listo');	
			$("#CapProveedorComunicadoFotoSolos").html("");
			$("#CapProveedorComunicadoFotoSolos").append(html);
		}
	});
	
	

}



function FncProveedorComunicadoFotoSoloEscoger(oItem){
}

function FncProveedorComunicadoFotoSoloEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProveedorComunicadoFotoSolosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/ProveedorComunicado/acc/AccProveedorComunicadoFotoSoloEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProveedorComunicadoFotoSolosAccion').html("Eliminado");	
				FncProveedorComunicadoFotoSoloListar();
			}
		});

		FncProveedorComunicadoFotoSoloNuevo();

	}
	
}

function FncProveedorComunicadoFotoSoloEliminarTodo(){

	
}
