// JavaScript Document

function FncTrasladoProductoFotoNuevo(){
}

function FncTrasladoProductoFotoGuardar(){
	
}


function FncTrasladoProductoFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapTrasladoProductoFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrasladoProducto/FrmTrasladoProductoFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+TrasladoProductoFotoEditar+'&Eliminar='+TrasladoProductoFotoEliminar,
		success: function(html){
			$('#CapTrasladoProductoFotosAccion').html('Listo');	
			$("#CapTrasladoProductoFotos").html("");
			$("#CapTrasladoProductoFotos").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncTrasladoProductoFotoEscoger(oItem){
}

function FncTrasladoProductoFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapTrasladoProductoFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoProducto/acc/AccTrasladoProductoFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapTrasladoProductoFotosAccion').html("Eliminado");	
				FncTrasladoProductoFotoListar();
			}
		});

		FncTrasladoProductoFotoNuevo();

	}
	
}

function FncTrasladoProductoFotoEliminarTodo(){

	
}
