// JavaScript Document

function FncCotizacionProductoFotoNuevo(oTipo){
}

function FncCotizacionProductoFotoGuardar(oTipo){
	
}


function FncCotizacionProductoFotoListar(oTipo){

	var Identificador = $('#Identificador').val();

	$('#CapCotizacionProductoFotosAccion'+oTipo).html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionProducto/FrmCotizacionProductoFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+CotizacionProductoFotoEditar+'&Eliminar='+CotizacionProductoFotoEliminar+'&Tipo='+oTipo,
		success: function(html){
			$('#CapCotizacionProductoFotosAccion'+oTipo).html('Listo');	
			$("#CapCotizacionProductoFotos"+oTipo).html("");
			$("#CapCotizacionProductoFotos"+oTipo).append(html);
		}
	});
	
	

}



function FncCotizacionProductoFotoEscoger(oItem){
}

function FncCotizacionProductoFotoEliminar(oItem,oTipo){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapCotizacionProductoFotosAccion'+oTipo).html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapCotizacionProductoFotosAccion'+oTipo).html("Eliminado");	
				FncCotizacionProductoFotoListar(oTipo);
			}
		});

		FncCotizacionProductoFotoNuevo();

	}
	
}



function FncCotizacionProductoFotoEliminarTodo(oTipo){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapCotizacionProductoFotosAccion'+oTipo).html('Eliminando...');
	
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoFotoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapCotizacionProductoFotosAccion'+oTipo).html('Eliminado');	
				FncCotizacionProductoFotoListar(oTipo);
			}
		});	
			
		FncCotizacionProductoFotoNuevo(oTipo);
	}
	
}
