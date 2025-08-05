// JavaScript Document

function FncTrabajoTerminadoGastoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapTrabajoTerminadoGastoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoGastoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+TrabajoTerminadoGastoEditar+'&Eliminar='+TrabajoTerminadoGastoEliminar,
		success: function(html){
			$('#CapTrabajoTerminadoGastoAccion').html('Listo');	
			$("#CapTrabajoTerminadoGastos").html("");
			$("#CapTrabajoTerminadoGastos").append(html);
		}
	});
	

}
