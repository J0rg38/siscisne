// JavaScript Document

function FncFichaAccionFotoCuponNuevo(){
	

}

function FncFichaAccionFotoCuponGuardar(){

	
}


function FncFichaAccionFotoCuponListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoCuponAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionFotoCuponListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+FichaAccionFotoCuponEliminar,
		success: function(html){
			$('#CapFotoCuponAccion').html('Listo');	
			$("#CapFichaAccionFotoCupones").html("");
			$("#CapFichaAccionFotoCupones").append(html);
		}
	});

}

function FncFichaAccionFotoCuponEscoger(){

}

function FncFichaAccionFotoCuponEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionFotoCuponEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncFichaAccionFotoCuponListar();
			}
		});

		FncFichaAccionFotoCuponNuevo();

	}
	
}

