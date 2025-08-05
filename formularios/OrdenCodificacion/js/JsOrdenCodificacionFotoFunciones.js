// JavaScript Document

function FncOrdenCodificacionFotoNuevo(){
}

function FncOrdenCodificacionFotoGuardar(){
	
}


function FncOrdenCodificacionFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapOrdenCodificacionFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenCodificacion/FrmOrdenCodificacionFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+OrdenCodificacionFotoEditar+'&Eliminar='+OrdenCodificacionFotoEliminar,
		success: function(html){
			$('#CapOrdenCodificacionFotosAccion').html('Listo');	
			$("#CapOrdenCodificacionFotos").html("");
			$("#CapOrdenCodificacionFotos").append(html);
		}
	});
	
	

}



function FncOrdenCodificacionFotoEscoger(oItem){
}

function FncOrdenCodificacionFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapOrdenCodificacionFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenCodificacion/acc/AccOrdenCodificacionFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapOrdenCodificacionFotosAccion').html("Eliminado");	
				FncOrdenCodificacionFotoListar();
			}
		});

		FncOrdenCodificacionFotoNuevo();

	}
	
}

function FncOrdenCodificacionFotoEliminarTodo(){

	
}
