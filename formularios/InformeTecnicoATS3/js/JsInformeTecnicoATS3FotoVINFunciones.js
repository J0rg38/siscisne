// JavaScript Document

function FncInformeTecnicoATS3FotoVINNuevo(){
	

}

function FncInformeTecnicoATS3FotoVINGuardar(){

	
}


function FncInformeTecnicoATS3FotoVINListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoVINAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/InformeTecnicoATS3/FrmInformeTecnicoATS3FotoVINListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+InformeTecnicoATS3FotoVINEliminar,
		success: function(html){
			$('#CapFotoVINAccion').html('Listo');	
			$("#CapInformeTecnicoATS3FotoVINs").html("");
			$("#CapInformeTecnicoATS3FotoVINs").append(html);
		}
	});

}

function FncInformeTecnicoATS3FotoVINEscoger(){

}

function FncInformeTecnicoATS3FotoVINEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3FotoVINEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncInformeTecnicoATS3FotoVINListar();
			}
		});

		FncInformeTecnicoATS3FotoVINNuevo();

	}
	
}

