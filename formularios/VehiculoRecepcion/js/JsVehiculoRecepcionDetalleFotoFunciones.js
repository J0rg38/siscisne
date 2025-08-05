// JavaScript Document

function FncVehiculoRecepcionDetalleFotoNuevo(oFotoItem){
	

}

function FncVehiculoRecepcionDetalleFotoGuardar(oFotoItem){

	
}


function FncVehiculoRecepcionDetalleFotoListar(oFotoItem){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoRecepcionDetalleFotoAccion'+oFotoItem).html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoRecepcion/FrmVehiculoRecepcionDetalleFotoListado.php',
		data: 'FotoItem='+oFotoItem+'&Identificador='+Identificador+'&Editar='+VehiculoRecepcionDetalleFotoEditar+'&Eliminar='+VehiculoRecepcionDetalleFotoEliminar,
		success: function(html){
			$('#CapVehiculoRecepcionDetalleFotoAccion'+oFotoItem).html('Listo');	

			$("#CapVehiculoRecepcionDetalleFotos"+oFotoItem).html("");
			$("#CapVehiculoRecepcionDetalleFotos"+oFotoItem).append(html);
		}
	});
	


}



function FncVehiculoRecepcionDetalleFotoEscoger(oItem,oFotoItem){
		
	
	
	
}

function FncVehiculoRecepcionDetalleFotoEliminar(oItem,oFotoItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoRecepcionDetalleFotoAccion'+oFotoItem).html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoRecepcion/acc/AccVehiculoRecepcionDetalleFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&FotoItem='+oFotoItem,
			success: function(){
				$('#CapVehiculoRecepcionDetalleFotoAccion'+oFotoItem).html('Eliminado');
				FncVehiculoRecepcionDetalleFotoListar(oFotoItem);
			}
		});

		FncVehiculoRecepcionDetalleFotoNuevo(oFotoItem);

	}
	
}



function FncVehiculoRecepcionDetalleFotoEliminarTodo(oFotoItem){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oItem+'FotoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoRecepcion/acc/AccVehiculoRecepcionDetalleFotoEliminarTodo.php',
			data: 'Identificador='+Identificador+'&FotoItem='+oFotoItem,
			success: function(){
				$('#Cap'+oItem+'FotoAccion').html('Eliminado');	
				FncVehiculoRecepcionDetalleFotoListar(oFotoItem);
			}
		});	
			
		FncVehiculoRecepcionDetalleFotoNuevo(oFotoItem);
	}
	
}
