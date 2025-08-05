// JavaScript Document

function FncFichaAccionFotoMantenimientoNuevo(){
	

}

function FncFichaAccionFotoMantenimientoGuardar(){

	
}


function FncFichaAccionFotoMantenimientoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoMantenimientoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionFotoMantenimientoListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+FichaAccionFotoMantenimientoEliminar,
		success: function(html){
			$('#CapFotoMantenimientoAccion').html('Listo');	
			$("#CapFichaAccionFotoMantenimientos").html("");
			$("#CapFichaAccionFotoMantenimientos").append(html);
		}
	});

}

function FncFichaAccionFotoMantenimientoEscoger(){

}

function FncFichaAccionFotoMantenimientoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionFotoMantenimientoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncFichaAccionFotoMantenimientoListar();
			}
		});

		FncFichaAccionFotoMantenimientoNuevo();

	}
	
}

