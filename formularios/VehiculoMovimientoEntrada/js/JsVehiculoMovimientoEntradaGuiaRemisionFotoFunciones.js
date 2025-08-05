// JavaScript Document

function FncVehiculoMovimientoEntradaGuiaRemisionFotoNuevo(){
}

function FncVehiculoMovimientoEntradaGuiaRemisionFotoGuardar(){
	
}


function FncVehiculoMovimientoEntradaGuiaRemisionFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoMovimientoEntradaGuiaRemisionFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoMovimientoEntrada/FrmVehiculoMovimientoEntradaGuiaRemisionFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoMovimientoEntradaGuiaRemisionFotoEditar+'&Eliminar='+VehiculoMovimientoEntradaGuiaRemisionFotoEliminar,
		success: function(html){
			
			$('#CapVehiculoMovimientoEntradaGuiaRemisionFotosAccion').html('Listo');	
			$("#CapVehiculoMovimientoEntradaGuiaRemisionFotos").html("");
			$("#CapVehiculoMovimientoEntradaGuiaRemisionFotos").append(html);
			
		//	tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			//console.log("FncVehiculoMovimientoEntradaGuiaRemisionFotoListar aa");
		}
	});
	
	

}



function FncVehiculoMovimientoEntradaGuiaRemisionFotoEscoger(oItem){
}

function FncVehiculoMovimientoEntradaGuiaRemisionFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoMovimientoEntradaGuiaRemisionFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoEntrada/acc/AccVehiculoMovimientoEntradaGuiaRemisionFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoMovimientoEntradaGuiaRemisionFotosAccion').html("Eliminado");	
				FncVehiculoMovimientoEntradaGuiaRemisionFotoListar();
			}
		});

		FncVehiculoMovimientoEntradaGuiaRemisionFotoNuevo();

	}
	
}

function FncVehiculoMovimientoEntradaGuiaRemisionFotoEliminarTodo(){

	
}
