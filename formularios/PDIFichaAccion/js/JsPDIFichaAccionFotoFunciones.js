// JavaScript Document

function FncFichaAccionFotoNuevo(oModalidadIngreso){
	

}

function FncFichaAccionFotoGuardar(oModalidadIngreso){

	
}


function FncFichaAccionFotoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'FotoAccion').html('Cargando...');
	var ModalidadIngresoId = $('#CmpModalidadIngresoId_'+oModalidadIngreso).val();
	
	
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PDIFichaAccion/FrmPDIFichaAccionFotoListado.php',
		data: 'ModalidadIngresoId='+ModalidadIngresoId+'&Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaAccionFotoEditar+'&Eliminar='+FichaAccionFotoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'FotoAccion').html('Listo');	
//			alert("#CapFichaAccion"+oModalidadIngreso+"Fotos");
			
			$("#CapFichaAccion"+oModalidadIngreso+"Fotos").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Fotos").append(html);
		}
	});
	
	


}



function FncFichaAccionFotoEscoger(oItem,oModalidadIngreso){
		
	
	
	
}

function FncFichaAccionFotoEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'FotoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionFotoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'FotoAccion').html("Eliminado");	
				FncFichaAccionFotoListar(oModalidadIngreso);
			}
		});

		FncFichaAccionFotoNuevo(oModalidadIngreso);

	}
	
}



function FncFichaAccionFotoEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'FotoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionFotoEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'FotoAccion').html('Eliminado');	
				FncFichaAccionFotoListar(oModalidadIngreso);
			}
		});	
			
		FncFichaAccionFotoNuevo(oModalidadIngreso);
	}
	
}
