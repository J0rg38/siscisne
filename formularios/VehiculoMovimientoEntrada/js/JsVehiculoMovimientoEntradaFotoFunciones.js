// JavaScript Document

function FncVehiculoMovimientoEntradaFotoNuevo(){
}

function FncVehiculoMovimientoEntradaFotoGuardar(){
	
}


function FncVehiculoMovimientoEntradaFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoMovimientoEntradaFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoMovimientoEntrada/FrmVehiculoMovimientoEntradaFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoMovimientoEntradaFotoEditar+'&Eliminar='+VehiculoMovimientoEntradaFotoEliminar,
		success: function(html){
			$('#CapVehiculoMovimientoEntradaFotosAccion').html('Listo');	
			$("#CapVehiculoMovimientoEntradaFotos").html("");
			$("#CapVehiculoMovimientoEntradaFotos").append(html);
			
			//tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncVehiculoMovimientoEntradaFotoEscoger(oItem){
}

function FncVehiculoMovimientoEntradaFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoMovimientoEntradaFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoEntrada/acc/AccVehiculoMovimientoEntradaFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoMovimientoEntradaFotosAccion').html("Eliminado");	
				FncVehiculoMovimientoEntradaFotoListar();
			}
		});

		FncVehiculoMovimientoEntradaFotoNuevo();

	}
	
}

function FncVehiculoMovimientoEntradaFotoEliminarTodo(){

	
}
