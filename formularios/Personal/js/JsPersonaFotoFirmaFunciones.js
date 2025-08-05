// JavaScript Document

function FncPersonalFotoFirmaNuevo(){
}

function FncPersonalFotoFirmaGuardar(){
	
}


function FncPersonalFotoFirmaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapPersonalFotoFirmasAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Personal/FrmPersonalFotoFirmaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+PersonalFotoFirmaEditar+'&Eliminar='+PersonalFotoFirmaEliminar,
		success: function(html){
			$('#CapPersonalFotoFirmasAccion').html('Listo');	
			$("#CapPersonalFotoFirmas").html("");
			$("#CapPersonalFotoFirmas").append(html);
		}
	});
	
	

}



function FncPersonalFotoFirmaEscoger(oItem){
}

function FncPersonalFotoFirmaEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapPersonalFotoFirmasAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Personal/acc/AccPersonalFotoFirmaEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapPersonalFotoFirmasAccion').html("Eliminado");	
				FncPersonalFotoFirmaListar();
			}
		});

		FncPersonalFotoFirmaNuevo();

	}
	
}

function FncPersonalFotoFirmaEliminarTodo(){

	
}
