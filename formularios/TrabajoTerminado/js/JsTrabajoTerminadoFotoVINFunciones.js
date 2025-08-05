// JavaScript Document

function FncTrabajoTerminadoFotoVINNuevo(){
	

}

function FncTrabajoTerminadoFotoVINGuardar(){

	
}


function FncTrabajoTerminadoFotoVINListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoVINAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoFotoVINListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+TrabajoTerminadoFotoVINEliminar,
		success: function(html){
			$('#CapFotoVINAccion').html('Listo');	
			$("#CapTrabajoTerminadoFotoVINs").html("");
			$("#CapTrabajoTerminadoFotoVINs").append(html);
		}
	});

}

function FncTrabajoTerminadoFotoVINEscoger(){

}

function FncTrabajoTerminadoFotoVINEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoFotoVINEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncTrabajoTerminadoFotoVINListar();
			}
		});

		FncTrabajoTerminadoFotoVINNuevo();

	}
	
}

