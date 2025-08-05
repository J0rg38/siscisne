// JavaScript Document

function FncInformeTecnicoATS3FotoCuponNuevo(){
	

}

function FncInformeTecnicoATS3FotoCuponGuardar(){

	
}


function FncInformeTecnicoATS3FotoCuponListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFotoCuponAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/InformeTecnicoATS3/FrmInformeTecnicoATS3FotoCuponListado.php',
		data: 'Identificador='+Identificador+'&Eliminar='+InformeTecnicoATS3FotoCuponEliminar,
		success: function(html){
			$('#CapFotoCuponAccion').html('Listo');	
			$("#CapInformeTecnicoATS3FotoCupones").html("");
			$("#CapInformeTecnicoATS3FotoCupones").append(html);
		}
	});

}

function FncInformeTecnicoATS3FotoCuponEscoger(){

}

function FncInformeTecnicoATS3FotoCuponEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3FotoCuponEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFotoAccion').html("Eliminado");	
				FncInformeTecnicoATS3FotoCuponListar();
			}
		});

		FncInformeTecnicoATS3FotoCuponNuevo();

	}
	
}

