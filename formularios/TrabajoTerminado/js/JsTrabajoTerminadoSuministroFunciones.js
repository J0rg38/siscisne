// JavaScript Document




function FncTrabajoTerminadoSuministroListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoSuministroListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TrabajoTerminadoSuministroEditar+'&Eliminar='+TrabajoTerminadoSuministroEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo');	
//			alert("#CapTrabajoTerminado"+oModalidadIngreso+"Suministros");
			
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Suministros").html("");
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Suministros").append(html);
		}
	});
	
	


}


function FncTrabajoTerminadoSuministroListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoSuministroListado2.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TrabajoTerminadoSuministroEditar+'&Eliminar='+TrabajoTerminadoSuministroEliminar,		
		success: function(html){
			$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo');	
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Suministros2").html("");
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Suministros2").append(html);
		}
	});
	
}


