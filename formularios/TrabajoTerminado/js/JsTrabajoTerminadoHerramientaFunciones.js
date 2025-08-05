// JavaScript Document

/******************************************************************************/

function FncTrabajoTerminadoHerramientaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapHerramientaAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoHerramientaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+TrabajoTerminadoHerramientaEditar+'&Eliminar='+TrabajoTerminadoHerramientaEliminar,
		success: function(html){
			$('#CapHerramientaAccion').html('Listo');	

			$("#CapTrabajoTerminadoHerramientas").html("");
			$("#CapTrabajoTerminadoHerramientas").append(html);
		}
	});

}


function FncTrabajoTerminadoHerramientaListar2(){

	var Identificador = $('#Identificador').val();

	$('#CapHerramientaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoHerramientaListado2.php',
		data: 'Identificador='+Identificador+'&Editar=2'+'&Eliminar=2',
		success: function(html){
			$('#CapHerramientaAccion').html('Listo');	
			$("#CapTrabajoTerminadoHerramientas2").html("");
			$("#CapTrabajoTerminadoHerramientas2").append(html);
		}
	});
	
}

