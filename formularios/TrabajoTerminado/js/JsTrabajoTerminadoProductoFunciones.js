// JavaScript Document

function FncTrabajoTerminadoProductoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoProductoListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TrabajoTerminadoProductoEditar+'&Eliminar='+TrabajoTerminadoProductoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Productos").html("");
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Productos").append(html);
		}
	});

}


function FncTrabajoTerminadoProductoListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoProductoListado2.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TrabajoTerminadoProductoEditar+'&Eliminar='+TrabajoTerminadoProductoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Productos2").html("");
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Productos2").append(html);
		}
	});
	
}
