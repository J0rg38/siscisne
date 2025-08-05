// JavaScript Document

function FncTrabajoTerminadoFotoDelanteraNuevo(){
	

}

function FncTrabajoTerminadoFotoDelanteraGuardar(){

	
}


function FncTrabajoTerminadoFotoDelanteraListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoDelanteraAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoFotoDelanteraListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+TrabajoTerminadoFotoDelanteraEliminar,
		success: function(html){
			$('#CapFotoDelanteraAccion').html('Listo');	
			$("#CapTrabajoTerminadoFotoDelanteras").html("");
			$("#CapTrabajoTerminadoFotoDelanteras").append(html);
		}
	});

}



function FncTrabajoTerminadoFotoDelanteraEscoger(){
		
}

function FncTrabajoTerminadoFotoDelanteraEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoFotoDelanteraEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncTrabajoTerminadoFotoDelanteraListar();
			}
		});

		FncTrabajoTerminadoFotoDelanteraNuevo();

	}
	
}

