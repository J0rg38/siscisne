// JavaScript Document

function FncInformeTecnicoATS3FotoDelanteraNuevo(){
	

}

function FncInformeTecnicoATS3FotoDelanteraGuardar(){

	
}


function FncInformeTecnicoATS3FotoDelanteraListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoDelanteraAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/InformeTecnicoATS3/FrmInformeTecnicoATS3FotoDelanteraListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+InformeTecnicoATS3FotoDelanteraEliminar,
		success: function(html){
			$('#CapFotoDelanteraAccion').html('Listo');	
			$("#CapInformeTecnicoATS3FotoDelanteras").html("");
			$("#CapInformeTecnicoATS3FotoDelanteras").append(html);
		}
	});

}



function FncInformeTecnicoATS3FotoDelanteraEscoger(){
		
}

function FncInformeTecnicoATS3FotoDelanteraEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3FotoDelanteraEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncInformeTecnicoATS3FotoDelanteraListar();
			}
		});

		FncInformeTecnicoATS3FotoDelanteraNuevo();

	}
	
}

