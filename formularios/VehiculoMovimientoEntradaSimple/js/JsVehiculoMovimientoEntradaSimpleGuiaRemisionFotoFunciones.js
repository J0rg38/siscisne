// JavaScript Document

function FncVehiculoMovimientoEntradaSimpleGuiaRemisionFotoNuevo(){
}

function FncVehiculoMovimientoEntradaSimpleGuiaRemisionFotoGuardar(){
	
}


function FncVehiculoMovimientoEntradaSimpleGuiaRemisionFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoMovimientoEntradaSimpleGuiaRemisionFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoMovimientoEntradaSimple/FrmVehiculoMovimientoEntradaSimpleGuiaRemisionFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoMovimientoEntradaSimpleGuiaRemisionFotoEditar+'&Eliminar='+VehiculoMovimientoEntradaSimpleGuiaRemisionFotoEliminar,
		success: function(html){
			
			$('#CapVehiculoMovimientoEntradaSimpleGuiaRemisionFotosAccion').html('Listo');	
			$("#CapVehiculoMovimientoEntradaSimpleGuiaRemisionFotos").html("");
			$("#CapVehiculoMovimientoEntradaSimpleGuiaRemisionFotos").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			//console.log("FncVehiculoMovimientoEntradaSimpleGuiaRemisionFotoListar aa");
		}
	});
	
	

}



function FncVehiculoMovimientoEntradaSimpleGuiaRemisionFotoEscoger(oItem){
}

function FncVehiculoMovimientoEntradaSimpleGuiaRemisionFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoMovimientoEntradaSimpleGuiaRemisionFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoEntradaSimple/acc/AccVehiculoMovimientoEntradaSimpleGuiaRemisionFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoMovimientoEntradaSimpleGuiaRemisionFotosAccion').html("Eliminado");	
				FncVehiculoMovimientoEntradaSimpleGuiaRemisionFotoListar();
			}
		});

		FncVehiculoMovimientoEntradaSimpleGuiaRemisionFotoNuevo();

	}
	
}

function FncVehiculoMovimientoEntradaSimpleGuiaRemisionFotoEliminarTodo(){

	
}
