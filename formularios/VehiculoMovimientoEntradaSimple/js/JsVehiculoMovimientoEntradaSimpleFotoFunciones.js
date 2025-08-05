// JavaScript Document

function FncVehiculoMovimientoEntradaSimpleFotoNuevo(){
}

function FncVehiculoMovimientoEntradaSimpleFotoGuardar(){
	
}


function FncVehiculoMovimientoEntradaSimpleFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoMovimientoEntradaSimpleFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoMovimientoEntradaSimple/FrmVehiculoMovimientoEntradaSimpleFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoMovimientoEntradaSimpleFotoEditar+'&Eliminar='+VehiculoMovimientoEntradaSimpleFotoEliminar,
		success: function(html){
			$('#CapVehiculoMovimientoEntradaSimpleFotosAccion').html('Listo');	
			$("#CapVehiculoMovimientoEntradaSimpleFotos").html("");
			$("#CapVehiculoMovimientoEntradaSimpleFotos").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncVehiculoMovimientoEntradaSimpleFotoEscoger(oItem){
}

function FncVehiculoMovimientoEntradaSimpleFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoMovimientoEntradaSimpleFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoEntradaSimple/acc/AccVehiculoMovimientoEntradaSimpleFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoMovimientoEntradaSimpleFotosAccion').html("Eliminado");	
				FncVehiculoMovimientoEntradaSimpleFotoListar();
			}
		});

		FncVehiculoMovimientoEntradaSimpleFotoNuevo();

	}
	
}

function FncVehiculoMovimientoEntradaSimpleFotoEliminarTodo(){

	
}
