// JavaScript Document

function FncFichaAccionFotoDelanteraNuevo(){
	

}

function FncFichaAccionFotoDelanteraGuardar(){

	
}


function FncFichaAccionFotoDelanteraListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoDelanteraAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/PDIFichaAccion/FrmPDIFichaAccionFotoDelanteraListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+FichaAccionFotoDelanteraEliminar,
		success: function(html){
			$('#CapFotoDelanteraAccion').html('Listo');	
			$("#CapFichaAccionFotoDelanteras").html("");
			$("#CapFichaAccionFotoDelanteras").append(html);
		}
	});

}



function FncFichaAccionFotoDelanteraEscoger(){
		
}

function FncFichaAccionFotoDelanteraEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionFotoDelanteraEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncFichaAccionFotoDelanteraListar();
			}
		});

		FncFichaAccionFotoDelanteraNuevo();

	}
	
}

