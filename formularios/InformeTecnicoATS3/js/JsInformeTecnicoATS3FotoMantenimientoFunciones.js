// JavaScript Document

function FncInformeTecnicoATS3FotoMantenimientoNuevo(){
	

}

function FncInformeTecnicoATS3FotoMantenimientoGuardar(){

	
}


function FncInformeTecnicoATS3FotoMantenimientoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoMantenimientoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/InformeTecnicoATS3/FrmInformeTecnicoATS3FotoMantenimientoListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+InformeTecnicoATS3FotoMantenimientoEliminar,
		success: function(html){
			$('#CapFotoMantenimientoAccion').html('Listo');	
			$("#CapInformeTecnicoATS3FotoMantenimientos").html("");
			$("#CapInformeTecnicoATS3FotoMantenimientos").append(html);
		}
	});

}

function FncInformeTecnicoATS3FotoMantenimientoEscoger(){

}

function FncInformeTecnicoATS3FotoMantenimientoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3FotoMantenimientoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncInformeTecnicoATS3FotoMantenimientoListar();
			}
		});

		FncInformeTecnicoATS3FotoMantenimientoNuevo();

	}
	
}

