// JavaScript Document

function FncTrabajoTerminadoProductoAdicionalListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoProductoAdicionalListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TrabajoTerminadoProductoEditar+'&Eliminar='+TrabajoTerminadoProductoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Productos").html("");
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Productos").append(html);
		}
	});

}

