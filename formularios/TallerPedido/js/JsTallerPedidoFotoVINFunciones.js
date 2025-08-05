// JavaScript Document

function FncTallerPedidoFotoVINNuevo(){
	

}

function FncTallerPedidoFotoVINGuardar(){

	
}


function FncTallerPedidoFotoVINListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoVINAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoFotoVINListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+TallerPedidoFotoVINEliminar,
		success: function(html){
			$('#CapFotoVINAccion').html('Listo');	
			$("#CapTallerPedidoFotoVINs").html("");
			$("#CapTallerPedidoFotoVINs").append(html);
		}
	});

}

function FncTallerPedidoFotoVINEscoger(){

}

function FncTallerPedidoFotoVINEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoFotoVINEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncTallerPedidoFotoVINListar();
			}
		});

		FncTallerPedidoFotoVINNuevo();

	}
	
}

