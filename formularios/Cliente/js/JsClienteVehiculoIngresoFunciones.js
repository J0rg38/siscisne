// JavaScript Document

function FncClienteVehiculoIngresoNuevo(){

}

function FncClienteVehiculoIngresoGuardar(){
	
	
}


function FncClienteVehiculoIngresoListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapClienteVehiculoIngresoAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/Cliente/FrmClienteVehiculoIngresoListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+ClienteVehiculoIngresoEditar+
'&Eliminar='+ClienteVehiculoIngresoEliminar,
		success: function(html){
			$('#CapClienteVehiculoIngresoAccion').html('Listo');	
			$("#CapClienteVehiculoIngresos").html("");
			$("#CapClienteVehiculoIngresos").append(html);
		}
	});

}


function FncClienteVehiculoIngresoEscoger(oItem){


}



function FncClienteVehiculoIngresoEliminar(oItem){


	
}

function FncClienteVehiculoIngresoEliminarTodo(){

	
	
}



