// JavaScript Document

function FncPagoVehiculoIngresoFotoNuevo(){
}

function FncPagoVehiculoIngresoFotoGuardar(){
	
}


function FncPagoVehiculoIngresoFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapPagoVehiculoIngresoFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PagoVehiculoIngreso/FrmPagoVehiculoIngresoFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+PagoVehiculoIngresoFotoEditar+'&Eliminar='+PagoVehiculoIngresoFotoEliminar,
		success: function(html){
			$('#CapPagoVehiculoIngresoFotosAccion').html('Listo');	
			$("#CapPagoVehiculoIngresoFotos").html("");
			$("#CapPagoVehiculoIngresoFotos").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncPagoVehiculoIngresoFotoEscoger(oItem){
}

function FncPagoVehiculoIngresoFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapPagoVehiculoIngresoFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PagoVehiculoIngreso/acc/AccPagoVehiculoIngresoFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapPagoVehiculoIngresoFotosAccion').html("Eliminado");	
				FncPagoVehiculoIngresoFotoListar();
			}
		});

		FncPagoVehiculoIngresoFotoNuevo();

	}
	
}

function FncPagoVehiculoIngresoFotoEliminarTodo(){

	
}
