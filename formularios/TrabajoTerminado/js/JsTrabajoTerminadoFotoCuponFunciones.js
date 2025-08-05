// JavaScript Document

function FncTrabajoTerminadoFotoCuponNuevo(){
	

}

function FncTrabajoTerminadoFotoCuponGuardar(){

	
}


function FncTrabajoTerminadoFotoCuponListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoCuponAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoFotoCuponListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+TrabajoTerminadoFotoCuponEliminar,
		success: function(html){
			$('#CapFotoCuponAccion').html('Listo');	
			$("#CapTrabajoTerminadoFotoCupones").html("");
			$("#CapTrabajoTerminadoFotoCupones").append(html);
		}
	});

}

function FncTrabajoTerminadoFotoCuponEscoger(){

}

function FncTrabajoTerminadoFotoCuponEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoFotoCuponEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncTrabajoTerminadoFotoCuponListar();
			}
		});

		FncTrabajoTerminadoFotoCuponNuevo();

	}
	
}

