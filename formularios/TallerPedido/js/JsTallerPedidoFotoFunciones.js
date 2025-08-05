// JavaScript Document

function FncTallerPedidoFotoNuevo(oModalidadIngreso){
	

}

function FncTallerPedidoFotoGuardar(oModalidadIngreso){

	
}


function FncTallerPedidoFotoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'FotoAccion').html('Cargando...');
	var ModalidadIngresoId = $('#CmpModalidadIngresoId_'+oModalidadIngreso).val();
	
	
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoFotoListado.php',
		data: 'ModalidadIngresoId='+ModalidadIngresoId+'&Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TallerPedidoFotoEditar+'&Eliminar='+TallerPedidoFotoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'FotoAccion').html('Listo');	
//			alert("#CapTallerPedido"+oModalidadIngreso+"Fotos");
			
			$("#CapTallerPedido"+oModalidadIngreso+"Fotos").html("");
			$("#CapTallerPedido"+oModalidadIngreso+"Fotos").append(html);
		}
	});
	
	


}



function FncTallerPedidoFotoEscoger(oItem,oModalidadIngreso){
		
	
}

function FncTallerPedidoFotoEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'FotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'FotoAccion').html("Eliminado");	
				FncTallerPedidoFotoListar(oModalidadIngreso);
			}
		});

		FncTallerPedidoFotoNuevo(oModalidadIngreso);

	}
	
}



function FncTallerPedidoFotoEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'FotoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoFotoEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'FotoAccion').html('Eliminado');	
				FncTallerPedidoFotoListar(oModalidadIngreso);
			}
		});	
			
		FncTallerPedidoFotoNuevo(oModalidadIngreso);
	}
	
}
