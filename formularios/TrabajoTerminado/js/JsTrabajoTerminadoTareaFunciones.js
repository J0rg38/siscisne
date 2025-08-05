// JavaScript Document



function FncTrabajoTerminadoTareaListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoTareaListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TrabajoTerminadoTareaEditar+'&Eliminar='+TrabajoTerminadoTareaEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');	
			//alert(html);
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Tareas").html("");
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Tareas").append(html);
		}
	});
	
}

function FncTrabajoTerminadoTareaListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoTareaListado2.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar=2'+'&Eliminar=2',
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');	

			$("#CapTrabajoTerminado"+oModalidadIngreso+"Tareas2").html("");
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Tareas2").append(html);
		}
	});
	
}