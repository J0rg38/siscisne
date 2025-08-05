// JavaScript Document

function FncTrasladoAlmacenEntradaRecepcionNuevo(){
	
}

function FncTrasladoAlmacenEntradaRecepcionGuardar(){

	
}


function FncTrasladoAlmacenEntradaRecepcionListar(){

	var Identificador = $('#Identificador').val();

	$('#CapTrasladoAlmacenEntradaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrasladoAlmacenEntrada/FrmTrasladoAlmacenEntradaRecepcionListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+TrasladoAlmacenEntradaRecepcionEditar+
		'&Eliminar='+TrasladoAlmacenEntradaRecepcionEliminar,
		
		success: function(html){

			$('#CapTrasladoAlmacenEntradaAccion').html('Listo');	
			$("#CapTrasladoAlmacenEntradaRecepcions").html("");
			$("#CapTrasladoAlmacenEntradaRecepcions").append(html);

		}
	});
	
}



function FncTrasladoAlmacenEntradaRecepcionEscoger(oItem){
		

		
}





function FncTrasladoAlmacenEntradaRecepcionEliminar(oItem){


}



function FncTrasladoAlmacenEntradaRecepcionEliminarTodo(){


	
}




