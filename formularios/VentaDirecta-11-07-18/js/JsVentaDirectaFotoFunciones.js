// JavaScript Document

function FncVentaDirectaFotoNuevo(oTipo){
}

function FncVentaDirectaFotoGuardar(oTipo){
	
}


function FncVentaDirectaFotoListar(oTipo){

	var Identificador = $('#Identificador').val();

	$('#CapVentaDirectaFotosAccion'+oTipo).html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VentaDirecta/FrmVentaDirectaFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VentaDirectaFotoEditar+'&Eliminar='+VentaDirectaFotoEliminar+'&Tipo='+oTipo,
		success: function(html){
			$('#CapVentaDirectaFotosAccion'+oTipo).html('Listo');	
			$("#CapVentaDirectaFotos"+oTipo).html("");
			$("#CapVentaDirectaFotos"+oTipo).append(html);
		}
	});
	
	

}



function FncVentaDirectaFotoEscoger(oItem){
}

function FncVentaDirectaFotoEliminar(oItem,oTipo){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVentaDirectaFotosAccion'+oTipo).html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVentaDirectaFotosAccion'+oTipo).html("Eliminado");	
				FncVentaDirectaFotoListar(oTipo);
			}
		});

		FncVentaDirectaFotoNuevo();

	}
	
}



function FncVentaDirectaFotoEliminarTodo(oTipo){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapVentaDirectaFotosAccion'+oTipo).html('Eliminando...');
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaFotoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVentaDirectaFotosAccion'+oTipo).html('Eliminado');	
				FncVentaDirectaFotoListar(oTipo);
			}
		});	
			
		FncVentaDirectaFotoNuevo(oTipo);
	}
	
}
