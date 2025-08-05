// JavaScript Document

function FncProductoFotoSoloNuevo(){
}

function FncProductoFotoSoloGuardar(){
	
}


function FncProductoFotoSoloListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoFotoSolosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Producto/FrmProductoFotoSoloListado.php',
		data: 'Identificador='+Identificador+'&Editar='+ProductoFotoSoloEditar+'&Eliminar='+ProductoFotoSoloEliminar,
		success: function(html){
			$('#CapProductoFotoSolosAccion').html('Listo');	
			$("#CapProductoFotoSolos").html("");
			$("#CapProductoFotoSolos").append(html);
		}
	});
	
	

}



function FncProductoFotoSoloEscoger(oItem){
}

function FncProductoFotoSoloEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoFotoSolosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Producto/acc/AccProductoFotoSoloEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoFotoSolosAccion').html("Eliminado");	
				FncProductoFotoSoloListar();
			}
		});

		FncProductoFotoSoloNuevo();

	}
	
}

function FncProductoFotoSoloEliminarTodo(){

	
}
