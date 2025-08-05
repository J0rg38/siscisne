// JavaScript Document

function FncFichaIngresoLlamadaNuevo(){
	
	$('#CmpFichaIngresoLlamadaId').val("");

	//$('#CmpFichaIngresoLlamadaNumero').val("");
	$('#CmpFichaIngresoLlamadaFecha').val(FechaHoy);

	$('#CmpFichaIngresoLlamadaObservacion').val("");
	$('#CmpFichaIngresoLlamadaItem').val("");	

	$('#CapFichaIngresoLlamadaAccion').html('Listo para registrar elementos');	
			
	$('#CmpFichaIngresoLlamadaNumero').select();
			
	$('#CmpFichaIngresoLlamadaAccion').val("AccFichaIngresoLlamadaRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncFichaIngresoLlamadaGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpFichaIngresoLlamadaAccion').val();		

	var FichaIngresoLlamadaId = $('#CmpFichaIngresoLlamadaId').val();
	//var FichaIngresoLlamadaNumero = $('#CmpFichaIngresoLlamadaNumero').val();			
	var FichaIngresoLlamadaFecha = $('#CmpFichaIngresoLlamadaFecha').val();
	var FichaIngresoLlamadaObservacion = $('#CmpFichaIngresoLlamadaObservacion').val();
	var FichaIngresoLlamadaValor = $('#CmpFichaIngresoLlamadaValor').val();
				
	var Item = $('#CmpFichaIngresoLlamadaItem').val();
	
	if(FichaIngresoLlamadaFecha==""){

		$('#CmpFichaIngresoLlamadaFecha').select();
		
	}else if(FichaIngresoLlamadaObservacion=="" || FichaIngresoLlamadaObservacion <=0){
		
		$('#CmpFichaIngresoLlamadaObservacion').select();	
		
	}else{
		
		$('#CapFichaIngresoLlamadaAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/FichaIngreso/acc/'+Acc,
			data: 'Identificador='+Identificador+'&FichaIngresoLlamadaId='+FichaIngresoLlamadaId+'&FichaIngresoLlamadaFecha='+FichaIngresoLlamadaFecha+'&FichaIngresoLlamadaObservacion='+FichaIngresoLlamadaObservacion+'&Item='+Item,
			success: function(){
				
			$('#CapFichaIngresoLlamadaAccion').html('Listo');							
				FncFichaIngresoLlamadaListar();
			}
		});
		
		FncFichaIngresoLlamadaNuevo();
	}
	
}

function FncFichaIngresoLlamadaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapFichaIngresoLlamadaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/CapFichaIngresoLlamadaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+FichaIngresoLlamadaEditar+'&Eliminar='+FichaIngresoLlamadaEliminar,
		success: function(html){
			$('#CapFichaIngresoLlamadaAccion').html('Listo');	
			$("#CapFichaIngresoLlamadas").html("");
			$("#CapFichaIngresoLlamadas").append(html);
		}
	});

}


function FncFichaIngresoLlamadaEscoger(oItem){

	var Identificador = $('#Identificador').val();

	$('#CapFichaIngresoLlamadaAccion').html('Editando...');
	$('#CmpFichaIngresoLlamadaAccion').val("AccFichaIngresoLlamadaEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FichaIngreso/acc/AccFichaIngresoLlamadaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsFichaIngresoLlamada){

		//SesionObjeto-InsFichaIngresoLlamada
		//Parametro1 = GopId
		//Parametro2 = 
		//Parametro3 = GopFecha
		//Parametro4 = 
		//Parametro5 = GopObservacion
		//Parametro6 = GopEstado
		//Parametro7 = GopFechaCreacion
		//Parametro8 = GopFechaModificacion

			$('#CmpFichaIngresoLlamadaFecha').val(InsFichaIngresoLlamada.Parametro3);
			$('#CmpFichaIngresoLlamadaObservacion').val(InsFichaIngresoLlamada.Parametro5);

			$('#CmpFichaIngresoLlamadaItem').val(InsFichaIngresoLlamada.Item);

			$('#CmpFichaIngresoLlamadaFecha').select();

		}
	});
	
	

	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncFichaIngresoLlamadaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFichaIngresoLlamadaAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaIngreso/acc/AccFichaIngresoLlamadaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapFichaIngresoLlamadaAccion').html("Eliminado");	
				FncFichaIngresoLlamadaListar();
			}
		});

		FncFichaIngresoLlamadaNuevo();

	}
	
}

function FncFichaIngresoLlamadaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapFichaIngresoLlamadaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaIngreso/acc/AccFichaIngresoLlamadaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFichaIngresoLlamadaAccion').html('Eliminado');	
				FncFichaIngresoLlamadaListar();
			}
		});	
			
		FncFichaIngresoLlamadaNuevo();
	}
	
}





