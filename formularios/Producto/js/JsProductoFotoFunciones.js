// JavaScript Document

function FncProductoFotoNuevo(){
}

function FncProductoFotoGuardar(){
	
}


function FncProductoFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Producto/FrmProductoFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+ProductoFotoEditar+'&Eliminar='+ProductoFotoEliminar+'&Tipo=',
		success: function(html){
			$('#CapProductoFotosAccion').html('Listo');	
			$("#CapProductoFotos").html("");
			$("#CapProductoFotos").append(html);
		}
	});
	
	

}



function FncProductoFotoEscoger(oItem){
}

function FncProductoFotoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Producto/acc/AccProductoFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoFotosAccion').html("Eliminado");	
				FncProductoFotoListar(oTipo);
			}
		});

		FncProductoFotoNuevo();

	}
	
}



function FncProductoFotoEliminarTodo(oTipo){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapProductoFotosAccion').html('Eliminando...');
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Producto/acc/AccProductoFotoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoFotosAccion').html('Eliminado');	
				FncProductoFotoListar(oTipo);
			}
		});	
			
		FncProductoFotoNuevo(oTipo);
	}
	
}
