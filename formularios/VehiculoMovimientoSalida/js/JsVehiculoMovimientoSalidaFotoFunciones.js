// JavaScript Document

function FncVehiculoMovimientoSalidaFotoNuevo(){
}

function FncVehiculoMovimientoSalidaFotoGuardar(){
	
}


function FncVehiculoMovimientoSalidaFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoMovimientoSalidaFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoMovimientoSalida/FrmVehiculoMovimientoSalidaFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoMovimientoSalidaFotoEditar+'&Eliminar='+VehiculoMovimientoSalidaFotoEliminar,
		success: function(html){
			$('#CapVehiculoMovimientoSalidaFotosAccion').html('Listo');	
			$("#CapVehiculoMovimientoSalidaFotos").html("");
			$("#CapVehiculoMovimientoSalidaFotos").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncVehiculoMovimientoSalidaFotoEscoger(oItem){
}

function FncVehiculoMovimientoSalidaFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoMovimientoSalidaFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoSalida/acc/AccVehiculoMovimientoSalidaFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoMovimientoSalidaFotosAccion').html("Eliminado");	
				FncVehiculoMovimientoSalidaFotoListar();
			}
		});

		FncVehiculoMovimientoSalidaFotoNuevo();

	}
	
}

function FncVehiculoMovimientoSalidaFotoEliminarTodo(){

	
}
