// JavaScript Document

function FncOrdenVentaVehiculoFotoActaEntregaNuevo(){
}

function FncOrdenVentaVehiculoFotoActaEntregaGuardar(){
	
}


function FncOrdenVentaVehiculoFotoActaEntregaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapOrdenVentaVehiculoFotoActaEntregasAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenVentaVehiculoC/FrmOrdenVentaVehiculoFotoActaEntregaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+OrdenVentaVehiculoFotoActaEntregaEditar+'&Eliminar='+OrdenVentaVehiculoFotoActaEntregaEliminar,
		success: function(html){
			$('#CapOrdenVentaVehiculoFotoActaEntregasAccion').html('Listo');	
			$("#CapOrdenVentaVehiculoFotoActaEntregas").html("");
			$("#CapOrdenVentaVehiculoFotoActaEntregas").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncOrdenVentaVehiculoFotoActaEntregaEscoger(oItem){
}

function FncOrdenVentaVehiculoFotoActaEntregaEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapOrdenVentaVehiculoFotoActaEntregasAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculoC/acc/AccOrdenVentaVehiculoFotoActaEntregaEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapOrdenVentaVehiculoFotoActaEntregasAccion').html("Eliminado");	
				FncOrdenVentaVehiculoFotoActaEntregaListar();
			}
		});

		FncOrdenVentaVehiculoFotoActaEntregaNuevo();

	}
	
}

function FncOrdenVentaVehiculoFotoActaEntregaEliminarTodo(){

	
}
