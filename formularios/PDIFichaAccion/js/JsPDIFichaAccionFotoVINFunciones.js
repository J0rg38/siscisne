// JavaScript Document

function FncFichaAccionFotoVINNuevo(){
	

}

function FncFichaAccionFotoVINGuardar(){

	
}


function FncFichaAccionFotoVINListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoVINAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PDIFichaAccion/FrmPDIFichaAccionFotoVINListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+FichaAccionFotoVINEliminar,
		success: function(html){
			$('#CapFotoVINAccion').html('Listo');	
			$("#CapFichaAccionFotoVINs").html("");
			$("#CapFichaAccionFotoVINs").append(html);
		}
	});

}

function FncFichaAccionFotoVINEscoger(){

}

function FncFichaAccionFotoVINEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionFotoVINEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncFichaAccionFotoVINListar();
			}
		});

		FncFichaAccionFotoVINNuevo();

	}
	
}

