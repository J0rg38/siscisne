// JavaScript Document

function FncReclamoFotoNuevo(){
	

}

function FncReclamoFotoGuardar(){

	
}


function FncReclamoFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapReclamoFotoAccion').html('Cargando...');
	
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Reclamo/FrmReclamoFotoListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso=&Editar='+ReclamoFotoEditar+'&Eliminar='+ReclamoFotoEliminar,
		success: function(html){
			$('#CapReclamoFotoAccion').html('Listo');	

			$("#CapReclamoFotos").html("");
			$("#CapReclamoFotos").append(html);
		}
	});
	
	


}



function FncReclamoFotoEscoger(oItem,oModalidadIngreso){
		
}

function FncReclamoFotoEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapReclamoFotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Reclamo/acc/AccReclamoFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapReclamoFotoAccion').html("Eliminado");	
				FncReclamoFotoListar(oModalidadIngreso);
			}
		});

		FncReclamoFotoNuevo();

	}
	
}



function FncReclamoFotoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapReclamoFotoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Reclamo/acc/AccReclamoFotoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapReclamoFotoAccion').html('Eliminado');	
				FncReclamoFotoListar();
			}
		});	
			
		FncReclamoFotoNuevo();
	}
	
}
