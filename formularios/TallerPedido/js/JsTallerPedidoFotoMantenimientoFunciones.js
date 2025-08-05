// JavaScript Document

function FncTallerPedidoFotoMantenimientoNuevo(){
	

}

function FncTallerPedidoFotoMantenimientoGuardar(){

	
}


function FncTallerPedidoFotoMantenimientoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoMantenimientoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoFotoMantenimientoListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+TallerPedidoFotoMantenimientoEliminar,
		success: function(html){
			$('#CapFotoMantenimientoAccion').html('Listo');	
			$("#CapTallerPedidoFotoMantenimientos").html("");
			$("#CapTallerPedidoFotoMantenimientos").append(html);
		}
	});

}

function FncTallerPedidoFotoMantenimientoEscoger(){

}

function FncTallerPedidoFotoMantenimientoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoFotoMantenimientoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncTallerPedidoFotoMantenimientoListar();
			}
		});

		FncTallerPedidoFotoMantenimientoNuevo();

	}
	
}

