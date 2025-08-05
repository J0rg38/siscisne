// JavaScript Document

function FncTallerPedidoFotoDelanteraNuevo(){
	

}

function FncTallerPedidoFotoDelanteraGuardar(){

	
}


function FncTallerPedidoFotoDelanteraListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoDelanteraAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoFotoDelanteraListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+TallerPedidoFotoDelanteraEliminar,
		success: function(html){
			$('#CapFotoDelanteraAccion').html('Listo');	
			$("#CapTallerPedidoFotoDelanteras").html("");
			$("#CapTallerPedidoFotoDelanteras").append(html);
		}
	});

}



function FncTallerPedidoFotoDelanteraEscoger(){
		
}

function FncTallerPedidoFotoDelanteraEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoFotoDelanteraEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncTallerPedidoFotoDelanteraListar();
			}
		});

		FncTallerPedidoFotoDelanteraNuevo();

	}
	
}

