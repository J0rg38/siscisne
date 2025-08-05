// JavaScript Document

function FncVehiculoVersionFotoLateralNuevo(){
}

function FncVehiculoVersionFotoLateralGuardar(){
	
}


function FncVehiculoVersionFotoLateralListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoVersionFotoLateralsAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoVersion/FrmVehiculoVersionFotoLateralListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoVersionFotoLateralEditar+'&Eliminar='+VehiculoVersionFotoLateralEliminar,
		success: function(html){
			$('#CapVehiculoVersionFotoLateralsAccion').html('Listo');	
			$("#CapVehiculoVersionFotoLaterals").html("");
			$("#CapVehiculoVersionFotoLaterals").append(html);
		}
	});
	
	

}



function FncVehiculoVersionFotoLateralEscoger(oItem){
}

function FncVehiculoVersionFotoLateralEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoVersionFotoLateralsAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoVersion/acc/AccVehiculoVersionFotoLateralEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoVersionFotoLateralsAccion').html("Eliminado");	
				FncVehiculoVersionFotoLateralListar();
			}
		});

		FncVehiculoVersionFotoLateralNuevo();

	}
	
}

function FncVehiculoVersionFotoLateralEliminarTodo(){

	
}
