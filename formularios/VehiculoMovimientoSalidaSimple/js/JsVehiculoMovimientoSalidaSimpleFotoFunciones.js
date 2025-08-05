// JavaScript Document

function FncVehiculoMovimientoSalidaSimpleFotoNuevo(){
}

function FncVehiculoMovimientoSalidaSimpleFotoGuardar(){
	
}


function FncVehiculoMovimientoSalidaSimpleFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoMovimientoSalidaSimpleFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoMovimientoSalidaSimple/FrmVehiculoMovimientoSalidaSimpleFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoMovimientoSalidaSimpleFotoEditar+'&Eliminar='+VehiculoMovimientoSalidaSimpleFotoEliminar,
		success: function(html){
			$('#CapVehiculoMovimientoSalidaSimpleFotosAccion').html('Listo');	
			$("#CapVehiculoMovimientoSalidaSimpleFotos").html("");
			$("#CapVehiculoMovimientoSalidaSimpleFotos").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncVehiculoMovimientoSalidaSimpleFotoEscoger(oItem){
}

function FncVehiculoMovimientoSalidaSimpleFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoMovimientoSalidaSimpleFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoSalidaSimple/acc/AccVehiculoMovimientoSalidaSimpleFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoMovimientoSalidaSimpleFotosAccion').html("Eliminado");	
				FncVehiculoMovimientoSalidaSimpleFotoListar();
			}
		});

		FncVehiculoMovimientoSalidaSimpleFotoNuevo();

	}
	
}

function FncVehiculoMovimientoSalidaSimpleFotoEliminarTodo(){

	
}
