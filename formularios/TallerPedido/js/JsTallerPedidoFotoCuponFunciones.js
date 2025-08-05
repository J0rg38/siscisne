// JavaScript Document

function FncTallerPedidoFotoCuponNuevo(){
	

}

function FncTallerPedidoFotoCuponGuardar(){

	
}


function FncTallerPedidoFotoCuponListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoCuponAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoFotoCuponListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+TallerPedidoFotoCuponEliminar,
		success: function(html){
			$('#CapFotoCuponAccion').html('Listo');	
			$("#CapTallerPedidoFotoCupones").html("");
			$("#CapTallerPedidoFotoCupones").append(html);
		}
	});

}

function FncTallerPedidoFotoCuponEscoger(){

}

function FncTallerPedidoFotoCuponEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoFotoCuponEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncTallerPedidoFotoCuponListar();
			}
		});

		FncTallerPedidoFotoCuponNuevo();

	}
	
}

