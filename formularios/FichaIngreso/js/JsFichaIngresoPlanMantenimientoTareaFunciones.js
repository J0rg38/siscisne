// JavaScript Document

// JavaScript Document




function FncFichaIngresoPlanMantenimientoTareaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapPlanMantenimientoTareaAccion').html('Cargando...');
	
	if(document.getElementById('CmpFichaIngresoPlanMantenimientoTareaMostrarTiempoModificacion').checked == 1){
		var MostrarTiempoModificacion = 1;
	}else{
		var MostrarTiempoModificacion =	0;
	}
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/FrmFichaIngresoPlanMantenimientoTareaListado.php',
		data: 'Identificador='+Identificador+'&MostrarTiempoModificacion='+MostrarTiempoModificacion+'&Editar='+FichaIngresoPlanMantenimientoTareaEditar+'&Eliminar='+FichaIngresoPlanMantenimientoTareaEliminar,
		success: function(html){
			$('#CapPlanMantenimientoTareaAccion').html('Listo');	
			$("#CapFichaIngresoPlanMantenimientoTareas").html("");
			$("#CapFichaIngresoPlanMantenimientoTareas").append(html);
		}
	});
	
	


}

