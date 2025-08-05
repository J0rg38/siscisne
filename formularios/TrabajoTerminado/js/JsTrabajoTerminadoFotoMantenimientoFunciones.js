// JavaScript Document

function FncTrabajoTerminadoFotoMantenimientoNuevo(){
	

}

function FncTrabajoTerminadoFotoMantenimientoGuardar(){

	
}


function FncTrabajoTerminadoFotoMantenimientoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoMantenimientoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoFotoMantenimientoListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+TrabajoTerminadoFotoMantenimientoEliminar,
		success: function(html){
			$('#CapFotoMantenimientoAccion').html('Listo');	
			$("#CapTrabajoTerminadoFotoMantenimientos").html("");
			$("#CapTrabajoTerminadoFotoMantenimientos").append(html);
		}
	});

}

function FncTrabajoTerminadoFotoMantenimientoEscoger(){

}

function FncTrabajoTerminadoFotoMantenimientoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoFotoMantenimientoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncTrabajoTerminadoFotoMantenimientoListar();
			}
		});

		FncTrabajoTerminadoFotoMantenimientoNuevo();

	}
	
}

