// JavaScript Document

function FncTrasladoVehiculoFotoNuevo(){
}

function FncTrasladoVehiculoFotoGuardar(){
	
}


function FncTrasladoVehiculoFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapTrasladoVehiculoFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrasladoVehiculo/FrmTrasladoVehiculoFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+TrasladoVehiculoFotoEditar+'&Eliminar='+TrasladoVehiculoFotoEliminar,
		success: function(html){
			$('#CapTrasladoVehiculoFotosAccion').html('Listo');	
			$("#CapTrasladoVehiculoFotos").html("");
			$("#CapTrasladoVehiculoFotos").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncTrasladoVehiculoFotoEscoger(oItem){
}

function FncTrasladoVehiculoFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapTrasladoVehiculoFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoVehiculo/acc/AccTrasladoVehiculoFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapTrasladoVehiculoFotosAccion').html("Eliminado");	
				FncTrasladoVehiculoFotoListar();
			}
		});

		FncTrasladoVehiculoFotoNuevo();

	}
	
}

function FncTrasladoVehiculoFotoEliminarTodo(){

	
}
